/*PATIENT TEMPORARY SAVE - CLEANUP*/
window.PatientTemporarySave = window.PatientTemporarySave || {};
(function (module) {
    /*Clear Draft*/
    module.clear = function () {
        const draftId = module.getId();

        /* Stop Autosave  */
        if (window.patientTemporarySaveTimer) {
            clearInterval(window.patientTemporarySaveTimer);

            window.patientTemporarySaveTimer = null;
        }

        /* No Draft ID  */
        if (!draftId) {
            module.clearStorage();
            return;
        }

        /*Delete Database Draft */
        const deleteUrl =
            window.patientRoutes?.lostDataDelete ||
            "/patients/drafts/" + encodeURIComponent(draftId);

        $.ajax({
            url: deleteUrl,
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            complete: function () {
                module.clearStorage();
            },
        });
    };

    /* Global Helper  */
    window.clearPatientTemporaryData = function () {
        module.clear();
    };
})(window.PatientTemporarySave);
