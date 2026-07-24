{{-- ========================= RECOMMENDED PATIENT ========================= --}}

<div class="section-subtitle">

    <span>
        <i class="fas fa-user-md"></i>
        Referral Status
    </span>

    <hr>

</div>

<div class="section-note primary">

    <div class="section-note-icon">
        <i class="fas fa-hospital-user"></i>
    </div>

    <div class="section-note-content">

        <strong>Patient Referral</strong>

        <p>
            Select whether the patient has been referred by another doctor or
            medical institution. Additional referral information will appear
            automatically.
        </p>

    </div>

</div>

<div class="row">

    {{-- Referral Status --}}
    <div class="form-group col-lg-6">

        <label>Is Referred Patient?</label>

        <div class="input-group modern-input">

            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fas fa-share-square"></i>
                </span>
            </div>

            <select name="is_recommend" id="is_recommend" class="form-control">

                <option value="0" {{ old('is_recommend') == '0' ? 'selected' : '' }}>
                    No
                </option>

                <option value="1" {{ old('is_recommend') == '1' ? 'selected' : '' }}>
                    Yes
                </option>

            </select>

        </div>

        <small class="text-muted">
            Choose whether this patient was referred by another doctor.
        </small>

    </div>

</div>

{{-- ========================= Referral Details ========================= --}}
<div class="recommend-section d-none">

    <div class="section-divider"></div>

    <div class="section-subtitle">

        <span>
            <i class="fas fa-file-medical"></i>
            Referral Details
        </span>

        <hr>

    </div>

    <div class="section-note info">

        <div class="section-note-icon">
            <i class="fas fa-notes-medical"></i>
        </div>

        <div class="section-note-content">

            <strong>Referral Information</strong>

            <p>
                Record the referring doctor's notes, upload referral documents
                and preserve any supporting medical records.
            </p>

        </div>

    </div>

    <div class="row">

        {{-- Doctor Note --}}
        <div class="form-group col-lg-6">

            <label>Referred Doctor Note</label>

            <textarea name="recommend_note" class="form-control ckeditor" rows="6">{{ old('recommend_note') }}</textarea>

            <small class="text-muted">
                Enter diagnosis, referral reason, treatment advice and any
                additional recommendations from the referring doctor.
            </small>

        </div>

        {{-- Documents --}}
        <div class="form-group col-lg-6">

            <label>Referral Documents</label>

            <div class="treatment-upload-box">

                <input type="file" name="documents[]" class="form-control-file" accept=".pdf,image/*" multiple>

                <div class="upload-placeholder">

                    <i class="fas fa-cloud-upload-alt"></i>

                    <h6>Upload Referral Documents</h6>

                    <p>
                        Upload referral letters, prescriptions,
                        PDF reports or medical images.
                    </p>

                </div>

            </div>

            <small class="text-muted">
                Supported formats: PDF, JPG, JPEG, PNG and other image files.
            </small>

        </div>

    </div>

    <div id="referPreviewContainer" class="refer-preview-container mt-3">
    </div>

</div>
