<?php

namespace tencotools\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use tencotools\Http\Requests;

use tencotools\Project;

use tencotools\User;
use tencotools\ProjectFile;
use tencotools\ProjectTime;

use Auth;
use Storage;
use Session;
use Carbon\Carbon;


class ProjectsController extends Controller
{

	public function __construct() 
	{
  		$this->middleware('auth');
	}
    
	/*
	*
	* get all projects
	* return view
	*/
	public function home(Carbon $carbon)
	{

		
		// eager load tasks for all projects
		#$projects = Project::with('tasks')->get();
		#$projects = Project::whereNotNull('close_date')->with('tasks')->get();
		
		
		$matchThese = [	'ongoing',
						'ongoing_2',
						'ongoing_3',
						'backlog',
						'backlog_2',
						'backlog_3',
						];
		$projects = Project::with(['tasks' => function ($query) use ($matchThese) {
	    		$query->whereIn('stage',$matchThese);
	    		$query->Where('responsible', Auth::id());	
			}])->get();
		
		#whereNotNull('projects.close_date')
		$now = Carbon::now();

		return view('home', compact('projects', 'now'));
	}


	/*
	*
	* get all projects
	* return view
	*/
	public function uploadImage($project)
	{

		$project = Project::where('id', $project)->first();
		

		return view('projects.createProject2', compact('project'));

	}

	/*
	*
	* show create new proejct form
	*
	*/
	public function create()
	{
		$users = User::all();
		return view('projects.createProject', compact('users'));
	}

	/*
	*
	* Save a new pjoject
	*
	*/
	public function store(Request $request, Project $project)
	{
		#dd($request);

		$this->validate($request, [
            'name' => 'required',
            'desc' => 'required',
            'project_owner' => 'required',
            //'invision' => 'URL'
            ]);

		$deadline = (strlen(request()->deadline) ? request()->deadline : NULL);

    	$p = $project->create([
    		'name' => request()->name, /* kan även använda typehintade $request objeketet $request->taskName */
    		'desc' => request()->desc,
    		'created_by' => Auth::id(),
    		'project_owner' => request()->project_owner,
    		'value' => request()->value,
    		'cost' => request()->cost,
    		'deadline' => $deadline,
    		'slack' => request()->slack,
    		'invision' => request()->invision
    		
    	]);

    	return redirect('/project/image/'. $p->id);

	}

	/*
	*
	* Store project image locally
	*
	*/
	public function storeImage(Request $request, Project $project)
	{
		// VALIDATION 
		if( ! $request->hasFile('file'))
			return response()->json(['error' => 'No File Sent']);

		$this->validate($request, [
				'file' => 'required|mimes:jpeg,jpg,png',
			]);

		$uploadedfile = $request->file('file');
		$new_file_name = time() . $uploadedfile->getClientOriginalName();
		$uploadedfile->move('img/projectuploads/', $new_file_name);

		$project->update([
			'img' => $new_file_name,
			]);

		return response()->json(['success' => 'ok']);
	}

	
	/*
	*
	* display a single project and it's tasks
	* 
	*/
	public function show(Project $project)
	{
		// nedan behövs ej pga Route/modal-binding ..alltså hela project objektet laddas 
		// genom att type hinta ovan baserat på det wildcard som skickas in till funktionen.
		#$project = Project::find($project_id);
		

		// eagerload the project owner data
		$project->load('user.ProjectFile'); // EAGER LOAD ALSO FILES!! avoid N+1 problem!

		#$allusers = User::withTrashed()->get(); // load all data in user table
		$allusers = User::all(); // load all data in user table

		#dd($allusers);

		$path = '/project#'.$project->id.'/';
		

		#return view('project', compact('project', 'allusers'));
		return view('projects.tableproject', compact('project', 'allusers'));

	}


	public function download($file)
	{
		
		$file = base64_decode($file);

		if ( ! Storage::disk('cloud')->exists($file))
		{
			dd('file: '.$file.' does not seem to exist?');
		}

		$mime = Storage::disk('cloud')->mimeType($file);
		$contents = Storage::disk('cloud')->get($file);
		
        $headers = array(
              'Content-Type: '.$mime,
            );

        #ob_end_clean();
        
        return response($contents)
        	  ->header('Content-Type', $mime);
        
	}


	/*
	*
	* 
	*
	*/
	public function edit(Request $request, Project $project)
	{
		// eagerload the project owner data
		$project->load('user'); // load user-data for this project
		$allusers = User::all(); // load all data in user table


		return view('projects.editProject', compact('project', 'allusers'));

	}

	/*
	*
	* 
	*
	*/
	public function update(Request $request, $id)
	{

		#dd($request);

		// validation:
		$this->validate($request, [
				'name' => 'required',
				'desc' => 'required',
				'project_owner' => 'required|numeric',
				//'invision' => 'URL'
			]);
		
		$deadline = (strlen(request()->deadline) ? request()->deadline : NULL);

		Project::where('id', $id)
          ->update([
          		'name' => request()->name,
				'desc' => request()->desc,
    			'project_owner' => request()->project_owner,
    			'value' => request()->value,
    			'cost' => request()->cost,
    			'deadline' => $deadline,
    			'slack' => request()->slack,
    			'invision' => request()->invision
          		]);

		Session::flash('flash_message', 'Project updated.');

		$url = '/project/'.$id.'/edit';

		return redirect($url);

	}

	/*
	*
	* 
	*
	*/
	public function revive($id)
	{

		#dd($id);

		Project::where('id', $id)
          ->update(['close_date' => NULL]);
		
		Session::flash('flash_message', 'Project revived.');

		$url = '/project/'.$id;

		return redirect($url);

	}

	/*
	*
	* 
	*
	*/
	public function archive($id)
	{

		$now = date("Y-m-d H:i:s");

		Project::where('id', $id)
          ->update(['close_date' => $now]);
		
		Session::flash('flash_message', 'Project has been archived.');


		return redirect('/');

	}

	/*
	*
	* 
	*
	*/
	public function files($project)
	{

		$files = ProjectFile::where('project_id', $project)->get();
		#dd($files);

		return view('projects.projectFiles', compact('files'));

	}
}
