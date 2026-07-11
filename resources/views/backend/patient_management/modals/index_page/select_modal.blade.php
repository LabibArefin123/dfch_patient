<!-- Bulk Action Modal -->
<div class="modal fade" id="selectPatientsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-trash"></i> Delete Selected Patients
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">

                <h4 class="mb-3">
                    You selected
                    <span id="selectedCount" class="text-danger font-weight-bold">0</span>
                    patients
                </h4>

                <p class="text-muted">
                    This action cannot be undone.
                </p>

            </div>

            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>

                <button type="button" id="confirmDeleteSelected" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Confirm Delete
                </button>
            </div>

        </div>
    </div>
</div>
