@extends('adminlte::page')

@section('title', 'BG / PG Management')

@section('content_header')
    <h1>BG / PG Management</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs" id="bgPgTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="bg-tab" data-toggle="tab" href="#bg" role="tab">Bid Guarantee
                        Information
                        (BG)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pg-tab" data-toggle="tab" href="#pg" role="tab">Performance Guarantee
                        Information
                        (PG)</a>
                </li>
            </ul>
        </div>

        <div class="card-body tab-content" id="bgPgContent">
            {{-- BG TAB --}}
            <div class="tab-pane fade show active" id="bg" role="tabpanel">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>BG No</th>
                            <th>Tender Name</th>
                            <th>Tender No</th>
                            <th>Bank</th>
                            <th>Branch</th>
                            <th>Issue Date</th>
                            <th>Expiry Date</th>
                            <th>Amount</th>
                            <th>Attachment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bgs as $index => $tenderParticipate)
                            @php
                                $bg = $tenderParticipate->bg;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $bg->bg_no ?? '-' }}</td>
                                <td>{{ $tenderParticipate->tender->title ?? '-' }}</td>
                                <td>{{ $tenderParticipate->tender->tender_no ?? '-' }}</td>
                                <td>{{ $bg->issue_in_bank ?? '-' }}</td>
                                <td>{{ $bg->issue_in_branch ?? '-' }}</td>
                                <td>{{ $bg->issue_date ?? '-' }}</td>
                                <td>{{ $bg->expiry_date ?? '-' }}</td>
                                <td>{{ $bg->amount ?? '-' }}</td>
                                <td>
                                    @if (!empty($bg->attachment))
                                        <a href="{{ asset('uploads/documents/bg_attachments/' . $bg->attachment) }}"
                                            target="_blank">View</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($bg)
                                        <a href="{{ route('bg.show', $bg->id) }}" class="btn btn-info btn-sm"
                                            title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('bg.destroy', $bg->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this Bid Guarantee (BG)?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PG TAB --}}
            <div class="tab-pane fade" id="pg" role="tabpanel">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>PG No</th>
                            <th>Tender Name</th>
                            <th>Tender No</th>
                            <th>Bank</th>
                            <th>Branch</th>
                            <th>Issue Date</th>
                            <th>Expiry Date</th>
                            <th>Amount</th>
                            <th>Attachment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pgs as $index => $tenderAwarded)
                            @php
                                $pg = $tenderAwarded->pg;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pg->pg_no ?? '-' }}</td>
                                <td>{{ $tenderAwarded->tenderParticipate->tender->title ?? '-' }}</td>
                                <td>{{ $tenderAwarded->tenderParticipate->tender->tender_no ?? '-' }}</td>
                                <td>{{ $pg->issue_in_bank ?? '-' }}</td>
                                <td>{{ $pg->issue_in_branch ?? '-' }}</td>
                                <td>{{ $pg->issue_date ?? '-' }}</td>
                                <td>{{ $pg->expiry_date ?? '-' }}</td>
                                <td>{{ $pg->amount ?? '-' }}</td>
                                <td>
                                    @if (!empty($pg->attachment))
                                        <a href="{{ asset('uploads/documents/pg_attachments/' . $pg->attachment) }}"
                                            target="_blank">View</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($pg)
                                        <a href="{{ route('pg.show', $pg->id) }}" class="btn btn-info btn-sm"
                                            title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('pg.destroy', $pg->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this Performance Guarantee (PG)?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop
