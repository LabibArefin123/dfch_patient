function patientSummarySearch() {
    let keyword = $("#patientSummarySearch").val().trim();

    if (keyword === "") return;

    // 1. Bulletproof inline intercept for "close" command
    if (keyword.toLowerCase() === "close") {
        $("#patientSummarySearch").val("");

        const chatCol = $("#patientSummaryChat").closest(".col-lg-5");
        const detailCol = $("#patientSummaryDetail").closest(
            ".col-lg-7, .col-lg-12",
        );

        if (chatCol.length && detailCol.length) {
            // Hide the chat column
            chatCol.addClass("d-none");

            // Expand the details column to full size
            detailCol.removeClass("col-lg-7").addClass("col-lg-12");

            // Add a floating restore chat button if not already present
            if ($("#reopenChatBtn").length === 0) {
                const reopenBtn = $(`
                    <button id="reopenChatBtn" class="btn btn-outline-primary btn-sm position-absolute" 
                            style="top: 15px; right: 15px; z-index: 100; border-radius: 20px; padding: 6px 16px;">
                        <i class="fas fa-comments mr-1"></i> Open Chat
                    </button>
                `);

                reopenBtn.on("click", function () {
                    chatCol.removeClass("d-none");
                    detailCol.removeClass("col-lg-12").addClass("col-lg-7");
                    reopenBtn.remove();
                });

                detailCol.css("position", "relative").append(reopenBtn);
            }
        }
        return;
    }

    // 2. Immediately post user's text inside the chat bubble
    appendUserMessage(keyword);

    // 3. Clear input field immediately for natural chat interface
    $("#patientSummarySearch").val("");

    // 4. Initiate thinking indicator
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
                appendBotMessage(
                    "❌ Patient not found in this chat.<br><br>Search another patient?",
                );
                $("#patientSummaryAction").removeClass("d-none");
                $("#patientSearchResult").html("");
                $("#patientSummaryDetail").html("");
                return;
            }

            appendBotMessage("✅ Found " + res.count + " patient(s).");

            // Delegate rendering to result module
            renderPatientResults(res.patients);
        },
        error: function () {
            patientTypingDone();
            appendBotMessage("Something went wrong.");
        },
    });
}
