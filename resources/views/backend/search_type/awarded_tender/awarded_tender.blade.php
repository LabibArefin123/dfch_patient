<div class="form-group col-md-6">
    <label>Tender No</label>
    <input type="text" readonly class="form-control" value="{{ $data->tenderParticipate->tender->tender_no }}">
</div>

<div class="form-group col-md-6">
    <label>Tender Title</label>
    <input type="text" readonly class="form-control" value="{{ $data->tenderParticipate->tender->title }}">
</div>

<div class="form-group col-md-6">
    <label>Procuring Authority</label>
    <input type="text" readonly class="form-control"
        value="{{ $data->tenderParticipate->tender->procuring_authority }}">
</div>

<div class="form-group col-md-6">
    <label>End User</label>
    <input type="text" readonly class="form-control" value="{{ $data->tenderParticipate->tender->end_user }}">
</div>

<div class="form-group col-md-6">
    <label>Publication Date</label>
    <p class="form-control-plaintext" readonly>
        {{ $data->tenderParticipate?->tender?->publication_date
            ? \Carbon\Carbon::parse($data->tenderParticipate->tender->publication_date)->format('d M Y')
            : '--:--' }}
    </p>
</div>

<div class="form-group col-md-6">
    <label>Submission Date</label>
    <p class="form-control-plaintext" readonly>
        {{ $data->tenderParticipate?->tender?->submission_date
            ? \Carbon\Carbon::parse($data->tenderParticipate->tender->submission_date)->format('d M Y')
            : '--:--' }}
    </p>
</div>

<div class="form-group col-md-6">
    <label>Financial Year</label>
    <input type="text" readonly class="form-control" value="{{ $data->tenderParticipate->tender->financial_year }}">
</div>

<div class="form-group col-md-6">
    <label><strong>Tender Specification Files</strong></label><br>
    @if (!empty($data->tenderParticipate->tender->spec_file))
        <a class="form-control"
            href="{{ asset('uploads/documents/spec_files/' . $data->tenderParticipate->tender->spec_file) }}"
            target="_blank">View
            Attachment</a>
    @else
        <p class="text-muted">No attachment uploaded</p>
    @endif
</div>

<div class="form-group col-md-6">
    <label><strong>Tender Notice File</strong></label><br>
    @if (!empty($data->tenderParticipate->tender->notice_file))
        <a class="form-control"
            href="{{ asset('uploads/documents/notice_files/' . $data->tenderParticipate->tender->notice_file) }}"
            target="_blank">View
            Attachment</a>
    @else
        <p class="text-muted">No attachment uploaded</p>
    @endif
</div>

@php
    $statusLabel = match ($data->tenderParticipate->tender->status) {
        0 => 'Pending',
        1 => 'Not Participated',
        2 => 'Participated',
        3 => 'Awarded',
        4 => 'Completed',
        default => 'Unknown',
    };

    $now = now();
    $submissionDateTime = \Carbon\Carbon::parse(
        $data->tenderParticipate->tender->submission_date . ' ' . $data->tenderParticipate->tender->submission_time,
    );

    if ($data->tenderParticipate->tender->status === 0 && $submissionDateTime->lt($now)) {
        $statusLabel = 'Expired';
    }
@endphp
<div class="form-group col-md-6">
    <label>Tender Status</label>
    <input type="text" readonly class="form-control" value="{{ $statusLabel }}">
</div>

<div class="form-group col-12">
    <label class="form-label">Item Details <span class="text-danger">*</span></label>
    <table class="table table-bordered" id="item-table">
        <thead class="table-light">
            <tr>
                <th>SL</th>
                <th width="25%">Item</th>
                <th width="15%">Deno</th>
                <th width="10%">Qty</th>
                <th width="15%">Unit Price</th>
                <th width="15%">Total Price</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody id="item-tbody">
            @php
                // Use old input if exists, else items from DB, else show one blank
                $oldItems = old(
                    'items',
                    $items ?? [
                        [
                            'item' => '',
                            'deno' => '',
                            'quantity' => '',
                            'unit_price' => '',
                            'total_price' => '',
                        ],
                    ],
                );
            @endphp

            @foreach ($items as $index => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <input type="text" name="items[{{ $index }}][item]" class="form-control"
                            value="{{ $item['item'] ?? '' }}" readonly>
                    </td>
                    <td>
                        <input type="text" name="items[{{ $index }}][deno]" class="form-control"
                            value="{{ $item['deno'] ?? '' }}" readonly>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $index }}][quantity]" class="form-control"
                            value="{{ $item['quantity'] ?? '' }}" readonly>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $index }}][unit_price]" class="form-control"
                            value="{{ $item['unit_price'] ?? '' }}" readonly>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $index }}][total_price]" class="form-control"
                            value="{{ number_format(($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0), 2, '.', '') }}"
                            readonly>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-secondary btn-sm" disabled>
                            <i class="fas fa-ban"></i>
                        </button>
                    </td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                <td colspan="2">
                    <input type="number" id="grand-total" class="form-control"
                        value="{{ number_format(old('grandTotal', $grandTotal ?? 0), 2, '.', '') }}" readonly>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="form-group col-md-6">
    <label>Offer No</label>
    <input type="text" readonly class="form-control" value="{{ $data->tenderParticipate->offer_no }}">
