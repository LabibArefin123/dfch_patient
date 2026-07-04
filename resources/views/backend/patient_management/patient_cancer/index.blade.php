@extends('adminlte::page')

@section('title', 'Patient Cancer Photos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1>
                <i class="fas fa-x-ray text-danger"></i>
                Patient Cancer Reports
            </h1>

            <small class="text-muted">
                Manage Patient X-Ray Images & Cancer Reports
            </small>
        </div>

        <div>
            <a href="{{ route('patient-cancer-photos.create') }}" class="btn btn-success">

                <i class="fas fa-plus-circle"></i>
                Add New Report
            </a>
        </div>

    </div>
@stop


@section('content')

    <div class="container-fluid">
        <div class="card card-outline card-danger">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title">
                            <i class="fas fa-list"></i>
                            Cancer Report List
                        </h3>
                    </div>

                    <div class="col-md-4">
                        <form method="GET" action="{{ route('patient-cancer-photos.index') }}">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search Patient Name / Code" value="{{ request('search') }}">

                                <div class="input-group-append">
                                    <button class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>

                                    @if (request('search'))
                                        <a href="{{ route('patient-cancer-photos.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-sync"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover table-bordered" id="dataTables">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th width="60">#</th>
                            <th>Patient</th>
                            <th>Total Cancer</th>
                            <th>X-Ray Images</th>
                            <th>Description</th>
                            <th>Remarks</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($patientCancerPhotos as $report)
                            <tr>
                                <td class="text-center align-middle">
                                    {{ $loop->iteration + ($patientCancerPhotos->firstItem() - 1) }}
                                </td>
                                <td>
                                    <strong class="text-primary">
                                        {{ $report->patient->patient_name ?? 'N/A' }}
                                    </strong>
                                    <br>
                                    <small class="text-muted">
                                        Code :
                                        {{ $report->patient->patient_code ?? 'N/A' }}
                                    </small>
                                    <br>
                                    <small>
                                        <i class="fas fa-phone text-success"></i>
                                        {{ $report->patient->phone_1 ?? '-' }}
                                    </small>

                                    @if (isset($report->patient->age))
                                        <br>
                                        <small>
                                            Age :
                                            <span class="badge badge-info">
                                                {{ $report->patient->age }}
                                            </span>
                                        </small>
                                    @endif
                                </td>

                                <td class="text-center align-middle">
                                    <span class="badge badge-danger p-2">
                                        {{ $report->total_cancer }}
                                    </span>
                                </td>

                                <td>
                                    @if (!empty($report->xray_photo) && is_array($report->xray_photo))
                                        <div class="d-flex flex-wrap">
                                            @foreach ($report->xray_photo as $photo)
                                                <a href="{{ asset($photo) }}" target="_blank">
                                                    <img src="{{ asset($photo) }}" class="img-thumbnail m-1"
                                                        style="
                            width: 80px;
                            height: 80px;
                            object-fit: cover;
                        ">
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>

                                <td>
                                    @if (!empty($report->xray_description))
                                        <ul class="pl-3 mb-0">
                                            @foreach ($report->xray_description as $description)
                                                <li> {{ $description }} </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">No Description</span>
                                    @endif

                                </td>

                                <td>{{ $report->remarks ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('patient-cancer-photos.show', $report->id) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('patient-cancer-photos.edit', $report->id) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('patient-cancer-photos.destroy', $report->id) }}" method="POST"
                                        class="d-inline deleteForm">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    <i class="fas fa-folder-open fa-2x"></i>
                                    <br><br>
                                    No Cancer Report Found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">

                <div class="float-left mt-2">
                    Showing
                    <strong>{{ $patientCancerPhotos->firstItem() ?? 0 }}</strong>
                    to
                    <strong>{{ $patientCancerPhotos->lastItem() ?? 0 }}</strong>
                    of
                    <strong>{{ $patientCancerPhotos->total() }}</strong>
                    record(s)
                </div>
            </div>
        </div>
    </div>
@stop


@section('css')

    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }

        .img-thumbnail {
            transition: .25s;
        }

        .img-thumbnail:hover {
            transform: scale(1.08);
            box-shadow: 0 2px 12px rgba(0, 0, 0, .25);
        }

        .badge {
            font-size: 13px;
        }
    </style>

@stop


@section('js')

    <script>
        $(function() {

            /*
            |--------------------------------------------------------------------------
            | Auto Hide Alert
            |--------------------------------------------------------------------------
            */

            setTimeout(function() {

                $('.alert').fadeOut('slow');

            }, 4000);


            /*
            |--------------------------------------------------------------------------
            | Delete Confirmation
            |--------------------------------------------------------------------------
            */

            $('.deleteForm').submit(function(e) {

                e.preventDefault();

                let form = this;

                Swal.fire({

                    title: 'Delete Report?',

                    text: 'All uploaded X-Ray images will also be deleted.',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#d33',

                    cancelButtonColor: '#6c757d',

                    confirmButtonText: 'Yes, Delete',

                    cancelButtonText: 'Cancel'

                }).then((result) => {

                    if (result.isConfirmed) {

                        form.submit();

                    }

                });

            });

        });
    </script>

@stop
