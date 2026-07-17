@extends('adminlte::page')

@section('title', 'Patient Meeting Schedule')

@section('content_header')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
            <h1 class="mb-1">
                <i class="fas fa-calendar-alt text-primary mr-2"></i>
                Patient Meeting Schedule
            </h1>

            <small class="text-muted">
                Manage consultations, follow-ups, report reviews, and patient appointments.
            </small>
        </div>

        <div class="mt-3 mt-md-0">
            <a href="{{ route('patient_meetings.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle mr-1"></i>
                Schedule Meeting
            </a>
        </div>
    </div>

@stop

@section('content')
    {{-- Summary Cards --}}
    @include('backend.patient_management.patient_meetings.partial_pages.index_page.part_1')

    {{-- Filters --}}
    @include('backend.patient_management.patient_meetings.partial_pages.index_page.part_2')

    {{-- Schedule --}}
    {{-- Schedule --}}
    <div class="card card-outline card-primary shadow meeting-dashboard">

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>
                <h3 class="card-title mb-0">
                    <i class="fas fa-calendar-week mr-2"></i>
                    Meeting Dashboard
                </h3>

                <div class="text-muted small mt-1">
                    Specialist wise patient meeting overview
                </div>
            </div>

            <span class="badge badge-primary px-3 py-2">
                {{ $patientMeetings->total() }}
                Meetings
            </span>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive dashboard-table-wrapper">

                <table class="table table-bordered table-hover meeting-grid mb-0">

                    <thead>

                        <tr>

                            <th class="text-center" style="width:80px;">
                                SL
                            </th>

                            <th style="min-width:250px;">
                                Specialist
                            </th>

                            <th style="min-width:280px;">
                                Recent
                            </th>

                            <th style="min-width:280px;">
                                Yesterday
                            </th>

                            <th style="min-width:280px;">
                                Day Before
                            </th>

                            <th style="min-width:280px;">
                                This Week
                            </th>

                            <th style="min-width:280px;">
                                This Month
                            </th>

                            <th class="text-center" style="width:130px;">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($specialists as $specialist)
                            @php

                                $today = \Carbon\Carbon::today();

                                $recent = $specialist->meetings->filter(
                                    fn($m) => optional($m->meeting_date)->isSameDay($today),
                                );

                                $yesterday = $specialist->meetings->filter(
                                    fn($m) => optional($m->meeting_date)->isSameDay($today->copy()->subDay()),
                                );

                                $dayBefore = $specialist->meetings->filter(
                                    fn($m) => optional($m->meeting_date)->isSameDay($today->copy()->subDays(2)),
                                );

                                $week = $specialist->meetings->filter(
                                    fn($m) => optional($m->meeting_date)->isCurrentWeek(),
                                );

                                $month = $specialist->meetings->filter(
                                    fn($m) => optional($m->meeting_date)->isCurrentMonth(),
                                );

                            @endphp

                            <tr>

                                <td class="text-center align-middle">

                                    <strong>
                                        {{ $loop->iteration }}
                                    </strong>

                                </td>

                                <td>

                                    <div class="specialist-box">

                                        @php
                                            $doctorImage = $specialist->photo
                                                ? asset('uploads/images/welcome_page/doctors/' . $specialist->photo)
                                                : null;
                                        @endphp

                                        <div class="specialist-avatar">

                                            @if ($specialist->photo)
                                                <img src="{{ $doctorImage }}" alt="{{ $specialist->name }}"
                                                    class="specialist-image" loading="lazy">
                                            @else
                                                <span>
                                                    {{ strtoupper(substr($specialist->name, 0, 1)) }}
                                                </span>
                                            @endif

                                        </div>

                                        <div class="specialist-info">

                                            <h6 class="mb-1">

                                                Dr.
                                                {{ $specialist->name }}

                                            </h6>

                                            <p class="mb-1">

                                                {{ $specialist->designation }}

                                            </p>

                                            @if ($specialist->degree)
                                                <small class="text-muted">

                                                    {{ $specialist->degree }}

                                                </small>
                                            @endif

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    @include(
                                        'backend.patient_management.patient_meetings.partial_pages.index_page.patient_cards',
                                        ['meetings' => $recent]
                                    )
                                </td>

                                <td>
                                    @include(
                                        'backend.patient_management.patient_meetings.partial_pages.index_page.patient_cards',
                                        ['meetings' => $yesterday]
                                    )
                                </td>

                                <td>
                                    @include(
                                        'backend.patient_management.patient_meetings.partial_pages.index_page.patient_cards',
                                        ['meetings' => $dayBefore]
                                    )
                                </td>

                                <td>
                                    @include(
                                        'backend.patient_management.patient_meetings.partial_pages.index_page.patient_cards',
                                        ['meetings' => $week]
                                    )
                                </td>

                                <td>
                                    @include(
                                        'backend.patient_management.patient_meetings.partial_pages.index_page.patient_cards',
                                        ['meetings' => $month]
                                    )
                                </td>

                                <td class="text-center">
                                    {{-- Patient Show Proflile but pass them to each patients part in hover show eye corner in top --}}
                                    <a href="{{ route('patient_meetings.show', $specialist->id) }}"
                                        class="btn btn-sm btn-outline-primary mb-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- Specialist Profile --}}
                                    <a href="{{ route('specialists.show', $specialist->id) }}"
                                        class="btn btn-sm btn-outline-warning mb-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- Patient Week History part so that it will show patient in 3x2 card format and each patient will have patient_code, patient_name(	Recent	Yesterday	Day Before	This Week	This Month) --}}
                                    <a href="{{ route('specialists.show', $specialist->id) }}"
                                        class="btn btn-sm btn-outline-secondary  mb-2">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8">

                                    <div class="text-center py-5">

                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>

                                        <h5 class="text-muted">
                                            No Specialists Found
                                        </h5>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <div class="card-footer bg-white">
            <div class="d-flex justify-content-end">
                {{ $specialists->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    <div style="height: 50px;"></div>
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/index_page/dashboard_layout.css') }}">

    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/index_page/table_grid.css') }}">

    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/specialist_section.css') }}">

    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/index_page/patient_card.css') }}">

    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/index_page/pagination.css') }}">

    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/index_page/responsive.css') }}">
@stop