</div>

<div class="form-group col-md-6">
    <label>Offer Date</label>
    <input type="text" readonly class="form-control"
        value="{{ formatDateSafe($data->tenderParticipate->offer_date) }}">
</div>

<div class="form-group col-md-6">
    <label>Offer Validity</label>
    <input type="text" readonly class="form-control"
        value="{{ formatDateSafe($data->tenderParticipate->offer_validity) }}">
</div>

<div class="form-group col-md-6">
    <label><strong>Offer Document</strong></label><br>
    @if (!empty($data->tenderParticipate->offer_doc))
        <a class="form-control"
            href="{{ asset('uploads/documents/offer_docs/' . $data->tenderParticipate->offer_doc) }}"
            target="_blank">View
            Attachment</a>
    @else
        <p class="text-muted">No attachment uploaded</p>
    @endif
</div>

<div class="form-group col-md-12 mt-3">
    <label><strong>Tender's Participants</strong></label>
    @if (!empty($currentTenderParticipants) && count($currentTenderParticipants))
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Company</th>
                    <th>Offered Price</th>
                    <th class="text-center">Position</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($currentTenderParticipants as $index => $participant)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $participant->company_name }}</td>
                        <td>{{ number_format($participant->offered_price, 2) }}</td>
                        <td class="text-center">{{ $index + 1 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">No participants found for this tender.</p>
    @endif
</div>

<div class="form-group col-md-12">
    <strong>Participated Tender Correspondence</strong>

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

<div class="form-group col-md-6">
    <label>Is Bid Performance (BG)?</label>
    <input type="text" readonly class="form-control"
        value="{{ $data->tenderParticipate->is_bg == 1 ? 'Yes' : 'No' }}">
    <input type="hidden" name="is_bg" value="{{ $data->tenderParticipate->is_bg }}">
</div>

<div class="w-100"></div>

@if ($data->tenderParticipate->is_bg == 1)
    <div class="form-group col-md-6">
        <label for="bg_no">BG Number</label>
        <input type="text" class="form-control"
            value="{{ optional($data->tenderParticipate->bg)->bg_no ?? '-' }}" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="issue_in_bank">Issue in Bank</label>
        <input type="text" class="form-control"
            value="{{ optional($data->tenderParticipate->bg)->issue_in_bank ?? '-' }}" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="issue_in_branch">Issue in Branch</label>
        <input type="text" class="form-control"
            value="{{ optional($data->tenderParticipate->bg)->issue_in_branch ?? '-' }}" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="issue_date">BG Issue Date</label>
        <input type="date" class="form-control"
            value="{{ optional($data->tenderParticipate->bg)->issue_date ?? '' }}" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="expiry_date">BG Expiry Date</label>
        <input type="date" class="form-control"
            value="{{ optional($data->tenderParticipate->bg)->expiry_date ?? '' }}" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="amount">BG Amount</label>
        <input type="text" class="form-control"
            value="{{ optional($data->tenderParticipate->bg)->amount ?? '' }}" readonly>
    </div>
    <div class="form-group col-md-6">
        <label>BG Attachment</label><br>
        @if (!empty(optional($data->tenderParticipate->bg)->attachment))
            <a class="form-control"
                {{ asset('uploads/documents/bg_attachments/' . $data->tenderParticipate->bg->attachment) }}"
                target="_blank">
                View Current Attachment
            </a>
        @else
            <span class="text-muted">No attachment available</span>
        @endif
    </div>
@endif

<div class="w-100"></div>

<div class="form-group col-md-6">
    <label>Workorder No/ NOA No</label>
    <input type="text" readonly class="form-control" value="{{ $data->workorder_no }}">
</div>

<div class="form-group col-md-6">
    <label>Workorder Date/ NOA Date</label>
    <input type="text" readonly class="form-control" value="{{ formatDateSafe($data->workorder_date) }}">
</div>

<div class="form-group col-md-6">
    <label>Awarded Date</label>
    <input type="text" readonly class="form-control" value="{{ formatDateSafe($data->awarded_date) }}">
</div>

{{-- Delivery Date --}}
<div class="form-group col-md-6">
    <label><strong>Delivery Date</strong></label>
    <input type="text" readonly class="form-control"
        value="{{ $data->awarded_date ? \Carbon\Carbon::parse($data->awarded_date)->format('Y-m-d') : 'N/A' }}">
</div>

{{-- Delivery Type --}}
<div class="form-group col-md-6">
    <label><strong>Delivery Type</strong></label>
    <input type="text" readonly class="form-control"
        value="@switch($data->delivery_type ?? '')
                                            @case('1') Single @break
                                            @case('partial') Multiple @break
                                            @default N/A
                                        @endswitch">
</div>

{{-- Single Delivery Section --}}
@if (($data->delivery_type ?? '') == '1' && isset($singleDelivery))
    <div class="form-group col-md-12">
        <h5 class="mt-4">Delivery Information (Single)</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Delivery Item</th>
                    <th>Delivery Date</th>
                    <th>Warranty</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1 x</td>
                    <td>{{ $singleDelivery->delivery_item ?? 'N/A' }}</td>
                    <td>{{ $singleDelivery->delivery_date ? \Carbon\Carbon::parse($singleDelivery->delivery_date)->format('Y-m-d') : 'N/A' }}
                    </td>
                    <td>{{ ucfirst($singleDelivery->warranty ?? 'N/A') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endif

{{-- Partial Delivery Section --}}
@if (($data->delivery_type ?? '') === 'partial' && isset($partialDeliveries) && count($partialDeliveries))
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
                        <td>{{ $delivery->delivery_item ?? 'N/A' }}</td>
                        <td>{{ $delivery->delivery_date ? \Carbon\Carbon::parse($delivery->delivery_date)->format('Y-m-d') : 'N/A' }}
                        </td>
                        <td>{{ ucfirst($delivery->warranty ?? 'N/A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif


<!-- Break the row -->
<div class="w-100"></div>

<div class="form-group col-md-6">
    <label>Is Performance Guarantee (BG)?</label>
    <input type="text" readonly class="form-control" value="{{ $data->is_pg == 1 ? 'Yes' : 'No' }}">
    <input type="hidden" name="is_pg" value="{{ $data->is_pg }}">
</div>

<div class="w-100"></div>

@if ($data->is_pg == 1)
    <div class="form-group col-md-6">
        <label for="bg_no">PG Number</label>
        <input type="text" class="form-control" value="{{ optional($data->pg)->pg_no ?? '-' }}" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="issue_in_bank">Issue in Bank</label>
        <input type="text" class="form-control" value="{{ optional($data->pg)->issue_in_bank ?? '-' }}" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="issue_in_branch">Issue in Branch</label>
        <input type="text" class="form-control" value="{{ optional($data->pg)->issue_in_branch ?? '-' }}"
            readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="issue_date">PG Issue Date</label>
        <input type="date" class="form-control" value="{{ optional($data->pg)->issue_date ?? '' }}" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="expiry_date">PG Expiry Date</label>
        <input type="date" class="form-control" value="{{ optional($data->pg)->expiry_date ?? '' }}" readonly>
    </div>
    <div class="form-group col-md-6">
        <label for="amount">PG Amount</label>
        <input type="text" class="form-control" value="{{ optional($data->pg)->amount ?? '' }}" readonly>
    </div>
    <div class="form-group col-md-6">
        <label>PG Attachment</label><br>
        @if (!empty(optional($data->pg)->attachment))
            <a class="form-control" href="{{ asset('uploads/documents/pg_attachments/' . $data->pg->attachment) }}"
                target="_blank">
                View Current Attachment
            </a>
        @else
            <span class="text-muted">No attachment available</span>
        @endif
    </div>
@endif

<div class="form-group col-md-12">
    <strong>Awarded Tender Correspondence</strong>

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

<div class="form-group col-md-12">
    <strong>Progress Tender Correspondence</strong>

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
            @forelse ($progressLetters as $key => $letter)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $letter->reference_no }}</td>
                    <td>{{ $letter->remarks }}</td>
                    <td>{{ $letter->value }}</td>
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
