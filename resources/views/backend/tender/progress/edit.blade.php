@extends('adminlte::page')
@section('title', 'Edit Progress Tender')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h1 class="mb-0">Edit Progress Tender</h1>
        <div class="d-flex align-items-center gap-2">
            <span id="work-process" class="badge bg-success py-2 px-3" style="font-size: 1rem;">
                Work Progress: 0%
            </span>

            <a href="{{ route('tender_progress.index') }}"
                class="btn btn-sm btn-warning d-flex align-items-center gap-1 back-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147
                        4.146a.5.5 0 0 1-.708.708l-5-5a.5.5
                        0 0 1 0-.708l5-5a.5.5 0 0
                        1 .708.708L2.707 7.5H14.5A.5.5
                        0 0 1 15 8z" />
                </svg>
                Go Back
            </a>
        </div>
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
    <form action="{{ route('tender_progress.update', $progressTender->id) }}" method="POST" enctype="multipart/form-data"
        id="awardedForm" data-confirm="edit">

        @csrf
        @method('PUT')

        <ul class="nav nav-tabs" id="employeeTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tender-tab" data-toggle="tab" href="#tender" role="tab">Tender Info</a>
            </li>
        </ul>

        <div class="tab-content p-4 border border-top-0 rounded-bottom" id="employeeTabContent">
            <div class="tab-pane fade show active" id="tender" role="tabpanel">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            {{-- Tender Number --}}
                            <div class="form-group col-md-6">
                                <label for="tender_no">Tender Number <span class="text-danger">*</span></label>
                                <input type="text" id="tender_no" class="form-control"
                                    value="{{ $progressTender->tenderAwarded->tenderParticipate->tender->tender_no }}"
                                    readonly>
                                {{-- Hidden field for tender_id submission --}}
                                <input type="hidden" name="tender_participate_id"
                                    value="{{ $progressTender->tenderAwarded->tenderParticipate->id }}">
                            </div>

                            {{-- Tender Title (readonly, from related tender or old) --}}
                            <div class="form-group col-md-6">
                                <label for="title">Tender Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" readonly
                                    value="{{ old('title', $progressTender->tenderAwarded->tenderParticipate->tender->title ?? '') }}">
                            </div>

                            {{-- Procuring Authority (readonly) --}}
                            <div class="form-group col-md-6">
                                <label for="procuring_authority" class="form-label">Procuring Authority <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="procuring_authority" id="procuring_authority"
                                    class="form-control" readonly
                                    value="{{ old('procuring_authority', $progressTender->tenderAwarded->tenderParticipate->tender->procuring_authority ?? '') }}">
                                @error('procuring_authority')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- End User (readonly) --}}
                            <div class="form-group col-md-6">
                                <label for="end_user" class="form-label">End User <span class="text-danger">*</span></label>
                                <input type="text" name="end_user" id="end_user" class="form-control" readonly
                                    value="{{ old('end_user', $progressTender->tenderAwarded->tenderParticipate->tender->end_user ?? '') }}">
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
                                            {{ old('financial_year', $progressTender->tenderAwarded->tenderParticipate->tender->financial_year ?? '') == $fy ? 'selected' : '' }}>
                                            {{ $fy }}
                                        </option>
                                    @endfor
                                </select>

                                <input type="hidden" name="financial_year" id="financial_year"
                                    value="{{ old('financial_year', $progressTender->tenderAwarded->tenderParticipate->tender->financial_year ?? '') }}">

                                @error('financial_year')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tender Type (readonly) --}}
                            <div class="form-group col-md-6">
                                <label for="tender_type">Tender Type <span class="text-danger">*</span></label>
                                <input type="text" name="tender_type" id="tender_type" class="form-control" readonly
                                    value="{{ old('tender_type', $progressTender->tenderAwarded->tenderParticipate->tender->tender_type ?? '') }}">
                                @error('tender_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Publication Date --}}
                            <div class="form-group col-md-6">
                                <label>Publication Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" readonly
                                    value="{{ \Carbon\Carbon::parse($progressTender->tenderAwarded->tenderParticipate->tender->publication_date)->format('d F Y') }}">
                            </div>

                            {{-- Submission Date --}}
                            <div class="form-group col-md-6">
                                <label>Submission Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" readonly
                                    value="{{ \Carbon\Carbon::parse($progressTender->tenderAwarded->tenderParticipate->tender->submission_date)->format('d F Y') }}">
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
                                                <td>{{ $index + 1 }}</td>
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

                            {{-- Offer No --}}
                            <div class="form-group col-md-6">
                                <label for="offer_no">Offer No <span class="text-danger">*</span></label>
                                <input type="text" name="offer_no" id="offer_no" class="form-control"
                                    value="{{ old('offer_no', $progressTender->tenderAwarded->tenderParticipate->offer_no ?? '') }}"
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
                                        $progressTender->tenderAwarded->tenderParticipate->offer_date
                                            ? \Carbon\Carbon::parse($progressTender->tenderAwarded->tenderParticipate->offer_date)->format('d F Y')
                                            : '',
                                    ) }}"
                                    readonly>

                                @error('offer_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Offer Validity --}}
                            <div class="form-group col-md-6">
                                <label for="offer_validity">Offer Validity <span class="text-danger">*</span></label>
                                <input type="text" name="offer_validity" id="offer_validity" class="form-control"
                                    value="{{ old(
                                        'offer_validity',
                                        $progressTender->tenderAwarded->tenderParticipate->offer_validity
                                            ? \Carbon\Carbon::parse($progressTender->tenderAwarded->tenderParticipate->offer_validity)->format('d F Y')
                                            : '',
                                    ) }}"
                                    readonly>

                                @error('offer_validity')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="offer_doc">Offer Document <span class="text-danger">*</span></label><br>
                                @if (!empty($progressTender->tenderAwarded?->tenderParticipate?->offer_doc))
                                    <a href="{{ asset('uploads/documents/offer_docs/' . $progressTender->tenderAwarded->tenderParticipate->offer_doc) }}"
                                        target="_blank">View
                                        Current</a><br>
                                @endif
                            </div>

                            <div class="form-group col-md-12">
                                <label><strong>Tender's Participate Company</strong></label>

                                @if (!empty($companies) && count($companies))
                                    <table class="table table-bordered mt-2" id="company-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">SL</th>
                                                <th>Company</th>
                                                <th class="text-end">Price</th>
                                                <th class="text-center align-middle" style="width: 20%">Position</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($companies as $key => $company)
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
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


                            <div class="w-100"></div>
                            <div class="form-group col-md-6">
                                <label>is Bid Guarentee (BG)? </label>
                                <div class="mt-1">
                                    <p class="form-control" readonly>
                                        {{ $progressTender->tenderAwarded->tenderParticipate->is_bg == 1 ? 'Yes' : 'No' }}
                                    </p>
                                    <input type="hidden" name="is_bg"
                                        value="{{ $progressTender->tenderAwarded->tenderParticipate->is_bg }}">
                                </div>
                            </div>

                            <div class="w-100"></div>
                            {{-- If BG is required, show full BG details --}}

                            @php
                                $bg = optional($progressTender->tenderAwarded->tenderParticipate->bg);
                            @endphp

                            <div class="form-group col-md-6">
                                <label for="bg_no">BG Number</label>
                                <input type="text" class="form-control {{ $bg->bg_no ? '' : 'text-danger' }}"
                                    value="{{ $bg->bg_no ?? 'N/A' }}" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="issue_in_bank">Issue in Bank</label>
                                <input type="text" class="form-control {{ $bg->issue_in_bank ? '' : 'text-danger' }}"
                                    value="{{ $bg->issue_in_bank ?? 'N/A' }}" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="issue_in_branch">Issue in Branch</label>
                                <input type="text"
                                    class="form-control {{ $bg->issue_in_branch ? '' : 'text-danger' }}"
                                    value="{{ $bg->issue_in_branch ?? 'N/A' }}" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="issue_date">BG Issue Date</label>
                                @php
                                    $issue_date = $bg->issue_date
                                        ? \Carbon\Carbon::parse($bg->issue_date)->format('d F Y')
                                        : 'N/A';
                                @endphp
                                <input type="text"
                                    class="form-control {{ $issue_date === 'N/A' ? 'text-danger' : '' }}"
                                    value="{{ $issue_date }}" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="expiry_date">BG Expiry Date</label>
                                @php
                                    $expiry_date = $bg->expiry_date
                                        ? \Carbon\Carbon::parse($bg->expiry_date)->format('d F Y')
                                        : 'N/A';
                                @endphp
                                <input type="text"
                                    class="form-control {{ $expiry_date === 'N/A' ? 'text-danger' : '' }}"
                                    value="{{ $expiry_date }}" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="amount">BG Amount</label>
                                <input type="text" class="form-control {{ $bg->amount ? '' : 'text-danger' }}"
                                    value="{{ $bg->amount ?? 'N/A' }}" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>BG Attachment</label><br>
                                @if (!empty($bg->attachment))
                                    <a href="{{ asset('uploads/documents/bg_attachments/' . $bg->attachment) }}"
                                        target="_blank">
                                        View Current Attachment
                                    </a>
                                @else
                                    <span class="text-danger">N/A</span>
                                @endif
                            </div>

                            <div class="w-100"></div>

                            {{-- Work Order No/NOA No --}}
                            <div class="form-group col-md-6">
                                <label for="workorder_no">Work Order No/NOA No <span class="text-danger">*</span></label>
                                <input type="text" name="workorder_no" id="workorder_no" class="form-control"
                                    value="{{ old('workorder_no', $progressTender->tenderAwarded->workorder_no ?? '') }}"
                                    readonly>
                                @error('workorder_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Work Order/NOA Date --}}
                            <div class="form-group col-md-6">
                                <label for="workorder_date">Work Order/NOA Date <span class="text-danger">*</span></label>
                                <input type="date" name="workorder_date" id="workorder_date" class="form-control"
                                    value="{{ old('workorder_date', $progressTender->tenderAwarded->workorder_date ? \Carbon\Carbon::parse($progressTender->tenderAwarded->workorder_date)->format('Y-m-d') : '') }}"
                                    readonly>
                                @error('workorder_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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
                                    value="{{ old('awarded_date', $progressTender->tenderAwarded->awarded_date ? \Carbon\Carbon::parse($progressTender->tenderAwarded->awarded_date)->format('Y-m-d') : '') }}"
                                    readonly>
                                @error('awarded_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Delivery Type --}}
                            <div class="form-group col-md-6">
                                <label>Delivery Type</label>
                                <select class="form-control" disabled>
                                    <option value="">-- Select --</option>
                                    <option value="1"
                                        {{ $progressTender->tenderAwarded->delivery_type == '1' ? 'selected' : '' }}>
                                        Single</option>
                                    <option value="partial"
                                        {{ $progressTender->tenderAwarded->delivery_type == 'partial' ? 'selected' : '' }}>
                                        Multiple
                                    </option>
                                </select>
                            </div>

                            {{-- Single Delivery --}}
                            @if ($progressTender->tenderAwarded->delivery_type == '1' && $singleDelivery)
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
                                                <td>1</td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        value="{{ $singleDelivery->delivery_item }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control"
                                                        name="deliveries[0][delivery_date]"
                                                        value="{{ $singleDelivery->delivery_date ?? '' }}">
                                                </td>
                                                <td>
                                                    <select class="form-control" name="deliveries[0][warranty]">
                                                        <option value="">-- Select --</option>
                                                        @foreach (['7 days', '30 days', '45 days', '60 days', '90 days', '6 months', '12 months', '2 years', '3 years'] as $warranty)
                                                            <option value="{{ $warranty }}"
                                                                {{ $singleDelivery->warranty == $warranty ? 'selected' : '' }}>
                                                                {{ $warranty }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            {{-- Partial Deliveries --}}
                            @if ($progressTender->tenderAwarded->delivery_type == 'partial' && $partialDeliveries)
                                <div class="form-group col-md-12">
                                    <h5 class="mt-4">Delivery Information (Multiple)</h5>
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
                                            @foreach ($partialDeliveries as $index => $delivery)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><input type="text" class="form-control"
                                                            value="{{ $delivery->delivery_item }}" readonly></td>
                                                    <td><input type="date" class="form-control"
                                                            value="{{ $delivery->delivery_date }}" readonly></td>
                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option value="">-- Select --</option>
                                                            @foreach (['7 days', '30 days', '45 days', '60 days', '90 days', '6 months', '12 months', '2 years', '3 years'] as $warranty)
                                                                <option value="{{ $warranty }}"
                                                                    {{ $delivery->warranty == $warranty ? 'selected' : '' }}>
                                                                    {{ $warranty }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <div class="w-100"></div>

                            <div class="form-group col-md-6">
                                <label>is Performance Guarentee (PG)? </label>
                                <div class="mt-1">
                                    <p class="form-control" readonly>
                                        {{ $progressTender->tenderAwarded->tenderParticipate->is_pg == 1 ? 'Yes' : 'No' }}
                                    </p>
                                    <input type="hidden" name="is_pg"
                                        value="{{ $progressTender->tenderAwarded->tenderParticipate->is_pg }}">
                                </div>
                            </div>

                            <div class="w-100"></div>
                            @php
                                $pg = $progressTender->tenderAwarded->pg ?? null;
                            @endphp

                            {{-- PG Number --}}
                            <div class="form-group col-md-6">
                                <label for="pg_no">PG Number <span class="text-danger">*</span></label>
                                <input type="text" name="pg_no"
                                    class="form-control {{ empty($pg?->pg_no) ? 'text-danger fw-bold' : '' }}"
                                    value="{{ old('pg_no', $pg?->pg_no ?? 'N/A') }}" readonly>
                                @error('pg_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Issue in Bank --}}
                            <div class="form-group col-md-6">
                                <label for="issue_in_bank">Issue in Bank <span class="text-danger">*</span></label>
                                <input type="text" name="issue_in_bank"
                                    class="form-control {{ empty($pg?->issue_in_bank) ? 'text-danger fw-bold' : '' }}"
                                    value="{{ old('issue_in_bank', $pg?->issue_in_bank ?? 'N/A') }}" readonly>
                                @error('issue_in_bank')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Issue in Branch --}}
                            <div class="form-group col-md-6">
                                <label for="issue_in_branch">Issue in Branch <span class="text-danger">*</span></label>
                                <input type="text" name="issue_in_branch"
                                    class="form-control {{ empty($pg?->issue_in_branch) ? 'text-danger fw-bold' : '' }}"
                                    value="{{ old('issue_in_branch', $pg?->issue_in_branch ?? 'N/A') }}" readonly>
                                @error('issue_in_branch')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Issue Date --}}
                            <div class="form-group col-md-6">
                                <label for="issue_date">PG Issue Date <span class="text-danger">*</span></label>
                                <input type="text" name="issue_date"
                                    class="form-control {{ empty($pg?->issue_date) ? 'text-danger fw-bold' : '' }}"
                                    value="{{ old('issue_date', $pg?->issue_date ?? 'N/A') }}" readonly>
                                @error('issue_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Expiry Date --}}
                            <div class="form-group col-md-6">
                                <label for="expiry_date">PG Expiry Date <span class="text-danger">*</span></label>
                                <input type="text" name="expiry_date"
                                    class="form-control {{ empty($pg?->expiry_date) ? 'text-danger fw-bold' : '' }}"
                                    value="{{ old('expiry_date', $pg?->expiry_date ?? 'N/A') }}" readonly>
                                @error('expiry_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Amount --}}
                            <div class="form-group col-md-6">
                                <label for="amount">PG Amount <span class="text-danger">*</span></label>
                                <input type="text" name="amount"
                                    class="form-control {{ empty($pg?->amount) ? 'text-danger fw-bold' : '' }}"
                                    value="{{ old('amount', $pg?->amount ?? 'N/A') }}" readonly>
                                @error('amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Attachment --}}
                            <div class="form-group col-md-6">
                                <label for="attachment">PG Attachment <span class="text-danger">*</span></label><br>
                                @if (!empty($pg?->attachment))
                                    <a href="{{ asset('uploads/documents/pg_attachments/' . $pg->attachment) }}"
                                        target="_blank">View Current</a>
                                @else
                                    <span class="text-danger fw-bold">N/A</span>
                                @endif
                            </div>

                            <div class="w-100"></div>

                            <div class="form-group col-md-6">
                                <label>Is Delivered?</label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_delivered"
                                            id="delivered_no" value="0"
                                            {{ old('is_delivered', $progressTender->is_delivered) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="delivered_no">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_delivered"
                                            id="delivered_yes" value="1"
                                            {{ old('is_delivered', $progressTender->is_delivered) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="delivered_yes">Yes</label>
                                    </div>
                                </div>
                            </div>

                            <div class="w-100"></div>
                            {{-- Challan No --}}

                            <div class="form-group col-md-6">
                                <label for="challan_no">Challan No <span class="text-danger">*</span></label>
                                <input type="text" name="challan_no" id="challan_no" class="form-control"
                                    value="{{ old('challan_no', $progressTender->challan_no ?? '') }}">
                                @error('challan_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Challan Date --}}
                            <div class="form-group col-md-6">
                                <label for="challan_date">Challan Date <span class="text-danger">*</span></label>
                                <input type="date" name="challan_date" id="challan_date" class="form-control"
                                    value="{{ old('challan_no', $progressTender->challan_date ?? '') }}">

                                @error('challan_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Challan Doc --}}
                            <div class="form-group col-md-6">
                                <label for="challan_doc">Challan Document <span class="text-danger">*</span></label><br>
                                @if (!empty($progressTender?->challan_doc))
                                    <a href="{{ asset('uploads/documents/challan_docs/' . $progressTender->challan_doc) }}"
                                        target="_blank">View
                                        Current</a><br>
                                @endif
                                <input type="file" name="challan_doc" class="form-control mt-2">
                                @error('attachment')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="w-100"></div>
                            <div class="form-group col-md-6">
                                <label>Is Inspection Completed? <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_inspection_completed"
                                            value="0"
                                            {{ old('is_inspection_completed', $progressTender->is_inspection_completed) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_inspection_completed"
                                            value="1"
                                            {{ old('is_inspection_completed', $progressTender->is_inspection_completed) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                </div>
                            </div>

                            {{-- JS Part --}}
                            <div class="form-group col-md-6">
                                <label for="inspection_complete_date">Inspection Complete Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="inspection_complete_date" id="inspection_complete_date"
                                    class="form-control"
                                    value="{{ old('inspection_complete_date', $progressTender->inspection_complete_date ?? '') }}">

                                @error('inspection_complete_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Is Inspection Accepted? <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_inspection_accepted"
                                            value="0"
                                            {{ old('is_inspection_accepted', $progressTender->is_inspection_accepted) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_inspection_accepted"
                                            value="1"
                                            {{ old('is_inspection_accepted', $progressTender->is_inspection_accepted) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inspection_accept_date">Inspection Accept Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="inspection_accept_date" id="inspection_accept_date"
                                    class="form-control"
                                    value="{{ old('inspection_accept_date', $progressTender->inspection_accept_date ?? '') }}">

                                @error('inspection_accept_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label for="warranty_expiry_date">Warranty Expiry Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="warranty_expiry_date" id="warranty_expiry_date"
                                    class="form-control"
                                    value="{{ old('warranty_expiry_date', $progressTender->warranty_expiry_date ?? '') }}"
                                    readonly>

                                @error('warranty_expiry_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Is Bill Submitted? <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_bill_submitted"
                                            value="0"
                                            {{ old('is_bill_submitted', $progressTender->is_bill_submitted) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_bill_submitted"
                                            value="1"
                                            {{ old('is_bill_submitted', $progressTender->is_bill_submitted) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                </div>
                            </div>

                            <div class="w-100"></div>

                            <div class="form-group col-md-6">
                                <label><strong>Bill No <span class="text-danger">*</span></strong></label>
                                <input type="text" name="bill_no" class="form-control"
                                    value="{{ old('bill_no', $progressTender->bill_no) }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label><strong>Bill Submit Date <span class="text-danger">*</span></strong></label>
                                <input type="date" name="bill_submit_date" class="form-control"
                                    value="{{ old('bill_submit_date', $progressTender->bill_submit_date) }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label><strong>Bill Document <span class="text-danger">*</span></strong></label>
                                @if (!empty($progressTender->bill_doc))
                                    <a href="{{ asset('uploads/documents/bill_docs/' . $progressTender->bill_doc) }}"
                                        target="_blank">View
                                        Current</a><br>
                                @endif
                                <input type="file" name="bill_doc" class="form-control">
                            </div>


                            <div class="w-100"></div>
                            <div class="form-group col-md-6">
                                <label>Is Bill Received? <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_bill_received"
                                            value="0"
                                            {{ old('is_bill_received', $progressTender->is_bill_received) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_bill_received"
                                            value="1"
                                            {{ old('is_bill_received', $progressTender->is_bill_received) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-md-6">
                                <label><strong>Bill Cheque No <span class="text-danger">*</span></strong></label>
                                <input type="text" name="bill_cheque_no" class="form-control"
                                    value="{{ old('bill_cheque_no', $progressTender->bill_cheque_no) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label><strong>Bill Receive Date <span class="text-danger">*</span></strong></label>
                                <input type="date" name="bill_receive_date" class="form-control"
                                    value="{{ old('bill_receive_date', $progressTender->bill_receive_date) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label><strong>Bank Name <span class="text-danger">*</span></strong></label>
                                <input type="text" name="bill_bank_name" class="form-control"
                                    value="{{ old('bill_bank_name', $progressTender->bill_bank_name) }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label><strong>Bill Amount <span class="text-danger">*</span></strong></label>
                                <input type="number" name="bill_amount" class="form-control"
                                    value="{{ old('bill_amount', $progressTender->bill_amount) }}">
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
        </div>
    </form>

@endsection

@section('js')
    <!-- Required: Animate.css + Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    {{-- start of challan field by toggle on is delivery --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deliveredYes = document.getElementById("delivered_yes");
            const deliveredNo = document.getElementById("delivered_no");

            const challanNo = document.getElementById("challan_no");
            const challanDate = document.getElementById("challan_date");
            const challanDoc = document.querySelector("input[name='challan_doc']");

            function toggleReadonly(isReadonly) {
                challanNo.readOnly = isReadonly;
                challanDate.readOnly = isReadonly;
                challanDoc.disabled = isReadonly;
            }

            // যদি Yes select করে -> readonly mode remove হবে
            deliveredYes.addEventListener("change", function() {
                if (this.checked) {
                    toggleReadonly(false);
                }
            });

            // যদি No select করে -> confirmation আসবে
            deliveredNo.addEventListener("change", function() {
                if (this.checked) {
                    let confirmRemove = confirm("Do you want to remove previous challan data?");
                    if (confirmRemove) {
                        challanNo.value = "";
                        challanDate.value = "";
                        challanDoc.value = "";
                    }
                    toggleReadonly(true); // No হলে সব field readonly হয়ে যাবে
                }
            });

            // Page reload হলে initial অবস্থায় ঠিক রাখা
            if (deliveredNo.checked) {
                toggleReadonly(true);
            }
        });
    </script>

    {{-- end of challan field  by toggle on is delivery --}}
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
    <script>
        function toggleFields() {
            let isDelivered = $('input[name="is_delivered"]:checked').val();
            let isSubmitted = $('input[name="is_bill_submitted"]:checked').val();
            let isReceived = $('input[name="is_bill_received"]:checked').val();

            $('#challan-fields').toggle(isDelivered == 1);
            $('#bill-submit-fields').toggle(isSubmitted == 1);
            $('#bill-receive-fields').toggle(isReceived == 1);
        }

        $(document).ready(function() {
            toggleFields();
            $('input[type=radio]').on('change', toggleFields);
        });
    </script>
    <script>
        function calculateWorkProgress() {
            const fields = [
                document.querySelector('input[name="is_delivered"]:checked'),
                document.querySelector('input[name="is_inspection_completed"]:checked'),
                document.querySelector('input[name="is_inspection_accepted"]:checked'),
                document.querySelector('input[name="is_bill_submitted"]:checked'),
                document.querySelector('input[name="is_bill_received"]:checked')
            ];

            let completed = 0;

            fields.forEach(field => {
                if (field && field.value === "1") {
                    completed += 1;
                }
            });

            const percentage = (completed / 5) * 100;
            document.getElementById('work-process').innerText = `Work Progress: ${percentage}%`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            calculateWorkProgress();

            const radioGroups = ['is_delivered', 'is_inspection_completed', 'is_inspection_accepted',
                'is_bill_submitted', 'is_bill_received'
            ];
            radioGroups.forEach(name => {
                document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
                    radio.addEventListener('change', calculateWorkProgress);
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const challanInput = document.getElementById('challan_date');
            const yesRadio = document.querySelector('input[name="is_inspection_completed"][value="1"]');
            const noRadio = document.querySelector('input[name="is_inspection_completed"][value="0"]');

            // Check if challan date exists AND inspection is not already marked as completed
            if (challanInput?.value && yesRadio && !yesRadio.checked) {
                Swal.fire({
                    title: 'Do you have an inspection date?',
                    text: 'Challan Date is already filled. Please confirm inspection status.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true,
                    customClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        yesRadio.checked = true;
                        Swal.fire({
                            title: 'Marked as Completed',
                            text: 'Inspection marked as completed.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        if (noRadio) noRadio.checked = true;
                        Swal.fire({
                            title: 'Pending Inspection',
                            text: 'Please complete the inspection later.',
                            icon: 'info',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const yesRadio = document.querySelector('input[name="is_inspection_completed"][value="1"]');
            const acceptedRadio = document.querySelector('input[name="is_inspection_accepted"][value="1"]');
            const warrantyExpiryInput = document.getElementById('warranty_expiry_date');
            const singleSection = document.getElementById('first_delivery_section');
            const dateInput = document.querySelector('input[name="deliveries[0][delivery_date]"]');
            const warrantySelect = document.querySelector('select[name="deliveries[0][warranty]"]');

            function calculateWarranty() {
                if (!dateInput || !warrantySelect) return;
                const deliveryDateStr = dateInput.value;
                const warrantyText = warrantySelect.value;

                if (!deliveryDateStr || !warrantyText) return;

                const daysMap = {
                    '7 days': 7,
                    '30 days': 30,
                    '45 days': 45,
                    '60 days': 60,
                    '90 days': 90,
                    '6 months': 182,
                    '12 months': 365,
                    '2 years': 730,
                    '3 years': 1095
                };

                const baseDate = new Date(deliveryDateStr);
                const addedDays = daysMap[warrantyText] ?? 0;
                if (!isNaN(baseDate.getTime()) && addedDays > 0) {
                    baseDate.setDate(baseDate.getDate() + addedDays);
                    const yyyy = baseDate.getFullYear();
                    const mm = String(baseDate.getMonth() + 1).padStart(2, '0');
                    const dd = String(baseDate.getDate()).padStart(2, '0');
                    warrantyExpiryInput.value = `${yyyy}-${mm}-${dd}`;
                }
            }

            function showPopup() {
                Swal.fire({
                    title: 'Did you receive the inspection acceptance?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true,
                    customClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (acceptedRadio) acceptedRadio.checked = true;
                        singleSection?.removeAttribute('style');
                        calculateWarranty();

                        Swal.fire({
                            title: 'Delivery section unlocked',
                            text: 'You may now proceed with delivery details.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        if (acceptedRadio) acceptedRadio.checked = false;
                        singleSection?.setAttribute('style', 'display:none');
                        warrantyExpiryInput.value = '';
                        Swal.fire({
                            title: 'Inspection not accepted',
                            text: 'You cannot proceed with deliveries until inspection is accepted.',
                            icon: 'info',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            }

            // ✅ Trigger popup if inspection completed = Yes AND inspection accepted = No
            const isInspectionCompleted = yesRadio?.checked;
            const isInspectionAccepted = acceptedRadio?.checked;

            if (isInspectionCompleted && !isInspectionAccepted) {
                showPopup();
            }

            // ✅ Also trigger on change
            yesRadio?.addEventListener('change', function() {
                if (yesRadio.checked && !acceptedRadio.checked) {
                    showPopup();
                }
            });

            acceptedRadio?.addEventListener('change', calculateWarranty);
            dateInput?.addEventListener('change', calculateWarranty);
            warrantySelect?.addEventListener('change', calculateWarranty);
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const billInput = document.querySelector('input[name="bill_amount"]');
            const grandTotalInput = document.getElementById('grand-total');

            billInput.addEventListener('blur', function() {
                const billAmount = parseFloat(billInput.value.replace(/,/g, ''));
                const grandTotal = parseFloat(grandTotalInput.value.replace(/,/g, ''));

                if (!isNaN(billAmount) && !isNaN(grandTotal)) {
                    const minimumAllowed = grandTotal - (grandTotal * 0.15);

                    if (billAmount < minimumAllowed) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Invalid Bill Amount',
                            text: `You can't input less than ${minimumAllowed.toLocaleString()} BDT. Please try again.`,
                            confirmButtonText: 'Okay',
                            allowOutsideClick: true
                        }).then(() => {
                            billInput.value = '';
                            billInput.focus();
                        });
                    }
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const billSubmittedRadios = document.querySelectorAll('input[name="is_bill_submitted"]');

            billSubmittedRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === "1") {
                        Swal.fire({
                            title: 'Did you receive the bill?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No',
                            confirmButtonColor: '#28a745',
                            cancelButtonColor: '#dc3545',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Set "Is Bill Received" to Yes (1)
                                const receivedYesRadio = document.querySelector(
                                    'input[name="is_bill_received"][value="1"]');
                                if (receivedYesRadio) {
                                    receivedYesRadio.checked = true;
                                }
                            }
                            // If 'No' selected, do nothing (stay on page)
                        });
                    }
                });
            });
        });
    </script>


@endsection
