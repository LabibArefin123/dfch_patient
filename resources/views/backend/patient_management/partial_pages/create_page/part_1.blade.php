<div class="section-body">

    {{-- ========================================================= --}}
    {{-- Personal Details --}}
    {{-- ========================================================= --}}

    <div class="section-subtitle">

        <span>
            <i class="fas fa-id-card"></i>
            Personal Details
        </span>

        <hr>

    </div>

    <div class="section-note primary">

        <div class="section-note-icon">
            <i class="fas fa-user-check"></i>
        </div>

        <div class="section-note-content">

            <strong>Patient Identity</strong>

            <p>
                Enter the patient's official personal information as it appears
                on medical records or identification documents.
            </p>

        </div>

    </div>

    <div class="row">

        {{-- Patient Name --}}
        <div class="form-group col-lg-6">

            <label class="required-field">
                Patient Name
            </label>

            <div class="input-group modern-input">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                </div>

                <input type="text" name="patient_name"
                    class="form-control @error('patient_name') is-invalid @enderror"
                    placeholder="Enter patient's full name" value="{{ old('patient_name') }}">

                @error('patient_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <small class="text-muted">
                Official full name of the patient.
            </small>

        </div>

        {{-- Father Name --}}
        <div class="form-group col-lg-6">

            <label>
                Father's Name
            </label>

            <div class="input-group modern-input">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-male"></i>
                    </span>
                </div>

                <input type="text" name="patient_f_name" class="form-control" placeholder="Enter father's full name"
                    value="{{ old('patient_f_name') }}">

            </div>

            <small class="text-muted">
                Father's legal name (optional).
            </small>

        </div>

        {{-- Mother Name --}}
        <div class="form-group col-lg-6">

            <label>
                Mother's Name
            </label>

            <div class="input-group modern-input">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-female"></i>
                    </span>
                </div>

                <input type="text" name="patient_m_name" class="form-control" placeholder="Enter mother's full name"
                    value="{{ old('patient_m_name') }}">

            </div>

            <small class="text-muted">
                Mother's legal name (optional).
            </small>

        </div>

        {{-- Age --}}
        <div class="form-group col-lg-3 col-md-6">

            <label>
                Age
            </label>

            <div class="input-group modern-input">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-hourglass-half"></i>
                    </span>
                </div>

                <input type="number" min="0" name="age" class="form-control" placeholder="Years"
                    value="{{ old('age') }}">

            </div>

            <small class="text-muted">
                Patient's current age.
            </small>

        </div>

        {{-- Gender --}}
        <div class="form-group col-lg-3 col-md-6">

            <label>
                Gender
            </label>

            <div class="input-group modern-input">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-venus-mars"></i>
                    </span>
                </div>

                <select name="gender" class="form-control">

                    <option value="">
                        Select Gender
                    </option>

                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                        Male
                    </option>

                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                        Female
                    </option>

                </select>

            </div>

            <small class="text-muted">
                Select the patient's gender.
            </small>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- Patient Contact --}}
    {{-- ========================================================= --}}

    <div class="section-divider"></div>

    <div class="section-subtitle">

        <span>
            <i class="fas fa-mobile-alt"></i>
            Patient Contact
        </span>

        <hr>

    </div>

    <div class="section-note info">

        <div class="section-note-icon">
            <i class="fas fa-phone-volume"></i>
        </div>

        <div class="section-note-content">

            <strong>Primary Communication</strong>

            <p>
                Enter the patient's primary and secondary phone numbers for
                appointment reminders and future communication.
            </p>

        </div>

    </div>

    <div class="row">

        {{-- Primary Phone --}}
        <div class="form-group col-lg-6">

            <label class="required-field">
                Mobile Number
            </label>

            <div class="input-group modern-input">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-mobile-alt"></i>
                    </span>
                </div>

                <input type="text" name="phone_1" class="form-control @error('phone_1') is-invalid @enderror"
                    placeholder="01XXXXXXXXX" value="{{ old('phone_1') }}">

                @error('phone_1')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <small class="text-muted">
                Primary contact number.
            </small>

        </div>

        {{-- Secondary Phone --}}
        <div class="form-group col-lg-6">

            <label>
                Alternative Number
            </label>

            <div class="input-group modern-input">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-phone"></i>
                    </span>
                </div>

                <input type="text" name="phone_2" class="form-control" placeholder="Optional phone number"
                    value="{{ old('phone_2') }}">

            </div>

            <small class="text-muted">
                Optional backup contact number.
            </small>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- Family Contact --}}
    {{-- ========================================================= --}}

    <div class="section-divider"></div>

    <div class="section-subtitle">

        <span>
            <i class="fas fa-users"></i>
            Family Contact
        </span>

        <hr>

    </div>

    <div class="section-note warning">

        <div class="section-note-icon">
            <i class="fas fa-user-friends"></i>
        </div>

        <div class="section-note-content">

            <strong>Emergency Contacts</strong>

            <p>
                Family contact numbers can be used in case the patient cannot
                be reached during treatment or emergencies.
            </p>

        </div>

    </div>

    <div class="row">

        {{-- Father's Phone --}}
        <div class="form-group col-lg-6">

            <label>
                Father's Mobile
            </label>

            <div class="input-group modern-input">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-male"></i>
                    </span>
                </div>

                <input type="text" name="phone_f_1" class="form-control" placeholder="Father's mobile number"
                    value="{{ old('phone_f_1') }}">

            </div>

            <small class="text-muted">
                Emergency contact for the father.
            </small>

        </div>

        {{-- Mother's Phone --}}
        <div class="form-group col-lg-6">

            <label>
                Mother's Mobile
            </label>

            <div class="input-group modern-input">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-female"></i>
                    </span>
                </div>

                <input type="text" name="phone_m_1" class="form-control" placeholder="Mother's mobile number"
                    value="{{ old('phone_m_1') }}">

            </div>

            <small class="text-muted">
                Emergency contact for the mother.
            </small>

        </div>

    </div>

</div>
