<div class="form-group col-md-6">
    <label>Is Investigated?</label>
    <select name="is_investigated" id="is_investigated" class="form-control">
        <option value="0" {{ !$patient->is_investigated ? 'selected' : '' }}>No</option>
        <option value="1" {{ $patient->is_investigated ? 'selected' : '' }}>Yes</option>
    </select>
</div>
<div class="investigation-section">

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
