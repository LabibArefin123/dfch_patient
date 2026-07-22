<div class="col-12">

    <div class="patient-section-card investigation-card">

        <div class="section-header">

            <div>

                <h5>
                    <i class="fas fa-microscope text-primary"></i>
                    Investigation Information
                </h5>

                <span>
                    Investigation history & diagnostic image archive
                </span>

            </div>

            <span class="section-badge investigation-badge">
                Diagnostic Record
            </span>

        </div>

        <div class="row">

            <div class="form-group col-md-6">

                <label>Is Investigated?</label>

                <select name="is_investigated" id="is_investigated" class="form-control">

                    <option value="0"
                        {{ old('is_investigated', $patient->is_investigated) == 0 ? 'selected' : '' }}>
                        No
                    </option>

                    <option value="1"
                        {{ old('is_investigated', $patient->is_investigated) == 1 ? 'selected' : '' }}>
                        Yes
                    </option>

                </select>

            </div>

        </div>

        <div class="investigation-section">

            <div class="row">

                <div class="form-group col-md-6">

                    <label>Investigation Information</label>

                    <textarea name="investigation_information" id="edit_investigation_information" class="form-control">{{ old('investigation_information', $patient->investigation_information) }}</textarea>

                </div>

                {{-- Existing Images --}}
                <div class="form-group col-md-12">

                    <label>Investigation Images</label>

                    <div class="card shadow-sm border-0">

                        <div class="card-body">

                            @if (!empty($patient->investigation_images))

                                <div class="row">

                                    @foreach ($patient->investigation_images as $image)
                                        <div class="col-md-4 col-lg-3 mb-3">

                                            <div class="card h-100 border-0 investigation-image-card">

                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#imageZoomModal"
                                                    data-bs-img-src="{{ asset($image) }}" class="text-decoration-none">

                                                    <img src="{{ asset($image) }}"
                                                        class="img-fluid investigation-gallery-image"
                                                        alt="Investigation Image">

                                                </a>

                                                <div class="card-body text-center">

                                                    <a href="#" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                                        data-bs-img-src="{{ asset($image) }}">

                                                        <i class="fas fa-search-plus mr-1"></i>
                                                        Magnify

                                                    </a>

                                                </div>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            @else
                                <div class="text-center text-muted py-4">

                                    No investigation images available

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

                {{-- Upload More --}}
                <div class="form-group col-md-6">

                    <label>Add More Investigation Images</label>

                    <input type="file" name="investigation_images[]" multiple class="form-control">

                </div>

            </div>

        </div>

    </div>

</div>
