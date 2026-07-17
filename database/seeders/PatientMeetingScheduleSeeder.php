<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\PatientMeeting;
use App\Models\Specialist;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PatientMeetingScheduleSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        */

        $startDate = Carbon::create(2026, 7, 1);

        $endDate = Carbon::create(2026, 7, 17);


        /*
        |--------------------------------------------------------------------------
        | Load Existing Patients & Specialists
        |--------------------------------------------------------------------------
        */

        $patients = Patient::inRandomOrder()->get();

        $specialists = Specialist::where('is_active', true)
            ->orderBy('position')
            ->get();


        if ($patients->isEmpty()) {

            $this->command->error(
                'No patients found. Please run PatientSeeder first.'
            );

            return;
        }


        if ($specialists->isEmpty()) {

            $this->command->error(
                'No active specialists found. Please run SpecialistSeeder first.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Meeting Information
        |--------------------------------------------------------------------------
        */

        $meetingTypes = [

            'consultation' => [

                'title' => 'Patient Consultation',

                'descriptions' => [

                    'Initial consultation and clinical assessment.',

                    'General patient consultation and treatment planning.',

                    'Clinical evaluation and specialist consultation.',

                ],

            ],


            'follow_up' => [

                'title' => 'Follow-up Consultation',

                'descriptions' => [

                    'Follow-up consultation for ongoing treatment.',

                    'Review of patient progress and treatment response.',

                    'Post-treatment follow-up and clinical evaluation.',

                ],

            ],


            'report_review' => [

                'title' => 'Medical Report Review',

                'descriptions' => [

                    'Review of patient medical reports and investigations.',

                    'Review of X-ray and diagnostic reports.',

                    'Discussion regarding investigation findings.',

                ],

            ],


            'emergency' => [

                'title' => 'Emergency Patient Review',

                'descriptions' => [

                    'Urgent patient evaluation and specialist review.',

                    'Emergency clinical assessment.',

                ],

            ],


            'other' => [

                'title' => 'Patient Medical Meeting',

                'descriptions' => [

                    'General medical discussion and patient management.',

                    'Patient care planning meeting.',

                ],

            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | Time Slots
        |--------------------------------------------------------------------------
        */

        $timeSlots = [

            ['09:00:00', '09:30:00'],

            ['09:30:00', '10:00:00'],

            ['10:00:00', '10:30:00'],

            ['10:30:00', '11:00:00'],

            ['11:00:00', '11:30:00'],

            ['11:30:00', '12:00:00'],

            ['14:00:00', '14:30:00'],

            ['14:30:00', '15:00:00'],

            ['15:00:00', '15:30:00'],

            ['15:30:00', '16:00:00'],

            ['16:00:00', '16:30:00'],

            ['16:30:00', '17:00:00'],

        ];


        /*
        |--------------------------------------------------------------------------
        | Track Used Patients
        |--------------------------------------------------------------------------
        |
        | A patient should not be assigned to multiple specialists
        | on the same day.
        |
        */

        $usedPatientDates = [];


        /*
        |--------------------------------------------------------------------------
        | Generate Schedule
        |--------------------------------------------------------------------------
        */

        foreach ($specialists as $specialist) {


            /*
            |--------------------------------------------------------------------------
            | Each Specialist Gets 3–5 Meetings
            |--------------------------------------------------------------------------
            */

            $meetingCount = rand(3, 5);


            /*
            |--------------------------------------------------------------------------
            | Select Different Days
            |--------------------------------------------------------------------------
            */

            $availableDates = [];

            $currentDate = $startDate->copy();


            while ($currentDate->lte($endDate)) {

                $availableDates[] = $currentDate->toDateString();

                $currentDate->addDay();
            }


            shuffle($availableDates);


            $selectedDates = array_slice(
                $availableDates,
                0,
                $meetingCount
            );


            foreach ($selectedDates as $meetingDate) {


                /*
                |--------------------------------------------------------------------------
                | Find A Patient Not Already Scheduled On This Date
                |--------------------------------------------------------------------------
                */

                $availablePatients = $patients->filter(function ($patient) use (
                    $usedPatientDates,
                    $meetingDate
                ) {

                    $key = $patient->id . '_' . $meetingDate;


                    return !isset($usedPatientDates[$key]);
                });


                if ($availablePatients->isEmpty()) {

                    continue;
                }


                $patient = $availablePatients->random();


                /*
                |--------------------------------------------------------------------------
                | Mark Patient As Used On This Date
                |--------------------------------------------------------------------------
                */

                $usedPatientDates[$patient->id . '_' . $meetingDate] = true;


                /*
                |--------------------------------------------------------------------------
                | Meeting Type
                |--------------------------------------------------------------------------
                */

                $meetingType = array_rand($meetingTypes);

                $meetingData = $meetingTypes[$meetingType];


                /*
                |--------------------------------------------------------------------------
                | Random Time
                |--------------------------------------------------------------------------
                */

                $timeSlot = $timeSlots[array_rand($timeSlots)];


                /*
                |--------------------------------------------------------------------------
                | Status Based On Meeting Date
                |--------------------------------------------------------------------------
                */

                $meetingCarbonDate = Carbon::parse($meetingDate);


                if ($meetingCarbonDate->isBefore(Carbon::today())) {

                    $status = collect([

                        'completed',

                        'completed',

                        'completed',

                        'no_show',

                    ])->random();
                } else {

                    $status = collect([

                        'scheduled',

                        'scheduled',

                        'confirmed',

                    ])->random();
                }


                /*
                |--------------------------------------------------------------------------
                | Create Meeting
                |--------------------------------------------------------------------------
                */

                PatientMeeting::create([

                    'patient_id' => $patient->id,

                    'specialist_id' => $specialist->id,


                    'title' => $meetingData['title'],


                    'description' => collect(
                        $meetingData['descriptions']
                    )->random(),


                    'meeting_date' => $meetingDate,


                    'start_time' => $timeSlot[0],

                    'end_time' => $timeSlot[1],


                    'status' => $status,


                    'meeting_type' => $meetingType,


                    'notes' => $this->generateNotes(
                        $status,
                        $specialist->name,
                        $patient->patient_name
                    ),

                ]);
            }
        }


        $this->command->info(

            'Patient meeting schedule seeded successfully from '
                . $startDate->format('d M Y')
                . ' to '
                . $endDate->format('d M Y')
                . '.'

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Generate Meeting Notes
    |--------------------------------------------------------------------------
    */

    private function generateNotes(
        string $status,
        string $specialistName,
        string $patientName
    ): ?string {


        if ($status === 'completed') {

            return collect([

                'Patient consultation completed successfully.',

                'Patient evaluated and treatment plan discussed.',

                'Clinical assessment completed.',

                'Follow-up recommendations provided.',

            ])->random();
        }


        if ($status === 'no_show') {

            return 'Patient did not attend the scheduled meeting.';
        }


        if ($status === 'confirmed') {

            return 'Meeting confirmed with the patient.';
        }


        return 'Meeting scheduled with ' . $specialistName . '.';
    }
}
