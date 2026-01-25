@extends('adminlte::page')

@section('title', 'Awarded Tenders')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Awarded Tender List</h1>
        <a href="{{ route('awarded_tenders.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-plus" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add New
        </a>
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
            <table id="awardedTable" class="table table-bordered table-striped table-hover nowrap w-100">
                <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Tender Number</th>
                        <th>Title</th>
                        <th>Tender Type</th>
                        <th>Publication Date</th>
                        <th>Submission Date</th>
                        <th>Work Order/NOA No</th>
                        <th>Work Order/NOA Date</th>
                        <th>Awarded Date</th>
                        <th>Delivery Type</th>
                        <th>Position</th>
                        <th>Actions</th>
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
            const table = $('#awardedTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                autoWidth: false,
                ajax: '{{ route('awarded_tenders.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tender_no',
                        name: 'tender_no'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'tender_type',
                        name: 'tender_type'
                    },
                    {
                        data: 'publication_date',
                        name: 'publication_date'
                    },
                    {
                        data: 'submission_date',
                        name: 'submission_date'
                    },
                    {
                        data: 'workorder_no',
                        name: 'workorder_no'
                    },
                    {
                        data: 'workorder_date',
                        name: 'workorder_date'
                    },
                    {
                        data: 'awarded_date',
                        name: 'awarded_date'
                    },
                    {
                        data: 'delivery_type',
                        name: 'delivery_type'
                    },
                    {
                        data: 'position',
                        name: 'position'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endsection
