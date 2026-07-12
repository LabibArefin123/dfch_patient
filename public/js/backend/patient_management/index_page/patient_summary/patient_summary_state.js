$(function () {
    // "Yes" button click handler - resets field, sets focus, and switches tab back
    $("#patientSearchAgain").on("click", function () {
        $("#patientSummarySearch").val("").focus();
        $("#patientSummaryAction").addClass("d-none");

        // 🆕 Automatically switch back to Search Results Tab
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

    // "No" button click handler - closes modal
    $("#patientSummaryClose").on("click", function () {
        $("#patientSummaryModal").modal("hide");
    });

    // Update active icon colors on manual tab clicking
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

    window.PatientSummaryState = {
        chatClosed: false,
    };
});
