<?php

namespace tencotools\Events;

use tencotools\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use tencotools\Task;

class TaskDone extends Event
{
    use SerializesModels;


    public $task_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($task_id)
    {
        $this->task_id = $task_id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
