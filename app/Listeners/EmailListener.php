<?php

namespace tencotools\Listeners;

use tencotools\Events\TaskDone;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
    public function notifyBlockedUser(TaskDone $task)
    {
        

        print_r($task);
    }
}
