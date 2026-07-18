@extends('adminlte::page')

@section('title', "Today's Meetings")

@section('content_header')

    <div class="d-flex justify-content-between">

        <div>

            <h1>

                <i class="fas fa-calendar-day text-primary mr-2"></i>

                Today's Meetings

            </h1>

            <small class="text-muted">

                {{ now()->format('d F Y') }}

            </small>

        </div>

    </div>

@stop


@section('content')

    <div class="row">

        <div class="col-md-4">

            <div class="small-box bg-info">

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

        <div class="col-md-4">

            <div class="small-box bg-success">

                <div class="inner">

                    <h3>

                        {{ $completedCount }}

                    </h3>

                    <p>

                        Completed

                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-check-circle"></i>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="small-box bg-warning">

                <div class="inner">

                    <h3>

                        {{ $pendingCount }}

                    </h3>

                    <p>

                        Pending

                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-clock"></i>

                </div>

            </div>

        </div>

    </div>



    <div class="card card-outline card-primary">

        <div class="card-header">

            <form>

                <div class="row">

                    <div class="col-md-4">

                        <input type="text" name="search" value="{{ $search }}" class="form-control"
                            placeholder="Search Patient / Specialist">

                    </div>

                    <div class="col-md-3">

                        <select name="status" class="form-control">

                            <option value="">

                                All Status

                            </option>

                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>

                                Pending

                            </option>

                            <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>

                                Completed

                            </option>

                            <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>

                                Cancelled

                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary btn-block">

                            Search

                        </button>

                    </div>

                    <div class="col-md-2">

                        <a href="{{ route('patient_meetings.today') }}" class="btn btn-secondary btn-block">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Patient</th>

                            <th>Specialist</th>

                            <th>Time</th>

                            <th>Status</th>

                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($patientMeetings as $meeting)
                            @php

                                $patientImage =
                                    $meeting->patient &&
                                    $meeting->patient->patient_photo &&
                                    file_exists(public_path($meeting->patient->patient_photo))
                                        ? asset($meeting->patient->patient_photo)
                                        : asset('uploads/images/default.jpg');

                            @endphp

                            <tr>

                                <td>

                                    {{ $patientMeetings->firstItem() + $loop->index }}

                                </td>

                                <td>

                                    <div class="d-flex align-items-center">

                                        <img src="{{ $patientImage }}" class="rounded-circle mr-3"
                                            style="
                                            width:45px;
                                            height:45px;
                                            object-fit:cover;
                                        ">

                                        <div>

                                            <strong>

                                                {{ $meeting->patient?->patient_name }}

                                            </strong>

                                            <br>

                                            <small>

                                                {{ $meeting->patient?->patient_code }}

                                            </small>

                                        </div>

                                    </div>

                                </td>

                                <td>

                                    Dr.
                                    {{ $meeting->specialist?->name }}

                                </td>

                                <td>

                                    {{ $meeting->start_time ? \Carbon\Carbon::parse($meeting->start_time)->format('h:i A') : '--' }}

                                </td>

                                <td>

                                    <span
                                        class="badge badge-{{ $meeting->status == 'completed' ? 'success' : ($meeting->status == 'cancelled' ? 'danger' : 'warning') }}">

                                        {{ ucfirst($meeting->status) }}

                                    </span>

                                </td>

                                <td>

                                    <a href="{{ route('patient_meetings.show', $meeting->id) }}"
                                        class="btn btn-sm btn-primary">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6">

                                    <div class="text-center py-5">

                                        <i
                                            class="fas fa-calendar-times
                                              fa-4x
                                              text-muted mb-3"></i>

                                        <h5>

                                            No Meetings Scheduled Today

                                        </h5>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <div class="card-footer">

            <div class="d-flex justify-content-end">

                {{ $patientMeetings->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>

@stop
