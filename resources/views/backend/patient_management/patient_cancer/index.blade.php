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
            <button type="button" id="syncCancerPatientsBtn" class="btn btn-outline-primary mr-2 mb-2 mb-md-0">

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
    <link rel="stylesheet" href="{{ asset('css/backend/patient_page/patient_cancer/index_page/patient_info.css') }}">
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
                    {{-- PATIENT AGE INFO --}}
                    <tbody>
                        @forelse($patientCancerPhotos as $report)
                            <tr>
                                <td class="text-center align-middle">
                                    {{ $loop->iteration + ($patientCancerPhotos->firstItem() - 1) }}
                                </td>
                              
                                <td class="patient-info-td">

                                    @if (isset($report->patient))
                                        <div class="patient-info-card">

                                            {{-- Patient Avatar --}}
                                            <div class="patient-info-avatar">
                                                <i class="fas fa-user-injured"></i>
                                            </div>

                                            {{-- Patient Details --}}
                                            <div class="patient-info-content">

                                                {{-- Patient Name --}}
                                                <div class="patient-info-name">
                                                    {{ $report->patient->patient_name }}
                                                </div>

                                                {{-- Patient Code --}}
                                                @if (!empty($report->patient->patient_code))
                                                    <div class="patient-info-code">
                                                        <i class="fas fa-id-card"></i>
                                                        <span>
                                                            {{ $report->patient->patient_code }}
                                                        </span>
                                                    </div>
                                                @endif

                                                {{-- Patient Age --}}
                                                @if (isset($report->patient->age))
                                                    <div class="patient-info-age">
                                                        <i class="fas fa-birthday-cake"></i>

                                                        <span>
                                                            {{ $report->patient->age }}

                                                            @if ($report->patient->age == 1)
                                                                year old
                                                            @else
                                                                years old
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endif

                                                @if (
                                                    !empty($report->patient->phone_1) ||
                                                        !empty($report->patient->phone_2) ||
                                                        !empty($report->patient->phone_f_1) ||
                                                        !empty($report->patient->phone_m_1))
                                                    <div class="patient-info-phones">

                                                        {{-- Primary Phone --}}
                                                        @if (!empty($report->patient->phone_1))
                                                            <div class="patient-phone-item primary">
                                                                <i class="fas fa-phone"></i>

                                                                <span>
                                                                    {{ $report->patient->phone_1 }}
                                                                </span>

                                                                <small>Primary</small>
                                                            </div>
                                                        @endif


                                                        {{-- Secondary Phone --}}
                                                        @if (!empty($report->patient->phone_2))
                                                            <div class="patient-phone-item">
                                                                <i class="fas fa-phone-alt"></i>

                                                                <span>
                                                                    {{ $report->patient->phone_2 }}
                                                                </span>

                                                                <small>Secondary</small>
                                                            </div>
                                                        @endif


                                                        {{-- Father's Phone --}}
                                                        @if (!empty($report->patient->phone_f_1))
                                                            <div class="patient-phone-item">
                                                                <i class="fas fa-male"></i>

                                                                <span>
                                                                    {{ $report->patient->phone_f_1 }}
                                                                </span>

                                                                <small>Father</small>
                                                            </div>
                                                        @endif


                                                        {{-- Mother's Phone --}}
                                                        @if (!empty($report->patient->phone_m_1))
                                                            <div class="patient-phone-item">
                                                                <i class="fas fa-female"></i>

                                                                <span>
                                                                    {{ $report->patient->phone_m_1 }}
                                                                </span>

                                                                <small>Mother</small>
                                                            </div>
                                                        @endif

                                                    </div>
                                                @endif

                                            </div>

                                        </div>
                                    @else
                                        <div class="patient-info-empty">
                                            <i class="fas fa-user-slash"></i>
                                            <span>Patient information unavailable</span>
                                        </div>
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
                                <td class="description-column">
                                    @if (!empty($report->description_preview))
                                        <div class="content-preview">

                                            @foreach ($report->description_preview as $description)
                                                <div class="preview-item">
                                                    {!! nl2br(e(\Illuminate\Support\Str::limit($description, 180))) !!}
                                                </div>
                                            @endforeach

                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif

                                </td>
                                <td class="remarks-column">

                                    @if (!empty($report->remarks_preview))
                                        <div class="content-preview">

                                            <div class="preview-item">
                                                {!! nl2br(e(\Illuminate\Support\Str::limit($report->remarks_preview, 220))) !!}
                                            </div>

                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif

                                </td>
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
                                        class="d-inline deleteConfirmModal">
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

@section('js')
    <script>
        window.PatientCancerSync = {
            syncUrl: @json(route('patient-cancer-photos.sync'))
        };
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/index_page/patient_age.js') }}"></script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/index_page/patient_cancer_sync_init.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/index_page/patient_cancer_sync_ui.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/index_page/patient_cancer_sync_request.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/index_page/patient_cancer_sync_animation.js') }}">
    </script>
    <script src="{{ asset('js/backend/patient_management/patient_cancer/index_page/patient_cancer_sync_status.js') }}">
    </script>
@stop
