@extends('adminlte::page')

@section('title', 'Archived Tenders')

@section('css')
    {{-- <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" /> --}}
    {{-- <style>
        table.dataTable td {
            white-space: nowrap;
            /* ✅ row venge jeno na jai */
        }
    </style> --}}
@endsection

@section('content_header')
    <h1>Archived Tenders</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="archiveTable" class="table table-bordered table-striped w-100">
                <style>
                    /* Hover effect for table row, excluding cells with .no-hover */
                    .tender-row td:not(.no-hover):hover {
                        background-color: #ff9900;

                        transition: background-color 0.3s ease, color 0.3s ease;
                    }

                    /* Optional: highlight entire row except no-hover cells */
                    .tender-row:hover td:not(.no-hover) {}
                </style>
                <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Tender No</th>
                        <th>Title</th>
                        <th>Procuring Authority</th>
                        <th>End User</th>
                        <th>Item</th>
                        <th>Deno</th>
                        <th>Quantity</th>
                        <th>Publication Date</th>
                        <th>Submission Date</th>
                        <th>Submission Time</th>
                        <th>Financial Year</th>
                        <th>Status</th>
                        <th>Notice</th>
                        <th>Spec</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($archivedTenders as $index => $tender)
                        <tr class="tender-row" onclick="window.location='{{ route('tenders.show', $tender->id) }}'"
                            style="cursor:pointer;">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tender->tender_no }}</td>
                            <td>{{ $tender->title }}</td>
                            <td>{{ $tender->procuring_authority }}</td>
                            <td>{{ $tender->end_user }}</td>
                            <td>{{ optional(json_decode($tender->items, true))[0]['item'] ?? 'N/A' }}</td>
                            <td>{{ optional(json_decode($tender->items, true))[0]['deno'] ?? 'N/A' }}</td>
                            <td>{{ optional(json_decode($tender->items, true))[0]['quantity'] ?? 'N/A' }}</td>
                            <td>{{ $tender->publication_date ? \Carbon\Carbon::parse($tender->publication_date)->format('d F Y') : '' }}
                            </td>
                            <td>{{ $tender->submission_date ? \Carbon\Carbon::parse($tender->submission_date)->format('d F Y') : '' }}
                            </td>
                            <td>
                                {{ $tender->submission_time ? \Carbon\Carbon::parse($tender->submission_time)->format('h:i A') : '' }}
                            </td>
                            <td>{{ $tender->financial_year }}</td>
                            <td>
                                @if ($tender->status == 4)
                                    <span class="badge bg-success">Completed Tender</span>
                                @else
                                    <span class="badge bg-danger">Archived</span>
                                @endif
                            </td>
                            <!-- These two td’s should not be hover-highlighted -->
                            <td class="no-hover">
                                @if ($tender->notice_file)
                                    <a href="{{ asset('uploads/documents/notice_files/' . $tender->notice_file) }}"
                                        target="_blank" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
                                @else
                                    <span class="text-muted">No Notice</span>
                                @endif
                            </td>
                            <td class="no-hover">
                                @if ($tender->spec_file)
                                    <a href="{{ asset('uploads/documents/spec_files/' . $tender->spec_file) }}"
                                        target="_blank" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                @else
                                    <span class="text-muted">No Spec</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
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
            $('#archiveTable').DataTable({
                pageLength: 25,

            });
        });
    </script>
@stop
