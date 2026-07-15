<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Seeder;

class SpecialistSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            [
                'name' => 'Prof. Dr. AKM Fazlul Haque',
                'designation' => 'Founder & Chief Consultant',
                'degree' => 'MBBS, FCPS, FICS',
                'details' => 'Fellow, Colorectal Surgery (Singapore)<br>
International Scholar (USA)<br>
Founder Chairman (RETD.), Department of Colorectal Surgery<br>
Bangladesh Medical University, Dhaka<br>
Chief Consultant, DFCH',
                'photo' => 'image_1.jpg',
                'position' => 1,
            ],

            [
                'name' => 'Dr. Asif Almas Haque',
                'designation' => 'Consultant',
                'degree' => 'MBBS, FCPS, FRCS, FACS, FASCRS',
                'details' => 'Consultant, Colorectal, Laparoscopic & Laser Surgeon<br>
Member, American Society of Colon & Rectal Surgeons',
                'photo' => 'image_2.jpg',
                'position' => 2,
            ],

            [
                'name' => 'Dr. Fatema Sharmin (Anny)',
                'designation' => 'Consultant (Anesthesiology)',
                'degree' => 'MBBS, DA, FCPS (Final)',
                'details' => 'Consultant (Anesthesiology), DFCH<br>
Assistant Professor, Bangladesh Medical College Hospital',
                'photo' => 'image_3.jpg',
                'position' => 3,
            ],

            [
                'name' => 'Dr. Sakib Sarwat Haque',
                'designation' => 'Consultant Surgeon',
                'degree' => 'MBBS, FCPS, MRCS (Edinburgh)',
                'details' => 'Consultant Surgeon, DFCH',
                'photo' => 'image_4.jpg',
                'position' => 4,
            ],

            [
                'name' => 'Dr. Asma Husain Noora',
                'designation' => 'Consultant Surgeon',
                'degree' => 'MBBS, FCPS, MRCS (Edinburgh)',
                'details' => 'Consultant Surgeon, DFCH',
                'photo' => 'image_5.jpg',
                'position' => 5,
            ],

            [
                'name' => 'Mrs. Shahin Mahbuba Haque',
                'designation' => 'Co-Founder',
                'degree' => '',
                'details' => 'Co-Founder of Dr. Fazlul Haque Colorectal Hospital (DFCH). She has played a significant role in establishing and developing the hospital alongside Prof. Dr. AKM Fazlul Haque, contributing to patient care, hospital administration, and organizational development.',
                'photo' => 'image_6.jpg',
                'position' => 6,
            ],

        ];

        foreach ($data as $item) {
            Specialist::create($item);
        }
    }
}