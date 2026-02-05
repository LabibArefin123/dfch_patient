@extends('frontend.layouts.app')

@section('title', 'Dr. Sakib Sarwat Haque | Dr. Fazlul Haque Colorectal Hospital Limited(DFCH)')
<link rel="stylesheet" href="{{ asset('css/frontend/doctor/doc_4.css') }}">

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
                    <a href="{{ route('doc_4') }}" class="doc-link text-decoration-none">
                        Dr. Sakib Sarwat Haque
                    </a>
                </nav>
            </div>

            <div class="doctor-card">
                <div class="row align-items-start">

                    <!-- Image + Book Now -->
                    <div class="col-md-5 mb-4 mb-md-0">
                        <div class="doctor-image">
                            <img src="{{ asset('uploads/images/welcome_page/doctors/image_4.jpg') }}"
                                alt="Dr. Sakib Sarwat Haque">

                            <a href="#" class="book-btn">Book Now</a>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="col-md-7">
                        <h2 class="doctor-name">Dr. Sakib Sarwat Haque</h2>

                        <p class="doctor-degree">
                            MBBS, FCPS (Surgery), MRCS (Edinburgh)
                        </p>

                        <p class="doctor-designation">
                            Consultant Surgeon<br>
                            Dr. Fazlul Haque Colorectal Hospital Ltd.
                        </p>

                        <h5 class="section-title">About the Doctor</h5>
                        <p>
                            Dr. Sakib Sarwat Haque is a skilled consultant surgeon with advanced training
                            in general and colorectal surgery. He is committed to delivering safe,
                            evidence-based, and patient-centered surgical care.
                        </p>

                        <p>
                            He is currently serving at Dr. Fazlul Haque Colorectal Hospital Ltd.,
                            where he is involved in both elective and emergency surgical procedures.
                        </p>

                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
