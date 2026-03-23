@extends('adminlte::page')

@section('title', 'Patient Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Patient Details </h1>
        <div>
            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('patients.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">

                {{-- LEFT CONTENT --}}
                <div class="col-md-9">

                    {{-- HEADER --}}
                    <div class="form-group">
                        <label>Patient Name</label>
                        <input type="text" class="form-control" disabled
                            value="{{ $patient->patient_name }} ({{ $patient->patient_code ?? 'N/A' }})">
                    </div>

                    {{-- BASIC INFO --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Father's Name</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $patient->patient_f_name ?? 'N/A' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mother's Name</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $patient->patient_m_name ?? 'N/A' }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Age</label>
                                <input type="text" class="form-control" disabled value="{{ $patient->age ?? 'N/A' }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Gender</label>
                                <input type="text" class="form-control text-uppercase" disabled
                                    value="{{ $patient->gender ?? 'N/A' }}">
                            </div>
                        </div>
                    </div>

                    {{-- CONTACT --}}
                    <h6 class="text-muted mt-3">Contact Information</h6>
                    <div class="row">

                        <div class="col-md-3 mb-2">
                            <div class="form-control bg-light">
                                Personal:
                                <span class="dev-link text-primary font-weight-bold" data-phone="{{ $patient->phone_1 }}">
                                    {{ $patient->phone_1 }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2">
                            <div class="form-control bg-light">
                                Alt:
                                <span class="dev-link text-primary font-weight-bold" data-phone="{{ $patient->phone_2 }}">
                                    {{ $patient->phone_2 ?? 'N/A' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2">
                            <div class="form-control bg-light">
                                Father:
                                <span class="dev-link text-primary font-weight-bold"
                                    data-phone="{{ $patient->phone_f_1 }}">
                                    {{ $patient->phone_f_1 ?? 'N/A' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2">
                            <div class="form-control bg-light">
                                Mother:
                                <span class="dev-link text-primary font-weight-bold"
                                    data-phone="{{ $patient->phone_m_1 }}">
                                    {{ $patient->phone_m_1 ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Call Confirmation Modal -->
                    <div class="modal fade" id="callConfirmModal" tabindex="-1" role="dialog" aria-hidden="true"
                        data-backdrop="true" data-keyboard="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content shadow">

                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title">📞 Confirm Call</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body text-center">
                                    <p class="mb-1">Do you want to call this number?</p>
                                    <h5 class="text-primary" id="selectedPhone"></h5>
                                </div>

                                <div class="modal-footer justify-content-center">
                                    <button type="button" class="btn btn-secondary" id="cancelCall">No</button>
                                    <a href="#" target="_blank" id="confirmWhatsapp" class="btn btn-success">Yes
                                        (WhatsApp)</a>
                                </div>

                            </div>
                        </div>
                    </div>


                    {{-- LOCATION --}}
                    <h6 class="text-muted mt-3">Location</h6>

                    <p class="form-control mb-2 bg-light">
                        @if ($patient->location_type == 1)
                            {{ $patient->location_simple }}
                        @elseif ($patient->location_type == 2)
                            {{ $patient->house_address }},
                            {{ $patient->city }},
                            {{ $patient->district }} - {{ $patient->post_code }}
                        @else
                            {{ $patient->country }}, Passport Number = {{ $patient->passport_no }}
                            <br>
                        @endif
                    </p>

                    {{-- RECOMMENDATION --}}
                    @if ($patient->is_recommend)
                        <h6 class="text-muted mt-3">Doctor Recommendation</h6>
                        <input type="text" class="form-control mb-2" disabled
                            value="{{ $patient->recommend_doctor_name }}">

                        <div class="form-control mb-3" style="height:auto;">
                            {!! $patient->recommend_note ?? '-' !!}
                        </div>
                    @endif

                    {{-- MEDICAL --}}
                    <h6 class="text-muted">Medical Information</h6>

                    <div class="form-control mb-3" style="height:auto;">
                        {!! $patient->patient_problem_description ?? '-' !!}
                    </div>
                    <h6 class="text-muted">Drug Information</h6>
                    <div class="form-control mb-3" style="height:auto;">
                        {!! $patient->patient_drug_description ?? '-' !!}
                    </div>

                    {{-- REMARKS --}}
                    <h6 class="text-muted">Remarks</h6>
                    <div class="form-control mb-3" style="height:auto;">
                        {!! $patient->remarks ?? '-' !!}
                    </div>
                </div>

                {{-- RIGHT IMAGE --}}
                <div class="col-md-3 d-flex justify-content-end">
                    <style>
                        .patient-photo-box {
                            width: 200px;
                            height: 200px;
                            border-radius: 12px;
                            overflow: hidden;
                            border: 3px solid #e9ecef;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                            transition: 0.3s ease;
                        }

                        .patient-photo-box:hover {
                            transform: scale(1.03);
                            border-color: #007bff;
                        }

                        .patient-photo-img {
                            width: 100%;
                            height: 100%;
                            object-fit: contain;
                            /* 🔥 FORCE SQUARE */
                        }

                        .zoom-modal {
                            display: none;
                            position: fixed;
                            z-index: 9999;
                            padding-top: 60px;
                            left: 0;
                            top: 0;
                            width: 100%;
                            height: 100%;
                            overflow: auto;
                            background-color: rgba(0, 0, 0, 0.9);
                        }

                        .zoom-modal-content {
                            margin: auto;
                            display: block;
                            max-width: 80%;
                            max-height: 80%;
                            border-radius: 10px;
                        }

                        .zoom-close {
                            position: absolute;
                            top: 20px;
                            right: 35px;
                            color: #fff;
                            font-size: 40px;
                            font-weight: bold;
                            cursor: pointer;
                        }
                    </style>
                    <div class="text-center">

                        <div class="patient-photo-box mb-2">

                            <img src="{{ $patient->patient_photo && file_exists(public_path($patient->patient_photo))
                                ? asset($patient->patient_photo)
                                : asset('uploads/images/default.jpg') }}"
                                alt="Patient Photo" class="patient-photo-img zoomable" data-action="zoom">

                        </div>

                        <small class="text-muted">Patient Photo</small>

                    </div>
                    <!-- Image Zoom Modal -->
                    <div id="imageZoomModal" class="zoom-modal">
                        <span class="zoom-close">&times;</span>
                        <img class="zoom-modal-content" id="zoomedImage">
                    </div>

                </div>

            </div>

        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/backend/patient_management/zoom.js') }}"></script>
    <script>
        $(document).on('click', '.dev-link', function() {

            let phone = $(this).data('phone');

            if (!phone || phone === 'N/A') {
                return;
            }

            phone = phone.toString().replace(/[^0-9]/g, '');

            $('#selectedPhone').text(phone);
            $('#confirmWhatsapp').attr('href', 'https://wa.me/' + phone);

            $('#callConfirmModal').modal('show');
            $('#cancelCall').on('click', function() {
                $('#callConfirmModal').modal('hide');
            });
        });
    </script>
@endsection
