@extends('adminlte::page')

@section('title', 'System Problems')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">System Problems</h1>
    </div>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap w-100" id="systemProblemTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Problem ID</th>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>Attachment</th>
                        <th>Reported At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="mb-4"></div>
@stop

@section('js')
    {{-- <script>
        $(function() {
            $('#systemProblemTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('system_problems.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'problem_uid',
                        name: 'problem_uid'
                    },
                    {
                        data: 'problem_title',
                        name: 'problem_title'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'problem_file',
                        name: 'problem_file',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script> --}}
    <script>
    function showDtToast(message) {
        $('#dtErrorMessage').text(message);
        $('#dtErrorToast').addClass('show');
    }

    function closeDtToast() {
        $('#dtErrorToast').removeClass('show');
    }

    $(function () {

        $.fn.dataTable.ext.errMode = 'none'; // Disable default alert

        const table = $('#systemProblemTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('system_problems.index') }}",
                error: function (xhr, error, thrown) {

                    // Developer console
                    console.error('DataTable Error:', xhr.responseText);

                    // Friendly UI message
                    showDtToast(
                        'We couldn’t load the system problems right now. ' +
                        'Please contact the system administrator.'
                    );
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'problem_uid' },
                { data: 'problem_title' },
                { data: 'status' },
                { data: 'problem_file', orderable: false, searchable: false },
                { data: 'created_at' },
                { data: 'action', orderable: false, searchable: false }
            ]
        });

        // Catch column mismatch / JSON issues
        table.on('error.dt', function (e, settings, techNote, message) {
            console.error('DataTable Tech Error:', message);
            showDtToast(
                'A system configuration issue was detected. ' +
                'Please notify the technical team.'
            );
        });
    });
</script>
@endsection
