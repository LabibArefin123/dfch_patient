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
        <div id="editEmergencySection" style="{{ old('is_emergency', $patient->is_emergency) ? '' : 'display:none;' }}">

            <div class="section-subtitle mt-4">

                <span>
                    <i class="fas fa-notes-medical"></i>
                    Emergency Details
                </span>

                <hr>

            </div>

            <div class="section-note warning">

                <div class="section-note-icon">
                    <i class="fas fa-file-medical-alt"></i>
                </div>

                <div class="section-note-content">

                    <strong>Emergency Notes</strong>

                    <p>
                        Record the patient's emergency condition, arrival status,
                        first aid, triage and any immediate observations.
                    </p>

                </div>

            </div>

            <div class="row">

                <div class="form-group col-md-12">

                    <label>Emergency Details</label>

                    <textarea id="edit_emergency_details" name="emergency_details[notes]" class="form-control" rows="8"
                        placeholder="Enter complete emergency details...">{{ old('emergency_details.notes', $patient->emergency_details['notes'] ?? '') }}</textarea>

                    <small class="text-muted">
                        This field supports rich text formatting through the editor.
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>
