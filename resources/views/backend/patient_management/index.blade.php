@extends('adminlte::page')

@section('title', 'Patients')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Patients</h1>
        <a href="{{ route('patients.create') }}" class="btn btn-success btn-sm">
            Add Patient
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Patient Code</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Recommended</th>
                                <th>Added Date</th>
                                <th width="160">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($patients as $patient)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        {{ $patient->patient_code ?? '—' }}
                                    </td>

                                    <td>
                                        <strong>{{ $patient->patient_name }}</strong><br>
                                        <small class="text-muted">
                                            F: {{ $patient->patient_f_name ?? 'N/A' }}
                                        </small>
                                    </td>

                                    <td>{{ $patient->age ?? '—' }}</td>

                                    <td>
                                        {{ ucfirst($patient->gender ?? '—') }}
                                    </td>

                                    <td>
                                        {{ $patient->phone_1 }}<br>
                                        <small class="text-muted">
                                            {{ $patient->phone_2 ?? '' }}
                                        </small>
                                    </td>

                                    <td>
                                        @if ($patient->location_type == 1)
                                            {{ $patient->location_simple }}
                                        @elseif ($patient->location_type == 2)
                                            {{ $patient->city }}, {{ $patient->district }}
                                        @else
                                            {{ $patient->country }}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($patient->is_recommend)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ optional($patient->date_of_patient_added)->format('d M Y') }}
                                    </td>

                                    <td>
                                        <a href="{{ route('patients.show', $patient->id) }}"
                                            class="btn btn-info btn-sm mb-1">
                                            View
                                        </a>

                                        <a href="{{ route('patients.edit', $patient->id) }}"
                                            class="btn btn-warning btn-sm mb-1">
                                            Edit
                                        </a>

                                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
                                            style="display:inline-block" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        No patients found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
