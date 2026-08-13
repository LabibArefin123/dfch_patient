/*
|--------------------------------------------------------------------------
| PATIENT LOST DATA - NOTIFICATION ACTIONS
|--------------------------------------------------------------------------
*/

function setupLostPatientDataActions() {
    if (!window.patientLostDataNotification) {
        return;
    }

    const recoverButton = window.patientLostDataNotification.recoverButton;

    const discardButton = window.patientLostDataNotification.discardButton;

    const closeButton = window.patientLostDataNotification.closeButton;

    /*
    |--------------------------------------------------------------------------
    | Recover
    |--------------------------------------------------------------------------
    */

    recoverButton.on("click", function () {
        if (!currentLostPatientDraft) {
            return;
        }

        const draftId = currentLostPatientDraft.id;

        /*
            |--------------------------------------------------------------------------
            | Store Recovery ID
            |--------------------------------------------------------------------------
            */

        sessionStorage.setItem("recover_patient_draft_id", draftId);

        if (currentLostPatientDraft.draft_token) {
            sessionStorage.setItem(
                "recover_patient_draft_token",
                currentLostPatientDraft.draft_token,
            );
        }

        /*
            |--------------------------------------------------------------------------
            | Hide Notification
            |--------------------------------------------------------------------------
            */

        hideLostPatientDataNotification();

        /*
            |--------------------------------------------------------------------------
            | Recover
            |--------------------------------------------------------------------------
            */

        if (typeof window.recoverPatientDraft === "function") {
            window.recoverPatientDraft(draftId);
        } else {
            console.error("recoverPatientDraft() is not available.");
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Discard
    |--------------------------------------------------------------------------
    */

    discardButton.on("click", function () {
        if (!currentLostPatientDraft) {
            return;
        }

        const draftId = currentLostPatientDraft.id;

        let deleteUrl = window.patientRoutes?.lostDataDelete;

        if (deleteUrl) {
            deleteUrl = deleteUrl.replace(
                "__ID__",
                encodeURIComponent(draftId),
            );
        } else {
            deleteUrl = "/patients/drafts/" + encodeURIComponent(draftId);
        }

        $.ajax({
            url: deleteUrl,

            method: "DELETE",

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),

                Accept: "application/json",
            },

            success: function (response) {
                console.log("Patient draft deleted:", response);

                hideLostPatientDataNotification();
            },

            error: function (xhr) {
                console.error("Unable to discard patient draft.", xhr);

                console.error(xhr.responseText);
            },
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Close
    |--------------------------------------------------------------------------
    */

    closeButton.on("click", function () {
        hideLostPatientDataNotification();
    });
}
