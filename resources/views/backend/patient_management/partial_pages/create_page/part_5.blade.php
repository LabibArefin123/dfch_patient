<div class="card card-primary card-outline">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-procedures mr-2"></i>
            Treatment Information
        </h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-12">
                <label>Has Treatment?</label>
                <select name="is_treatment" id="is_treatment" class="form-control">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
        </div>

        <div id="treatmentSection" style="display:none;">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Treatment Type</label>
                    <select name="treatment_type" id="treatment_type" class="form-control">
                        <option value="">-- Select Treatment Type --</option>
                        <option value="OPD">OPD</option>
                        <option value="OT">OT</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>Treatment Images</label>
                    <input type="file" class="form-control" name="treatment_images[]" multiple accept="image/*">
                    <div id="treatmentPreviewContainer" class="treatment-preview-grid mt-3"></div>
                </div>

                <div class="form-group col-md-12">
                    <label>Treatment Information</label>
                    <textarea id="treatment_information" name="treatment_information" class="form-control ckeditor"></textarea>
                </div>

            </div>

        </div>

    </div>

</div>
