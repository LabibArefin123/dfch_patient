<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Father's Name</label>
            <input type="text" class="form-control" disabled value="{{ $patient->patient_f_name ?? 'N/A' }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Mother's Name</label>
            <input type="text" class="form-control" disabled value="{{ $patient->patient_m_name ?? 'N/A' }}">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Age</label>
            <input type="text" class="form-control" disabled value="{{ $patient->age ?? 'N/A' }}">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Gender</label>
            <input type="text" class="form-control text-uppercase" disabled value="{{ $patient->gender ?? 'N/A' }}">
        </div>
    </div>
</div>
