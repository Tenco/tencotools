<?php

namespace tencotools\Console\Commands;

use Illuminate\Console\Command;

use tencotools\Project;
use tencotools\User;
use tencotools\Task;
use Carbon\Carbon;
use Mail;
use Log;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tencotools:weekly-task-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly email to all users with their tasks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        // POC
        /*
        $user = User::find(1);
        $to = $user->email;
        $subject = 'POC';
        $data = [
                'to'=>$to, 
                'olle'=>'Bulle'
                ];
        
        Mail::queue(['html' => 'emails.weeklyTask'], $data, function ($message) use ($to, $subject)
        {
                
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->subject($subject);
            $message->to($to);

        });

        return;
        */
        
        $stages = [
                'backlog',
                'backlog_2',
                'backlog_3',
                'ongoing',
                'ongoing_2',
                'ongoing_3',
            ];

        // get all users
        $users = User::with(['tasks' => function ($query) use ($stages) {
                $query->whereIn('tasks.stage',$stages);
                $query->where('tasks.deadline', '>', Carbon::now());
                $query->where('tasks.deadline', '<', Carbon::now()->addWeek());
            }])->get();
        

        foreach ($users as $user)
        {

            $to = $user->email;
            $subject = 'Upcoming deadlines';
            $links = [];

            // loop tasks for each user with deadline the following 7 days
            if (count($user->tasks) > 0)
            {

                foreach ($user->tasks as $task)
                {
                                        
                    $links = [
                            $task->name => url('/').'/project/'.$task->project_id.'#TaskModal'.$task->id
                        ];
                }

            }
            $data = [
                'tasks' => $links,
                'namn' => $user->name,
            ];

            // fire off the email
            Mail::queue(['html' => 'emails.weeklyTask'], $data, function ($message) use ($to, $subject)
            {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->subject($subject);
                $message->to($to);
            });
            
        }
        
        
        
        
    }
}
