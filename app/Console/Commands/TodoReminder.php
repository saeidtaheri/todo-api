<?php

namespace App\Console\Commands;

use App\Mail\ReminderTodoEmail;
use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TodoReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todo:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder for Todo';

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
     * @return int
     */
    public function handle()
    {
        $remindertodo = Todo::where('reminder',  Carbon::now()->addMinutes(30))->get();

        foreach ($remindertodo as $todo)
        {
            $this->SendReminderEmail($todo, $todo->project->user->email);
        }
    }

    private function SendReminderEmail($todo, $email)
    {
       Mail::to($email)->send(new ReminderTodoEmail($todo));
    }
}
