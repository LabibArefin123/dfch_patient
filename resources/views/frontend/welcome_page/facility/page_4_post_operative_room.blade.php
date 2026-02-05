@extends('frontend.layouts.app')

<link rel="stylesheet" href="{{ asset('css/frontend/facility/page_4_post_op.css') }}">

@section('title', 'Post-Operative Recovery Room | Dr. Fazlul Haque Colorectal Hospital Limited')

@section('content')
    @include('frontend.welcome_page.header')

    <section class="facility-page bg-white">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="facility-breadcrumb">
                <a href="{{ route('welcome') }}" class="dev-link">Home</a>
                <span>/</span>
                <span>Post-Operative Recovery Room</span>
            </div>

            <div class="facility-content">

                <!-- LEFT CONTENT -->
                <div class="facility-text">
                    <h1>Post-Operative Recovery Room</h1>

                    <p class="facility-intro">
                        Our Post-Operative Recovery Rooms are designed to provide a safe,
                        comfortable, and closely monitored environment for patients
                        immediately after surgery. With eighteen advanced beds, the unit
                        supports smooth recovery and rapid medical response when required.
                    </p>

                    <h3>Patient Comfort & Monitoring</h3>
                    <ul class="facility-list">
                        <li>Eighteen Japanese electric beds designed for maximum patient comfort</li>
                        <li>Individual patient monitors at each bed for continuous observation</li>
                        <li>Bedside lockers and medical-grade mattresses for enhanced recovery</li>
                    </ul>

                    <h3>Accessible & Patient-Friendly Design</h3>
                    <ul class="facility-list">
                        <li>Dedicated bathrooms with accessibility features</li>
                        <li>Supportive amenities for patients with mobility or balance limitations</li>
                        <li>Calm, hygienic, and well-ventilated recovery environment</li>
                    </ul>

                    <h3>Nursing Control & Emergency Readiness</h3>
                    <p>
                        The unit operates under full nursing supervision with extensive
                        treatment facilities, including centralized medical gas lines,
                        high-speed internet access, and central air conditioning.
                        In case of emergency, any bed can be rapidly converted into an ICU-level
                        setup, ensuring immediate advanced care without patient relocation.
                    </p>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="facility-image">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/post-op.jpeg') }}"
                        alt="Post-Operative Recovery Room" class="facility-img magnify-img">
                </div>

            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
