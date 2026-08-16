<div class="card card-outline card-primary shadow-sm mb-4 patient-filter-card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter mr-1"></i>Schedule Filters</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('patient_meetings.index') }}" id="meetingFilterForm">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <label><i class="fas fa-user-md mr-1"></i>Specialist</label>
                    <select name="specialist_id" class="form-control">
                        <option value="">All Specialists</option>
                        @foreach ($filterSpecialists as $filterSpecialist)
                            <option value="{{ $filterSpecialist->id }}">{{ $filterSpecialist->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <label><i class="fas fa-calendar-day mr-1"></i>Date</label>
                    <input type="date" name="date" class="form-control">
                </div>
                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <label><i class="fas fa-tasks mr-1"></i>Status</label>
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="no_show">No Show</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <label><i class="fas fa-stethoscope mr-1"></i>Meeting Type</label>
                    <select name="meeting_type" class="form-control">
                        <option value="">All Types</option>
                        <option value="consultation">Consultation</option>
                        <option value="follow_up">Follow Up</option>
                        <option value="report_review">Report Review</option>
                        <option value="emergency">Emergency</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>
