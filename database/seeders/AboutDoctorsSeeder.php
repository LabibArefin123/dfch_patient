<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutDoctor;

class AboutDoctorsSeeder extends Seeder
{
    public function run()
    {

        AboutDoctor::insert([

            [
                'name' => 'Prof. Dr. AKM Fazlul Haque',
                'slug' => 'doc_1',
                'degree' => 'MBBS, FCPS, FICS',
                'designation' => 'Fellow, Colorectal Surgery (Singapore)
International Scholar, Colorectal Surgery (USA)

Founder Chairman (RETD.), Chief Consultant (Chairman)
Colorectal Surgery Department
Dr. Fazlul Haque Colorectal Hospital Ltd.

Department of Colorectal Surgery
Bangladesh Medical University, Dhaka',

                'about' => 'Professor Dr. AKM Fazlul Haque is the founder Chairman of Colorectal Surgery Department in Bangladesh Medical University.

He obtained MBBS from Dhaka Medical College in 1982 and FCPS in 1989.

He is considered the pioneer colorectal surgeon in South Asia and has performed more than 95,000 colorectal surgeries.

He introduced several modern colorectal procedures in Bangladesh including Longo operation and advanced rectal cancer surgery.

He also introduced MS degree in Colorectal Surgery in Bangladesh in 2006.',

                'image' => 'uploads/images/welcome_page/doctors/image_1.jpg',
                'youtube' => null,
                'status' => 1,
            ],

            [
                'name' => 'Dr. Asif Almas Haque',
                'slug' => 'doc_2',

                'degree' => 'MBBS (SSMC), FCPS (Surgery), FCPS (Colorectal Surgery), FRCS (England), FRCS (Glasgow), FRCS (Edinburgh), FACS (USA), FASCRS (USA)',

                'designation' => 'Consultant, Colorectal, Laparoscopic and Laser Surgeon
Member, American Society of Colon and Rectal Surgeons',

                'about' => 'Dr. Asif Almas Haque is one of the leading colorectal surgeons in Bangladesh.

He specializes in colorectal surgery, laparoscopic surgery, and laser surgery. He has successfully performed numerous complex colorectal procedures with excellent patient outcomes.

He is known for his compassionate approach and commitment to providing high quality patient care.',

                'image' => 'uploads/images/welcome_page/doctors/image_2.jpg',

                'youtube' => 'https://www.youtube.com/embed/txHKFJtOqYE',

                'status' => 1,
            ],

            [
                'name' => 'Dr. Fatema Sharmin (Anny)',
                'slug' => 'doc_3',

                'degree' => 'MBBS, DA, FCPS (Final Part)',

                'designation' => 'Consultant (Anesthesiology)
Dr. Fazlul Haque Colorectal Hospital Limited

Assistant Professor (Anesthesiology)
Bangladesh Medical College Hospital, Dhanmondi',

                'about' => 'Dr. Fatema Sharmin (Anny) is an experienced anesthesiology consultant with strong expertise in anesthesia management during complex surgical procedures.

She is known for her patient focused care and dedication to maintaining the highest safety standards in operation theaters.',

                'image' => 'uploads/images/welcome_page/doctors/image_3.jpg',

                'youtube' => null,

                'status' => 1,
            ],

            [
                'name' => 'Dr. Sakib Sarwat Haque',

                'slug' => 'doc_4',

                'degree' => 'MBBS, FCPS (Surgery), MRCS (Edinburgh)',

                'designation' => 'Consultant Surgeon
Dr. Fazlul Haque Colorectal Hospital Ltd.',

                'about' => 'Dr. Sakib Sarwat Haque is a consultant surgeon trained in general and colorectal surgery.

He focuses on delivering safe, modern, and patient-centered surgical care and actively participates in both elective and emergency surgical treatments.',

                'image' => 'uploads/images/welcome_page/doctors/image_4.jpg',

                'youtube' => null,

                'status' => 1,
            ],

            [
                'name' => 'Dr. Asma Husain Noora',

                'slug' => 'doc_5',

                'degree' => 'MBBS, FCPS (Surgery), MRCS (Edinburgh)',

                'designation' => 'Consultant Surgeon
Dr. Fazlul Haque Colorectal Hospital Ltd',

                'about' => 'Dr. Asma Husain Noora is a consultant surgeon with strong clinical and academic training.

She is experienced in modern surgical techniques and is dedicated to ensuring patient safety and excellent surgical outcomes.',

                'image' => 'uploads/images/welcome_page/doctors/image_5.jpg',

                'youtube' => null,

                'status' => 1,
            ],

        ]);
    }
}
