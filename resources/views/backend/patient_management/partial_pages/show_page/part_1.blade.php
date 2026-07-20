<div class="row">

    <div class="col-md-6 mb-3">

        <div class="patient-info-item">

            <span class="patient-info-label">
                <i class="fas fa-user-tie mr-1"></i>
                Father's Name
            </span>

            <strong>
                {{ $patient->patient_f_name ?? 'N/A' }}
            </strong>

        </div>

    </div>


    <div class="col-md-6 mb-3">

        <div class="patient-info-item">

            <span class="patient-info-label">
                <i class="fas fa-female mr-1"></i>
                Mother's Name
            </span>

            <strong>
                {{ $patient->patient_m_name ?? 'N/A' }}
            </strong>

        </div>

    </div>


    <div class="col-md-6">

        <div class="patient-info-item">

            <span class="patient-info-label">
                <i class="fas fa-birthday-cake mr-1"></i>
                Age
            </span>

            <strong>
                {{ $patient->age ?? 'N/A' }}
                @if ($patient->age)
                    <small class="text-muted">years</small>
                @endif
            </strong>

        </div>

    </div>


    <div class="col-md-6">

        <div class="patient-info-item">

            <span class="patient-info-label">
                <i class="fas fa-venus-mars mr-1"></i>
                Gender
            </span>

            <strong class="text-uppercase">
                {{ $patient->gender ?? 'N/A' }}
            </strong>

        </div>

    </div>

</div>
