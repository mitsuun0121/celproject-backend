<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;
use App\Models\Guest;
use App\Jobs\SendReminderEmail;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to guests';

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
        $today = Carbon::now()->format('Y-m-d');
        $guests = Guest::where('date', $today)
            ->whereBetween('timeSlot', ['10:00:00', '17:00:00'])
            ->get();

        // リマインダーメールを送信
        foreach ($guests as $guest) {
            SendReminderEmail::dispatch($guest);
        }
        
        $this->info('Reminders sent successfully.');
    }
}
