<!-- Start of No Filter Warning Modal -->
<div class="modal fade" id="noFilterModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fa fa-exclamation-triangle"></i>
                    Filter Required
                </h5>
                <button type="button" class="close text-white" onclick="$('#noFilterModal').modal('hide')">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">
                <p class="mb-0">
                    Please choose at least one filter before exporting Excel or PDF.
                </p>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" onclick="$('#noFilterModal').modal('hide')">
                    OK
                </button>

            </div>

        </div>
    </div>
</div>
<!-- End of No Filter Warning Modal -->
