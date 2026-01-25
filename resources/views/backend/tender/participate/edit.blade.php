@extends('adminlte::page')

@section('title', 'Edit Participated Tender')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Edit Participated Tender</h1>
        <a href="{{ route('participated_tenders.index') }}"
            class="btn btn-sm btn-warning d-flex align-items-center gap-1 flex-shrink-0">
            <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>
@stop
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops! Something went wrong.</strong>
            <ul class="mb-0 mt-2">
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
        <p class="mb-0 text-dark">Publication date cannot be after submission date!</p>
    </div>

    <form action="{{ route('participated_tenders.update', $tenderParticipate->id) }}" method="POST"
        enctype="multipart/form-data" id="editTenderForm" data-confirm="edit">
        @csrf
        @method('PUT')

        <input type="hidden" name="tender_id" value="{{ $tenderParticipate->tender_id }}">

        {{-- Nav Tabs --}}
        <ul class="nav nav-tabs mb-3" id="editTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tender-tab" data-bs-toggle="tab" href="#tenderInfo" role="tab"
                    aria-controls="tenderInfo" aria-selected="true">Tender Info</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="bg-tab" data-bs-toggle="tab" href="#bgInfo" role="tab" aria-controls="bgInfo"
                    aria-selected="false">Bid Guarentee(BG) Info</a>
            </li>
        </ul>

        <div class="tab-content p-4" id="editTabContent">
            <div class="tab-pane fade show active" id="tenderInfo" role="tabpanel" aria-labelledby="tender-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>BG:</label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_bg" id="bg_no"
                                            value="0"
                                            {{ old('is_bg', $tenderParticipate->is_bg) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bg_no">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_bg" id="bg_yes"
                                            value="1"
                                            {{ old('is_bg', $tenderParticipate->is_bg) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bg_yes">Yes</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="tender_no">Tender Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    value="{{ old('tender_no', $tenderParticipate->tender->tender_no) }}" readonly>
                                @error('tender_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="title">Tender Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    value="{{ old('title', $tenderParticipate->tender->title) }}" readonly>
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Procuring Authority <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    value="{{ old('procuring_authority', $tenderParticipate->tender->procuring_authority) }}"
                                    readonly>
                                @error('procuring_authority')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>End User <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    value="{{ old('end_user', $tenderParticipate->tender->end_user) }}" readonly>
                                @error('end_user')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>FY (Financial Year) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    value="{{ old('financial_year', $tenderParticipate->tender->financial_year) }}"
                                    readonly>
                                @error('financial_year')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tender Type <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    value="{{ old('tender_type', $tenderParticipate->tender->tender_type) }}" readonly>
                                @error('tender_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text">Publication Date</label>
                                <div class="form-control" readonly>
                                    {{ \Carbon\Carbon::parse($tenderParticipate->tender->publication_date)->format('d-F-Y') }}
                                </div>
                            </div>

                            {{-- Submission Date --}}
                            <div class="form-group col-md-6">
                                <label class="text">Submission Date</label>
                                <div class="form-control" readonly>
                                    {{ \Carbon\Carbon::parse($tenderParticipate->tender->submission_date)->format('d-F-Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Submission Time <span class="text-danger">*</span></label>
                                <input type="text" name="submission_time" class="form-control"
                                    value="{{ old('submission_time', $tenderParticipate->tender->submission_time) }}"
                                    readonly>
                                @error('submission_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Participated? <span class="text-danger">*</span></label>
                                <select name="is_participate" class="form-control" readonly>
                                    <option value="1"
                                        {{ old('is_participate', $tenderParticipate->tender->is_participate) == 1 ? 'selected' : '' }}>
                                        Yes
                                    </option>
                                    <option value="0"
                                        {{ old('is_participate', $tenderParticipate->tender->is_participate) == 0 ? 'selected' : '' }}>
                                        No
                                    </option>
                                </select>
                                @error('is_participate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        @php
                            $oldItems = old('items');
                            //                            $items = $oldItems ?? ($tenderParticipate->tender->items ?? []);
                            $items = $oldItems ?? json_decode($tenderParticipate->tender->items ?? '[]', true);

                            $denoOptions = [
                                'Item',
                                'Piece',
                                'Kg',
                                'Line',
                                'No',
                                'Gram',
                                'Liter',
                                'Milliliter',
                                'Meter',
                                'Centimeter',
                                'Millimeter',
                                'Square Meter',
                                'Square Foot',
                                'Cubic Meter',
                                'Cubic Foot',
                                'Box',
                                'Pack',
                                'Set',
                                'Pair',
                                'Dozen',
                                'Hour',
                                'Day',
                                'Week',
                                'Month',
                                'Year',
                                'Service',
                                'Job',
                                'Lot',
                                'Bundle',
                                'Roll',
                                'Sheet',
                                'Unit',
                                'Gallon',
                                'Quart',
                                'Pound',
                                'Ton',
                                'Each',
                            ];
                            $sortedDenoOptions = $denoOptions;
                            sort($sortedDenoOptions); // alphabetically
                        @endphp

                        <div class="form-group col-12">
                            <label class="form-label">Item Details <span class="text-danger">*</span></label>
                            <table class="table table-bordered" id="item-table">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">SL</th>
                                        <th width="35%">Item</th>
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
                                            <td class="sl-no">{{ $index + 1 }}</td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][item]"
                                                    class="form-control" value="{{ $item['item'] ?? '' }}"
                                                    placeholder="Item name">
                                            </td>
                                            <td>
                                                <select name="items[{{ $index }}][deno]" class="form-control">
                                                    <option value="">-- Select Denominator --</option>
                                                    @foreach ($sortedDenoOptions as $deno)
                                                        <option value="{{ $deno }}" @selected(($item['deno'] ?? '') == $deno)>
                                                            {{ $deno }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" step="any"
                                                    name="items[{{ $index }}][quantity]" class="form-control qty"
                                                    value="{{ $item['quantity'] ?? '' }}" placeholder="Quantity"
                                                    oninput="updateTotal(this)">
                                            </td>
                                            <td>
                                                <input type="number" step="any"
                                                    name="items[{{ $index }}][unit_price]"
                                                    class="form-control unit {{ auth()->user()->role?->name !== 'admin' ? 'bg-light text-muted' : '' }}"
                                                    value="{{ $item['unit_price'] ?? '' }}" placeholder="Unit Price"
                                                    {{ auth()->user()->role?->name !== 'admin' ? 'readonly' : 'oninput=updateTotal(this)' }}>
                                            </td>
                                            <td>
                                                <input type="number" step="any"
                                                    name="items[{{ $index }}][total_price]"
                                                    class="form-control total" value="{{ $item['total_price'] ?? '' }}"
                                                    placeholder="Total Price" readonly>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm remove-row">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold">Grand Total</td>
                                        <td>
                                            <input type="text" id="grand_total" class="form-control fw-bold bg-light"
                                                readonly>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>

                            <button type="button" class="btn btn-success btn-sm mt-2" id="add-row">
                                <i class="fas fa-plus"></i> Add Item
                            </button>
                        </div>


                        @if ($tenderParticipate->tender->is_participate)
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Offer No <span class="text-danger">*</span></label>
                                    <input type="text" id="offer_no" name="offer_no" class="form-control"
                                        value="{{ old('offer_no', $tenderParticipate->offer_no ?? '') }}">

                                    @error('offer_no')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Offered Price <span class="text-danger">*</span></label>
                                    <input type="text" id="offered_price" name="offered_price" class="form-control"
                                        value="{{ old('offered_price', $participates->offered_price ?? '') }}">

                                    @error('offered_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Offer Date <span class="text-danger">*</span></label>
                                    <input type="date" id="offer_date" name="offer_date" class="form-control"
                                        value="{{ old('offer_date', $tenderParticipate->offer_date ?? '') }}">

                                    @error('offer_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Offer Validity <span class="text-danger">*</span></label>
                                    <input type="date" id="offer_validity" name="offer_validity" class="form-control"
                                        value="{{ old('offer_validity', $tenderParticipate->offer_validity ?? '') }}">

                                    @error('offer_validity')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="offer_doc">Offer Document <span class="text-danger">*</span></label>
                                    <input type="file" name="offer_doc" class="form-control">

                                    @if (!empty($tenderParticipate->offer_doc))
                                        <small class="text-muted">
                                            Current: <a
                                                href="{{ asset('uploads/documents/offer_docs/' . $tenderParticipate->offer_doc) }}"
                                                target="_blank">View File</a>
                                        </small>
                                    @endif

                                    @error('offer_doc')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label class="fw-bold mb-2">Tender's Participate Company</label>
                        <div class="tab-content">
                            <div class="tab-pane fade show active">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;">SL</th>
                                            <th>Company</th>
                                            <th>Offered Price</th>
                                            <th>Position</th>
                                            <th style="width: 50px;">
                                                <button type="button" class="btn btn-sm btn-success" onclick="addRow()">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="participant-table">
                                        @if ($groupedCompanies->isEmpty())
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td>
                                                    <input type="text" name="tender_participates[0][company]"
                                                        class="form-control" value="{{ $organization->name }}"
                                                        placeholder="Company name">
                                                </td>
                                                <td>
                                                    <input type="number" name="tender_participates[0][price]"
                                                        class="form-control price-input"
                                                        value="{{ $offered_price ?? '' }}" placeholder="Offered price"
                                                        onchange="reorderTable()">
                                                </td>
                                                <td class="position-cell text-center fw-semibold">1</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm remove-row">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @else
                                            @php $rowIndex = 0; @endphp
                                            @foreach ($groupedCompanies as $participant)
                                                <tr>
                                                    <td class="text-center">{{ $rowIndex + 1 }}</td>
                                                    <td>
                                                        <input type="text"
                                                            name="tender_participates[{{ $rowIndex }}][company]"
                                                            class="form-control" value="{{ $participant->company_name }}"
                                                            placeholder="Company name">
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            name="tender_participates[{{ $rowIndex }}][price]"
                                                            class="form-control price-input"
                                                            value="{{ $participant->offered_price }}"
                                                            placeholder="Offered price" onchange="reorderTable()">
                                                    </td>
                                                    <td class="position-cell text-center fw-semibold">{{ $rowIndex + 1 }}
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php $rowIndex++; @endphp
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 mt-4" style="text-align: right;">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                        <a href="{{ route('participated_tenders.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>

            {{-- Tab Content --}}
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="bgInfo" role="tabpanel" aria-labelledby="bg-tab">
                    {{-- BG Info Content --}}
                    <div class="card mt-3">
                        <div class="card-body row">
                            <div class="form-group col-md-6">
                                <label for="bg_no">BG Number <span class="text-danger">*</span></label>
                                <input type="text" name="bg_no" class="form-control"
                                    value="{{ old('bg_no', $tenderParticipate->bg->bg_no ?? '') }}">
                                @error('bg_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="issue_in_bank">Issue in Bank <span class="text-danger">*</span></label>
                                <input type="text" name="issue_in_bank" class="form-control"
                                    value="{{ old('issue_in_bank', $tenderParticipate->bg->issue_in_bank ?? '') }}">
                                @error('issue_in_bank')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="issue_in_branch">Issue in Branch <span class="text-danger">*</span></label>
                                <input type="text" name="issue_in_branch" class="form-control"
                                    value="{{ old('issue_in_branch', $tenderParticipate->bg->issue_in_branch ?? '') }}">
                                @error('issue_in_branch')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="issue_date">BG Issue Date <span class="text-danger">*</span></label>
                                <input type="date" name="issue_date" class="form-control"
                                    value="{{ old('issue_date', $tenderParticipate->bg->issue_date ?? '') }}">
                                @if (optional($tenderParticipate->bg)->issue_date)
                                    <small class="text-primary">
                                        [{{ \Carbon\Carbon::parse($tenderParticipate->bg->issue_date)->format('d F Y') }}]
                                    </small>
                                @endif
                                @error('issue_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="expiry_date">BG Expiry Date <span class="text-danger">*</span></label>
                                <input type="date" name="expiry_date" class="form-control"
                                    value="{{ old('expiry_date', $tenderParticipate->bg->expiry_date ?? '') }}">
                                @if (optional($tenderParticipate->bg)->expiry_date)
                                    <small class="text-primary">
                                        [{{ \Carbon\Carbon::parse($tenderParticipate->bg->expiry_date)->format('d F Y') }}]
                                    </small>
                                @endif
                                @error('expiry_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="amount">BG Amount <span class="text-danger">*</span></label>
                                <input type="number" name="amount" step="0.01" class="form-control"
                                    value="{{ old('amount', $tenderParticipate->bg->amount ?? '') }}">
                                @error('amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="attachment">Attachment <span class="text-danger">*</span></label><br>
                                <input type="file" name="attachment" class="form-control mt-2">
                                @if (!empty($tenderParticipate->bg?->attachment))
                                    <a href="{{ asset('uploads/documents/bg_attachments/' . $tenderParticipate->bg->attachment) }}"
                                        target="_blank">View
                                        Current</a><br>
                                @endif
                                @error('attachment')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

@stop
@section('js')
    {{-- Bootstrap and Animate.css --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    {{-- BG Yes Than Show BG Tab --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bgYes = document.getElementById('bg_yes');
            const bgNo = document.getElementById('bg_no');
            const bgTab = document.getElementById('bg-tab');
            const bgPane = document.getElementById('bgInfo');

            function toggleBGTab() {
                if (bgYes.checked) {
                    bgTab.classList.remove('d-none');
                } else {
                    bgTab.classList.add('d-none');

                    // Optional: if BG tab is active, switch to first tab
                    if (bgTab.classList.contains('active')) {
                        document.getElementById('tender-tab').click();
                    }

                    // Also hide tab-pane content if needed
                    bgPane.classList.remove('show', 'active');
                }
            }

            // Event listeners
            bgYes.addEventListener('change', toggleBGTab);
            bgNo.addEventListener('change', toggleBGTab);

            // Initial run
            toggleBGTab();
        });
    </script>

    {{-- Add Item | Calculate Qty * Price | Grand Total --}}
    <script>
        function updateTotal(input) {
            const row = input.closest('tr');
            const qty = parseFloat(row.querySelector('input[name*="[quantity]"]')?.value) || 0;
            const unit = parseFloat(row.querySelector('input[name*="[unit_price]"]')?.value) || 0;
            const total = qty * unit;

            const totalField = row.querySelector('input[name*="[total_price]"]');
            if (totalField) totalField.value = total.toFixed(2);

            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            const totalFields = document.querySelectorAll('input[name*="[total_price]"]');
            let grandTotal = 0;

            totalFields.forEach(field => {
                const val = parseFloat(field.value) || 0;
                grandTotal += val;
            });

            document.getElementById('grand_total').value = grandTotal.toFixed(2);

            const offeredPriceInput = document.getElementById('offered_price');
            if (offeredPriceInput) {
                offeredPriceInput.value = grandTotal.toFixed(2);
            }
        }

        // ✅ Laravel variables to JS
        const denoOptions = {!! json_encode($denoOptions) !!};
        const authCompany = {!! json_encode($organization->name ?? '') !!};
        const authOfferedPrice = {!! json_encode($offered_price ?? '') !!};

        document.addEventListener('DOMContentLoaded', function() {
            // ✅ Date Validation Logic
            const form = document.getElementById('editTenderForm');
            const pubInput = document.getElementById('publication_date');
            const subInput = document.getElementById('submission_date');
            const offerValidityInput = document.getElementById('offer_validity');
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

            if (form) {
                form.addEventListener('submit', function(e) {
                    const pubDate = new Date(pubInput.value);
                    const subDate = new Date(subInput.value);
                    const offerValidityDate = new Date(offerValidityInput.value);
                    const bgIssueInput = document.querySelector('input[name="issue_date"]');
                    const bgExpiryInput = document.querySelector('input[name="expiry_date"]');

                    if (!pubInput.value || !subInput.value) return;

                    if (pubDate > subDate) {
                        e.preventDefault();
                        showSweetError("Publication date cannot be after submission date!");
                        return;
                    }

                    if (offerValidityInput.value && offerValidityDate < pubDate) {
                        e.preventDefault();
                        showSweetError("Offer Validity date cannot be before Publication date!");
                        return;
                    }

                    if (bgIssueInput?.value && bgExpiryInput?.value) {
                        const bgIssueDate = new Date(bgIssueInput.value);
                        const bgExpiryDate = new Date(bgExpiryInput.value);
                        if (bgExpiryDate < bgIssueDate) {
                            e.preventDefault();
                            showSweetError("BG Expiry Date cannot be before BG Issue Date!");
                            return;
                        }
                    }
                });
            }

            function updateSlNumbers() {
                document.querySelectorAll('#item-table tbody tr').forEach((row, index) => {
                    const slCell = row.querySelector('.sl-no');
                    if (slCell) {
                        slCell.textContent = index + 1;
                    }
                });
            }

            // ✅ Item Row Logic
            let rowIndex = {{ isset($items) ? count($items) : 0 }};
            const tableBody = document.querySelector('#item-table tbody');
            const addRowBtn = document.getElementById('add-row');

            if (addRowBtn && tableBody) {
                addRowBtn.addEventListener('click', function() {
                    let optionsHtml = `<option value="">-- Select Denominator --</option>`;
                    denoOptions.forEach(deno => {
                        optionsHtml += `<option value="${deno}">${deno}</option>`;
                    });

                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td><input type="text" name="items[${rowIndex}][item]" class="form-control" placeholder="Item name"></td>
                        <td><select name="items[${rowIndex}][deno]" class="form-control">${optionsHtml}</select></td>
                        <td><input type="number" name="items[${rowIndex}][quantity]" class="form-control" placeholder="Quantity" oninput="updateTotal(this)"></td>
                        <td><input type="number" name="items[${rowIndex}][unit_price]" class="form-control" placeholder="Unit Price" oninput="updateTotal(this)"></td>
                        <td><input type="number" name="items[${rowIndex}][total_price]" class="form-control" placeholder="Total Price" readonly></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                        </td>
                    `;
                    tableBody.appendChild(newRow);
                    rowIndex++;
                });
            }

            // ✅ Remove Row
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-row')) {
                    e.target.closest('tr').remove();
                }
            });
        });
        calculateGrandTotal();
    </script>

    {{-- Start Tender Participates Script --}}
    <script>
        // ✅ Add Participant Row
        window.addRow = function(date) {
            const tbody = document.getElementById('table-' + date);
            const index = tbody?.rows.length || 0;

            const row = `
            <tr>
                <td class="position-cell align-middle text-center">${index + 1}</td>
                <td>
                    <input type="text" name="tender_participates[${date}][${index}][company]" class="form-control"
                        value="" placeholder="Company name" />
                </td>
                <td>
                    <input type="number" step="0.01" name="tender_participates[${date}][${index}][price]" class="form-control price-input"
                        value="" placeholder="Price"
                        onchange="formatAndReorder(this, '${date}')"
                        onblur="formatPrice(this)" />
                </td>
                <td class="position-cell align-middle text-center">${index + 1}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger "
                        onclick="this.closest('tr').remove(); reorderTable('${date}')"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `;
            tbody.insertAdjacentHTML('beforeend', row);
            reorderTable(date);
        };

        // ✅ Reorder by price (lowest price = Position 1)
        window.reorderTable = function(date) {
            const tbody = document.getElementById('table-' + date);
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                const priceA = parseFloat(a.querySelector('input[name*="[price]"]')?.value) || Infinity;
                const priceB = parseFloat(b.querySelector('input[name*="[price]"]')?.value) || Infinity;
                return priceA - priceB;
            });

            rows.forEach((row, index) => {
                tbody.appendChild(row);
                const posCell = row.querySelector('.position-cell');
                if (posCell) {
                    posCell.textContent = index + 1;
                } else {
                    const newTd = document.createElement('td');
                    newTd.className = 'position-cell align-middle text-center';
                    newTd.textContent = index + 1;
                    row.insertBefore(newTd, row.children[2]);
                }

                // ✅ Fix input name indexes after sorting
                row.querySelectorAll('input').forEach(input => {
                    input.name = input.name.replace(/\[\d+]/, `[${index}]`);
                });
            });
        };

        function formatPrice(input) {
            const value = parseFloat(input.value);
            if (!isNaN(value)) {
                input.value = value.toFixed(2);
            }
        }

        function formatAndReorder(input, date) {
            formatPrice(input);
            reorderTable(date);
        }
    </script>

@endsection
