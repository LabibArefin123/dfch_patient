    {{-- Location Type --}}
    <div class="form-group col-md-6">
        <label>Location Type <span class="text-danger">*</span></label>
        <select name="location_type" id="location_type" class="form-control">
            <option value="">Select</option>
            <option value="1">Simple Location</option>
            <option value="2">Bangladesh Address</option>
            <option value="3">Outside Bangladesh</option>
        </select>
    </div>

    {{-- Type 1 --}}
    <div class="form-group col-md-6 location location-1 d-none">
        <label>Location</label>
        <textarea name="location_simple" class="form-control"></textarea>
    </div>

    {{-- Type 2 --}}
    <div class="location location-2 d-none col-12">
        <div class="row">
            <div class="form-group col-md-6">
                <label>House Address</label>
                <input type="text" name="house_address" class="form-control">
            </div>
            <div class="form-group col-md-3">
                <label>City</label>
                <input type="text" name="city" class="form-control">
            </div>
            <div class="form-group col-md-3">
                <label>District</label>
                <input type="text" name="district" class="form-control">
            </div>
            <div class="form-group col-md-3">
                <label>Post Code</label>
                <input type="text" name="post_code" class="form-control">
            </div>
        </div>
    </div>

    {{-- Type 3 --}}
    <div class="location location-3 d-none col-12">
        <div class="row">
            <div class="form-group col-md-6">
                <label>Country</label>
                <input type="text" name="country" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label>Passport No</label>
                <input type="text" name="passport_no" class="form-control">
            </div>
        </div>
    </div>
