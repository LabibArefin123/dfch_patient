{{-- CANCER INFORMATION --}}
<div class="patient-section-card">
    {{-- Header --}}
    <div class="section-header danger">
        <div class="section-icon">
            <i class="fas fa-ribbon"></i>
        </div>

        <div class="section-content">
            <h3>Cancer Information</h3>
            <p class="mb-0">
                Record the patient's previous cancer history, diagnostic reports,
                medical images and clinical observations for future treatment.
            </p>
        </div>
    </div>

    <div class="section-body">
        {{-- ================= Cancer Status ================= --}}
        <div class="section-subtitle">
            <span><i class="fas fa-ribbon"></i> Cancer Status</span>
            <hr>
        </div>

        <div class="section-note danger">
            <div class="section-note-icon">
                <i class="fas fa-radiation-alt"></i>
            </div>

            <div class="section-note-content">
                <strong>Previous Cancer History</strong>
                <p>
                    Select whether the patient has a previous or existing
                    cancer history. Additional cancer information will
                    appear automatically.
                </p>
            </div>
        </div>

        <div class="row">
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
                <small class="text-muted">Choose whether previous cancer information is available.</small>
            </div>
        </div>

        {{-- ================= Cancer Details ================= --}}
        <div id="cancerSection" style="display:none;">
            <div class="section-divider"></div>
            <div class="section-subtitle">
                <span>
                    <i class="fas fa-x-ray"></i>
                    Patient Cancer Details
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
                        Specify the total number of cancer reports,
                        upload diagnostic images and provide findings
                        for each uploaded report.
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
                        <input type="number" id="total_cancer" name="total_cancer" class="form-control" min="1"
                            value="1" placeholder="Enter Total Cancer Reports">

                    </div>
                    <small class="text-muted"> Number of diagnosed cancer reports or affected locations. </small>
                </div>

                {{-- Upload Images --}}
                <div class="form-group col-lg-6">
                    <label>Cancer Images</label>
                    <div class="cancer-upload-box">
                        <input type="file" name="xray_photo[]" class="form-control-file" accept="image/*" multiple>
                        <div class="upload-placeholder">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <h6>Upload Cancer Images</h6>
                            <p> Upload X-Ray, CT Scan, MRI or PET Scan images. </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview --}}
            <div id="cancerPreviewContainer" class="cancer-preview-container mt-3">
            </div>

            {{-- ================= Diagnostic Description ================= --}}
            <div class="section-divider my-4"></div>

            <div class="section-subtitle">
                <span> <i class="fas fa-align-left"></i> Diagnostic Description </span>
                <hr>
            </div>

            <div class="section-note info">
                <div class="section-note-icon">
                    <i class="fas fa-notes-medical"></i>
                </div>

                <div class="section-note-content">
                    <strong>Clinical Findings</strong>
                    <p>
                        Describe each uploaded diagnostic image including
                        tumour location, staging, measurements and other
                        important observations.
                    </p>
                </div>
            </div>

            <div id="xrayDescriptionWrapper">
                <div class="form-group">
                    <label>Diagnostic Description</label>
                    <textarea name="xray_description[]" class="form-control" rows="4"
                        placeholder="Enter X-Ray / CT Scan / MRI findings..."></textarea>
                    <small class="text-muted">One description will be generated for each uploaded image.</small>
                </div>
            </div>

            {{-- ================= Medical Remarks ================= --}}
            <div class="section-divider my-4"></div>
            <div class="section-subtitle">
                <span> <i class="fas fa-comment-medical"></i> Medical Remarks</span>
                <hr>
            </div>

            <div class="section-note success">
                <div class="section-note-icon"> <i class="fas fa-user-md"></i></div>
                <div class="section-note-content">
                    <strong>Doctor's Assessment</strong>
                    <p>
                        Record the final diagnosis, recommendations,
                        treatment plan, follow-up instructions and
                        additional clinical notes.
                    </p>
                </div>
            </div>

            <div class="form-group">
                <label>Doctor's Remarks</label>
                <textarea name="cancer_remarks" class="form-control ckeditor" rows="5"></textarea>
                <small class="text-muted">
                    Enter diagnosis, recommendations, follow-up schedule and additional observations.
                </small>
            </div>
        </div>
    </div>
</div>
