function setupLostPatientDataActions() {
    if (!window.patientLostDataNotification) return;
    const recoverButton = window.patientLostDataNotification.recoverButton;
    const discardButton = window.patientLostDataNotification.discardButton;
    const closeButton = window.patientLostDataNotification.closeButton;

    recoverButton.on("click", function () {
        if (!currentLostPatientDraft) return;
        sessionStorage.setItem(
            "recover_patient_draft_id",
            currentLostPatientDraft.id,
        );
        sessionStorage.setItem(
            "recover_patient_draft_token",
            currentLostPatientDraft.draft_token,
        );
        hideLostPatientDataNotification();
        if (typeof window.recoverPatientDraft === "function") {
            window.recoverPatientDraft(currentLostPatientDraft.id);
        } else {
            window.location.reload();
        }
    });

    discardButton.on("click", function () {
        if (!currentLostPatientDraft) return;
        const draftId = currentLostPatientDraft.id;
        $.ajax({
            url: "patient-drafts/" + encodeURIComponent(draftId),
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                hideLostPatientDataNotification();
            },
            error: function (xhr) {
                console.error("Unable to discard patient draft.", xhr);
            },
        });
    });

    closeButton.on("click", function () {
        hideLostPatientDataNotification();
    });
}
