@extends('adminlte::page')
@section('title', 'Add Participated Tender')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Create Participated Tender</h1>
        <a href="{{ route('participated_tenders.index') }}"
            class="btn btn-sm btn-warning d-flex align-items-center gap-1 flex-shrink-0">
            <i class="fas fa-arrow-left"></i> Go Back
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

    <form action="{{ route('participated_tenders.store') }}" method="POST" enctype="multipart/form-data" data-confirm="create">
        @csrf

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
                    <div class="card-body row">
                        <div class="form-group col-md-12">
                            <label>BG:</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_bg" id="bg_no"
                                        value="0" {{ old('is_bg') == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bg_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_bg" id="bg_yes"
                                        value="1" {{ old('is_bg') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bg_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        {{-- Tender Select --}}
                        <div class="form-group col-md-6">
                            <label for="tender_id">Tender Number <span class="text-danger">*</span></label>
                            <select name="tender_id" id="tender_id" class="form-control">
                                <option value="">-- Select Tender --</option>
                                @foreach ($tenders as $tender)
                                    <option value="{{ $tender->id }}">
                                        {{ $tender->title }} ({{ $tender->tender_no }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tender Title --}}
                        <div class="form-group col-md-6">
                            <label for="title" class="form-label">Tender Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Tender Title" value="{{ old('title') }}" readonly>
                        </div>

                        {{-- Procuring Authority --}}
                        <div class="form-group col-md-6">
                            <label for="procuring_authority" class="form-label">Procuring Authority <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="procuring_authority" id="procuring_authority" class="form-control"
                                placeholder="Enter Procuring Authority" value="{{ old('procuring_authority') }}" readonly>
                        </div>

                        {{-- End User --}}
                        <div class="form-group col-md-6">
                            <label for="end_user" class="form-label">End User <span class="text-danger">*</span></label>
                            <input type="text" name="end_user" id="end_user" class="form-control"
                                placeholder="Enter End User" value="{{ old('end_user') }}" readonly>
                        </div>

                        {{-- Financial Year --}}
                        <div class="form-group col-md-6">
                            <label for="financial_year">FY (Financial Year) <span class="text-danger">*</span></label>
                            <select name="financial_year" id="financial_year" class="form-control" readonly>
                                <option value="">Select Financial Year</option>
                                @for ($year = 2026; $year >= 2005; $year--)
                                    @php $fy = $year . '-' . ($year + 1); @endphp
                                    <option value="{{ $fy }}"
                                        {{ old('financial_year') == $fy ? 'selected' : '' }}>
                                        {{ $fy }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Tender Type --}}
                        <div class="form-group col-md-6">
                            <label for="tender_type" class="form-label">Tender Type <span
                                    class="text-danger">*</span></label>
                            <select name="tender_type" id="tender_type" class="form-control" readonly>
                                <option value="">-- Select Tender Type --</option>

                                {{-- Dynamically fetched types --}}
                                @foreach ($tenders as $t)
                                    @if (!in_array($t->name, $commonTenders ?? []))
                                        <option value="{{ $t->name }}"
                                            {{ old('tender_type') == $t->name ? 'selected' : '' }}>
                                            {{ $t->name }}
                                        </option>
                                    @endif
                                @endforeach

                                {{-- Common Options --}}
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
                                @foreach ($commonTenders as $option)
                                    <option value="{{ $option }}"
                                        {{ old('tender_type') == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @php
                            $commonDenos = [
                                'Piece',
                                'Kg',
                                'Gram',
                                'Line',
                                'No',
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

                            // Optional: load additional denos from DB if $denos is available
                            $additionalDenos = isset($denos)
                                ? $denos->pluck('name')->diff($commonDenos)->toArray()
                                : [];

                            $allDenos = array_merge($commonDenos, $additionalDenos);
                            sort($allDenos, SORT_STRING | SORT_FLAG_CASE);
                        @endphp


                        <div class="form-group col-12">
                            <label class="form-label">Item Details <span class="text-danger">*</span></label>

                            <table class="table table-bordered" id="item-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>SL</th>
                                        <th width="35%">Item</th>
                                        <th width="14%">Deno</th>
                                        <th width="14%">Quantity</th>
                                        <th width="20%">Unit Price</th>
                                        <th width="20%">Total Price</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $oldItems = old('items', [[]]); // Always at least one empty row
                                    @endphp

                                    @foreach ($oldItems as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][item]"
                                                    class="form-control" placeholder="Enter Item Name"
                                                    value="{{ $item['item'] ?? '' }}">
                                            </td>
                                            <td>
                                                <select name="items[{{ $index }}][deno]" class="form-control">
                                                    <option value="">-- Select Denominator --</option>
                                                    @foreach ($allDenos as $denoOption)
                                                        <option value="{{ $denoOption }}"
                                                            {{ ($item['deno'] ?? '') === $denoOption ? 'selected' : '' }}>
                                                            {{ $denoOption }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][quantity]"
                                                    class="form-control" placeholder="Quantity"
                                                    value="{{ $item['quantity'] ?? '' }}" oninput="updateTotal(this)">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][unit_price]"
                                                    class="form-control" placeholder="Unit Price"
                                                    value="{{ $item['unit_price'] ?? '' }}" oninput="updateTotal(this)">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][total_price]"
                                                    class="form-control" placeholder="Total Price" readonly
                                                    value="{{ $item['total_price'] ?? '' }}">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-success btn-sm" id="add-row">
                                                    <i class="fas fa-plus"></i>
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
                        </div>

                        {{-- Publication Date --}}
                        <div class="form-group col-md-6">
                            <label for="publication_date" class="form-label">
                                Publication Date <span class="text-danger">*</span>
                                <small class="text-secondary">(mm-dd-yyyy)</small>
                            </label>
                            <div class="input-group">
                                <input type="text" name="publication_date" id="publication_date" class="form-control"
                                    readonly value="{{ old('publication_date') }}" readonly>
                                <span class="input-group-text" id="publication_date_icon"><i
                                        class="fas fa-calendar-alt"></i></span>
                            </div>
                        </div>

                        {{-- Submission Date --}}
                        <div class="form-group col-md-6">
                            <label for="submission_date" class="form-label">
                                Submission Date <span class="text-danger">*</span>
                                <small class="text-secondary">(mm-dd-yyyy)</small>
                            </label>
                            <div class="input-group">
                                <input type="text" name="submission_date" id="submission_date" class="form-control"
                                    readonly value="{{ old('submission_date') }}" readonly>
                                <span class="input-group-text" id="submission_date_icon"><i
                                        class="fas fa-calendar-alt"></i></span>
                            </div>
                        </div>

                        {{-- Submission Time --}}
                        <div class="form-group col-md-6">
                            <label for="submission_time">Submission Time <span class="text-danger">*</span></label>
                            <input type="text" name="submission_time" id="submission_time" class="form-control"
                                value="{{ old('submission_time') ? \Carbon\Carbon::parse(old('submission_time'))->format('g:i A') : '' }}"
                                readonly>
                        </div>


                        <div class="form-group col-md-6">
                            <label for="offer_no">Offer No <span class="text-danger">*</span></label>
                            <input type="text" name="offer_no" class="form-control" value="{{ old('offer_no') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="offer_date">Offer Date <span class="text-danger">*</span></label>
                            <input type="date" name="offer_date" class="form-control"
                                value="{{ old('offer_date') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="offer_validity">Offer Validity <span class="text-danger">*</span></label>
                            <input type="date" name="offer_validity" class="form-control"
                                value="{{ old('offer_validity') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="offer_doc">Offer Document <span class="text-danger">*</span></label>
                            <input type="file" name="offer_doc" class="form-control">
                        </div>

                        <div class="form-group col-md-12">
                            <label class="fw-bold mb-2">Tender's Participate Company</label>

                            <div class="tab-content" id="participates-tabContent">
                                @php
                                    // Prepare safe variables in PHP first
                                    $oldTenderId = old('tender_id', '');
                                    $oldCompanies = old('tender_participates', []);
                                @endphp

                                @if (empty($oldCompanies) && $groupedCompanies->isEmpty())
                                    {{-- Default tab when no old data and no DB data --}}
                                    <div class="tab-pane fade show active" id="pane-default" role="tabpanel">
                                        <table class="table table-bordered align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Company</th>
                                                    <th>Offered Price</th>
                                                    <th>Position</th>
                                                    <th style="width: 50px;">
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="addRow('default')">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-default">
                                                <tr>
                                                    <td class="sl-cell text-center fw-semibold">1</td>
                                                    <td>
                                                        <input type="text"
                                                            name="tender_participates[default][0][company]"
                                                            class="form-control" value="{{ $organization->name ?? '' }}"
                                                            placeholder="Company name">
                                                    </td>
                                                    <td>
                                                        <input type="number"
                                                            name="tender_participates[default][0][price]"
                                                            class="form-control price-input"
                                                            value="{{ $offered_price ?? '' }}"
                                                            placeholder="Offered price" onchange="reorderTable('default')"
                                                            readonly>
                                                    </td>
                                                    <td class="position-cell text-center fw-semibold">1</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    @foreach ($oldCompanies ?: $groupedCompanies as $date => $companies)
                                        <div class="tab-pane fade @if ($loop->first) show active @endif"
                                            id="pane-{{ $date }}" role="tabpanel">
                                            <table class="table table-bordered align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Company</th>
                                                        <th>Offered Price</th>
                                                        <th>Position</th>
                                                        <th style="width: 50px;">
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="addRow('{{ $date }}')">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-{{ $date }}">
                                                    @foreach ($companies as $index => $participant)
                                                        @php
                                                            $company = is_array($participant)
                                                                ? $participant['company'] ?? ''
                                                                : $participant->company_name ?? '';
                                                            $price = is_array($participant)
                                                                ? $participant['price'] ?? ''
                                                                : $participant->offered_price ?? '';
                                                        @endphp
                                                        <tr>
                                                            <td class="sl-cell text-center fw-semibold">
                                                                {{ $loop->iteration }}</td>
                                                            <td>
                                                                <input type="text"
                                                                    name="tender_participates[{{ $date }}][{{ $index }}][company]"
                                                                    class="form-control"
                                                                    value="{{ old("tender_participates.$date.$index.company", $company) }}"
                                                                    placeholder="Company name">
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    name="tender_participates[{{ $date }}][{{ $index }}][price]"
                                                                    class="form-control price-input"
                                                                    value="{{ old("tender_participates.$date.$index.price", $price) }}"
                                                                    placeholder="Offered price"
                                                                    onchange="reorderTable('{{ $date }}')"
                                                                    readonly>
                                                            </td>
                                                            <td class="position-cell text-center fw-semibold">
                                                                {{ $loop->iteration }}</td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm remove-row">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-12 mt-4" style="text-align: right;">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="bgInfo" role="tabpanel" aria-labelledby="bg-tab">
                {{-- BG Info Content --}}
                <div class="card mt-3">
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="bg_no">BG Number <span class="text-danger">*</span></label>
                            <input type="text" name="bg_no" class="form-control"
                                value="{{ old('bg_no', $bg_no ?? '') }}">
                            @error('bg_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="issue_in_bank">Issue in Bank <span class="text-danger">*</span></label>
                            <input type="text" name="issue_in_bank" class="form-control"
                                value="{{ old('issue_in_bank', $issue_in_bank ?? '') }}">
                            @error('issue_in_bank')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="issue_in_branch">Issue in Branch <span class="text-danger">*</span></label>
                            <input type="text" name="issue_in_branch" class="form-control"
                                value="{{ old('issue_in_branch', $issue_in_branch ?? '') }}">
                            @error('issue_in_branch')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="issue_date">BG Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="issue_date" class="form-control"
                                value="{{ old('issue_date', $issue_date ?? '') }}">
                            @error('issue_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="expiry_date">BG Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" name="expiry_date" class="form-control"
                                value="{{ old('expiry_date', $expiry_date ?? '') }}">
                            @error('expiry_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="amount">BG Amount <span class="text-danger">*</span></label>
                            <input type="number" name="amount" step="0.01" class="form-control"
                                value="{{ old('amount', $amount ?? '') }}">
                            @error('amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="attachment">Attachment <span class="text-danger">*</span></label><br>
                            <input type="file" name="attachment" class="form-control mt-2">
                            @if (!empty($tenderParticipate->bg?->attachment))
                                <a href="{{ asset('uploads/documents/bg_attachments/' . $attachment) }}"
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
    </form>
@endsection

@section('js')
    <!-- Bootstrap + Animate -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script>
        const tenders = @json($tenders);
        const groupedCompanies = @json($groupedCompanies);
        const authCompanyName = @json(optional($organization)->name); // ✅ only the name
        const oldTenderId = @json(old('tender_id'));
        const oldCompanies = @json($oldCompanies);

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str ?? '';
            return div.innerHTML;
        }

        /** =============================
         *  Tender Info & Items
         *  ============================= */
        function fillTenderFields(selectedId) {
            const tender = tenders.find(t => t.id == selectedId);
            if (!tender) return;

            const fields = {
                title: tender.title,
                procuring_authority: tender.procuring_authority,
                end_user: tender.end_user,
                publication_date: tender.publication_date,
                submission_date: tender.submission_date,
                submission_time: tender.submission_time,
            };

            Object.entries(fields).forEach(([field, value]) => {
                const input = document.getElementById(field);
                if (input) {
                    input.value = value ?? '';
                    input.readOnly = true;
                    input.disabled = true;
                    input.classList.add('bg-light');
                }
            });

            const tenderType = document.getElementById('tender_type');
            if (tenderType) {
                tenderType.value = tender.tender_type ?? '';
                tenderType.disabled = true;
                tenderType.classList.add('bg-light');
            }

            const fy = document.getElementById('financial_year');
            if (fy) {
                fy.value = tender.financial_year ?? '';
                fy.disabled = true;
                fy.classList.add('bg-light');
            }

            fillItemTable(tender);
            calculateGrandTotal();
            fillParticipantCompanies();
        }

        function fillItemTable(tender) {
            const tbody = document.querySelector('#item-table tbody');

            // 🔹 Check if Blade rendered old values
            const oldRows = tbody.querySelectorAll('tr');
            const hasOldValues = [...oldRows].some(row => {
                const unitPriceInput = row.querySelector('input[name*="[unit_price]"]');
                return unitPriceInput && unitPriceInput.value.trim() !== '';
            });

            if (hasOldValues) {
                // Keep old values, just recalc grand total
                calculateGrandTotal();
                return;
            }

            // 🔹 If no old values, load from tender.items
            tbody.innerHTML = '';

            try {
                const items = JSON.parse(tender.items ?? '[]');
                if (!Array.isArray(items) || items.length === 0) {
                    tbody.innerHTML =
                        `<tr><td colspan="7" class="text-center text-muted">No item data available.</td></tr>`;
                    return;
                }

                items.forEach((item, i) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td class="text-center sl-cell">${i + 1}</td>
                <td><input type="text" class="form-control bg-light" readonly name="items[${i}][item]" value="${escapeHtml(item.item)}"></td>
                <td><input type="text" class="form-control bg-light" readonly name="items[${i}][deno]" value="${escapeHtml(item.deno)}"></td>
                <td><input type="text" class="form-control bg-light" readonly name="items[${i}][quantity]" value="${escapeHtml(item.quantity)}"></td>
                <td><input type="text" class="form-control" name="items[${i}][unit_price]" value="${escapeHtml(item.unit_price)}" oninput="updateTotal(this)"></td>
                <td><input type="text" class="form-control bg-light" readonly name="items[${i}][total_price]" value="${escapeHtml(item.total_price)}"></td>
                <td class="text-center"><button type="button" class="btn btn-secondary btn-sm" disabled><i class="fas fa-lock"></i></button></td>
            `;
                    tbody.appendChild(row);
                });

            } catch (e) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Invalid item format</td></tr>`;
            }

            calculateGrandTotal();
        }


        /** =============================
         *  Participant Companies Handling
         *  ============================= */
        function fillParticipantCompanies() {
            for (const date in groupedCompanies) {
                const tbody = document.getElementById('table-' + date);
                if (!tbody) continue;
                tbody.innerHTML = '';

                const oldRows = oldCompanies[date] || [];
                const rows = [];

                if (oldRows.length > 0) {
                    oldRows.forEach((row, i) => {
                        const tr = document.createElement('tr');
                        const isOwnCompany = row.company === authCompanyName;
                        tr.innerHTML = `
                        <td class="sl-cell text-center fw-semibold">${i + 1}</td>
                        <td><input type="text" name="tender_participates[${date}][${i}][company]"
                                   class="form-control ${isOwnCompany ? 'bg-light' : ''}"
                                   value="${escapeHtml(row.company)}" ${isOwnCompany ? 'readonly' : ''}></td>
                        <td><input type="number" step="0.01"
                                   name="tender_participates[${date}][${i}][price]"
                                   class="form-control ${isOwnCompany ? 'bg-light' : ''}"
                                   value="${escapeHtml(row.price)}"
                                   onchange="formatAndReorder(this,'${date}')"></td>
                        <td class="position-cell text-center fw-semibold">${i + 1}</td>
                        <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this,'${date}')"><i class="fas fa-trash"></i></button></td>
                    `;
                        rows.push(tr);
                    });
                } else {
                    const grandTotal = document.getElementById('grand_total')?.value ?? '0.00';
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td class="sl-cell text-center fw-semibold">1</td>
                    <td><input type="text" name="tender_participates[${date}][0][company]" class="form-control bg-light" value="${escapeHtml(authCompanyName)}" readonly></td>
                    <td><input type="number" step="0.01" name="tender_participates[${date}][0][price]" class="form-control bg-light" value="${escapeHtml(grandTotal)}" onchange="formatAndReorder(this,'${date}')"></td>
                    <td class="position-cell text-center fw-semibold">1</td>
                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this,'${date}')"><i class="fas fa-trash"></i></button></td>
                `;
                    rows.push(tr);
                }

                rows.forEach(r => tbody.appendChild(r));
                reorderTable(date);
            }
        }

        window.addRow = function(date) {
            const tbody = document.getElementById('table-' + date);
            const index = tbody.rows.length;

            const row = document.createElement('tr');
            row.innerHTML = `
            <td class="sl-cell text-center fw-semibold">${index + 1}</td>
            <td><input type="text" name="tender_participates[${date}][${index}][company]" class="form-control" placeholder="Company name"></td>
            <td><input type="number" step="0.01" name="tender_participates[${date}][${index}][price]" class="form-control" placeholder="Offered Price" onchange="formatAndReorder(this,'${date}')"></td>
            <td class="position-cell text-center fw-semibold">${index + 1}</td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this,'${date}')"><i class="fas fa-trash"></i></button></td>
        `;
            tbody.appendChild(row);
            reorderTable(date);
        };

        window.removeRow = function(btn, date) {
            btn.closest('tr').remove();
            reorderTable(date);
        };

        window.reorderTable = function(date) {
            const tbody = document.getElementById('table-' + date);
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                const priceA = parseFloat(a.querySelector('input[name*="[price]"]')?.value) || Infinity;
                const priceB = parseFloat(b.querySelector('input[name*="[price]"]')?.value) || Infinity;
                return priceA - priceB;
            });

            rows.forEach((row, i) => {
                row.querySelector('.sl-cell').textContent = i + 1;
                row.querySelector('.position-cell').textContent = i + 1;
                tbody.appendChild(row);
            });
        };

        /** =============================
         *  Totals & Calculations
         *  ============================= */
        function updateTotal(input) {
            const row = input.closest('tr');
            const qty = parseFloat(row.querySelector('input[name*="[quantity]"]')?.value) || 0;
            const unit = parseFloat(row.querySelector('input[name*="[unit_price]"]')?.value) || 0;
            const total = qty * unit;
            const totalField = row.querySelector('input[name*="[total_price]"]');
            if (totalField) totalField.value = total.toFixed(2);

            calculateGrandTotal();
            fillParticipantCompanies();
        }

        function calculateGrandTotal() {
            let total = 0;
            document.querySelectorAll('input[name*="[total_price]"]').forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            const grandInput = document.getElementById('grand_total');
            if (grandInput) grandInput.value = total.toFixed(2);

            const offeredPriceInput = document.getElementById('offered_price');
            if (offeredPriceInput) offeredPriceInput.value = total.toFixed(2);
        }

        function formatPrice(input) {
            const value = parseFloat(input.value);
            if (!isNaN(value)) input.value = value.toFixed(2);
        }

        function formatAndReorder(input, date) {
            formatPrice(input);
            reorderTable(date);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('tender_id');
            if (select) {
                if (oldTenderId) select.value = oldTenderId;
                fillTenderFields(select.value || select.options[0]?.value);

                select.addEventListener('change', function() {
                    fillTenderFields(this.value);
                });
            }

            for (const date in groupedCompanies) reorderTable(date);
        });
    </script>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const requiredFields = [
                'tender_id',
                'title',
                'offer_no',
                'offer_date',
                'offer_validity',
                'offer_doc',
            ];

            let isFormDirty = false;

            // Add change event listener for each required field by ID
            requiredFields.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('change', () => {
                        isFormDirty = true;
                    });
                }
            });

            // Function to check if any required field is empty
            function hasUnfilledFields() {
                return requiredFields.some(id => {
                    const el = document.getElementById(id);
                    return el && el.value.trim() === '';
                });
            }

            // Mark form dirty on any input/select/textarea change
            document.querySelectorAll('input, select, textarea').forEach(input => {
                input.addEventListener('input', () => {
                    isFormDirty = true;
                });
            });

            // Warn on page refresh or close if form dirty and fields unfilled
            window.addEventListener('beforeunload', function(e) {
                if (isFormDirty && hasUnfilledFields()) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });

            // Trap back navigation if required fields are empty
            history.pushState(null, null, location.href);
            window.addEventListener('popstate', function() {
                if (!hasUnfilledFields()) return;

                history.pushState(null, null, location.href); // trap back again

                Swal.fire({
                    title: 'Incomplete Fields Detected',
                    html: `You have to fill up those required <span class="text-danger">[*]</span> fields.<br><br>Do you want to stay on this page?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then(result => {
                    if (!result.isConfirmed) {
                        window.location.href = "{{ route('participated_tenders.index') }}";
                    }
                });
            });
        });
    </script>
@endsection
