/*PATIENT LOST DATA NOTIFICATION*/
$(function () {
    const notification = $("#patientLostDataNotification");

    if (!notification.length) {
        return;
    }

    const countElement = $("#lostPatientDataCount");
    const recoverButton = $("#recoverPatientDataBtn");
    const discardButton = $("#discardPatientDataBtn");
    const closeButton = $("#closePatientLostDataNotification");
    let currentDraft = null;

    /* Show */
    function showNotification(count, draft) {
        currentDraft = draft;
        countElement.text(count);
        notification.stop(true, true).fadeIn(300);
    }

    /* Hide  */
    function hideNotification() {
        notification.stop(true, true).fadeOut(300);
        currentDraft = null;
    }

    /* Check Pending Drafts  */

    function checkPendingDrafts() {
        const url =
            window.patientRoutes?.lostDataPending || "patient-drafts/pending";

        $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (
                    !response ||
                    !response.success ||
                    !response.count ||
                    !response.drafts ||
                    !response.drafts.length
                ) {
                    return;
                }

                /* Newest Draft   */
                const draft = response.drafts[0];
                showNotification(response.count, draft);
            },

            error: function (xhr) {
                console.warn("Unable to check patient lost data.", xhr);
            },
        });
    }

    /* Recover   */
    recoverButton.on("click", function () {
        if (!currentDraft) {
            return;
        }

        sessionStorage.setItem("recover_patient_draft_id", currentDraft.id);
        sessionStorage.setItem(
            "recover_patient_draft_token",
            currentDraft.draft_token,
        );
        hideNotification();

        /* Recover Directly*/
        if (typeof window.recoverPatientDraft === "function") {
            window.recoverPatientDraft(currentDraft.id);
        } else {
            /*
             * If recovery script isn't loaded yet,
             * reload the current page.
             */

            window.location.reload();
        }
    });

    /* Discard  */
    discardButton.on("click", function () {
        if (!currentDraft) {
            return;
        }

        const draftId = currentDraft.id;

        $.ajax({
            url: "patient-drafts/" + encodeURIComponent(draftId),
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function () {
                hideNotification();
            },

            error: function (xhr) {
                console.error("Unable to discard patient draft.", xhr);
            },
        });
    });

    /*Close */
    closeButton.on("click", function () {
        hideNotification();
    });

    /*Initial Check*/
    setTimeout(checkPendingDrafts, 800);
});
