{{-- ========================= PRINT PREVIEW MODAL ========================= --}}
<div class="modal fade" id="printPreviewModal" tabindex="-1" role="dialog" aria-labelledby="printPreviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content print-preview-modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="printPreviewModalLabel">
                    <i class="fas fa-print text-danger"></i>
                    Card Print Preview
                </h5>

                <button type="button" class="close" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>


            <div class="modal-body">

                <div class="print-control-box">

                    <label>
                        Number of Copies
                    </label>

                    <select id="cardPrintCopies" class="form-control">

                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ $i == 1 ? 'selected' : '' }}>
                                {{ $i }} Copy{{ $i > 1 ? 'ies' : '' }}
                            </option>
                        @endfor

                    </select>

                </div>


                <div class="a4-preview-wrapper">

                    <div class="a4-paper" id="printA4Paper">

                        <div class="print-card-grid" id="printCardGrid">

                        </div>

                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button type="button" class="btn btn-danger" id="printCardButton">
                    <i class="fas fa-print"></i>
                    Print
                </button>


                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Close
                </button>

            </div>


        </div>
    </div>
</div>
