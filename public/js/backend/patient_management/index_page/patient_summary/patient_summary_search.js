function patientSummarySearch() {
    let keyword = $("#patientSummarySearch").val().trim();

    if (keyword === "") return;

    // 1. Immediately post user's text inside the chat bubble
    appendUserMessage(keyword);

    // 2. Clear input field immediately for natural chat interface
    $("#patientSummarySearch").val("");

    // 3. Initiate thinking indicator
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
