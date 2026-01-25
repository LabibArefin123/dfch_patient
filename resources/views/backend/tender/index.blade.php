@extends('adminlte::page')

@section('title', 'All Tenders')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Tender List</h1>
    </div>
    <style>
        .card-body {
            overflow-x: auto;
            /* horizontal scroll for small screens */
            padding-bottom: 70px;
            /* add space for pagination */
        }
    </style>
@stop

@section('content')
    <div class="card">
        <div class="card-body table-responsive">
            <table id="yajraTable" class="table table-bordered table-striped table-hover nowrap w-100">
                <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th class="text-start">Tender Number</th>
                        <th class="text-start">Title</th>
                        <th class="text-center">Procuring Authority</th>
                        <th class="text-center">End User</th>
                        <th class="text-center">Item</th>
                        <th class="text-center">Deno</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Publication Date</th>
                        <th class="text-center">Submission Date</th>
                        <th class="text-center">Submission Time</th>
                        <th class="text-center">FY</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Notice</th>
                        <th class="text-center">Spec</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function() {
            $('#yajraTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                // autoWidth: false,
                lengthChange: true,
                pageLength: 10, // default page length
                language: {
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'></i>",
                        next: "<i class='fas fa-chevron-right'></i>"
                    }
                },
                ajax: '{{ route('tenders.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'tender_no',
                        name: 'tender_no',
                        className: 'text-center'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        className: 'text-center'
                    },
                    {
                        data: 'procuring_authority',
                        name: 'procuring_authority',
                        className: 'text-center'
                    },
                    {
                        data: 'end_user',
                        name: 'end_user',
                        className: 'text-center'
                    },
                    {
                        data: 'item',
                        name: 'item',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'deno',
                        name: 'deno',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'publication_date',
                        name: 'publication_date',
                        className: 'text-center'
                    },
                    {
                        data: 'submission_date',
                        name: 'submission_date',
                        className: 'text-center'
                    },
                    {
                        data: 'submission_time',
                        name: 'submission_time',
                        className: 'text-center'
                    },
                    {
                        data: 'financial_year',
                        name: 'financial_year',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'noticeFile',
                        name: 'noticeFile',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'specFile',
                        name: 'specFile',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endsection
