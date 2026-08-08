/* PATIENT TEMPORARY SAVE - INIT*/
$(function () {
    /*Patient Create Form*/
    const form = $("#patientCreateForm");

    if (!form.length) {
        console.warn("Patient create form not found.");

        return;
    }

    /*Configuration */
    const SAVE_INTERVAL = 5000;

    /* Start Autosave */
    const timer = setInterval(function () {
        if (
            window.PatientTemporarySave &&
            typeof window.PatientTemporarySave.save === "function"
        ) {
            window.PatientTemporarySave.save();
        }
    }, SAVE_INTERVAL);

    /*Expose Timer */
    window.patientTemporarySaveTimer = timer;

    /* Manual Save*/
    window.savePatientDraft = function () {
        if (
            window.PatientTemporarySave &&
            typeof window.PatientTemporarySave.save === "function"
        ) {
            window.PatientTemporarySave.save();
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Form Submit
    |--------------------------------------------------------------------------
    |
    | Don't delete the draft here.
    |
    | The patient controller should delete the draft only
    | after the Patient record has been successfully created.
    |
    */

    form.on("submit", function () {
        /*Stop future autosaves. */
        if (window.patientTemporarySaveTimer) {
            clearInterval(window.patientTemporarySaveTimer);
            window.patientTemporarySaveTimer = null;
        }
    });
});
