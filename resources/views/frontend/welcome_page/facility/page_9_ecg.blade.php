@extends('frontend.layouts.app')

<link rel="stylesheet" href="{{ asset('css/frontend/facility/page_9_ecg.css') }}">

@section('title', 'ECG Services | Dr. Fazlul Haque Colorectal Hospital Limited')

@section('content')
    @include('frontend.welcome_page.header')

    <section class="facility-page bg-white">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="facility-breadcrumb">
                <a href="{{ route('welcome') }}" class="dev-link">Home</a>
                <span>/</span>
                <span>ECG Services</span>
            </div>

            <div class="facility-content">

                <!-- LEFT CONTENT -->
                <div class="facility-text">
                    <h1>ECG Services</h1>

                    <p class="facility-intro">
                        We use world-class GE MAC 5 ECG machines to deliver accurate and reliable
                        cardiac diagnostics for both adult and pediatric patients. Our ECG
                        services are designed to support timely clinical decisions across
                        multiple departments within the hospital.
                    </p>

                    <h3>Advanced ECG Technology</h3>
                    <ul class="facility-list">
                        <li>Four units of GE MAC 5 ECG machines</li>
                        <li>Portable devices supporting 3-lead, 6-lead, and 12-lead ECG recordings</li>
                        <li>High-quality digital signal acquisition for precise interpretation</li>
                    </ul>

                    <h3>Flexible & Multi-Location Use</h3>
                    <p>
                        These portable ECG machines are used across various clinical areas,
                        including the dedicated ECG room, indoor patient floors, and the
                        Intensive Care Unit (ICU). This mobility allows rapid cardiac assessment
                        at the patient’s bedside whenever required.
                    </p>

                    <h3>Accurate Diagnosis & Patient Safety</h3>
                    <p>
                        Operated by trained medical professionals, our ECG services follow
                        standardized protocols to ensure accuracy, consistency, and patient
                        safety. The use of advanced GE technology supports reliable cardiac
                        monitoring and diagnosis as part of comprehensive patient care.
                    </p>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="facility-image">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/ecg.jpeg') }}" alt="ECG Services"
                        class="facility-img">
                </div>

            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
