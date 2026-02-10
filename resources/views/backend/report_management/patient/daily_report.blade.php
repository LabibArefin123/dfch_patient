@extends('adminlte::page')

@section('title', 'Daily Patient Report')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Daily Patient Report</h1>
        <a href="{{ route('report.daily.pdf') }}" class="btn btn-danger btn-sm">
            Download PDF
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
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
                        d.location_type = $('select[name=location_type]').val();
                        d.location_value = $('input[name=location_value]').val();
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

            // Reload table on filter submit
            $('form').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            // PDF with filters
            $('#downloadPdfBtn').on('click', function() {

                let params = $.param({
                    gender: $('select[name=gender]').val(),
                    is_recommend: $('select[name=is_recommend]').val(),
                    location_type: $('select[name=location_type]').val(),
                    location_value: $('input[name=location_value]').val(),
                    from_date: $('input[name=from_date]').val(),
                    to_date: $('input[name=to_date]').val(),
                });

                window.location.href = "{{ route('report.daily.pdf') }}?" + params;
            });

        });
    </script>
@endsection
