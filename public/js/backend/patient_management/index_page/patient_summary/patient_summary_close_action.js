/**
|--------------------------------------------------------------------------
| Patient Close Action
|--------------------------------------------------------------------------
| Handles closing and reopening the AI chat panel.
|--------------------------------------------------------------------------
*/

/**
 * Reopen AI Chat
 */
function reopenPatientChat() {
    const chatCol = $("#patientSummaryChat").closest(".col-lg-5");

    const detailCol = $("#patientSummaryDetail").closest(
        ".col-lg-7, .col-lg-12",
    );

    window.PatientSummaryState.chatClosed = false;

    chatCol.removeClass("d-none");

    detailCol.removeClass("col-lg-12").addClass("col-lg-7");

    $("#reopenChatBtn").remove();
}

/**
 * Close AI Chat
 */
function handleChatCloseAction(keyword) {
    if (keyword.trim().toLowerCase() !== "close") {
        return false;
    }

    const chatCol = $("#patientSummaryChat").closest(".col-lg-5");

    const detailCol = $("#patientSummaryDetail").closest(
        ".col-lg-7, .col-lg-12",
    );

    if (!chatCol.length || !detailCol.length) {
        return true;
    }

    window.PatientSummaryState.chatClosed = true;

    chatCol.addClass("d-none");

    detailCol.removeClass("col-lg-7").addClass("col-lg-12");

    if (!$("#reopenChatBtn").length) {
        const reopenBtn = $(`
            <button
                id="reopenChatBtn"
                class="btn btn-outline-primary btn-sm position-absolute"
                style="
                    top:15px;
                    right:15px;
                    z-index:100;
                    border-radius:30px;
                ">
                <i class="fas fa-comments mr-1"></i>
                Open Chat
            </button>
        `);

        reopenBtn.on("click", reopenPatientChat);

        detailCol.css("position", "relative").append(reopenBtn);
    }

    return true;
}
