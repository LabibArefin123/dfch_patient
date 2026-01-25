@php $ircIndex = 0; @endphp
<div class="d-flex justify-content-between align-items-center mb-2">
    <h4>Import Registration Certificate (IRC) Information</h4>
    <button type="button" class="btn btn-success btn-sm" id="add-irc"
        @if (auth()->user()->hasRole('demo')) disabled @endif>+</button>
</div>

<div class="table-responsive">
    <table class="table table-bordered" id="irc-table">
        <thead class="table-dark">
            <tr>
                <th>SL</th>
                <th>IRC License No</th>
                <th>Validity</th>
                <th>Financial Year</th>
                <th>Document</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="irc-wrapper">
            @foreach ($organization->documents->where('type', 'irc') as $document)
                <tr class="irc-row">
                    <td>{{ $ircIndex + 1 }}</td>
                    <td>
                        <input type="hidden" name="documents[irc][{{ $ircIndex }}][id]"
                            value="{{ $document->id }}">
                        <input type="text" name="documents[irc][{{ $ircIndex }}][number]" class="form-control"
                            value="{{ old('documents.irc.' . $ircIndex . '.number', $document->number) }}">
                    </td>
                    <td>
                        <input type="date" name="documents[irc][{{ $ircIndex }}][validity]" class="form-control"
                            value="{{ old('documents.irc.' . $ircIndex . '.validity', $document->validity) }}">
                    </td>
                    <td>
                        <select name="documents[irc][{{ $ircIndex }}][financial_year]"
                            id="financialYearSelect_irc_{{ $ircIndex }}" class="form-control"
                            data-selected="{{ old('documents.irc.' . $ircIndex . '.financial_year', $document->financial_year ?? '') }}"></select>
                    </td>
                    <td class="text-center">
                        @if ($document->document && file_exists(public_path('uploads/documents/company_documents/irc/' . $document->document)))
                            <a href="{{ asset('uploads/documents/company_documents/irc/' . $document->document) }}"
                                target="_blank">
                                <i class="fas fa-file-pdf text-danger"></i> View Document
                            </a><br>
                        @else
                            <span class="text-muted">No file</span><br>
                        @endif
                        <input type="file" name="documents[irc][{{ $ircIndex }}][document][]"
                            class="form-control mt-2" multiple>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-irc">Remove</button>
                    </td>
                </tr>
                @php $ircIndex++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let ircIndex = {{ $ircIndex }};
        const maxRows = 10;

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
        document.querySelectorAll('#irc-wrapper .irc-row select').forEach(select => {
            populateFinancialYearDropdown(select, select.dataset.selected);
        });

        // Add new row
        document.getElementById('add-irc').addEventListener('click', function() {
            const rowCount = document.querySelectorAll('#irc-wrapper .irc-row').length;
            if (rowCount >= maxRows) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Reached',
                    text: 'You are not allowed to give more than 10 IRC documents',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const tbody = document.getElementById('irc-wrapper');
            const tr = document.createElement('tr');
            tr.classList.add('irc-row');

            tr.innerHTML = `
            <td></td>
            <td>
                <input type="text" name="documents[irc][${ircIndex}][number]" class="form-control">
            </td>
            <td>
                <input type="date" name="documents[irc][${ircIndex}][validity]" class="form-control">
            </td>
            <td>
                <select name="documents[irc][${ircIndex}][financial_year]" id="financialYearSelect_irc_${ircIndex}" class="form-control"></select>
            </td>
            <td>
                <input type="file" name="documents[irc][${ircIndex}][document][]" class="form-control mt-1" multiple>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-irc">Remove</button>
            </td>
        `;

            tbody.appendChild(tr);
            populateFinancialYearDropdown(tr.querySelector('select'));
            ircIndex++;
            updateSL();
        });

        // Remove row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-irc')) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This IRC document will be removed.",
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
            document.querySelectorAll('#irc-wrapper .irc-row').forEach((row, index) => {
                row.querySelector('td:first-child').textContent = index + 1;
            });
        }
    });
</script>
