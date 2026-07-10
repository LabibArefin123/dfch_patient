<div class="form-group col-md-4">
    <label>Recommended?</label>
    <select name="is_recommend" id="is_recommend" class="form-control">
        <option value="0">No</option>
        <option value="1">Yes</option>
    </select>
</div>

<div class="recommend-section d-none col-12">
    <div class="row">
        <div class="form-group col-md-6">
            <label>Doctor Name</label>
            <input type="text" name="recommend_doctor_name" class="form-control">
        </div>

        <div class="form-group col-md-6">
            <label>Doctor Note</label>
            <textarea name="recommend_note" class="form-control"></textarea>
        </div>

        <div class="form-group col-md-6">
            <label>Recommendation Documents (PDF)</label>
            <input type="file" name="documents[]" multiple class="form-control">
        </div>
    </div>
</div>
