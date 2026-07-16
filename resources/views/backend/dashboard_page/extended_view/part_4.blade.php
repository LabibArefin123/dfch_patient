<div class="row mt-1">
    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <x-adminlte-small-box title="{{ $totalCancerPatientHistory }}" text="Total Cancer Patient History" theme="danger"
            icon="fas fa-user-md" />
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <x-adminlte-small-box title="{{ $todayCancerPatientHistory }}" text="Today's Cancer Patient History"
            theme="warning" icon="fas fa-stethoscope" />
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <x-adminlte-small-box title="{{ $weeklyCancerPatientHistory }}" text="Weekly Cancer Patient History"
            theme="warning" icon="fas fa-stethoscope" />
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <x-adminlte-small-box title="{{ $monthlyCancerPatientHistory }}" text="Monthly Cancer Patient History"
            theme="success" icon="fas fa-chart-line" />
    </div>
</div>
