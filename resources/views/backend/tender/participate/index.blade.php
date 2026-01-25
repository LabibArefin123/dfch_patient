@extends('adminlte::page')

@section('title', 'Participated Tenders')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Participated Tender List</h1>
        <a href="{{ route('participated_tenders.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2">
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
            <table id="participatedTable" class="table table-bordered table-striped table-hover nowrap w-100">
                <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th class="text-center">Tender Number</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Procuring Authority</th>
                        <th class="text-center">End User</th>
                        <th class="text-center">Publication Date</th>
                        <th class="text-center">Submission Date</th>
                        <th class="text-center">Submission Time</th>
                        <th class="text-center">Offer Price</th>
                        <th class="text-center">Offer Date</th>
                        <th class="text-center">Offer Validity</th>
                        <th class="text-center">FY</th>
                        <th class="text-center">Position</th>
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
    <div class="card mt-4">
        <div class="card-body" style="height:50px;">
            <!-- Intentionally left blank -->
        </div>
    </div>
@stop
@section('js')
    <script>
        $(function() {
            const table = $('#participatedTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                autoWidth: false,
                ajax: '{{ route('participated_tenders.index') }}',
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
                        data: 'offered_price',
                        name: 'offered_price',
                        className: 'text-center'
                    },
                    {
                        data: 'offer_date',
                        name: 'offer_date',
                        className: 'text-center'
                    },
                    {
                        data: 'offer_validity',
                        name: 'offer_validity',
                        className: 'text-center'
                    },
                    {
                        data: 'financial_year',
                        name: 'financial_year',
                        className: 'text-center'
                    },
                    {
                        data: 'position',
                        name: 'position',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'noticeFile',
                        name: 'noticeFile',
                        className: 'text-center'
                    },
                    {
                        data: 'specFile',
                        name: 'specFile',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                rowCallback: function(row, data) {
                    $(row).attr('data-id', data.id);
                }
            });

            // 🟡 Check & display alert
            function processRowAlert(row, nextCallback) {
                const participateId = row.data('id');
                const alertKey = `alertShown_${participateId}`;
                if (localStorage.getItem(alertKey)) {
                    nextCallback(); // Skip if already alerted
                    return;
                }

                const tenderNo = row.find('td:eq(1)').text().trim() || 'N/A';
                const title = row.find('td:eq(2)').text().trim() || 'Untitled Tender';
                const offerDateText = row.find('td:eq(9)').text().trim();
                const offerValidityText = row.find('td:eq(10)').text().trim();

                const today = new Date();
                today.setHours(0, 0, 0, 0);

                let messages = [];
                let showAlert = false;

                // Offer Date alert
                if (offerDateText) {
                    const offerDate = new Date(offerDateText);
                    if (!isNaN(offerDate) && offerDate <= today) {
                        messages.push(`Offer date has passed or is today.`);
                        showAlert = false;
                    }
                }

                // Offer Validity alert
                if (offerValidityText) {
                    const validityDate = new Date(offerValidityText);
                    if (!isNaN(validityDate)) {
                        const diffDays = Math.floor((validityDate - today) / (1000 * 60 * 60 * 24));
                        if (diffDays > 0 && diffDays <= 10) {
                            messages.push(
                                `Offer validity will expire in <b>${diffDays}</b> day(s). Want to extend it?`
                            );
                            showAlert = true;
                        }
                    }
                }

                // Show SweetAlert if needed
                if (showAlert) {
                    Swal.fire({
                        title: `Tender Alert: "${title}" [${tenderNo}]`,
                        html: messages.join('<br><br>'),
                        icon: 'warning',
                        showCancelButton: messages.some(msg => msg.includes('extend')),
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        reverseButtons: true
                    }).then((result) => {
                        localStorage.setItem(alertKey, 'true'); // ✅ Prevent repeat
                        if (result.isConfirmed) {
                            window.location.href = `/participated_tenders`; // Extend link
                        } else {
                            nextCallback(); // Move to next row
                        }
                    });
                } else {
                    nextCallback();
                }
            }

            // Sequentially loop rows and show alerts
            function showAlertsSequentially(rows) {
                if (!rows.length) return;
                const currentRow = rows.shift();
                processRowAlert(currentRow, () => showAlertsSequentially(rows));
            }

            // Trigger after DataTable load
            table.on('draw', function() {
                const rows = $('#participatedTable tbody tr').toArray().map(row => $(row));
                showAlertsSequentially(rows);
            });
        });
    </script>
@endsection
