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
                                <a href="{{ route('patients.show', $patient->id) }}" class="dev-link">
                                    {{ $patient->patient_code ?? '—' }}</a>
                            </td>

                            <td>
                                <a href="{{ route('patients.show', $patient->id) }}"
                                    class="dev-link"><strong>{{ $patient->patient_name }}</strong></a><br>
                                <small class="text-muted">
                                    <a href="{{ route('patients.show', $patient->id) }}" class="dev-link"> Father's Name:
                                        {{ $patient->patient_f_name ?? 'N/A' }}</a>
                                </small><br>
                                <small class="text-muted">
                                    <a href="{{ route('patients.show', $patient->id) }}" class="dev-link">Mother's Name:
                                        {{ $patient->patient_m_name ?? 'N/A' }}
                                </small></a>
                            </td>

                            <td><a href="{{ route('patients.show', $patient->id) }}"
                                    class="dev-link">{{ $patient->age ?? '—' }}</a></td>

                            <td>
                                <a href="{{ route('patients.show', $patient->id) }}"
                                    class="dev-link">{{ ucfirst($patient->gender ?? '—') }}</a>
                            </td>

                            <td>
                                {{-- Primary Phone --}}
                                @if ($patient->phone_1)
                                    <a href="{{ route('patients.show', $patient->id) }}" class="dev-link">
                                        {{ $patient->phone_1 }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif

                                <br>

                                {{-- Alternate Phone --}}
                                <small class="text-muted">
                                    @if ($patient->phone_2)
                                        <a href="{{ route('patients.show', $patient->id) }}" class="dev-link">
                                            Alt: {{ $patient->phone_2 }}
                                        </a>
                                    @else
                                        Alt: N/A
                                    @endif
                                </small>

                                <br>

                                {{-- Father Phone --}}
                                <small class="text-muted">
                                    @if ($patient->phone_f_1)
                                        <a href="{{ route('patients.show', $patient->id) }}" class="dev-link">
                                            Father’s Phone: {{ $patient->phone_f_1 }}
                                        </a>
                                    @else
                                        Father’s Phone: N/A
                                    @endif
                                </small>

                                <br>

                                {{-- Mother Phone --}}
                                <small class="text-muted">
                                    @if ($patient->phone_m_1)
                                        <a href="{{ route('patients.show', $patient->id) }}" class="dev-link">
                                            Mother’s Phone: {{ $patient->phone_m_1 }}
                                        </a>
                                    @else
                                        Mother’s Phone: N/A
                                    @endif
                                </small>
                            </td>

                            <td>
                                @if ($patient->location_type == 1)
                                    @if ($patient->location_simple)
                                        <a href="{{ route('patients.show', $patient->id) }}" class="dev-link">
                                            {{ $patient->location_simple }}
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                @elseif ($patient->location_type == 2)
                                    @if ($patient->city)
                                        <a href="{{ route('patients.show', $patient->id) }}" class="dev-link">
                                            {{ $patient->city }}
                                        </a>
                                    @else
                                        <span class="text-muted">City: N/A</span>
                                    @endif

                                    <br>

                                    @if ($patient->district)
                                        <a href="{{ route('patients.show', $patient->id) }}" class="dev-link">
                                            {{ $patient->district }}
                                        </a>
                                    @else
                                        <span class="text-muted">District: N/A</span>
                                    @endif
                                @else
                                    @if ($patient->country)
                                        <a href="{{ route('patients.show', $patient->id) }}" class="dev-link">
                                            {{ $patient->country }}
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
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
                                <a href="{{ route('patients.show', $patient->id) }}"
                                    class="dev-link">{{ optional($patient->date_of_patient_added)->format('d M Y') }}</a>
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
