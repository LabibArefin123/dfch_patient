@extends('adminlte::page')
@section('title', 'Add Progress Tender')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Create Progress Tender</h1>
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

    <form action="{{ route('tender_progress.store') }}" method="POST" id="awardedForm" enctype="multipart/form-data"
        data-confirm="create">
        @csrf
        <ul class="nav nav-tabs mb-3" id="editTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tender-tab" data-bs-toggle="tab" href="#tenderPane" role="tab"
                    aria-controls="tenderPane" aria-selected="true">Tender Info</a>
            </li>

            <li class="nav-item" id="pg-tab-li" style="display: none;">
                <a class="nav-link" id="pg-tab" data-bs-toggle="tab" href="#pgPane" role="tab" aria-controls="pgPane"
                    aria-selected="false">Performance Guarantee (PG) Info</a>
            </li>
        </ul>

        <div class="tab-content p-4" id="editTabContent">
            <div class="tab-pane fade show active" id="tenderPane" role="tabpanel">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="tender_no">Tender Number <span class="text-danger">*</span></label>
                                <select name="tender_awarded_id" id="tenderNo" class="form-control">
                                    <option value="">-- Select Tender Number --</option>
                                    @foreach ($progressTenders as $pt)
                                        <option value="{{ $pt->tenderParticipate->tender->id }}"
                                            data-awarded-id="{{ $pt->id }}"
                                            {{ old('tender_awarded_id') == $pt->tenderParticipate->tender->id ? 'selected' : '' }}>
                                            {{ $pt->tenderParticipate->tender->tender_no }} -
                                            {{ $pt->tenderParticipate->tender->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="tender_awarded_id" id="tender_awarded_id"
                                    value="{{ old('tender_awarded_id') }}">
                                @error('tender_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="title">Tender Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" readonly
                                    value="{{ old('title') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="offer_no">Offer No <span class="text-danger">*</span></label>
                                <input type="text" name="offer_no" id="offer_no" class="form-control"
                                    value="{{ old('offer_no') }}" readonly>
                                @error('offer_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="offer_date">Offer Date <span class="text-danger">*</span></label>
                                <input type="date" name="offer_date" id="offer_date" class="form-control"
                                    value="{{ old('offer_date') }}" readonly>
                                @error('offer_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="offer_validity">Offer Validity <span class="text-danger">*</span></label>
                                <input type="date" name="offer_validity" id="offer_validity" class="form-control"
                                    value="{{ old('offer_validity') }}" readonly>
                                @error('offer_validity')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="procuring_authority" class="form-label">Procuring Authority <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="procuring_authority" id="procuring_authority"
                                    class="form-control" placeholder="Enter Procuring Authority"
                                    value="{{ old('procuring_authority') }}" readonly>
                                @error('procuring_authority')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="end_user" class="form-label">End User <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="end_user" id="end_user" class="form-control"
                                    placeholder="Enter End User" value="{{ old('end_user') }}" readonly>
                                @error('end_user')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="financial_year">FY (Financial Year) <span class="text-danger">*</span></label>

                                {{-- Disabled visible select (read-only effect) --}}
                                <select id="financial_year" class="form-control" disabled>
                                    <option value="">Select Financial Year</option>
                                    @for ($year = 2026; $year >= 2005; $year--)
                                        @php $fy = $year . '-' . ($year + 1); @endphp
                                        <option value="{{ $fy }}"
                                            {{ old('financial_year') == $fy ? 'selected' : '' }}>
                                            {{ $fy }}
                                        </option>
                                    @endfor
                                </select>

                                {{-- Hidden actual select for form submission --}}
                                <input type="hidden" name="financial_year" id="financial_year"
                                    value="{{ old('financial_year') }}">

                                @error('financial_year')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label for="tender_type">Tender Type <span class="text-danger">*</span></label>
                                <input type="text" name="tender_type" id="tender_type" class="form-control" readonly
                                    value="{{ old('tender_type') }}">
                                @error('tender_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="publication_date">Publication Date <span class="text-danger">*</span></label>
                                <input type="date" name="publication_date" id="publication_date" class="form-control"
                                    value="{{ old('publication_date') }}" readonly>
                                @error('publication_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="submission_date">Submission Date <span class="text-danger">*</span></label>
                                <input type="date" name="submission_date" id="submission_date" class="form-control"
                                    value="{{ old('submission_date') }}" readonly>
                                @error('submission_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div style="width: 100%; height: 2px; background-color: #ddd; margin: 20px 0;"></div>

                            <div class="form-group col-md-6">
                                <label>Bid Guarentee (BG):</label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_bg" id="bg_no"
                                            value="0" disabled>
                                        <label class="form-check-label" for="bg_no">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_bg" id="bg_yes"
                                            value="1" disabled>
                                        <label class="form-check-label" for="bg_yes">Yes</label>
                                    </div>
                                </div>
                            </div>

                            <div id="bg-field-wrapper" class="d-none">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="bg_no">BG Number <span class="text-danger">*</span></label>
                                        <input type="text" name="bg_no" class="form-control"
                                            value="{{ old('bg_no', $tenderParticipate->bg->bg_no ?? '') }}"
                                            id="bg_no_field" readonly>
                                        @error('bg_no')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="issue_in_bank">Issue in Bank <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="issue_in_bank" class="form-control"
                                            value="{{ old('issue_in_bank', $tenderParticipate->bg->issue_in_bank ?? '') }}"
                                            id="issue_in_bank_field" readonly>
                                        @error('issue_in_bank')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="issue_in_branch">Issue in Branch <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="issue_in_branch" class="form-control"
                                            value="{{ old('issue_in_branch', $tenderParticipate->bg->issue_in_branch ?? '') }}"
                                            id="issue_in_branch_field" readonly>
                                        @error('issue_in_branch')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="issue_date">BG Issue Date <span class="text-danger">*</span></label>
                                        <input type="date" name="issue_date" class="form-control"
                                            value="{{ old('issue_date', $tenderParticipate->bg->issue_date ?? '') }}"
                                            id="issue_date_field" readonly>
                                        @error('issue_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="expiry_date">BG Expiry Date <span class="text-danger">*</span></label>
                                        <input type="date" name="expiry_date" class="form-control"
                                            value="{{ old('expiry_date', $tenderParticipate->bg->expiry_date ?? '') }}"
                                            id="expiry_date_field" readonly>
                                        @error('expiry_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="amount">BG Amount <span class="text-danger">*</span></label>
                                        <input type="number" name="amount" class="form-control"
                                            value="{{ old('amount', $tenderParticipate->bg->amount ?? '') }}"
                                            id="amount_field" readonly>
                                        @error('amount')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Attachment <span class="text-danger">*</span></label><br>

                                        {{-- Remove input[type=file] if it's read-only --}}
                                        <span id="attachment_link_wrapper">
                                            @if (!empty($tenderParticipate->bg?->attachment))
                                                <a href="{{ asset('uploads/documents/bg_attachments/' . $tenderParticipate->bg->attachment) }}"
                                                    target="_blank">
                                                    View Current Attachment
                                                </a>
                                            @else
                                                <span class="text-muted">No attachment available</span>
                                            @endif
                                        </span>

                                        @error('attachment')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
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
                                        @foreach ($items ?? [['item' => '', 'deno' => '', 'quantity' => '', 'unit_price' => '', 'total_price' => '']] as $index => $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><input type="text" name="items[{{ $index }}][item]"
                                                        class="form-control" value="{{ $item['item'] }}" readonly></td>
                                                <td>
                                                    <input type="text" name="items[{{ $index }}][deno]"
                                                        class="form-control" value="{{ $item['deno'] }}" readonly>
                                                </td>
                                                <td><input type="number" name="items[{{ $index }}][quantity]"
                                                        class="form-control" value="{{ $item['quantity'] }}" readonly>
                                                </td>
                                                <td><input type="number" name="items[{{ $index }}][unit_price]"
                                                        class="form-control" value="{{ $item['unit_price'] }}" readonly>
                                                </td>
                                                <td><input type="number" name="items[{{ $index }}][total_price]"
                                                        class="form-control" value="{{ $item['total_price'] }}" readonly>
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
                                                    value="{{ number_format($grandTotal ?? 0, 2, '.', '') }}" readonly>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Tender's Participate Company</label>
                                <div id="company-participants">
                                    <p class="text-muted">Please select a tender to view participant company.</p>
                                </div>
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
                                    <tbody id="participateLettersTable">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No letters uploaded yet.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div style="width: 100%; height: 2px; background-color: #ddd; margin: 20px 0;"></div>

                            <div class="form-group col-md-6">
                                <label for="workorder_no">Work Order No/NOA No <span class="text-danger">*</span></label>
                                <input type="text" name="workorder_no" id="workorder_no" class="form-control"
                                    value="{{ old('workorder_no') }}" readonly>
                                @error('workorder_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="workorder_no">Work Order/NOA Date <span class="text-danger">*</span></label>
                                <input type="date" name="workorder_date" id="workorder_date" class="form-control"
                                    value="{{ old('workorder_date') }}" readonly>
                                @error('workorder_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="awarded_date">Delivery Date <span class="text-danger">*</span></label>
                                <input type="date" name="awarded_date" id="awarded_date" class="form-control"
                                    value="{{ old('awarded_date') }}" readonly>
                                @error('awarded_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Delivery Type</label>
                                <select class="form-control" name="delivery_type" id="delivery_type" readonly disabled>
                                    <option value="">-- Select --</option>
                                    <option value="1">Single</option>
                                    <option value="partial">Multiple</option>
                                </select>
                            </div>

                            <div id="first_delivery_section" style="display: none;" class="form-group col-md-12">
                                <h5 class="mt-4">Delivery Information (Single)</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Delivery Item </th>
                                            <th>Delivery Date</th>
                                            <th>Warranty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td><input type="text" name="deliveries[0][delivery_item]"
                                                    class="form-control">
                                            </td>
                                            <td><input type="date" name="deliveries[0][delivery_date]"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <select name="deliveries[0][warranty]" class="form-control">
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

                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Partial Delivery Section --}}
                            <div id="partial_delivery_section" style="display: none;" class="form-group col-md-12">
                                <h5 class="mt-4 d-flex justify-content-between">
                                    Delivery Information (Multiple)
                                    <button type="button" class="btn btn-success btn-sm"
                                        onclick="addPartialDeliveryRow()">+
                                        Add
                                        Row</button>
                                </h5>
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
                                    <tbody></tbody>
                                </table>
                            </div>

                            <div class="form-group col-md-12">
                                <strong>Awarded Tender's Correspondence</strong>
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
                                    <tbody id="awardedLettersTable">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No letters uploaded yet.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Performance Guarentee (PG):</label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_pg" id="pg_no_radio"
                                            value="0" disabled>
                                        <label class="form-check-label" for="pg_no_radio">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_pg" id="pg_yes_radio"
                                            value="1" disabled>
                                        <label class="form-check-label" for="pg_yes_radio">Yes</label>
                                    </div>
                                </div>
                            </div>

                            <div id="pg-field-wrapper" class="d-none">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="pg_no">PG Number <span class="text-danger">*</span></label>
                                        <input type="text" name="pg_no" class="form-control" id="pg_no_field"
                                            value="{{ old('pg_no', $tenderAwarded->pg->pg_no ?? '') }}" readonly>
                                        @error('pg_no')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="issue_in_bank">Issue in Bank <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="issue_in_bank" class="form-control"
                                            id="pg_issue_in_bank_field"
                                            value="{{ old('issue_in_bank', $tenderAwarded->pg->issue_in_bank ?? '') }}"
                                            readonly>
                                        @error('issue_in_bank')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="issue_in_branch">Issue in Branch <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="issue_in_branch" class="form-control"
                                            id="pg_issue_in_branch_field"
                                            value="{{ old('issue_in_branch', $tenderAwarded->pg->issue_in_branch ?? '') }}"
                                            readonly>
                                        @error('issue_in_branch')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="issue_date">PG Issue Date <span class="text-danger">*</span></label>
                                        <input type="date" name="issue_date" class="form-control"
                                            id="pg_issue_date_field"
                                            value="{{ old('issue_date', $tenderAwarded->pg->issue_date ?? '') }}"
                                            readonly>
                                        @error('issue_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="expiry_date">PG Expiry Date <span class="text-danger">*</span></label>
                                        <input type="date" name="expiry_date" class="form-control"
                                            id="pg_expiry_date_field"
                                            value="{{ old('expiry_date', $tenderAwarded->pg->expiry_date ?? '') }}"
                                            readonly>
                                        @error('expiry_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="amount">PG Amount <span class="text-danger">*</span></label>
                                        <input type="number" name="amount" step="0.01" class="form-control"
                                            id="pg_amount_field"
                                            value="{{ old('amount', $tenderAwarded->pg->amount ?? '') }}" readonly>
                                        @error('amount')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>PG Attachment</label><br>
                                        <div id="pg_attachment_link_wrapper">
                                            @if (!empty($tenderAwarded->pg->attachment))
                                                <a class="form-control"
                                                    href="{{ asset('uploads/documents/pg_attachments/' . $tenderAwarded->pg->attachment) }}"
                                                    target="_blank">
                                                    View Current Attachment
                                                </a>
                                            @else
                                                <span class="text-muted">No attachment available</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="w-100"></div>

                            <div class="form-group col-md-6">
                                <label>Is Delivered? <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_delivered"
                                            id="delivered_no" value="0"
                                            {{ old('is_delivered') == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="delivered_no">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_delivered"
                                            id="delivered_yes" value="1"
                                            {{ old('is_delivered') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="delivered_yes">Yes</label>
                                    </div>
                                </div>
                            </div>

                            <div class="w-100"></div>

                            <div class="form-group col-md-6 challan-field">
                                <label><strong>Challan No <span class="text-danger">*</span></strong></label>
                                <input type="text" name="challan_no" class="form-control"
                                    value="{{ old('challan_no') }}">
                            </div>

                            <div class="form-group col-md-6 challan-field">
                                <label><strong>Challan Date <span class="text-danger">*</span></strong></label>
                                <input type="date" name="challan_date" class="form-control"
                                    value="{{ old('challan_date') }}">
                            </div>

                            <div class="form-group col-md-6 challan-field">
                                <label><strong>Challan Document <span class="text-danger">*</span></strong></label>
                                <input type="file" name="challan_doc" class="form-control">
                            </div>

                            <div class="w-100"></div>

                            <div class="form-group col-md-6">
                                <label>Is Inspection Completed? <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_inspection_completed"
                                            id="inspection_complete_no" value="0"
                                            {{ old('is_inspection_completed') == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inspection_complete_no">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_inspection_completed"
                                            id="inspection_complete_yes" value="1"
                                            {{ old('is_inspection_completed') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inspection_complete_yes">Yes</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6 inspection-complete-field">
                                <label><strong>Inspection Complete Date <span class="text-danger">*</span></strong></label>
                                <input type="date" name="inspection_complete_date" class="form-control"
                                    value="{{ old('inspection_complete_date') }}">
                            </div>



                            <div class="form-group col-md-6">
                                <label>Is Inspection Accepted? <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_inspection_accepted"
                                            id="inspection_accepted_no" value="0"
                                            {{ old('is_inspection_accepted') == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inspection_accepted_no">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_inspection_accepted"
                                            id="inspection_accepted_yes" value="1"
                                            {{ old('is_inspection_accepted') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inspection_accepted_yes">Yes</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6 inspection-accept-field">
                                <label><strong>Inspection Accept Date <span class="text-danger">*</span></strong></label>
                                <input type="date" name="inspection_accept_date" class="form-control"
                                    value="{{ old('inspection_accept_date') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Is Bill Submitted? <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_bill_submitted"
                                            id="bill_submitted_no" value="0"
                                            {{ old('is_bill_submitted') == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bill_submitted_no">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_bill_submitted"
                                            id="bill_submitted_yes" value="1"
                                            {{ old('is_bill_submitted') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bill_submitted_yes">Yes</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6 bill-submit-field">
                                <label><strong>Bill No <span class="text-danger">*</span></strong></label>
                                <input type="text" name="bill_no" class="form-control" value="{{ old('bill_no') }}">
                            </div>

                            <div class="form-group col-md-6 bill-submit-field">
                                <label><strong>Bill Submit Date <span class="text-danger">*</span></strong></label>
                                <input type="date" name="bill_submit_date" class="form-control"
                                    value="{{ old('bill_submit_date') }}">
                            </div>

                            <div class="form-group col-md-6 bill-submit-field">
                                <label><strong>Bill Document <span class="text-danger">*</span></strong></label>
                                <input type="file" name="bill_doc" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Is Bill Received? <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_bill_received"
                                            id="bill_received_no" value="0"
                                            {{ old('is_bill_received') == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bill_received_no">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_bill_received"
                                            id="bill_received_yes" value="1"
                                            {{ old('is_bill_received') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bill_received_yes">Yes</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6 bill-receive-fields">
                                <label><strong>Bill Cheque No <span class="text-danger">*</span></strong></label>
                                <input type="text" name="bill_cheque_no" class="form-control"
                                    value="{{ old('bill_cheque_no') }}">
                            </div>

                            <div class="form-group col-md-6 bill-receive-fields">
                                <label><strong>Bill Receive Date <span class="text-danger">*</span></strong></label>
                                <input type="date" name="bill_receive_date" class="form-control"
                                    value="{{ old('bill_receive_date') }}">
                            </div>

                            <div class="form-group col-md-6 bill-receive-fields">
                                <label><strong>Bank Name <span class="text-danger">*</span></strong></label>
                                <input type="text" name="bill_bank_name" class="form-control"
                                    value="{{ old('bill_bank_name') }}">
                            </div>

                            <div class="form-group col-md-6 bill-receive-fields">
                                <label><strong>Bill Amount <span class="text-danger">*</span></strong></label>
                                <input type="number" name="bill_amount" class="form-control">
                            </div>

                        </div>
                        <div class="mt-4" style="text-align: right;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Submit
                            </button>
                        </div>
                    </div>


                </div>
            </div>

    </form>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('tenderNo').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const awardedId = selectedOption.getAttribute('data-awarded-id');

            console.log('Selected Awarded ID:', awardedId); // 👈 Console log added

            document.getElementById('tender_awarded_id').value = awardedId ?? '';
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tenderSelect = document.getElementById('tenderNo');
            const tenderParticipateInput = document.getElementById('tender_awarded_id');
            const bgYes = document.getElementById('bg_yes');
            const bgNo = document.getElementById('bg_no');
            const pgYes = document.getElementById('pg_yes_radio');
            const pgNo = document.getElementById('pg_no_radio');
            const bgFieldWrapper = document.getElementById('bg-field-wrapper');
            const pgFieldWrapper = document.getElementById('pg-field-wrapper');
            const deliveryTypeSelect = document.getElementById('delivery_type');
            const firstDeliverySection = document.getElementById('first_delivery_section');
            const partialDeliverySection = document.getElementById(
                'partial_delivery_section');
            const partialDeliveryTableBody = document.querySelector(
                '#partial_delivery_table tbody');
            // ==============================
            // UTILITY FUNCTIONS
            // ==============================
            const disableBgRadios = () => {
                if (bgYes && bgNo) {
                    bgYes.disabled = true;
                    bgNo.disabled = true;
                }
            };
            const disablePgRadios = () => {
                if (pgYes && pgNo) {
                    pgYes.disabled = true;
                    pgNo.disabled = true;
                }
            };

            const showBGFields = () => bgFieldWrapper?.classList.remove('d-none');
            const hideBGFields = () => bgFieldWrapper?.classList.add('d-none');

            const showPGFields = () => pgFieldWrapper?.classList.remove('d-none');
            const hidePGFields = () => pgFieldWrapper?.classList.add('d-none');

            const resetState = () => {

                hideBGFields();
                hidePGFields();
                if (bgYes) bgYes.checked = false;
                if (bgNo) bgNo.checked = false;

            };

            const populateTenderFields = (data) => {
                const fields = [
                    'title', 'offer_no', 'offer_date', 'offer_validity',
                    'procuring_authority', 'end_user', 'financial_year',
                    'tender_type', 'publication_date', 'submission_date',
                    'workorder_no', 'workorder_date', 'awarded_date',
                ];
                fields.forEach(f => {
                    const el = document.getElementById(f);
                    if (el) el.value = data[f] || '';
                });

            };

            const populateBGFields = (bg) => {
                if (!bg) return;
                const fieldMap = {
                    'bg_no_field': bg.bg_no,
                    'issue_in_bank_field': bg.issue_in_bank,
                    'issue_in_branch_field': bg.issue_in_branch,
                    'issue_date_field': bg.issue_date,
                    'expiry_date_field': bg.expiry_date,
                    'amount_field': bg.amount
                };
                Object.entries(fieldMap).forEach(([id, val]) => {
                    const el = document.getElementById(id);
                    if (el) el.value = val || '';
                });

                const wrapper = document.getElementById('attachment_link_wrapper');
                if (wrapper) {
                    wrapper.innerHTML = bg.attachment ?
                        `<a href="/uploads/documents/bg_attachments/${bg.attachment}" target="_blank">View Current Attachment</a>` :
                        '<span class="text-muted">No attachment available</span>';
                }
            };

            const populatePGFields = (pg) => {
                if (!pg) return;
                const fieldMap = {
                    'pg_no_field': pg.pg_no,
                    'pg_issue_in_bank_field': pg.issue_in_bank,
                    'pg_issue_in_branch_field': pg.issue_in_branch,
                    'pg_issue_date_field': pg.issue_date,
                    'pg_expiry_date_field': pg.expiry_date,
                    'pg_amount_field': pg.amount
                };
                Object.entries(fieldMap).forEach(([id, val]) => {
                    const el = document.getElementById(id);
                    if (el) el.value = val || '';
                });

                const wrapper = document.getElementById('pg_attachment_link_wrapper');
                if (wrapper) {
                    wrapper.innerHTML = pg.attachment ?
                        `<a href="/uploads/documents/pg_attachments/${pg.attachment}" target="_blank">View Current Attachment</a>` :
                        '<span class="text-muted">No attachment available</span>';
                }

            };

            const populateItems = (items) => {
                const tbody = document.getElementById('item-tbody');
                if (!tbody) return;
                tbody.innerHTML = '';
                let grandTotal = 0;
                (Array.isArray(items) ? items : JSON.parse(items || '[]')).forEach((item, index) => {
                    grandTotal += parseFloat(item.total_price || 0);
                    tbody.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td><input type="text" class="form-control" value="${item.item}" readonly></td>
                    <td><select class="form-control" disabled><option selected>${item.deno}</option></select></td>
                    <td><input type="number" class="form-control" value="${item.quantity}" readonly></td>
                    <td><input type="number" class="form-control" value="${item.unit_price}" readonly></td>
                    <td><input type="number" class="form-control" value="${item.total_price}" readonly></td>
                    <td class="text-center"><button type="button" class="btn btn-secondary btn-sm" disabled><i class="fas fa-ban"></i></button></td>
                </tr>`;
                });
                const totalField = document.getElementById('grand-total');
                if (totalField) totalField.value = grandTotal.toFixed(2);
            };

            const populateCompanies = (companies) => {
                const div = document.getElementById('company-participants');
                if (!div) return;

                if (companies?.length) {
                    companies.sort((a, b) => parseFloat(a.price) - parseFloat(b.price));
                    let tableRows = companies.map((c, index) => `
                <tr>
                    <td>${index + 1}</td>
                    <td>${c.name}</td>
                    <td>${c.price}</td>
                    <td>${['1st','2nd','3rd'][index] || `${index + 1}th`}</td>
                </tr>`).join('');

                    div.innerHTML = `
                <table class="table table-bordered">
                    <thead><tr><th>SL</th><th>Company</th><th>Price</th><th>Position</th></tr></thead>
                    <tbody>${tableRows}</tbody>
                </table>`;
                } else {
                    div.innerHTML = '<p class="text-muted">No participating companies found.</p>';
                }
            };

            const populateLetters = (letters, tableId) => {
                const tbody = document.getElementById(tableId);
                if (!tbody) return; // Exit if table not found

                tbody.innerHTML = '';
                letters = Array.isArray(letters) ? letters : [];

                if (letters.length > 0) {
                    letters.forEach(letter => {
                        tbody.innerHTML += `
                <tr>
                    <td>${letter.sl || ''}</td>
                    <td>${letter.reference_no || ''}</td>
                    <td>${letter.remarks || ''}</td>
                    <td>${letter.value || ''}</td>
                    <td class="text-center">${letter.date || ''}</td>
                    <td class="text-center">
                        ${letter.document 
                            ? `<a href="${letter.document}" target="_blank" class="btn btn-sm btn-primary">
                                                                                                                                                                                                                                                                                        <i class="fas fa-file-pdf"></i>
                                                                                                                                                                                                                                                                                       </a>` 
                            : '<span class="text-muted">No file</span>'
                        }
                    </td>
                </tr>
            `;
                    });
                } else {
                    tbody.innerHTML = `
                    <tr><td colspan="6" class="text-center text-muted">No letters uploaded yet.</td></tr>
                `;
                }
            };

            // ==============================
            // FETCH & POPULATE DATA
            // ==============================
            tenderSelect?.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const awardedId = selectedOption.getAttribute('data-awarded-id') || '';
                tenderParticipateInput.value = awardedId;
                resetState();
                if (!awardedId) return;

                fetch(`/get-tender-awarded-details/${awardedId}`)
                    .then(res => res.json())
                    .then(data => {
                        console.log('Fetched data:', data); // <-- Debug: check letters array

                        if (data.error || data.message) return alert(data.error || data.message);

                        populateTenderFields(data);
                        populateItems(data.items);
                        populateCompanies(data.companies);

                        if (data.is_bg == 1) {
                            bgYes.checked = true;
                            showBGFields();
                            populateBGFields(data.bg);
                        } else {
                            bgNo.checked = true;
                            hideBGFields();
                        }
                        disableBgRadios();

                        if (data.is_pg == 1) {
                            pgYes.checked = true;
                            showPGFields();
                            populatePGFields(data.pg);
                        } else {
                            pgNo.checked = true;
                            hidePGFields();
                        }
                        disablePgRadios();

                        if (!deliveryTypeSelect) return;
                        deliveryTypeSelect.value = data.delivery_type || '';
                        firstDeliverySection.style.display = 'none';
                        partialDeliverySection.style.display = 'none';
                        partialDeliveryTableBody.innerHTML = '';

                        if (data.delivery_type == '1' && data.single_delivery) {
                            firstDeliverySection.style.display = 'block';
                            document.querySelector('input[name="deliveries[0][delivery_item]"]').value =
                                data.single_delivery.delivery_item || '';
                            document.querySelector('input[name="deliveries[0][delivery_date]"]').value =
                                data.single_delivery.delivery_date || '';
                            document.querySelector('select[name="deliveries[0][warranty]"]').value =
                                data.single_delivery.warranty || '';
                            document.querySelectorAll(
                                    '#first_delivery_section input, #first_delivery_section select')
                                .forEach(el => el.setAttribute('disabled', true));
                        } else if (data.delivery_type == 'partial' && Array.isArray(data
                                .partial_deliveries)) {
                            partialDeliverySection.style.display = 'block';
                            data.partial_deliveries.forEach((delivery, index) => {
                                partialDeliveryTableBody.innerHTML += `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td><input type="text" name="partial_deliveries[${index}][delivery_item]" class="form-control" value="${delivery.delivery_item || ''}" disabled></td>
                            <td><input type="date" name="partial_deliveries[${index}][delivery_date]" class="form-control" value="${delivery.delivery_date || ''}" disabled></td>
                            <td>
                                <select name="partial_deliveries[${index}][warranty]" class="form-control" disabled>
                                    <option value="">-- Select --</option>
                                    ${['7 days','30 days','45 days','60 days','90 days','6 months','12 months','2 years','3 years'].map(w => `<option ${delivery.warranty==w?'selected':''}>${w}</option>`).join('')}
                                </select>
                            </td>
                            <td class="text-center"><button type="button" class="btn btn-danger btn-sm" disabled>Remove</button></td>
                        </tr>`;
                            });
                        }

                        // Populate both letters tables
                        populateLetters(data.participate_letters, 'participateLettersTable');
                        populateLetters(data.awarded_letters, 'awardedLettersTable');
                    })
                    .catch(err => {
                        console.error('Fetch error:', err);
                        alert('Failed to load tender details.');
                    });
            });

        });
    </script>

    <script>
        function toggleChallanFields() {
            const isDelivered = document.querySelector('input[name="is_delivered"]:checked');
            const challanFields = document.querySelectorAll('.challan-field');

            challanFields.forEach(field => {
                field.style.display = (isDelivered && isDelivered.value === "1") ? 'block' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleChallanFields();
            document.querySelectorAll('input[name="is_delivered"]').forEach(radio => {
                radio.addEventListener('change', toggleChallanFields);
            });
        });
    </script>
    <script>
        function toggleBillSubmitFields() {
            const isDelivered = document.querySelector('input[name="is_bill_submitted"]:checked');
            const billSubmitFields = document.querySelectorAll('.bill-submit-field');

            billSubmitFields.forEach(field => {
                field.style.display = (isDelivered && isDelivered.value === "1") ? 'block' : 'none';
            });
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleBillSubmitFields();

            document.querySelectorAll('input[name="is_bill_submitted"]').forEach(radio => {
                radio.addEventListener('change', toggleBillSubmitFields);
            });
        });
    </script>

    <script>
        function toggleInspectionCompleteFields() {
            const isDelivered = document.querySelector('input[name="is_inspection_completed"]:checked');
            const inspectionCompleteFields = document.querySelectorAll('.inspection-complete-field');

            inspectionCompleteFields.forEach(field => {
                field.style.display = (isDelivered && isDelivered.value === "1") ? 'block' : 'none';
            });
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleInspectionCompleteFields();

            document.querySelectorAll('input[name="is_inspection_completed"]').forEach(radio => {
                radio.addEventListener('change', toggleInspectionCompleteFields);
            });
        });
    </script>

    <script>
        function toggleInspectionAcceptFields() {
            const isDelivered = document.querySelector('input[name="is_inspection_accepted"]:checked');
            const inspectionAcceptFields = document.querySelectorAll('.inspection-accept-field');

            inspectionAcceptFields.forEach(field => {
                field.style.display = (isDelivered && isDelivered.value === "1") ? 'block' : 'none';
            });
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleInspectionAcceptFields();

            document.querySelectorAll('input[name="is_inspection_accepted"]').forEach(radio => {
                radio.addEventListener('change', toggleInspectionAcceptFields);
            });
        });
    </script>

    <script>
        function toggleBillReceiveFields() {
            const isDelivered = document.querySelector('input[name="is_bill_received"]:checked');
            const billReceiveFields = document.querySelectorAll('.bill-receive-fields');

            billReceiveFields.forEach(field => {
                field.style.display = (isDelivered && isDelivered.value === "1") ? 'block' : 'none';
            });
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleBillReceiveFields();

            document.querySelectorAll('input[name="is_bill_received"]').forEach(radio => {
                radio.addEventListener('change', toggleBillReceiveFields);
            });
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
