@extends('adminlte::page')

@section('title', 'Dashboard | BidTrack Software')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">BidTrack Dashboard</h1>
        <small>Tender Participation Record Management System</small>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show custom-alert shadow-sm position-relative mb-3"
            role="alert">
            <button type="button" class="custom-close-btn"
                onclick="this.parentElement.style.opacity='0'; setTimeout(() => this.parentElement.remove(), 300);"
                aria-label="Close">&times;</button>

            {{-- Icon moved downward --}}
            <div class="position-absolute end-0 me-4 mb-2 bottom-0">
                <i class="fas fa-check-circle text-success fs-4"></i>
            </div>

            {{ session('success') }}
        </div>
    @endif

    @php
        $groupedNotifications = collect($notifications)->groupBy('type');
    @endphp

    @if ($groupedNotifications->isNotEmpty())
        <div class="position-fixed" style="bottom: 1rem; right: 1rem; z-index: 1050; max-width: 400px; width: 100%;">
            @foreach ($groupedNotifications as $type => $notes)
                @php
                    $firstNote = $notes->first();
                    $count = $notes->count();

                    $redirectUrl = match ($type) {
                        'bg', 'pg' => route('bg_pg.index'),
                        'awarded_notification' => route('awarded_tenders.index'),
                        'follow_up', 'lead_to' => route('tenders.index'),
                        default => route('participated_tenders.index', [$firstNote['tender_id']]),
                    };

                    $borderClass = match ($type) {
                        'bg' => 'border-danger',
                        'pg' => 'border-danger',
                        'awarded_notification' => 'border-danger',
                        'follow_up' => 'border-danger',
                        'lead_to' => 'border-danger',
                        default => 'border-danger',
                    };

                    $typeText = match ($type) {
                        'bg' => 'day(s) remaining for Bid Guarantee (BG). Please pay it soon!',
                        'pg' => 'day(s) remaining for Performance Guarantee (PG). Please pay it soon!',
                        'awarded_notification' => 'day(s) left to process award. Please fill up awarded details!',
                        'follow_up' => 'day(s) remaining for follow-up task!',
                        'lead_to' => 'day(s) left to convert the lead!',
                        default => 'day(s) remaining before expiry.',
                    };

                    $trailingText = match ($type) {
                        'bg' => 'from Bid Guarantee (BG) page',
                        'pg' => 'from Performance Guarantee (PG) page',
                        'awarded_notification' => 'from Awarded Tenders page',
                        'follow_up' => 'from Tender Follow-Up page',
                        'lead_to' => 'from Lead Conversion page',
                        default => 'from Tender  page',
                    };

                    $iconClass = match ($type) {
                        'bg' => 'fas fa-shield-alt text-primary',
                        'pg' => 'fas fa-file-signature text-success',
                        'awarded_notification' => 'fas fa-award text-warning',
                        'follow_up' => 'fas fa-calendar-check text-danger',
                        'lead_to' => 'fas fa-flag text-dark',
                        default => 'fas fa-hourglass-half text-info',
                    };

                    $badge = $count > 1 ? "+$count" : '';
                @endphp

                <div class="alert alert-light border-start {{ $borderClass }} border-4 shadow-sm alert-dismissible fade show custom-alert mb-3 position-relative"
                    role="alert" style="cursor: pointer; transition: opacity 0.3s ease-in-out;"
                    onclick="window.location.href='{{ $redirectUrl }}';">

                    {{-- Close Button --}}
                    <button type="button" class="custom-close-btn"
                        onclick="event.stopPropagation(); this.closest('.custom-alert').style.opacity='0'; setTimeout(() => this.closest('.custom-alert').remove(), 300);"
                        aria-label="Close">&times;</button>

                    {{-- Icon aligned bottom right --}}
                    <div class="custom-icon">
                        <i class="{{ $iconClass }} fs-4"></i>
                    </div>

                    {{-- Message --}}
                    <div class="pe-4">
                        <strong>{{ $firstNote['title'] }}</strong>
                        @if ($badge)
                            <span class="badge bg-secondary ms-2">{{ $badge }}</span>
                        @endif
                        <br>

                        @if (in_array($firstNote['days_left'], [15, 7, 3, 2, 1]))
                            <span>
                                <strong>{{ $firstNote['days_left'] }}</strong> {{ $typeText }}
                            </span>
                            <br>
                        @endif

                        <small class="text-muted">Expiry Date: {{ $firstNote['submission_date'] }} —
                            {{ $trailingText }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Close Button & Alert Custom CSS --}}
    <style>
        .custom-close-btn {
            position: absolute;
            top: 0.3rem;
            right: 0.5rem;
            background: transparent;
            border: none;
            font-size: 1.2rem;
            font-weight: bold;
            color: #999;
            line-height: 1;
            cursor: pointer;
            z-index: 20;
        }

        .custom-close-btn:hover {
            color: #000;
            transform: scale(1.1);
        }

        .custom-alert {
            padding-right: 3rem;
            border-radius: 0.5rem;
        }

        .custom-icon {
            position: absolute;
            bottom: 1.8rem;
            /* below close button */
            right: 0.8rem;
            /* z-index: 10; */
        }
    </style>



    <div class="row mt-3">
        {{-- Total Tenders --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-info text-white shadow">
                <div class="inner">
                    <h3>{{ $totalTenders ?? 0 }}</h3>
                    <p>Total Tenders</p>
                </div>
                <div class="icon"><i class="fas fa-clipboard-list"></i></div>
                <a href="{{ route('tenders.index') }}" class="small-box-footer text-white">
                    View All <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- Participated Tenders --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-success text-white shadow">
                <div class="inner">
                    <h3>{{ $totalParticipated ?? 0 }}</h3>
                    <p>Participated Tenders</p>
                </div>
                <div class="icon"><i class="fas fa-vote-yea"></i></div>
                <a href="{{ route('participated_tenders.index') }}" class="small-box-footer text-white">
                    View All <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- BG Expiring --}}
        <div class="col-lg-3 col-6">
            <div class="small-box text-white shadow" style="background-color: #f28b82;">
                <div class="inner">
                    <h3>{{ $totalBGExpiring ?? '—' }}</h3>
                    <p>BG Expiring</p>
                </div>
                <div class="icon"><i class="fas fa-hourglass-end"></i></div>
                <a href="{{ route('bg_pg.index') }}" class="small-box-footer text-white">
                    View All <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


        {{-- Offer Validity Expiring --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-purple shadow-sm border border-purple-600">
                <div class="inner">
                    <h3 class="text-white">{{ $totalOfferValidity }}</h3>
                    <p class="text-white">Offer Validity Expiring</p>
                </div>
                <div class="icon text-white">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <a href="{{ route('participated_tenders.index') }}" class="small-box-footer text-white">
                    View All <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- Awarded Tenders --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-warning text-white shadow">
                <div class="inner">
                    <h3>{{ $totalAwardedTender ?? 0 }}</h3>
                    <p>Awarded Tenders</p>
                </div>
                <div class="icon"><i class="fas fa-trophy"></i></div>
                <a href="{{ route('awarded_tenders.index') }}" class="small-box-footer text-white">
                    View All <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- PG Expiring --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-danger text-white shadow">
                <div class="inner">
                    <h3>{{ $totalPGExpiring ?? '—' }}</h3>
                    <p>PG Expiring</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-times"></i></div>
                <a href="{{ route('bg_pg.index') }}" class="small-box-footer text-white">
                    View All <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- Completed Tenders --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-primary text-white shadow">
                <div class="inner">
                    <h3>{{ $totalCompletedTenders ?? '—' }}</h3>
                    <p>Completed Tenders</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
                <a href="{{ route('completed_tenders.index') }}" class="small-box-footer text-white">
                    View All <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- Archived --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-secondary text-white shadow">
                <div class="inner">
                    <h3>{{ $totalArchivedTenders }}</h3>
                    <p>Archived Tenders</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-times"></i></div>
                <a href="{{ route('archived_tenders.index') }}" class="small-box-footer text-white">
                    View All <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <strong>Tender Progress</strong>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- LEFT TABS -->
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills">
                        <a class="nav-link active" data-toggle="pill" href="#currentTab">Current Progress</a>
                        <a class="nav-link" data-toggle="pill" href="#completedTab">Completed Progress</a>
                    </div>
                </div>

                <!-- RIGHT CONTENT -->
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="currentTab">
                            <canvas id="currentChart" height="100"></canvas>
                            <div id="currentPagination" class="mt-3"></div>
                        </div>

                        <div class="tab-pane fade" id="completedTab">
                            <canvas id="completedChart" height="100"></canvas>
                            <div id="completedPagination" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>


@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof notifications === 'undefined' || !Array.isArray(notifications) || notifications.length ===
                0) {
                return;
            }

            const container = document.getElementById('toast-container');
            let currentIndex = 0;

            function createToast(note) {
                let typeColor = 'bg-info text-white';
                if (note.type === 'bg') typeColor = 'bg-primary text-white';
                else if (note.type === 'pg') typeColor = 'bg-success text-white';

                let daysMsg = '';
                if ([15, 7, 3, 2, 1].includes(note.days_left)) {
                    const isPayment = (note.type === 'bg' || note.type === 'pg');
                    const label = isPayment ? 'remaining. Please pay it soon!' : 'remaining before expiry.';
                    daysMsg = `<strong>${note.days_left} day${note.days_left > 1 ? 's' : ''}</strong> ${label}`;
                }

                let redirectUrl = '/';
                if (note.type === 'bg' || note.type === 'pg') {
                    redirectUrl = "{{ route('bg_pg.index') }}";
                } else {
                    redirectUrl = `{{ route('tenders.edit', '__id__') }}`.replace('__id__', note.tender_id);
                }

                const toastHTML = `
                    <div class="toast align-items-start ${typeColor} border-0 shadow mb-3" role="alert" aria-live="assertive" aria-atomic="true" style="cursor: pointer;">
                        <div class="d-flex">
                            <div class="toast-body">
                                <strong>${note.title}</strong><br>
                                ${daysMsg}<br>
                                <small>Expiry Date: ${note.submission_date}</small>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" aria-label="Close"></button>
                        </div>
                    </div>
                `;

                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = toastHTML.trim();
                const toastEl = tempDiv.firstChild;

                toastEl.addEventListener('click', (e) => {
                    if (!e.target.classList.contains('btn-close')) {
                        window.location.href = redirectUrl;
                    }
                });

                toastEl.querySelector('.btn-close').addEventListener('click', (e) => {
                    e.stopPropagation();
                    const instance = bootstrap.Toast.getOrCreateInstance(toastEl);
                    instance.hide();
                });

                container.appendChild(toastEl);

                return new bootstrap.Toast(toastEl, {
                    delay: 10000 // Toast auto-closes in 10s
                });
            }

            function showNextToast() {
                if (currentIndex >= notifications.length) return;

                const toastInstance = createToast(notifications[currentIndex]);
                toastInstance.show();

                toastInstance._element.addEventListener('hidden.bs.toast', () => {
                    toastInstance._element.remove();
                    currentIndex++;
                    showNextToast();
                });
            }

            showNextToast();
        });
    </script>

    <script>
        const chartData = @json($chartData);
        const PER_PAGE = 4;
        let currentChart, completedChart;

        // Progress calculation
        chartData.forEach(item => {
            const stages = [
                item.is_delivered,
                item.is_inspection_completed,
                item.is_inspection_accepted,
                item.is_bill_submitted,
                item.is_bill_received,
            ];
            item.progress = stages.filter(v => v == 1).length * 20;
        });

        // Split data
        const currentData = chartData.filter(i => i.progress < 100);
        const completedData = chartData.filter(i => i.progress === 100);

        // Progress-based color
        function getColor(progress) {
            if (progress <= 20) return '#dc3545';
            if (progress <= 40) return '#fd7e14';
            if (progress <= 60) return '#ffc107';
            if (progress <= 80) return '#0d6efd';
            return '#198754';
        }

        // Render chart
        function renderChart(canvasId, data, page, paginationId, existingChart) {
            const start = (page - 1) * PER_PAGE;
            const items = data.slice(start, start + PER_PAGE);

            const labels = items.map(i => i.tender_name);
            const values = items.map(i => i.progress);
            const colors = items.map(i => getColor(i.progress));

            if (existingChart) existingChart.destroy();

            const ctx = document.getElementById(canvasId);
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Progress (%)',
                        data: values,
                        backgroundColor: colors
                    }]
                },
                options: {
                    responsive: true,
                    onClick(evt, elements) {
                        if (elements.length) {
                            const index = elements[0].index;
                            window.location = `/tender_progress/${items[index].id}`;
                        }
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Progress (%)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tender'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => `Progress: ${ctx.raw}%`
                            }
                        }
                    }
                }
            });

            renderPagination(data.length, page, paginationId, canvasId);
            return chart;
        }

        // Pagination
        function renderPagination(total, page, paginationId, canvasId) {
            const pages = Math.ceil(total / PER_PAGE);
            let html = '';

            for (let i = 1; i <= pages; i++) {
                html += `
        <button class="btn btn-sm ${i === page ? 'btn-primary' : 'btn-outline-primary'} mr-1"
            onclick="loadPage('${canvasId}', ${i})">${i}</button>`;
            }
            document.getElementById(paginationId).innerHTML = html;
        }

        // Load page
        function loadPage(canvasId, page) {
            if (canvasId === 'currentChart') {
                currentChart = renderChart('currentChart', currentData, page, 'currentPagination', currentChart);
            } else {
                completedChart = renderChart('completedChart', completedData, page, 'completedPagination', completedChart);
            }
        }

        // Initial load
        loadPage('currentChart', 1);
        loadPage('completedChart', 1);
    </script>
@endsection
