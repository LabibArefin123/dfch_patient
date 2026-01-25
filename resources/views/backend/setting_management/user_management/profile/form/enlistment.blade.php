@php $enlistIndex = 0; @endphp
<div class="d-flex justify-content-between align-items-center mb-2">
    <h4>Company Enlistments</h4>
    <button type="button" class="btn btn-success btn-sm" id="add-enlistment"
        @if (auth()->user()->hasRole('demo')) disabled @endif>
        +
    </button>

</div>

<div class="table-responsive">
    <table class="table table-bordered" id="enlistments-table">
        <thead class="table-dark">
            <tr>
                <th>SL</th>
                <th>Customer Name</th>
                <th>Validity</th>
                <th>Security Deposit</th>
                <th>Financial Year</th>
                <th>Document</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="enlistments-wrapper">
            @foreach ($organization->enlistments as $enlistment)
                <tr class="enlistment-row">
                    <td>{{ $enlistIndex + 1 }}</td>
                    <td>
                        <input type="hidden" name="enlistments[{{ $enlistIndex }}][id]" value="{{ $enlistment->id }}">
                        <input type="text" name="enlistments[{{ $enlistIndex }}][customer_name]"
                            class="form-control"
                            value="{{ old('enlistments.' . $enlistIndex . '.customer_name', $enlistment->customer_name) }}">
                    </td>
                    <td>
                        <input type="date" name="enlistments[{{ $enlistIndex }}][validity]" class="form-control"
                            value="{{ old('enlistments.' . $enlistIndex . '.validity', $enlistment->validity) }}">
                    </td>
                    <td>
                        <input type="number" name="enlistments[{{ $enlistIndex }}][security_deposit]"
                            class="form-control"
                            value="{{ old('enlistments.' . $enlistIndex . '.security_deposit', $enlistment->security_deposit) }}">
                    </td>
                    <td>
                        <select name="enlistments[{{ $enlistIndex }}][financial_year]"
                            id="financialYearSelect_{{ $enlistIndex }}" class="form-control"
                            data-selected="{{ old('enlistments.' . $enlistIndex . '.financial_year', $enlistment->financial_year ?? '') }}">
                        </select>
                    </td>
                    <td class="text-center">
                        @if ($enlistment->document && file_exists(public_path('uploads/documents/company_enlistments/' . $enlistment->document)))
                            <a href="{{ asset('uploads/documents/company_enlistments/' . $enlistment->document) }}"
                                target="_blank">
                                <i class="fas fa-file-pdf text-danger"></i> View Document
                            </a><br>
                        @else
                            <span class="text-muted">No file</span><br>
                        @endif
                        <input type="file" name="enlistments[{{ $enlistIndex }}][document][]"
                            class="form-control mt-2" multiple>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-enlistment">Remove</button>
                    </td>
                </tr>
                @php $enlistIndex++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let enlistIndex = {{ $enlistIndex }};
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
        document.querySelectorAll('#enlistments-wrapper .enlistment-row select').forEach(select => {
            populateFinancialYearDropdown(select, select.dataset.selected);
        });

        // Add new row
        document.getElementById('add-enlistment').addEventListener('click', function() {
            const rowCount = document.querySelectorAll('#enlistments-wrapper .enlistment-row').length;
            if (rowCount >= maxRows) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Reached',
                    text: 'You are not allowed to give more than 15 enlistments',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const tbody = document.getElementById('enlistments-wrapper');
            const tr = document.createElement('tr');
            tr.classList.add('enlistment-row');

            tr.innerHTML = `
                <td></td>
                <td><input type="text" name="enlistments[${enlistIndex}][customer_name]" class="form-control"></td>
                <td><input type="date" name="enlistments[${enlistIndex}][validity]" class="form-control"></td>
                <td><input type="number" name="enlistments[${enlistIndex}][security_deposit]" class="form-control"></td>
                <td><select name="enlistments[${enlistIndex}][financial_year]" id="financialYearSelect_${enlistIndex}" class="form-control"></select></td>
                <td><input type="file" name="enlistments[${enlistIndex}][document][]" class="form-control mt-1" multiple></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-enlistment">Remove</button></td>
            `;

            tbody.appendChild(tr);
            populateFinancialYearDropdown(tr.querySelector('select'));
            enlistIndex++;
            updateSL();
        });

        // Remove row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-enlistment')) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This enlistment will be removed.",
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
            document.querySelectorAll('#enlistments-wrapper .enlistment-row').forEach((row, index) => {
                row.querySelector('td:first-child').textContent = index + 1;
            });
        }
    });
</script>
