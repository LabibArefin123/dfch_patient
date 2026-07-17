<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-primary shadow-sm">
            <div class="inner">
                <h3> {{ $patientMeetings->total() }}</h3>
                <p> Total Meetings</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3>{{ $patientMeetings->where('status', 'confirmed')->count() }}</h3>
                <p>Confirmed Meetings</p>
            </div>

            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3>{{ $patientMeetings->where('status', 'scheduled')->count() }}</h3>
                <p>Scheduled</p>
            </div>

            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3>{{ $patientMeetings->where('meeting_type', 'emergency')->count() }}</h3>
                <p>Emergency Meetings </p>
            </div>

            <div class="icon">
                <i class="fas fa-ambulance"></i>
            </div>
        </div>
    </div>
</div>
