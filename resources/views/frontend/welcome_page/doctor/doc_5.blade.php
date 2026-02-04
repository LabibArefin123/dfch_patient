@extends('frontend.layouts.app')

@section('title', 'Dr. Asma Husain Noora | DFCH')
<link rel="stylesheet" href="{{ asset('css/doctor/doc_5.css') }}">

@section('content')

    @include('frontend.welcome_page.header')

    <section class="doctor-profile">
        <div class="container">

            <!-- Top Banner -->
            <div class="doctor-banner">
                <nav class="breadcrumb-custom">
                    <a href="{{ route('welcome') }}" class="doc-link text-decoration-none">Home</a>
                    <span>→</span>
                    <span>Our Specialists</span>
                    <span>→</span>
                    <a href="{{ route('doc_5') }}" class="doc-link text-decoration-none">
                        Dr. Asma Husain Noora
                    </a>
                </nav>
            </div>

            <div class="doctor-card">
                <div class="row align-items-start">

                    <!-- Image + Book Now -->
                    <div class="col-md-5 mb-4 mb-md-0">
                        <div class="doctor-image">
                            <img src="{{ asset('uploads/images/welcome_page/doctors/image_5.jpg') }}"
                                alt="Dr. Asma Husain Noora">

                            <a href="#" class="book-btn">Book Now</a>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="col-md-7">
                        <h2 class="doctor-name">Dr. Asma Husain Noora</h2>

                        <p class="doctor-degree">
                            MBBS, FCPS (Surgery), MRCS (Edinburgh)
                        </p>

                        <p class="doctor-designation">
                            Consultant Surgeon<br>
                            Dr. Fazlul Haque Colorectal Hospital Ltd
                        </p>

                        <h5 class="section-title">About the Doctor</h5>
                        <p>
                            Dr. Asma Husain Noora is a consultant surgeon with strong academic
                            credentials and clinical experience in surgical care. She is trained
                            in modern surgical techniques and prioritizes patient safety and comfort.
                        </p>

                        <p>
                            She is currently practicing at Dr. Fazlul Haque Colorectal Hospital Ltd,
                            where she is actively involved in managing both routine and complex
                            surgical cases.
                        </p>

                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
