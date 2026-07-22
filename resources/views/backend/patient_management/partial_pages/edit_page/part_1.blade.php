{{-- Patient Name --}}
<div class="col-12">
    <div class="patient-section-card">

        <div class="section-header">
            <div>
                <h5>
                    <i class="fas fa-user-injured"></i>
                    Patient Basic Information
                </h5>
                <span>Personal & contact details</span>
            </div>
        </div>

        <div class="row">

            <div class="form-group col-md-6">
                <label>Patient's Name <span class="text-danger">*</span></label>
                <input type="text" name="patient_name" class="form-control"
                    value="{{ old('patient_name', $patient->patient_name) }}">
            </div>

            <div class="form-group col-md-6">
                <label>Patient's Father Name<span class="text-danger">*</span></label>
                <input type="text" name="patient_f_name" class="form-control"
                    value="{{ old('patient_f_name', $patient->patient_f_name) }}">
            </div>

            <div class="form-group col-md-6">
                <label>Patient's Mother Name<span class="text-danger">*</span></label>
                <input type="text" name="patient_m_name" class="form-control"
                    value="{{ old('patient_m_name', $patient->patient_m_name) }}">
            </div>

            <div class="form-group col-md-3">
                <label>Age<span class="text-danger">*</span></label>
                <input type="number" name="age" class="form-control" value="{{ old('age', $patient->age) }}">
            </div>

            <div class="form-group col-md-3">
                <label>Gender<span class="text-danger">*</span></label>
                <select name="gender" class="form-control">
                    <option value="">Select</option>
                    <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label>Patient's Phone 1 <span class="text-danger">*</span></label>
                <input type="text" name="phone_1" class="form-control"
                    value="{{ old('phone_1', $patient->phone_1) }}">
            </div>

            <div class="form-group col-md-6">
                <label>Patient's Phone 2</label>
                <input type="text" name="phone_2" class="form-control"
                    value="{{ old('phone_2', $patient->phone_2) }}">
            </div>

            <div class="form-group col-md-6">
                <label>Patient's Father Phone</label>
                <input type="text" name="phone_f_1" class="form-control"
                    value="{{ old('phone_f_1', $patient->phone_f_1) }}">
            </div>

            <div class="form-group col-md-6">
                <label>Patient's Mother Phone</label>
                <input type="text" name="phone_m_1" class="form-control"
                    value="{{ old('phone_m_1', $patient->phone_m_1) }}">
            </div>

        </div>

    </div>
</div>
