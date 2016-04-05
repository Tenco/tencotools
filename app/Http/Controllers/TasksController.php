<?php

namespace tencotools\Http\Controllers;

use Illuminate\Http\Request;

use tencotools\Project;
use tencotools\Task;


class TasksController extends Controller
{
    

    public function __construct() 
    {
        $this->middleware('auth');
    }



    public function store(Request $request, Project $project) //project returnerar rätt projekt via wildcard i URL
    {

        $this->validate($request, [
            'taskName' => 'required',
            'taskDesc' => 'required'
            ]);

    	$project->tasks()->create([
    		'name' => request()->taskName, /* kan även använda typehintade $request objeketet $request->taskName */
    		'desc' => request()->taskDesc,
    		'created_by' => 1,
    		'responsible' => 1,
    		'prio' => 1,
    		'stage' => 'backlog'
    	]);

    	return back();

    }


	public function edit(Task $task)
	{

		return view('tasks.edit', compact('task'));

	}

    public function updateStage(Request $request)
    {
        #dd($request()->taskid);
        Task::where('id', $request->taskid)
                    ->update(['stage' => $request->target]);
        return;
    }


}
