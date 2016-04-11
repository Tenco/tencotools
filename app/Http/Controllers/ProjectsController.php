<?php

namespace tencotools\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use tencotools\Http\Requests;

use tencotools\Project;

use tencotools\User;
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

		$projects = Project::all();


		return view('home', compact('projects'));
	}

	/*
	*
	* show create new proejct form
	*
	*/
	public function create()
	{
		$users = User::all();
		return view('createProject', compact('users'));
	}

	/*
	*
	* Save a new pjoject
	*
	*/
	public function store(Request $request, Project $project)
	{
		$this->validate($request, [
            'name' => 'required',
            //'desc' => 'required',
            'project_owner' => 'required'
            ]);

		$deadline = (request()->deadline ? request()->deadline : NULL);

    	$p = $project->create([
    		'name' => request()->name, /* kan även använda typehintade $request objeketet $request->taskName */
    		'desc' => request()->desc,
    		'created_by' => Auth::id(),
    		'project_owner' => request()->project_owner,
    		'value' => request()->value,
    		'cost' => request()->cost,
    		'deadline' => $deadline
    	]);

    	return redirect('/project/'. $p->id);

	}

	/*
	*
	* Store project image on Cloud server
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
		//Storage::disk('dropbox')->put('/project#'.$project->id.'/'.$new_file_name, file_get_contents($uploadedfile));


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
		
		
		/*
		$folder_and_file = 'project'. $project->id .'/'.$project->img;
		$url = Storage::disk('dropbox')->url($folder_and_file);
		dd($url);

		if (Storage::disk('dropbox')->has($folder_and_file))
		{
			$contents = Storage::disk('dropbox')->get($folder_and_file);
		}

		return $response->stream(function() use($contents) {
  			echo $contents;
		}, 200, $headers);
		*/

		// eagerload the project owner data
		$project->load('user'); // load user-data for this project
		$allusers = User::all(); // load all data in user table


		return view('project', compact('project', 'allusers'));
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


		return view('editProject', compact('project', 'allusers'));

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
				'project_owner' => 'required|numeric'
			]);
		
		$deadline = (request()->deadline ? request()->deadline : NULL);
		
		Project::where('id', $id)
          ->update([
          		'name' => request()->name,
				'desc' => request()->desc,
    			'project_owner' => request()->project_owner,
    			'value' => request()->value,
    			'cost' => request()->cost,
    			'deadline' => $deadline
          		]);

		Session::flash('flash_message', 'Project updated.');

		$url = '/project/'.$id;

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

}
