<div class="modal fade" id="warningMessage" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    PDF Record Limit Warning
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">
                <h5 class="text-danger">
                    Maximum {{ session('perPage') }} records allowed ({{ session('totalRecords') }})
                </h5>
                <p>Do you want to generate PDF with first {{ session('perPage') }} records?</p>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button" id="confirmPdfBtn" class="btn btn-success">
                    Yes, Generate
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Cancel
                </button>
            </div>

        </div>
    </div>
</div>
