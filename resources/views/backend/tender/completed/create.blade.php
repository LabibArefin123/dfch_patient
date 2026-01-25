@extends('adminlte::page')
@section('title', 'Add Completed Tender')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Create Completed Tenders</h1>
        <a href="{{ route('completed_tenders.index') }}"
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
    <form action="{{ route('completed_tenders.store') }}" method="POST" id="completedForm">
        @csrf
        <div class="tab-pane fade show active p-2" id="tender" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="tender_progress_id">Tender Number <span class="text-danger">*</span></label>
                            <select name="tender_progress_id" id="tenderNo" class="form-control">
                                <option value="">-- Select Tender Number --</option>
                                @foreach ($progressTenders as $ct)
                                    <option value="{{ $ct->tenderAwarded->id }}" data-awarded-id="{{ $ct->id }}"
                                        {{ old('tender_progress_id') == $ct->tender_progress_id ? 'selected' : '' }}>
                                        {{ $ct->tenderAwarded->tenderParticipate->tender->tender_no }} -
                                        ({{ $ct->tenderAwarded->tenderParticipate->tender->title }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="tender_progress_id" id="tender_progress_id"
                                value="{{ old('tender_progress_id') }}">
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
                            <label for="procuring_authority">Procurring Authority <span class="text-danger">*</span></label>
                            <input type="text" name="procuring_authority" id="procuring_authority" class="form-control"
                                readonly value="{{ old('procuring_authority') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="end_user">End User <span class="text-danger">*</span></label>
                            <input type="text" name="end_user" id="end_user" class="form-control" readonly
                                value="{{ old('end_user') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="financial_year_display">FY (Financial Year) <span
                                    class="text-danger">*</span></label>

                            <select id="financial_year_display" class="form-control" disabled>
                                <option value="">Select Financial Year</option>
                                @for ($year = 2026; $year >= 2005; $year--)
                                    @php $fy = $year . '-' . ($year + 1); @endphp
                                    <option value="{{ $fy }}"
                                        {{ old('financial_year') == $fy ? 'selected' : '' }}>
                                        {{ $fy }}
                                    </option>
                                @endfor
                            </select>

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
                                    @foreach ($items ?? [['item' => '', 'deno' => '', 'quantity' => '', 'unit_price' => '', 'total_price' => '']] as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><input type="text" name="items[{{ $index }}][item]"
                                                    class="form-control" value="{{ $item['item'] }}" readonly></td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][deno]"
                                                    class="form-control" value="{{ $item['deno'] }}" readonly>
                                            </td>
                                            <td><input type="number" name="items[{{ $index }}][quantity]"
                                                    class="form-control" value="{{ $item['quantity'] }}" readonly></td>
                                            <td><input type="number" name="items[{{ $index }}][unit_price]"
                                                    class="form-control" value="{{ $item['unit_price'] }}" readonly></td>
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

                        <div class="form-group col-md-12">
                            <label>Tender Participate Company</label>
                            <div class="tab-content" id="participates-tabContent">
                                <p class="text-muted">Please select a tender to view participants.</p>
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

                        <div class="form-group col-md-6">
                            <label>Is Bid Guarantee (BG)?</label><br>
                            <div>
                                <label><input type="radio" id="is_bg_yes" name="is_bg" disabled> Yes</label>
                                <label class="ml-3"><input type="radio" id="is_bg_no" name="is_bg" disabled>
                                    No</label>
                            </div>
                        </div>

                        <div class="w-100"></div>

                        <div id="bg-field-wrapper" style="display: none;">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bg_no_field">BG Number</label>
                                    <input type="text" id="bg_no_field" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="bg_issue_in_bank_field">Issue in Bank</label>
                                    <input type="text" id="bg_issue_in_bank_field" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="bg_issue_in_branch_field">Issue in Branch</label>
                                    <input type="text" id="bg_issue_in_branch_field" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="bg_issue_date_field">BG Issue Date</label>
                                    <input type="date" id="bg_issue_date_field" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="bg_expiry_date_field">BG Expiry Date</label>
                                    <input type="date" id="bg_expiry_date_field" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="bg_amount_field">BG Amount</label>
                                    <input type="number" id="bg_amount_field" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>BG Attachment</label><br>
                                    <span id="bg_attachment_link_wrapper">
                                        <span class="text-muted">No attachment available</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="workorder_no">Work Order No/NOA No <span class="text-danger">*</span></label>
                            <input type="text" name="workorder_no" id="workorder_no" class="form-control"
                                value="{{ old('workorder_no') }}" readonly>
                            @error('workorder_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="workorder_date">Work Order/NOA Date <span class="text-danger">*</span></label>
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
                            <label for="delivery_type">Delivery Type <span class="text-danger">*</span></label>
                            <select name="delivery_type" id="delivery_type" class="form-control" readonly>
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
                                <button type="button" class="btn btn-success btn-sm" onclick="addPartialDeliveryRow()">+
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

                        {{-- Is PG? --}}
                        <div class="form-group col-md-6">
                            <label>Is Performance Guarantee(PG)?</label><br>
                            <div>
                                <label><input type="radio" id="is_pg_yes" name="is_pg" disabled> Yes</label>
                                <label class="ml-3"><input type="radio" id="is_pg_no" name="is_pg" disabled>
                                    No</label>
                            </div>
                        </div>

                        {{-- PG Section --}}
                        <div id="pg-field-wrapper" style="display: none;">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="pg_no_field">PG Number</label>
                                    <input type="text" id="pg_no_field" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pg_issue_in_bank_field">Issue in Bank</label>
                                    <input type="text" id="pg_issue_in_bank_field" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pg_issue_in_branch_field">Issue in Branch</label>
                                    <input type="text" id="pg_issue_in_branch_field" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pg_issue_date_field">PG Issue Date</label>
                                    <input type="date" id="pg_issue_date_field" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pg_expiry_date_field">PG Expiry Date</label>
                                    <input type="date" id="pg_expiry_date_field" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pg_amount_field">PG Amount</label>
                                    <input type="number" id="pg_amount_field" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>PG Attachment</label><br>
                                    <span id="pg_attachment_link_wrapper">
                                        <span class="text-muted">No attachment available</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>

                        <div class="form-group col-md-6">
                            <label>Is Delivered?</label><br>
                            <div>
                                <label><input type="radio" id="is_delivered_yes" name="is_delivered" disabled>
                                    Yes</label>
                                <label class="ml-3"><input type="radio" id="is_delivered_no" name="is_delivered"
                                        disabled>
                                    No</label>
                            </div>
                        </div>

                        <div class="w-100"></div>

                        {{-- Challan Section from Is Delivered --}}
                        <div class="form-group col-md-6">
                            <label for="challan_no">Challan Number</label>
                            <input type="text" id="challan_no" class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="challan_date">Challan Date</label>
                            <input type="date" id="challan_date" class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Challan Doc Attachment</label><br>
                            <span id="challan_attachment_link_wrapper">
                                <span class="text-muted">No attachment available</span>
                            </span>
                        </div>

                        <div class="w-100"></div>

                        <div class="form-group col-md-6">
                            <label>Is Inspection Completed?</label><br>
                            <div>
                                <label><input type="radio" id="is_inspection_complete_yes"
                                        name="is_inspection_completed" disabled>
                                    Yes</label>
                                <label class="ml-3"><input type="radio" id="is_inspection_complete_no"
                                        name="is_inspection_completed" disabled>
                                    No</label>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inspection_complete_date">Inspection Complete Date</label>
                            <input type="date" id="inspection_complete_date" class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Is Inspection Accepted?</label><br>
                            <div>
                                <label><input type="radio" id="is_inspection_accept_yes" name="is_inspection_accepted"
                                        disabled>
                                    Yes</label>
                                <label class="ml-3"><input type="radio" id="is_inspection_accept_no"
                                        name="is_inspection_accepted" disabled>
                                    No</label>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inspection_accept_date">Inspection Accept Date</label>
                            <input type="date" id="inspection_accept_date" class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Is Bill Submitted?</label><br>
                            <div>
                                <label><input type="radio" id="is_bill_submit_yes" name="is_bill_submitted" disabled>
                                    Yes</label>
                                <label class="ml-3"><input type="radio" id="is_bill_submit_no"
                                        name="is_bill_submitted" disabled>
                                    No</label>
                            </div>
                        </div>

                        <div class="w-100"></div>

                        {{-- Challan Section from Is Delivered --}}
                        <div class="form-group col-md-6">
                            <label for="bill_no">Bill Number</label>
                            <input type="text" id="bill_no" class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="bill_submit_date">Bill Date</label>
                            <input type="date" id="bill_submit_date" class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Bill Document</label><br>
                            <span id="bill_attachment_link_wrapper">
                                <span class="text-muted">No attachment available</span>
                            </span>
                        </div>

                        <div class="w-100"></div>

                        <div class="form-group col-md-6">
                            <label>Is Bill Received?</label><br>
                            <div>
                                <label><input type="radio" id="is_bill_receive_yes" name="is_bill_received" disabled>
                                    Yes</label>
                                <label class="ml-3"><input type="radio" id="is_bill_receive_no"
                                        name="is_bill_received" disabled>
                                    No</label>
                            </div>
                        </div>

                        <div class="w-100"></div>

                        <div class="form-group col-md-6">
                            <label for="bill_cheque_no">Bill Cheque No</label>
                            <input type="text" id="bill_cheque_no" class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="bill_receive_date">Bill Received Date</label>
                            <input type="date" id="bill_receive_date" class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="bill_amount">Bill Amount</label>
                            <input type="text" id="bill_amount" class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="bill_bank_name">Bill Bank Name</label>
                            <input type="text" id="bill_bank_name" class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-12">
                            <strong>Progress Tender's Correspondence</strong>
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
                                <tbody id="progressLettersTable">
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No letters uploaded yet.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="w-100"></div>
                        <div class="form-group col-md-6">
                            <label>Is Warranty Complete? <span class="text-danger">*</span></label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_warranty_complete"
                                        id="warranty_complete_no" value="0"
                                        {{ old('is_warranty_complete') == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="warranty_complete_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_warranty_complete"
                                        id="warranty_complete_yes" value="1"
                                        {{ old('is_warranty_complete') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="warranty_complete_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div id="warranty-complete-fields" class="form-group col-md-6" style="display: none;">
                            <label for="warranty_complete_date">Warranty Complete Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="warranty_complete_date" id="warranty_complete_date"
                                class="form-control" value="{{ old('warranty_complete_date') }}">
                            @error('warranty_complete_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="w-100"></div>
                        <div class="form-group col-md-6">
                            <label>Is Service Warranty? <span class="text-danger">*</span></label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_service_warranty"
                                        id="service_warranty_no" value="0"
                                        {{ old('is_service_warranty') == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="service_warranty_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_service_warranty"
                                        id="service_warranty_yes" value="1"
                                        {{ old('is_service_warranty') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="service_warranty_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div id="service-warranty-fields" class="form-group col-md-6" style="display: none;">
                            <label for="service_warranty_duration">Service Warranty Duration <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="service_warranty_duration" id="service_warranty_duration"
                                class="form-control" value="{{ old('service_warranty_duration') }}">
                            @error('service_warranty_duration')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group col-12 mt-4" style="text-align: right;">
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
    </form>

@endsection
@section('js')


    <script>
        document.getElementById('tenderNo').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const awardedId = selectedOption.getAttribute('data-awarded-id');
            document.getElementById('tender_progress_id').value = awardedId ?? '';
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tenderNoSelect = document.getElementById('tenderNo');
            const awardedIdInput = document.getElementById('tender_progress_id');
            const itemTbody = document.getElementById('item-tbody');
            const grandTotalInput = document.getElementById('grand-total');
            const participateWrapper = document.getElementById('participates-tabContent');

            const bgWrapper = document.getElementById('bg-field-wrapper');
            const pgWrapper = document.getElementById('pg-field-wrapper');

            const isBgYes = document.getElementById('is_bg_yes');
            const isBgNo = document.getElementById('is_bg_no');
            const isPgYes = document.getElementById('is_pg_yes');
            const isPgNo = document.getElementById('is_pg_no');

            const isDeliveredYes = document.getElementById('is_delivered_yes');
            const isDeliveredNo = document.getElementById('is_delivered_no');
            const isInspectionCompleteYes = document.getElementById('is_inspection_complete_yes');
            const isInspectionCompleteNo = document.getElementById('is_inspection_complete_no');
            const isInspectionAcceptYes = document.getElementById('is_inspection_accept_yes');
            const isInspectionAcceptNo = document.getElementById('is_inspection_accept_no');
            const isBillSubmitYes = document.getElementById('is_bill_submit_yes');
            const isBillSubmitNo = document.getElementById('is_bill_submit_no');
            const isBillReceivedYes = document.getElementById('is_bill_receive_yes');
            const isBillReceivedNo = document.getElementById('is_bill_receive_no');

            tenderNoSelect?.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const participateId = this.value;
                const awardedId = selectedOption.getAttribute('data-awarded-id') || '';
                awardedIdInput.value = awardedId;

                if (!participateId) return;

                fetch(`/get-tender-awarded-progress-details/${participateId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.message) {
                            alert(data.message);
                            return;
                        }

                        console.log('Tender Details:', data);

                        // Set input fields
                        const fields = [
                            'title', 'offer_no', 'offer_date', 'offer_validity',
                            'procuring_authority',
                            'end_user',
                            'publication_date', 'submission_date', 'workorder_no',
                            'workorder_date', 'awarded_date', 'tender_type', 'challan_no',
                            'challan_date', 'inspection_complete_date', 'inspection_accept_date',
                            'bill_no', 'bill_submit_date', 'bill_cheque_no', 'bill_receive_date',
                            'bill_amount', 'bill_bank_name',
                        ];
                        fields.forEach(id => {
                            const el = document.getElementById(id);
                            if (el) el.value = data[id] || '';
                        });

                        // Set financial year
                        const fyInput = document.getElementById('financial_year');
                        const fySelect = document.getElementById('financial_year_display');
                        fyInput.value = data.financial_year || '';
                        if (fySelect) {
                            Array.from(fySelect.options).forEach(opt => {
                                opt.selected = opt.value === data.financial_year;
                            });
                        }

                        // Set delivery type
                        const deliverySelect = document.getElementById('delivery_type');
                        if (deliverySelect) {
                            Array.from(deliverySelect.options).forEach(opt => {
                                opt.selected = opt.value === data.delivery_type;
                            });
                        }

                        const firstDeliverySection = document.getElementById('first_delivery_section');
                        const partialDeliverySection = document.getElementById(
                            'partial_delivery_section');
                        const partialDeliveryTableBody = document.querySelector(
                            '#partial_delivery_table tbody');

                        if (deliverySelect) {
                            Array.from(deliverySelect.options).forEach(opt => {
                                opt.selected = opt.value == data.delivery_type;
                            });

                            // Clear both sections first
                            firstDeliverySection.style.display = 'none';
                            partialDeliverySection.style.display = 'none';
                            partialDeliveryTableBody.innerHTML = '';

                            if (data.delivery_type == '1') {
                                // Single Delivery
                                firstDeliverySection.style.display = 'block';

                                if (data.single_delivery) {
                                    document.querySelector('input[name="deliveries[0][delivery_item]"]')
                                        .value =
                                        data.single_delivery.delivery_item || '';
                                    document.querySelector('input[name="deliveries[0][delivery_date]"]')
                                        .value =
                                        data.single_delivery.delivery_date || '';
                                    document.querySelector('select[name="deliveries[0][warranty]"]')
                                        .value =
                                        data.single_delivery.warranty || '';

                                    // Make all fields read-only
                                    document.querySelectorAll(
                                            '#first_delivery_section input, #first_delivery_section select'
                                        )
                                        .forEach(el => {
                                            el.setAttribute('disabled', true);
                                        });
                                }
                            } else if (data.delivery_type == 'partial') {
                                // Multiple Deliveries
                                partialDeliverySection.style.display = 'block';
                                if (Array.isArray(data.partial_deliveries) && data.partial_deliveries
                                    .length > 0) {
                                    data.partial_deliveries.forEach((delivery, index) => {
                                        partialDeliveryTableBody.innerHTML += `
                                    <tr>
                                        <td class="text-center">${index + 1}</td>
                                        <td><input type="text" name="partial_deliveries[${index}][delivery_item]" class="form-control" value="${delivery.delivery_item || ''}" disabled></td>
                                        <td><input type="date" name="partial_deliveries[${index}][delivery_date]" class="form-control" value="${delivery.delivery_date || ''}" disabled></td>
                                        <td>
                                            <select name="partial_deliveries[${index}][warranty]" class="form-control" disabled>
                                                <option value="">-- Select --</option>
                                                <option ${delivery.warranty == '7 days' ? 'selected' : ''}>7 days</option>
                                                <option ${delivery.warranty == '30 days' ? 'selected' : ''}>30 days</option>
                                                <option ${delivery.warranty == '45 days' ? 'selected' : ''}>45 days</option>
                                                <option ${delivery.warranty == '60 days' ? 'selected' : ''}>60 days</option>
                                                <option ${delivery.warranty == '90 days' ? 'selected' : ''}>90 days</option>
                                                <option ${delivery.warranty == '6 months' ? 'selected' : ''}>6 months</option>
                                                <option ${delivery.warranty == '12 months' ? 'selected' : ''}>12 months</option>
                                                <option ${delivery.warranty == '2 years' ? 'selected' : ''}>2 years</option>
                                                <option ${delivery.warranty == '3 years' ? 'selected' : ''}>3 years</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm" disabled>Remove</button>
                                        </td>
                                    </tr>
                                `;
                                    });
                                }
                            }

                            // Disable any main form action buttons

                        }

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

                        populateLetters(data.participate_letters, 'participateLettersTable');
                        populateLetters(data.awarded_letters, 'awardedLettersTable');
                        populateLetters(data.progress_letters, 'progressLettersTable');

                        // Render items
                        itemTbody.innerHTML = '';
                        let grandTotal = 0;
                        const items = Array.isArray(data.items) ? data.items : JSON.parse(data.items ||
                            '[]');

                        items.forEach((item, i) => {
                            grandTotal += parseFloat(item.total_price || 0);
                            itemTbody.innerHTML += `
                        <tr>
                            <td>${i + 1}</td>
                            <td><input type="text" name="items[${i}][item]" class="form-control" value="${item.item || ''}" readonly></td>
                            <td><input type="text" name="items[${i}][deno]" class="form-control" value="${item.deno || ''}" readonly></td>
                            <td><input type="number" name="items[${i}][quantity]" class="form-control" value="${item.quantity || ''}" readonly></td>
                            <td><input type="number" name="items[${i}][unit_price]" class="form-control" value="${item.unit_price || ''}" readonly></td>
                            <td><input type="number" name="items[${i}][total_price]" class="form-control" value="${item.total_price || ''}" readonly></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-secondary btn-sm" disabled>
                                    <i class="fas fa-ban"></i>
                                </button>
                            </td>
                        </tr>`;
                        });
                        grandTotalInput.value = grandTotal.toFixed(2);

                        // Render Participants
                        if (participateWrapper) {
                            if (Array.isArray(data.companies) && data.companies.length > 0) {
                                // Convert price string like "12000.00 ৳" to float for sorting
                                const sortedCompanies = data.companies.slice().sort((a, b) => {
                                    const priceA = parseFloat(a.price.replace(/[^\d.]/g, '')) ||
                                        0;
                                    const priceB = parseFloat(b.price.replace(/[^\d.]/g, '')) ||
                                        0;
                                    return priceA - priceB;
                                });

                                // Create table with headers
                                let tableHTML = `
                                <table class="table table-bordered table-striped table-sm">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 5%">SL</th>
                                            <th>Company Name</th>
                                            <th style="width: 30%">Offered Price</th>
                                            <th style="width: 20%">Position</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            `;

                                sortedCompanies.forEach((company, index) => {
                                    const positionText = index === 0 ? '1' : (index + 1);
                                    tableHTML += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${company.name}</td>
                                        <td>${company.price}</td>
                                        <td>${positionText}</td>
                                    </tr>
                                `;
                                });

                                tableHTML += `
                                    </tbody>
                                </table>
                            `;

                                participateWrapper.innerHTML = tableHTML;
                            } else {
                                participateWrapper.innerHTML =
                                    '<p class="text-muted">No participants found for this tender.</p>';
                            }
                        }

                        // Set Is BG? radios
                        if (data.is_bg == 1) {
                            isBgYes.checked = true;
                            isBgNo.checked = false;
                            bgWrapper.style.display = 'block';
                        } else {
                            isBgYes.checked = false;
                            isBgNo.checked = true;
                            bgWrapper.style.display = 'none';
                        }

                        if (data.is_delivered == 1) {
                            isDeliveredYes.checked = true;
                            isDeliveredNo.checked = false;
                            // bgWrapper.style.display = 'block';
                        } else {
                            isDeliveredYes.checked = false;
                            isDeliveredNo.checked = true;
                            // bgWrapper.style.display = 'none';
                        }

                        if (data.is_inspection_completed == 1) {
                            isInspectionCompleteYes.checked = true;
                            isInspectionCompleteNo.checked = false;
                            // bgWrapper.style.display = 'block';
                        } else {
                            isInspectionCompleteYes.checked = false;
                            isInspectionCompleteNo.checked = true;
                            // bgWrapper.style.display = 'none';
                        }

                        if (data.is_inspection_accepted == 1) {
                            isInspectionAcceptYes.checked = true;
                            isInspectionAcceptNo.checked = false;
                            // bgWrapper.style.display = 'block';
                        } else {
                            isInspectionAcceptYes.checked = false;
                            isInspectionAcceptNo.checked = true;
                            // bgWrapper.style.display = 'none';
                        }

                        if (data.is_bill_submitted == 1) {
                            isBillSubmitYes.checked = true;
                            isBillSubmitNo.checked = false;
                            // bgWrapper.style.display = 'block';
                        } else {
                            isBillSubmitYes.checked = false;
                            isBillSubmitNo.checked = true;
                            // bgWrapper.style.display = 'none';
                        }

                        if (data.is_bill_received == 1) {
                            isBillReceivedYes.checked = true;
                            isBillReceivedNo.checked = false;
                            // bgWrapper.style.display = 'block';
                        } else {
                            isBillReceivedYes.checked = false;
                            isBillReceivedNo.checked = true;
                            // bgWrapper.style.display = 'none';
                        }

                        const challanDocAttachment = document.getElementById(
                            'challan_attachment_link_wrapper');
                        challanDocAttachment.innerHTML = data.challan_doc ?
                            `<a href="/uploads/documents/challan_docs/${data.challan_doc}" target="_blank">View Attachment</a>` :
                            '<span class="text-muted">No attachment available</span>';

                        const billDocAttachment = document.getElementById(
                            'bill_attachment_link_wrapper');
                        billDocAttachment.innerHTML = data.challan_doc ?
                            `<a href="/uploads/documents/bill_docs/${data.bill_doc}" target="_blank">View Attachment</a>` :
                            '<span class="text-muted">No attachment available</span>';

                        // BG fields
                        if (data.bg) {
                            document.getElementById('bg_no_field').value = data.bg.bg_no || '';
                            document.getElementById('bg_issue_in_bank_field').value = data.bg
                                .issue_in_bank || '';
                            document.getElementById('bg_issue_in_branch_field').value = data.bg
                                .issue_in_branch || '';
                            document.getElementById('bg_issue_date_field').value = data.bg.issue_date ||
                                '';
                            document.getElementById('bg_expiry_date_field').value = data.bg
                                .expiry_date || '';
                            document.getElementById('bg_amount_field').value = data.bg.amount || '';

                            const bgAttachment = document.getElementById('bg_attachment_link_wrapper');
                            bgAttachment.innerHTML = data.bg.attachment ?
                                `<a href="/uploads/documents/bg_attachments/${data.bg.attachment}" target="_blank">View Attachment</a>` :
                                '<span class="text-muted">No attachment available</span>';
                        }

                        // Set Is PG? radios
                        if (data.is_pg == 1) {
                            isPgYes.checked = true;
                            isPgNo.checked = false;
                            pgWrapper.style.display = 'block';
                        } else {
                            isPgYes.checked = false;
                            isPgNo.checked = true;
                            pgWrapper.style.display = 'none';
                        }

                        // PG fields
                        if (data.pg) {
                            document.getElementById('pg_no_field').value = data.pg.pg_no || '';
                            document.getElementById('pg_issue_in_bank_field').value = data.pg
                                .issue_in_bank || '';
                            document.getElementById('pg_issue_in_branch_field').value = data.pg
                                .issue_in_branch || '';
                            document.getElementById('pg_issue_date_field').value = data.pg.issue_date ||
                                '';
                            document.getElementById('pg_expiry_date_field').value = data.pg
                                .expiry_date || '';
                            document.getElementById('pg_amount_field').value = data.pg.amount || '';

                            const pgAttachment = document.getElementById('pg_attachment_link_wrapper');
                            pgAttachment.innerHTML = data.pg.attachment ?
                                `<a href="/uploads/documents/pg_attachments/${data.pg.attachment}" target="_blank">View Attachment</a>` :
                                '<span class="text-muted">No attachment available</span>';
                        }

                    })
                    .catch(err => {
                        console.error('Fetch error:', err);
                        alert('Failed to fetch tender details.');
                    });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const submissionDateInput = document.getElementById('submission_date');
            const deliveryTypeSelect = document.getElementById('delivery_type');
            const firstDeliverySection = document.getElementById('first_delivery_section');
            const partialDeliverySection = document.getElementById('partial_delivery_section');
            const workorderInput = document.getElementById('workorder_date');
            const awardedInput = document.getElementById('awarded_date');
            const errorBox = document.getElementById('dateErrorBox');
            const form = document.getElementById('awardedForm');

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

                const row = document.createElement('tr');
                row.innerHTML = `
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
            <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove();">Remove</button></td>
        `;
                tbody.appendChild(row);
                partialIndex++;
            };

            form?.addEventListener('submit', function(e) {
                const workDate = new Date(workorderInput?.value);
                const awardedDate = new Date(awardedInput?.value);
                const submissionDate = submissionDateInput?.value ? new Date(submissionDateInput.value) :
                    null;

                if (awardedDate && workDate && awardedDate < workDate) {
                    e.preventDefault();
                    showDateError("Awarded Date cannot be before Work Order Date!");
                    return;
                }

                const oneTimeDeliveryInput = document.querySelector(
                    'input[name="deliveries[0][delivery_date]"]');
                if (submissionDate && oneTimeDeliveryInput?.value) {
                    const deliveryDate = new Date(oneTimeDeliveryInput.value);
                    if (deliveryDate < submissionDate) {
                        e.preventDefault();
                        showDateError("One-Time Delivery Date cannot be before Submission Date!");
                        return;
                    }
                }

                const partialDates = document.querySelectorAll(
                    'input[name^="partial_deliveries"][name$="[delivery_date]"]');
                for (const input of partialDates) {
                    if (submissionDate && input.value && new Date(input.value) < submissionDate) {
                        e.preventDefault();
                        showDateError(
                            "One or more Partial Delivery Dates cannot be before Submission Date!");
                        return;
                    }
                }
            });
        });
    </script>
    <script>
        function toggleWarrantyCompleteFields() {
            const isWarranty = document.querySelector('input[name="is_warranty_complete"]:checked');
            const warrantyCompleteFields = document.getElementById('warranty-complete-fields');

            if (isWarranty && isWarranty.value === "1") {
                warrantyCompleteFields.style.display = 'block';
            } else {
                warrantyCompleteFields.style.display = 'none';
            }
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleWarrantyCompleteFields();

            document.querySelectorAll('input[name="is_warranty_complete"]').forEach(function(radio) {
                radio.addEventListener('change', toggleWarrantyCompleteFields);
            });
        });
    </script>
    <script>
        function toggleServiceWarrantyFields() {
            const isServiceWarranty = document.querySelector('input[name="is_service_warranty"]:checked');
            const warrantyCompleteFields = document.getElementById('service-warranty-fields');

            if (isServiceWarranty && isServiceWarranty.value === "1") {
                warrantyCompleteFields.style.display = 'block';
            } else {
                warrantyCompleteFields.style.display = 'none';
            }
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleServiceWarrantyFields();

            document.querySelectorAll('input[name="is_service_warranty"]').forEach(function(radio) {
                radio.addEventListener('change', toggleServiceWarrantyFields);
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const isPgYes = document.getElementById('is_pg_yes');
            const expiryField = document.getElementById('pg_expiry_date_field');

            // Unique key for this tender/page to remember PG release
            const pgKey = 'pg_released_' + window.location.pathname;

            // Check PG Follow-up only if PG is Yes and not released before
            function checkPGFollowUp() {
                if (!isPgYes || !isPgYes.checked) return;
                if (!expiryField || !expiryField.value) return;
                if (localStorage.getItem(pgKey) === 'yes') return; // Already released, no popup

                const expiryDate = new Date(expiryField.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (today >= expiryDate) {
                    askPGRelease();
                }
            }

            function askPGRelease() {
                Swal.fire({
                    title: 'PG Follow-up',
                    text: 'Did you release the Performance Guarantee (PG)?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Released',
                    cancelButtonText: 'No, Not Yet',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.setItem(pgKey, 'yes'); // Mark as released
                        Swal.fire({
                            title: 'Great!',
                            text: 'PG release confirmed.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            title: 'Reminder',
                            text: 'Please release the PG soon.',
                            icon: 'info',
                            timer: 2500,
                            showConfirmButton: false
                        });
                        // Keeps asking again next load
                    }
                });
            }

            // Run check every page load
            checkPGFollowUp();

            // Optional: check hourly if the user keeps the page open
            setInterval(checkPGFollowUp, 60 * 60 * 1000);
        });
    </script>

@endsection
