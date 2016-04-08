<?php

namespace tencotools\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use tencotools\Http\Requests;

use tencotools\Project;

use tencotools\User;
use Auth;
use Storage;



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
	public function home()
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

    	$p = $project->create([
    		'name' => request()->name, /* kan även använda typehintade $request objeketet $request->taskName */
    		'desc' => request()->desc,
    		'created_by' => Auth::id(),
    		'project_owner' => request()->project_owner,
    		'value' => request()->value,
    		'cost' => request()->cost,
    		'deadline' => request()->deadline
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
		$uploadedfile->move('img/uprojectuploads/', $new_file_name);
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
		$project->load('user');
		$allusers = User::all();

		return view('project', compact('project', 'allusers'));
	}

	/*
	*
	* 
	*
	*/
	public function update(Request $request, Project $project)
	{
		#return $request->all();
		$project->update([
			'name' => $request->taskName,
			'desc' => $request->taskDesc
			]);
		return back();

	}


}
