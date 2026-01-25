@extends('adminlte::page')

@section('title', 'Edit Tender')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h1 class="mb-0">Edit Tender</h1>

        <a href="{{ route('tenders.index') }}" class="btn btn-sm btn-warning d-flex align-items-center gap-1 flex-shrink-0">
            <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>
@stop

@section('content')
    <div id="dateErrorBox"
        class="position-fixed bg-white border border-danger rounded shadow-lg px-4 py-3 text-center animate__animated"
        style="display: none; z-index: 9999; top: 50%; left: 50%; transform: translate(-50%, -50%); min-width: 320px;">
        <div class="d-flex justify-content-center mb-2">
            <i class="fas fa-exclamation-triangle text-danger fa-2x animate__animated animate__bounce"></i>
        </div>
        <strong class="text-danger fs-5">Oops!</strong>
        <p class="mb-0 text-dark">Publication date cannot be after submission date!</p>
    </div>


    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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

    <form action="{{ route('tenders.update', $tender->id) }}" method="POST" enctype="multipart/form-data"
        id="editTenderForm" data-confirm="edit">
        @csrf
        @method('PUT')

        <div class="card p-2">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="tender_no">Tender Number <span class="text-danger">*</span></label>
                        <input type="text" name="tender_no" id="tender_no" class="form-control"
                            value="{{ old('tender_no', $tender->tender_no) }}">
                        @error('tender_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="title">Tender Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ old('title', $tender->title) }}">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="procuring_authority">Procuring Authority <span class="text-danger">*</span></label>
                        <input type="text" name="procuring_authority" id="procuring_authority" class="form-control"
                            value="{{ old('procuring_authority', $tender->procuring_authority) }}">
                        @error('procuring_authority')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="end_user">End User <span class="text-danger">*</span></label>
                        <input type="text" name="end_user" id="end_user" class="form-control"
                            value="{{ old('end_user', $tender->end_user) }}">
                        @error('end_user')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="financial_year">FY (Financial Year) <span class="text-danger">*</span></label>
                        <select name="financial_year" id="financial_year" class="form-control">
                            <option value="">Select Financial Year</option>
                            @for ($year = 2025; $year >= 2005; $year--)
                                @php $fy = $year . '-' . ($year + 1); @endphp
                                <option value="{{ $fy }}"
                                    {{ old('financial_year', $tender->financial_year) == $fy ? 'selected' : '' }}>
                                    {{ $fy }}
                                </option>
                            @endfor
                        </select>
                        @error('financial_year')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="tender_type" class="form-label">Tender Type <span class="text-danger">*</span></label>
                        <div class="input-group">
                            @php
                                $commonTenders = [
                                    'Open Tender',
                                    'Limited Tender (Restricted Tender)',
                                    'Two-Stage Tender(EOI)',
                                    'Request for Proposal (RFP)',
                                    'Request for Quotation (RFQ)',
                                    'Framework Agreement',
                                    'Design-Build Tender',
                                    'Turnkey Tender',
                                    'E-Procurement',
                                    'Multi-Envelope Tender',
                                ];
                            @endphp

                            <select name="tender_type" id="tender_type" class="form-control">
                                <option value="">-- Select Tender Type --</option>

                                {{-- First: dynamically fetched types not in common --}}
                                @if (!empty($tenders))
                                    @foreach ($tenders as $t)
                                        @if (!in_array($t->name, $commonTenders))
                                            <option value="{{ $t->name }}"
                                                {{ old('tender_type', $tender->tender_type) == $t->name ? 'selected' : '' }}>
                                                {{ $t->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endif

                                {{-- Then: common predefined tender types --}}
                                @foreach ($commonTenders as $tenderOption)
                                    <option value="{{ $tenderOption }}"
                                        {{ old('tender_type', $tender->tender_type) == $tenderOption ? 'selected' : '' }}>
                                        {{ $tenderOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('tender_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Publication Date --}}
                    <div class="form-group col-md-6">
                        <label for="publication_date">
                            Publication Date <span class="text-danger">*</span>

                        </label>
                        <input type="date" name="publication_date" id="publication_date" class="form-control"
                            value="{{ old('publication_date', optional($tender)->publication_date) }}">
                        <small class="text-primary">
                            [{{ \Carbon\Carbon::parse($tender->publication_date)->format('d F Y') }}]
                        </small>
                        @error('publication_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Submission Date --}}
                    <div class="form-group col-md-6">
                        <label for="submission_date">Submission Date <span class="text-danger">*</span></label>
                        <input type="date" name="submission_date" id="submission_date" class="form-control"
                            value="{{ old('submission_date', $tender->submission_date) }}">
                        <small class="text-primary">
                            [{{ \Carbon\Carbon::parse($tender->submission_date)->format('d F Y') }}]
                        </small>
                        @error('submission_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Submission Time --}}
                    <div class="form-group col-md-6">
                        <label for="submission_time">Submission Time <span class="text-danger">*</span></label>
                        <input type="time" name="submission_time" class="form-control"
                            value="{{ old('submission_time', $tender->submission_time) }}">
                        @error('submission_time')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Spec File --}}
                    <div class="form-group col-md-6">
                        <label for="spec_file">Tender Specification File <span class="text-danger">*</span></label>
                        <input type="file" name="spec_file" class="form-control">
                        @if ($tender->spec_file)
                            <small class="text-muted">Current:
                                <a href="{{ asset('uploads/documents/spec_files/' . $tender->spec_file) }}"
                                    target="_blank">View File</a>
                            </small>
                        @endif
                        @error('spec_file')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Notice File --}}
                    <div class="form-group col-md-6">
                        <label for="notice_file">Notice File <span class="text-danger">*</span></label>
                        <input type="file" name="notice_file" class="form-control">
                        @if ($tender->notice_file)
                            <small class="text-muted">Current:
                                <a href="{{ asset('uploads/documents/notice_files/' . $tender->notice_file) }}"
                                    target="_blank">View File</a>
                            </small>
                        @endif
                        @error('notice_file')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Item Details --}}
                    @php
                        $oldItems = old('items');
                        $items = $oldItems ?? ($tender->items ?? [['item' => '', 'deno' => '', 'quantity' => '']]);
                    @endphp

                    <!-- Participation NO Section -->
                    <div id="nonParticipationFields">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Item Details <span class="text-danger">*</span></label>
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" id="item-table-basic">
                                        <thead class="table-light text-center">
                                            <tr>
                                                <th width="5%">SL</th> <!-- SL Column -->
                                                <th width="45%">Item</th>
                                                <th width="20%">Deno</th>
                                                <th width="20%">Quantity</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $index => $item)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                                                    <!-- SL Number -->
                                                    <td>
                                                        <input type="text" name="items[{{ $index }}][item]"
                                                            class="form-control" value="{{ $item['item'] ?? '' }}"
                                                            placeholder="Item name">
                                                    </td>
                                                    <td class="d-flex gap-1">
                                                        @php
                                                            $sortedDenoOptions = $denoOptions;
                                                            sort($sortedDenoOptions);
                                                        @endphp
                                                        <select name="items[{{ $index }}][deno]"
                                                            class="form-control">
                                                            <option value="">-- Select Deno --</option>
                                                            @foreach ($denoOptions as $deno)
                                                                <option value="{{ $deno }}"
                                                                    {{ isset($item['deno']) && $item['deno'] === $deno ? 'selected' : '' }}>
                                                                    {{ $deno }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-sm add-deno-btn"
                                                            title="Add new Deno">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="items[{{ $index }}][quantity]"
                                                            class="form-control quantity"
                                                            value="{{ $item['quantity'] ?? '' }}" placeholder="Qty"
                                                            min="0" step="any">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <button type="button" class="btn btn-success btn-sm" id="add-row-basic">
                                        <i class="fas fa-plus"></i> Add Item
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-100"></div>
                    {{-- Tender Participate Radio --}}
                    <div class="form-group col-md-6">
                        <label>Tender Participate:</label>
                        <div class="d-flex gap-3 align-items-center mt-1">
                            <div class="form-check" style="margin-right: 25px;">
                                <input class="form-check-input" type="radio" name="is_participate" id="participate_no"
                                    value="0"
                                    {{ old('is_participate', $tender->is_participate) == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="participate_no">No</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_participate"
                                    id="participate_yes" value="1"
                                    {{ old('is_participate', $tender->is_participate) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="participate_yes">Yes</label>
                            </div>
                        </div>
                    </div>

                    {{-- if yes Participate Conditional Fields --}}
                    <div id="participationFields" style="display: none;">
                        <div class="form-group col-12">
                            <label class="form-label fw-bold">Item Details <span class="text-danger">*</span></label>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle" id="item-table-detailed">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th width="30%">Item</th>
                                            <th width="15%">Deno</th>
                                            <th width="10%">Quantity</th>
                                            <th width="15%">Unit Price</th>
                                            <th width="15%">Total Price</th>
                                            <th width="5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $index => $item)
                                            <tr>
                                                <td>
                                                    <input type="text" name="items[{{ $index }}][item]"
                                                        class="form-control" value="{{ $item['item'] ?? '' }}"
                                                        placeholder="Item name">
                                                </td>
                                                <td class="d-flex gap-1">
                                                    @php
                                                        $sortedDenoOptions = $denoOptions;
                                                        sort($sortedDenoOptions);
                                                    @endphp
                                                    <select name="items[{{ $index }}][deno]" class="form-control">
                                                        <option value="">-- Select Deno --</option>
                                                        @foreach ($sortedDenoOptions as $deno)
                                                            <option value="{{ $deno }}"
                                                                {{ isset($item['deno']) && $item['deno'] == $deno ? 'selected' : '' }}>
                                                                {{ $deno }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-sm add-deno-btn"
                                                        title="Add new Deno">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][quantity]"
                                                        class="form-control quantity"
                                                        value="{{ $item['quantity'] ?? '' }}" placeholder="Qty"
                                                        min="0" step="any">
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][unit_price]"
                                                        class="form-control unit-price"
                                                        value="{{ $item['unit_price'] ?? '' }}" placeholder="Unit Price"
                                                        min="0" step="any">
                                                </td>
                                                <td>
                                                    <input type="text" name="items[{{ $index }}][total_price]"
                                                        class="form-control total-price"
                                                        value="{{ $item['total_price'] ?? '' }}" readonly>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm remove-row">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="fw-bold">
                                        <tr>
                                            <td colspan="4" class="text-end">Grand Total</td>
                                            <td>
                                                <input type="text" id="grand-total"
                                                    class="form-control text-end fw-bold" readonly value="0.00">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-success btn-sm" id="add-row-detailed">
                                    <i class="fas fa-plus"></i> Add Item
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="price">Offer No <span class="text-danger">*</span></label>
                                <input type="text" name="offer_no" class="form-control" disabled
                                    value="{{ old('offer_no', $participation->offer_no ?? '') }}">

                                @error('offer_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="price">My Offered Price <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="offeredPrice" class="form-control" disabled
                                    value="{{ old('price', optional($userParticipated)->offered_price ?? $tender->price) }}"
                                    readonly>
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="offer_date">Offer Date <span class="text-danger">*</span>
                                    <small class="text-muted">(d-m-y)</small>
                                </label>
                                <input type="date" name="offer_date" class="form-control" disabled
                                    value="{{ old('offer_date', $participation->offer_date ?? '') }}">
                                @if (!empty($participation->offer_date))
                                    <small class="text-primary">
                                        {{ \Carbon\Carbon::parse($participation->offer_date)->format('d F Y') }}
                                    </small>
                                @endif

                                @error('offer_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="offer_validity">Offer Validity <span class="text-danger">*</span>
                                    <small class="text-muted">(d-m-y)</small>
                                </label>

                                <input type="date" name="offer_validity" class="form-control" disabled
                                    value="{{ old('offer_validity', $participation->offer_validity ?? '') }}">

                                @if (!empty($participation->offer_validity))
                                    <small class="text-primary">
                                        {{ \Carbon\Carbon::parse($participation->offer_validity)->format('d F Y') }}
                                    </small>
                                @endif

                                @error('offer_validity')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="offer_doc">Offer Document <span class="text-danger">*</span></label>
                                <input type="file" name="offer_doc" id="offer_doc" class="form-control" disabled>

                                @if (!empty($participation) && $participation->offer_doc)
                                    <small class="text-muted">Current:
                                        <a href="{{ asset($participation->offer_doc) }}" target="_blank">View File</a>
                                    </small>
                                @endif

                                @error('offer_doc')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @php
                        $hasParticipated = count($tenderParticipated);
                        $dateKey = \Carbon\Carbon::now()->toDateString(); // fallback key if no participation
                    @endphp

                    <div class="form-group col-md-12">
                        <label>Tender Participate Company:</label>
                        <div class="tab-content" id="participates-tabContent">

                            @if ($hasParticipated)
                                @foreach ($tenderParticipated as $date => $participatesOnDate)
                                    @php
                                        $sortedParticipated = $participatesOnDate->sortBy('offered_price')->values();
                                    @endphp

                                    <div class="tab-pane fade show active" id="pane-{{ $date }}"
                                        role="tabpanel">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sl No.</th>
                                                    <th>Company</th>
                                                    <th>Offered Price</th>
                                                    <th>Position</th>
                                                    <th style="width: 50px;">
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="addRow('{{ $date }}')">+</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-{{ $date }}">
                                                @foreach ($sortedParticipated as $index => $participate)
                                                    <tr>
                                                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                                        {{-- Sl No. --}}
                                                        <td>
                                                            <input type="text"
                                                                name="tender_participates[{{ $date }}][{{ $index }}][company]"
                                                                class="form-control"
                                                                value="{{ $participate->company_name }}">
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                name="tender_participates[{{ $date }}][{{ $index }}][price]"
                                                                class="form-control"
                                                                value="{{ $participate->offered_price }}"
                                                                onchange="reorderTable('{{ $date }}')">
                                                        </td>
                                                        <td class="position-cell align-middle text-center">
                                                            {{ $index + 1 }}
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="this.closest('tr').remove(); reorderTable('{{ $date }}')">x</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            @else
                                {{-- No participation yet, render empty table with current date --}}
                                <div class="tab-pane fade show active" id="pane-{{ $dateKey }}" role="tabpanel">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Company</th>
                                                <th>Offered Price</th>
                                                <th>Position</th>
                                                <th style="width: 50px;">
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        onclick="addRow('{{ $dateKey }}')">+</button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-{{ $dateKey }}">
                                            {{-- Empty initially --}}
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>


                    {{-- To show data if status is 3 or Awarded State --}}
                    @php
                        $isAwarded = $tender->status == 3;
                        $isCompleted = $tender->status == 4;
                    @endphp

                    @if ($isAwarded)
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
                                    @forelse ($participatedLetters as $key => $letter)
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

                        {{-- Tender Awarded --}}
                        <div class="form-group col-md-6">
                            <label>Tender Awarded:</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_awarded" id="participate_no"
                                        value="0" {{ old('is_awarded', $tender->is_awarded) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="participate_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_awarded"
                                        id="participate_yes" value="1"
                                        {{ old('is_awarded', $tender->is_awarded) == 1 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="participate_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>

                        {{-- Work Order --}}
                        <div class="form-group col-md-6">
                            <label for="workorder_no">Work Order No/NOA No</label>
                            <input type="text" name="workorder_no" class="form-control"
                                value="{{ old('workorder_no', optional($tenderAwarded)->workorder_no) }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="expiry_date">Work Order No/NOA No</label>
                            <input type="text" class="form-control"
                                value="{{ $tenderAwarded->workorder_date ? \Carbon\Carbon::parse($tenderAwarded->workorder_date)->format('d F Y') : '' }}"
                                readonly>
                        </div>

                        {{-- BG Section --}}
                        <div class="form-group col-md-6">
                            <label>Is Bid Guarantee (BG)?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_bg" id="bg_no"
                                        value="0" {{ old('is_bg', $participation->is_bg) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="bg_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_bg" id="bg_yes"
                                        value="1" {{ old('is_bg', $participation->is_bg) == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="bg_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div id="bg-field-wrapper">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bg_no">BG Number</label>
                                    <input type="text" name="bg_no" class="form-control"
                                        value="{{ old('bg_no', $bg->bg_no ?? 'N/A') }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="issue_in_bank">Issue in Bank</label>
                                    <input type="text" name="issue_in_bank" class="form-control"
                                        value="{{ old('issue_in_bank', $bg->issue_in_bank ?? 'N/A') }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="issue_in_branch">Issue in Branch</label>
                                    <input type="text" name="issue_in_branch" class="form-control"
                                        value="{{ old('issue_in_branch', $bg->issue_in_branch ?? 'N/A') }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="issue_date">BG Issue Date</label>
                                    <input type="text" class="form-control" value="{{ $bg->issue_date ?? 'N/A' }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="expiry_date">BG Expiry Date</label>
                                    <input type="text" class="form-control" value="{{ $bg->expiry_date ?? 'N/A' }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="amount">BG Amount</label>
                                    <input type="text" name="amount" class="form-control"
                                        value="{{ old('amount', $bg->amount ?? 'N/A') }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>BG Attachment</label><br>
                                    @if (!empty($bg->attachment))
                                        <a href="{{ asset('uploads/documents/bg_attachments/' . $bg->attachment) }}"
                                            target="_blank">
                                            View Current Attachment
                                        </a>
                                    @else
                                        <span class="text-danger">No Attachment File Found</span>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="awarded_date">Delivery Date</label>
                            <input type="date" name="awarded_date" class="form-control"
                                value="{{ old('awarded_date', optional($tenderAwarded)->awarded_date) }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="delivery_type">Delivery Type</label>
                            <select name="delivery_type" id="delivery_type" class="form-control" disabled>
                                <option value="">-- Select --</option>
                                <option value="1"
                                    {{ old('delivery_type', $tenderAwarded->delivery_type ?? '') == '1' ? 'selected' : '' }}>
                                    Single</option>
                                <option value="partial"
                                    {{ old('delivery_type', $tenderAwarded->delivery_type ?? '') == 'partial' ? 'selected' : '' }}>
                                    Multiple</option>
                            </select>
                        </div>

                        {{-- Single Delivery --}}
                        @if (old('delivery_type', $tenderAwarded->delivery_type ?? '') == '1')
                            <div class="form-group col-md-12">
                                <h5 class="mt-4">Delivery Information (Single)</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Delivery Item</th>
                                            <th>Delivery Date</th>
                                            <th>Warranty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td> {{-- Serial number fixed for single --}}
                                            <td>
                                                <input type="text" name="deliveries[0][delivery_item]"
                                                    class="form-control"
                                                    value="{{ old('deliveries.0.delivery_item', $singleDelivery->delivery_item ?? '') }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="deliveries[0][delivery_date]"
                                                    class="form-control"
                                                    value="{{ old('deliveries.0.delivery_date', isset($singleDelivery->delivery_date) ? \Carbon\Carbon::parse($singleDelivery->delivery_date)->format('d F Y') : '') }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <select name="deliveries[0][warranty]" class="form-control" disabled>
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
                        @endif

                        {{-- Partial Delivery --}}
                        @if (old('delivery_type', $tenderAwarded->delivery_type ?? '') == 'partial')
                            <div class="form-group col-md-12">
                                <h5 class="mt-4">Delivery Information (Multiple)</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Delivery Item</th>
                                            <th>Delivery Date</th>
                                            <th>Warranty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (old('deliveries', $partialDeliveries->toArray() ?? []) as $index => $delivery)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td> {{-- Serial number --}}
                                                <td>
                                                    <input type="text"
                                                        name="deliveries[{{ $index }}][delivery_item]"
                                                        class="form-control"
                                                        value="{{ $delivery['delivery_item'] ?? '' }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="date"
                                                        name="deliveries[{{ $index }}][delivery_date]"
                                                        class="form-control"
                                                        value="{{ isset($delivery['delivery_date']) ? \Carbon\Carbon::parse($delivery['delivery_date'])->format('Y-m-d') : '' }}"
                                                        readonly>
                                                </td>
                                                <td>
                                                    <select name="deliveries[{{ $index }}][warranty]"
                                                        class="form-control" disabled>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($warranties as $warranty)
                                                            <option value="{{ $warranty }}"
                                                                {{ isset($delivery['warranty']) && $delivery['warranty'] == $warranty ? 'selected' : '' }}>
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

                        <div class="form-group col-md-6">
                            <label>Is Performance Guarantee (PG) ?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_pg" id="pg_no"
                                        value="0" {{ old('is_pg', $tenderAwarded->is_pg) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="pg_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_pg" id="pg_yes"
                                        value="1" {{ old('is_pg', $tenderAwarded->is_pg) == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="pg_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div id="pg-field-wrapper">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="pg_no">PG Number</label>
                                    <input type="text" name="pg_no" class="form-control"
                                        value="{{ old('pg_no', $tenderAwarded->pg->pg_no ?? 'N/A') }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="issue_in_bank">Issue in Bank</label>
                                    <input type="text" name="issue_in_bank" class="form-control"
                                        value="{{ old('issue_in_bank', $tenderAwarded->pg->issue_in_bank ?? 'N/A') }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="issue_in_branch">Issue in Branch</label>
                                    <input type="text" name="issue_in_branch" class="form-control"
                                        value="{{ old('issue_in_branch', $tenderAwarded->pg->issue_in_branch ?? 'N/A') }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="issue_date">PG Issue Date</label>
                                    <input type="text" name="issue_date" class="form-control"
                                        value="{{ $tenderAwarded->pg->issue_date ?? 'N/A' }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="expiry_date">PG Expiry Date</label>
                                    <input type="text" name="expiry_date" class="form-control"
                                        value="{{ $tenderAwarded->pg->expiry_date ?? 'N?A' }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="amount">PG Amount</label>
                                    <input type="text" name="amount" class="form-control"
                                        value="{{ old('amount', $tenderAwarded->pg->amount ?? 'N/A') }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>PG Attachment</label><br>
                                    @if (!empty($tenderAwarded->pg->attachment))
                                        <a href="{{ asset('uploads/documents/pg_attachments/' . $tenderAwarded->pg->attachment) }}"
                                            target="_blank">
                                            View Current Attachment
                                        </a>
                                    @else
                                        <span class="text-danger">No Attachment File Found</span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endif

                    @if ($isCompleted)
                        {{-- Tender Completed --}}
                        <div class="form-group col-md-6">
                            <label>Tender Completed:</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" checked disabled>
                                    <label class="form-check-label">Yes</label>
                                </div>
                            </div>
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
                                    @forelse ($participatedLetters as $key => $letter)
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
                            <label for="workorder_no">Work Order No/NOA No</label>
                            <input type="text" class="form-control"
                                value="{{ optional($tenderAwarded)->workorder_no }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="workorder_date">Work Order Date/NOA Date</label>
                            <input type="date" class="form-control"
                                value="{{ optional($tenderAwarded)->workorder_date }}" readonly>
                        </div>

                        {{-- BG Section --}}

                        <div class="form-group col-md-6">
                            <label>Is Bid Guarantee (BG) ?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio"
                                        {{ $participation->is_bg == 0 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        {{ $participation->is_bg == 1 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>BG Number</label>
                                <input type="text" class="form-control" value="{{ $bg?->bg_no ?? 'N/A' }}" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Issue in Bank</label>
                                <input type="text" class="form-control" value="{{ $bg?->issue_in_bank ?? 'N/A' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Issue in Branch</label>
                                <input type="text" class="form-control" value="{{ $bg?->issue_in_branch ?? 'N/A' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>BG Issue Date</label>
                                <input type="text" class="form-control"
                                    value="{{ $bg?->issue_date ? \Carbon\Carbon::parse($bg->issue_date)->format('d F Y') : 'N/A' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>BG Expiry Date</label>
                                <input type="text" class="form-control"
                                    value="{{ $bg?->expiry_date ? \Carbon\Carbon::parse($bg->expiry_date)->format('d F Y') : 'N/A' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>BG Amount</label>
                                <input type="text" class="form-control" value="{{ $bg?->amount ?? 'N/A' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>BG Attachment</label><br>

                                @if ($bg?->attachment)
                                    <a href="{{ asset('uploads/documents/bg_attachments/' . $bg->attachment) }}"
                                        target="_blank">
                                        View Attachment
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Delivery Date</label>
                            <input type="text" class="form-control"
                                value="{{ $tenderAwarded->awarded_date ? \Carbon\Carbon::parse($tenderAwarded->awarded_date)->format('d F Y') : '' }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Delivery Type</label>
                            <select class="form-control" disabled>
                                <option value="">-- Select --</option>
                                <option value="1" {{ $tenderAwarded->delivery_type == '1' ? 'selected' : '' }}>
                                    Single</option>
                                <option value="partial"
                                    {{ $tenderAwarded->delivery_type == 'partial' ? 'selected' : '' }}>Multiple
                                </option>
                            </select>
                        </div>

                        {{-- Single Delivery --}}
                        @if ($tenderAwarded->delivery_type == '1' && $singleDelivery)
                            <div class="form-group col-md-12">
                                <h5 class="mt-4">Delivery Information (Single)</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th>Delivery Item</th>
                                            <th>Delivery Date</th>
                                            <th>Warranty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $singleDelivery->delivery_item }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $singleDelivery->delivery_date ? \Carbon\Carbon::parse($singleDelivery->delivery_date)->format('d F Y') : 'N/A' }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <select class="form-control" disabled>
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
                        @if ($tenderAwarded->delivery_type == 'partial' && $partialDeliveries)
                            <div class="form-group col-md-12">
                                <h5 class="mt-4">Delivery Information (Multiple)</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th>Delivery Item</th>
                                            <th>Delivery Date</th>
                                            <th>Warranty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($partialDeliveries as $delivery)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td><input type="text" class="form-control"
                                                        value="{{ $delivery->delivery_item }}" readonly></td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        value="{{ $delivery->delivery_date ? \Carbon\Carbon::parse($delivery->delivery_date)->format('d F Y') : 'N/A' }}"
                                                        readonly>
                                                </td>
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

                        <div class="form-group col-md-6">
                            <label>Is Performance Guarentee (PG) ?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_pg" id="pg_no"
                                        value="0" {{ old('is_pg', $tenderAwarded->is_pg) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="pg_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_pg" id="pg_yes"
                                        value="1" {{ old('is_pg', $tenderAwarded->is_pg) == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="pg_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div id="pg-field-wrapper">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>PG Number</label>
                                    <input type="text" class="form-control"
                                        value="{{ $tenderAwarded->pg?->pg_no ?? 'N/A' }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Issue in Bank</label>
                                    <input type="text" class="form-control"
                                        value="{{ $tenderAwarded->pg?->issue_in_bank ?? 'N/A' }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Issue in Branch</label>
                                    <input type="text" class="form-control"
                                        value="{{ $tenderAwarded->pg?->issue_in_branch ?? 'N/A' }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>PG Issue Date</label>
                                    <input type="text" class="form-control"
                                        value="{{ $tenderAwarded->pg?->issue_date
                                            ? \Carbon\Carbon::parse($tenderAwarded->pg->issue_date)->format('d F Y')
                                            : 'N/A' }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>PG Expiry Date</label>
                                    <input type="text" class="form-control"
                                        value="{{ $tenderAwarded->pg?->expiry_date
                                            ? \Carbon\Carbon::parse($tenderAwarded->pg->expiry_date)->format('d F Y')
                                            : 'N/A' }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>PG Amount</label>
                                    <input type="text" class="form-control"
                                        value="{{ $tenderAwarded->pg?->amount ?? 'N/A' }}" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>PG Attachment</label><br>

                                    @if ($tenderAwarded->pg?->attachment)
                                        <a href="{{ asset('uploads/documents/pg_attachments/' . $tenderAwarded->pg->attachment) }}"
                                            target="_blank">
                                            View Attachment
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
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

                        <div class="form-group col-md-12">
                            <strong>Completed Tender Correspondence</strong>

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
                                    @forelse ($completedLetters as $key => $letter)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $letter->reference_no }}</td>
                                            <td>{{ $letter->remarks }}</td>
                                            <td>{{ $letter->value }}</td>
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
                    @endif

                    <div class="form-group col-12 mb-2" style="text-align: right;">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('tenders.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
    </form>
    <div class="mt-4" style="height:50px;"></div>
@stop

@section('js')


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Helper to sort and build deno options (will be replaced by Blade server-side render)
            const denoOptions = [
                @foreach ($denoOptions as $deno)
                    "{{ $deno }}",
                @endforeach
            ].sort();

            // Utility to build deno <option> tags
            function buildDenoOptions(selected = '') {
                let options = '<option value="">-- Select Deno --</option>';
                denoOptions.forEach(deno => {
                    options +=
                        `<option value="${deno}" ${deno === selected ? 'selected' : ''}>${deno}</option>`;
                });
                return options;
            }

            // Calculate totals for detailed table
            function calculateTotalPrice() {
                let grandTotal = 0;

                document.querySelectorAll('#item-table-detailed tbody tr').forEach(row => {
                    const qty = parseFloat(row.querySelector('.quantity')?.value) || 0;
                    const price = parseFloat(row.querySelector('.unit-price')?.value) || 0;
                    const total = qty * price;

                    const totalInput = row.querySelector('.total-price');
                    if (totalInput) totalInput.value = total.toFixed(2);

                    grandTotal += total;
                });

                const grandTotalInput = document.getElementById('grand-total');
                if (grandTotalInput) grandTotalInput.value = grandTotal.toFixed(2);

                const offeredPriceInput = document.getElementById('offeredPrice');
                if (offeredPriceInput) offeredPriceInput.value = grandTotal.toFixed(2);

                if (typeof updateMyCompanyPrice === 'function') {
                    updateMyCompanyPrice("{{ now()->toDateString() }}");
                }
            }

            // Add row to detailed table
            document.getElementById('add-row-detailed').addEventListener('click', function() {
                const tableBody = document.querySelector('#item-table-detailed tbody');
                const index = tableBody.rows.length;

                const newRow = `
            <tr>
                <td><input type="text" name="detailed_items[${index}][item]" class="form-control" placeholder="Item name"></td>
                <td class="d-flex gap-1">
                    <select name="detailed_items[${index}][deno]" class="form-control">
                        ${buildDenoOptions()}
                    </select>
                    <button type="button" class="btn btn-outline-primary btn-sm add-deno-btn" title="Add new Deno">
                        <i class="fas fa-plus"></i>
                    </button>
                </td>
                <td><input type="number" name="detailed_items[${index}][quantity]" class="form-control quantity" placeholder="Qty" min="0" step="any"></td>
                <td><input type="number" name="detailed_items[${index}][unit_price]" class="form-control unit-price" placeholder="Unit Price" min="0" step="any"></td>
                <td><input type="text" name="detailed_items[${index}][total_price]" class="form-control total-price" placeholder="Total Price" readonly></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `;

                tableBody.insertAdjacentHTML('beforeend', newRow);
            });

            // Add row to basic table
            document.getElementById('add-row-basic').addEventListener('click', function() {
                const tableBody = document.querySelector('#item-table-basic tbody');
                const index = tableBody.rows.length;

                const newRow = `
            <tr>
                <td><input type="text" name="basic_items[${index}][item]" class="form-control" placeholder="Item name"></td>
                <td class="d-flex gap-1">
                    <select name="basic_items[${index}][deno]" class="form-control">
                        ${buildDenoOptions()}
                    </select>
                    <button type="button" class="btn btn-outline-primary btn-sm add-deno-btn" title="Add new Deno">
                        <i class="fas fa-plus"></i>
                    </button>
                </td>
                <td><input type="number" name="basic_items[${index}][quantity]" class="form-control quantity" placeholder="Qty" min="0" step="any"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `;

                tableBody.insertAdjacentHTML('beforeend', newRow);
            });

            // Remove row (works for both tables)
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-row')) {
                    e.target.closest('tr').remove();
                    calculateTotalPrice();
                }
            });

            // Recalculate totals on input for detailed table only
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('quantity') || e.target.classList.contains('unit-price')) {
                    // Only recalc for detailed table inputs
                    if (e.target.closest('#item-table-detailed')) {
                        calculateTotalPrice();
                    }
                }
            });

            calculateTotalPrice(); // Initial calculation on load
        });
    </script>

    {{-- ========== ✅ Start Tender Participates Script ✅ ========== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const participateYes = document.getElementById('participate_yes');
            const participateNo = document.getElementById('participate_no');
            const yesSection = document.getElementById('participationFields');
            const noSection = document.getElementById('nonParticipationFields');
            const companyName = @json($organization->name);
            const todayDate = "{{ now()->toDateString() }}";

            function toggleSections() {
                const isYes = participateYes.checked;

                yesSection.style.display = isYes ? 'block' : 'none';
                noSection.style.display = isYes ? 'none' : 'block';

                yesSection.querySelectorAll('input, select, button').forEach(el => el.disabled = !isYes);
                noSection.querySelectorAll('input, select, button').forEach(el => el.disabled = isYes);

                if (isYes) {
                    addMyCompanyParticipationRow(todayDate);
                    showMyCompanyRow(todayDate, true);
                } else {
                    showMyCompanyRow(todayDate, false);
                }
            }

            function addMyCompanyParticipationRow(date) {
                const tbody = document.getElementById('table-' + date);
                if (!tbody) return;

                const alreadyExists = Array.from(tbody.querySelectorAll('input[name*="[company]"]')).some(input =>
                    input.value.trim().toLowerCase() === companyName.toLowerCase()
                );
                if (alreadyExists) return;

                const price = parseFloat(document.getElementById('grand-total')?.value || 0).toFixed(2);
                const index = tbody.rows.length;

                const row = `
            <tr data-own-company="true">
                <td class="sl-cell align-middle text-center"></td> <!-- Sl No. auto updated -->
                <td>
                    <input type="text" name="tender_participates[${date}][${index}][company]"
                        class="form-control" value="${companyName}">
                </td>
                <td>
                    <input type="number" step="0.01" name="tender_participates[${date}][${index}][price]"
                        class="form-control" value="${price}" onchange="reorderTable('${date}')">
                </td>
                <td class="position-cell align-middle text-center">${index + 1}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="this.closest('tr').remove(); reorderTable('${date}')">x</button>
                </td>
            </tr>`;
                tbody.insertAdjacentHTML('beforeend', row);
                reorderTable(date);
            }

            function showMyCompanyRow(date, show) {
                const tbody = document.getElementById('table-' + date);
                if (!tbody) return;

                tbody.querySelectorAll('tr').forEach(row => {
                    const companyInput = row.querySelector('input[name*="[company]"]');
                    if (!companyInput) return;

                    const isOwnCompany = companyInput.value.trim().toLowerCase() === companyName
                        .toLowerCase();
                    if (isOwnCompany) {
                        row.style.display = show ? '' : 'none';
                        row.querySelectorAll('input, button').forEach(el => el.disabled = !show);
                    }
                });
            }

            window.updateMyCompanyPrice = function(date) {
                const tbody = document.getElementById('table-' + date);
                if (!tbody) return;

                const price = parseFloat(document.getElementById('grand-total')?.value || 0).toFixed(2);

                tbody.querySelectorAll('tr').forEach(row => {
                    const companyInput = row.querySelector('input[name*="[company]"]');
                    const priceInput = row.querySelector('input[name*="[price]"]');
                    if (companyInput && priceInput &&
                        companyInput.value.trim().toLowerCase() === companyName.toLowerCase()) {
                        priceInput.value = price;
                    }
                });
                reorderTable(date);
            }

            // ✅ New function to reorder by price & update Sl/Position
            window.reorderTable = function(date) {
                const tbody = document.getElementById('table-' + date);
                if (!tbody) return;

                const rows = Array.from(tbody.querySelectorAll('tr'));

                // Sort by offered price
                rows.sort((a, b) => {
                    const priceA = parseFloat(a.querySelector('input[name*="[price]"]').value) || 0;
                    const priceB = parseFloat(b.querySelector('input[name*="[price]"]').value) || 0;
                    return priceA - priceB;
                });

                // Re-append sorted rows
                tbody.innerHTML = "";
                rows.forEach((row, idx) => {
                    // Update Sl No.
                    const slCell = row.querySelector('.sl-cell');
                    if (slCell) slCell.textContent = idx + 1;

                    // Update Position
                    const posCell = row.querySelector('.position-cell');
                    if (posCell) posCell.textContent = idx + 1;

                    tbody.appendChild(row);
                });
            }

            // Init
            toggleSections();
            participateYes.addEventListener('change', toggleSections);
            participateNo.addEventListener('change', toggleSections);
        });
    </script>
    <script>
        // GLOBAL addRow function for the "Tender Participates" table
        function addRow(date) {
            const tbody = document.getElementById('table-' + date);
            if (!tbody) return;

            const index = tbody.rows.length;

            const row = `
        <tr>
            <td class="sl-cell align-middle text-center"></td>
            <td><input type="text" name="tender_participates[${date}][${index}][company]" class="form-control"></td>
            <td><input type="number" step="0.01" name="tender_participates[${date}][${index}][price]" class="form-control" onchange="reorderTable('${date}')"></td>
            <td class="position-cell align-middle text-center"></td>
            <td>
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="this.closest('tr').remove(); reorderTable('${date}')">x</button>
            </td>
        </tr>
        `;

            tbody.insertAdjacentHTML('beforeend', row);
            reorderTable(date);
        }

        // Function to reorder SL & Position
        function reorderTable(date) {
            const tbody = document.getElementById('table-' + date);
            if (!tbody) return;

            [...tbody.rows].forEach((row, i) => {
                // Update SL (1,2,3,...)
                row.querySelector('.sl-cell').textContent = i + 1;

                // Update Position
                row.querySelector('.position-cell').textContent = i + 1;

                // Update input names with correct indexes
                const inputs = row.querySelectorAll("input");
                inputs.forEach(input => {
                    let name = input.getAttribute("name");
                    if (name) {
                        name = name.replace(/\[\d+\]/, `[${i}]`);
                        input.setAttribute("name", name);
                    }
                });
            });
        }
    </script>
    <script>
        function reorderTable(date) {
            const tbody = document.getElementById('table-' + date);
            if (!tbody) return;

            const rows = tbody.querySelectorAll('tr');
            rows.forEach((row, index) => {
                const cell = row.querySelector('.position-cell');
                if (cell) {
                    cell.textContent = index + 1;
                }
            });
        }
    </script>
    {{-- ========== End Tender Participation Handling Script ========== --}}

    <script>
        // ✅ Date Validation Before Submit
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editTenderForm');
            const pubInput = document.getElementById('publication_date');
            const subInput = document.getElementById('submission_date');
            const errorBox = document.getElementById('dateErrorBox');

            function showSweetError(message) {
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

            if (form && pubInput && subInput) {
                form.addEventListener('submit', function(e) {
                    const pubDate = new Date(pubInput.value);
                    const subDate = new Date(subInput.value);

                    if (!pubInput.value || !subInput.value) return;

                    if (pubDate > subDate) {
                        e.preventDefault();
                        showSweetError("Publication date cannot be after submission date!");
                    }
                });
            }
        });
    </script>
@endsection
