@extends('frontend.layouts.app')

<link rel="stylesheet" href="{{ asset('css/frontend/facility/page_8_radiology.css') }}">

@section('title', 'Radiology & Imaging | Dr. Fazlul Haque Colorectal Hospital Limited')

@section('content')
    @include('frontend.welcome_page.header')

    <section class="facility-page bg-white">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="facility-breadcrumb">
                <a href="{{ route('welcome') }}" class="dev-link">Home</a>
                <span>/</span>
                <span>Radiology & Imaging</span>
            </div>

            <!-- TOP IMAGES -->
            <div class="facility-top-images">
                <img src="{{ asset('uploads/images/welcome_page/facilities/xray.jpeg') }}"
                    alt="Radiology Room" class="top-img magnify-img">
                <img src="{{ asset('uploads/images/welcome_page/facilities/radio.jpeg') }}"
                    alt="Imaging Room" class="top-img magnify-img">
            </div>

            <div class="facility-content">

                <!-- LEFT CONTENT -->
                <div class="facility-text">
                    <h1>Radiology & Imaging</h1>

                    <p class="facility-intro">
                        Our Radiology and Imaging Department is equipped with state-of-the-art
                        diagnostic technology to support accurate, timely, and comprehensive
                        medical evaluation. Advanced imaging systems combined with expert
                        professionals ensure reliable diagnostic services for optimal patient care.
                    </p>

                    <h3>State-of-the-Art Imaging Technology</h3>
                    <ul class="facility-list">
                        <li>1000 mA digital X-ray system with fluoroscopy</li>
                        <li>2D, 3D, and 4D ultrasonography with color Doppler facilities</li>
                        <li>Portable digital X-ray units for bedside imaging</li>
                    </ul>

                    <h3>Advanced Diagnostic Equipment</h3>
                    <ul class="facility-list">
                        <li>Latest digital imaging technologies for high-resolution diagnostics</li>
                        <li>Modern image processing and reporting systems</li>
                        <li>Comprehensive imaging support across clinical specialties</li>
                    </ul>

                    <h3>Expert Care & Accurate Reporting</h3>
                    <p>
                        Our department is staffed by fully qualified radiologists and trained
                        technologists who provide personalized patient care and precise diagnostic
                        reporting. Every examination follows strict quality protocols to ensure
                        accuracy, safety, and patient comfort throughout the imaging process.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
