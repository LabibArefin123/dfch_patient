@extends('adminlte::page')
@section('title', 'Edit Awarded Tender')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Edit Awarded Tenders</h1>
        <a href="{{ route('awarded_tenders.index') }}"
            class="btn btn-sm btn-warning d-flex align-items-center gap-1 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147
                                    4.146a.5.5 0 0 1-.708.708l-5-5a.5.5
                                    0 0 1 0-.708l5-5a.5.5 0 0
                                    1 .708.708L2.707 7.5H14.5A.5.5
                                    0 0 1 15 8z" />
            </svg>
            Go Back
        </a>
    </div>
@stop


@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="dateErrorBox"
        class="position-fixed bg-white border border-danger rounded shadow-lg px-4 py-3 text-center animate__animated"
        style="display: none; z-index: 9999; top: 50%; left: 50%; transform: translate(-50%, -50%); min-width: 320px;">
        <div class="d-flex justify-content-center mb-2">
            <i class="fas fa-exclamation-triangle text-danger fa-2x animate__animated animate__bounce"></i>
        </div>
        <strong class="text-danger fs-5">Oops!</strong>
        <p class="mb-0 text-dark">Date validation failed!</p>
    </div>
    <form action="{{ route('awarded_tenders.update', $awardedTender->id) }}" method="POST" enctype="multipart/form-data"
        id="awardedForm" data-confirm="edit">
        @csrf
        @method('PUT')

        <ul class="nav nav-tabs" id="employeeTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tender-tab" data-toggle="tab" href="#tender" role="tab">Tender Info</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pg-tab" data-bs-toggle="tab" href="#pgInfo" role="tab" aria-controls="pgInfo"
                    aria-selected="false">Performance Guarentee(PG) Info</a>
            </li>
        </ul>

        <div class="tab-content py-4 border border-top-0 rounded-bottom" id="employeeTabContent">
            <div class="tab-pane fade show active" id="tender" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>is Performance Guarantee (PG) ?</label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_pg" id="pg_no"
                                            value="0" {{ old('is_pg', $awardedTender->is_pg) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pg_no">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_pg" id="pg_yes"
                                            value="1" {{ old('is_pg', $awardedTender->is_pg) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pg_yes">Yes</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Tender Number --}}
                            <div class="form-group col-md-6">
                                <label for="tender_no">Tender Number <span class="text-danger">*</span></label>
                                <input type="text" id="tender_no" class="form-control"
                                    value="{{ $awardedTender->tenderParticipate->tender->tender_no }}" readonly>
                                {{-- Hidden field for tender_id submission --}}
                                <input type="hidden" name="tender_participate_id"
                                    value="{{ $awardedTender->tenderParticipate->id }}">
                            </div>

                            {{-- Tender Title (readonly, from related tender or old) --}}
                            <div class="form-group col-md-6">
                                <label for="title">Tender Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" readonly
                                    value="{{ old('title', $awardedTender->tenderParticipate->tender->title ?? '') }}">
                            </div>

                            {{-- Offer No --}}
                            <div class="form-group col-md-6">
                                <label for="offer_no">Offer No <span class="text-danger">*</span></label>
                                <input type="text" name="offer_no" id="offer_no" class="form-control"
                                    value="{{ old('offer_no', $awardedTender->tenderParticipate->offer_no ?? '') }}"
                                    readonly>
                                @error('offer_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Offer Date --}}
                            <div class="form-group col-md-6">
                                <label for="offer_date">Offer Date <span class="text-danger">*</span></label>
                                <input type="text" name="offer_date" id="offer_date" class="form-control"
                                    value="{{ old(
                                        'offer_date',
                                        $awardedTender->tenderParticipate->tender->submission_date
                                            ? \Carbon\Carbon::parse($awardedTender->tenderParticipate->tender->submission_date)->format('d F Y')
                                            : '',
                                    ) }}"
                                    readonly>

                                @error('offer_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Procuring Authority (readonly) --}}
                            <div class="form-group col-md-6">
                                <label for="procuring_authority" class="form-label">Procuring Authority <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="procuring_authority" id="procuring_authority"
                                    class="form-control" readonly
                                    value="{{ old('procuring_authority', $awardedTender->tenderParticipate->tender->procuring_authority ?? '') }}">
                                @error('procuring_authority')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- End User (readonly) --}}
                            <div class="form-group col-md-6">
                                <label for="end_user" class="form-label">End User <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="end_user" id="end_user" class="form-control" readonly
                                    value="{{ old('end_user', $awardedTender->tenderParticipate->tender->end_user ?? '') }}">
                                @error('end_user')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Financial Year --}}
                            <div class="form-group col-md-6">
                                <label for="financial_year_display">FY (Financial Year) <span
                                        class="text-danger">*</span></label>

                                <select id="financial_year_display" class="form-control" disabled>
                                    <option value="">Select Financial Year</option>
                                    @for ($year = 2026; $year >= 2005; $year--)
                                        @php $fy = $year . '-' . ($year + 1); @endphp
                                        <option value="{{ $fy }}"
                                            {{ old('financial_year', $awardedTender->tenderParticipate->tender->financial_year ?? '') == $fy ? 'selected' : '' }}>
                                            {{ $fy }}
                                        </option>
                                    @endfor
                                </select>

                                <input type="hidden" name="financial_year" id="financial_year"
                                    value="{{ old('financial_year', $awardedTender->tenderParticipate->tender->financial_year ?? '') }}">

                                @error('financial_year')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tender Type (readonly) --}}
                            <div class="form-group col-md-6">
                                <label for="tender_type">Tender Type <span class="text-danger">*</span></label>
                                <input type="text" name="tender_type" id="tender_type" class="form-control" readonly
                                    value="{{ old('tender_type', $awardedTender->tenderParticipate->tender->tender_type ?? '') }}">
                                @error('tender_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Publication Date --}}
                            <div class="form-group col-md-6">
                                <label>Publication Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" readonly
                                    value="{{ \Carbon\Carbon::parse($awardedTender->tenderParticipate->tender->publication_date)->format('d F Y') }}">
                            </div>

                            {{-- Submission Date --}}
                            <div class="form-group col-md-6">
                                <label>Submission Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" readonly
                                    value="{{ \Carbon\Carbon::parse($awardedTender->tenderParticipate->tender->submission_date)->format('d F Y') }}">
                            </div>


                            <div class="form-group col-md-6">
                                <label>is Bid Guarentee (BG)? </label>
                                <div class="mt-1">
                                    <p class="form-control" readonly>
                                        {{ $awardedTender->tenderParticipate->is_bg == 1 ? 'Yes' : 'No' }}
                                    </p>
                                    <input type="hidden" name="is_bg"
                                        value="{{ $awardedTender->tenderParticipate->is_bg }}">
                                </div>
                            </div>

                            <div class="w-100"></div>
                            {{-- If BG is required, show full BG details --}}

                            <div class="form-group col-md-6">
                                <label for="bg_no">BG Number</label>
                                <input type="text" class="form-control"
                                    value="{{ optional($awardedTender->tenderParticipate->bg)->bg_no ?? 'N/A' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="issue_in_bank">Issue in Bank</label>
                                <input type="text" class="form-control"
                                    value="{{ optional($awardedTender->tenderParticipate->bg)->issue_in_bank ?? 'N/A' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="issue_in_branch">Issue in Branch</label>
                                <input type="text" class="form-control"
                                    value="{{ optional($awardedTender->tenderParticipate->bg)->issue_in_branch ?? 'N/A' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="issue_date">BG Issue Date</label>
                                <input type="text" class="form-control"
                                    value="{{ optional($awardedTender->tenderParticipate->bg)->issue_date
                                        ? \Carbon\Carbon::parse($awardedTender->tenderParticipate->bg->issue_date)->format('d F Y')
                                        : 'N/A' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="expiry_date">BG Expiry Date</label>
                                <input type="text" class="form-control"
                                    value="{{ optional($awardedTender->tenderParticipate->bg)->expiry_date
                                        ? \Carbon\Carbon::parse($awardedTender->tenderParticipate->bg->expiry_date)->format('d F Y')
                                        : 'N/A' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="amount">BG Amount</label>
                                <input type="text" class="form-control"
                                    value="{{ optional($awardedTender->tenderParticipate->bg)->amount ?? 'N/A' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>BG Attachment</label><br>
                                @if (!empty(optional($awardedTender->tenderParticipate->bg)->attachment))
                                    <a href="{{ asset('uploads/documents/bg_attachments/' . $awardedTender->tenderParticipate->bg->attachment) }}"
                                        target="_blank">
                                        View Current Attachment
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>


                            {{-- Item Details Table --}}
                            <div class="form-group col-12">
                                <label class="form-label">Item Details <span class="text-danger">*</span></label>
                                <table class="table table-bordered" id="item-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">SL</th>
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
                                                <td class="sl">{{ $index + 1 }}</td>
                                                <td>
                                                    <input type="text" name="items[{{ $index }}][item]"
                                                        class="form-control" value="{{ $item['item'] ?? '' }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="items[{{ $index }}][deno]"
                                                        class="form-control" value="{{ $item['deno'] ?? '' }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][quantity]"
                                                        class="form-control" value="{{ $item['quantity'] ?? '' }}"
                                                        readonly>
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][unit_price]"
                                                        class="form-control" value="{{ $item['unit_price'] ?? '' }}"
                                                        readonly>
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][total_price]"
                                                        class="form-control"
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
                                            <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
                                            <td colspan="2">
                                                <input type="number" id="grand-total" class="form-control"
                                                    value="{{ number_format(old('grandTotal', $grandTotal ?? 0), 2, '.', '') }}"
                                                    readonly>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            {{-- Work Order No/NOA No --}}
                            <div class="form-group col-md-6">
                                <label for="workorder_no">Work Order No/NOA No <span class="text-danger">*</span></label>
                                <input type="text" name="workorder_no" id="workorder_no" class="form-control"
                                    value="{{ old('workorder_no', $awardedTender->workorder_no ?? '') }}">
                                @error('workorder_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Work Order/NOA Date --}}
                            <div class="form-group col-md-6">
                                <label for="workorder_date">Work Order/NOA Date <span class="text-danger">*</span></label>
                                <input type="date" name="workorder_date" id="workorder_date" class="form-control"
                                    value="{{ old('workorder_date', $awardedTender->workorder_date ? \Carbon\Carbon::parse($awardedTender->workorder_date)->format('Y-m-d') : '') }}">
                                @error('workorder_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="workorder_doc">Work Order/NOA Doc <span class="text-danger">*</span></label>
                                <input type="file" name="workorder_doc" class="form-control">

                                @if (!empty($awardedTender->workorder_doc))
                                    <small class="text-muted">
                                        Current: <a
                                            href="{{ asset('uploads/documents/workorder_docs/' . $awardedTender->workorder_doc) }}"
                                            target="_blank">View File</a>
                                    </small>
                                @endif

                                @error('workorder_doc')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label><strong>Tender's Participate Company</strong></label>

                                @if (!empty($companies) && count($companies))
                                    <table class="table table-bordered mt-2" id="company-table">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Company</th>
                                                <th class="text-end">Price</th>
                                                <th class="text-center align-middle" style="width: 20%">Position</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($companies as $index => $company)
                                                <tr>
                                                    <td class="sl">{{ $index + 1 }}</td>
                                                    <td>{{ $company['name'] }}</td>
                                                    <td class="text-end price">{{ $company['price'] }}</td>
                                                    <td class="position-text text-center align-middle"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-muted mt-2">No participating companies found.</p>
                                @endif
                            </div>


                            {{-- JavaScript for sorting and position --}}
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const positionWords = ["First", "Second", "Third", "Fourth", "Fifth", "Sixth", "Seventh", "Eighth",
                                        "Ninth", "Tenth"
                                    ];
                                    let table = document.getElementById("company-table").getElementsByTagName('tbody')[0];
                                    let rows = Array.from(table.querySelectorAll("tr"));

                                    // Parse and sort rows by price
                                    rows.sort((a, b) => {
                                        let priceA = parseFloat(a.querySelector(".price").textContent.replace(/[^0-9.]/g, ""));
                                        let priceB = parseFloat(b.querySelector(".price").textContent.replace(/[^0-9.]/g, ""));
                                        return priceA - priceB;
                                    });

                                    // Clear current rows
                                    table.innerHTML = "";

                                    // Re-append sorted rows with position
                                    rows.forEach((row, index) => {
                                        row.querySelector(".position-text").textContent = positionWords[index] || (index + 1) +
                                            "th";
                                        table.appendChild(row);
                                    });
                                });
                            </script>


                            {{-- Delivery Date --}}
                            <div class="form-group col-md-6">
                                <label for="awarded_date">Delivery Date <span class="text-danger">*</span></label>
                                <input type="date" name="awarded_date" id="awarded_date" class="form-control"
                                    value="{{ old('awarded_date', $awardedTender->awarded_date ? \Carbon\Carbon::parse($awardedTender->awarded_date)->format('Y-m-d') : '') }}">
                                @error('awarded_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Delivery Type --}}
                            <div class="form-group col-md-6">
                                <label for="delivery_type">Delivery Type <span class="text-danger">*</span></label>
                                <select name="delivery_type" id="delivery_type" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option value="1"
                                        {{ old('delivery_type', $awardedTender->delivery_type ?? '') == '1' ? 'selected' : '' }}>
                                        Single
                                    </option>
                                    <option value="partial"
                                        {{ old('delivery_type', $awardedTender->delivery_type ?? '') == 'partial' ? 'selected' : '' }}>
                                        Multiple</option>
                                </select>
                                @error('delivery_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Single Delivery Section --}}
                            <div id="first_delivery_section"
                                style="{{ old('delivery_type', $awardedTender->delivery_type ?? '') == '1' ? '' : 'display:none;' }}"
                                class="form-group col-md-12">
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
                                            <td>1</td>
                                            <td>
                                                <input type="text" name="deliveries[0][delivery_item]"
                                                    class="form-control"
                                                    value="{{ old('deliveries.0.delivery_item', $singleDelivery->delivery_item ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="date" name="deliveries[0][delivery_date]"
                                                    class="form-control"
                                                    value="{{ old('deliveries.0.delivery_date', $singleDelivery ? ($singleDelivery->delivery_date ? \Carbon\Carbon::parse($singleDelivery->delivery_date)->format('Y-m-d') : '') : '') }}">
                                            </td>
                                            <td>
                                                <select name="deliveries[0][warranty]" class="form-control">
                                                    <option value="">-- Select --</option>
                                                    @php
                                                        $warranties = [
                                                            '7 days',
                                                            '30 days',
                                                            '45 days',
                                                            '60 days',
                                                            '90 days',
                                                            '6 months',
                                                            '12 months',
                                                            '2 years',
                                                            '3 years',
                                                        ];
                                                        $selectedWarranty = old(
                                                            'deliveries.0.warranty',
                                                            $singleDelivery->warranty ?? '',
                                                        );
                                                    @endphp
                                                    @foreach ($warranties as $warranty)
                                                        <option value="{{ $warranty }}"
                                                            {{ $selectedWarranty == $warranty ? 'selected' : '' }}>
                                                            {{ $warranty }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Partial Delivery Section --}}
                            <div id="partial_delivery_section"
                                style="{{ old('delivery_type', $awardedTender->delivery_type ?? '') == 'partial' ? '' : 'display:none;' }}"
                                class="form-group col-md-12">

                                <h5 class="mt-4">Delivery Information (Multiple)</h5>

                                <table class="table table-bordered" id="partial_delivery_table">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Delivery Item</th>
                                            <th>Delivery Date</th>
                                            <th>Warranty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $oldPartialDeliveries = old(
                                                'deliveries',
                                                $partialDeliveries->toArray() ?? [],
                                            );
                                        @endphp

                                        @foreach ($oldPartialDeliveries as $index => $delivery)
                                            <tr>
                                                <td>{{ $index + 1 }}</td> {{-- SL Number --}}
                                                <td>
                                                    <input type="text"
                                                        name="deliveries[{{ $index }}][delivery_item]"
                                                        class="form-control"
                                                        value="{{ $delivery['delivery_item'] ?? '' }}">
                                                </td>
                                                <td>
                                                    <input type="date"
                                                        name="deliveries[{{ $index }}][delivery_date]"
                                                        class="form-control"
                                                        value="{{ isset($delivery['delivery_date']) && $delivery['delivery_date'] ? \Carbon\Carbon::parse($delivery['delivery_date'])->format('Y-m-d') : '' }}">
                                                </td>
                                                <td>
                                                    <select name="deliveries[{{ $index }}][warranty]"
                                                        class="form-control">
                                                        <option value="">-- Select --</option>
                                                        @foreach ($warranties as $warranty)
                                                            <option value="{{ $warranty }}"
                                                                {{ isset($delivery['warranty']) && $delivery['warranty'] == $warranty ? 'selected' : '' }}>
                                                                {{ $warranty }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4" style="text-align: right;">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="pgInfo" role="tabpanel" aria-labelledby="pg-tab">
                <div class="card">
                    <div class="card-body row">

                        {{-- BG No --}}
                        <div class="form-group col-md-6">
                            <label for="pg_no">PG Number <span class="text-danger">*</span></label>
                            <input type="text" name="pg_no" class="form-control"
                                value="{{ old('pg_no', $awardedTender->pg->pg_no ?? '') }}">
                            @error('pg_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Issue in Bank --}}
                        <div class="form-group col-md-6">
                            <label for="issue_in_bank">Issue in Bank <span class="text-danger">*</span></label>
                            <input type="text" name="issue_in_bank" class="form-control"
                                value="{{ old('issue_in_bank', $awardedTender->pg->issue_in_bank ?? '') }}">
                            @error('issue_in_bank')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Issue in Branch --}}
                        <div class="form-group col-md-6">
                            <label for="issue_in_branch">Issue in Branch <span class="text-danger">*</span></label>
                            <input type="text" name="issue_in_branch" class="form-control"
                                value="{{ old('issue_in_branch', $awardedTender->pg->issue_in_branch ?? '') }}">
                            @error('issue_in_branch')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Issue Date --}}
                        <div class="form-group col-md-6">
                            <label for="issue_date">PG Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="issue_date" class="form-control"
                                value="{{ old('issue_date', $awardedTender->pg->issue_date ?? '') }}">
                            @error('issue_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Expiry Date --}}
                        <div class="form-group col-md-6">
                            <label for="expiry_date">PG Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" name="expiry_date" class="form-control"
                                value="{{ old('expiry_date', $awardedTender->pg->expiry_date ?? '') }}">
                            @error('expiry_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Amount --}}
                        <div class="form-group col-md-6">
                            <label for="amount">PG Amount <span class="text-danger">*</span></label>
                            <input type="number" name="amount" step="0.01" class="form-control"
                                value="{{ old('amount', $awardedTender->pg->amount ?? '') }}">
                            @error('amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Attachment --}}
                        <div class="form-group col-md-6">
                            <label for="attachment">Attachment <span class="text-danger">*</span></label><br>
                            @if (!empty($awardedTender?->pg?->attachment))
                                <a href="{{ asset('uploads/documents/pg_attachments/' . $awardedTender->pg->attachment) }}"
                                    target="_blank">View
                                    Current</a><br>
                            @endif
                            <input type="file" name="attachment" class="form-control mt-2">
                            @error('attachment')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </form>

@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ========== PG Tab Toggle ==========
            const pgYes = document.getElementById('pg_yes');
            const pgNo = document.getElementById('pg_no');
            const pgTab = document.getElementById('pg-tab');
            const pgPane = document.getElementById('pgInfo');

            function togglePGTab() {
                if (pgYes?.checked) {
                    pgTab?.classList.remove('d-none');
                } else {
                    pgTab?.classList.add('d-none');
                    if (pgTab?.classList.contains('active')) {
                        document.getElementById('tender-tab')?.click();
                    }
                    pgPane?.classList.remove('show', 'active');
                }
            }

            pgYes?.addEventListener('change', togglePGTab);
            pgNo?.addEventListener('change', togglePGTab);
            togglePGTab(); // Run once on load


            // ========== Delivery Type Toggle ==========
            const deliveryTypeSelect = document.getElementById('delivery_type');
            const singleSection = document.getElementById('first_delivery_section');
            const partialSection = document.getElementById('partial_delivery_section');

            function toggleDeliverySections() {
                const type = deliveryTypeSelect?.value;
                if (singleSection) singleSection.style.display = (type === '1') ? 'block' : 'none';
                if (partialSection) partialSection.style.display = (type === 'partial') ? 'block' : 'none';
            }

            deliveryTypeSelect?.addEventListener('change', toggleDeliverySections);
            toggleDeliverySections(); // Run once on load


            // ========== Dynamic Partial Rows ==========
            let partialIndex = {{ count($partialDeliveries ?? []) }};

            window.addPartialDeliveryRow = function() {
                const tbody = document.querySelector('#partial_delivery_table tbody');
                if (!tbody) return;

                const row = document.createElement('tr');
                row.innerHTML = `
            <td><input type="text" name="partial_deliveries[${partialIndex}][delivery_item]" class="form-control"></td>
            <td><input type="date" name="partial_deliveries[${partialIndex}][delivery_date]" class="form-control"></td>
            <td>
                <select name="partial_deliveries[${partialIndex}][warranty]" class="form-control">
                    <option value="">-- Select --</option>
                    <option>7 days</option>
                    <option>30 days</option>
                    <option>45 days</option>
                    <option>60 days</option>
                    <option>90 days</option>
                    <option>6 months</option>
                    <option>12 months</option>
                    <option>2 years</option>
                    <option>3 years</option>
                </select>
            </td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
        `;
                tbody.appendChild(row);
                partialIndex++;
            };

            window.removeRow = function(btn) {
                btn.closest('tr')?.remove();
            };


            // ========== Date Validations ==========
            const form = document.getElementById('awardedForm');
            const workorderInput = document.getElementById('workorder_date');
            const awardedDateInput = document.getElementById('awarded_date');
            const submissionDateInput = document.getElementById('submission_date');
            const pgIssueInput = document.querySelector('input[name="issue_date"]');
            const pgExpiryInput = document.querySelector('input[name="expiry_date"]');
            const errorBox = document.getElementById('dateErrorBox');

            function showSweetError(message) {
                if (!errorBox) return;
                errorBox.querySelector('p').innerText = message;
                errorBox.style.display = 'block';
                errorBox.classList.remove('animate__fadeInDown', 'animate__fadeOutUp');
                void errorBox.offsetWidth;
                errorBox.classList.add('animate__animated', 'animate__fadeInDown');

                setTimeout(() => {
                    errorBox.classList.remove('animate__fadeInDown');
                    errorBox.classList.add('animate__fadeOutUp');
                    setTimeout(() => {
                        errorBox.style.display = 'none';
                        errorBox.classList.remove('animate__fadeOutUp');
                    }, 800);
                }, 4000);
            }

            form?.addEventListener('submit', function(e) {
                const workDate = new Date(workorderInput?.value);
                const awardDate = new Date(awardedDateInput?.value);
                const subDate = submissionDateInput?.value ? new Date(submissionDateInput.value) : null;

                const singleDeliveryInput = document.querySelector(
                    'input[name="deliveries[0][delivery_date]"]');
                if (awardDate && workDate && awardDate < workDate) {
                    e.preventDefault();
                    showSweetError("Awarded Date cannot be before Work Order Date!");
                    return;
                }

                if (subDate && singleDeliveryInput?.value) {
                    const deliveryDate = new Date(singleDeliveryInput.value);
                    if (deliveryDate < subDate) {
                        e.preventDefault();
                        showSweetError("Single Delivery Date cannot be before Submission Date!");
                        return;
                    }
                }

                if (subDate) {
                    const partialDates = document.querySelectorAll(
                        'input[name^="partial_deliveries"][name$="[delivery_date]"]');
                    for (let input of partialDates) {
                        if (input.value && new Date(input.value) < subDate) {
                            e.preventDefault();
                            showSweetError(
                                "One or more Partial Delivery Dates cannot be before Submission Date!");
                            return;
                        }
                    }
                }

                if (pgIssueInput?.value && pgExpiryInput?.value) {
                    const issueDate = new Date(pgIssueInput.value);
                    const expiryDate = new Date(pgExpiryInput.value);
                    if (expiryDate < issueDate) {
                        e.preventDefault();
                        showSweetError("PG Expiry Date cannot be before PG Issue Date!");
                        return;
                    }
                }
            });
        });
    </script>

    <!-- Required: Animate.css + Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

@endsection
