<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\CounselingMail;
use Illuminate\Support\Carbon;

class SendCounselingEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * ゲストのID. ユーザーのID.
     *
     * @var int
     */
    protected $guestId;
    protected $userId;
    protected $date;
    protected $timeSlot; 

    /**
     * Create a new job instance.
     *
     * @param int $guestId
     * @param int $userId
     * @return void
     */
    public function __construct($guestId, $userId, $date, $timeSlot)
    {
        $this->guestId = $guestId;
        $this->userId = $userId;
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
            $guestEmail = $guest->email;
            $guestName = $guest->name;
            $date = Carbon::parse($this->date)->format('Y年m月d日');
            $timeSlot = Carbon::parse($this->timeSlot)->format('H時');

            $user = User::find($this->userId);

            if ($user) {
                $userEmail = $user->email;
                $userName = $user->name;
                $email = new CounselingMail($userName, $guest);
                Mail::to($userEmail)->send($email);
            }
        }
    }
}
