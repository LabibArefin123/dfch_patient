/* PATIENT TEMPORARY SAVE - INIT */

$(function () {
    const form = $("#patientCreateForm");

    if (!form.length) {
        console.warn("Patient create form not found.");

        return;
    }

    const SAVE_INTERVAL = 5000;

    let dirty = false;

    /*
    |--------------------------------------------------------------------------
    | Detect changes
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
    | Form Submit
    |--------------------------------------------------------------------------
    */

    form.on("submit", function () {
        if (window.patientTemporarySaveTimer) {
            clearInterval(window.patientTemporarySaveTimer);

            window.patientTemporarySaveTimer = null;
        }
    });
});
