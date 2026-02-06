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
        // Faker (South Asia friendly)
        $faker = Faker::create('en_IN');

        /* ===============================
           BANGLADESH REALISTIC DATA
        =============================== */

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
            'Shamima Begum'
        ];

        $fatherNames = [
            'dsaFWFAGWG WADW',
            'SGWBWDAWD FWFWArWR',
            'SDADADSDA WFOIAJFOJOW',
            'SFWAFDAWD DOAWJPJ',
            'WRRWFAGGDA WDAS',
            'SDSDDDDHW FPOAKFK',
            'WGWHEHHHH DAWFAFGG',
            'WDGWBBWAFD DADAFG',
            'WAWGWGGGG OJOFIVOH',
            'HHHHQEDQQ MGOICD',
            'GWIJWDOJAOD DKPOAJPJA',
            'WPPWOAFPJJ KDPAWPDWAJ',
            'WJFOJAFOHF MMDPADPOKP'
        ];

        $motherNames = [
            'WIFAOFHHOF DAWDBAB',
            'WJFPWAJFFW JFPOJWJFA',
            'SAFsFAFWFW FPOAWJFO',
            'GGWNWRNTA WJFPADW',
            'OJDOIHWDOAN AKFPDAW',
            'WDYHIAUHDIU PWOJFAPJFJPOAF',
            'JDOWJAODJ FAKFPJWAPJFPJD',
            'JDPAJDJJJAO AKFKAGPFKAWWW',
            'GIJIOWGONF APLDPWLAD',
            'DWADADWWFFWA DWJDPWAJFPWJA'
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

        // Common colorectal & hospital problems (BD context)
        $patientProblems = [
            'Chronic abdominal pain with constipation',
            'Rectal bleeding during defecation',
            'Hemorrhoids with pain and itching',
            'Anal fissure with bleeding',
            'Suspected colorectal carcinoma',
            'Chronic diarrhea with weight loss',
            'Inflammatory bowel disease symptoms',
            'Post-operative follow-up visit',
            'Lower abdominal pain with anemia',
            'Piles with prolapse'
        ];

        // Realistic OPD / hospital drug prescriptions
        $drugPrescriptions = [
            'Tab Napa 500mg 1+1+1 after meal',
            'Tab Seclo 20mg 1+0+1 before meal',
            'Tab Domperidone 10mg 1+0+1',
            'Syrup Lactulose 15ml at night',
            'Tab Flagyl 400mg 1+1+1 for 7 days',
            'Tab Cefixime 200mg 1+0+1 for 5 days',
            'Suppository Proctosedyl at night',
            'ORS after each loose motion',
            'Tab Napa Extend 665mg 1+0+1',
            'Injection Ceftriaxone 1gm IV BD'
        ];

        // Local doctor names
        $doctorNames = [
            'Dr. ABC',
            'Dr. AAA',
            'Dr. ACC',
            'Dr. ABCD',
            'Dr. AZZZZ',
            'Dr. XYZ',
            'Dr. ZZZ',
            'Dr. AAAS',
            'Dr. SDDDA',
            'Dr. MBO'
        ];

        /* ===============================
           DATE RANGE
        =============================== */

        $startDate = Carbon::now()->subMonths(6)->startOfDay();
        $endDate   = Carbon::now()->startOfDay();

        $baseId = Patient::max('id') ?? 0;

        /* ===============================
           MAIN LOOP
        =============================== */

        while ($startDate <= $endDate) {

            $dailyCount = $startDate->isToday() ? 120 : rand(100, 150);

            for ($i = 1; $i <= $dailyCount; $i++) {

                $baseId++;

                $gender = rand(0, 1) ? 'male' : 'female';

                $patientName = $gender === 'male'
                    ? $maleNames[array_rand($maleNames)]
                    : $femaleNames[array_rand($femaleNames)];

                $locationType = rand(1, 3); // 1=Local, 2=Domestic, 3=Foreign
                $isRecommend  = rand(1, 100) <= 15;

                Patient::create([
                    'patient_code' => 'DFCH-' . $startDate->year . '-' . str_pad($baseId, 9, '0', STR_PAD_LEFT),

                    'patient_name'   => $patientName,
                    'patient_f_name' => $fatherNames[array_rand($fatherNames)],
                    'patient_m_name' => $motherNames[array_rand($motherNames)],

                    'age'    => rand(2, 85),
                    'gender' => $gender,

                    'location_type'   => $locationType,
                    'location_simple' => $locationType === 1 ? 'Local Area' : null,

                    // Domestic patient
                    'house_address' => $locationType === 2 ? $faker->streetAddress : null,
                    'city'          => $locationType === 2 ? 'Dhaka' : null,
                    'district'      => $locationType === 2 ? $districts[array_rand($districts)] : null,
                    'post_code'     => $locationType === 2 ? rand(1000, 9999) : null,

                    // Foreign patient
                    'country'     => $locationType === 3 ? 'India' : null,
                    'passport_no' => $locationType === 3 ? strtoupper($faker->bothify('A######')) : null,

                    // Bangladesh mobile format
                    'phone_1'   => '01' . rand(3, 9) . rand(10000000, 99999999),
                    'phone_2'   => rand(0, 1) ? '01' . rand(3, 9) . rand(10000000, 99999999) : null,
                    'phone_f_1' => rand(0, 1) ? '01' . rand(3, 9) . rand(10000000, 99999999) : null,
                    'phone_m_1' => rand(0, 1) ? '01' . rand(3, 9) . rand(10000000, 99999999) : null,

                    // Medical info
                    'patient_problem_description' => $patientProblems[array_rand($patientProblems)],
                    'patient_drug_description'    => $drugPrescriptions[array_rand($drugPrescriptions)],

                    // Recommendation
                    'is_recommend'           => $isRecommend,
                    'recommend_doctor_name' => $isRecommend ? $doctorNames[array_rand($doctorNames)] : null,
                    'recommend_note'        => $isRecommend ? 'Advised further evaluation and follow-up.' : null,

                    'date_of_patient_added' => $startDate->toDateString(),
                    'remarks'               => rand(0, 1) ? 'Patient advised follow-up visit.' : null,

                    'created_at' => $startDate->copy()->addMinutes(rand(1, 600)),
                    'updated_at' => $startDate->copy()->addMinutes(rand(1, 600)),
                ]);
            }

            $startDate->addDay();
        }
    }
}
