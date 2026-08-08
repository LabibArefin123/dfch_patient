/* PATIENT LOST DATA - NOTIFICATION START*/
$(function () {
    /* Notification must exist */
    if (!window.patientLostDataNotification) {
        return;
    }

    /*Setup notification actions  */
    setupLostPatientDataActions();


    /* Only check drafts when: ?check_draft=1  */
    const params = new URLSearchParams(
        window.location.search
    );

    if (
        params.get("check_draft") !== "1"
    ) {
        return;
    }

    /*Small delay so the index page/UI is fully initialized  */
    setTimeout(function () {
        checkPendingPatientDrafts();
    }, 300);
});

