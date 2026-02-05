@extends('frontend.layouts.app')

@section('title', 'Emergency Department | Dr. Fazlul Haque Colorectal Hospital Limited')


<link rel="stylesheet" href="{{ asset('css/frontend/facility/page_1_emergency.css') }}">

@section('content')
@include('frontend.welcome_page.header')
<section class="facility-page bg-white">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="facility-breadcrumb">
            <a href="{{ route('welcome') }}">Home</a>
            <span>/</span>
            <span>Emergency Department</span>
        </div>

        <div class="facility-content">
            <!-- LEFT CONTENT -->
            <div class="facility-text">
                <h1>Emergency Department</h1>

                <p class="facility-intro">
                    Our Emergency Department operates 24 hours a day, providing immediate and
                    life-saving medical care for patients of all ages. We are fully equipped to
                    handle critical illnesses, trauma cases, and medical emergencies with speed,
                    precision, and compassion.
                </p>

                <h3>We Are Offering</h3>
                <ul class="facility-list">
                    <li>Individual emergency beds with continuous patient monitoring</li>
                    <li>Central medical gas supply system</li>
                    <li>Advanced ECG monitoring and cardiac life-support equipment</li>
                    <li>Defibrillators and emergency resuscitation facilities</li>
                    <li>Fully sterilized emergency treatment and procedure area</li>
                </ul>

                <h3>Specialized Emergency Team</h3>
                <p>
                    Our department is staffed by highly trained professionals, including
                    full-time emergency physicians, physician assistants, and registered nurses.
                    All staff members are certified in advanced life support and emergency response
                    protocols to ensure rapid and effective patient care.
                </p>

                <p>
                    With rapid triage, modern technology, and a patient-focused approach, our
                    Emergency Department ensures timely diagnosis, stabilization, and treatment
                    during critical moments.
                </p>
            </div>

            <!-- RIGHT IMAGE -->
            <div class="facility-image">
                <!-- You will place image later -->
                <div class="image-placeholder">
                    Emergency Department Image
                </div>
            </div>
        </div>
    </div>
</section>
@include('frontend.welcome_page.footer')
@endsection

