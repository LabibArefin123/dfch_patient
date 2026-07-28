<div class="patient-section-card emergency-card">
    <div class="section-header danger">
        <div>

            <h5>
                <i class="fas fa-microscope text-primary"></i>
                Emergency Patient
            </h5>

            <span>
                Emergency admission history & critical patient notes
            </span>

        </div>
        <span class="section-badge badge-danger">
            Emergency Record
        </span>
    </div>

    <div class="section-body">
        <div class="section-subtitle">
            <span>
                <i class="fas fa-exclamation-triangle"></i>
                Emergency Status
            </span>

            <hr>

        </div>

        <div class="section-note danger">
            <div class="section-note-icon">
                <i class="fas fa-ambulance"></i>
            </div>
            <div class="section-note-content">
                <strong>Emergency Patient</strong>
                <p>
                    Select whether the patient arrived as an emergency case.
                </p>

            </div>

        </div>

        <div class="row">
            <div class="form-group col-lg-6">
                <label>Emergency Patient?</label>
                <div class="input-group modern-input">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-ambulance"></i>
                        </span>
                    </div>

                    <select name="is_emergency" id="edit_is_emergency" class="form-control">

                        <option value="0" {{ old('is_emergency', $patient->is_emergency) == 0 ? 'selected' : '' }}>
                            No
                        </option>

                        <option value="1" {{ old('is_emergency', $patient->is_emergency) == 1 ? 'selected' : '' }}>
                            Yes
                        </option>

                    </select>

                </div>

                <small class="text-muted">
                    Choose whether this patient was admitted as an emergency case.
                </small>

            </div>

        </div>

        {{-- Emergency Details --}}
        {{-- Emergency Information --}}
        <div id="editEmergencySection" style="{{ old('is_emergency', $patient->is_emergency) ? '' : 'display:none;' }}">

            <div class="section-subtitle mt-4">
                <span>
                    <i class="fas fa-notes-medical"></i>
                    Emergency Information
                </span>
                <hr>
            </div>

            <div class="section-note warning">

                <div class="section-note-icon">
                    <i class="fas fa-first-aid"></i>
                </div>

                <div class="section-note-content">
                    <strong>Emergency Admission Details</strong>
                    <p>
                        Update the reason for emergency admission and the date/time the
                        patient arrived.
                    </p>
                </div>

            </div>

            <div class="row">

                {{-- Emergency Date --}}
                <div class="form-group col-lg-6">

                    <label>Emergency Date &amp; Time</label>

                    <div class="input-group modern-input">

                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                        </div>

                        <input type="datetime-local" name="emergency_date" id="edit_emergency_date" class="form-control"
                            value="{{ old('emergency_date', optional($patient->latestEmergency?->emergency_date)->format('Y-m-d\TH:i')) }}">

                    </div>

                    <small class="text-muted">
                        Select the patient's emergency admission date and time.
                    </small>

                </div>

                {{-- Emergency Reason --}}
                <div class="form-group col-lg-6">

                    <label>Emergency Reason</label>

                    <textarea name="reason" id="edit_reason" rows="5" class="form-control"
                        placeholder="Describe the emergency condition, symptoms, accident, trauma, bleeding, severe pain, etc.">{{ old('reason', $patient->latestEmergency->reason ?? '') }}</textarea>

                    <small class="text-muted">
                        Briefly describe why the patient required emergency treatment.
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>
