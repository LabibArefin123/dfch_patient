@extends('frontend.layouts.app')

<link rel="stylesheet" href="{{ asset('css/frontend/facility/page_6_private_cabin.css') }}">

@section('title', 'Private Cabin | Dr. Fazlul Haque Colorectal Hospital Limited')

@section('content')
    @include('frontend.welcome_page.header')

    <section class="facility-page bg-white">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="facility-breadcrumb">
                <a href="{{ route('welcome') }}" class="dev-link">Home</a>
                <span>/</span>
                <span>Private Cabin</span>
            </div>

            <div class="facility-content">

                <!-- LEFT CONTENT -->
                <div class="facility-text">
                    <h1>Private Cabin</h1>

                    <p class="facility-intro">
                        Our hospital offers forty advanced private cabins designed to provide
                        patients with a peaceful, comfortable, and personalized healing
                        environment. Each cabin combines modern medical infrastructure with
                        hotel-like amenities to ensure privacy and relaxation during recovery.
                    </p>

                    <h3>Modern Amenities</h3>
                    <ul class="facility-list">
                        <li>Japanese electric hospital beds for superior comfort and safety</li>
                        <li>Centralized medical gas supply lines at each cabin</li>
                        <li>Central air conditioning with individual comfort control</li>
                        <li>Television and entertainment facilities for patient convenience</li>
                        <li>Extra bed accommodation for attendants</li>
                        <li>Attached modern toilet with hygiene-focused fittings</li>
                    </ul>

                    <h3>Comfort, Privacy & Nursing Support</h3>
                    <p>
                        Each private cabin is thoughtfully designed to ensure tranquility and
                        patient privacy while maintaining continuous clinical oversight.
                        An instant nurse call notification system connects directly to the
                        nursing station for prompt assistance at any time. Select higher-standard
                        cabins also feature private verandas, offering an enhanced recovery
                        experience in a calm and airy setting.
                    </p>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="facility-image">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/cabin.jpg') }}"
                        alt="Private Cabin"
                        class="facility-img">
                </div>

            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
