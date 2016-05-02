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

        #dd(request()->taskDeadline);

        $this->validate($request, [
            'taskName' => 'required',
            'taskResponsible' => 'required',
            'taskDeadline' => 'required|date|after:today',
            ]);

        #$deadline = (strlen(request()->taskDeadline) ? request()->taskDeadline : NULL);

    	$task = $project->tasks()->create([
    		'name' => request()->taskName, /* kan även använda typehintade $request objeketet $request->taskName */
    		'desc' => request()->taskDesc,
    		'created_by' => Auth::id(),
    		'responsible' => request()->taskResponsible,
    		'prio' => 1,
    		'stage' => request()->taskPhase,
            'deadline' => request()->taskDeadline
    	]);

        

        // notify responsible?        
        if (Auth::id() != request()->taskResponsible)
        {
            $user = User::where('id', request()->taskResponsible)->first();
            $to = $user->email;
            $project_id = $project->id;
            $task_id = $task->id;
            $subject = Auth::user()->name.' assigned you a task';
            $template = 'emails.newTask';
            $data = array(
                    'to'=>$to, 
                    'project_id'=>$project_id, 
                    'task_id'=>$task_id,
                    'task_name' => \Helpers\TaskIdToName($task_id),
                    'project_name' => \Helpers\ProjectIdToName($project_id)
                    );

            $this->notify($to, $data, $project_id, $task_id, $subject, $template);

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
        $blocked_tasks = Task::where('blockedby', $task_id)->get();

        if (count($blocked_tasks))
        {
            $blocked_tasks->load('user');

            // notify blocked users:
            $subject = 'Your task is no longer blocked';
            $template = 'emails.unblockedTask';
                    
            foreach ($blocked_tasks as $blocked) 
            {
                // do not send to yourself!
                if ($blocked->user->id != Auth::id())
                {
                    $project_id = $blocked->project_id;
                    $data = array('to'=>$blocked->user->email, 'project_id'=>$project_id, 'task_id'=>$blocked->id);
                    $this->notify($blocked->user->email, $data, $project_id, $blocked->id, $subject, $template);
                }

            }
        }

        
        // delete the task in DB
        Task::destroy($task_id);

        // when deleted also remove this task_id from blockedby column
        Task::where('blockedby', $task_id)
                    ->update(['blockedby' => NULL]);

        // when deleted also set blockedby column to NULL
        Task::where('id', $task_id)
                    ->update(['blockedby' => NULL]);


        Session::flash('flash_message', 'Task deleted. <a href="/task/'.$task_id.'/undo">Undo.</a>');
        return back();

    }


    /*
    *
    *  revive a deleted task
    *
    */
    public function restore($task)
    {

        Task::withTrashed()
            ->where('id', $task)
            ->restore();

        
        Session::flash('flash_message', 'Task revived.');
        
        return back();
    }

    /*
    *
    * 
    *
    */
    public function updateStage(Request $request)
    {
        
        // update the status for the task
        Task::where('id', $request->taskid)
                ->update(['stage' => $request->target]);

        // get all task
        $task = Task::find($request->taskid);

        // now check if we should send notifications
        if ($request->target == 'done')
        {
            
            $blocked_tasks = Task::where('blockedby', $request->taskid)->get();

            // are ther any bliocked tasks
            if (count($blocked_tasks))
            {
                // eager load the corresponding user records
                $blocked_tasks->load('user');

                // notify blocked users:
                $subject = 'Your task is no longer blocked';
                $template = 'emails.unblockedTask';
                        
                foreach ($blocked_tasks as $blocked) 
                {
                    // do not send to yourself!
                    if ($blocked->user->id != Auth::id())
                    {
                        $project_id = $blocked->project_id;
                        $data = array('to'=>$blocked->user->email, 'project_id'=>$project_id, 'task_id'=>$blocked->id);
                        $this->notify($blocked->user->email, $data, $project_id, $blocked->id, $subject, $template);
                    }

                }
            }

        }


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
            'taskResponsible' => 'required',
            'taskDeadline' => 'required|date|after:today',
            ]);
        
        $blockedby = (request()->blockedby ? request()->blockedby : NULL);
        #$deadline = (strlen(request()->taskDeadline) ? request()->taskDeadline : NULL);

        // should this update generate a notification??
        if ($task->responsible != $request->taskResponsible 
            && Auth::id() != $request->taskResponsible)
        {
            $user = User::where('id', request()->taskResponsible)->first();
            $to = $user->email;
            $project_id = $task->project_id;
            $task_id = $task->id;
            $subject = 'You have been assigned a task';
            $template = 'emails.newTask';
            $data = array('to'=>$to, 'project_id'=>$project_id, 'task_id'=>$task_id);

            $this->notify($to, $data, $project_id, $task_id, $subject, $template);
        }

        $task->update([
            'name' => $request->taskName,
            'responsible' => $request->taskResponsible,
            'desc' => $request->taskDesc, 
            'deadline' => $request->taskDeadline,
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

       $loggedin = Auth::id();
        // add a whole bunch of tasks to this project
        $boilerplate = [        
            0 => [
                'name' => 'Mission statement',
                'desc' => 'Agree on the vision for the project together with the customer',
                'created_by' => $loggedin,
                'responsible' => $loggedin,
                'prio' => 1,
                'stage' => 'ongoing',
                'project_id' => $project
            ],
            1 => [
                'name' => 'Stakeholder map',
                'desc' => 'Create stakeholder map containing at least data about owner, customer and user.',
                'created_by' => $loggedin,
                'responsible' => $loggedin,
                'prio' => 1,
                'stage' => 'backlog',
                'project_id' => $project
            ],
            2 => [
                'name' => 'Context diagram',
                'desc' => 'Sketch out the context and map relations between objects.',
                'created_by' => $loggedin,
                'responsible' => $loggedin,
                'prio' => 1,
                'stage' => 'backlog',
                'project_id' => $project
            ],
            3 => [
                'name' => 'Value Propesition Canvas',
                'desc' => 'Create a VPC based on what jobs key stakeholders are facing.',
                'created_by' => $loggedin,
                'responsible' => $loggedin,
                'prio' => 1,
                'stage' => 'backlog',
                'project_id' => $project
            ],
            4 => [
                'name' => 'Create Personas',
                'desc' => 'Create personas based on research and interviews.',
                'created_by' => $loggedin,
                'responsible' => $loggedin,
                'prio' => 1,
                'stage' => 'backlog',
                'project_id' => $project
            ],
            5 => [
                'name' => 'Customer journey',
                'desc' => 'Create a customer journey to get a holistic view from the customer perspective and identify pain-points',
                'created_by' => $loggedin,
                'responsible' => $loggedin,
                'prio' => 1,
                'stage' => 'backlog',
                'project_id' => $project
            ],
            6 => [
                'name' => 'Sketch Scenarios',
                'desc' => 'Illustrate the suggested solutions',
                'created_by' => $loggedin,
                'responsible' => $loggedin,
                'prio' => 1,
                'stage' => 'backlog_2',
                'project_id' => $project
            ],
            7 => [
                'name' => 'Value Prototype',
                'desc' => 'Create testcards and test methods to try out the hypothesis created from VPC',
                'created_by' => $loggedin,
                'responsible' => $loggedin,
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


    /*
    *
    * 
    *
    */
    public function notify($to, $data, $project_id, $task_id, $subject, $template)
    {
        
        Mail::queue(['html' => $template], $data, function ($message) use ($to, $project_id, $task_id, $subject)
        {
                
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->subject($subject);
            $message->to($to);
        });

        return;
    }
}
