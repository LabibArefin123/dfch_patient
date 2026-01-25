@php $orgIndex = 0; @endphp
<div class="d-flex justify-content-between align-items-center mb-2">
    <h4>Organization Member Information</h4>
    <button type="button" class="btn btn-success btn-sm" id="add-org"
        @if (auth()->user()->hasRole('demo')) disabled @endif>+</button>
</div>

<div class="table-responsive">
    <table class="table table-bordered" id="org-table">
        <thead class="table-dark">
            <tr>
                <th>SL</th>
                <th>Association Name</th>
                <th>Validity</th>
                <th>Financial Year</th>
                <th>Document</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="org-wrapper">
            @foreach ($organization->documents->where('type', 'org_member') as $document)
                <tr class="org-row">
                    <td>{{ $orgIndex + 1 }}</td>
                    <td>
                        <input type="hidden" name="documents[org_member][{{ $orgIndex }}][id]"
                            value="{{ $document->id }}">
                        <input type="text" name="documents[org_member][{{ $orgIndex }}][number]"
                            class="form-control"
                            value="{{ old('documents.org_member.' . $orgIndex . '.number', $document->number) }}">
                    </td>
                    <td>
                        <input type="date" name="documents[org_member][{{ $orgIndex }}][validity]"
                            class="form-control"
                            value="{{ old('documents.org_member.' . $orgIndex . '.validity', $document->validity) }}">
                    </td>
                    <td>
                        <select name="documents[org_member][{{ $orgIndex }}][financial_year]"
                            id="financialYearSelect_org_{{ $orgIndex }}" class="form-control"
                            data-selected="{{ old('documents.org_member.' . $orgIndex . '.financial_year', $document->financial_year ?? '') }}"></select>
                    </td>
                    <td class="text-center">
                        @if (
                            $document->document &&
                                file_exists(public_path('uploads/documents/company_documents/org_member/' . $document->document)))
                            <a href="{{ asset('uploads/documents/company_documents/org_member/' . $document->document) }}"
                                target="_blank">
                                <i class="fas fa-file-pdf text-danger"></i> View Document
                            </a><br>
                        @else
                            <span class="text-muted">No file</span><br>
                        @endif
                        <input type="file" name="documents[org_member][{{ $orgIndex }}][document][]"
                            class="form-control mt-2" multiple>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-org">Remove</button>
                    </td>
                </tr>
                @php $orgIndex++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let orgIndex = {{ $orgIndex }};
        const maxRows = 15;

        function populateFinancialYearDropdown(select, selectedValue = null) {
            if (!select) return;
            select.innerHTML = '<option value="">Select Year</option>';
            const currentYear = new Date().getFullYear();
            for (let year = currentYear; year >= 1950; year--) {
                let option = document.createElement('option');
                option.value = `${year}-${year + 1}`;
                option.textContent = `${year}-${year + 1}`;
                if (selectedValue && selectedValue === option.value) option.selected = true;
                select.appendChild(option);
            }
        }

        // Populate existing selects
        document.querySelectorAll('#org-wrapper .org-row select').forEach(select => {
            populateFinancialYearDropdown(select, select.dataset.selected);
        });

        // Add new row
        document.getElementById('add-org').addEventListener('click', function() {
            const rowCount = document.querySelectorAll('#org-wrapper .org-row').length;
            if (rowCount >= maxRows) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Reached',
                    text: 'You are not allowed to give more than 15 documents',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const tbody = document.getElementById('org-wrapper');
            const tr = document.createElement('tr');
            tr.classList.add('org-row');

            tr.innerHTML = `
            <td></td>
            <td>
                <input type="text" name="documents[org_member][${orgIndex}][number]" class="form-control">
            </td>
            <td><input type="date" name="documents[org_member][${orgIndex}][validity]" class="form-control"></td>
            <td><select name="documents[org_member][${orgIndex}][financial_year]" id="financialYearSelect_org_${orgIndex}" class="form-control"></select></td>
            <td><input type="file" name="documents[org_member][${orgIndex}][document][]" class="form-control mt-1" multiple></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-org">Remove</button></td>
        `;

            tbody.appendChild(tr);
            populateFinancialYearDropdown(tr.querySelector('select'));
            orgIndex++;
            updateSL();
        });

        // Remove row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-org')) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This organization member document will be removed.",
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
            document.querySelectorAll('#org-wrapper .org-row').forEach((row, index) => {
                row.querySelector('td:first-child').textContent = index + 1;
            });
        }
    });
</script>
