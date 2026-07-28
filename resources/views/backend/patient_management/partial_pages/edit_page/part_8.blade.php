{{-- ===========================================================
CANCER INFORMATION (EDIT)
=========================================================== --}}
<div class="patient-section-card cancer-card">
    <div class="section-header">
        <div>
            <h5>
                <i class="fas fa-ribbon text-danger"></i>
                Cancer Information
            </h5>

            <span>
                Cancer history & diagnostic image archive
            </span>

        </div>

        <span class="section-badge badge-danger">
            Cancer Record
        </span>
    </div>
    <div class="section-body">

        {{-- Cancer Status --}}
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

                <strong>Previous Cancer History</strong>

                <p>
                    Select whether the patient has a previous or existing cancer
                    history. Additional cancer information will appear
                    automatically.
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

                        <option value="0" {{ $patient->is_old_cancer ? '' : 'selected' }}>
                            No
                        </option>

                        <option value="1" {{ $patient->is_old_cancer ? 'selected' : '' }}>
                            Yes
                        </option>

                    </select>

                </div>

                <small class="text-muted">
                    Choose whether the patient has a previous cancer history.
                </small>

            </div>

        </div>

        <div id="cancerSection" style="{{ $patient->is_old_cancer ? '' : 'display:none;' }}">

            <div class="section-divider"></div>

            {{-- Cancer Details --}}
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
                        Upload additional diagnostic images, update the cancer
                        count and modify report descriptions whenever required.
                    </p>

                </div>

            </div>

            <div class="row">
                {{-- Total Cancer --}}
                <div class="form-group col-lg-6">
                    <label>Total Cancer</label>
                    <div class="input-group modern-input">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-list-ol"></i>
                            </span>
                        </div>

                        <input type="number" min="1" id="edit_total_cancer" name="total_cancer"
                            class="form-control" value="{{ optional($patient->cancerPhotos)->total_cancer ?? 1 }}"
                            placeholder="Enter Total Cancer">

                    </div>
                    <small class="text-muted"> Number of detected cancer locations or reports. </small>
                </div>

                {{-- Upload More Images --}}
                <div class="form-group col-lg-6">
                    <label>Add More Cancer Images</label>
                    <div class="global-upload-box">
                        <input type="file" name="xray_photo[]" class="form-control-file" accept="image/*" multiple>
                        <div class="upload-placeholder">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <h6>Upload Additional Cancer Images</h6>
                            <p>
                                Drag & drop images or click to browse.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Existing Cancer Images --}}
            @if ($patient->cancerPhotos->isNotEmpty() && !empty($patient->cancerPhotos->first()->xray_photo))
                <div class="form-group">
                    <label>Existing Cancer Images</label>
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="row">
                                @foreach ($patient->cancerPhotos->first()->xray_photo as $image)
                                    <div class="col-md-4 col-lg-3 mb-3">
                                        <div class="card h-100 border-0 investigation-image-card">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                                data-bs-img-src="{{ asset($image) }}" class="text-decoration-none">
                                                <img src="{{ asset($image) }}"
                                                    class="img-fluid investigation-gallery-image" alt="Cancer Image">
                                            </a>

                                            <div class="card-body text-center">
                                                <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#imageZoomModal"
                                                    data-bs-img-src="{{ asset($image) }}">
                                                    View Image
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- Preview --}}
            <div id="cancerPreviewContainer" class="cancer-preview-container mt-3"></div>

            <div class="section-divider my-4"></div>

            {{-- X-Ray Description --}}
            <div class="section-subtitle">

                <span>
                    <i class="fas fa-align-left"></i>
                    X-Ray Description
                </span>

                <hr>

            </div>

            <div id="xrayDescriptionWrapper">
                @php
                    $descriptions = optional($patient->cancerPhotos)->xray_description ?? [];
                @endphp

                @forelse($descriptions as $index => $description)
                    <div class="form-group">
                        <label>Cancer Description</label>
                        <textarea name="xray_description[]" id="edit_xray_description" class="form-control" rows="4" placeholder="Enter X-Ray / CT Scan findings...">{{ $description }}</textarea>
                    </div>
                @empty
                    <div class="form-group">
                        <label>Description </label>
                        <textarea name="xray_description[]" id="edit_xray_description" class="form-control" rows="4" placeholder="Enter X-Ray / CT Scan findings..."></textarea>
                    </div>
                @endforelse
            </div

            {{-- Remarks --}}
            <div class="form-group">
                <label>Remarks</label>
                <textarea name="cancer_remarks" id="edit_cancer_remarks" class="form-control" rows="5">{{ $patient->cancer_remarks }}</textarea>
                <small class="text-muted">
                    Additional observations, diagnosis or recommendations.
                </small>
            </div>
        </div>
    </div>

</div>
