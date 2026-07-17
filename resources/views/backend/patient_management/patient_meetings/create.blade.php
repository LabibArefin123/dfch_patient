@extends('adminlte::page')

@section('title', 'Schedule Patient Meeting')

@section('content_header')


    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">

                <i class="fas fa-calendar-plus text-primary mr-2"></i>

                Schedule Patient Meeting

            </h1>

            <small class="text-muted">

                Create a new consultation, follow-up, report review, or patient appointment.

            </small>

        </div>


        <a href="{{ route('patient_meetings.index') }}" class="btn btn-outline-secondary">

            <i class="fas fa-arrow-left mr-1"></i>

            Back to Schedule

        </a>

    </div>


@stop

@section('content')


    <form action="{{ route('patient_meetings.store') }}" method="POST">

        @csrf


        {{-- ============================================================
    Meeting Participants
    ============================================================= --}}

        <div class="card card-outline card-primary shadow-sm mb-4">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="fas fa-users mr-1"></i>

                    Meeting Participants

                </h3>

            </div>


            <div class="card-body">

                <div class="row">


                    {{-- Patient --}}

                    <div class="form-group col-md-6 mb-3">

                        <label for="patient_id">

                            <i class="fas fa-user-injured mr-1 text-danger"></i>

                            Patient

                        </label>


                        <select name="patient_id" id="patient_id"
                            class="form-control @error('patient_id') is-invalid @enderror">

                            <option value="">

                                Select Patient

                            </option>


                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    {{ old('patient_id') == $patient->id ? 'selected' : '' }}>

                                    {{ $patient->patient_name }}

                                    —

                                    {{ $patient->patient_code }}

                                </option>
                            @endforeach

                        </select>


                        @error('patient_id')
                            <span class="invalid-feedback">

                                {{ $message }}

                            </span>
                        @enderror

                    </div>


                    {{-- Specialist --}}

                    <div class="form-group col-md-6 mb-3">

                        <label for="specialist_id">

                            <i class="fas fa-user-md mr-1 text-primary"></i>

                            Specialist / Doctor

                        </label>


                        <select name="specialist_id" id="specialist_id"
                            class="form-control @error('specialist_id') is-invalid @enderror">

                            <option value="">

                                Select Specialist

                            </option>


                            @foreach ($specialists as $specialist)
                                <option value="{{ $specialist->id }}"
                                    {{ old('specialist_id') == $specialist->id ? 'selected' : '' }}>

                                    {{ $specialist->name }}

                                    —

                                    {{ $specialist->designation }}

                                </option>
                            @endforeach

                        </select>


                        @error('specialist_id')
                            <span class="invalid-feedback">

                                {{ $message }}

                            </span>
                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================
    Meeting Information
    ============================================================= --}}

        <div class="card card-outline card-info shadow-sm mb-4">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="fas fa-info-circle mr-1"></i>

                    Meeting Information

                </h3>

            </div>


            <div class="card-body">

                <div class="row">


                    {{-- Title --}}

                    <div class="form-group col-md-8 mb-3">

                        <label for="title">

                            Meeting Title

                        </label>


                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="form-control @error('title') is-invalid @enderror"
                            placeholder="Example: Cancer Report Review">


                        @error('title')
                            <span class="invalid-feedback">

                                {{ $message }}

                            </span>
                        @enderror

                    </div>


                    {{-- Meeting Type --}}

                    <div class="form-group col-md-4 mb-3">

                        <label for="meeting_type">

                            <i class="fas fa-stethoscope mr-1"></i>

                            Meeting Type

                            <span class="text-danger">*</span>

                        </label>


                        <select name="meeting_type" id="meeting_type"
                            class="form-control @error('meeting_type') is-invalid @enderror">

                            <option value="">

                                Select Meeting Type

                            </option>


                            <option value="consultation" {{ old('meeting_type') == 'consultation' ? 'selected' : '' }}>

                                Consultation

                            </option>


                            <option value="follow_up" {{ old('meeting_type') == 'follow_up' ? 'selected' : '' }}>

                                Follow Up

                            </option>


                            <option value="report_review" {{ old('meeting_type') == 'report_review' ? 'selected' : '' }}>

                                Report Review

                            </option>


                            <option value="emergency" {{ old('meeting_type') == 'emergency' ? 'selected' : '' }}>

                                Emergency

                            </option>


                            <option value="other" {{ old('meeting_type') == 'other' ? 'selected' : '' }}>

                                Other

                            </option>

                        </select>


                        @error('meeting_type')
                            <span class="invalid-feedback">

                                {{ $message }}

                            </span>
                        @enderror

                    </div>


                    {{-- Description --}}

                    <div class="form-group col-12 mb-3">

                        <label for="description">

                            <i class="fas fa-align-left mr-1"></i>

                            Description

                        </label>


                        <textarea name="description" id="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Describe the purpose of this meeting...">{{ old('description') }}</textarea>


                        @error('description')
                            <span class="invalid-feedback">

                                {{ $message }}

                            </span>
                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================
    Schedule
    ============================================================= --}}

        <div class="card card-outline card-success shadow-sm mb-4">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="fas fa-clock mr-1"></i>

                    Schedule Details

                </h3>

            </div>


            <div class="card-body">

                <div class="row">


                    {{-- Date --}}

                    <div class="form-group col-md-4 mb-3">

                        <label for="meeting_date">

                            <i class="fas fa-calendar-day mr-1 text-success"></i>

                            Meeting Date

                            <span class="text-danger">*</span>

                        </label>


                        <input type="date" name="meeting_date" id="meeting_date"
                            value="{{ old('meeting_date', now()->format('Y-m-d')) }}"
                            class="form-control @error('meeting_date') is-invalid @enderror">


                        @error('meeting_date')
                            <span class="invalid-feedback">

                                {{ $message }}

                            </span>
                        @enderror

                    </div>


                    {{-- Start Time --}}

                    <div class="form-group col-md-4 mb-3">

                        <label for="start_time">

                            <i class="fas fa-hourglass-start mr-1 text-primary"></i>

                            Start Time

                            <span class="text-danger">*</span>

                        </label>


                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                            class="form-control @error('start_time') is-invalid @enderror">


                        @error('start_time')
                            <span class="invalid-feedback">

                                {{ $message }}

                            </span>
                        @enderror

                    </div>


                    {{-- End Time --}}

                    <div class="form-group col-md-4 mb-3">

                        <label for="end_time">

                            <i class="fas fa-hourglass-end mr-1 text-secondary"></i>

                            End Time

                        </label>


                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}"
                            class="form-control @error('end_time') is-invalid @enderror">


                        @error('end_time')
                            <span class="invalid-feedback">

                                {{ $message }}

                            </span>
                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================
    Status & Notes
    ============================================================= --}}

        <div class="card card-outline card-warning shadow-sm mb-4">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="fas fa-tasks mr-1"></i>

                    Status & Additional Notes

                </h3>

            </div>


            <div class="card-body">

                <div class="row">


                    {{-- Status --}}

                    <div class="form-group col-md-4 mb-3">

                        <label for="status">

                            Meeting Status

                            <span class="text-danger">*</span>

                        </label>


                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">

                            <option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>

                                Scheduled

                            </option>


                            <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>

                                Confirmed

                            </option>


                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>

                                Completed

                            </option>


                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>

                                Cancelled

                            </option>


                            <option value="no_show" {{ old('status') == 'no_show' ? 'selected' : '' }}>

                                No Show

                            </option>

                        </select>


                        @error('status')
                            <span class="invalid-feedback">

                                {{ $message }}

                            </span>
                        @enderror

                    </div>


                    {{-- Notes --}}

                    <div class="form-group col-md-8 mb-3">

                        <label for="notes">

                            <i class="fas fa-sticky-note mr-1"></i>

                            Additional Notes

                        </label>


                        <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"
                            placeholder="Add any additional notes...">{{ old('notes') }}</textarea>


                        @error('notes')
                            <span class="invalid-feedback">

                                {{ $message }}

                            </span>
                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================
    Actions
    ============================================================= --}}

        <div class="d-flex justify-content-between align-items-center mb-5">

            <a href="{{ route('patient_meetings.index') }}" class="btn btn-outline-secondary px-4">

                <i class="fas fa-times mr-1"></i>

                Cancel

            </a>


            <button type="submit" class="btn btn-success px-5">

                <i class="fas fa-calendar-check mr-1"></i>

                Schedule Meeting

            </button>

        </div>

    </form>


    <div style="height: 30px;"></div>


@stop
