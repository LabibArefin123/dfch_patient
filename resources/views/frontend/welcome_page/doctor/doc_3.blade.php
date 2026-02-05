@extends('frontend.layouts.app')

@section('title', 'Dr. Fatema Sharmin (Anny) | DFCH')
<link rel="stylesheet" href="{{ asset('css/doctor/doc_3.css') }}">

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
                    <a href="{{ route('doc_3') }}" class="doc-link text-decoration-none">
                        Dr. Fatema Sharmin (Anny)
                    </a>
                </nav>
            </div>

            <div class="doctor-card">
                <div class="row align-items-start">

                    <!-- Image + Book Now -->
                    <div class="col-md-5 mb-4 mb-md-0">
                        <div class="doctor-image">
                            <img src="{{ asset('uploads/images/welcome_page/doctors/image_3.jpg') }}"
                                 alt="Dr. Fatema Sharmin (Anny)">

                            <a href="#" class="book-btn">Book Now</a>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="col-md-7">
                        <h2 class="doctor-name">Dr. Fatema Sharmin (Anny)</h2>

                        <p class="doctor-degree">
                            MBBS, DA, FCPS (Final Part)
                        </p>

                        <p class="doctor-designation">
                            Consultant (Anesthesiology)<br>
                            Dr. Fazlul Haque Colorectal Hospital Limited
                        </p>

                        <p class="doctor-designation">
                            Junior Consultant (Anesthesiology)<br>
                            Bangladesh Medical College Hospital, Dhanmondi
                        </p>

                        <h5 class="section-title">About the Doctor</h5>
                        <p>
                            Dr. Fatema Sharmin (Anny) is a dedicated anesthesiology consultant with
                            experience in managing anesthesia for a wide range of surgical procedures.
                            She is known for her professionalism, patient-focused care, and commitment
                            to maintaining the highest standards of safety.
                        </p>

                        <p>
                            She is currently serving at Dr. Fazlul Haque Colorectal Hospital Limited
                            and also works as a Junior Consultant at Bangladesh Medical College Hospital,
                            Dhanmondi.
                        </p>

                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
