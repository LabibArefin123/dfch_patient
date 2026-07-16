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
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h6>Patient Registrations Distribution</h6>
                                </div>
                                <div class="card-body"><canvas id="patientsPieChartExt"></canvas></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h6>Recommended Patients Trend</h6>
                                </div>
                                <div class="card-body"><canvas id="recommendedBarChartExt"></canvas></div>
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

            monthlyRecommendedPatients: {{ $monthlyRecommendedPatients }}
        };
    </script>

    <script src="{{ asset('js/dashboard_page/dashboard_view_toggle.js') }}"></script>
    <script src="{{ asset('js/dashboard_page/dashboard_charts.js') }}"></script>
    <script src="{{ asset('js/dashboard_page/dashboard.js') }}"></script>

@stop
