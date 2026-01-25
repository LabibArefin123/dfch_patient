@php $taxIndex = 0; @endphp
<div class="d-flex justify-content-between align-items-center mb-2">
    <h4>Tax Information</h4>
    <button type="button" class="btn btn-success btn-sm" id="add-tax"
        @if (auth()->user()->hasRole('demo')) disabled @endif>+</button>
</div>

<div class="table-responsive">
    <table class="table table-bordered" id="tax-table">
        <thead class="table-dark">
            <tr>
                <th>SL</th>
                <th>Tax License</th>
                <th>Validity</th>
                <th>Financial Year</th>
                <th>Document</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tax-wrapper">
            @foreach ($organization->documents->where('type', 'tax') as $document)
                <tr class="tax-row">
                    <td>{{ $taxIndex + 1 }}</td>
                    <td>
                        {{-- পুরনো ডেটার জন্য hidden id --}}
                        <input type="hidden" name="documents[tax][{{ $taxIndex }}][id]"
                            value="{{ $document->id }}">
                        <input type="hidden" name="documents[tax][{{ $taxIndex }}][type]" value="tax">
                        <input type="text" name="documents[tax][{{ $taxIndex }}][number]" class="form-control"
                            value="{{ old('documents.tax.' . $taxIndex . '.number', $document->number) }}">
                    </td>
                    <td>
                        <input type="date" name="documents[tax][{{ $taxIndex }}][validity]" class="form-control"
                            value="{{ old('documents.tax.' . $taxIndex . '.validity', $document->validity) }}">
                    </td>
                    <td>
                        <select name="documents[tax][{{ $taxIndex }}][financial_year]"
                            id="financialYearSelect_tax_{{ $taxIndex }}" class="form-control"
                            data-selected="{{ old('documents.tax.' . $taxIndex . '.financial_year', $document->financial_year ?? '') }}"></select>
                    </td>
                    <td class="text-center">
                        @if ($document->document && file_exists(public_path('uploads/documents/company_documents/tax/' . $document->document)))
                            <a href="{{ asset('uploads/documents/company_documents/tax/' . $document->document) }}"
                                target="_blank">
                                <i class="fas fa-file-pdf text-danger"></i> View Document
                            </a><br>
                        @else
                            <span class="text-muted">No file</span><br>
                        @endif
                        <input type="file" name="documents[tax][{{ $taxIndex }}][document][]"
                            class="form-control mt-2" multiple>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-tax">Remove</button>
                    </td>
                </tr>
                @php $taxIndex++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let taxIndex = {{ $taxIndex }};
        const maxRows = 15;

        function populateFinancialYearDropdown(select, selectedValue = null) {
            if (!select) return;
            select.innerHTML = '<option value="">Select Year</option>';
            const currentYear = new Date().getFullYear();
            for (let year = currentYear; year >= 1950; year--) {
                let option = document.createElement("option");
                option.value = `${year}-${year + 1}`;
                option.textContent = `${year}-${year + 1}`;
                if (selectedValue && selectedValue === option.value) option.selected = true;
                select.appendChild(option);
            }
        }

        // Populate existing selects
        document.querySelectorAll('#tax-wrapper .tax-row select').forEach(select => {
            populateFinancialYearDropdown(select, select.dataset.selected);
        });

        // Add new row
        document.getElementById('add-tax').addEventListener('click', function() {
            const rowCount = document.querySelectorAll('#tax-wrapper .tax-row').length;
            if (rowCount >= maxRows) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Reached',
                    text: 'You are not allowed to give more than 15 documents',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const tbody = document.getElementById('tax-wrapper');
            const tr = document.createElement('tr');
            tr.classList.add('tax-row');

            tr.innerHTML = `
            <td></td>
            <td>
                <input type="hidden" name="documents[tax][${taxIndex}][type]" value="tax">
                <input type="text" name="documents[tax][${taxIndex}][number]" class="form-control">
            </td>
            <td>
                <input type="date" name="documents[tax][${taxIndex}][validity]" class="form-control">
            </td>
            <td>
                <select name="documents[tax][${taxIndex}][financial_year]" id="financialYearSelect_tax_${taxIndex}" class="form-control"></select>
            </td>
            <td>
                <input type="file" name="documents[tax][${taxIndex}][document][]" class="form-control mt-1" multiple>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-tax">Remove</button>
            </td>
        `;

            tbody.appendChild(tr);
            populateFinancialYearDropdown(tr.querySelector('select'));
            taxIndex++;
            updateSL();
        });

        // Remove row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-tax')) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This tax document will be removed.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it'
                }).then(res => {
                    if (res.isConfirmed) {
                        e.target.closest('tr').remove();
                        updateSL();
                    }
                });
            }
        });

        function updateSL() {
            document.querySelectorAll('#tax-wrapper .tax-row').forEach((row, index) => {
                row.querySelector('td:first-child').textContent = index + 1;
            });
        }
    });
</script>
