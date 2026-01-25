<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attendance;

class AttendanceDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Attendance::whereNull('date')->each(function ($attendance) {
            $attendance->update(['date' => now()->toDateString()]);
        });
    }
}
