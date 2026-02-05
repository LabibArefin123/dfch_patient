@extends('frontend.layouts.app')

<link rel="stylesheet" href="{{ asset('css/frontend/facility/page_2_icu.css') }}">

@section('title', 'Intensive Care Unit (ICU) | Dr. Fazlul Haque Colorectal Hospital Limited')
@section('content')
    @include('frontend.welcome_page.header')
    <section class="facility-page bg-white">
        <div class="container">
            <!-- Breadcrumb -->
            <div class="facility-breadcrumb">
                <a href="{{ route('welcome') }}" class="dev-link">Home</a>
                <span>/</span>
                <span>Intensive Care Unit (ICU)</span>
            </div>

            <div class="facility-content">
                <!-- LEFT CONTENT -->
                <div class="facility-text">
                    <h1>Intensive Care Unit (ICU)</h1>

                    <p class="facility-intro">
                        Our Intensive Care Unit (ICU) is a world-class facility designed to provide
                        comprehensive and continuous care for critically ill patients. With seven
                        fully equipped beds, the ICU ensures round-the-clock monitoring and rapid
                        medical intervention in a controlled and sterile environment.
                    </p>

                    <h3>Critical Care Facilities</h3>
                    <ul class="facility-list">
                        <li>Seven dedicated ICU beds with advanced life-support systems</li>
                        <li>Ventilators and continuous cardiac monitoring at each bed</li>
                        <li>Centralized medical gas supply system</li>
                        <li>Syringe pumps and infusion pumps for precise medication delivery</li>
                        <li>Central air conditioning ensuring optimal patient comfort</li>
                    </ul>

                    <h3>High Standards & Continuous Improvement</h3>
                    <p>
                        Our ICU is regularly upgraded with the latest medical equipment and best
                        clinical practices. Monthly seminars, multidisciplinary board discussions,
                        and ongoing staff training ensure adherence to the highest standards of
                        critical care medicine.
                    </p>

                    <h3>Specialist ICU Care</h3>
                    <p>
                        A dedicated team of experienced physicians, intensivists, nurses, and
                        support staff work collaboratively to deliver reliable, high-quality care.
                        Our team is committed to managing life-threatening conditions that require
                        constant observation, rapid response, and advanced medical support.
                    </p>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="facility-image">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/icu.jpeg') }}" alt="Intensive Care Unit"
                        class="facility-img magnify-img">
                </div>
            </div>
        </div>
    </section>
    @include('frontend.welcome_page.footer')
@endsection
