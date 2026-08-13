/*
|--------------------------------------------------------------------------
| PATIENT RECOVER DATA - REQUEST
|--------------------------------------------------------------------------
*/

window.recoverPatientDraft = function (draftId) {
    if (!draftId) {
        console.error("No patient draft ID supplied.");

        return;
    }

    /*
        |--------------------------------------------------------------------------
        | Build URL
        |--------------------------------------------------------------------------
        */

    let url = window.patientRoutes?.lostDataShow;

    if (url) {
        url = url.replace("__ID__", encodeURIComponent(draftId));
    } else {
        url = "/patients/drafts/" + encodeURIComponent(draftId);
    }

    console.log("Recovering patient draft:", url);

    /*
        |--------------------------------------------------------------------------
        | Request
        |--------------------------------------------------------------------------
        */

    $.ajax({
        url: url,

        method: "GET",

        dataType: "json",

        headers: {
            Accept: "application/json",
        },

        success: function (response) {
            console.log("Patient draft response:", response);

            if (!response || !response.success || !response.draft) {
                console.error("Invalid patient draft response.", response);

                return;
            }

            const draft = response.draft;

            const formData = draft.form_data || {};

            /*
                |--------------------------------------------------------------------------
                | Restore Form
                |--------------------------------------------------------------------------
                */

            restoreFormData(formData);

            /*
                |--------------------------------------------------------------------------
                | Restore Step
                |--------------------------------------------------------------------------
                */

            if (
                draft.current_step !== null &&
                draft.current_step !== undefined
            ) {
                restorePatientStep(draft.current_step);
            }

            /*
                |--------------------------------------------------------------------------
                | Clear Recovery Storage
                |--------------------------------------------------------------------------
                */

            sessionStorage.removeItem("recover_patient_draft_id");

            sessionStorage.removeItem("recover_patient_draft_token");

            /*
                |--------------------------------------------------------------------------
                | Success
                |--------------------------------------------------------------------------
                */

            showRecoverySuccess();
        },

        error: function (xhr) {
            console.error("Unable to recover patient draft.", xhr);

            console.error("Status:", xhr.status);

            console.error("Response:", xhr.responseText);
        },
    });
};
