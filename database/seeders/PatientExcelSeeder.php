<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PatientExcelSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [

            [
                'patient_name' => 'Md. Rakib Hasan',
                'patient_f_name' => 'Abdul Karim',
                'patient_m_name' => 'Ayesha Begum',
                'age' => 32,
                'gender' => 'male',
                'phone_1' => '01712345678',
                'phone_2' => '01812345678',
                'phone_f_1' => '01799999999',
                'phone_m_1' => '01888888888',
                'location_type' => 2,
                'location_simple' => null,
                'city' => 'Dhaka',
                'district' => 'Dhaka',
                'country' => null,
                'is_recommend' => 1,
                'date_of_patient_added' => Carbon::now()->toDateString(),
            ],

            [
                'patient_name' => 'Shamima Akter',
                'patient_f_name' => 'Md. Rahman',
                'patient_m_name' => 'Fatema Khatun',
                'age' => 28,
                'gender' => 'female',
                'phone_1' => '01987654321',
                'phone_2' => null,
                'phone_f_1' => null,
                'phone_m_1' => null,
                'location_type' => 1,
                'location_simple' => 'Local Area',
                'city' => null,
                'district' => null,
                'country' => null,
                'is_recommend' => 0,
                'date_of_patient_added' => Carbon::now()->toDateString(),
            ],

            [
                'patient_name' => 'Tanvir Ahmed',
                'patient_f_name' => 'Md. Saiful Islam',
                'patient_m_name' => 'Shamima Begum',
                'age' => 45,
                'gender' => 'male',
                'phone_1' => '01611223344',
                'phone_2' => null,
                'phone_f_1' => null,
                'phone_m_1' => null,
                'location_type' => 3,
                'location_simple' => null,
                'city' => null,
                'district' => null,
                'country' => 'India',
                'is_recommend' => 1,
                'date_of_patient_added' => Carbon::now()->toDateString(),
            ],

            [
                'patient_name' => 'Nusrat Jahan',
                'patient_f_name' => 'Md. Kamal',
                'patient_m_name' => 'Ayesha Begum',
                'age' => 22,
                'gender' => 'female',
                'phone_1' => '01555667788',
                'phone_2' => '01799887766',
                'phone_f_1' => null,
                'phone_m_1' => null,
                'location_type' => 2,
                'location_simple' => null,
                'city' => 'Chattogram',
                'district' => 'Chattogram',
                'country' => null,
                'is_recommend' => 0,
                'date_of_patient_added' => Carbon::now()->toDateString(),
            ],

            [
                'patient_name' => 'Arif Hossain',
                'patient_f_name' => 'Md. Jahangir',
                'patient_m_name' => 'Shamima Begum',
                'age' => 60,
                'gender' => 'male',
                'phone_1' => '01833445566',
                'phone_2' => null,
                'phone_f_1' => null,
                'phone_m_1' => null,
                'location_type' => 1,
                'location_simple' => 'Local Area',
                'city' => null,
                'district' => null,
                'country' => null,
                'is_recommend' => 1,
                'date_of_patient_added' => Carbon::now()->toDateString(),
            ],

        ];

        // Generate Excel file
        Excel::store(
            new class($patients) implements
                \Maatwebsite\Excel\Concerns\FromArray,
                \Maatwebsite\Excel\Concerns\WithHeadings {

                protected $patients;

                public function __construct($patients)
                {
                    $this->patients = $patients;
                }

                public function array(): array
                {
                    return $this->patients;
                }

                public function headings(): array
                {
                    return [
                        'patient_name',
                        'patient_f_name',
                        'patient_m_name',
                        'age',
                        'gender',
                        'phone_1',
                        'phone_2',
                        'phone_f_1',
                        'phone_m_1',
                        'location_type',
                        'location_simple',
                        'city',
                        'district',
                        'country',
                        'is_recommend',
                        'date_of_patient_added',
                    ];
                }
            },
            'patient_import_sample.xlsx'
        );

        $this->command->info('Excel file created: storage/app/patient_import_sample.xlsx');
    }
}
