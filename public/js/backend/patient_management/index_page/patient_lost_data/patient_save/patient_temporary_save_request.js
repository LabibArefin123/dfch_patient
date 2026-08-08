
/* PATIENT TEMPORARY SAVE - REQUEST */
window.PatientTemporarySave = window.PatientTemporarySave || {};

(function (module) {

    let saving = false;

    module.save = function () {

        if (saving) {
            return;
        }

        const form = module.getForm();

        if (!form) {
            return;
        }

        const formData = module.collect();

        /*
        |--------------------------------------------------------------------------
        | Don't save empty form
        |--------------------------------------------------------------------------
        */

        if (!module.hasData(formData)) {
            return;
        }

        saving = true;

        const draftToken = module.getToken();

        const saveUrl =
            window.patientRoutes?.lostDataSave ||
            "/patient-drafts/save";

        $.ajax({
            url: saveUrl,
            method: "POST",
            dataType: "json",

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },

            data: {
                draft_token: draftToken,
                form_data: formData,

                current_step:
                    typeof module.getCurrentStep === "function"
                        ? module.getCurrentStep()
                        : null
            },

            success: function (response) {

                if (!response || !response.success) {
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | Store Draft ID
                |--------------------------------------------------------------------------
                */

                if (response.draft_id) {
                    module.setId(response.draft_id);
                }

                /*
                |--------------------------------------------------------------------------
                | Store server token
                |--------------------------------------------------------------------------
                */

                if (response.draft_token) {

                    sessionStorage.setItem(
                        "patient_draft_token",
                        response.draft_token
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Optional callback
                |--------------------------------------------------------------------------
                */

                if (
                    typeof window.onPatientDraftSaved === "function"
                ) {
                    window.onPatientDraftSaved(response);
                }
            },

            error: function (xhr) {

                console.warn(
                    "Patient temporary save failed.",
                    xhr
                );
            },

            complete: function () {

                saving = false;
            }
        });
    };

})(window.PatientTemporarySave);