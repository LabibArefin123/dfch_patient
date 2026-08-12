$(function () {
    function getSelectedLanyard() {
        const selected = window.selectedLanyard;
        if (selected && selected.length) return selected.first();
        const active = $(".lanyard-card.active").first();
        if (active.length) return active;
        const first = $(".lanyard-card").first();
        if (first.length) return first;
        return null;
    }
    function createLanyardPreviewModal() {
        if ($("#wholeLanyardPreviewModal").length) return;
        const modal = `
        <div class="modal fade" id="wholeLanyardPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-eye"></i>
                            Lanyard Preview
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="wholeLanyardPreviewContent" class="whole-lanyard-preview-content"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        `;
        $("body").append(modal);
    }
    function showWholeLanyardPreview() {
        const lanyard = getSelectedLanyard();
        if (!lanyard) {
            alert("Please select a lanyard first.");
            return;
        }
        createLanyardPreviewModal();
        const clone = lanyard.clone();
        clone
            .find(
                ".whole-lanyard-action-buttons,.whole-card-action-buttons,.lanyard-action-buttons",
            )
            .remove();
        const content = $("#wholeLanyardPreviewContent");
        content.empty();
        content.append(clone);
        $("#wholeLanyardPreviewModal").modal("show");
    }
    $(document).on(
        "click",
        ".whole-lanyard-preview-btn,.whole-card-preview-btn",
        function (e) {
            e.preventDefault();
            showWholeLanyardPreview();
        },
    );
});
