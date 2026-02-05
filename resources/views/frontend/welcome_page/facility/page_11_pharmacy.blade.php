@extends('frontend.layouts.app')

<link rel="stylesheet" href="{{ asset('css/frontend/facility/page_11_pharmacy.css') }}">

@section('title', 'Hospital Pharmacy | Dr. Fazlul Haque Colorectal Hospital Limited')

@section('content')
    @include('frontend.welcome_page.header')

    <section class="facility-page bg-white">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="facility-breadcrumb">
                <a href="{{ route('welcome') }}" class="dev-link">Home</a>
                <span>/</span>
                <span>Hospital Pharmacy</span>
            </div>

            <div class="facility-content">

                <!-- LEFT CONTENT -->
                <div class="facility-text">
                    <h1>Hospital Pharmacy</h1>

                    <p class="facility-intro">
                        Our hospital pharmacy is dedicated to providing safe, high-quality,
                        and accessible medications for all patients. We emphasize patient safety,
                        accurate dispensing, and comprehensive pharmaceutical care.
                    </p>

                    <h3>Comprehensive Pharmaceutical Care</h3>
                    <ul class="facility-list">
                        <li>Reliable supply of essential and specialized medications</li>
                        <li>Safe handling and storage according to international standards</li>
                        <li>Medication counseling and guidance for patients and staff</li>
                    </ul>

                    <h3>Patient-Focused Services</h3>
                    <p>
                        The pharmacy ensures cost-effective, patient-centered pharmaceutical
                        care, supporting both inpatient and outpatient needs. Our trained
                        pharmacists work closely with the medical team to optimize therapy,
                        promote adherence, and provide timely information to patients and staff.
                    </p>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="facility-image">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/Pharmacy.jpeg') }}"
                        alt="Hospital Pharmacy"
                        class="facility-img magnify-img">
                </div>

            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
