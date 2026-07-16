<div class="row mt-1">
    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <x-adminlte-small-box title="{{ $totalEmergencyPatientHistory }}" text="Total Emergency Patient History"
            theme="danger" icon="fas fa-user-md" />
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <x-adminlte-small-box title="{{ $todayEmergencyPatientHistory }}" text="Today's Emergency Patient History"
            theme="warning" icon="fas fa-stethoscope" />
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <x-adminlte-small-box title="{{ $weeklyEmergencyPatientHistory }}" text="Weekly Emergency Patient History"
            theme="warning" icon="fas fa-stethoscope" />
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <x-adminlte-small-box title="{{ $monthlyEmergencyPatientHistory }}" text="Monthly Emergency Patient History"
            theme="success" icon="fas fa-chart-line" />
    </div>
</div>
