@php $ircIndentIndex = 0; @endphp
<div class="d-flex justify-content-between align-items-center mb-2">
    <h4>IRC Indent Information</h4>
    <button type="button" class="btn btn-success btn-sm" id="add-irc_indent"
        @if (auth()->user()->hasRole('demo')) disabled @endif>+</button>
</div>

<div class="table-responsive">
    <table class="table table-bordered" id="irc_indent-table">
        <thead class="table-dark">
            <tr>
                <th>SL</th>
                <th>IRC Indent License No</th>
                <th>Validity</th>
                <th>Financial Year</th>
                <th>Document</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="irc_indent-wrapper">
            @foreach ($organization->documents->where('type', 'irc_indent') as $document)
                <tr class="irc_indent-row">
                    <td>{{ $ircIndentIndex + 1 }}</td>
                    <td>
                        <input type="hidden" name="documents[irc_indent][{{ $ircIndentIndex }}][id]"
                            value="{{ $document->id }}">
                        <input type="text" name="documents[irc_indent][{{ $ircIndentIndex }}][number]"
                            class="form-control"
                            value="{{ old('documents.irc_indent.' . $ircIndentIndex . '.number', $document->number) }}">
                    </td>
                    <td>
                        <input type="date" name="documents[irc_indent][{{ $ircIndentIndex }}][validity]"
                            class="form-control"
                            value="{{ old('documents.irc_indent.' . $ircIndentIndex . '.validity', $document->validity) }}">
                    </td>
                    <td>
                        <select name="documents[irc_indent][{{ $ircIndentIndex }}][financial_year]"
                            id="financialYearSelect_irc_indent_{{ $ircIndentIndex }}" class="form-control"
                            data-selected="{{ old('documents.irc_indent.' . $ircIndentIndex . '.financial_year', $document->financial_year ?? '') }}"></select>
                    </td>
                    <td class="text-center">
                        @if (
                            $document->document &&
                                file_exists(public_path('uploads/documents/company_documents/irc_indent/' . $document->document)))
                            <a href="{{ asset('uploads/documents/company_documents/irc_indent/' . $document->document) }}"
                                target="_blank">
                                <i class="fas fa-file-pdf text-danger"></i> View Document
                            </a><br>
                        @else
                            <span class="text-muted">No file</span><br>
                        @endif
                        <input type="file" name="documents[irc_indent][{{ $ircIndentIndex }}][document][]"
                            class="form-control mt-2" multiple>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-irc_indent">Remove</button>
                    </td>
                </tr>
                @php $ircIndentIndex++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let ircIndentIndex = {{ $ircIndentIndex }};
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
        document.querySelectorAll('#irc_indent-wrapper .irc_indent-row select').forEach(select => {
            populateFinancialYearDropdown(select, select.dataset.selected);
        });

        // Add new row
        document.getElementById('add-irc_indent').addEventListener('click', function() {
            const rowCount = document.querySelectorAll('#irc_indent-wrapper .irc_indent-row').length;
            if (rowCount >= maxRows) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Reached',
                    text: 'You are not allowed to give more than 15 IRC Indent documents',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const tbody = document.getElementById('irc_indent-wrapper');
            const tr = document.createElement('tr');
            tr.classList.add('irc_indent-row');

            tr.innerHTML = `
            <td></td>
            <td>
                <input type="text" name="documents[irc_indent][${ircIndentIndex}][number]" class="form-control">
            </td>
            <td>
                <input type="date" name="documents[irc_indent][${ircIndentIndex}][validity]" class="form-control">
            </td>
            <td>
                <select name="documents[irc_indent][${ircIndentIndex}][financial_year]" id="financialYearSelect_irc_indent_${ircIndentIndex}" class="form-control"></select>
            </td>
            <td>
                <input type="file" name="documents[irc_indent][${ircIndentIndex}][document][]" class="form-control mt-1" multiple>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-irc_indent">Remove</button>
            </td>
        `;

            tbody.appendChild(tr);
            populateFinancialYearDropdown(tr.querySelector('select'));
            ircIndentIndex++;
            updateSL();
        });

        // Remove row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-irc_indent')) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This IRC Indent document will be removed.",
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
            document.querySelectorAll('#irc_indent-wrapper .irc_indent-row').forEach((row, index) => {
                row.querySelector('td:first-child').textContent = index + 1;
            });
        }
    });
</script>
