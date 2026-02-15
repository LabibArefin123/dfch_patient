<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class PatientWordSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [

            [
                'patient_name' => 'Word User 1',
                'patient_f_name' => 'Father 1',
                'patient_m_name' => 'Mother 1',
                'age' => 30,
                'gender' => 'male',
                'phone_1' => '01700000001',
                'phone_2' => null,
                'phone_f_1' => null,
                'phone_m_1' => null,
                'location_type' => 2,
                'location_simple' => null,
                'city' => 'Dhaka',
                'district' => 'Dhaka',
                'country' => null,
                'is_recommend' => 1,
                'date_of_patient_added' => Carbon::now()->toDateString(),
            ],

            [
                'patient_name' => 'Word User 2',
                'patient_f_name' => 'Father 2',
                'patient_m_name' => 'Mother 2',
                'age' => 25,
                'gender' => 'female',
                'phone_1' => '01700000002',
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
                'patient_name' => 'Word User 3',
                'patient_f_name' => 'Father 3',
                'patient_m_name' => 'Mother 3',
                'age' => 40,
                'gender' => 'male',
                'phone_1' => '01700000003',
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
                'patient_name' => 'Word User 4',
                'patient_f_name' => 'Father 4',
                'patient_m_name' => 'Mother 4',
                'age' => 22,
                'gender' => 'female',
                'phone_1' => '01700000004',
                'phone_2' => null,
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

        ];

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Headings (same as Excel)
        $headings = [
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

        // Add table
        $table = $section->addTable();

        // Header row
        $table->addRow();
        foreach ($headings as $heading) {
            $table->addCell(2000)->addText($heading);
        }

        // Data rows
        foreach ($patients as $patient) {
            $table->addRow();
            foreach ($headings as $key) {
                $table->addCell(2000)->addText($patient[$key] ?? '');
            }
        }

        // Save file
        $filePath = storage_path('app/patient_import_sample.docx');
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($filePath);

        $this->command->info('Word file created: storage/app/patient_import_sample.docx');
    }
}
