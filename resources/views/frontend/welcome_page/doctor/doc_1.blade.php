@extends('frontend.layouts.app')

@section('title', 'Prof. Dr. AKM Fazlul Haque | Dr. Fazlul Haque Colorectal Hospital Limited (DFCH)')

<link rel="stylesheet" href="{{ asset('css/frontend/doctor/doc_1.css') }}">

@section('content')
    @include('frontend.welcome_page.header')

    <!-- COVER BANNER -->
    <div class="doctor-banner" style="background-image: url('{{ asset('uploads/images/welcome_page/cover.png') }}');">
        <nav class="breadcrumb-custom">
            <a href="{{ route('welcome') }}" class="doc-link text-decoration-none">Home</a>
            <span>></span>
            <a href="{{ route('doc_1') }}" class="doc-link text-decoration-none">
                Prof. Dr. AKM Fazlul Haque
            </a>
        </nav>
    </div>

    <!-- DOCTOR PROFILE -->
    <section class="doctor-profile">
            <div class="doctor-card">
                <div class="row align-items-start">
                    <!-- IMAGE + BUTTON -->
                    <div class="col-md-5 mb-4 mb-md-0">
                        <div class="doctor-image">
                            <img src="{{ asset('uploads/images/welcome_page/doctors/image_1.jpg') }}"
                                alt="Prof. Dr. AKM Fazlul Haque" class="magnify-img">

                            <a href="#" class="book-btn">Book Now</a>
                        </div>
                    </div>

                    <!-- BASIC INFO -->
                    <div class="col-md-7">
                        <h2 class="doctor-name">
                            Prof. Dr. AKM Fazlul Haque
                        </h2>

                        <p class="doctor-degree">
                            MBBS, FCPS, FICS
                        </p>

                        <p class="doctor-designation">
                            Fellow, Colorectal Surgery (Singapore)<br>
                            International Scholar, Colorectal Surgery (USA)
                        </p>

                        <p class="doctor-designation">
                            Founder Chairman (RETD.), Chief Consultant (Chairman)<br>
                            Colorectal Surgery Department<br>
                            Dr. Fazlul Haque Colorectal Hospital Ltd.
                        </p>

                        <p class="doctor-designation">
                            Department of Colorectal Surgery<br>
                            Bangladesh Medical University, Dhaka
                        </p>


                        <h5 class="section-title">About the Doctor</h5>
                        <p>
                            Professor Dr. AKM Fazlul Haque was the founder Chairman and Professor of the Department of
                            Colorectal Surgery in Bangladesh Medical University, Dhaka, the only Medical University in
                            Bangladesh. He obtained MBBS Degree from Dhaka Medical College in 1982 and was awarded
                            Fellowship (FCPS, Surgery) from Bangladesh College of Physicians and Surgeons in January
                            1989. He worked in Government health service in Bangladesh starting from April 1982 until
                            2009. He served as a registrar in the department of surgery for one year in Singapore General
                            Hospital in 1995 – 1996. He is the best and most experienced doctor of Colorectal Surgery
                            specially in Bangladesh. He is also the Pioneer Colorectal Surgeon in South Asian Subcontinent
                            (India, Bangladesh, Nepal, and Pakistan). Chief Consultant (Chairman), Colorectal Surgery
                            Department. Dr. Fazlul Haque Colorectal Hospital Ltd.
                        </p>

                        <p>
                            Prof. Dr. AKM Fazlul Haque is one of the best colorectal surgeons in world ranking.
                        </p>

                        <p>
                            Prof Haque has performed the highest number of operations in colorectal surgery in the world
                            starting from 1996 till now. He practices only colorectal surgery (diseases involving colon,
                            rectum & anus like piles, anal fissure, fistula, colon & rectum cancer, Colostomy, Ileostomy,
                            polyposis coli, appendicitis, polyp, Diverticulosis, constipation, Diarrhea, Ulcerative colitis,
                            Crohn’s disease, IBS, pilonidal sinus, condyloma acuminate, Itching around anus, TB
                            (Tuberculosis of colon).
                        </p>

                        <p>
                            According to Wikipedia Prof. Dr. AKM Fazlul Haque is the best doctor as Notable alumni in the
                            history of Dhaka Medical College.
                        </p>

                        <p>
                            Prof. Haque started the loner journey of relentless struggle to establish colorectal surgery as
                            a
                            new specialty in Bangladesh. After nine years of lonely bitter struggle he succeeded to
                            establish
                            colorectal surgery as a new specialty here. Under his pioneering leadership, Colorectal Surgery
                            was recognized as an independent department in the Medical University (BSMMU), Chief
                            Consultant (Chairman), Colorectal Surgery Department. Dr. Fazlul Haque Colorectal Hospital
                            Ltd. He introduced M.S. degree in Colorectal Surgery in Bangladesh in 2006. The course was
                            also designed by himself. He was the founder chairman of Bangabandhu Shekh Mujib Medical
                            University.
                        </p>

                        <p>
                            He practices absolutely restricted Colorectal Surgery since 1995. In last 25 years he has
                            consulted nearly 6,50,000 (Six lac fifty thousand) new patients and operated 95,000 (Ninety five
                            thousand) patients in private and government’s hospital having Piles, Fistula, Anal Fissure,
                            Colon and Rectal Cancer, Polyp, Rectal Prolapse & Diverticulitis. He does short and full
                            colonoscopy himself routinely for most of the patients.
                        </p>

                        <p>
                            He successfully initiated various modern surgeries of colon and rectum. Such as double
                            stapling of rectum cancer, Longo operation for Hemorrhoid and successful operation of fistula
                            after having frequent unsuccessful operations. Professor Haque popularized the idea of
                            treating 70-80% of Hemorrhoid patients with non-operation procedure such as Rubber Ring
                            Ligation.
                        </p>

                        <p>
                            He has started operations in Bangladesh for the first time namely Low anterior resection with
                            double stapling, Longo operation and complex fistula operation with seton technique.
                        </p>

                        <p>
                            He is doing various Laser operations which are very popular among patients.
                        </p>

                        <p>
                            He has taken the initiative to observe “World Piles & Colorectal Cancer Day” on 20th November
                            in Bangladesh and internationally to increase public awareness.
                        </p>

                        <p>
                            In the history of Bangladesh he is the first who directed international training course for
                            senior
                            foreign specialists in May’2008. Surgeons from Srilanka, Nepal, India and Maldives attended the
                            international training program “Titled: Master program in MIPH”. In this program he trained
                            them practically how to perform Longo operation skillfully without any trauma to the anal canal
                            exterior.
                        </p>

                    </div>
                </div>
        </div>
    </section>
    @include('frontend.welcome_page.footer')
@endsection
