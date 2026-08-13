/*PATIENT LOST DATA - NOTIFICATION START*/
$(function () {
    /* Make sure notification exists  */
    if (!window.patientLostDataNotification) {
        console.warn("Patient lost-data notification not initialized.");

        return;
    }

    /*Setup Actions*/
    if (typeof setupLostPatientDataActions === "function") {
        setupLostPatientDataActions();
    }

    /* Check Pending Drafts */
    setTimeout(function () {
        if (typeof checkPendingPatientDrafts === "function") {
            checkPendingPatientDrafts();
        } else {
            console.error("checkPendingPatientDrafts() is not available.");
        }
    }, 300);
});
