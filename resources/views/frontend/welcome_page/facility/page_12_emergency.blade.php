@extends('frontend.layouts.app')    

<link rel="stylesheet" href="{{ asset('css/frontend/facility/page_12_emergency.css') }}">

@section('title', 'Emergency Services | Dr. Fazlul Haque Colorectal Hospital Limited')

@section('content')
    @include('frontend.welcome_page.header')

    <section class="facility-page bg-white">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="facility-breadcrumb">
                <a href="{{ route('welcome') }}" class="dev-link">Home</a>
                <span>/</span>
                <span>Emergency Services</span>
            </div>

            <div class="facility-content">

                <!-- LEFT CONTENT -->
                <div class="facility-text">
                    <h1>Emergency Services</h1>

                    <p class="facility-intro">
                        Our Emergency Department provides swift and professional medical assistance
                        around the clock. Equipped with advanced life-support systems and staffed
                        by experienced physicians and nurses, we ensure prompt and effective care
                        for patients in urgent need.
                    </p>

                    <h3>24/7 Medical Readiness</h3>
                    <ul class="facility-list">
                        <li>Immediate assessment and triage of patients</li>
                        <li>Advanced resuscitation and critical care equipment</li>
                        <li>Continuous monitoring and rapid intervention for emergencies</li>
                    </ul>

                    <h3>Expert Staff & Patient Care</h3>
                    <p>
                        Our emergency team is trained to handle diverse medical and surgical
                        emergencies efficiently. Round-the-clock availability ensures that
                        patients receive timely attention and the highest quality of care,
                        any time of day or night.
                    </p>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="facility-image">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/ambulance.jpeg') }}" alt="Emergency Services"
                        class="facility-img">
                </div>

            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
