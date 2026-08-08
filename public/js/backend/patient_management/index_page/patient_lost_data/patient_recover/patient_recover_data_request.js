window.recoverPatientDraft = function (draftId) {
    if (!draftId) return;
    $.ajax({
        url: "/patient-drafts/" + encodeURIComponent(draftId),
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (!response || !response.success || !response.draft) return;
            const draft = response.draft;
            const formData = draft.form_data || {};
            restoreFormData(formData);
            if (
                draft.current_step !== null &&
                draft.current_step !== undefined
            ) {
                restorePatientStep(draft.current_step);
            }
            sessionStorage.removeItem("recover_patient_draft_id");
            sessionStorage.removeItem("recover_patient_draft_token");
            showRecoverySuccess();
        },
        error: function (xhr) {
            console.error("Unable to recover patient draft.", xhr);
        },
    });
};
