@extends('adminlte::page')

@section('title', 'Yearly Patient Report')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Yearly Patient Report</h1>

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

            {{-- FILTER --}}
            <div class="collapse mb-3" id="filterSection">
                <div class="card card-body">
                    <form id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Year</label>
                                <select name="year" class="form-control">
                                    <option value="">All</option>
                                    @for ($y = now()->year; $y >= 2015; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>

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

                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">Apply Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <table class="table table-striped table-hover w-100" id="yearlyPatientsTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Patient Code</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Alt Phone</th>
                        <th>Father</th>
                        <th>Mother</th>
                        <th>Location</th>
                        <th>Recommended</th>
                        <th>Date Added</th>
                        <th>Action</th>
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
    
    {{-- Warning Modal --}}
    <div class="modal fade" id="warningMessage" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle"></i>
                        PDF Record Limit Warning
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body text-center">
                    <h5 class="text-danger">
                        Maximum 300 records reached ({{ session('totalRecords') }})
                    </h5>
                    <p>Do you want to generate PDF with first 300 records?</p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" id="confirmPdfBtn" class="btn btn-success">
                        Yes, Generate
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Cancel
                    </button>
                </div>

            </div>
        </div>
    </div>

@stop

@section('js')
    <script>
        $(function() {
            let table = $('#yearlyPatientsTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('report.yearly') }}",
                    data: function(d) {
                        d.year = $('select[name=year]').val();
                        d.gender = $('select[name=gender]').val();
                        d.is_recommend = $('select[name=is_recommend]').val();
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

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            // Handle Download PDF button
            $('#downloadPdfBtn').on('click', function(e) {
                e.preventDefault();
                let params = $.param({
                    year: $('select[name=year]').val(),
                    gender: $('select[name=gender]').val(),
                    is_recommend: $('select[name=is_recommend]').val(),
                });

                // Open PDF in new tab
                window.open("{{ route('report.yearly.pdf') }}?" + params, '_blank');
            });
        });

        // ================== TOAST CONFIRM PDF ==================
        // ================== MODAL CONFIRM PDF ==================
        @if (session('confirm_pdf'))
            $(document).ready(function() {
                $('#warningMessage').modal('show');

                $('#confirmPdfBtn').on('click', function() {

                    let params = new URLSearchParams({
                        year: "{{ session('year') }}",
                        gender: "{{ session('gender') }}",
                        is_recommend: "{{ session('is_recommend') }}",
                        confirm: 1
                    });

                    window.open("{{ route('report.yearly.pdf') }}?" + params.toString(), '_blank');

                    $('#warningMessage').modal('hide');
                });
            });
        @endif
    </script>
@endsection
