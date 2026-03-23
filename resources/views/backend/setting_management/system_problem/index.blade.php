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
                        <th>Status Email</th>
                        <th>Remarks</th>
                        <th>Notify</th>
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
    <script>
        $(function() {

            function showDtToast(message) {
                $('#dtErrorMessage').text(message);
                $('#dtErrorToast').addClass('show');
            }

            function closeDtToast() {
                $('#dtErrorToast').removeClass('show');
            }

            $.fn.dataTable.ext.errMode = 'none'; // Disable default alert

            const table = $('#systemProblemTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('system_problems.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'problem_uid'
                    },
                    {
                        data: 'problem_title'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'status_email',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'remarks',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'notify',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'problem_file',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function() {
                    // Optional: any JS after redraw
                }
            });

            // Catch column mismatch / JSON issues
            table.on('error.dt', function(e, settings, techNote, message) {
                console.error('DataTable Tech Error:', message);
                showDtToast(
                    'A system configuration issue was detected. ' +
                    'Please notify the technical team.'
                );
            });

            // Notify button click
            $(document).on('click', '.notify-btn', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Send Notification',
                    html: `
                <input type="email" id="to_email" class="swal2-input" placeholder="Recipient Email">
                <textarea id="remarks" class="swal2-textarea" placeholder="Remarks (optional)"></textarea>
            `,
                    showCancelButton: true,
                    confirmButtonText: 'Send',
                    preConfirm: () => {
                        const email = Swal.getPopup().querySelector('#to_email').value;
                        const remarks = Swal.getPopup().querySelector('#remarks').value;
                        if (!email) {
                            Swal.showValidationMessage('Recipient email is required');
                        }
                        return {
                            email,
                            remarks
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('/system-problems/notify/' + id, {
                                to_email: result.value.email,
                                remarks: result.value.remarks,
                                _token: '{{ csrf_token() }}'
                            })
                            .done(function(res) {
                                Swal.fire('Success!', 'Email sent successfully!', 'success');
                                table.ajax.reload();
                            })
                            .fail(function(err) {
                                Swal.fire('Error', 'Failed to send email.', 'error');
                            });
                    }
                });
            });
        });
    </script>
@endsection
