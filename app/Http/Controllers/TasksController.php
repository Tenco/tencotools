<?php

namespace tencotools\Http\Controllers;

use Illuminate\Http\Request;

use tencotools\Project;
use tencotools\Task;
use Session;
use Auth;


class TasksController extends Controller
{
    

    /*
    *
    * 
    *
    */
    public function __construct() 
    {
        $this->middleware('auth');
    }


    /*
    *
    * 
    *
    */
    public function store(Request $request, Project $project) //project returnerar rätt projekt via wildcard i URL
    {

        $this->validate($request, [
            'taskName' => 'required',
            'taskResponsible' => 'required'
            ]);

    	$project->tasks()->create([
    		'name' => request()->taskName, /* kan även använda typehintade $request objeketet $request->taskName */
    		'desc' => request()->taskDesc,
    		'created_by' => Auth::id(),
    		'responsible' => request()->taskResponsible,
    		'prio' => 1,
    		'stage' => 'backlog'
    	]);

    	return back();

    }

    /*
    *
    * 
    *
    */
	public function edit(Task $task)
	{

		return view('tasks.edit', compact('task'));

	}

    /*
    *
    * 
    *
    */
    public function remove($task_id)
    {


        Task::destroy($task_id);

        Session::flash('flash_message', 'Task deleted.');
        return back();

    }

    /*
    *
    * 
    *
    */
    public function updateStage(Request $request)
    {
        #dd($request()->taskid);
        Task::where('id', $request->taskid)
                    ->update(['stage' => $request->target]);
        return;
    }

    /*
    *
    * 
    *
    */
    public function update(Request $request, Task $task)
    {
        #return $request->all();
        $task->update([
            'name' => $request->taskName,
            'responsible' => $request->taskResponsible,
            'desc' => $request->taskDesc
            ]);

         Session::flash('flash_message', 'Task updated.');
        return back();

    }
}
