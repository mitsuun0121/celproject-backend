<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ReservationMail extends Mailable implements ShouldQueue
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
        return $this->view('emails.reservation_mail')
            ->from('celproject@example.com')
            ->text('emails.reservation_mail')
            ->with([
                'guestEmail' => $this->guest->email,
                'guestName' => $this->guest->name,
                'date' => Carbon::parse($this->guest->date)->format('Y年m月d日'),
                'timeSlot' => Carbon::parse($this->guest->timeSlot)->format('H時'),
            ]);
    }
}
