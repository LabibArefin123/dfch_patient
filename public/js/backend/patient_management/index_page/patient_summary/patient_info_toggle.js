/**
 * Patient Info Tab Toggle Handler
 * Dynamically switches tabs when patient selection or reset events are fired.
 */
$(function () {
    // 1. Auto-switch to profile tab when 'Show' button is clicked inside Search results card list
    $(document).on("click", ".patient-summary-show", function () {
        const profileTabLink = $("#profile-tab");
        if (profileTabLink.length) {
            // Support both Bootstrap 4 and Bootstrap 5 toggle conventions
            profileTabLink.tab("show");
            // Safely toggle profile active icon color styling
            profileTabLink
                .find("i")
                .removeClass("text-muted")
                .addClass("text-primary");
            $("#results-tab").find("i").addClass("text-muted");
        }
    });

    // 2. Auto-switch back to results tab when 'Search Again' (Yes) is clicked
    $("#patientSearchAgain").on("click", function () {
        const resultsTabLink = $("#results-tab");
        if (resultsTabLink.length) {
            resultsTabLink.tab("show");
            $("#profile-tab")
                .find("i")
                .removeClass("text-primary")
                .addClass("text-muted");
            resultsTabLink.find("i").removeClass("text-muted");
        }
    });

    // Toggle active icon colors on manual tab clicking
    $('#patientSummaryTabs a[data-toggle="tab"]').on(
        "shown.bs.tab",
        function (e) {
            const activeTabId = $(e.target).attr("id");
            if (activeTabId === "profile-tab") {
                $("#profile-tab")
                    .find("i")
                    .removeClass("text-muted")
                    .addClass("text-primary");
                $("#results-tab").find("i").addClass("text-muted");
            } else if (activeTabId === "results-tab") {
                $("#results-tab").find("i").removeClass("text-muted");
                $("#profile-tab")
                    .find("i")
                    .removeClass("text-primary")
                    .addClass("text-muted");
            }
        },
    );
});
