@extends('frontend.layouts.app')

<link rel="stylesheet" href="{{ asset('css/frontend/facility/page_10_colonoscopy.css') }}">

@section('title', 'Colonoscopy Services | Dr. Fazlul Haque Colorectal Hospital Limited')

@section('content')
    @include('frontend.welcome_page.header')

    <section class="facility-page bg-white">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="facility-breadcrumb">
                <a href="{{ route('welcome') }}" class="dev-link">Home</a>
                <span>/</span>
                <span>Colonoscopy Services</span>
            </div>

            <div class="facility-content">

                <!-- LEFT CONTENT -->
                <div class="facility-text">
                    <h1>Colonoscopy Services</h1>

                    <p class="facility-intro">
                        Our hospital offers advanced colonoscopy services using world-class
                        Olympus colonoscopy systems. These modern diagnostic tools enable
                        accurate visualization of the colon and rectum, supporting early
                        detection and effective management of colorectal conditions.
                    </p>

                    <h3>Advanced Diagnostic Procedures</h3>
                    <ul class="facility-list">
                        <li>Two state-of-the-art Olympus colonoscopy machines</li>
                        <li>High-definition imaging for detailed visualization</li>
                        <li>Advanced technology for detecting abnormalities in the colon and rectum</li>
                    </ul>

                    <h3>Expert Medical Care</h3>
                    <p>
                        Colonoscopy procedures are performed by highly trained and certified
                        physicians with extensive experience in gastrointestinal diagnostics.
                        All examination reports are carefully evaluated and validated by
                        post-graduate specialist doctors to ensure diagnostic accuracy and
                        reliable clinical decision-making.
                    </p>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="facility-image">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/colonoscopy.jpeg') }}"
                        alt="Colonoscopy Services"
                        class="facility-img magnify-img">
                </div>

            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
