<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The guest instance.
     *
     * @var \App\Models\Guest
     */
    public $guest;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Guest $guest
     * @return void
     */

    public function __construct($guest)
    {
        $this->guest = $guest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reminder_mail')
            ->from('celproject@example.com')
            ->text('emails.reminder_mail');
    }
}
