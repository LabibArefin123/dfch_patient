{{-- ========================= EMERGENCY INFORMATION ========================= --}}

<div class="patient-section-card">

    <div class="section-header danger">

        <div class="section-icon">
            <i class="fas fa-ambulance"></i>
        </div>

        <div class="section-content">
            <h3>Emergency Information</h3>
            <p class="mb-0">
                Specify whether this patient was admitted as an emergency case.
            </p>
        </div>

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

                    <select name="is_emergency" id="is_emergency" class="form-control">

                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>

                    </select>

                </div>

                <small class="text-muted">
                    Choose whether this patient was admitted as an emergency case.
                </small>

            </div>

        </div>

    </div>

</div>
