@extends('adminlte::page')

@section('title', 'Patient Cancer Photos')
@section('content_header')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">

        {{-- Page Title --}}
        <div class="mb-3 mb-md-0">

            <h1 class="mb-1 font-weight-bold">

                <i class="fas fa-x-ray text-danger mr-2"></i>

                Patient Cancer Reports

            </h1>

            <small class="text-muted">

                <i class="fas fa-info-circle mr-1"></i>

                Manage patient X-ray images and cancer reports

            </small>

        </div>


        {{-- Action Buttons --}}
        <div class="d-flex flex-wrap align-items-center">

            {{-- Sync Patients --}}
            <button type="button" id="cancerPatientSyncModal" class="btn btn-outline-primary mr-2 mb-2 mb-md-0">

                <i class="fas fa-sync-alt mr-1"></i>

                Sync Patients

            </button>


            {{-- Add New Report --}}
            <a href="{{ route('patient-cancer-photos.create') }}" class="btn btn-success mb-2 mb-md-0">

                <i class="fas fa-plus-circle mr-1"></i>

                Add New Report

            </a>

        </div>

    </div>

@stop


@section('content')
    @include('backend.patient_management.modals.patient_cancer.index_page.patient_sync_modal')
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
                                        <div class="d-flex flex-wrap align-items-center">
                                            @foreach ($report->xray_photo as $photo)
                                                <style>
                                                    /* Premium Hover Animation for Thumbnails */
                                                    .magnify-img:hover {
                                                        transform: scale(1.08) translateY(-2px);
                                                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
                                                    }

                                                    /* Styling for the premium close button hover effect */
                                                    .zoom-modal-close-btn {
                                                        cursor: pointer;
                                                    }

                                                    .zoom-modal-close-btn:hover {
                                                        background: rgba(255, 255, 255, 0.15) !important;
                                                        border-color: rgba(255, 255, 255, 0.4) !important;
                                                        transform: scale(1.05);
                                                        color: #ffffff !important;
                                                        box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1) !important;
                                                    }

                                                    .zoom-modal-close-btn:active {
                                                        transform: scale(0.95);
                                                    }
                                                </style>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                                    data-bs-img-src="{{ asset($photo) }}" style="text-decoration: none;">
                                                    <img src="{{ asset($photo) }}" class="img-thumbnail m-1 magnify-img"
                                                        alt="X-Ray Photo"
                                                        style="
                                                        width: 80px;
                                                        height: 80px;
                                                        object-fit: cover;
                                                        cursor: zoom-in;
                                                            transition: transform 0.2s ease, box-shadow 0.2s ease;
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

    <script src="{{ asset('js/backend/patient_management/patient_cancer/index_page/patient_cancer_sync.js') }}"></script>
@stop
