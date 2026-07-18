@extends('adminlte::page')

@section('title', 'All Meetings')

@section('content_header')

    <div class="d-flex justify-content-between">

        <div>

            <h1>
                <i class="fas fa-calendar-check text-primary mr-2"></i>
                All Patient Meetings
            </h1>

            <small class="text-muted">
                Patient consultation history and schedules.
            </small>

        </div>

        <a href="{{ route('patient_meetings.create') }}" class="btn btn-primary">

            <i class="fas fa-plus mr-1"></i>

            Add Meeting

        </a>

    </div>

@stop


@section('content')

    <div class="card card-outline card-primary shadow">

        <div class="card-header">

            <form>

                <div class="row">

                    <div class="col-md-3">

                        <input type="text" class="form-control" name="search" value="{{ $search }}"
                            placeholder="Search patient/specialist">

                    </div>

                    <div class="col-md-2">

                        <select name="status" class="form-control">

                            <option value="">All Status</option>

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

                        <input type="date" class="form-control" name="date" value="{{ $date }}">

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">

                            <i class="fas fa-search mr-1"></i>

                            Search

                        </button>

                    </div>

                    <div class="col-md-2">

                        <a href="{{ route('patient_meetings.list') }}" class="btn btn-secondary w-100">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>


        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="dataTables">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Specialist</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th width="150"> Action</th>
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
                                    {{ $loop->iteration }}
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
                                            <strong>{{ $meeting->patient?->patient_name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $meeting->patient?->patient_code }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $meeting->specialist?->name }} </td>
                                <td>{{ $meeting->meeting_date?->format('d M Y') }} </td>
                                <td>{{ $meeting->start_time ? \Carbon\Carbon::parse($meeting->start_time)->format('h:i A') : '--' }}
                                </td>
                                <td>
                                    <span
                                        class="badge badge-{{ $meeting->status == 'completed' ? 'success' : ($meeting->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($meeting->status) }}
                                    </span>
                                </td>

                                <td>{{ ucfirst(str_replace('_', ' ', $meeting->meeting_type)) }} </td>
                                <td>
                                    <a href="{{ route('patient_meetings.show', $meeting->id) }}"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="fas fa-eye"></i>

                                    </a>
                                    <a href="{{ route('patient_meetings.edit', $meeting->id) }}"
                                        class="btn btn-sm btn-outline-warning">

                                        <i class="fas fa-edit"></i>

                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="text-center py-5">
                                        <i
                                            class="far fa-calendar-times
                                              fa-4x
                                              text-muted mb-3"></i>

                                        <h5> No Meetings Found</h5>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div style="height: 25px;"></div>
@stop
