@extends('adminlte::page')

@section('title', 'Add Patient Emergency')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add Patient Emergency</h3>

        <a href="{{ route('patient_emergencies.index') }}"
            class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('patient_emergencies.store') }}" method="POST" data-confirm="create">

                @csrf

                <div class="row">

                    <div class="form-group col-md-6 mb-3">
                        <label for="patientSelect">
                            Patient
                            <span class="text-danger">*</span>
                        </label>

                        <select id="patientSelect" name="patient_id"
                            class="form-control @error('patient_id') is-invalid @enderror">

                            <option value="">Select Patient</option>

                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    data-search="{{ strtolower($patient->patient_name . ' ' . $patient->patient_code) }}"
                                    {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->patient_name }}
                                    ({{ $patient->patient_code }})
                                </option>
                            @endforeach

                        </select>

                        @error('patient_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Emergency Status --}}
                    <div class="form-group col-md-6 mb-3">
                        <label for="is_emergency">
                            Emergency Status
                            <span class="text-danger">*</span>
                        </label>

                        <select name="is_emergency" id="is_emergency"
                            class="form-control @error('is_emergency') is-invalid @enderror">

                            <option value="1" {{ old('is_emergency', '1') == '1' ? 'selected' : '' }}>
                                Yes
                            </option>

                            <option value="0" {{ old('is_emergency') == '0' ? 'selected' : '' }}>
                                No
                            </option>

                        </select>

                        @error('is_emergency')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Emergency Date --}}
                    <div class="form-group col-md-6 mb-3">
                        <label for="emergency_date">
                            Emergency Date
                            <span class="text-danger">*</span>
                        </label>

                        <input type="datetime-local" name="emergency_date" id="emergency_date"
                            value="{{ old('emergency_date') }}"
                            class="form-control @error('emergency_date') is-invalid @enderror">

                        @error('emergency_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Reason --}}
                    <div class="form-group col-md-12 mb-3">
                        <label for="reason">
                            Emergency Reason
                        </label>

                        <textarea name="reason" id="reason" rows="5" class="form-control @error('reason') is-invalid @enderror"
                            placeholder="Write emergency details here...">{{ old('reason') }}</textarea>

                        @error('reason')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success px-4">
                        Save
                    </button>
                </div>

            </form>

        </div>
    </div>
    <script src="{{ asset('js/backend/patient_management/emergency_patient/create_page/patient_list.js') }}"></script>
@stop
