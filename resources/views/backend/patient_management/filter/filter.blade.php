<div class="card card-outline card-primary shadow-sm mb-4">

    <div class="card-header border-0">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div>
                <h5 class="mb-1 font-weight-bold">
                    <i class="fas fa-filter text-primary mr-2"></i>
                    Patient Filter Center
                </h5>

                <small class="text-muted">
                    Search patients using demographics, treatment history and registration date.
                </small>
            </div>

            <div class="d-flex flex-wrap">

                <span class="badge badge-light border mr-2 px-3 py-2">
                    👶 Child
                    <strong class="text-primary ml-1">{{ $childPatients }}</strong>
                </span>

                <span class="badge badge-light border mr-2 px-3 py-2">
                    🧑 Adult
                    <strong class="text-success ml-1">{{ $adultPatients }}</strong>
                </span>

                <span class="badge badge-light border px-3 py-2">
                    👴 Senior
                    <strong class="text-danger ml-1">{{ $seniorPatients }}</strong>
                </span>

            </div>

        </div>

    </div>

    <div class="card-body">

        <form method="GET" action="{{ route('patients.index') }}">

            <div class="row">

                {{-- Location --}}
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                    <label class="font-weight-semibold">
                        <i class="fas fa-map-marker-alt text-danger mr-1"></i>
                        Location Type
                    </label>

                    <select name="location_type" class="form-control">

                        <option value="">All Locations</option>

                        <option value="1" {{ request('location_type') == '1' ? 'selected' : '' }}>
                            Local Area
                        </option>

                        <option value="2" {{ request('location_type') == '2' ? 'selected' : '' }}>
                            City / District
                        </option>

                        <option value="3" {{ request('location_type') == '3' ? 'selected' : '' }}>
                            Abroad
                        </option>

                    </select>
                </div>

                {{-- Gender --}}
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">

                    <label class="font-weight-semibold">
                        <i class="fas fa-venus-mars text-info mr-1"></i>
                        Gender
                    </label>

                    <select name="gender" class="form-control">

                        <option value="">All Gender</option>

                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>
                            Male
                        </option>

                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>
                            Female
                        </option>

                    </select>

                </div>

                {{-- Recommendation --}}
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">

                    <label class="font-weight-semibold">
                        <i class="fas fa-user-md text-success mr-1"></i>
                        Referred Doctor
                    </label>

                    <select name="is_recommend" class="form-control">

                        <option value="">All</option>

                        <option value="1" {{ request('is_recommend') === '1' ? 'selected' : '' }}>
                            Referred
                        </option>

                        <option value="0" {{ request('is_recommend') === '0' ? 'selected' : '' }}>
                            Not Referred
                        </option>

                    </select>

                </div>

                {{-- Cancer --}}
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">

                    <label class="font-weight-semibold">
                        <i class="fas fa-radiation text-danger mr-1"></i>
                        Cancer History
                    </label>

                    <select name="is_old_cancer" class="form-control">

                        <option value="">All Patients</option>

                        <option value="1" {{ request('is_old_cancer') == '1' ? 'selected' : '' }}>
                            Has Cancer Report
                        </option>

                        <option value="0" {{ request('is_old_cancer') == '0' ? 'selected' : '' }}>
                            No Cancer Report
                        </option>

                    </select>

                </div>

                {{-- Treatment --}}
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">

                    <label class="font-weight-semibold">
                        <i class="fas fa-procedures text-warning mr-1"></i>
                        Treatment
                    </label>

                    <select name="is_treatment" class="form-control">

                        <option value="">All Patients</option>

                        <option value="1" {{ request('is_treatment') === '1' ? 'selected' : '' }}>
                            Under Treatment
                        </option>

                        <option value="0" {{ request('is_treatment') === '0' ? 'selected' : '' }}>
                            No Treatment
                        </option>

                    </select>

                </div>

                {{-- Investigation --}}
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">

                    <label class="font-weight-semibold">
                        <i class="fas fa-microscope text-secondary mr-1"></i>
                        Investigation
                    </label>

                    <select name="is_investigated" class="form-control">

                        <option value="">All Patients</option>

                        <option value="1" {{ request('is_investigated') === '1' ? 'selected' : '' }}>
                            Investigated
                        </option>

                        <option value="0" {{ request('is_investigated') === '0' ? 'selected' : '' }}>
                            Not Investigated
                        </option>

                    </select>

                </div>

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-ambulance text-danger mr-1"></i>
                            Emergency Patient
                        </label>

                        <select name="is_emergency" class="form-control">
                            <option value="">All Patients</option>

                            <option value="1" {{ request('is_emergency') === '1' ? 'selected' : '' }}>
                                Emergency
                            </option>

                            <option value="0" {{ request('is_emergency') === '0' ? 'selected' : '' }}>
                                Non-Emergency
                            </option>
                        </select>
                    </div>
                </div>

                {{-- Date Filter --}}
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">

                    <label class="font-weight-semibold">
                        <i class="fas fa-calendar-alt text-primary mr-1"></i>
                        Registration Date
                    </label>

                    <select name="date_filter" id="dateFilter" class="form-control">

                        <option value="">All Time</option>

                        <option value="today">Today</option>

                        <option value="yesterday">Yesterday</option>

                        <option value="last_7_days">Last 7 Days</option>

                        <option value="last_30_days">Last 30 Days</option>

                        <option value="this_month">This Month</option>

                        <option value="last_month">Last Month</option>

                        <option value="this_year">This Year</option>

                        <option value="custom">Custom Range</option>

                    </select>

                </div>

                {{-- Start Date --}}
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3 d-none" id="startDateDiv">

                    <label class="font-weight-semibold">
                        From Date
                    </label>

                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">

                </div>

                {{-- End Date --}}
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3 d-none" id="endDateDiv">

                    <label class="font-weight-semibold">
                        To Date
                    </label>

                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">

                </div>

            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <small class="text-muted">
                    <i class="fas fa-info-circle mr-1"></i>
                    Multiple filters can be combined for more accurate results.
                </small>

                <div>

                    <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">

                        <i class="fas fa-redo mr-1"></i>

                        Reset

                    </a>

                    <button class="btn btn-primary ml-2">

                        <i class="fas fa-search mr-1"></i>

                        Apply Filters

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
