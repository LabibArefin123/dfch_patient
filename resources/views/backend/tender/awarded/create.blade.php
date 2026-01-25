@extends('adminlte::page')
@section('title', 'Add Awarded Tender')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Create Awarded Tenders</h1>
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

    <form action="{{ route('awarded_tenders.store') }}" method="POST" id="awardedForm" enctype="multipart/form-data" data-confirm="create">
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

        <div class="tab-content py-4" id="editTabContent">
            <div class="tab-pane fade show active" id="tenderPane" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>PG:</label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_pg" id="pg_no"
                                            value="0" {{ old('is_pg') == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pg_no">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_pg" id="pg_yes"
                                            value="1" {{ old('is_pg') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pg_yes">Yes</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="tender_no">Tender Number <span class="text-danger">*</span></label>
                                <select name="tender_id" id="tenderNo" class="form-control">
                                    <option value="">-- Select Tender Number --</option>
                                    @foreach ($participateTenders as $pt)
                                        <option value="{{ $pt->tender->id }}" data-participate-id="{{ $pt->id }}"
                                            {{ old('tender_id') == $pt->tender->id ? 'selected' : '' }}>
                                            {{ $pt->tender->tender_no }} - {{ $pt->tender->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="tender_participate_id" id="tender_participate_id"
                                    value="{{ old('tender_participate_id') }}">
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
                                <label for="financial_year" class="form-label">Financial Year <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="financial_year" id="financial_year" class="form-control"
                                    placeholder="Enter Financial Year" value="{{ old('financial_year') }}" readonly>
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

                            <div class="form-group col-md-6">
                                <label>BG:</label>
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

                            <div id="bg-field-wrapper" style="display: none;">
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
                                            <th width="5%">SL</th> <!-- Added SL Column -->
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
                                                <td>{{ $index + 1 }}</td> <!-- SL Number -->
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
                                            <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
                                            <td colspan="2">
                                                <input type="number" id="grand-total" class="form-control"
                                                    value="{{ number_format($grandTotal ?? 0, 2, '.', '') }}" readonly>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
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

                            <div class="form-group col-md-6">
                                <label for="workorder_no">Work Order No/NOA No <span class="text-danger">*</span></label>
                                <input type="text" name="workorder_no" id="workorder_no" class="form-control"
                                    value="{{ old('workorder_no') }}">
                                @error('workorder_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="workorder_no">Work Order/NOA Date <span class="text-danger">*</span></label>
                                <input type="date" name="workorder_date" id="workorder_date" class="form-control"
                                    value="{{ old('workorder_date') }}">
                                @error('workorder_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="workorder_doc">Work Order No/NOA Document <span
                                        class="text-danger">*</span></label>
                                <input type="file" name="workorder_doc" class="form-control">
                            </div>


                            <div class="form-group col-md-12">
                                <label>Tender's Participate Company</label>
                                <div id="company-participants">
                                    <p class="text-muted">Please select a tender to view participant company.</p>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="awarded_date">Delivery Date <span class="text-danger">*</span></label>
                                <input type="date" name="awarded_date" id="awarded_date" class="form-control"
                                    value="{{ old('awarded_date') }}">
                                @error('awarded_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="delivery_type">Delivery Type <span class="text-danger">*</span></label>
                                <select name="delivery_type" id="delivery_type" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option value="1" {{ old('delivery_type') == '1' ? 'selected' : '' }}>Single
                                    </option>
                                    <option value="partial" {{ old('delivery_type') == 'partial' ? 'selected' : '' }}>
                                        Multiple</option>
                                </select>
                                @error('delivery_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <div id="first_delivery_section" style="display: none;" class="form-group col-md-12">
                                <h5 class="mt-4">Delivery Information (Single)</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Delivery Item </th>
                                            <th>Delivery Date</th>
                                            <th>Warranty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
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
                                            <th>Sl</th>
                                            <th>Delivery Item</th>
                                            <th>Delivery Date</th>
                                            <th>Warranty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
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

            <div class="tab-pane fade" id="pgPane" role="tabpanel" aria-labelledby="pg-tab">
                {{-- BG Info Content --}}
                <div class="card mt-3">
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="pg_no">PG Number <span class="text-danger">*</span></label>
                            <input type="text" name="pg_no" class="form-control"
                                value="{{ old('pg_no', $tenderParticipate->pg->pg_no ?? '') }}">
                            @error('pg_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="issue_in_bank">Issue in Bank <span class="text-danger">*</span></label>
                            <input type="text" name="issue_in_bank" class="form-control"
                                value="{{ old('issue_in_bank', $tenderParticipate->pg->issue_in_bank ?? '') }}">
                            @error('issue_in_bank')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="issue_in_branch">Issue in Branch <span class="text-danger">*</span></label>
                            <input type="text" name="issue_in_branch" class="form-control"
                                value="{{ old('issue_in_branch', $tenderParticipate->pg->issue_in_branch ?? '') }}">
                            @error('issue_in_branch')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="issue_date">PG Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="issue_date" class="form-control"
                                value="{{ old('issue_date', $tenderParticipate->pg->issue_date ?? '') }}">
                            @error('issue_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="expiry_date">PG Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" name="expiry_date" class="form-control"
                                value="{{ old('expiry_date', $tenderParticipate->pg->expiry_date ?? '') }}">
                            @error('expiry_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="amount">PG Amount <span class="text-danger">*</span></label>
                            <input type="number" name="amount" step="0.01" class="form-control"
                                value="{{ old('amount', $tenderParticipate->pg->amount ?? '') }}">
                            @error('amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="attachment">Attachment <span class="text-danger">*</span></label><br>
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
        document.getElementById('tenderNo').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const participateId = selectedOption.getAttribute('data-participate-id');
            document.getElementById('tender_participate_id').value = participateId ?? '';
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tenderSelect = document.getElementById('tenderNo');
            const tenderParticipateInput = document.getElementById('tender_participate_id');

            const bgYes = document.getElementById('bg_yes');
            const bgNo = document.getElementById('bg_no');
            const bgFieldWrapper = document.getElementById('bg-field-wrapper');

            const pgYes = document.getElementById('pg_yes');
            const pgNo = document.getElementById('pg_no');
            const pgTabLi = document.getElementById('pg-tab-li');

            const deliveryTypeSelect = document.getElementById('delivery_type');
            const singleSection = document.getElementById('first_delivery_section');
            const partialSection = document.getElementById('partial_delivery_section');

            // Reset UI State
            const resetState = () => {
                if (pgNo) pgNo.checked = true;
                pgTabLi.style.display = 'none';
                bgYes.checked = false;
                bgNo.checked = false;
                bgFieldWrapper.style.display = 'none';
                singleSection.style.display = 'none';
                partialSection.style.display = 'none';
            };

            // Populate Tender Fields
            const populateTenderFields = (data) => {
                const fields = [
                    'title', 'offer_no', 'offer_date', 'offer_validity', 'procuring_authority',
                    'end_user', 'financial_year',
                    'tender_type', 'publication_date', 'submission_date'
                ];
                fields.forEach(id => {
                    document.getElementById(id).value = data[id] || '';
                });
                window.currentTenderTitle = data.title || '';
            };

            // Populate BG Fields
            const populateBGFields = (bg) => {
                if (!bg) return;
                const map = {
                    bg_no: 'bg_no_field',
                    issue_in_bank: 'issue_in_bank_field',
                    issue_in_branch: 'issue_in_branch_field',
                    issue_date: 'issue_date_field',
                    expiry_date: 'expiry_date_field',
                    amount: 'amount_field'
                };
                Object.keys(map).forEach(key => {
                    document.getElementById(map[key]).value = bg[key] || '';
                });

                document.getElementById('attachment_link_wrapper').innerHTML = bg.attachment ?
                    `<a href="/uploads/documents/bg_attachments/${bg.attachment}" target="_blank">View Current Attachment</a>` :
                    '<span class="text-muted">No attachment available</span>';
            };

            // Populate Items
            const populateItems = (items) => {
                const tbody = document.getElementById('item-tbody');
                tbody.innerHTML = '';
                let grandTotal = 0;
                const parsedItems = Array.isArray(items) ? items : JSON.parse(items || '[]');

                parsedItems.forEach((item, index) => {
                    grandTotal += parseFloat(item.total_price || 0);
                    tbody.innerHTML += `
                            <tr>
                                <td class="text-center align-middle">${index + 1}</td>
                                <td><input type="text" name="items[${index}][item]" class="form-control" value="${item.item}" readonly></td>
                                <td><select class="form-control" disabled><option selected>${item.deno}</option></select></td>
                                <td><input type="number" name="items[${index}][quantity]" class="form-control" value="${item.quantity}" readonly></td>
                                <td><input type="number" name="items[${index}][unit_price]" class="form-control" value="${item.unit_price}" readonly></td>
                                <td><input type="number" name="items[${index}][total_price]" class="form-control" value="${item.total_price}" readonly></td>
                                <td class="text-center"><button type="button" class="btn btn-secondary btn-sm" disabled><i class="fas fa-ban"></i></button></td>
                            </tr>
                        `;
                });

                document.getElementById('grand-total').value = grandTotal.toFixed(2);

                // Auto-fill for single item
                if (parsedItems.length === 1) {
                    deliveryTypeSelect.value = '1';
                    singleSection.style.display = 'block';
                    partialSection.style.display = 'none';
                    document.querySelector('input[name="deliveries[0][delivery_item]"]').value =
                        document.getElementById('title')?.value || parsedItems[0].item || '';
                }
            };

            // Populate Companies
            const populateCompanies = (companies) => {
                const container = document.getElementById('company-participants');
                if (!Array.isArray(companies) || companies.length === 0) {
                    container.innerHTML = '<p class="text-muted">No participating companies found.</p>';
                    return;
                }
                companies.sort((a, b) => parseFloat(a.price) - parseFloat(b.price));
                container.innerHTML = `
            <table class="table table-bordered">
                <thead>
                    <tr><th>SL</th><th>Company</th><th>Price</th><th>Position</th></tr>
                </thead>
                <tbody>
                    ${companies.map((c, i) => `
                                    <tr>
                                        <td>${i + 1}</td>
                                        <td>${c.name}</td>
                                        <td>${c.price}</td>
                                        <td>${['1st','2nd','3rd'][i] || `${i+1}th`}</td>
                                    </tr>
                                `).join('')}
                </tbody>
            </table>
        `;
            };

            // Populate Participate Letters
            const populateLetters = (letters) => {
                const tbody = document.getElementById('participateLettersTable');
                tbody.innerHTML = '';
                if (letters.length > 0) {
                    letters.forEach(letter => {
                        tbody.innerHTML += `
                    <tr>
                        <td>${letter.sl}</td>
                        <td>${letter.reference_no}</td>
                        <td>${letter.remarks}</td>
                        <td>${letter.value}</td>
                        <td class="text-center">${letter.date}</td>
                        <td class="text-center">
                            <a href="${letter.document}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </td>
                    </tr>
                `;
                    });
                } else {
                    tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted">No letters uploaded yet.</td>
                </tr>
            `;
                }
            };

            // Handle PG toggle
            document.querySelectorAll('input[name="is_pg"]').forEach(radio => {
                radio.addEventListener('change', () => {
                    pgTabLi.style.display = radio.value === '1' ? 'block' : 'none';
                });
                if (radio.checked && radio.value === '1') {
                    pgTabLi.style.display = 'block';
                }
            });

            // Handle delivery type toggle
            deliveryTypeSelect.addEventListener('change', () => {
                singleSection.style.display = deliveryTypeSelect.value === '1' ? 'block' : 'none';
                partialSection.style.display = deliveryTypeSelect.value === 'partial' ? 'block' : 'none';
            });

            // Main tender load
            tenderSelect?.addEventListener('change', function() {
                const tenderId = this.value;
                const participateId = this.options[this.selectedIndex].getAttribute(
                    'data-participate-id') || '';
                tenderParticipateInput.value = participateId;
                resetState();
                if (!tenderId) return;

                fetch(`/get-tender-participate-details/${tenderId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.error || data.message) {
                            alert(data.error || data.message);
                            return;
                        }
                        populateTenderFields(data);
                        populateItems(data.items);
                        populateCompanies(data.companies);

                        if (data.is_bg === 1) {
                            bgYes.checked = true;
                            bgFieldWrapper.style.display = 'block';
                            populateBGFields(data.bg);
                        } else {
                            bgNo.checked = true;
                            bgFieldWrapper.style.display = 'none';
                        }
                        bgYes.disabled = true;
                        bgNo.disabled = true;

                        populateLetters(data.letters); // ✅ Load letters with same fetch
                    })
                    .catch(err => {
                        console.error('Fetch error:', err);
                        alert('Failed to load tender details.');
                    });
            });

            // Auto-load previous tender if exists
            if (tenderSelect?.value) {
                tenderSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('awardedForm');
            const deliveryTypeSelect = document.getElementById('delivery_type');
            const firstDeliverySection = document.getElementById('first_delivery_section');
            const partialDeliverySection = document.getElementById('partial_delivery_section');
            const submissionDateInput = document.getElementById('submission_date');
            const workorderInput = document.getElementById('workorder_date');
            const awardedInput = document.getElementById('awarded_date');
            const errorBox = document.getElementById('dateErrorBox');

            const requiredFields = ['tender_participate_id', 'workorder_no', 'workorder_date', 'awarded_date'];
            let isFormDirty = false;
            let partialIndex = 0;

            const showDateError = (message) => {
                if (!errorBox) return;
                errorBox.querySelector('p').textContent = message;
                errorBox.style.display = 'block';
                errorBox.classList.remove('animate__fadeOutUp');
                errorBox.classList.add('animate__animated', 'animate__fadeInDown');

                setTimeout(() => {
                    errorBox.classList.remove('animate__fadeInDown');
                    errorBox.classList.add('animate__fadeOutUp');
                    setTimeout(() => errorBox.style.display = 'none', 800);
                }, 4000);
            };

            deliveryTypeSelect?.addEventListener('change', function() {
                const type = this.value;
                firstDeliverySection.style.display = (type === '1') ? 'block' : 'none';
                partialDeliverySection.style.display = (type === 'partial') ? 'block' : 'none';

                if (type === 'partial') {
                    const tbody = document.querySelector('#partial_delivery_table tbody');
                    if (tbody && tbody.children.length === 0) {
                        addPartialDeliveryRow();
                    }
                }
            });

            window.addPartialDeliveryRow = () => {
                const tbody = document.querySelector('#partial_delivery_table tbody');
                if (!tbody) return;

                const rowCount = tbody.children.length; // current row count
                const sl = rowCount + 1; // SL number for new row

                const row = document.createElement('tr');
                row.innerHTML = `
                <td class="sl">${sl}</td>
                <td><input type="text" name="partial_deliveries[${partialIndex}][delivery_item]" class="form-control"></td>
                <td><input type="date" name="partial_deliveries[${partialIndex}][delivery_date]" class="form-control"></td>
                <td>
                    <select name="partial_deliveries[${partialIndex}][warranty]" class="form-control">
                        <option value="">-- Select --</option>
                        <option>7 days</option><option>30 days</option><option>45 days</option>
                        <option>60 days</option><option>90 days</option><option>6 months</option>
                        <option>12 months</option><option>2 years</option><option>3 years</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removePartialDeliveryRow(this)">Remove</button>
                </td>
    `;
                tbody.appendChild(row);
                partialIndex++;
            };

            // Function to remove row and re-index SL
            window.removePartialDeliveryRow = (btn) => {
                const row = btn.closest('tr');
                row.remove();

                // Re-index SL numbers
                document.querySelectorAll('#partial_delivery_table tbody tr').forEach((tr, i) => {
                    tr.querySelector('.sl').textContent = i + 1;
                });
            };
        });
    </script>

@endsection
