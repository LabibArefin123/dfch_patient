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
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Patient Code</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Recommended</th>
                        <th>Date of Patient Added</th>
                        <th>Actions</th>
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
                                    Father's Name: {{ $patient->patient_f_name ?? 'N/A' }}
                                </small><br>
                                <small class="text-muted">
                                    Mother's Name: {{ $patient->patient_m_name ?? 'N/A' }}
                                </small>
                            </td>

                            <td>{{ $patient->age ?? '—' }}</td>

                            <td>
                                {{ ucfirst($patient->gender ?? '—') }}
                            </td>

                            <td>
                                {{ $patient->phone_1 }}<br>
                                <small class="text-muted">
                                    Alt {{ $patient->phone_2 ?? 'N/A' }}
                                </small>
                                <br>
                                <small class="text-muted">
                                    Father's Phone {{ $patient->phone_f_1 ?? 'N/A' }}
                                </small>
                                <br>
                                <small class="text-muted">
                                    Mother's Phone {{ $patient->phone_m_1 ?? 'N/A' }}
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
                                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm mb-1">
                                    View
                                </a>

                                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning btn-sm mb-1">
                                    Edit
                                </a>

                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="triggerDeleteModal('{{ route('patients.destroy', $patient->id) }}')">
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
    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>
@stop
