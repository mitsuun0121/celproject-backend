<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;
use App\Models\Guest;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $guest;

    public function __construct($guest)
    {
        $this->guest = $guest;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $guest = Guest::find($this->guest);

        if (!$guest) {
            // 予約が見つからない場合
            \Log::error("Guest not found: {$this->guest}");
            return;
        }

        Mail::to($this->guest->email)->send(new ReminderMail($this->guest));
    }
}
