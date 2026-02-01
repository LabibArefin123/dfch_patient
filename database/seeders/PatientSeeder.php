<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('en_US'); // FIXED

        $maleNames = [
            'Abdul Karim',
            'Md. Rahman',
            'Md. Hasan',
            'Md. Alamgir',
            'Md. Saiful Islam',
            'Md. Jahangir',
            'Md. Kamal',
            'Md. Faruk',
            'Md. Mizanur Rahman'
        ];

        $femaleNames = [
            'Ayesha Begum',
            'Fatema Khatun',
            'Rokeya Begum',
            'Salma Akter',
            'Nasrin Akter',
            'Shamima Begum'
        ];

        $fatherNames = [
            'Abdul Gafur',
            'Abdul Jalil',
            'Md. Yunus',
            'Md. Sirajul Islam',
            'Md. Shamsul Haque'
        ];

        $motherNames = [
            'Rahima Begum',
            'Halima Khatun',
            'Amena Begum',
            'Nurjahan Begum'
        ];

        $districts = [
            'Dhaka',
            'Narayanganj',
            'Gazipur',
            'Cumilla',
            'Chattogram',
            'Noakhali',
            'Barishal',
            'Sylhet'
        ];

        $startDate = Carbon::now()->subMonths(6)->startOfDay();
        $endDate   = Carbon::now()->startOfDay();

        $baseId = Patient::max('id') ?? 0;

        while ($startDate <= $endDate) {

            $dailyCount = $startDate->isToday() ? 120 : rand(100, 300);

            for ($i = 1; $i <= $dailyCount; $i++) {

                $baseId++;

                $gender = rand(0, 1) ? 'male' : 'female';

                $patientName = $gender === 'male'
                    ? $maleNames[array_rand($maleNames)]
                    : $femaleNames[array_rand($femaleNames)];

                $locationType = rand(1, 3);
                $isRecommend  = rand(1, 100) <= 15;

                Patient::create([
                    'patient_code' => 'DFCH-' . $startDate->year . '-' . str_pad($baseId, 9, '0', STR_PAD_LEFT),

                    'patient_name'   => $patientName,
                    'patient_f_name' => $fatherNames[array_rand($fatherNames)],
                    'patient_m_name' => $motherNames[array_rand($motherNames)],

                    'age'    => rand(2, 85),
                    'gender' => $gender,

                    'location_type' => $locationType,

                    'location_simple' => $locationType == 1 ? 'Local Area' : null,

                    'house_address' => $locationType == 2 ? $faker->streetAddress : null,
                    'city'          => $locationType == 2 ? 'Dhaka' : null,
                    'district'      => $locationType == 2 ? $districts[array_rand($districts)] : null,
                    'post_code'     => $locationType == 2 ? rand(1000, 9999) : null,

                    'country'     => $locationType == 3 ? 'India' : null,
                    'passport_no' => $locationType == 3 ? strtoupper($faker->bothify('A######')) : null,

                    'phone_1'   => '01' . rand(3, 9) . rand(10000000, 99999999),
                    'phone_2'   => rand(0, 1) ? '01' . rand(3, 9) . rand(10000000, 99999999) : null,
                    'phone_f_1' => rand(0, 1) ? '01' . rand(3, 9) . rand(10000000, 99999999) : null,
                    'phone_m_1' => rand(0, 1) ? '01' . rand(3, 9) . rand(10000000, 99999999) : null,

                    'patient_problem_description' => $faker->sentence(6),
                    'patient_drug_description'    => $faker->sentence(5),

                    'is_recommend'           => $isRecommend,
                    'recommend_doctor_name' => $isRecommend ? 'Dr. ' . $faker->name : null,
                    'recommend_note'        => $isRecommend ? $faker->sentence(8) : null,

                    'date_of_patient_added' => $startDate->toDateString(),
                    'remarks'               => rand(0, 1) ? $faker->sentence(6) : null,

                    'created_at' => $startDate->copy()->addMinutes(rand(1, 600)),
                    'updated_at' => $startDate->copy()->addMinutes(rand(1, 600)),
                ]);
            }

            $startDate->addDay();
        }
    }
}
