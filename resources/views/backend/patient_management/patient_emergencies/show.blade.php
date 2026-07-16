@extends('adminlte::page')

@section('title', 'Patient Emergency Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Patient Emergency Details</h3>

        <div class="d-flex gap-2">
            <a href="{{ route('patient_emergencies.edit', $patientEmergency) }}" class="btn btn-warning">
                <i class="fas fa-edit mr-1"></i>
                Edit
            </a>

            <a href="{{ route('patient_emergencies.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i>
                Back
            </a>
        </div>
    </div>
@stop

@section('content')

    <div class="row align-items-stretch">
        {{-- Patient Information --}}
        <div class="col-lg-4 d-flex">

            <div class="card card-primary card-outline shadow-sm w-100">

                <div class="card-body d-flex flex-column justify-content-center text-center">

                    <img src="{{ !empty($patientEmergency->patient->patient_image)
                        ? asset('uploads/images/patients/' . $patientEmergency->patient->patient_image)
                        : asset('uploads/images/default.jpg') }}"
                        class="rounded-circle shadow mx-auto d-block mb-3"
                        style="width:140px;height:140px;object-fit:cover;">

                    <h4 class="mb-1 font-weight-bold">
                        {{ $patientEmergency->patient->patient_name }}
                    </h4>

                    <p class="text-muted mb-3">
                        {{ $patientEmergency->patient->patient_code }}
                    </p>

                    @if ($patientEmergency->is_emergency)
                        <span class="badge badge-danger px-3 py-2 align-self-center">
                            <i class="fas fa-ambulance mr-1"></i>
                            Emergency Patient
                        </span>
                    @else
                        <span class="badge badge-success px-3 py-2 align-self-center">
                            <i class="fas fa-check-circle mr-1"></i>
                            Normal
                        </span>
                    @endif

                </div>

            </div>

        </div>


        {{-- Emergency Details --}}
        <div class="col-lg-8 d-flex">

            <div class="card shadow-sm w-100">

                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-notes-medical text-danger"></i>
                        Emergency Information
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-4">

                            <label class="text-muted small">
                                Patient Name
                            </label>

                            <h5>
                                {{ $patientEmergency->patient->patient_name }}
                            </h5>

                        </div>

                        <div class="col-md-6 mb-4">

                            <label class="text-muted small">
                                Patient Code
                            </label>

                            <h5>
                                {{ $patientEmergency->patient->patient_code }}
                            </h5>

                        </div>

                        <div class="col-md-6 mb-4">

                            <label class="text-muted small">
                                Emergency Status
                            </label>

                            <br>

                            @if ($patientEmergency->is_emergency)
                                <span class="badge badge-danger px-3 py-2">
                                    YES
                                </span>
                            @else
                                <span class="badge badge-success px-3 py-2">
                                    NO
                                </span>
                            @endif

                        </div>

                        <div class="col-md-6 mb-4">

                            <label class="text-muted small">
                                Emergency Date
                            </label>

                            <h5>
                                {{ optional($patientEmergency->emergency_date)->format('d M Y, h:i A') }}
                            </h5>

                        </div>

                        <div class="col-12">

                            <label class="text-muted small">
                                Emergency Reason
                            </label>

                            <div class="border rounded p-3 bg-light">

                                @if ($patientEmergency->reason)
                                    {!! nl2br(e($patientEmergency->reason)) !!}
                                @else
                                    <span class="text-muted">
                                        No emergency reason provided.
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@stop
