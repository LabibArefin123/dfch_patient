@extends('frontend.layouts.app')

<link rel="stylesheet" href="{{ asset('css/frontend/facility/page_7_laboratory.css') }}">

@section('title', 'Laboratory Services | Dr. Fazlul Haque Colorectal Hospital Limited')

@section('content')
    @include('frontend.welcome_page.header')

    <section class="facility-page bg-white">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="facility-breadcrumb">
                <a href="{{ route('welcome') }}" class="dev-link">Home</a>
                <span>/</span>
                <span>Laboratory Services</span>
            </div>

            <div class="facility-content">

                <!-- LEFT CONTENT -->
                <div class="facility-text">
                    <h1>Laboratory Services</h1>

                    <p class="facility-intro">
                        Our laboratory is equipped with advanced diagnostic technology and
                        staffed by skilled professionals to deliver accurate, timely, and
                        reliable test results. We support clinical decision-making through
                        comprehensive diagnostic services conducted under strict quality
                        standards.
                    </p>

                    <h3>Comprehensive Diagnostic Testing</h3>
                    <ul class="facility-list">
                        <li>Hematology testing for blood disorders and routine analysis</li>
                        <li>Biochemistry testing for metabolic and organ function assessment</li>
                        <li>Immunology and serology for infection and immune response evaluation</li>
                        <li>Clinical pathology services supporting diverse diagnostic needs</li>
                    </ul>

                    <h3>Advanced Laboratory Equipment</h3>
                    <ul class="facility-list">
                        <li>Automated biochemistry and hematology analyzers</li>
                        <li>Blood gas analyzers for critical care diagnostics</li>
                        <li>Biosafety cabinets ensuring safe sample handling</li>
                        <li>High-technology blood culture machines</li>
                        <li>Automated tissue processors for precise histopathology preparation</li>
                    </ul>

                    <h3>Quality Control & Accuracy</h3>
                    <p>
                        Our laboratory follows strict standardization protocols and rigorous
                        quality control measures at every stage of testing. Continuous monitoring,
                        calibration, and adherence to international best practices ensure
                        dependable and accurate diagnostic results for optimal patient care.
                    </p>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="facility-image">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/laboratory.jpeg') }}"
                        alt="Laboratory Services"
                        class="facility-img magnify-img">
                </div>

            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
