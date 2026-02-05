@extends('frontend.layouts.app')

<link rel="stylesheet" href="{{ asset('css/frontend/facility/page_5_ward.css') }}">

@section('title', 'General Ward | Dr. Fazlul Haque Colorectal Hospital Limited')

@section('content')
    @include('frontend.welcome_page.header')

    <section class="facility-page bg-white">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="facility-breadcrumb">
                <a href="{{ route('welcome') }}" class="dev-link">Home</a>
                <span>/</span>
                <span>General Ward</span>
            </div>

            <div class="facility-content">

                <!-- LEFT CONTENT -->
                <div class="facility-text">
                    <h1>General Ward</h1>

                    <p class="facility-intro">
                        Our General Ward is designed to provide a comfortable, safe, and
                        supportive environment for patients requiring hospital care with
                        continuous nursing supervision. The ward combines modern facilities
                        with patient-focused amenities to ensure a smooth recovery experience.
                    </p>

                    <h3>Patient Comfort & Care</h3>
                    <ul class="facility-list">
                        <li>Eight standard beds equipped with world-class Japanese hospital beds</li>
                        <li>Adjustable lighting and centrally air-conditioned environment</li>
                        <li>Comfort-focused layout promoting rest and recovery</li>
                    </ul>

                    <h3>Essential Amenities</h3>
                    <ul class="facility-list">
                        <li>Individual bedside lockers for patient belongings</li>
                        <li>Over-bed tables for meals, reading, and personal use</li>
                        <li>Centralized medical gas supply lines for clinical support</li>
                    </ul>

                    <h3>Nursing Support & Safety</h3>
                    <p>
                        Each bed is integrated with a nurse call system that provides instant
                        notification to the nursing station, ensuring prompt assistance at
                        any time. Our trained nursing staff remain readily available to
                        respond to patient needs, reinforcing safety and reassurance
                        throughout the hospital stay.
                    </p>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="facility-image">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/ward.jpeg') }}" alt="General Ward"
                        class="facility-img">
                </div>

            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
