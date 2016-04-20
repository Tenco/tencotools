<?php

namespace tencotools\Http\Controllers;

use Illuminate\Http\Request;

use tencotools\Project;
use tencotools\Task;
use Session;
use Auth;
use Mail;
use tencotools\User;

//use Event;
//use tencotools\Events\TaskDone;



class TasksController extends Controller
{
    

    /*
    *
    * 
    *
    */
    public function __construct() 
    {
        // user needs to be logged in for all of these functions/routes
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

        $deadline = (strlen(request()->taskDeadline) ? request()->taskDeadline : NULL);

    	$task = $project->tasks()->create([
    		'name' => request()->taskName, /* kan även använda typehintade $request objeketet $request->taskName */
    		'desc' => request()->taskDesc,
    		'created_by' => Auth::id(),
    		'responsible' => request()->taskResponsible,
    		'prio' => 1,
    		'stage' => 'backlog',
            'deadline' => $deadline
    	]);

        
        // notify responsible?
        if (Auth::id() != request()->taskResponsible)
        {
            
            $user = User::where('id', request()->taskResponsible)->first();
            $mottagare = $user->email;
            $project_id = $project->id;
            $task_id = $task->id;

            $data = array('to'=>$mottagare, 'project_id'=>$project_id, 'task_id'=>$task_id);
            
            Mail::queue(['html' => 'emails.newTask'], $data, function ($message) use ($mottagare, $project_id, $task_id)
            {
                
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->subject('New TencoTool task');
                $message->to($mottagare);


            });
        }
        
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

        // notify blocked task owners about this
        // task being deleted
        //Event::fire(new TaskDone($task_id));


        Task::destroy($task_id);

        // when deleted also remove this task_id from blockedby column
        Task::where('blockedby', $task_id)
                    ->update(['blockedby' => NULL]);

        // when deleted also set blockedby column to NULL
        Task::where('id', $task_id)
                    ->update(['blockedby' => NULL]);

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
        
        if ($request->target == 'done')
        {
            
            /*
            Events:
            Event and Event listner registred in app\Providers\EventServiceProvider.php
            TaskDone.php recieves task_id and fires off notifyBlockedUser function in 
            app\Listners\EmailListner.php. This function figures out who should get 
            notifications about this task getting done and sends emails.
            */
            // fire event!!
            //Event::fire(new TaskDone($request->taskid));
        }


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

        $this->validate($request, [
            'taskName' => 'required',
            'taskResponsible' => 'required'
            ]);
        
        $blockedby = (request()->blockedby ? request()->blockedby : NULL);
        $deadline = (strlen(request()->taskDeadline) ? request()->taskDeadline : NULL);

        $task->update([
            'name' => $request->taskName,
            'responsible' => $request->taskResponsible,
            'desc' => $request->taskDesc, 
            'deadline' => $deadline,
            'blockedby' => $blockedby,
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

    /*
    *
    * 
    *
    */
    public function removeblock($project, $task)
    {
        Task::where('id', $task)
          ->update([
                'blockedby' => NULL,
                ]);
        
        $url = '/project/'. $project .'#TaskModal'.$task;
        return redirect($url);
    }

    /*
    *
    * 
    *
    */
    public function removedeadline($project, $task)
    {
        Task::where('id', $task)
          ->update([
                'deadline' => 'NULL',
                ]);
        
        $url = '/project/'. $project .'#TaskModal'.$task;
        return redirect($url);
    }    


}
