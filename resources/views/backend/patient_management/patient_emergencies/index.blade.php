@extends('adminlte::page')

@section('title', 'Patient Emergency History')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1>
            Patient Emergency History
        </h1>
        <a href="{{ route('patient_emergencies.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus me-1"></i>
            Add Emergency History
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_emergency/patient_filter_button.css') }}">

        <div class="card-header">
            <div class="emergency-header">
                <h5 class="emergency-header-title">
                    <i class="fas fa-ambulance text-danger mr-2"></i>
                    Emergency History List
                </h5>

                <button type="button" class="btn btn-danger btn-sm emergency-filter-btn" id="emergencyFilterButton">
                    <i class="fas fa-filter mr-1"></i>
                    Filter
                </button>
            </div>
        </div>

        @include('backend.patient_management.modals.emegency_patient.index_page.full_reason_modal')
        <div class="card-body border-bottom d-none" id="emergencyFilterPanel">
            <div class="row align-items-end">
                <div class="col-lg-4 col-md-6 mb-3">
                    <label class="font-weight-semibold">
                        <i class="fas fa-search text-primary mr-1"></i>
                        Patient Search
                    </label>
                    <input type="text" id="emergencySearch" class="form-control"
                        placeholder="Patient code or patient name">
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="font-weight-semibold">
                        <i class="fas fa-exclamation-circle text-danger mr-1"></i>
                        Emergency Status
                    </label>
                    <select id="emergencyStatus" class="form-control">
                        <option value="">All Status</option>
                        <option value="emergency">Emergency</option>
                        <option value="normal">Normal</option>
                    </select>
                </div>

                <div class="col-lg-5 col-md-12 mb-3">
                    <label class="font-weight-semibold">
                        <i class="fas fa-calendar-alt text-info mr-1"></i>
                        Emergency Date
                    </label>

                    <select id="emergencyDateFilter" class="form-control">
                        <option value="">All Dates</option>
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="this_week">This Week</option>
                        <option value="last_week">Last Week</option>
                        <option value="last_2_weeks">Last 2 Weeks</option>
                        <option value="this_month">This Month</option>
                        <option value="custom">Custom Date</option>
                    </select>
                </div>
            </div>

            <div class="row d-none" id="emergencyCustomDate">
                <div class="col-lg-6 col-md-6 mb-3">
                    <label class="font-weight-semibold">
                        <i class="fas fa-calendar-day text-success mr-1"></i>
                        From Date
                    </label>
                    <input type="date" id="emergencyDateFrom" class="form-control">
                </div>

                <div class="col-lg-6 col-md-6 mb-3">
                    <label class="font-weight-semibold">
                        <i class="fas fa-calendar-check text-danger mr-1"></i>
                        To Date
                    </label>
                    <input type="date" id="emergencyDateTo" class="form-control">
                </div>
            </div>
        </div>

        <div class="card-body table-responsive">
            <div id="emergencyFilterLoading" class="text-center py-3 d-none"> <i
                    class="fas fa-spinner fa-spin fa-lg text-danger"></i>
                <div class="mt-2 text-muted">Loading emergency history...</div>
            </div>

            <table class="table table-bordered table-hover table-striped align-middle" id="dataTables">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width:60px;"> SL</th>
                        <th class="text-center">Patient Photo</th>
                        <th>Patient Code</th>
                        <th> Patient Name</th>
                        <th class="text-center"> Emergency Status</th>
                        <th>Reason</th>
                        <th class="text-center">Emergency Date</th>
                        <th class="text-center" style="width:220px;">Action</th>
                    </tr>
                </thead>

                <tbody id="emergencyTableBody">
                    @forelse($patientEmergencies as $emergency)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                @php
                                    $photo = $emergency->patient?->patient_image
                                        ? asset('uploads/images/patients/' . $emergency->patient->patient_image)
                                        : asset('uploads/images/default.jpg');
                                @endphp
                                <img src="{{ $photo }}" class="rounded shadow-sm"
                                    style="width:70px;height:70px;object-fit:cover;">
                            </td>
                            <td> {{ $emergency->patient?->patient_code ?? '-' }} </td>
                            <td>{{ $emergency->patient?->patient_name ?? '-' }}</td>
                            <td class="text-center">
                                @if ($emergency->is_emergency)
                                    <span class="badge bg-danger">Emergency</span>
                                @else
                                    <span class="badge bg-success">Normal</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $reason = $emergency->reason ?: '-';
                                    $words = preg_split('/\s+/', strip_tags($reason));
                                    $shortReason = count($words) > 10 ? implode(' ', array_slice($words, 0, 10)) : '';
                                @endphp

                                @if (count($words) > 10)
                                    <span>{{ $shortReason }}</span>
                                    <button type="button" class="btn btn-link btn-sm p-0 patient-full-reason-btn"
                                        data-reason="{{ $reason }}">
                                        [....]
                                    </button>
                                @else
                                    {{ $reason }}
                                @endif
                            </td>
                            <td class="text-center">{{ optional($emergency->emergency_date)->format('d M Y h:i A') }}</td>
                            <td class="text-center">
                                <a href="{{ route('patient_emergencies.show', $emergency->id) }}"
                                    class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                    Show
                                </a>

                                <a href="{{ route('patient_emergencies.edit', $emergency->id) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>

                                <form action="{{ route('patient_emergencies.destroy', $emergency->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this emergency history?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                No emergency history found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div style="height: 50px;"></div>
@stop

@section('js')
    <script>
        window.patientEmergencyRoutes = {
            show: "{{ route('patient_emergencies.show', '__ID__') }}",
            edit: "{{ route('patient_emergencies.edit', '__ID__') }}",
            destroy: "{{ route('patient_emergencies.destroy', '__ID__') }}",
            csrf: "{{ csrf_token() }}"
        };
    </script>
    <script src="{{ asset('js/backend/patient_management/emergency_patient/index_page/emergency_filter.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/emergency_patient/index_page/emergency_full_reason_modal.js') }}">
    </script>
@endsection
