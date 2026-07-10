{{-- Patient Name --}}
<div class="form-group col-md-6">
    <label>Patient Name <span class="text-danger">*</span></label>
    <input type="text" name="patient_name" class="form-control @error('patient_name') is-invalid @enderror"
        value="{{ old('patient_name') }}">
    @error('patient_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Father Name --}}
<div class="form-group col-md-6">
    <label>Father Name</label>
    <input type="text" name="patient_f_name" class="form-control" value="{{ old('patient_f_name') }}">
</div>

{{-- Mother Name --}}
<div class="form-group col-md-6">
    <label>Mother Name</label>
    <input type="text" name="patient_m_name" class="form-control" value="{{ old('patient_m_name') }}">
</div>

{{-- Age --}}
<div class="form-group col-md-3">
    <label>Age</label>
    <input type="number" name="age" class="form-control" value="{{ old('age') }}">
</div>

{{-- Gender --}}
<div class="form-group col-md-3">
    <label>Gender</label>
    <select name="gender" class="form-control">
        <option value="">Select</option>
        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
    </select>
</div>

{{-- Phones --}}
<div class="form-group col-md-6">
    <label>Phone 1 <span class="text-danger">*</span></label>
    <input type="text" name="phone_1" class="form-control @error('phone_1') is-invalid @enderror"
        value="{{ old('phone_1') }}">
    @error('phone_1')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group col-md-6">
    <label>Phone 2</label>
    <input type="text" name="phone_2" class="form-control" value="{{ old('phone_2') }}">
</div>

<div class="form-group col-md-6">
    <label>Father Phone</label>
    <input type="text" name="phone_f_1" class="form-control" value="{{ old('phone_f_1') }}">
</div>

<div class="form-group col-md-6">
    <label>Mother Phone</label>
    <input type="text" name="phone_m_1" class="form-control" value="{{ old('phone_m_1') }}">
</div>
