<div class="form-group col-md-6">
    <label>Is Treatment?</label>
    <select name="is_treatment" id="is_treatment" class="form-control">
        <option value="0" {{ !$patient->is_treatment ? 'selected' : '' }}>No</option>
        <option value="1" {{ $patient->is_treatment ? 'selected' : '' }}>Yes</option>
    </select>
</div>

<div class="treatment-section">

    <div class="form-group col-md-6">

        <label>Treatment Type</label>

        <select name="treatment_type" class="form-control">

            <option value="">Select Treatment Type</option>

            <option value="OPD" {{ old('treatment_type', $patient->treatment_type) == 'OPD' ? 'selected' : '' }}>
                OPD
            </option>

            <option value="OT" {{ old('treatment_type', $patient->treatment_type) == 'OT' ? 'selected' : '' }}>
                OT
            </option>

        </select>

    </div>

    <div class="form-group col-md-6">

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
                                    <img src="{{ asset($image) }}" class="img-fluid rounded-top"
                                        style="height:180px;width:100%;object-fit:cover;cursor:zoom-in;">
                                    <div class="card-body text-center">
                                        <a href="{{ asset($image) }}" class="btn btn-sm btn-primary previewImageBtn">
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

</div>
