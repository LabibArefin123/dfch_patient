@forelse ($patients as $patient)
    <div class="patient-card-column">

        <div class="patient-card-item">

            {{-- PHOTO --}}
            <div class="patient-card-photo-wrapper">

                @if ($patient->patient_photo && file_exists(public_path($patient->patient_photo)))
                    <img src="{{ asset($patient->patient_photo) }}" alt="{{ $patient->patient_name }}"
                        class="patient-card-photo" loading="lazy">
                @else
                    <div class="patient-card-placeholder">

                        <i class="fas fa-user"></i>

                    </div>
                @endif

            </div>


            {{-- CONTENT --}}
            <div class="patient-card-body">

                <div class="patient-card-name" title="{{ $patient->patient_name }}">

                    {{ $patient->patient_name }}

                </div>


                <div class="patient-card-code">

                    <i class="fas fa-id-badge mr-1"></i>

                    {{ $patient->patient_code }}

                </div>


                <div class="patient-card-info">

                    <i class="fas fa-user"></i>

                    <span>

                        {{ $patient->age ?? 'N/A' }}

                        years

                    </span>

                    <span>•</span>

                    <span>

                        {{ ucfirst($patient->gender ?? 'N/A') }}

                    </span>

                </div>


                @if ($patient->phone_1)
                    <div class="patient-card-info">

                        <i class="fas fa-phone"></i>

                        <span>

                            {{ $patient->phone_1 }}

                        </span>

                    </div>
                @endif


                {{-- ACTIONS --}}
                <div class="patient-card-actions">

                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-outline-primary">

                        <i class="fas fa-eye"></i>

                    </a>


                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-outline-warning">

                        <i class="fas fa-edit"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

@empty

    {{-- Empty handled by AJAX response --}}
@endforelse
