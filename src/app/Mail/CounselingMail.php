<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class CounselingMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The guest instance.
     *
     * @var string
     * @var \App\Models\Guest
     */
    public $userName;
    public $guest;

    /**
     * Create a new message instance.
     *
     * @param string $userName
     * @param \App\Models\Guest $guest
     * @return void
     */

    
    public function __construct($userName, $guest)
    {
        $this->userName = $userName;
        $this->guest = $guest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        \Log::info('Guest in build method: ' . print_r($this->guest, true));
        return $this->view('emails.counseling_mail')
            ->from('celproject@example.com', 'Child Edu Laboratory')
            ->text('emails.counseling_mail')
            ->with([
                'userName' => $this->userName,
                'date' => Carbon::parse($this->guest->date)->format('Y年m月d日'),
                'timeSlot' => Carbon::parse($this->guest->timeSlot)->format('H時'),
            ])
            ->subject('カウンセリングの予約');
    }
}
