<div class="col-12">

    <div class="patient-section-card treatment-card">

        <div class="section-header">

            <div>

                <h5>
                    <i class="fas fa-procedures text-warning"></i>
                    Treatment Information
                </h5>

                <span>
                    Treatment history & image archive
                </span>

            </div>

            <span class="section-badge treatment-badge">
                Medical Record
            </span>

        </div>

        <div class="row">

            <div class="form-group col-md-6">

                <label>Is Treatment?</label>
                <select name="is_treatment" id="is_treatment" class="form-control">

                    <option value="0" {{ old('is_treatment', $patient->is_treatment) == 0 ? 'selected' : '' }}>
                        No
                    </option>

                    <option value="1" {{ old('is_treatment', $patient->is_treatment) == 1 ? 'selected' : '' }}>
                        Yes
                    </option>

                </select>

            </div>

        </div>

        <div class="treatment-section">
            <div class="row">
                <div class="form-group col-md-12">

                    <label>Treatment Type</label>

                    <select name="treatment_type" class="form-control">

                        <option value="">Select Treatment Type</option>

                        <option value="OPD"
                            {{ old('treatment_type', $patient->treatment_type) == 'OPD' ? 'selected' : '' }}>
                            OPD
                        </option>

                        <option value="OT"
                            {{ old('treatment_type', $patient->treatment_type) == 'OT' ? 'selected' : '' }}>
                            OT
                        </option>

                    </select>

                </div>

                <div class="form-group col-md-12">

                    <label>Treatment Information</label>

                    <textarea name="treatment_information" id="edit_treatment_information" class="form-control">{{ old('treatment_information', $patient->treatment_information) }}</textarea>

                </div>

                {{-- Existing Images --}}
                <div class="form-group col-md-12">
                    <label>Treatment Images</label>
                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            @if (!empty($patient->treatment_images))

                                <div class="row">

                                    @foreach ($patient->treatment_images as $image)
                                        <div class="col-md-4 col-lg-3 mb-3">

                                            <div class="card h-100 shadow-sm border">

                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#imageZoomModal"
                                                    data-bs-img-src="{{ asset($image) }}" class="text-decoration-none">

                                                    <img src="{{ asset($image) }}"
                                                        class="img-fluid rounded-top magnify-img" alt="Treatment Image"
                                                        style="
                                                    height:180px;
                                                    width:100%;
                                                    object-fit:contain;
                                                    cursor:zoom-in;
                                                    transition:transform .2s ease, box-shadow .2s ease;
                                                ">

                                                </a>

                                                <div class="card-body text-center">

                                                    <a href="#" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                                        data-bs-img-src="{{ asset($image) }}">
                                                        View Image

                                                    </a>

                                                </div>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            @else
                                <div class="text-center text-muted py-4">

                                    No treatment images available

                                </div>

                            @endif

                        </div>
                    </div>
                </div>

                {{-- Upload More --}}
                <div class="form-group col-md-6">
                    <label>Add More Treatment Images</label>
                    <input type="file" name="treatment_images[]" multiple class="form-control">
                </div>
                <div id="treatmentPreviewContainer" class="treatment-preview-grid mt-3"></div>

            </div>
        </div>

    </div>

</div>
