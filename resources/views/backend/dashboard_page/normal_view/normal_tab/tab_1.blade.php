<div class="tab-pane active" id="normalView">
    <div class="row">

        {{-- Patient Stats 4x4 layout --}}
        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $totalPatients }}" text="Total Patients" theme="info" icon="fas fa-users"
                url="{{ route('patients.index') }}" />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $todayPatients }}" text="Registered Today" theme="light"
                icon="fas fa-calendar-day" url="{{ route('patients.index', ['date_filter' => 'today']) }}" />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $weeklyPatients }}" text="This Week" theme="primary"
                icon="fas fa-calendar-week" url="{{ route('patients.index', ['date_filter' => 'last_7_days']) }}" />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $monthlyPatients }}" text="This Month" theme="secondary"
                icon="fas fa-calendar-alt" url="{{ route('patients.index', ['date_filter' => 'this_month']) }}" />
        </div>

        {{-- Recommended Patients --}}
        <div class="col-12 mt-1">
            <hr>
            <h5 class="text-info font-weight-bold">⭐ Recommended Patients Overview</h5>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $totalRecommendedPatients }}" text="Total Recommended" theme="danger"
                icon="fas fa-user-md" url="{{ route('patients.recommend', ['is_recommend' => 1]) }}" />
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $todayRecommendedPatients }}" text="Today's Recommended" theme="warning"
                icon="fas fa-stethoscope"
                url="{{ route('patients.recommend', ['is_recommend' => 1, 'date_filter' => 'today']) }}" />
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $weeklyRecommendedPatients }}" text="Weekly Recommended" theme="warning"
                icon="fas fa-stethoscope"
                url="{{ route('patients.recommend', ['is_recommend' => 1, 'date_filter' => 'this_week']) }}" />
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $monthlyRecommendedPatients }}" text="Monthly Recommended" theme="success"
                icon="fas fa-chart-line"
                url="{{ route('patients.recommend', ['is_recommend' => 1, 'date_filter' => 'this_month']) }}" />
        </div>

        {{-- Emergency Patient History --}}
        <div class="col-12 mt-1">
            <hr>
            <h5 class="text-primary font-weight-bold">
                <i class="fas fa-ambulance mr-1"></i>
                Emergency Patient History Overview
            </h5>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $totalEmergencyPatientHistory }}" text="Total Emergency History"
                theme="primary" icon="fas fa-ambulance" url="{{ route('patient_emergencies.index') }}" />
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $todayEmergencyPatientHistory }}" text="Today's Emergency History"
                theme="warning" icon="fas fa-first-aid"
                url="{{ route('patient_emergencies.index', ['date_filter' => 'today']) }}" />
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $weeklyEmergencyPatientHistory }}" text="Weekly Emergency History"
                theme="warning" icon="fas fa-first-aid"
                url="{{ route('patient_emergencies.index', ['date_filter' => 'weekly']) }}" />
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $monthlyEmergencyPatientHistory }}" text="Monthly Emergency History"
                theme="danger" icon="fas fa-heartbeat"
                url="{{ route('patient_emergencies.index', ['date_filter' => 'this_month']) }}" />
        </div>


        {{-- Cancer Patient History --}}
        <div class="col-12 mt-1">
            <hr>
            <h5 class="text-danger font-weight-bold">
                <i class="fas fa-ribbon mr-1"></i>
                Cancer Patient History Overview
            </h5>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $totalCancerPatientHistory }}" text="Total Cancer History" theme="primary"
                icon="fas fa-ribbon" url="{{ route('patient-cancer-photos.index') }}" />
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $todayCancerPatientHistory }}" text="Today's Cancer History"
                theme="warning" icon="fas fa-calendar-check"
                url="{{ route('patient-cancer-photos.index', ['date_filter' => 'today']) }}" />
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $todayCancerPatientHistory }}" text="Today's Cancer History"
                theme="warning" icon="fas fa-calendar-check"
                url="{{ route('patient-cancer-photos.index', ['date_filter' => 'today']) }}" />
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
            <x-adminlte-small-box title="{{ $monthlyCancerPatientHistory }}" text="Monthly Cancer History"
                theme="danger" icon="fas fa-chart-line"
                url="{{ route('patient-cancer-photos.index', ['date_filter' => 'this_month']) }}" />
        </div>

    </div>
</div>
