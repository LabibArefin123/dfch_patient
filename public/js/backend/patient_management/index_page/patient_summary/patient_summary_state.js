/**
|--------------------------------------------------------------------------
| Patient Summary State
|--------------------------------------------------------------------------
| Handles summary modal state and tab behavior.
|--------------------------------------------------------------------------
*/

$(function () {
    window.PatientSummaryState = {
        chatClosed: false,
    };

    /**
     * Activate Search Result Tab
     */
    function activateResultsTab() {
        const resultsTab = $("#results-tab");

        if (!resultsTab.length) {
            return;
        }

        resultsTab.tab("show");

        $("#results-tab")
            .find("i")
            .removeClass("text-muted")
            .addClass("text-primary");

        $("#profile-tab")
            .find("i")
            .removeClass("text-primary")
            .addClass("text-muted");
    }

    /**
     * YES
     * Search another patient
     */
    $("#patientSearchAgain").on("click", function () {
        $("#patientSummarySearch").val("");

        $("#patientSummaryAction").addClass("d-none");

        // Reopen chat if it was previously closed
        if (
            window.PatientSummaryState &&
            window.PatientSummaryState.chatClosed
        ) {
            reopenPatientChat();
        }

        // Restore Search Result tab
        activateResultsTab();

        // Focus after everything is restored
        setTimeout(function () {
            $("#patientSummarySearch").focus();
        }, 100);
    });

    /**
     * NO
     * Close Summary Modal
     */
    $("#patientSummaryClose").on("click", function () {
        $("#patientSummaryModal").modal("hide");
    });

    /**
     * Update tab icon colors
     */
    $('#patientSummaryTabs a[data-toggle="tab"]').on(
        "shown.bs.tab",
        function (e) {
            const activeTab = $(e.target).attr("id");

            if (activeTab === "results-tab") {
                $("#results-tab")
                    .find("i")
                    .removeClass("text-muted")
                    .addClass("text-primary");

                $("#profile-tab")
                    .find("i")
                    .removeClass("text-primary")
                    .addClass("text-muted");
            } else if (activeTab === "profile-tab") {
                $("#profile-tab")
                    .find("i")
                    .removeClass("text-muted")
                    .addClass("text-primary");

                $("#results-tab")
                    .find("i")
                    .removeClass("text-primary")
                    .addClass("text-muted");
            }
        },
    );

    /**
     * Reset state whenever modal is opened
     */
    $("#patientSummaryModal").on("shown.bs.modal", function () {
        activateResultsTab();

        $("#patientSummaryAction").addClass("d-none");

        $("#patientSummarySearch").focus();
    });

    /**
     * Cleanup when modal closes
     */
    $("#patientSummaryModal").on("hidden.bs.modal", function () {
        $("#patientSummaryAction").addClass("d-none");

        $("#patientSummarySearch").val("");

        activateResultsTab();
    });
});
