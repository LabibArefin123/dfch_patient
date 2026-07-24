<div class="form-group col-md-4">
    <label>Is Referred Patient?</label>
    <select name="is_recommend" id="is_recommend" class="form-control">
        <option value="0">No</option>
        <option value="1">Yes</option>
    </select>
</div>

<div class="recommend-section d-none col-12">
    <div class="row">
        <div class="form-group col-md-6">
            <label>Referred Doctor Name</label>
            <input type="text" name="recommend_doctor_name" class="form-control">
        </div>

        <div class="form-group col-md-6">
            <label>Referred Doctor Note</label>
            <textarea name="recommend_note" class="form-control"></textarea>
        </div>

        <div class="form-group col-md-6">
            <label>Referred Documents (PDF/Image)</label>
            <input type="file" name="documents[]" multiple class="form-control">
        </div>
    </div>
    <div id="referPreviewContainer" class="refer-preview-container mt-3"></div>
</div>
