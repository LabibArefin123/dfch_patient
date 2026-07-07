/**
 * Handles closing the chat block when 'close' is typed in the search panel.
 * Expands the right details panel to fill the entire modal width.
 */
function handleChatCloseAction(keyword) {
    if (keyword.toLowerCase() === "close") {
        const chatCol = $("#patientSummaryChat").closest(".col-lg-5");
        const detailCol = $("#patientSummaryDetail").closest(
            ".col-lg-7, .col-lg-12",
        );

        if (chatCol.length && detailCol.length) {
            // Hide the chat column
            chatCol.addClass("d-none");

            // Expand the details column to full size
            detailCol.removeClass("col-lg-7").addClass("col-lg-12");

            // Add a floating restore chat button if not already present
            if ($("#reopenChatBtn").length === 0) {
                const reopenBtn = $(`
                    <button id="reopenChatBtn" class="btn btn-outline-primary btn-sm position-absolute" 
                            style="top: 15px; right: 15px; z-index: 100; border-radius: 20px; padding: 6px 16px;">
                        <i class="fas fa-comments mr-1"></i> Open Chat
                    </button>
                `);

                reopenBtn.on("click", function () {
                    chatCol.removeClass("d-none");
                    detailCol.removeClass("col-lg-12").addClass("col-lg-7");
                    reopenBtn.remove();
                });

                detailCol.css("position", "relative").append(reopenBtn);
            }
        }
        return true;
    }
    return false;
}
