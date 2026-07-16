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
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-ambulance text-danger me-2"></i>
                Emergency History List
            </h5>
        </div>

        <div class="card-body table-responsive">
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
                        <th class="text-center"> Created At </th>
                        <th class="text-center" style="width:220px;">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($patientEmergencies as $emergency)
                        <tr>

                            <td class="text-center">

                                {{ $loop->iteration }}

                            </td>

                            {{-- Patient Photo --}}
                            <td class="text-center">

                                @php
                                    $photo = $emergency->patient?->patient_image
                                        ? asset('uploads/images/patients/' . $emergency->patient->patient_image)
                                        : asset('uploads/images/default.jpg');
                                @endphp

                                <img src="{{ $photo }}" class="rounded shadow-sm"
                                    style="width:70px;height:70px;object-fit:cover;">

                            </td>

                            <td>

                                {{ $emergency->patient?->patient_code ?? '-' }}

                            </td>

                            <td>

                                {{ $emergency->patient?->patient_name ?? '-' }}

                            </td>

                            <td class="text-center">

                                @if ($emergency->is_emergency)
                                    <span class="badge bg-danger">

                                        Emergency

                                    </span>
                                @else
                                    <span class="badge bg-success">

                                        Normal

                                    </span>
                                @endif

                            </td>

                            <td>

                                {{ $emergency->reason ?: '-' }}

                            </td>

                            <td class="text-center">

                                {{ optional($emergency->emergency_date)->format('d M Y h:i A') }}

                            </td>

                            <td class="text-center">

                                {{ $emergency->created_at->format('d M Y') }}

                            </td>

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
                            <td colspan="9" class="text-center text-muted py-4">
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

@section('css')

    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }

        .badge {
            font-size: .85rem;
        }
    </style>

@stop

@section('js')

    <script>
        $(function() {

            $('#dataTables').DataTable({

                responsive: true,

                pageLength: 25,

                ordering: true,

                searching: true,

                autoWidth: false

            });

        });
    </script>

@stop
