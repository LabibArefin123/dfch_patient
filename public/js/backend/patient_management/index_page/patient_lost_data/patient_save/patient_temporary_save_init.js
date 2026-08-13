/*
|--------------------------------------------------------------------------
| PATIENT TEMPORARY SAVE - INIT
|--------------------------------------------------------------------------
*/

$(function () {
    const form = $("#patientCreateForm");

    if (!form.length) {
        console.warn("Patient create form not found.");

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    const SAVE_INTERVAL = 3000;

    let dirty = false;

    /*
    |--------------------------------------------------------------------------
    | Detect Changes
    |--------------------------------------------------------------------------
    */

    form.on("input change", "input, select, textarea", function () {
        dirty = true;
    });

    /*
    |--------------------------------------------------------------------------
    | Autosave
    |--------------------------------------------------------------------------
    */

    const timer = setInterval(function () {
        if (
            dirty &&
            window.PatientTemporarySave &&
            typeof window.PatientTemporarySave.save === "function"
        ) {
            window.PatientTemporarySave.save();

            dirty = false;
        }
    }, SAVE_INTERVAL);

    window.patientTemporarySaveTimer = timer;

    /*
    |--------------------------------------------------------------------------
    | Manual Save
    |--------------------------------------------------------------------------
    */

    window.savePatientDraft = function () {
        if (
            window.PatientTemporarySave &&
            typeof window.PatientTemporarySave.save === "function"
        ) {
            window.PatientTemporarySave.save();

            dirty = false;
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Browser Visibility
    |--------------------------------------------------------------------------
    */

    document.addEventListener("visibilitychange", function () {
        if (document.visibilityState === "hidden" && dirty) {
            if (
                window.PatientTemporarySave &&
                typeof window.PatientTemporarySave.save === "function"
            ) {
                window.PatientTemporarySave.save();

                dirty = false;
            }
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Submit
    |--------------------------------------------------------------------------
    */

    form.on("submit", function () {
        if (window.patientTemporarySaveTimer) {
            clearInterval(window.patientTemporarySaveTimer);

            window.patientTemporarySaveTimer = null;
        }

        dirty = false;
    });
});
