@extends('adminlte::page')
@section('title', 'Show Completed Tender')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h1 class="mb-0">View Completed Tender</h1>
    </div>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">

                {{-- Tender Number --}}
                <div class="form-group col-md-6">
                    <label><strong>Tender Number</strong></label>
                    <p class="form-control" readonly>{{ $tender->tender_no }}</p>
                </div>

                {{-- Tender Title --}}
                <div class="form-group col-md-6">
                    <label><strong>Tender Title</strong></label>
                    <p class="form-control" readonly>{{ $tender->title ?? '' }}</p>
                </div>

                {{-- Offer No --}}
                <div class="form-group col-md-6">
                    <label><strong>Offer No</strong></label>
                    <p class="form-control" readonly>{{ $participate->offer_no ?? '' }}</p>
                </div>

                {{-- Offer Date --}}
                <div class="form-group col-md-6">
                    <label><strong>Offer Date</strong></label>
                    <div class="form-control" readonly>
                        {{ \Carbon\Carbon::parse($participate->offer_date)->format('d F Y') }}
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Offer Document</strong></label><br>
                    @if (!empty($participate->offer_doc))
                        <a href="{{ asset('uploads/documents/offer_docs/' . $participate->offer_doc) }}" target="_blank"><i
                                class="fas fa-file-pdf"></i>View
                            Attachment</a>
                    @else
                        <p class="text-muted">No attachment uploaded</p>
                    @endif
                </div>

                <div class="w-100"></div>

                {{-- Procuring Authority --}}
                <div class="form-group col-md-6">
                    <label><strong>Procuring Authority</strong></label>
                    <p class="form-control" readonly>{{ $tender->procuring_authority ?? '' }}</p>
                </div>

                {{-- End User --}}
                <div class="form-group col-md-6">
                    <label><strong>End User</strong></label>
                    <p class="form-control" readonly>{{ $tender->end_user ?? '' }}</p>
                </div>

                {{-- Financial Year --}}
                <div class="form-group col-md-6">
                    <label><strong>Financial Year (FY)</strong></label>
                    <p class="form-control" readonly>{{ $tender->financial_year ?? '' }}</p>
                </div>

                {{-- Tender Type --}}
                <div class="form-group col-md-6">
                    <label><strong>Tender Type</strong></label>
                    <p class="form-control" readonly>{{ $tender->tender_type ?? '' }}</p>
                </div>

                {{-- Item Details Table --}}
                <div class="form-group col-12">
                    <label><strong>Item Details</strong></label>
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Deno</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $itemsToShow = $items ?? [
                                    [
                                        'item' => '',
                                        'deno' => '',
                                        'quantity' => '',
                                        'unit_price' => '',
                                        'total_price' => '',
                                    ],
                                ];
                            @endphp

                            @foreach ($itemsToShow as $item)
                                <tr>
                                    <td>{{ $item['item'] ?? '' }}</td>
                                    <td>{{ $item['deno'] ?? '' }}</td>
                                    <td>{{ $item['quantity'] ?? '' }}</td>
                                    <td>{{ $item['unit_price'] ?? '' }}</td>
                                    <td>{{ number_format(((float) ($item['quantity'] ?? 0)) * ((float) ($item['unit_price'] ?? 0)), 2) }}
                                    </td>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                                <td>{{ number_format($grandTotal ?? 0, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Publication Date</strong></label>
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


                {{-- Work Order No/NOA No --}}
                <div class="form-group col-md-6">
                    <label><strong>Work Order No/NOA No</strong></label>
                    <p class="form-control" readonly>{{ $completedTender->workorder_no ?? '' }}</p>
                </div>

                {{-- Work Order/NOA Date --}}
                <div class="form-group col-md-6">
                    <label><strong>Work Order/NOA Date</strong></label>
                    <div class="form-control" readonly>
                        {{ \Carbon\Carbon::parse($completedTender->workorder_date)->format('d F Y') }}
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Work Order/NOA Doc</strong></label><br>
                    @if (!empty($completedTender->workorder_doc))
                        <a href="{{ asset('uploads/documents/workorder_docs/' . $completedTender->workorder_doc) }}"
                            target="_blank"><i class="fas fa-file-pdf"></i>View
                            Attachment</a>
                    @else
                        <p class="text-muted">No attachment uploaded</p>
                    @endif
                </div>

                <div class="form-group col-12"><label
                        class="form-label fw-bold text-uppercase text-primary border-bottom border-primary pb-1 d-inline-block">Participated
                        Tender
                        Section</label></div>
                {{-- Tender Participants --}}
                <div class="form-group col-md-12">
                    <label><strong>Tender's Participants</strong></label>

                    @php
                        $participantsByDate = collect($currentTenderParticipants);
                    @endphp

                    @if ($participantsByDate->isEmpty())
                        <p class="text-muted">No participants found for this tender.</p>
                    @else
                        @foreach ($participantsByDate as $date => $participants)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">SL</th>
                                        <th>Company</th>
                                        <th>Offered Price</th>
                                        <th>Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($participants as $index => $participant)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $participant['company_name'] }}</td>
                                            <td>{{ number_format($participant['offered_price'], 2) }}</td>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    @endif
                </div>

                <div class="form-group col-md-12">
                    <strong>Participated Correspondence</strong>

                    <table class="table table-striped table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">SL</th>
                                <th>Ref No</th>
                                <th>Remarks</th>
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

                <div class="form-group col-12"><label
                        class="form-label fw-bold text-uppercase text-primary border-bottom border-primary pb-1 d-inline-block">Bid
                        Guarentee (BG)

                        Section</label></div>
                {{-- BG Number --}}

                <div class="form-group col-md-6">
                    <label><strong>BG Number</strong></label>
                    <p class="form-control" readonly>
                        {{ $participate->bg?->bg_no ?? '' }}
                    </p>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Issue in Bank</strong></label>
                    <p class="form-control" readonly>
                        {{ $participate->bg?->issue_in_bank ?? '' }}
                    </p>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Issue in Branch</strong></label>
                    <p class="form-control" readonly>
                        {{ $participate->bg?->issue_in_branch ?? '' }}
                    </p>
                </div>


                <div class="form-group col-md-6">
                    <label><strong>BG Issue Date</strong></label>
                    <div class="form-control" readonly>
                        @if (!empty($participate->bg->issue_date))
                            {{ \Carbon\Carbon::parse($participate->bg->issue_date)->format('d F Y') }}
                        @else
                            <span class="text-danger">N/A</span>
                        @endif
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>BG Expiry Date</strong></label>
                    <div class="form-control" readonly>
                        @if (!empty($participate->bg->expiry_date))
                            {{ \Carbon\Carbon::parse($participate->bg->expiry_date)->format('d F Y') }}
                        @else
                            <span class="text-danger">N/A</span>
                        @endif
                    </div>
                </div>


                {{-- BG Amount --}}
                <div class="form-group col-md-6">
                    <label><strong>BG Amount</strong></label>
                    <p class="form-control" readonly>
                        {{ $participate->bg->amount ?? '' }}
                    @empty($participate->bg->amount)
                        <span class="text-danger">N/A</span>
                    @endempty
                </p>
            </div>


            <div class="form-group col-md-6">
                <label><strong>BG Attachment</strong></label><br>
                @if (!empty($participate->bg->attachment))
                    <a href="{{ asset('uploads/documents/bg_attachments/' . $participate->bg->attachment) }}"
                        target="_blank">View
                        Attachment</a>
                @else
                    <p class="text-muted">No attachment uploaded</p>
                @endif
            </div>
        </div>

        <div class="form-group col-12"><label
                class="form-label fw-bold text-uppercase text-primary border-bottom border-primary pb-1 d-inline-block">Awarded
                Tender
                Section</label></div>

        {{-- Delivery Date --}}
        <div class="row">

            <div class="form-group col-md-6">
                <label><strong>Delivery Date</strong></label>
                <div class="form-control" readonly>
                    {{ \Carbon\Carbon::parse($completedTender->awarded_date)->format('d F Y') }}
                </div>
            </div>

            {{-- Delivery Type --}}
            <div class="form-group col-md-6">
                <label><strong>Delivery Type</strong></label>
                <p class="form-control" readonly>
                    @if (($completedTender->delivery_type ?? '') == '1')
                        Single
                    @elseif (($completedTender->delivery_type ?? '') == 'partial')
                        Multiple
                    @else
                        N/A
                    @endif
                </p>
            </div>
        </div>

        {{-- Single Delivery Section --}}
        @if (($completedTender->delivery_type ?? '') == '1')
            <div class="form-group col-md-12">
                <h5 class="mt-4">Delivery Information (Single)</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Delivery Item</th>
                            <th>Delivery Date</th>
                            <th>Warranty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $singleDelivery->delivery_item ?? '' }}</td>
                            <td>{{ $singleDelivery && $singleDelivery->delivery_date ? \Carbon\Carbon::parse($singleDelivery->delivery_date)->format('d F Y') : '' }}
                            </td>
                            <td>{{ $singleDelivery->warranty ?? '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        {{-- Partial Delivery Section --}}
        @if (($completedTender->delivery_type ?? '') == 'partial')
            <div class="form-group col-md-12">
                <h5 class="mt-4">Delivery Information (Multiple)</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Delivery Item</th>
                            <th>Delivery Date</th>
                            <th>Warranty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($partialDeliveries as $delivery)
                            <tr>
                                <td>{{ $delivery->delivery_item ?? '' }}</td>
                                <td>{{ $delivery->delivery_date ? \Carbon\Carbon::parse($delivery->delivery_date)->format('d F Y') : '' }}
                                </td>
                                <td>{{ $delivery->warranty ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="w-100"></div>

        <div class="form-group col-md-12">
            <strong>Awarded Correspondence</strong>

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
                    @forelse ($awardedLetters as $key => $letter)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $letter->reference_no }}</td>
                            <td>{{ $letter->remarks }}</td>
                            <td>{{ $letter->value }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ asset('uploads/documents/tender_letters/awarded/' . $letter->document) }}"
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

        <div class="form-group col-12"><label
                class="form-label fw-bold text-uppercase text-primary border-bottom border-primary pb-1 d-inline-block">Progress
                Tender
                Section</label></div>

        <div class="form-group col-md-12">
            <strong>Progress Tender Correspondence</strong>

            <table class="table table-striped table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">SL</th>
                        <th>Ref No</th>
                        <th>Remarks</th>
                        <th class="text-center" style="width: 140px;">Date</th>
                        <th class="text-center">PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($progressLetters as $key => $letter)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $letter->reference_no }}</td>
                            <td>{{ $letter->remarks }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ asset('uploads/documents/tender_letters/progress/' . $letter->document) }}"
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

        <div class="row">
            <div class="form-group col-12">
                <label
                    class="form-label fw-bold text-uppercase text-primary border-bottom border-primary pb-1 d-inline-block">
                    Performance Guarantee (PG) Section
                </label>
            </div>

            {{-- PG Number --}}
            <div class="form-group col-md-6">
                <label><strong>PG Number</strong></label>
                <p class="form-control" readonly>
                    {{ $pg->pg_no ?: 'N/A' }}
                </p>
            </div>

            <div class="form-group col-md-6">
                <label><strong>Issue in Bank</strong></label>
                <p class="form-control" readonly>
                    {{ $pg->issue_in_bank ?: 'N/A' }}
                </p>
            </div>

            <div class="form-group col-md-6">
                <label><strong>Issue in Branch</strong></label>
                <p class="form-control" readonly>
                    {{ $pg->issue_in_branch ?: 'N/A' }}
                </p>
            </div>

            <div class="form-group col-md-6">
                <label><strong>PG Issue Date</strong></label>
                <p class="form-control" readonly>
                    {{ $pg->issue_date ?: 'N/A' }}
                </p>
            </div>

            <div class="form-group col-md-6">
                <label><strong>PG Expiry Date</strong></label>
                <p class="form-control" readonly>
                    {{ $pg->expiry_date ?: 'N/A' }}
                </p>
            </div>

            <div class="form-group col-md-6">
                <label><strong>PG Amount</strong></label>
                <p class="form-control" readonly>
                    {{ $pg->amount ? number_format($pg->amount, 2) : 'N/A' }}
                </p>
            </div>

            <div class="form-group col-md-6">
                <label><strong>PG Attachment</strong></label><br>
                @if (!empty($pg->attachment))
                    <a href="{{ asset('uploads/documents/pg_attachments/' . $pg->attachment) }}" target="_blank">
                        View Attachment
                    </a>
                @else
                    <p class="text-muted">No attachment uploaded</p>
                @endif
            </div>
        </div>

        <div class="w-100"></div>

        <div class="form-group col-md-6">
            <label>Is Delivered ?</label>
            <input type="text" readonly class="form-control"
                value="{{ $completedTender->tenderProgress->is_delivered == 1 ? 'Yes' : 'No' }}">
            <input type="hidden" name="is_delivered" value="{{ $completedTender->tenderProgress->is_delivered }}">
        </div>

        <div class="w-100"></div>
        <div class="row">
            <div class="form-group col-md-6">
                <label><strong>Challan No</strong></label>
                <p class="form-control" readonly>{{ $completedTender->tenderProgress->challan_no ?? '-' }}</p>
            </div>

            {{-- Challan Date --}}
            <div class="form-group col-md-6">
                <label><strong>Challan Date</strong></label>
                <div class="form-control" readonly>
                    {{-- {{ $completedTender->tenderProgress?->challan_date }} --}}
                    {{ \Carbon\Carbon::parse($completedTender->tenderProgress?->challan_date)->format('d F Y') }}

                </div>
            </div>

            {{-- Challan Document --}}
            <div class="form-group col-md-6">
                <label><strong>Challan Document</strong></label><br>
                @if (!empty($completedTender->tenderProgress?->challan_doc))
                    <a href="{{ asset('uploads/documents/challan_docs/' . $completedTender->tenderProgress->challan_doc) }}"
                        target="_blank">
                        <i class="fas fa-file-pdf"></i> View Attachment
                    </a>
                @else
                    <p class="text-muted">No attachment uploaded</p>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Is Inspection Completed ?</label>
                <input type="text" readonly class="form-control"
                    value="{{ $completedTender->tenderProgress->is_inspection_completed == 1 ? 'Yes' : 'No' }}">
                <input type="hidden" name="is_inspection_completed"
                    value="{{ $completedTender->tenderProgress->is_inspection_completed }}">
            </div>

            {{-- Inspection Complete Date --}}
            <div class="form-group col-md-6">
                <label><strong>Inspection Complete Date</strong></label>
                <div class="form-control" readonly>
                    {{-- {{ $completedTender->tenderProgress?->inspection_complete_date }} --}}
                    {{ \Carbon\Carbon::parse($completedTender->tenderProgress?->inspection_complete_date)->format('d F Y') }}

                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Is Inspection Accepted ?</label>
                <input type="text" readonly class="form-control"
                    value="{{ $completedTender->tenderProgress->is_inspection_accepted == 1 ? 'Yes' : 'No' }}">
                <input type="hidden" name="is_inspection_accepted"
                    value="{{ $completedTender->tenderProgress->is_inspection_accepted }}">
            </div>

            {{-- Inspection Complete Date --}}
            <div class="form-group col-md-6">
                <label><strong>Inspection Accept Date</strong></label>
                <div class="form-control" readonly>
                    {{-- {{ $completedTender->tenderProgress?->inspection_accept_date }} --}}
                    {{ \Carbon\Carbon::parse($completedTender->tenderProgress?->inspection_accept_date)->format('d F Y') }}
                </div>
            </div>
        </div>

        <div class="row">

            <div class="form-group col-md-6">
                <label>Is Bill Submitted?</label>
                <input type="text" readonly class="form-control"
                    value="{{ $completedTender->tenderProgress->is_bill_submitted == 1 ? 'Yes' : 'No' }}">
                <input type="hidden" name="is_bill_submitted"
                    value="{{ $completedTender->tenderProgress->is_bill_submitted }}">
            </div>
        </div>

        <div class="w-100"></div>

        <div class="row">
            <div class="form-group col-md-6">
                <label><strong>Bill No</strong></label>
                <p class="form-control" readonly>{{ $completedTender->tenderProgress->bill_no ?? '-' }}</p>
            </div>

            {{-- Challan Date --}}
            <div class="form-group col-md-6">
                <label><strong>Bill Date</strong></label>
                <div class="form-control" readonly>
                    {{-- {{ $completedTender->tenderProgress?->challan_date }} --}}
                    {{ \Carbon\Carbon::parse($completedTender->tenderProgress?->bill_submit_date)->format('d F Y') }}

                </div>
            </div>

            {{-- Challan Document --}}
            <div class="form-group col-md-6">
                <label><strong>Bill Document</strong></label><br>
                @if (!empty($completedTender->tenderProgress?->challan_doc))
                    <a href="{{ asset('uploads/documents/bill_docs/' . $completedTender->tenderProgress->bill_doc) }}"
                        target="_blank">
                        <i class="fas fa-file-pdf"></i> View Attachment
                    </a>
                @else
                    <p class="text-muted">No attachment uploaded</p>
                @endif
            </div>
        </div>
        <div class="row">

            <div class="form-group col-md-6">
                <label>Is Bill Received?</label>
                <input type="text" readonly class="form-control"
                    value="{{ $completedTender->tenderProgress->is_bill_received == 1 ? 'Yes' : 'No' }}">
                <input type="hidden" name="is_bill_received"
                    value="{{ $completedTender->tenderProgress->is_bill_received }}">
            </div>
        </div>

        <div class="w-100"></div>
        <div class="row">
            <div class="form-group col-md-6">
                <label><strong>Bill Cheque No</strong></label>
                <p class="form-control" readonly>{{ $completedTender->tenderProgress->bill_cheque_no ?? '-' }}
                </p>
            </div>

            {{-- Challan Date --}}
            <div class="form-group col-md-6">
                <label><strong>Bill Receive Date</strong></label>
                <div class="form-control" readonly>
                    {{-- {{ $completedTender->tenderProgress?->challan_date }} --}}
                    {{ \Carbon\Carbon::parse($completedTender->tenderProgress?->bill_receive_date)->format('d F Y') }}

                </div>
            </div>

            <div class="form-group col-md-6">
                <label><strong>Bill Amount</strong></label>
                <p class="form-control" readonly>{{ $completedTender->tenderProgress->bill_amount ?? '-' }}
                </p>
            </div>

            <div class="form-group col-md-6">
                <label><strong>Bill Bank Name</strong></label>
                <p class="form-control" readonly>{{ $completedTender->tenderProgress->bill_bank_name ?? '-' }}
                </p>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Is Warranty Completed ?</label>
                <input type="text" readonly class="form-control"
                    value="{{ $completedTender->is_warranty_complete == 1 ? 'Yes' : 'No' }}">
                <input type="hidden" name="is_warranty_complete"
                    value="{{ $completedTender->is_warranty_complete }}">
            </div>

            {{-- Inspection Complete Date --}}
            <div class="form-group col-md-6">
                <label><strong>Warranty Date</strong></label>
                <div class="form-control" readonly>
                    {{-- {{ $completedTender->warranty_complete_date }} --}}
                    {{ \Carbon\Carbon::parse($completedTender->warranty_complete_date)->format('d F Y') }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Is Service Warranty?</label>
                <input type="text" readonly class="form-control"
                    value="{{ $completedTender->is_service_warranty == 1 ? 'Yes' : 'No' }}">
                <input type="hidden" name="is_service_warranty"
                    value="{{ $completedTender->is_service_warranty }}">
            </div>

            {{-- Inspection Complete Date --}}
            <div class="form-group col-md-6">
                <label><strong>Service Warranty Duration</strong></label>
                <div class="form-control" readonly>
                    {{-- {{ $completedTender->service_warranty_duration }} --}}
                    {{ \Carbon\Carbon::parse($completedTender->service_warranty_duration)->format('d F Y') }}
                </div>
            </div>
        </div>


        <div class="form-group col-md-12">
            <strong>Completed Correspondence</strong>

            <table class="table table-striped table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">SL</th>
                        <th>Ref No</th>
                        <th>Remarks</th>
                        <th class="text-center" style="width: 140px;">Date</th>
                        <th class="text-center">PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($completedLetters as $key => $letter)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $letter->reference_no }}</td>
                            <td>{{ $letter->remarks }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ asset('uploads/documents/tender_letters/completed/' . $letter->document) }}"
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

<div class="card mt-4">
    <div class="card-body" style="height:50px;">
        <!-- Intentionally left blank -->
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
