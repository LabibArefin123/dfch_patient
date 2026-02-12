<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('patients.index') }}">

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">

                {{-- Left: Title --}}
                <h4 class="mb-2 mb-md-0">
                    🔎 Filter Patients
                </h4>

                {{-- Right: Age Statistics --}}
                <div class="text-md-right text-muted small">
                    👶 Child Patients:
                    <strong id="childCount" class="text-secondary">
                        {{ $childPatients }}
                    </strong>

                    🧑 Adult Patients:
                    <strong id="adultCount" class="text-secondary">
                        {{ $adultPatients }}
                    </strong>

                    👴 Senior Patients:
                    <strong id="seniorCount" class="text-secondary">
                        {{ $seniorPatients }}
                    </strong>

                </div>

            </div>

            {{-- ROW 2 : Patient Type --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="small text-muted">Location Type</label>
                    <select name="location_type" class="form-control form-control-sm">
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

                <div class="col-md-4">
                    <label class="small text-muted">Location Keyword</label>
                    <input type="text" name="location_value" class="form-control form-control-sm"
                        placeholder="e.g. Dhaka, Chittagong, USA" value="{{ request('location_value') }}">
                </div>
                <div class="col-md-4">
                    <label class="small text-muted">Filter by Gender</label>
                    <select name="gender" class="form-control form-control-sm">
                        <option value="">All Genders</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="small text-muted">Filter by Recommendation</label>
                    <select name="is_recommend" class="form-control form-control-sm">
                        <option value="">Recommended?</option>
                        <option value="1" {{ request('is_recommend') === '1' ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('is_recommend') === '0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="small text-muted">Date Range</label>
                    <select name="date_filter" id="dateFilter" class="form-control form-control-sm">
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

                {{-- Custom Date Fields --}}
                <div class="col-md-2 d-none" id="startDateDiv">
                    <label class="small text-muted">Start Date</label>
                    <input type="date" name="from_date" class="form-control form-control-sm">
                </div>

                <div class="col-md-2 d-none" id="endDateDiv">
                    <label class="small text-muted">End Date</label>
                    <input type="date" name="to_date" class="form-control form-control-sm">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        Apply Filter
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
