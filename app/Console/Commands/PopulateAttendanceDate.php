<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;

class PopulateAttendanceDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-attendance-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $attendances = Attendance::all();

        foreach ($attendances as $attendance) {
            $attendance->update([
                'date' => $attendance->created_at->toDateString(),
            ]);
        }

        $this->info('Attendance dates populated successfully.');
    }
}
