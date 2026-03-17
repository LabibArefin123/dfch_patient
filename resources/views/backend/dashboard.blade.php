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

        {{-- Toggle Switch --}}
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
                    <div class="tab-pane active" id="normalView">
                        <div class="row">

                            {{-- Patient Stats 4x4 layout --}}
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $totalPatients }}" text="Total Patients" theme="info"
                                    icon="fas fa-users" url="{{ route('patients.index') }}" />
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $todayPatients }}" text="Registered Today" theme="light"
                                    icon="fas fa-calendar-day"
                                    url="{{ route('patients.index', ['date_filter' => 'today']) }}" />
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $weeklyPatients }}" text="This Week" theme="primary"
                                    icon="fas fa-calendar-week"
                                    url="{{ route('patients.index', ['date_filter' => 'last_7_days']) }}" />
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $monthlyPatients }}" text="This Month" theme="secondary"
                                    icon="fas fa-calendar-alt"
                                    url="{{ route('patients.index', ['date_filter' => 'this_month']) }}" />
                            </div>

                            {{-- Recommended Patients --}}
                            <div class="col-12 mt-3">
                                <hr>
                                <h5 class="text-info font-weight-bold">⭐ Recommended Patients Overview</h5>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $totalRecommendedPatients }}" text="Total Recommended"
                                    theme="danger" icon="fas fa-user-md"
                                    url="{{ route('patients.recommend', ['is_recommend' => 1]) }}" />
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $todayRecommendedPatients }}" text="Today's Recommended"
                                    theme="warning" icon="fas fa-stethoscope"
                                    url="{{ route('patients.recommend', ['is_recommend' => 1, 'date_filter' => 'today']) }}" />
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $monthlyRecommendedPatients }}" text="Monthly Recommended"
                                    theme="success" icon="fas fa-chart-line"
                                    url="{{ route('patients.recommend', ['is_recommend' => 1, 'date_filter' => 'this_month']) }}" />
                            </div>

                        </div>
                    </div>

                    {{-- Statistical View Tab --}}
                    <div class="tab-pane" id="statisticalView">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h6>Patient Registrations Distribution</h6>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="patientsPieChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h6>Recommended Patients Trend</h6>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="recommendedBarChart"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Detailed Stats --}}
                        <div class="row mt-4">
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $totalPatients }}" text="Total Patients" theme="info"
                                    icon="fas fa-users" />
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $todayPatients }}" text="Registered Today" theme="light"
                                    icon="fas fa-calendar-day" />
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $weeklyPatients }}" text="This Week" theme="primary"
                                    icon="fas fa-calendar-week" />
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $monthlyPatients }}" text="This Month" theme="secondary"
                                    icon="fas fa-calendar-alt" />
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $totalRecommendedPatients }}" text="Total Recommended"
                                    theme="danger" icon="fas fa-user-md" />
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $todayRecommendedPatients }}" text="Today's Recommended"
                                    theme="warning" icon="fas fa-stethoscope" />
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <x-adminlte-small-box title="{{ $monthlyRecommendedPatients }}"
                                    text="Monthly Recommended" theme="success" icon="fas fa-chart-line" />
                            </div>
                        </div>

                    </div>

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
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <x-adminlte-small-box title="{{ $totalPatients }}" text="Total Patients"
                                        theme="info" icon="fas fa-users" />
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <x-adminlte-small-box title="{{ $todayPatients }}" text="Registered Today"
                                        theme="light" icon="fas fa-calendar-day" />
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <x-adminlte-small-box title="{{ $weeklyPatients }}" text="This Week" theme="primary"
                                        icon="fas fa-calendar-week" />
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <x-adminlte-small-box title="{{ $monthlyPatients }}" text="This Month"
                                        theme="secondary" icon="fas fa-calendar-alt" />
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <x-adminlte-small-box title="{{ $totalRecommendedPatients }}"
                                        text="Total Recommended" theme="danger" icon="fas fa-user-md" />
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <x-adminlte-small-box title="{{ $todayRecommendedPatients }}"
                                        text="Today's Recommended" theme="warning" icon="fas fa-stethoscope" />
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <x-adminlte-small-box title="{{ $monthlyRecommendedPatients }}"
                                        text="Monthly Recommended" theme="success" icon="fas fa-chart-line" />
                                </div>
                            </div>
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
        const toggleBtn = document.getElementById('toggleViewBtn');
        const tabs = document.getElementById('dashboardTabs');
        const extended = document.getElementById('extendedView');

        // Set initial state
        let isNormalView = true;
        tabs.style.display = 'block';
        extended.style.display = 'none';

        toggleBtn.addEventListener('click', function() {
            isNormalView = !isNormalView;

            if (isNormalView) {
                tabs.style.display = 'block';
                extended.style.display = 'none';
                toggleBtn.textContent = 'Extended View';
                toggleBtn.classList.remove('btn-success');
                toggleBtn.classList.add('btn-primary');
            } else {
                tabs.style.display = 'none';
                extended.style.display = 'block';
                toggleBtn.textContent = 'Normal View';
                toggleBtn.classList.remove('btn-primary');
                toggleBtn.classList.add('btn-success');
            }
        });

        // Chart.js for tab view
        new Chart(document.getElementById('patientsPieChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Today', 'This Week', 'This Month'],
                datasets: [{
                    data: [{{ $todayPatients }}, {{ $weeklyPatients }}, {{ $monthlyPatients }}],
                    backgroundColor: ['#17a2b8', '#007bff', '#6c757d']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        new Chart(document.getElementById('recommendedBarChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Today', 'This Month'],
                datasets: [{
                    label: 'Recommended Patients',
                    data: [{{ $todayRecommendedPatients }}, {{ $monthlyRecommendedPatients }}],
                    backgroundColor: ['#ffc107', '#28a745']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Chart.js for extended view
        new Chart(document.getElementById('patientsPieChartExt').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Today', 'This Week', 'This Month'],
                datasets: [{
                    data: [{{ $todayPatients }}, {{ $weeklyPatients }}, {{ $monthlyPatients }}],
                    backgroundColor: ['#17a2b8', '#007bff', '#6c757d']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        new Chart(document.getElementById('recommendedBarChartExt').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Today', 'This Month'],
                datasets: [{
                    label: 'Recommended Patients',
                    data: [{{ $todayRecommendedPatients }}, {{ $monthlyRecommendedPatients }}],
                    backgroundColor: ['#ffc107', '#28a745']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@stop
