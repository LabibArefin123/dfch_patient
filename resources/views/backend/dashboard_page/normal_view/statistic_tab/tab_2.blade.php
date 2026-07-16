<div class="tab-pane" id="statisticalView">
    <div class="row">

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6>Patient Registrations Distribution</h6>
                </div>
                <div class="card-body">
                    <canvas id="patientsPieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6>Recommended Patients Trend</h6>
                </div>
                <div class="card-body">
                    <canvas id="recommendedBarChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- Detailed Stats --}}
    <div class="row mt-4">
        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $totalPatients }}" text="Total Patients" theme="info"
                icon="fas fa-users" />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $todayPatients }}" text="Registered Today" theme="light"
                icon="fas fa-calendar-day" />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $weeklyPatients }}" text="This Week" theme="primary"
                icon="fas fa-calendar-week" />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $monthlyPatients }}" text="This Month" theme="secondary"
                icon="fas fa-calendar-alt" />
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $totalRecommendedPatients }}" text="Total Recommended" theme="danger"
                icon="fas fa-user-md" />
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $todayRecommendedPatients }}" text="Today's Recommended" theme="warning"
                icon="fas fa-stethoscope" />
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $monthlyRecommendedPatients }}" text="Monthly Recommended" theme="success"
                icon="fas fa-chart-line" />
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $totalEmergencyPatientHistory  }}" text="Total Emergency Patient History"
                theme="danger" icon="fas fa-user-md" />
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $todayEmergencyPatientHistory  }}" text="Today's Emergency Patient History"
                theme="warning" icon="fas fa-stethoscope" />
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $monthlyEmergencyPatientHistory }}" text="Monthly Emergency Patient History"
                theme="success" icon="fas fa-chart-line" />
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $totalCancerPatientHistory }}" text="Total Cancer Patient History"
                theme="danger" icon="fas fa-user-md" />
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $todayCancerPatientHistory }}" text="Today's Cancer Patient History"
                theme="warning" icon="fas fa-stethoscope" />
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <x-adminlte-small-box title="{{ $monthlyCancerPatientHistory }}" text="Monthly Cancer Patient History"
                theme="success" icon="fas fa-chart-line" />
        </div>
    </div>

</div>
