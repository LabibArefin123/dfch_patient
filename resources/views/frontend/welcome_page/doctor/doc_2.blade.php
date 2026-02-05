@extends('frontend.layouts.app')

@section('title', 'Dr. Asif Almas Haque | DFCH')
<link rel="stylesheet" href="{{ asset('css/frontend/doctor/doc_2.css') }}">

@section('content')

@include('frontend.welcome_page.header')

<section class="doctor-profile">
<div class="container">
    <!-- Top Blank Banner (Image Placeholder) -->
    <div class="doctor-banner">
        <nav class="breadcrumb-custom">
            <a href="{{ route('welcome') }}" class="doc-link text-decoration-none">Home</a>
            <span>→</span>
            <span>Our Specialists</span>
            <span>→</span>
            <a href="{{ route('doc_2') }}" class="doc-link text-decoration-none ">Dr. Asif Almas Haque</a>
        </nav>
    </div>

    <div class="doctor-card">
        <div class="row align-items-start">

            <!-- Image + Book -->
            <div class="col-md-5 mb-4 mb-md-0">
                <div class="doctor-image">
                    <img src="{{ asset('uploads/images/welcome_page/doctors/image_2.jpg') }}"
                        alt="Dr. Asif Almas Haque">

                    <a href="#" class="book-btn">Book Now</a>
                </div>
            </div>

            <!-- Content -->
            <div class="col-md-7">
                <h2 class="doctor-name">Dr. Asif Almas Haque</h2>

                <p class="doctor-degree">
                    MBBS (SSMC), FCPS (Surgery), FCPS (Colorectal Surgery),<br>
                    FRCS (England), FRCS (Glasgow), FRCS (Edinburgh),<br>
                    FACS (USA), FASCRS (USA)
                </p>

                <p class="doctor-designation">
                    Consultant, Colorectal, Laparoscopic and Laser Surgeon<br>
                    Member, American Society of Colon and Rectal Surgeons
                </p>

                <h5 class="section-title">Areas of Expertise</h5>
                <ul class="expertise-list">
                    <li>Colorectal Surgery</li>
                    <li>Laparoscopic Surgery</li>
                    <li>Laser Surgery</li>
                </ul>

                <h5 class="section-title">About the Doctor</h5>
                <p>
                    Dr. Asif Almas Haque is one of the top colorectal surgeons in Bangladesh.
                    He has worked in some of the best hospitals in the country and brings
                    extensive experience in treating a wide range of colon and rectal conditions.
                </p>

                <p>
                    He is an expert in laparoscopic surgery and has successfully performed
                    numerous complex procedures. Dr. Haque is highly skilled in treating
                    colorectal cancer with an excellent success rate.
                </p>

                <p>
                    Known for his caring and compassionate nature, he always puts his patients
                    first and remains readily available to support them throughout their treatment journey.
                </p>

                <!-- YouTube -->
                <div class="youtube-card">
                    <iframe src="https://www.youtube.com/embed/txHKFJtOqYE"
                        title="Dr. Asif Almas Haque YouTube Video" frameborder="0" allowfullscreen>
                    </iframe>

                    <div class="yt-channel">
                        <a href="https://www.youtube.com/@asifh7000" target="_blank">
                            ▶ Visit YouTube Channel
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
</section>

@include('frontend.welcome_page.footer')
@endsection
