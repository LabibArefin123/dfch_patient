$("#patientPhotoBtn").click(function () {
    if (patientChatClosedWarning()) return;
    $("#patientPhotoInput").click();
});

$("#patientPhotoInput").change(function () {
    if (patientChatClosedWarning()) {
        $(this).val("");
        return;
    }
    if (!this.files.length) return;

    let fd = new FormData();

    fd.append("photo", this.files[0]);

    fd.append("_token", $('meta[name="csrf-token"]').attr("content"));

    patientSearching();

    $.ajax({
        url: patientPhotoSearchUrl,

        type: "POST",

        data: fd,

        processData: false,

        contentType: false,

        success: function (res) {
            patientTypingDone();

            if (!res.status) {
                appendBotMessage("📷 No matching patient photo found.");

                return;
            }

            appendBotMessage("📷 Matching patient photo found.");

            appendDateSearchInfo(res.patients, "Uploaded Patient Photo");

            renderPatientResults(res.patients);
        },

        error: function () {
            patientTypingDone();

            appendBotMessage("Unable to process uploaded photo.");
        },
    });
});
