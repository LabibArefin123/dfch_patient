{{-- ========================================================= --}}
{{-- ADDRESS INFORMATION --}}
{{-- ========================================================= --}}

<div class="patient-section-card">

    <div class="section-header info">

        <div class="section-icon">
            <i class="fas fa-map-marked-alt"></i>
        </div>

        <div class="section-content">
            <h3>Address Information</h3>
            <p class="mb-0">
                Select the patient's location type and provide the corresponding address details.
            </p>
        </div>

    </div>

    <div class="section-body">

        <div class="row">

            {{-- Location Type --}}
            <div class="form-group col-lg-6">

                <label class="required-field">
                    Location Type
                </label>

                <div class="input-group modern-input">

                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-globe-asia"></i>
                        </span>
                    </div>

                    <select name="location_type" id="location_type" class="form-control">

                        <option value="">
                            Select Location Type
                        </option>

                        <option value="1" {{ old('location_type') == '1' ? 'selected' : '' }}>
                            Simple Address
                        </option>

                        <option value="2" {{ old('location_type') == '2' ? 'selected' : '' }}>
                            Bangladesh Address
                        </option>

                        <option value="3" {{ old('location_type') == '3' ? 'selected' : '' }}>
                            Outside Bangladesh
                        </option>

                    </select>

                </div>

            </div>

            {{-- Information Box --}}
            <div class="col-lg-6">

                <div class="location-help-box">

                    <i class="fas fa-info-circle"></i>

                    <div>

                        <strong>Location Guide</strong>

                        <p class="mb-0">
                            Choose the appropriate location type. Additional address fields will
                            automatically appear below.
                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- ================================================= --}}
        {{-- SIMPLE LOCATION --}}
        {{-- ================================================= --}}

        <div class="location location-1 d-none">

            <div class="address-block mt-4">

                <div class="address-title">

                    <i class="fas fa-map-marker-alt mr-2"></i>

                    Simple Address

                </div>

                <div class="row">

                    <div class="form-group col-md-12">

                        <label>
                            Address
                        </label>

                        <textarea name="location_simple" rows="4" class="form-control"
                            placeholder="Example: Mirpur-10, Dhaka, Bangladesh">{{ old('location_simple') }}</textarea>

                    </div>

                </div>

            </div>

        </div>

        {{-- ================================================= --}}
        {{-- BANGLADESH ADDRESS --}}
        {{-- ================================================= --}}

        <div class="location location-2 d-none">

            <div class="address-block mt-4">

                <div class="address-title">

                    <i class="fas fa-home mr-2"></i>

                    Bangladesh Address

                </div>

                <div class="row">

                    <div class="form-group col-lg-6">

                        <label>
                            House Address
                        </label>

                        <input type="text" name="house_address" class="form-control"
                            placeholder="House / Road / Village" value="{{ old('house_address') }}">

                    </div>

                    <div class="form-group col-lg-3">

                        <label>
                            City
                        </label>

                        <input type="text" name="city" class="form-control" placeholder="City"
                            value="{{ old('city') }}">

                    </div>

                    <div class="form-group col-lg-3">

                        <label>
                            District
                        </label>

                        <input type="text" name="district" class="form-control" placeholder="District"
                            value="{{ old('district') }}">

                    </div>

                    <div class="form-group col-lg-3">

                        <label>
                            Post Code
                        </label>

                        <input type="text" name="post_code" class="form-control" placeholder="Postal Code"
                            value="{{ old('post_code') }}">

                    </div>

                </div>

            </div>

        </div>

        {{-- ================================================= --}}
        {{-- FOREIGN ADDRESS --}}
        {{-- ================================================= --}}

        <div class="location location-3 d-none">

            <div class="address-block mt-4">

                <div class="address-title">

                    <i class="fas fa-plane-departure mr-2"></i>

                    International Address

                </div>

                <div class="row">

                    <div class="form-group col-lg-6">

                        <label>
                            Country
                        </label>

                        <input type="text" name="country" class="form-control" placeholder="Country"
                            value="{{ old('country') }}">

                    </div>

                    <div class="form-group col-lg-6">

                        <label>
                            Passport Number
                        </label>

                        <input type="text" name="passport_no" class="form-control" placeholder="Passport Number"
                            value="{{ old('passport_no') }}">

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
