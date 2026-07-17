@extends('adminlte::page')

@section('title', 'Meeting Details')

@section('content_header')

    <div class="d-flex justify-content-between">

        <div>

            <h1>
                <i class="fas fa-calendar-check text-primary mr-2"></i>
                Meeting Details
            </h1>

            <small class="text-muted">

                View patient consultation information.

            </small>

        </div>

        <div>

            <a href="{{ route('patient_meetings.edit', $patientMeeting->id) }}" class="btn btn-primary">
                <i class="fas fa-edit mr-1"></i>
                Edit
            </a>

        </div>

    </div>

@stop

@section('content')

    <div class="row">

        {{-- Meeting --}}
        <div class="col-lg-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    <h5 class="mb-0">
                        Meeting Information
                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-sm">

                        <tr>
                            <th>Title</th>
                            <td>

                                {{ $patientMeeting->title ?? ucfirst(str_replace('_', ' ', $patientMeeting->meeting_type)) }}

                            </td>
                        </tr>

                        <tr>
                            <th>Date</th>
                            <td>

                                {{ $patientMeeting->meeting_date->format('d M Y') }}

                            </td>
                        </tr>

                        <tr>
                            <th>Time</th>

                            <td>

                                {{ \Carbon\Carbon::parse($patientMeeting->start_time)->format('h:i A') }}

                                -

                                {{ $patientMeeting->end_time ? \Carbon\Carbon::parse($patientMeeting->end_time)->format('h:i A') : '--' }}

                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>

                            <td>

                                <span class="badge badge-primary">

                                    {{ ucfirst($patientMeeting->status) }}

                                </span>

                            </td>
                        </tr>

                        <tr>
                            <th>Type</th>

                            <td>

                                {{ ucfirst(str_replace('_', ' ', $patientMeeting->meeting_type)) }}

                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

        {{-- Patient --}}
        <div class="col-lg-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    <h5 class="mb-0">

                        Patient

                    </h5>

                </div>

                <div class="card-body text-center">

                    @if ($patientMeeting->patient)
                        @php
                            $patientImage =
                                $patientMeeting->patient &&
                                $patientMeeting->patient->patient_photo &&
                                file_exists(public_path($patientMeeting->patient->patient_photo))
                                    ? asset($patientMeeting->patient->patient_photo)
                                    : asset('uploads/images/default.jpg');
                        @endphp

                        <img src="{{ $patientImage }}" alt="{{ $patientMeeting->patient?->patient_name }}"
                            class="img-thumbnail rounded-circle mb-3 zoomable"
                            style="
                                width:120px;
                                height:120px;
                                object-fit:cover;
                                cursor:pointer;
                                border:3px solid #f1f5f9;
                                box-shadow:0 4px 12px rgba(0,0,0,.08);
                            "
                            data-action="zoom">
                        <h5>

                            {{ $patientMeeting->patient->patient_name }}

                        </h5>

                        <p class="text-muted">

                            {{ $patientMeeting->patient->patient_code }}

                        </p>

                        <a href="{{ route('patients.show', $patientMeeting->patient->id) }}"
                            class="btn btn-outline-primary btn-sm">

                            View Patient

                        </a>
                    @endif

                </div>

            </div>

        </div>

        {{-- Specialist --}}
        <div class="col-lg-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    <h5 class="mb-0">

                        Specialist

                    </h5>

                </div>

                <div class="card-body text-center">

                    @if ($patientMeeting->specialist)
                        <img src="{{ asset('uploads/images/welcome_page/doctors/' . $patientMeeting->specialist->photo) }}"
                            class="img-thumbnail rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover;">

                        <h5>

                            Dr.
                            {{ $patientMeeting->specialist->name }}

                        </h5>

                        <p class="text-muted">

                            {{ $patientMeeting->specialist->designation }}

                        </p>

                        <a href="{{ route('specialists.show', $patientMeeting->specialist->id) }}"
                            class="btn btn-outline-primary btn-sm">

                            View Specialist

                        </a>
                    @endif

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm mt-4">

        <div class="card-header">

            Description & Notes

        </div>

        <div class="card-body">

            <h6>Description</h6>

            <p>

                {{ $patientMeeting->description ?? 'N/A' }}

            </p>

            <hr>

            <h6>Notes</h6>

            <p>

                {{ $patientMeeting->notes ?? 'N/A' }}

            </p>

        </div>

    </div>

@stop
