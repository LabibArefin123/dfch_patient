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

                        <input type="text" class="form-control mb-3" disabled
                            value="{{ $patient->recommend_note ?? '-' }}">
                    @endif

                    {{-- MEDICAL --}}
                    <h6 class="text-muted">Medical Information</h6>
                    <textarea class="form-control mb-2" rows="2" disabled>{{ $patient->patient_problem_description ?? 'N/A' }}</textarea>
                    <h6 class="text-muted">Drug Information</h6>
                    <textarea class="form-control mb-3" rows="2" disabled>{{ $patient->patient_drug_description ?? 'N/A' }}</textarea>

                    {{-- REMARKS --}}
                    <h6 class="text-muted">Remarks</h6>
                    <textarea class="form-control" rows="2" disabled>{{ $patient->remarks ?? 'No remarks' }}</textarea>

                </div>

                {{-- RIGHT IMAGE --}}
                <div class="col-md-3 d-flex justify-content-end">
                    <div class="text-center">
                        <div class="border rounded mb-2" style="width:200px;height:200px;">
                            <img src="{{ $patient->photo_path ? asset($patient->photo_path) : asset('images/patient_placeholder.png') }}"
                                alt="Patient Photo" class="img-fluid rounded"
                                style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <small class="text-muted">Patient Photo</small>
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
