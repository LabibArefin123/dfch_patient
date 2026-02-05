@extends('frontend.layouts.app')

<link rel="stylesheet" href="{{ asset('css/frontend/facility/page_3_ot.css') }}">

@section('title', 'Operation Theater (OT) | Dr. Fazlul Haque Colorectal Hospital Limited')

@section('content')
    @include('frontend.welcome_page.header')

    <section class="facility-page bg-white">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="facility-breadcrumb">
                <a href="{{ route('welcome') }}" class="dev-link">Home</a>
                <span>/</span>
                <span>Operation Theater (OT)</span>
            </div>

            <div class="facility-content">

                <!-- LEFT CONTENT -->
                <div class="facility-text">
                    <h1>Operation Theater (OT)</h1>

                    <p class="facility-intro">
                        Our Operation Theaters are designed to meet the highest standards of
                        surgical safety, precision, and infection control. With four fully
                        equipped operation theaters, we ensure a sterile, technologically
                        advanced environment for a wide range of surgical procedures.
                    </p>

                    <h3>Advanced Surgical Infrastructure</h3>
                    <ul class="facility-list">
                        <li>Overhead double dome LED multicolor surgical lighting for optimal visibility</li>
                        <li>Hermetic touchless sensor-based automatic doors</li>
                        <li>HVAC air conditioning with controlled temperature and humidity</li>
                        <li>High-efficiency ventilation system ensuring sterile airflow</li>
                    </ul>

                    <h3>Specialized Surgical Equipment</h3>
                    <ul class="facility-list">
                        <li>State-of-the-art laparoscopic surgical systems</li>
                        <li>Advanced colonoscopy and endoscopic equipment</li>
                        <li>Modern anesthesia workstations and patient monitoring systems</li>
                        <li>Precision surgical instruments for complex colorectal procedures</li>
                    </ul>

                    <h3>Safety, Hygiene & Power Backup</h3>
                    <p>
                        A dedicated automatic scrub area adjacent to each operation theater
                        ensures strict hygiene compliance for surgeons, nurses, and OT staff.
                        To guarantee uninterrupted surgical services, the OT complex is
                        supported by multiple power backup systems, including a Central UPS,
                        a 670 KVA main generator, and a dedicated 100 KVA generator exclusively
                        for operation theaters.
                    </p>
                </div>

                <!-- RIGHT IMAGE -->
                <div class="facility-image">
                    <img src="{{ asset('uploads/images/welcome_page/facilities/ot.jpeg') }}" alt="Operation Theater"
                        class="facility-img">
                </div>

            </div>
        </div>
    </section>

    @include('frontend.welcome_page.footer')
@endsection
