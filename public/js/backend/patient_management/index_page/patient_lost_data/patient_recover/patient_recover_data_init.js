$(function () {
    if (typeof window.recoverPatientDraft === "function") {
        const draftId = sessionStorage.getItem("recover_patient_draft_id");
        if (draftId) {
            setTimeout(function () {
                window.recoverPatientDraft(draftId);
            }, 500);
        }
    }
});
