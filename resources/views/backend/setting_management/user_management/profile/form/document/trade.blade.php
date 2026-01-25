@php $tradeIndex = 0; @endphp
<div class="d-flex justify-content-between align-items-center mb-2">
    <h4>Trade Information</h4>
    <button type="button" class="btn btn-success btn-sm" id="add-trade"
        @if (auth()->user()->hasRole('demo')) disabled @endif>+</button>
</div>

<div class="table-responsive">
    <table class="table table-bordered" id="trade-table">
        <thead class="table-dark">
            <tr>
                <th>SL</th>
                <th>Trade License</th>
                <th>Validity</th>
                <th>Financial Year</th>
                <th>Document</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="trade-wrapper">
            @foreach ($organization->documents->where('type', 'trade') as $document)
                <tr class="trade-row">
                    <td>{{ $tradeIndex + 1 }}</td>
                    <td>
                        <input type="hidden" name="documents[trade][{{ $tradeIndex }}][id]"
                            value="{{ $document->id }}">
                        <input type="text" name="documents[trade][{{ $tradeIndex }}][number]" class="form-control"
                            value="{{ old('documents.trade.' . $tradeIndex . '.number', $document->number) }}">
                    </td>
                    <td>
                        <input type="date" name="documents[trade][{{ $tradeIndex }}][validity]"
                            class="form-control"
                            value="{{ old('documents.trade.' . $tradeIndex . '.validity', $document->validity) }}">
                    </td>
                    <td>
                        <select name="documents[trade][{{ $tradeIndex }}][financial_year]"
                            id="financialYearSelect_{{ $tradeIndex }}" class="form-control"
                            data-selected="{{ old('documents.trade.' . $tradeIndex . '.financial_year', $document->financial_year ?? '') }}">
                        </select>
                    </td>
                    <td class="text-center">
                        @if ($document->document && file_exists(public_path('uploads/documents/company_documents/trade/' . $document->document)))
                            <a href="{{ asset('uploads/documents/company_documents/trade/' . $document->document) }}"
                                target="_blank">
                                <i class="fas fa-file-pdf text-danger"></i> View Document
                            </a><br>
                        @else
                            <span class="text-muted">No file</span><br>
                        @endif
                        <input type="file" name="documents[trade][{{ $tradeIndex }}][document][]"
                            class="form-control mt-2" multiple>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-trade">Remove</button>
                    </td>
                </tr>
                @php $tradeIndex++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let tradeIndex = {{ $tradeIndex }};
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
        document.querySelectorAll('#trade-wrapper .trade-row select').forEach(select => {
            populateFinancialYearDropdown(select, select.dataset.selected);
        });

        // Add new row
        document.getElementById('add-trade').addEventListener('click', function() {
            const rowCount = document.querySelectorAll('#trade-wrapper .trade-row').length;
            if (rowCount >= maxRows) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Reached',
                    text: 'You are not allowed to give more than 15 documents',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const tbody = document.getElementById('trade-wrapper');
            const tr = document.createElement('tr');
            tr.classList.add('trade-row');

            tr.innerHTML = `
            <td></td>
            <td>
                <input type="text" name="documents[trade][${tradeIndex}][number]" class="form-control">
            </td>
            <td>
                <input type="date" name="documents[trade][${tradeIndex}][validity]" class="form-control">
            </td>
            <td>
                <select name="documents[trade][${tradeIndex}][financial_year]" id="financialYearSelect_${tradeIndex}" class="form-control"></select>
            </td>
            <td>
                <input type="file" name="documents[trade][${tradeIndex}][document][]" class="form-control mt-1" multiple>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-trade">Remove</button>
            </td>
        `;

            tbody.appendChild(tr);
            populateFinancialYearDropdown(tr.querySelector('select'));
            tradeIndex++;
            updateSL();
        });

        // Remove row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-trade')) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This trade document will be removed.",
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
            document.querySelectorAll('#trade-wrapper .trade-row').forEach((row, index) => {
                row.querySelector('td:first-child').textContent = index + 1;
            });
        }
    });
</script>
