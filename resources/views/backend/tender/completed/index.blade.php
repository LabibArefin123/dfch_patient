@extends('adminlte::page')

@section('title', 'Completed Tenders')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Completed Tender List</h1>
        <a href="{{ route('completed_tenders.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-plus" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add New
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body table-responsive">
            <table id="completedTenderTable" class="table table-bordered table-striped table-hover nowrap w-100">
                <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th class="text-center">Tender Number</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Tender Type</th>
                        <th class="text-center">Publication Date</th>
                        <th class="text-center">Submission Date</th>
                        <th class="text-center">Work Order/NOA No</th>
                        <th class="text-center">Work Oder/NOA Date</th>
                        <th class="text-center">Awarded Date</th>
                        <th class="text-center">Delivery Type</th>
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
            $('#completedTenderTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('completed_tenders.index') }}',
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
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
@endsection
