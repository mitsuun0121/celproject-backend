<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Guest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationMail;
use Illuminate\Support\Carbon;


class SendReservationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * ゲストのID.
     *
     * @var int
     */
    protected $guestId;
    protected $email;
    protected $name;
    protected $date;
    protected $timeSlot; 

    /**
     * Create a new job instance.
     *
     * @param int $guestId
     * @return void
     */
    
    public function __construct($guestId, $email, $name, $date, $timeSlot)
    {
        $this->guestId = $guestId;
        $this->email = $email;
        $this->name = $name;
        $this->date = $date;
        $this->timeSlot = $timeSlot;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $guest = Guest::find($this->guestId);

        if ($guest) {
            $guestEmail = $this->email;
            $guestName = $this->name;
            $date = Carbon::parse($this->date)->format('Y年m月d日');
            $timeSlot = Carbon::parse($this->timeSlot)->format('H時');

            $email = new ReservationMail($guest);
            Mail::to($guestEmail)->send($email);
        }

    }
}
