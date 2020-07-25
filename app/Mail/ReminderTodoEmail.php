<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderTodoEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $todo;

    /**
     * Create a new message instance.
     *
     * @param $todo
     */
    public function __construct($todo)
    {
        $this->todo = $todo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.reminder-todo')
            ->with('todo', $this->todo);
    }
}
