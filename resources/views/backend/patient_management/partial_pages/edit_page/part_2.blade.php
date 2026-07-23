<div class="col-12">

    <div class="patient-section-card">

        <div class="section-header">
            <div>
                <h5>
                    <i class="fas fa-map-marker-alt"></i>
                    Location Information
                </h5>
                <span>Address & residency details</span>
            </div>
        </div>

        <div class="row">

            {{-- Location Type --}}
            <div class="form-group col-md-6">
                <label>Location Type</label>
                <select name="location_type" id="location_type" class="form-control custom-input">

                    <option value="1" {{ old('location_type', $patient->location_type) == 1 ? 'selected' : '' }}>
                        Simple
                    </option>

                    <option value="2" {{ old('location_type', $patient->location_type) == 2 ? 'selected' : '' }}>
                        Bangladesh
                    </option>

                    <option value="3" {{ old('location_type', $patient->location_type) == 3 ? 'selected' : '' }}>
                        Outside BD
                    </option>

                </select>
            </div>

            {{-- Simple Location --}}
            <div class="form-group col-md-6 location location-1">
                <label>Location</label>
                <textarea name="location_simple" class="form-control">{{ old('location_simple', $patient->location_simple) }}</textarea>
            </div>

            {{-- Bangladesh Location --}}
            <div class="location location-2 col-12">
                <div class="row">

                    <div class="form-group col-md-6">
                        <label>House Address</label>
                        <input type="text" name="house_address" class="form-control"
                            value="{{ old('house_address', $patient->house_address) }}">
                    </div>

                    <div class="form-group col-md-2">
                        <label>City</label>
                        <input type="text" name="city" class="form-control"
                            value="{{ old('city', $patient->city) }}">
                    </div>

                    <div class="form-group col-md-2">
                        <label>District</label>
                        <input type="text" name="district" class="form-control"
                            value="{{ old('district', $patient->district) }}">
                    </div>

                    <div class="form-group col-md-2">
                        <label>Post Code</label>
                        <input type="text" name="post_code" class="form-control"
                            value="{{ old('post_code', $patient->post_code) }}">
                    </div>

                </div>
            </div>

            {{-- Outside Bangladesh --}}
            <div class="location location-3 col-12">
                <div class="row">

                    <div class="form-group col-md-6">
                        <label>Country</label>
                        <input type="text" name="country" class="form-control"
                            value="{{ old('country', $patient->country) }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Passport No</label>
                        <input type="text" name="passport_no" class="form-control"
                            value="{{ old('passport_no', $patient->passport_no) }}">
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>
