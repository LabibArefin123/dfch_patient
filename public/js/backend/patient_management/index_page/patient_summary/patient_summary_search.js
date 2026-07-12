function patientSummarySearch() {
    let keyword = $("#patientSummarySearch").val().trim();

    if (!keyword) return;

    if (window.PatientSummaryState.chatClosed) {
        const modal = new bootstrap.Modal(
            document.getElementById("patientChatClosedModal"),
        );

        modal.show();

        return;
    }

    /*-----------------------------------
    Close Command
    ------------------------------------*/
    if (keyword.toLowerCase() === "close") {
        $("#patientSummarySearch").val("");

        const chatCol = $("#patientSummaryChat").closest(".col-lg-5");
        const detailCol = $("#patientSummaryDetail").closest(
            ".col-lg-7, .col-lg-12",
        );

        chatCol.addClass("d-none");
        detailCol.removeClass("col-lg-7").addClass("col-lg-12");

        if (!$("#reopenChatBtn").length) {
            detailCol.css("position", "relative").append(`
                <button
                    id="reopenChatBtn"
                    class="btn btn-outline-primary btn-sm position-absolute"
                    style="top:15px;right:15px;z-index:999;border-radius:20px;">

                    <i class="fas fa-comments mr-1"></i>

                    Open Chat

                </button>
            `);
        }

        return;
    }

    /*-----------------------------------
    Future Date Validation
    ------------------------------------*/
    if (patientSummaryIsFutureSearch(keyword)) {
        patientSummaryFutureWarning(function () {
            doPatientSummarySearch(keyword);
        });

        return;
    }

    doPatientSummarySearch(keyword);
}

/*========================================================
Actual AJAX
========================================================*/

function doPatientSummarySearch(keyword) {
    appendUserMessage(keyword);

    $("#patientSummarySearch").val("");

    patientSearching();

    $.ajax({
        url: patientSummarySearchUrl,

        type: "POST",

        data: {
            search: keyword,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },

        success: function (res) {
            patientTypingDone();

            if (!res.status) {
                appendBotMessage(`
                    <b>Patient not found.</b><br><br>

                    Please try searching with:

                    • Patient Name<br>
                    • Patient Code<br>
                    • Phone Number<br>
                    • Date (15/07/2026)<br>
                    • Day & Month (15 August)<br>
                    • Today<br>
                    • Yesterday<br>
                    • Last 7 Days<br>
                    • Last 30 Days<br>
                    • This Month
                `);

                $("#patientSummaryAction").removeClass("d-none");

                $("#patientSearchResult").empty();

                $("#patientSummaryDetail").empty();

                return;
            }

            appendDateSearchInfo(res.patients, keyword);

            renderPatientResults(res.patients);
        },

        error: function () {
            patientTypingDone();

            appendBotMessage(
                "Unable to complete the search at the moment. Please try again.",
            );
        },
    });
}

/*========================================================
Reopen Chat
========================================================*/

$(document).on("click", "#reopenChatBtn", function () {
    const chatCol = $("#patientSummaryChat").closest(".col-lg-5");
    const detailCol = $("#patientSummaryDetail").closest(
        ".col-lg-12, .col-lg-7",
    );

    chatCol.removeClass("d-none");

    detailCol.removeClass("col-lg-12").addClass("col-lg-7");

    $(this).remove();
});
