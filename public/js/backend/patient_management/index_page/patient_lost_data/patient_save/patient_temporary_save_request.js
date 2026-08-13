/*
|--------------------------------------------------------------------------
| PATIENT TEMPORARY SAVE - REQUEST
|--------------------------------------------------------------------------
*/

window.PatientTemporarySave = window.PatientTemporarySave || {};

(function (module) {
    let saving = false;
    let waitingCallbacks = [];

    module.save = function (options = {}) {
        /*
        |--------------------------------------------------------------------------
        | If already saving
        |--------------------------------------------------------------------------
        */

        if (saving) {
            if (typeof options.complete === "function") {
                waitingCallbacks.push(options.complete);
            }

            return;
        }

        const form = module.getForm();

        if (!form) {
            if (typeof options.complete === "function") {
                options.complete();
            }

            return;
        }

        const formData = module.collect();

        /*
        |--------------------------------------------------------------------------
        | Don't save empty form
        |--------------------------------------------------------------------------
        */

        if (!module.hasData(formData)) {
            if (typeof options.complete === "function") {
                options.complete();
            }

            return;
        }

        saving = true;

        if (typeof options.complete === "function") {
            waitingCallbacks.push(options.complete);
        }

        const draftToken = module.getToken();

        const saveUrl =
            window.patientRoutes?.lostDataSave || "/patients/drafts/save";

        $.ajax({
            url: saveUrl,

            method: "POST",

            dataType: "json",

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
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
                | Store Server Token
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
                console.warn("Patient temporary save failed.", xhr);
            },

            complete: function () {
                saving = false;

                /*
                |--------------------------------------------------------------------------
                | Execute queued callbacks
                |--------------------------------------------------------------------------
                */

                const callbacks = waitingCallbacks;

                waitingCallbacks = [];

                callbacks.forEach(function (callback) {
                    try {
                        callback();
                    } catch (error) {
                        console.error("Patient draft callback failed.", error);
                    }
                });
            },
        });
    };
})(window.PatientTemporarySave);
