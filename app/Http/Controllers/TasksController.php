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

        $deadline = (request()->taskDeadline ? request()->taskDeadline : NULL);

    	$project->tasks()->create([
    		'name' => request()->taskName, /* kan även använda typehintade $request objeketet $request->taskName */
    		'desc' => request()->taskDesc,
    		'created_by' => Auth::id(),
    		'responsible' => request()->taskResponsible,
    		'prio' => 1,
    		'stage' => 'backlog',
            'deadline' => $deadline
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
            'desc' => $request->taskDesc, 
            'deadline' => $request->taskDeadline,
            'blockedby' => request()->blockedby,
            ]);

        Session::flash('flash_message', 'Task updated.');
        return back();

    }

    /*
    *
    * 
    *
    */
    public function kickstart($project)
    {
       
       if ( ! is_numeric($project))
       {
            Session::flash('flash_message', 'Error..');
            return back();
       }
        // add a whole bunch of tasks to this project
        $boilerplate = [        
            0 => [
                'name' => 'Mission statement',
                'desc' => 'Agree on the vision for the project together with the customer',
                'created_by' => Auth::id(),
                'responsible' => Auth::id(),
                'prio' => 1,
                'stage' => 'ongoing',
                'project_id' => $project
            ],
            1 => [
                'name' => 'Stakeholder map',
                'desc' => 'Create stakeholder map containing at least data about owner, customer and user.',
                'created_by' => Auth::id(),
                'responsible' => Auth::id(),
                'prio' => 1,
                'stage' => 'backlog',
                'project_id' => $project
            ],
            2 => [
                'name' => 'Context diagram',
                'desc' => 'Sketch out the context and map relations between objects.',
                'created_by' => Auth::id(),
                'responsible' => Auth::id(),
                'prio' => 1,
                'stage' => 'backlog',
                'project_id' => $project
            ],
            3 => [
                'name' => 'Value Propesition Canvas',
                'desc' => 'Create a VPC based on what jobs key stakeholders are facing.',
                'created_by' => Auth::id(),
                'responsible' => Auth::id(),
                'prio' => 1,
                'stage' => 'backlog',
                'project_id' => $project
            ],
            4 => [
                'name' => 'Create Personas',
                'desc' => 'Create personas based on research and interviews.',
                'created_by' => Auth::id(),
                'responsible' => Auth::id(),
                'prio' => 1,
                'stage' => 'backlog',
                'project_id' => $project
            ],
            5 => [
                'name' => 'Customer journey',
                'desc' => 'Create a customer journey to get a holistic view from the customer perspective and identify pain-points',
                'created_by' => Auth::id(),
                'responsible' => Auth::id(),
                'prio' => 1,
                'stage' => 'backlog',
                'project_id' => $project
            ],
            6 => [
                'name' => 'Sketch Scenarios',
                'desc' => 'Illustrate the suggested solutions',
                'created_by' => Auth::id(),
                'responsible' => Auth::id(),
                'prio' => 1,
                'stage' => 'backlog',
                'project_id' => $project
            ],
            7 => [
                'name' => 'Value Prototype',
                'desc' => 'Create testcards and test methods to try out the hypothesis created from VPC',
                'created_by' => Auth::id(),
                'responsible' => Auth::id(),
                'prio' => 1,
                'stage' => 'backlog',
                'project_id' => $project
            ],
        ];

        
        foreach ($boilerplate as $task)
        {
            Task::create($task);    
        }

        
        // redirect back
        Session::flash('flash_message', 'Kaboom...');
        return back();

    }

    private function saveTask (Array $task)
    {
        return;
    }

}
