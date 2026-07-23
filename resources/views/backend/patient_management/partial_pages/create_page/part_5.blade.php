{{-- TREATMENT INFORMATION --}}
<div class="section-header success">
    <div class="section-icon">
        <i class="fas fa-procedures"></i>
    </div>

    <div class="section-content">
        <h3>Treatment Information</h3>
        <p class="mb-0">
            Record the patient's treatment status, procedure details and related documents.
        </p>
    </div>
</div>

<div class="section-body">
    {{-- Treatment Status --}}
    <div class="section-subtitle">

        <span>
            <i class="fas fa-notes-medical"></i>
            Treatment Status
        </span>

        <hr>

    </div>

    <div class="section-note success">
        <div class="section-note-icon">
            <i class="fas fa-heartbeat"></i>
        </div>

        <div class="section-note-content">
            <strong>Treatment Availability</strong>
            <p>
                Select whether the patient has already received treatment.
                Additional treatment information will appear automatically.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-6">
            <label> Has Treatment? </label>
            <div class="input-group modern-input">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-check-circle"></i>
                    </span>
                </div>

                <select name="is_treatment" id="is_treatment" class="form-control">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <small class="text-muted">Choose whether treatment information is available. </small>
        </div>
    </div>

    <div id="treatmentSection" style="display:none;">
        <div class="section-divider"></div>
        {{-- Treatment Details --}}
        <div class="section-subtitle">
            <span>
                <i class="fas fa-user-md"></i>
                Treatment Details
            </span>
            <hr>
        </div>

        <div class="section-note info">
            <div class="section-note-icon">
                <i class="fas fa-stethoscope"></i>
            </div>

            <div class="section-note-content">
                <strong>Procedure Information</strong>
                <p>
                    Specify the treatment type, upload treatment images,
                    and provide detailed medical notes.
                </p>
            </div>
        </div>

        <div class="row">
            {{-- Treatment Type --}}
            <div class="form-group col-lg-6">
                <label>Treatment Type</label>
                <div class="input-group modern-input">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-hospital"></i>
                        </span>
                    </div>

                    <select name="treatment_type" id="treatment_type" class="form-control">
                        <option value="">Select Treatment Type</option>
                        <option value="OPD">OPD</option>
                        <option value="OT">Operation Theatre (OT)</option>
                    </select>
                </div>

                <small class="text-muted"> Select where the treatment was performed.</small>
            </div>

            {{-- Images --}}
            <div class="form-group col-lg-6">
                <label> Treatment Images </label>
                <div class="treatment-upload-box">
                    <input type="file" name="treatment_images[]" class="form-control-file" accept="image/*" multiple>

                    <div class="upload-placeholder">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <h6>Upload Treatment Images</h6>
                        <p>Drag & drop images or click to browse.</p>
                    </div>
                </div>
                <div id="treatmentPreviewContainer" class="treatment-preview-grid mt-3"></div>
            </div>
        </div>

        {{-- Information --}}
        <div class="form-group col-12">
            <label> Treatment Summary </label>
            <textarea id="treatment_information" name="treatment_information" class="form-control ckeditor"></textarea>
            <small class="text-muted">Enter diagnosis, procedures, medications and follow-up recommendations.</small>
        </div>

    </div>

</div>

</div>
