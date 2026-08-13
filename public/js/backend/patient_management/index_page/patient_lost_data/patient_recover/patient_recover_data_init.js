/*PATIENT RECOVER DATA - INIT*/

$(function () {
    if (typeof window.recoverPatientDraft !== "function") {
        console.warn("recoverPatientDraft() is not available.");

        return;
    }

    const draftId = sessionStorage.getItem("recover_patient_draft_id");

    if (!draftId) {
        return;
    }

    /* Wait for Form / CKEditor / Patient UI */

    setTimeout(function () {
        window.recoverPatientDraft(draftId);
    }, 700);
});
