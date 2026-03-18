<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::create(2026, 3, 1);
        $endDate   = Carbon::create(2026, 3, 25);

        $baseId = Patient::max('id') ?? 0;

        /* ===============================
           LOAD CONFIG SAFELY
        =============================== */

        $maleFirst   = config('bd_names.male_first', []);
        $femaleFirst = config('bd_names.female_first', []);
        $lastNames   = config('bd_names.last', []);

        if (empty($maleFirst) || empty($femaleFirst) || empty($lastNames)) {
            throw new \Exception('bd_names config is missing or empty!');
        }

        $problems = [
            'Abdominal pain',
            'Rectal bleeding',
            'Hemorrhoids',
            'Anal fissure',
            'Chronic diarrhea',
            'IBD symptoms',
            'Post-op follow-up',
        ];

        $drugs = [
            'Tab Napa 500mg',
            'Tab Seclo 20mg',
            'Tab Flagyl 400mg',
            'Syrup Lactulose',
            'ORS',
        ];

        /* ===============================
           MAIN LOOP
        =============================== */

        while ($startDate <= $endDate) {

            $dailyCount = rand(50, 150);

            for ($i = 0; $i < $dailyCount; $i++) {

                $baseId++;

                $gender = rand(0, 1) ? 'male' : 'female';

                // First & Last Name
                $firstName = $gender === 'male'
                    ? $maleFirst[array_rand($maleFirst)]
                    : $femaleFirst[array_rand($femaleFirst)];

                $lastName = $lastNames[array_rand($lastNames)];

                // ✅ Add "Md." prefix randomly (very BD realistic)
                $prefix = ($gender === 'male' && rand(1, 100) <= 70) ? 'Md. ' : '';

                $patientName = $prefix . $firstName . ' ' . $lastName;

                // Parents
                $fatherName = 'Md. ' . $maleFirst[array_rand($maleFirst)] . ' ' . $lastName;
                $motherName = $femaleFirst[array_rand($femaleFirst)] . ' ' . $lastName;

                $locationType = rand(1, 3);

                Patient::create([
                    'patient_code' => 'DFCH-2026-' . str_pad($baseId, 8, '0', STR_PAD_LEFT),

                    'patient_name'   => $patientName,
                    'patient_f_name' => $fatherName,
                    'patient_m_name' => $motherName,

                    'age'    => rand(2, 85),
                    'gender' => $gender,

                    'location_type' => $locationType,

                    // Domestic
                    'house_address' => $locationType == 2 ? 'House-' . rand(1, 100) : null,
                    'city'          => $locationType == 2 ? 'Dhaka' : null,
                    'district'      => $locationType == 2 ? 'Dhaka' : null,
                    'post_code'     => $locationType == 2 ? rand(1000, 9999) : null,

                    // Foreign
                    'country'     => $locationType == 3 ? 'India' : null,
                    'passport_no' => $locationType == 3 ? strtoupper('A' . rand(100000, 999999)) : null,

                    // BD Phone
                    'phone_1' => '01' . rand(3, 9) . rand(10000000, 99999999),

                    // Medical
                    'patient_problem_description' => $problems[array_rand($problems)],
                    'patient_drug_description'    => $drugs[array_rand($drugs)],

                    'is_recommend' => rand(1, 100) <= 15,

                    'date_of_patient_added' => $startDate->toDateString(),

                    'created_at' => $startDate->copy()->addMinutes(rand(1, 600)),
                    'updated_at' => now(),
                ]);
            }

            $startDate->addDay();
        }
    }
}
