{{-- ========================= INVESTIGATION INFORMATION ========================= --}}

<div class="patient-section-card">

    <div class="section-header warning">

        <div class="section-icon">
            <i class="fas fa-microscope"></i>
        </div>

        <div class="section-content">
            <h3>Investigation Information</h3>
            <p class="mb-0">
                Record laboratory tests, diagnostic reports, investigation images
                and clinical findings for the patient.
            </p>
        </div>

    </div>

    <div class="section-body">

        {{-- ========================= Investigation Status ========================= --}}

        <div class="section-subtitle">
            <span>
                <i class="fas fa-vials"></i>
                Investigation Status
            </span>

            <hr>
        </div>

        <div class="section-note info">

            <div class="section-note-icon">
                <i class="fas fa-flask"></i>
            </div>

            <div class="section-note-content">

                <strong>Investigation Availability</strong>

                <p>
                    Select whether investigation reports are available.
                    Additional investigation details will appear automatically.
                </p>

            </div>

        </div>

        <div class="row">

            <div class="form-group col-lg-6">

                <label>Has Investigation?</label>

                <div class="input-group modern-input">

                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-check-circle"></i>
                        </span>
                    </div>

                    <select name="is_investigated" id="is_investigated" class="form-control">

                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>

                    </select>

                </div>

                <small class="text-muted">
                    Choose whether investigation records are available.
                </small>

            </div>

        </div>

        {{-- ========================= Investigation Details ========================= --}}

        <div id="investigationSection" style="display:none;">

            <div class="section-divider"></div>

            <div class="section-subtitle">

                <span>
                    <i class="fas fa-file-medical-alt"></i>
                    Investigation Details
                </span>

                <hr>

            </div>

            <div class="section-note warning">

                <div class="section-note-icon">
                    <i class="fas fa-microscope"></i>
                </div>

                <div class="section-note-content">

                    <strong>Diagnostic Reports</strong>

                    <p>
                        Upload investigation images such as laboratory reports,
                        pathology reports, X-Ray, CT Scan, MRI or other diagnostic
                        documents and describe the findings.
                    </p>

                </div>

            </div>

            <div class="row">

                {{-- Investigation Images --}}
                <div class="form-group col-lg-12">

                    <label>Investigation Images</label>

                    <div class="global-upload-box">

                        <input type="file" name="investigation_images[]" class="form-control-file" accept="image/*"
                            multiple>

                        <div class="upload-placeholder">

                            <i class="fas fa-cloud-upload-alt"></i>

                            <h6>Upload Investigation Images</h6>

                            <p>
                                Drag & drop investigation images or click to browse.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <div id="investigationPreviewContainer" class="investigation-preview-container mt-3">
            </div>

            {{-- ========================= Investigation Summary ========================= --}}

            <div class="section-divider"></div>

            <div class="section-subtitle">

                <span>
                    <i class="fas fa-notes-medical"></i>
                    Investigation Summary
                </span>

                <hr>

            </div>

            <div class="section-note success">

                <div class="section-note-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>

                <div class="section-note-content">

                    <strong>Clinical Findings</strong>

                    <p>
                        Summarize the investigation results, laboratory findings,
                        diagnosis and recommendations based on the uploaded reports.
                    </p>

                </div>

            </div>

            <div class="form-group">

                <label>Investigation Information</label>

                <textarea id="investigation_information" name="investigation_information" class="form-control ckeditor" rows="6"></textarea>

                <small class="text-muted">
                    Enter investigation findings, diagnosis, laboratory results,
                    recommendations and additional observations.
                </small>

            </div>

        </div>

    </div>

</div>
