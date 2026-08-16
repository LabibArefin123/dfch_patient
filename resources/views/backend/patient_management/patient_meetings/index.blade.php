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
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/index_page/dashboard_layout.css') }}">

    {{-- DASHBOARD MEETING EMPTY START --}}
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/dashboard_meeting_empty.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/dashboard_meeting_empty_decorations.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/dashboard_meeting_empty_icon.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/dashboard_meeting_empty_content.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/dashboard_meeting_empty_animation.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/dashboard_meeting_empty_responsive.css') }}">
    {{-- DASHBOARD MEETING EMPTY END --}}

    {{-- DASHBOARD TABLE HEADER START --}}
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/index_page/table_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/index_page/table_header_title.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/table_header_subtitle.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/table_header_buttons.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/table_header_badge.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/table_header_responsive.css') }}">
    {{-- DASHBOARD TABLE HEADER END --}}

    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/index_page/table_grid.css') }}">
    <link rel="stylesheet"href="{{ asset('css/backend/patient_page/patient_meeting/index_page/specialist_filter.css') }}">
    <link rel="stylesheet"href="{{ asset('css/backend/patient_page/patient_meeting/index_page/specialist_section.css') }}">
    <link rel="stylesheet"href="{{ asset('css/backend/patient_page/patient_meeting/index_page/patient_card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/index_page/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_meeting/index_page/responsive.css') }}">

    {{-- PATIENT SUMMARY CARD START --}}
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/patient_summary_cards/patient_summary_layout.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/patient_summary_cards/patient_summary_summary.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/patient_summary_cards/patient_summary_card.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/patient_summary_cards/patient_summary_patient_info.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/patient_summary_cards/patient_summary_actions.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/patient_summary_cards/patient_summary_status.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/patient_page/patient_meeting/index_page/patient_summary_cards/patient_summary_pagination.css') }}">
    {{-- PATIENT SUMMARY CARD END --}}

    {{-- Summary Cards --}}
    @include('backend.patient_management.patient_meetings.partial_pages.index_page.part_1')
    {{-- Filters --}}
    @include('backend.patient_management.patient_meetings.partial_pages.index_page.part_2')

    {{-- Schedule --}}
    <div id="meetingTableContainer">
        @include('backend.patient_management.patient_meetings.partial_pages.index_page.meeting_dashboard')
    </div>

    <div style="height: 50px;"></div>

@stop

@section('js')
    <script src="{{ asset('js/backend/patient_management/patient_meeting/index_page/meeting_table_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_meeting/index_page/specialist_filter.js') }}"></script>
@endsection
