{{-- ========================= CANCER INFORMATION ========================= --}}

<div class="section-content">
    <h3>Cancer Information</h3>
    <p class="mb-0">
        Record the patient's previous cancer history, diagnostic findings,
        medical images and clinical observations.
    </p>
</div>

<div class="section-subtitle">
    <span>
        <i class="fas fa-ribbon"></i>
        Cancer Status
    </span>

    <hr>
</div>

<div class="section-note danger">
    <div class="section-note-icon">
        <i class="fas fa-radiation-alt"></i>
    </div>

    <div class="section-note-content">
        <strong>Cancer History</strong>

        <p>
            Select whether the patient has a previous or current cancer history.
            Additional diagnostic fields will appear automatically.
        </p>
    </div>
</div>

<div class="row">

    {{-- Previous Cancer --}}
    <div class="form-group col-lg-6">

        <label>Has Previous Cancer?</label>

        <div class="input-group modern-input">

            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fas fa-heartbeat"></i>
                </span>
            </div>

            <select name="is_old_cancer" id="is_old_cancer" class="form-control">

                <option value="0" selected>No</option>
                <option value="1">Yes</option>

            </select>

        </div>

        <small class="text-muted">
            Choose whether previous cancer information is available.
        </small>

    </div>

</div>

{{-- ========================= Cancer Details ========================= --}}

<div id="cancerSection" style="display:none;">

    <div class="section-divider"></div>

    <div class="section-subtitle">
        <span>
            <i class="fas fa-x-ray"></i>
            Cancer Details
        </span>
        <hr>
    </div>

    <div class="section-note warning">

        <div class="section-note-icon">
            <i class="fas fa-file-medical-alt"></i>
        </div>

        <div class="section-note-content">

            <strong>Diagnostic Information</strong>

            <p>
                Specify the total cancer reports, upload diagnostic images,
                and provide clinical descriptions for each report.
            </p>

        </div>

    </div>

    <div class="row">

        {{-- Total Cancer --}}
        <div class="form-group col-lg-6">

            <label>Total Cancer Reports</label>

            <div class="input-group modern-input">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-list-ol"></i>
                    </span>
                </div>

                <input type="number" id="total_cancer" name="total_cancer" min="1" value="1"
                    class="form-control" placeholder="Enter Total Cancer Reports">

            </div>

            <small class="text-muted">
                Total number of diagnosed cancer reports or affected locations.
            </small>

        </div>

        {{-- Cancer Images --}}
        <div class="form-group col-lg-6">

            <label>Cancer Images</label>

            <div class="treatment-upload-box">

                <input type="file" name="xray_photo[]" class="form-control-file" accept="image/*" multiple>

                <div class="upload-placeholder">

                    <i class="fas fa-cloud-upload-alt"></i>

                    <h6>Upload Cancer Images</h6>

                    <p>
                        Upload X-Ray, CT Scan, MRI or other diagnostic images.
                    </p>

                </div>

            </div>

        </div>
        <div id="cancerPreviewContainer" class="cancer-preview-container mt-3"></div>
    </div>



    {{-- ========================= X-Ray Description ========================= --}}

    <div class="section-divider"></div>

    <div class="section-subtitle">

        <span>
            <i class="fas fa-align-left"></i>
            Diagnostic Description
        </span>

        <hr>

    </div>

    <div class="section-note info">

        <div class="section-note-icon">
            <i class="fas fa-notes-medical"></i>
        </div>

        <div class="section-note-content">

            <strong>Clinical Findings</strong>

            <p>
                Add findings for each uploaded diagnostic image.
                Include tumour location, size, stage or any significant observations.
            </p>

        </div>

    </div>

    <div id="xrayDescriptionWrapper">

        <div class="form-group">

            <label>Cancer Description</label>

            <textarea name="xray_description[]" class="form-control" rows="4"
                placeholder="Enter X-Ray / CT / MRI findings..."></textarea>

        </div>

    </div>

    {{-- ========================= Remarks ========================= --}}

    <div class="section-divider"></div>

    <div class="section-subtitle">

        <span>
            <i class="fas fa-comment-medical"></i>
            Medical Remarks
        </span>

        <hr>

    </div>

    <div class="section-note success">

        <div class="section-note-icon">
            <i class="fas fa-user-md"></i>
        </div>

        <div class="section-note-content">

            <strong>Doctor's Remarks</strong>

            <p>
                Record the overall diagnosis, treatment recommendations,
                follow-up instructions or additional clinical observations.
            </p>

        </div>

    </div>

    <div class="form-group">

        <label>Remarks</label>

        <textarea name="remarks" class="form-control ckeditor" rows="5"></textarea>

        <small class="text-muted">
            Enter diagnosis, recommendations, follow-up plan and any additional notes.
        </small>

    </div>

</div>
