<?php

namespace App\Console\Commands;

use App\ManageSiswa;
use App\Message;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete messages that are older than one minute';

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
        $oneMinuteAgo = Carbon::now()->subMinute();
        $twelveHoursAgo = Carbon::now()->subHours(12);

        Message::where('created_at', '<', $oneMinuteAgo)->delete();
        ManageSiswa::where('created_at', '<', $twelveHoursAgo)->delete();

        $this->info('Old messages deleted successfully.');
        return 0;
    }
}
