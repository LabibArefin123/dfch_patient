@foreach ($patients as $patient)
    <div class="patient-card-column">

        <div class="patient-card-item">

            {{-- ORGANIZATION HEADER --}}
            <div class="patient-card-header">

                <div class="patient-card-brand">

                    @if ($organizationLogo)
                        <img src="{{ $organizationLogo }}" alt="Hospital Logo" class="organization-logo">
                    @else
                        <div class="hospital-brand">

                            <i class="fas fa-hospital"></i>

                            <span>Hospital</span>

                        </div>
                    @endif

                </div>


                <div class="patient-card-contact">

                    @if ($organization?->organization_location)
                        <div>

                            <i class="fas fa-map-marker-alt"></i>

                            {!! collect(explode(' ', $organization->organization_location))->chunk(3)->map(function ($words) {
                                    return implode(' ', $words->toArray());
                                })->implode('<br>') !!}

                        </div>
                    @endif


                    @if ($organization?->phone_1)
                        <div>

                            <i class="fas fa-phone-alt"></i>

                            {{ $organization->phone_1 }}

                        </div>
                    @endif

                </div>

            </div>


            {{-- PATIENT PHOTO --}}
            <div class="patient-card-photo-wrapper">

                <img src="{{ $patient->patient_photo && file_exists(public_path($patient->patient_photo))
                    ? asset($patient->patient_photo)
                    : asset('uploads/images/default.jpg') }}"
                    alt="{{ $patient->patient_name }}" class="patient-card-photo zoomable" data-action="zoom">

                {{-- Patient Code Floating Badge --}}
                <span class="patient-code-badge">

                    <i class="fas fa-id-card mr-1"></i>

                    {{ $patient->patient_code }}

                </span>

            </div>


            {{-- PATIENT BASIC INFO --}}
            <div class="patient-card-body">

                <h5 class="patient-name">

                    {{ $patient->patient_name }}

                </h5>


                <div class="patient-meta">

                    <span>

                        <i class="fas fa-venus-mars"></i>

                        {{ ucfirst($patient->gender ?? 'N/A') }}

                    </span>


                    <span>

                        <i class="fas fa-birthday-cake"></i>

                        {{ $patient->age ?? 'N/A' }}

                        yrs

                    </span>

                </div>


                {{-- DETAILS --}}
                <div class="patient-details">

                    <div class="patient-detail-item">

                        <span>

                            <i class="fas fa-user-friends"></i>

                            Father

                        </span>

                        <strong>

                            {{ $patient->patient_f_name ?? 'N/A' }}

                        </strong>

                    </div>


                    <div class="patient-detail-item">

                        <span>

                            <i class="fas fa-phone-alt"></i>

                            Phone

                        </span>

                        <strong>

                            {{ $patient->phone_1 ?? 'N/A' }}

                        </strong>

                    </div>

                </div>

            </div>


            {{-- ACTION --}}
            <div class="patient-card-actions">

                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-primary btn-sm">

                    <i class="fas fa-eye mr-1"></i>

                    View Patient

                </a>

            </div>

        </div>

    </div>
@endforeach
