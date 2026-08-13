/*PATIENT TEMPORARY SAVE - REQUEST*/

window.PatientTemporarySave = window.PatientTemporarySave || {};

(function (module) {
    let saving = false;
    let queuedCallbacks = [];

    /* Save Draft  */
    module.save = function (options = {}) {
        /* If a save is already running */
        if (saving) {
            if (typeof options.complete === "function") {
                queuedCallbacks.push(options.complete);
            }

            return;
        }

        /* Get Form  */
        const form = module.getForm();

        if (!form || !form.length) {
            console.warn("Patient temporary save: form not found.");

            if (typeof options.complete === "function") {
                options.complete(false);
            }

            return;
        }

        /* Collect Form Data  */
        const formData = module.collect();

        /* Don't Save Empty Form */

        if (!module.hasData(formData)) {
            console.warn("Patient temporary save: no form data found.");

            if (typeof options.complete === "function") {
                options.complete(false);
            }

            return;
        }

        /* Saving */
        saving = true;
        if (typeof options.complete === "function") {
            queuedCallbacks.push(options.complete);
        }

        /* Draft Token  */
        const draftToken = module.getToken();

        /* Route  */

        const saveUrl =
            window.patientRoutes?.lostDataSave || "/patients/drafts/save";

        /*
        |--------------------------------------------------------------------------
        | AJAX
        |--------------------------------------------------------------------------
        */

        $.ajax({
            url: saveUrl,

            method: "POST",

            dataType: "json",

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),

                Accept: "application/json",
            },

            data: {
                draft_token: draftToken,

                form_data: formData,

                current_step:
                    typeof module.getCurrentStep === "function"
                        ? module.getCurrentStep()
                        : null,
            },

            success: function (response) {
                console.log("Patient draft saved:", response);

                if (!response || !response.success) {
                    console.warn(
                        "Patient draft save returned an invalid response.",
                        response,
                    );

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
                | Store Token
                |--------------------------------------------------------------------------
                */

                if (response.draft_token) {
                    sessionStorage.setItem(
                        "patient_draft_token",
                        response.draft_token,
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Optional Callback
                |--------------------------------------------------------------------------
                */

                if (typeof window.onPatientDraftSaved === "function") {
                    window.onPatientDraftSaved(response);
                }
            },

            error: function (xhr) {
                console.error("Patient temporary save failed.", xhr);

                console.error("Status:", xhr.status);

                console.error("Response:", xhr.responseText);
            },

            complete: function () {
                saving = false;

                /*
                |--------------------------------------------------------------------------
                | Execute queued callbacks
                |--------------------------------------------------------------------------
                */

                const callbacks = queuedCallbacks;

                queuedCallbacks = [];

                callbacks.forEach(function (callback) {
                    try {
                        callback(true);
                    } catch (error) {
                        console.error("Patient draft callback failed.", error);
                    }
                });
            },
        });
    };
})(window.PatientTemporarySave);
