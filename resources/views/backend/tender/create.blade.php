@extends('adminlte::page')

@section('title', 'Create Tender')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Add New Tender</h1>
        @if (auth()->user()->role?->name !== 'user')
            <button href="{{ route('tenders.index') }}"
                class="btn btn-sm btn-warning d-flex align-items-center gap-1 back-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 0 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z" />
                </svg>
                Go Back
            </button>
        @endif
    </div>
@stop

@section('content')
    <div id="dateErrorBox"
        class="position-fixed top-50 start-50 translate-middle bg-white border border-danger rounded shadow-lg px-4 py-3 text-center"
        style="display: none; z-index: 9999; min-width: 300px;">
        <div class="d-flex justify-content-center mb-2">
            <i class="fas fa-exclamation-triangle text-danger fa-2x animate__animated animate__bounceIn"></i>
        </div>
        <strong class="text-danger fs-5">Oops!</strong>
        <p class="mb-0 text-dark">Publication date cannot be after submission date!</p>
    </div>

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

    <form action="{{ route('tenders.store') }}" method="POST" enctype="multipart/form-data" data-confirm="create">
        @csrf
        {{-- Personal Info --}}
        <div class="card">
            <div class="card-body pb-5">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="tender_no" class="form-label">Tender Number <span class="text-danger">*</span></label>
                        <input type="text" name="tender_no" id="tender_no" class="form-control" placeholder=""
                            value="{{ old('tender_no') }}">
                        @error('tender_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="title" class="form-label">Tender Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder=""
                            value="{{ old('title') }}">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="procuring_authority" class="form-label">Procuring Authority <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <select name="procuring_authority" id="procuring_authority" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach ($procuringAuthorities as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="addCompany('procuring_authority')">+</button>
                        </div>
                    </div>
                    <script>
                        function addCompany(type) {
                            const value = prompt(`Enter new ${type.replace('_', ' ')}`);

                            if (!value || value.trim() === '') {
                                return;
                            }

                            fetch("{{ url('/add-supplier-option') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": '{{ csrf_token() }}',
                                    },
                                    body: JSON.stringify({
                                        field_type: type,
                                        value: value.trim()
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        const select = document.getElementById(type);
                                        const option = document.createElement("option");
                                        option.value = data.value;
                                        option.text = data.value;
                                        select.appendChild(option);
                                        select.value = data.value;

                                        document.getElementById('notifyText').innerText = data.message;
                                        const toast = new bootstrap.Toast(document.getElementById('notifyToast'));
                                        toast.show();
                                    } else {
                                        alert('Something went wrong!');
                                    }
                                })
                                .catch(() => {
                                    alert('Error occurred. Please try again.');
                                });
                        }
                    </script>

                    <div class="form-group col-md-6">
                        <label for="end_user" class="form-label">End User <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select name="end_user" id="end_user" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach ($endUsers as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="addCompany('end_user')">+</button>
                        </div>
                    </div>

                    {{-- Toast Notification --}}
                    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                        <div id="notifyToast" class="toast align-items-center text-white bg-success border-0" role="alert"
                            aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body" id="notifyText">Item added successfully!</div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="financial_year">FY (Financial Year) <span class="text-danger">*</span></label>
                        <select name="financial_year" id="financial_year" class="form-control">
                            <option value="">Select Financial Year</option>
                            @for ($year = 2026; $year >= 2005; $year--)
                                @php $fy = $year . '-' . ($year + 1); @endphp
                                <option value="{{ $fy }}" {{ old('financial_year') == $fy ? 'selected' : '' }}>
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
                            <select name="tender_type" id="tender_type" class="form-control">
                                <option value="">-- Select Tender Type --</option>

                                {{-- 🔁 Dynamically fetched types FIRST --}}
                                @if (!empty($tenders))
                                    @foreach ($tenders as $t)
                                        @if (!in_array($t->name, $commonTenders))
                                            <option value="{{ $t->name }}"
                                                {{ old('tender_type') == $t->name ? 'selected' : '' }}>
                                                {{ $t->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endif

                                {{-- 🔁 Then show common predefined options --}}
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

                                @foreach ($commonTenders as $tenderOption)
                                    <option value="{{ $tenderOption }}"
                                        {{ old('tender_type') == $tenderOption ? 'selected' : '' }}>
                                        {{ $tenderOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('tender_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
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

                        $additionalDenos = !empty($denos) ? $denos->pluck('name')->diff($commonDenos)->toArray() : [];

                        $allDenos = array_merge($commonDenos, $additionalDenos);
                        sort($allDenos, SORT_STRING | SORT_FLAG_CASE);

                        $oldItems = old('items') ?? [['item' => '', 'deno' => '', 'quantity' => '']];
                    @endphp

                    <div class="form-group col-12">
                        <label class="form-label">Item Details <span class="text-danger">*</span></label>

                        <table class="table table-bordered" id="item-table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th width="35%">Item</th>
                                    <th width="20%">Deno</th>
                                    <th width="20%">Quantity</th>
                                    <th width="10%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($oldItems as $index => $item)
                                    <tr>
                                        <td class="sl-no text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <input type="text" name="items[{{ $index }}][item]"
                                                class="form-control" value="{{ $item['item'] ?? '' }}"
                                                placeholder="Enter Item Name">
                                        </td>
                                        <td class="deno-cell">
                                            <div class="input-group">
                                                <select name="items[{{ $index }}][deno]"
                                                    class="form-control deno-select">
                                                    <option value="">-- Select Denominator --</option>
                                                    @foreach ($allDenos as $denoOption)
                                                        <option value="{{ $denoOption }}"
                                                            {{ ($item['deno'] ?? '') == $denoOption ? 'selected' : '' }}>
                                                            {{ $denoOption }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-outline-primary btn-sm add-deno-btn"
                                                    title="Add new Deno">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>

                                        <td>
                                            <input type="number" name="items[{{ $index }}][quantity]"
                                                class="form-control" value="{{ $item['quantity'] ?? '' }}"
                                                placeholder="Quantity">
                                        </td>
                                        <td class="text-center">
                                            @if ($loop->first)
                                                <button type="button" class="btn btn-success btn-sm" id="add-row">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-danger btn-sm remove-row">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="publication_date" class="form-label">
                            Publication Date <span class="text-danger">*</span>
                            <small class="text-secondary">(mm-dd-yyyy)</small>
                        </label>
                        <div class="input-group">
                            <input type="date" name="publication_date" id="publication_date" class="form-control"
                                value="{{ old('publication_date') }}" >
                           
                        </div>
                        @error('publication_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="submission_date" class="form-label">Submission Date <span
                                class="text-danger">*</span>
                            <small class="text-secondary">(mm-dd-yyyy)</small></label>
                        <div class="input-group">
                            <input type="date" name="submission_date" id="submission_date" class="form-control"
                                value="{{ old('submission_date') }}">
                           
                        </div>
                        @error('submission_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group col-md-6">
                        <label for="submission_time">Submission Time <span class="text-danger">*</span></label>
                        <input type="time" name="submission_time" id="submission_time" class="form-control"
                            step="60"
                            value="{{ old('submission_time') ?? (isset($tender) ? $tender->submission_time : '') }}"
                            placeholder="HH:MM">
                        @error('submission_time')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="spec_file" class="form-label">Tender Specification File <span
                                class="text-danger">*</span></label>
                        <input type="file" name="spec_file" id="spec_file" class="form-control">
                        @error('spec_file')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        @if (old('spec_file'))
                            <small class="text-success d-block mt-1">File uploaded previously. Please re-upload due to
                                validation error.</small>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="notice_file" class="form-label">Tender Notice File <span
                                class="text-danger">*</span></label>
                        <input type="file" name="notice_file" id="notice_file" class="form-control">
                        @error('notice_file')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        @if (old('notice_file'))
                            <small class="text-success d-block mt-1">File uploaded previously. Please re-upload due to
                                validation error.</small>
                        @endif
                    </div>
                    <div class="form-group col-12 mt-4"
                        style="text-align: right; margin-top: 1.5rem; margin-bottom: 0.5rem;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

@stop

@section('js')
    {{-- ✦ External Scripts --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 🔁 Setup constants
            let rowIndex = {{ count($oldItems) }};
            const tbody = document.querySelector('#item-table tbody');

            // 🔁 Function to update SL numbers
            function updateSerialNumbers() {
                const slCells = tbody.querySelectorAll('tr .sl-no');
                slCells.forEach((cell, index) => {
                    cell.textContent = index + 1;
                });
            }

            // ➕ Add new row
            document.getElementById('add-row')?.addEventListener('click', () => {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td class="sl-no text-center"></td>
            <td>
                <input type="text" name="items[${rowIndex}][item]" class="form-control" placeholder="Enter Item Name">
            </td>
            <td class="deno-cell">
                <div class="input-group">
                    <select name="items[${rowIndex}][deno]" class="form-control deno-select">
                        <option value="">-- Select Denominator --</option>
                        @foreach ($allDenos as $deno)
                            <option value="{{ $deno }}">{{ $deno }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-primary btn-sm add-deno-btn" title="Add new Deno">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </td>
            <td>
                <input type="number" name="items[${rowIndex}][quantity]" class="form-control" placeholder="Quantity">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
                tbody.appendChild(row);
                rowIndex++;
                updateSerialNumbers();
            });

            // ➖ Remove row
            tbody.addEventListener('click', function(e) {
                if (e.target.closest('.remove-row')) {
                    const row = e.target.closest('tr');
                    row.remove();
                    updateSerialNumbers();
                }
            });

            // 🗑 Remove row
            tbody.addEventListener('click', function(e) {
                if (e.target.closest('.remove-row')) {
                    e.target.closest('tr')?.remove();
                }
            });

            // ➕ Add custom Deno logic (delegated event)
            document.addEventListener('click', function(e) {
                const addBtn = e.target.closest('.add-deno-btn');
                if (addBtn) {
                    const select = addBtn.closest('.input-group').querySelector('select');
                    const newDeno = prompt('Enter new Deno name:');
                    if (newDeno) {
                        const exists = Array.from(select.options).some(option =>
                            option.value.toLowerCase() === newDeno.toLowerCase()
                        );
                        if (!exists) {
                            const option = new Option(newDeno, newDeno, true, true);
                            select.add(option);
                            alert(`'${newDeno}' added and selected.`);
                        } else {
                            alert('Deno already exists.');
                            select.value = newDeno;
                        }
                    }
                }
            });

            // 🗓 Flatpickr
            const publicationInput = document.getElementById('publication_date');
            const submissionInput = document.getElementById('submission_date');

            const publicationCalendar = flatpickr(publicationInput, {
                dateFormat: "j F Y",
                defaultDate: "{{ old('publication_date') }}",
                allowInput: true
            });

            const submissionCalendar = flatpickr(submissionInput, {
                dateFormat: "j F Y",
                defaultDate: "{{ old('submission_date') }}",
                allowInput: true
            });

            document.getElementById('publication_date_icon')?.addEventListener('click', () => {
                publicationCalendar.open();
            });

            document.getElementById('submission_date_icon')?.addEventListener('click', () => {
                submissionCalendar.open();
            });

            function validateDateLogic() {
                const pubDate = new Date(publicationInput.value);
                const subDate = new Date(submissionInput.value);
                if (publicationInput.value && submissionInput.value && pubDate > subDate) {
                    showAlert("Publication date cannot be after submission date!");
                    publicationInput.value = '';
                    submissionInput.value = '';
                }
            }

            publicationInput.addEventListener('change', validateDateLogic);
            submissionInput.addEventListener('change', validateDateLogic);

            // ❗ Sweet Alert
            function showAlert(message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: message,
                    timer: 3000,
                    showConfirmButton: false
                });
            }

            // 📂 File validation
            const maxFileSize = 5 * 1024 * 1024;
            const specFileInput = document.getElementById('spec_file');
            const noticeFileInput = document.getElementById('notice_file');

            function validateFileSize(inputElement) {
                if (inputElement.files.length > 0) {
                    const file = inputElement.files[0];
                    if (file.size > maxFileSize) {
                        inputElement.value = '';
                        showAlert('The selected file must be less than 5 MB.');
                    }
                }
            }

            specFileInput?.addEventListener('change', function() {
                validateFileSize(this);
            });

            noticeFileInput?.addEventListener('change', function() {
                validateFileSize(this);
            });

        });
    </script>
@stop
