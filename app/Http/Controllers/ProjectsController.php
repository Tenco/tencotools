<?php

namespace tencotools\Http\Controllers;

use Illuminate\Http\Request;

use tencotools\Http\Requests;

use tencotools\Project;

use tencotools\User;
use Auth;


class ProjectsController extends Controller
{

	public function __construct() 
	{
  		$this->middleware('auth');
	}
    

	public function home()
	{
		$projects = Project::all();

		return view('home', compact('projects'));
	}


	public function create()
	{
		$users = User::all();
		return view('createProject', compact('users'));
	}


	public function store(Request $request, Project $project)
	{
		$this->validate($request, [
            'name' => 'required',
            'desc' => 'required',
            'project_owner' => 'required'
            ]);

    	$project->create([
    		'name' => request()->name, /* kan även använda typehintade $request objeketet $request->taskName */
    		'desc' => request()->desc,
    		'created_by' => Auth::id(),
    		'project_owner' => request()->project_owner,
    		'value' => request()->value,
    		'cost' => request()->cost,
    		'deadline' => request()->deadline
    	]);

    	return redirect('/');

	}


	public function show(Project $project)
	{
		// nedan behövs ej pga Route/modal-binding ..alltså hela project objektet laddas 
		// genom att type hinta ovan baserat på det wildcard som skickas in till funktionen.
		#$project = Project::find($project_id);

		// eagerload the project owner data
		$project->load('user');

		return view('project', compact('project'));
	}


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
