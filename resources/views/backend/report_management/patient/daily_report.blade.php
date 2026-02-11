@extends('adminlte::page')

@section('title', 'Daily Patient Report')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Daily Patient Report</h1>

        <div>
            <button class="btn btn-info btn-sm mr-2" data-toggle="collapse" data-target="#filterSection">
                <i class="fas fa-filter"></i> Filter
            </button>

            <a href="#" id="downloadPdfBtn" target="_blank" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <div class="collapse mb-3" id="filterSection">
                <div class="card card-body">
                    <form id="filterForm">
                        <div class="row">

                            <div class="col-md-3">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="">All</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Recommended</label>
                                <select name="is_recommend" class="form-control">
                                    <option value="">All</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>From Date</label>
                                <input type="date" name="from_date" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label>To Date</label>
                                <input type="date" name="to_date" class="form-control">
                            </div>

                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Apply Filter
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-striped table-hover text-nowrap w-100" id="patientsReportTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Patient Code</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Alt Phone</th>
                        <th>Father's Phone</th>
                        <th>Mother's Phone</th>
                        <th>Location</th>
                        <th>Recommended</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>
@stop
@section('js')
    <script>
        $(function() {

            let table = $('#patientsReportTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('report.daily') }}",
                    data: function(d) {
                        d.gender = $('select[name=gender]').val();
                        d.is_recommend = $('select[name=is_recommend]').val();
                        d.from_date = $('input[name=from_date]').val();
                        d.to_date = $('input[name=to_date]').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'patient_code'
                    },
                    {
                        data: 'patient_name'
                    },
                    {
                        data: 'age'
                    },
                    {
                        data: 'gender'
                    },
                    {
                        data: 'phone_1'
                    },
                    {
                        data: 'phone_2'
                    },
                    {
                        data: 'phone_f_1'
                    },
                    {
                        data: 'phone_m_1'
                    },
                    {
                        data: 'location'
                    },
                    {
                        data: 'is_recommend'
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Apply Filter
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            // PDF Button
            $('#downloadPdfBtn').on('click', function(e) {

                e.preventDefault();

                let params = $.param({
                    gender: $('select[name=gender]').val(),
                    is_recommend: $('select[name=is_recommend]').val(),
                    from_date: $('input[name=from_date]').val(),
                    to_date: $('input[name=to_date]').val(),
                });

                window.open("{{ route('report.daily.pdf') }}?" + params, '_blank');
            });

        });
    </script>
@endsection
