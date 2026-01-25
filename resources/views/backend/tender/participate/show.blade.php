@extends('adminlte::page')
@section('title', 'View Participated Tender')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Participated Tender Details</h1>
        <a href="{{ route('participated_tenders.edit', $participated->id) }}"
            class="btn btn-sm btn-warning d-flex align-items-center gap-1 flex-shrink-0">
            Edit
        </a>
    </div>
@stop

@section('content')
    <ul class="nav nav-tabs" id="employeeTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tender-tab" data-toggle="tab" href="#tender" role="tab"
                aria-selected="true">Tender Info</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="bg-tab" data-bs-toggle="tab" href="#bgInfo" role="tab" aria-controls="bgInfo"
                aria-selected="false">Bid Guarantee (BG) Info</a>
        </li>
    </ul>
    <div class="tab-content p-4 border border-top-0 rounded-bottom" id="employeeTabContent">
        <div class="tab-pane fade show active" id="tender" role="tabpanel" aria-labelledby="tender-tab">
            <div class="card">
                <div class="card-body row">

                    {{-- Tender Details --}}
                    @php $tender = $participated->tender; @endphp

                    <div class="form-group col-md-6">
                        <label><strong>Tender Number</strong></label>
                        <p class="form-control" readonly>{{ $tender->tender_no }}</p>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Tender Title</strong></label>
                        <p class="form-control" readonly>{{ $tender->title }}</p>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Procurring Authority</strong></label>
                        <p class="form-control" readonly>{{ $tender->procuring_authority }}</p>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>End Year</strong></label>
                        <p class="form-control" readonly>{{ $tender->end_user }}</p>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Financial Year</strong></label>
                        <p class="form-control" readonly>{{ $tender->financial_year }}</p>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Tender Type</strong></label>
                        <p class="form-control" readonly>{{ $tender->tender_type }}</p>
                    </div>


                    {{-- Item Table --}}
                    <div class="form-group col-md-12 mt-3">
                        <label><strong>Item Details</strong></label>
                        <table class="table table-bordered mt-2">
                            <thead class="table-light">
                                <tr>
                                    <th>Sl</th>
                                    <th>Item</th>
                                    <th>Deno</th>
                                    <th>Quantity</th>
                                    <th>Unit Price (৳)</th>
                                    <th>Total Price (৳)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp

                                @forelse ($items as $item)
                                    @php
                                        $qty = floatval($item['quantity'] ?? 0);
                                        $unitPrice = floatval($item['unit_price'] ?? 0);
                                        $totalPrice = $qty * $unitPrice;
                                        $grandTotal += $totalPrice;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $item['item'] ?? '-' }}</td>
                                        <td>{{ $item['deno'] ?? '-' }}</td>
                                        <td>{{ $qty }}</td>
                                        <td>{{ number_format($unitPrice, 2) }}</td>
                                        <td>{{ number_format($totalPrice, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No item data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                            @if ($grandTotal > 0)
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="5" class="text-end fw-bold">Grand Total (৳)</td>
                                        <td class="fw-bold">{{ number_format($grandTotal, 2) }}</td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>

                    <div class="form-group col-md-6">
                        <label> <strong>Publication Date</strong></label>
                        <div class="form-control" readonly>
                            {{ \Carbon\Carbon::parse($tender->publication_date)->format('d F Y') }}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Submission Date</strong></label>
                        <div class="form-control" readonly>
                            {{ \Carbon\Carbon::parse($tender->submission_date)->format('d F Y') }}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Submission Time</strong></label>
                        <div class="form-control" readonly>
                            {{ \Carbon\Carbon::parse($tender->submission_time)->format('g:i A') }}
                        </div>
                    </div>

                    <x-adminlte-input name="offer_no" label="Offer Number" value="{{ $participated->offer_no ?? '-' }}"
                        disabled fgroup-class="col-md-6" />

                    <div class="form-group col-md-6">
                        <label>Offered Price</label>
                        <div class="form-control" readonly>
                            @php
                                $company = $participated->companies
                                    ->where('company_name', Auth::user()->company_name)
                                    ->first();
                            @endphp
                            {{ $company && $company->offered_price ? number_format($company->offered_price, 2) . ' ৳' : 'N/A' }}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Offer Date</strong></label>
                        <div class="form-control" readonly>
                            {{ \Carbon\Carbon::parse($participated->offer_date)->format('d F Y') }}
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Offer Validity</strong></label>
                        <div class="form-control" readonly>
                            {{ \Carbon\Carbon::parse($participated->offer_validity)->format('d F Y') }}
                        </div>
                    </div>

                    {{-- Offer Document --}}
                    <div class="form-group col-md-6">
                        <label>Offer Document</label>
                        @if ($participated->offer_doc)
                            <div class="form-control">
                                <a href="{{ asset('uploads/documents/offer_docs/' . $participated->offer_doc) }}"
                                    target="_blank">Download File</a>
                            </div>
                        @else
                            <div class="form-control text-muted">No file uploaded</div>
                        @endif
                    </div>

                    {{-- Other Participants --}}
                    <div class="form-group col-md-12 mt-4">
                        <label><strong>Tender's Participants</strong></label>

                        @if ($currentTenderParticipants->isEmpty())
                            <p class="text-muted">No participants found for this tender.</p>
                        @else
                            @foreach ($currentTenderParticipants as $date => $participants)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Company</th>
                                            <th>Offered Price (৳)</th>
                                            <th class="text-center">Position</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($participants->sortBy('offered_price')->values() as $index => $participant)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $participant->company_name }}</td>
                                                <td>{{ number_format($participant->offered_price, 2) }}</td>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <strong>Participated Tender's Correspondence</strong>

                        <table class="table table-striped table-hover table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">SL</th>
                                    <th>Ref No</th>
                                    <th>Remarks</th>
                                    <th>Value</th>
                                    <th class="text-center" style="width: 140px;">Date</th>
                                    <th class="text-center">PDF</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($participateLetters as $key => $letter)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $letter->reference_no }}</td>
                                        <td>{{ $letter->remarks }}</td>
                                        <td>{{ $letter->value }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ asset('uploads/documents/tender_letters/participate/' . $letter->document) }}"
                                                target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-file-pdf"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No letters
                                            uploaded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="bgInfo" role="tabpanel" aria-labelledby="bg-tab">
            <div class="card">
                <div class="card-body row">
                    {{-- BG Number --}}
                    <div class="form-group col-md-6">
                        <label><strong>BG Number</strong></label>
                        <p class="form-control" readonly>{{ $participated->bg->bg_no ?? '-' }}</p>
                    </div>

                    {{-- Issue in Bank --}}
                    <div class="form-group col-md-6">
                        <label><strong>Issue in Bank</strong></label>
                        <p class="form-control" readonly>{{ $participated->bg->issue_in_bank ?? '-' }}</p>
                    </div>

                    {{-- Issue in Branch --}}
                    <div class="form-group col-md-6">
                        <label><strong>Issue in Branch</strong></label>
                        <p class="form-control" readonly>{{ $participated->bg->issue_in_branch ?? '-' }}</p>
                    </div>

                    {{-- BG Issue Date --}}
                    <div class="form-group col-md-6">
                        <label><strong>BG Issue Date</strong></label>
                        <div class="form-control" readonly>
                            {{ $participated->bg->issue_date ?? '-' }}
                        </div>
                    </div>

                    {{-- BG Expiry Date --}}
                    <div class="form-group col-md-6">
                        <label><strong>BG Expire Date</strong></label>
                        <div class="form-control" readonly>
                            {{ $participated->bg->expiry_date ?? '-' }}
                        </div>
                    </div>

                    {{-- BG Amount --}}
                    <div class="form-group col-md-6">
                        <label><strong>BG Amount</strong></label>
                        <p class="form-control" readonly>{{ $participated->bg->amount ?? '-' }}</p>
                    </div>

                    {{-- BG Attachment --}}
                    <div class="form-group col-md-6">
                        <label><strong>Attachment</strong></label><br>
                        @if (!empty($participated->bg->attachment))
                            <a href="{{ asset('uploads/documents/bg_attachments/' . $participated->bg->attachment) }}"
                                target="_blank">View Attachment</a>
                        @else
                            <p class="text-muted">No attachment uploaded</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
