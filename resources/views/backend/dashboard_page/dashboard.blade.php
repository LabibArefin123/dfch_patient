@extends('adminlte::page')

@section('title', 'DFCH | Patient Dashboard')
@section('plugins.Chartjs', true)

@section('content')
    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="mb-4">
            <h1 class="text-2xl font-weight-bold text-primary">
                Dr. Fazlul Haque Colorectal Hospital
            </h1>
            <p class="text-muted">
                Patient Registration Overview & Reporting Dashboard
            </p>
        </div>

        {{-- Toggle Button --}}
        <div class="mb-3 d-flex justify-content-end">
            <button id="toggleViewBtn" class="btn btn-primary">
                Extended View
            </button>
        </div>

        {{-- Dashboard Tabs --}}
        <div id="dashboardTabs" class="card shadow-sm mb-4">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#normalView" data-toggle="tab">Normal View</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#statisticalView" data-toggle="tab">Statistical View</a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    {{-- Normal View Tab --}}
                    @include('backend.dashboard_page.normal_view.normal_tab.tab_1')
                    {{-- Statistical View Tab --}}
                    @include('backend.dashboard_page.normal_view.statistic_tab.tab_2')
                </div>
            </div>
        </div>

        {{-- Extended View: Merge Normal + Statistical --}}
        <div id="extendedView" style="display: none;">
            <div class="row">
                {{-- Normal Stats --}}
                <div class="col-12">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            {{-- TOTAL PATIENT PART --}}
                            @include('backend.dashboard_page.extended_view.part_1')
                            {{-- TOTAL RECOMMENDED PATIENT PART --}}
                            @include('backend.dashboard_page.extended_view.part_2')
                            {{-- TOTAL EMERGENCY PATIENT PART --}}
                            @include('backend.dashboard_page.extended_view.part_3')
                            {{-- TOTAL CANCER PATIENT PART --}}
                            @include('backend.dashboard_page.extended_view.part_4')
                        </div>
                    </div>
                </div>

                {{-- Statistical Charts --}}
                <div class="col-12">

                    {{-- =========================
        Patient Overview
    ========================== --}}
                    <div class="d-flex align-items-center mb-3">

                        <div>
                            <h5 class="font-weight-bold mb-0">
                                <i class="fas fa-chart-pie text-primary mr-2"></i>
                                Patient Analytics
                            </h5>

                            <small class="text-muted">
                                Overview of patient registrations and recommendations
                            </small>
                        </div>

                    </div>


                    <div class="row">

                        {{-- Patient Registrations --}}
                        <div class="col-lg-6 mb-4">

                            <div class="card shadow-sm h-100">

                                <div class="card-header bg-white border-0">

                                    <div class="d-flex align-items-center">

                                        <div class="mr-3">
                                            <i class="fas fa-user-plus text-primary fa-lg"></i>
                                        </div>

                                        <div>
                                            <h6 class="font-weight-bold mb-0">
                                                Patient Registrations
                                            </h6>

                                            <small class="text-muted">
                                                Registration distribution by period
                                            </small>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-body">

                                    <div style="height: 300px;">
                                        <canvas id="patientsPieChartExt"></canvas>
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Recommended Patients --}}
                        <div class="col-lg-6 mb-4">

                            <div class="card shadow-sm h-100">

                                <div class="card-header bg-white border-0">

                                    <div class="d-flex align-items-center">

                                        <div class="mr-3">
                                            <i class="fas fa-user-md text-success fa-lg"></i>
                                        </div>

                                        <div>
                                            <h6 class="font-weight-bold mb-0">
                                                Recommended Patients
                                            </h6>

                                            <small class="text-muted">
                                                Patient recommendation activity
                                            </small>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-body">

                                    <div style="height: 300px;">
                                        <canvas id="recommendedBarChartExt"></canvas>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =========================
        Emergency & Cancer Analytics
    ========================== --}}

                    <div class="d-flex align-items-center mt-3 mb-3">

                        <div>
                            <h5 class="font-weight-bold mb-0">
                                <i class="fas fa-chart-line text-danger mr-2"></i>
                                Medical History Analytics
                            </h5>

                            <small class="text-muted">
                                Emergency and cancer patient history overview
                            </small>
                        </div>

                    </div>


                    <div class="row">

                        {{-- Emergency History --}}
                        <div class="col-lg-6 mb-4">

                            <div class="card shadow-sm h-100">

                                <div class="card-header bg-white border-0">

                                    <div class="d-flex align-items-center">

                                        <div class="mr-3">
                                            <i class="fas fa-ambulance text-warning fa-lg"></i>
                                        </div>

                                        <div>
                                            <h6 class="font-weight-bold mb-0">
                                                Emergency Patient History
                                            </h6>

                                            <small class="text-muted">
                                                Emergency history by period
                                            </small>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-body">

                                    <div style="height: 300px;">
                                        <canvas id="emergencyHistoryChartExt"></canvas>
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Cancer History --}}
                        <div class="col-lg-6 mb-4">

                            <div class="card shadow-sm h-100">

                                <div class="card-header bg-white border-0">

                                    <div class="d-flex align-items-center">

                                        <div class="mr-3">
                                            <i class="fas fa-ribbon text-danger fa-lg"></i>
                                        </div>

                                        <div>
                                            <h6 class="font-weight-bold mb-0">
                                                Cancer Patient History
                                            </h6>

                                            <small class="text-muted">
                                                Cancer history by period
                                            </small>
                                        </div>

                                    </div>

                                </div>

                                <div class="card-body">

                                    <div style="height: 300px;">
                                        <canvas id="cancerHistoryChartExt"></canvas>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
@stop
@section('js')
    <script>
        window.dashboardData = {
            todayPatients: {{ $todayPatients }},
            weeklyPatients: {{ $weeklyPatients }},
            monthlyPatients: {{ $monthlyPatients }},
            todayRecommendedPatients: {{ $todayRecommendedPatients }},
            monthlyRecommendedPatients: {{ $monthlyRecommendedPatients }},
            todayEmergencyPatientHistory: {{ $todayEmergencyPatientHistory }},
            weeklyEmergencyPatientHistory: {{ $weeklyEmergencyPatientHistory }},
            monthlyEmergencyPatientHistory: {{ $monthlyEmergencyPatientHistory }},
            todayCancerPatientHistory: {{ $todayCancerPatientHistory }},
            weeklyCancerPatientHistory: {{ $weeklyCancerPatientHistory }},
            monthlyCancerPatientHistory: {{ $monthlyCancerPatientHistory }}
        };
    </script>

    <script src="{{ asset('js/backend/dashboard_page/dashboard_view_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/dashboard_page/dashboard_cancer.js') }}"></script>
    <script src="{{ asset('js/backend/dashboard_page/dashboard_emergency.js') }}"></script>
    <script src="{{ asset('js/backend/dashboard_page/dashboard_charts.js') }}"></script>
    <script src="{{ asset('js/backend/dashboard_page/dashboard.js') }}"></script>

@stop
