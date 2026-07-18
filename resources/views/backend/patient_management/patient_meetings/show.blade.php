@extends('adminlte::page')

@section('title', 'Meeting Details')

@section('content_header')

    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/show_page/show_layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/show_page/show_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/show_page/show_hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/show_page/show_card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/show_page/show_profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/show_page/show_notes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/show_page/show_meeting_info.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/show_page/show_responsive.css') }}">
    <div class="meeting-page-header">

        <div class="meeting-header-left">

            <div class="meeting-header-icon">

                <i class="fas fa-calendar-check"></i>

            </div>

            <div>

                <div class="meeting-breadcrumb">

                    <span>Patient Management</span>

                    <i class="fas fa-chevron-right"></i>

                    <span>Meetings</span>

                </div>

                <h1 class="meeting-page-title">

                    Meeting Details

                </h1>

                <p class="meeting-page-subtitle">

                    View complete consultation and appointment information.

                </p>

            </div>

        </div>

        <div class="meeting-header-actions">

            <a href="{{ route('patient_meetings.edit', $patientMeeting->id) }}" class="btn meeting-edit-btn">

                <i class="fas fa-edit mr-1"></i>

                Edit Meeting

            </a>

        </div>

    </div>


@stop

@section('content')
    @php
        $meetingTitle = $patientMeeting->title ?? ucfirst(str_replace('_', ' ', $patientMeeting->meeting_type));

        $meetingStatus = ucfirst($patientMeeting->status);

        $meetingType = ucfirst(str_replace('_', ' ', $patientMeeting->meeting_type));

        $patient = $patientMeeting->patient;

        $specialist = $patientMeeting->specialist;

        $patientImage =
            $patient && $patient->patient_photo && file_exists(public_path($patient->patient_photo))
                ? asset($patient->patient_photo)
                : asset('uploads/images/default.jpg');

    @endphp

    {{--  MEETING HERO --}}
    <div class="meeting-hero-card">

        <div class="meeting-hero-pattern"></div>

        <div class="meeting-hero-content">

            <div class="meeting-hero-main">

                <div class="meeting-calendar-icon">

                    <i class="fas fa-calendar-alt"></i>

                </div>

                <div>

                    <span class="meeting-overline">

                        CONSULTATION MEETING

                    </span>

                    <h2 class="meeting-hero-title">

                        {{ $meetingTitle }}

                    </h2>

                    <div class="meeting-hero-meta">

                        <span>

                            <i class="far fa-calendar-alt"></i>

                            {{ $patientMeeting->meeting_date?->format('d M Y') ?? 'Date unavailable' }}

                        </span>

                        <span class="meta-divider"></span>

                        <span>

                            <i class="far fa-clock"></i>

                            {{ \Carbon\Carbon::parse($patientMeeting->start_time)->format('h:i A') }}

                            @if ($patientMeeting->end_time)
                                -

                                {{ \Carbon\Carbon::parse($patientMeeting->end_time)->format('h:i A') }}
                            @endif

                        </span>

                    </div>

                </div>

            </div>

            <div class="meeting-hero-status">

                <span class="status-label">

                    STATUS

                </span>

                <span class="meeting-status-badge status-{{ strtolower($patientMeeting->status) }}">

                    <span class="status-indicator"></span>

                    {{ $meetingStatus }}

                </span>

            </div>

        </div>

    </div>


    {{-- MAIN INFORMATION --}}
    <div class="row meeting-main-row">
        {{--  MEETING INFORMATION --}}
        <div class="col-lg-4 mb-4">

            <div class="premium-meeting-card">

                <div class="premium-card-header">

                    <div class="card-header-icon meeting-icon">

                        <i class="fas fa-calendar-check"></i>

                    </div>

                    <div>

                        <h5>Meeting Information</h5>

                        <span>Appointment overview</span>

                    </div>

                </div>

                <div class="premium-card-body">

                    <div class="meeting-info-list">

                        <div class="meeting-info-item">

                            <div class="info-item-icon">

                                <i class="fas fa-heading"></i>

                            </div>

                            <div>

                                <span class="info-label">Title</span>

                                <strong>{{ $meetingTitle }}</strong>

                            </div>

                        </div>

                        <div class="meeting-info-item">

                            <div class="info-item-icon">

                                <i class="far fa-calendar"></i>

                            </div>

                            <div>

                                <span class="info-label">Meeting Date</span>

                                <strong>

                                    {{ $patientMeeting->meeting_date?->format('d M Y') ?? 'N/A' }}

                                </strong>

                            </div>

                        </div>

                        <div class="meeting-info-item">

                            <div class="info-item-icon">

                                <i class="far fa-clock"></i>

                            </div>

                            <div>

                                <span class="info-label">Time</span>

                                <strong>

                                    {{ \Carbon\Carbon::parse($patientMeeting->start_time)->format('h:i A') }}

                                    @if ($patientMeeting->end_time)
                                        -

                                        {{ \Carbon\Carbon::parse($patientMeeting->end_time)->format('h:i A') }}
                                    @endif

                                </strong>

                            </div>

                        </div>

                        <div class="meeting-info-item">

                            <div class="info-item-icon">

                                <i class="fas fa-layer-group"></i>

                            </div>

                            <div>

                                <span class="info-label">Meeting Type</span>

                                <strong>{{ $meetingType }}</strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{--  PATIENT PROFILE --}}
        <div class="col-lg-4 mb-4">

            <div class="premium-meeting-card profile-card">

                <div class="premium-card-header">

                    <div class="card-header-icon patient-icon">

                        <i class="fas fa-user-injured"></i>

                    </div>

                    <div>

                        <h5>Patient</h5>

                        <span>Meeting participant</span>

                    </div>

                </div>

                <div class="profile-card-body">

                    @if ($patient)
                        <div class="profile-image-wrapper">

                            <img src="{{ $patientImage }}" alt="{{ $patient->patient_name }}"
                                class="profile-image zoomable" data-action="zoom">

                            <span class="profile-online-indicator"></span>

                        </div>

                        <h4 class="profile-name">

                            {{ $patient->patient_name }}

                        </h4>

                        <span class="profile-code">

                            <i class="fas fa-id-card"></i>

                            {{ $patient->patient_code }}

                        </span>

                        <a href="{{ route('patients.show', $patient->id) }}" class="profile-view-btn patient-btn">

                            <i class="fas fa-user mr-1"></i>

                            View Patient

                        </a>
                    @else
                        <div class="profile-empty">

                            <i class="fas fa-user-slash"></i>

                            <span>Patient information unavailable</span>

                        </div>
                    @endif

                </div>

            </div>

        </div>


        {{--  SPECIALIST PROFILE --}}
        <div class="col-lg-4 mb-4">

            <div class="premium-meeting-card profile-card">

                <div class="premium-card-header">

                    <div class="card-header-icon specialist-icon">

                        <i class="fas fa-user-md"></i>

                    </div>

                    <div>

                        <h5>Specialist</h5>

                        <span>Consulting specialist</span>

                    </div>

                </div>

                <div class="profile-card-body">

                    @if ($specialist)
                        <div class="profile-image-wrapper specialist-image-wrapper">

                            <img src="{{ asset('uploads/images/welcome_page/doctors/' . $specialist->photo) }}"
                                alt="{{ $specialist->name }}" class="profile-image specialist-image">

                        </div>

                        <h4 class="profile-name">

                            {{ $specialist->name }}

                        </h4>

                        <span class="profile-designation">

                            {{ $specialist->designation }}

                        </span>

                        <a href="{{ route('specialists.show', $specialist->id) }}"
                            class="profile-view-btn specialist-btn">

                            <i class="fas fa-stethoscope mr-1"></i>

                            View Specialist

                        </a>
                    @else
                        <div class="profile-empty">

                            <i class="fas fa-user-md"></i>

                            <span>Specialist information unavailable</span>

                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- DESCRIPTION & NOTES --}}
    <div class="premium-notes-card">

        <div class="premium-notes-header">

            <div class="notes-header-icon">

                <i class="fas fa-notes-medical"></i>

            </div>

            <div>

                <h5>Consultation Notes</h5>

                <span>Additional meeting information</span>

            </div>

        </div>

        <div class="premium-notes-body">

            <div class="note-section">

                <div class="note-title">

                    <i class="fas fa-align-left"></i>

                    Description

                </div>

                <div class="note-content">

                    {!! nl2br(e($patientMeeting->description ?? 'No description has been added for this meeting.')) !!}

                </div>

            </div>

            <div class="note-divider"></div>

            <div class="note-section">

                <div class="note-title">

                    <i class="fas fa-sticky-note"></i>

                    Notes

                </div>

                <div class="note-content">

                    {!! nl2br(e($patientMeeting->notes ?? 'No additional notes have been added.')) !!}

                </div>

            </div>

        </div>

    </div>

    <div style="height: 30px;"></div>
@stop
