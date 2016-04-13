<?php

namespace tencotools\Listeners;

use tencotools\Events\TaskDone;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use tencotools\Task;

class EmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TaskDone  $event
     * @return void
     */
    public function notifyBlockedUser($task)
    {

        
        #dd(gettype($task));
        #dd($task->task_id);
        
        // select users who's tasks was blocked by this task
        $effected_users = Task::select('responsible')
            ->where('blockedby', $task->task_id)
            ->groupBy('responsible')
            ->get();
        

        // send email
        #foreach ($effected_users as $user)
        #{
         #   echo $user->responsible.', ';
        #}
        #exit;
    }
}
