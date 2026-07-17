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

   
    {{-- ============================================================
Summary Cards
============================================================= --}}

    <div class="row mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-primary shadow-sm">

                <div class="inner">

                    <h3>
                        {{ $patientMeetings->total() }}
                    </h3>

                    <p>
                        Total Meetings
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-calendar-check"></i>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-success shadow-sm">

                <div class="inner">

                    <h3>

                        {{ $patientMeetings->where('status', 'confirmed')->count() }}

                    </h3>

                    <p>
                        Confirmed Meetings
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-check-circle"></i>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-warning shadow-sm">

                <div class="inner">

                    <h3>

                        {{ $patientMeetings->where('status', 'scheduled')->count() }}

                    </h3>

                    <p>
                        Scheduled
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-clock"></i>

                </div>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-danger shadow-sm">

                <div class="inner">

                    <h3>

                        {{ $patientMeetings->where('meeting_type', 'emergency')->count() }}

                    </h3>

                    <p>
                        Emergency Meetings
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-ambulance"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
Filters
============================================================= --}}

    <div class="card card-outline card-primary shadow-sm mb-4">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-filter mr-1"></i>

                Schedule Filters

            </h3>

        </div>


        <div class="card-body">

            <form method="GET" action="{{ route('patient_meetings.index') }}">

                <div class="row">

                    {{-- Search --}}

                    <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">

                        <label>

                            <i class="fas fa-search mr-1"></i>

                            Search

                        </label>

                        <div class="input-group">

                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Patient, code, specialist, title...">

                            <div class="input-group-append">

                                <button class="btn btn-primary">

                                    <i class="fas fa-search"></i>

                                </button>

                            </div>

                        </div>

                    </div>


                    {{-- Date --}}

                    <div class="col-lg-2 col-md-6 mb-3 mb-lg-0">

                        <label>

                            <i class="fas fa-calendar-day mr-1"></i>

                            Date

                        </label>

                        <input type="date" name="date" value="{{ request('date') }}" class="form-control">

                    </div>


                    {{-- Status --}}

                    <div class="col-lg-2 col-md-6 mb-3 mb-lg-0">

                        <label>

                            <i class="fas fa-tasks mr-1"></i>

                            Status

                        </label>

                        <select name="status" class="form-control">

                            <option value="">
                                All Status
                            </option>

                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>

                                Scheduled

                            </option>

                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>

                                Confirmed

                            </option>

                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>

                                Completed

                            </option>

                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>

                                Cancelled

                            </option>

                            <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>

                                No Show

                            </option>

                        </select>

                    </div>


                    {{-- Meeting Type --}}

                    <div class="col-lg-2 col-md-6 mb-3 mb-lg-0">

                        <label>

                            <i class="fas fa-stethoscope mr-1"></i>

                            Meeting Type

                        </label>

                        <select name="meeting_type" class="form-control">

                            <option value="">
                                All Types
                            </option>

                            <option value="consultation" {{ request('meeting_type') == 'consultation' ? 'selected' : '' }}>

                                Consultation

                            </option>

                            <option value="follow_up" {{ request('meeting_type') == 'follow_up' ? 'selected' : '' }}>

                                Follow Up

                            </option>

                            <option value="report_review"
                                {{ request('meeting_type') == 'report_review' ? 'selected' : '' }}>

                                Report Review

                            </option>

                            <option value="emergency" {{ request('meeting_type') == 'emergency' ? 'selected' : '' }}>

                                Emergency

                            </option>

                            <option value="other" {{ request('meeting_type') == 'other' ? 'selected' : '' }}>

                                Other

                            </option>

                        </select>

                    </div>


                    {{-- Buttons --}}

                    <div class="col-lg-2 d-flex align-items-end mb-3 mb-lg-0">

                        <button type="submit" class="btn btn-primary mr-2">

                            <i class="fas fa-filter mr-1"></i>

                            Filter

                        </button>


                        <a href="{{ route('patient_meetings.index') }}" class="btn btn-outline-secondary">

                            <i class="fas fa-sync-alt"></i>

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ============================================================
Schedule
============================================================= --}}

    <div class="card card-outline card-primary shadow">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-calendar-week mr-1"></i>

                Meeting Schedule

            </h3>


            <div class="card-tools">

                <span class="badge badge-primary">

                    {{ $patientMeetings->total() }}

                    Meetings

                </span>

            </div>

        </div>


        <div class="card-body">

            @forelse($patientMeetings->groupBy(function ($meeting) {

                return $meeting->meeting_date->format('Y-m-d');

            }) as $date => $meetings)


                {{-- Date Header --}}

                <div class="schedule-date-header mb-3">

                    <div class="d-flex align-items-center">

                        <div class="date-icon mr-3">

                            <i class="fas fa-calendar-day"></i>

                        </div>


                        <div>

                            <h5 class="mb-0 font-weight-bold">

                                {{ \Carbon\Carbon::parse($date)->format('l, F d, Y') }}

                            </h5>


                            @if ($date === now()->format('Y-m-d'))
                                <span class="badge badge-success mt-1">

                                    TODAY

                                </span>
                            @elseif ($date > now()->format('Y-m-d'))
                                <span class="badge badge-info mt-1">

                                    UPCOMING

                                </span>
                            @else
                                <span class="badge badge-secondary mt-1">

                                    PAST

                                </span>
                            @endif

                        </div>

                    </div>

                </div>


                {{-- Meetings --}}

                @foreach ($meetings as $meeting)
                    <div class="meeting-card mb-3">


                        {{-- Time Column --}}

                        <div class="meeting-time">

                            <div class="time-start">

                                {{ \Carbon\Carbon::parse($meeting->start_time)->format('h:i A') }}

                            </div>


                            @if ($meeting->end_time)
                                <div class="time-end">

                                    to

                                    {{ \Carbon\Carbon::parse($meeting->end_time)->format('h:i A') }}

                                </div>
                            @endif

                        </div>


                        {{-- Main Content --}}

                        <div class="meeting-content">


                            <div class="d-flex flex-column flex-md-row justify-content-between">


                                <div>

                                    <h5 class="mb-1 font-weight-bold">

                                        <i class="fas fa-calendar-check text-primary mr-1"></i>

                                        {{ $meeting->title ?: ucfirst(str_replace('_', ' ', $meeting->meeting_type)) }}

                                    </h5>


                                    <div class="text-muted small">

                                        <i class="fas fa-stethoscope mr-1"></i>

                                        {{ ucfirst(str_replace('_', ' ', $meeting->meeting_type)) }}

                                    </div>

                                </div>


                                <div class="mt-2 mt-md-0">

                                    @switch($meeting->status)
                                        @case('scheduled')
                                            <span class="badge badge-warning">

                                                <i class="fas fa-clock mr-1"></i>

                                                Scheduled

                                            </span>
                                        @break

                                        @case('confirmed')
                                            <span class="badge badge-success">

                                                <i class="fas fa-check mr-1"></i>

                                                Confirmed

                                            </span>
                                        @break

                                        @case('completed')
                                            <span class="badge badge-primary">

                                                <i class="fas fa-check-double mr-1"></i>

                                                Completed

                                            </span>
                                        @break

                                        @case('cancelled')
                                            <span class="badge badge-danger">

                                                <i class="fas fa-times mr-1"></i>

                                                Cancelled

                                            </span>
                                        @break

                                        @case('no_show')
                                            <span class="badge badge-secondary">

                                                <i class="fas fa-user-times mr-1"></i>

                                                No Show

                                            </span>
                                        @break
                                    @endswitch

                                </div>

                            </div>


                            <hr>


                            <div class="row">


                                {{-- Patient --}}

                                <div class="col-lg-5 mb-2 mb-lg-0">

                                    <div class="text-muted small mb-1">

                                        <i class="fas fa-user-injured mr-1"></i>

                                        Patient

                                    </div>


                                    @if ($meeting->patient)
                                        <strong>

                                            {{ $meeting->patient->patient_name }}

                                        </strong>


                                        <div class="small text-muted">

                                            Code:

                                            {{ $meeting->patient->patient_code }}

                                        </div>
                                    @else
                                        <span class="text-muted">

                                            General Meeting

                                        </span>
                                    @endif

                                </div>


                                {{-- Specialist --}}

                                <div class="col-lg-5 mb-2 mb-lg-0">

                                    <div class="text-muted small mb-1">

                                        <i class="fas fa-user-md mr-1"></i>

                                        Specialist

                                    </div>


                                    @if ($meeting->specialist)
                                        <strong>

                                            {{ $meeting->specialist->name }}

                                        </strong>


                                        <div class="small text-muted">

                                            {{ $meeting->specialist->designation }}

                                        </div>
                                    @else
                                        <span class="text-muted">

                                            Not Assigned

                                        </span>
                                    @endif

                                </div>


                                {{-- Actions --}}

                                <div class="col-lg-2 text-lg-right">


                                    <a href="{{ route('patient_meetings.show', $meeting->id) }}"
                                        class="btn btn-sm btn-outline-info mb-1">

                                        <i class="fas fa-eye"></i>

                                    </a>


                                    <a href="{{ route('patient_meetings.edit', $meeting->id) }}"
                                        class="btn btn-sm btn-outline-primary mb-1">

                                        <i class="fas fa-edit"></i>

                                    </a>


                                    <form action="{{ route('patient_meetings.destroy', $meeting->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this meeting?')">

                                        @csrf

                                        @method('DELETE')


                                        <button type="submit" class="btn btn-sm btn-outline-danger mb-1">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </div>


                            @if ($meeting->description || $meeting->notes)
                                <div class="meeting-notes mt-3">


                                    @if ($meeting->description)
                                        <div>

                                            <strong>

                                                <i class="fas fa-info-circle mr-1"></i>

                                                Description:

                                            </strong>

                                            {{ $meeting->description }}

                                        </div>
                                    @endif


                                    @if ($meeting->notes)
                                        <div class="mt-1">

                                            <strong>

                                                <i class="fas fa-sticky-note mr-1"></i>

                                                Notes:

                                            </strong>

                                            {{ $meeting->notes }}

                                        </div>
                                    @endif

                                </div>
                            @endif

                        </div>

                    </div>
                @endforeach

                @empty

                    <div class="text-center py-5">

                        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>

                        <h4 class="text-muted">

                            No Meetings Found

                        </h4>

                        <p class="text-muted">

                            There are no patient meetings matching your current filters.

                        </p>


                        <a href="{{ route('patient_meetings.create') }}" class="btn btn-primary">

                            <i class="fas fa-plus-circle mr-1"></i>

                            Schedule First Meeting

                        </a>

                    </div>

                @endforelse

            </div>

        </div>


        <div style="height: 50px;"></div>
       

    @stop

    @section('css')

        <style>
            .schedule-date-header {

                padding: 14px 18px;

                background: #f8f9fa;

                border-left: 5px solid #007bff;

                border-radius: 6px;

            }


            .date-icon {

                width: 42px;

                height: 42px;

                display: flex;

                align-items: center;

                justify-content: center;

                background: #007bff;

                color: #fff;

                border-radius: 50%;

                font-size: 18px;

            }


            .meeting-card {

                display: flex;

                border: 1px solid #e5e7eb;

                border-radius: 8px;

                background: #fff;

                overflow: hidden;

                transition: all .2s ease;

            }


            .meeting-card:hover {

                transform: translateY(-2px);

                box-shadow: 0 6px 18px rgba(0, 0, 0, .08);

            }


            .meeting-time {

                width: 145px;

                flex-shrink: 0;

                background: #f8f9fa;

                border-right: 1px solid #e5e7eb;

                padding: 22px 15px;

                text-align: center;

            }


            .time-start {

                font-size: 18px;

                font-weight: 700;

                color: #007bff;

            }


            .time-end {

                font-size: 12px;

                color: #6c757d;

                margin-top: 4px;

            }


            .meeting-content {

                flex: 1;

                padding: 18px 20px;

            }


            .meeting-notes {

                background: #f8f9fa;

                border-radius: 6px;

                padding: 10px 12px;

                font-size: 13px;

                color: #495057;

            }


            @media (max-width: 768px) {

                .meeting-card {

                    display: block;

                }


                .meeting-time {

                    width: 100%;

                    border-right: none;

                    border-bottom: 1px solid #e5e7eb;

                    padding: 12px;

                }


                .meeting-content {

                    padding: 15px;

                }

            }
        </style>

    @stop
