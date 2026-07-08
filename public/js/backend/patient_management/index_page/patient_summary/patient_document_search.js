$("#patientDocumentBtn").click(function () {
    $("#patientDocumentInput").click();
});

$("#patientDocumentInput").change(function () {
    if (!this.files.length) return;

    let fd = new FormData();

    fd.append("document", this.files[0]);

    fd.append("_token", $("meta[name=csrf-token]").attr("content"));

    patientSearching();

    $.ajax({
        url: patientDocumentSearchUrl,

        type: "POST",

        data: fd,

        processData: false,

        contentType: false,

        success: function (res) {
            patientTypingDone();

            if (!res.status) {
                appendBotMessage(res.message);

                return;
            }

            appendBotMessage("📄 Matching recommendation document located.");

            appendDateSearchInfo(res.patients, "Uploaded Document");

            renderPatientResults(res.patients);
        },

        error: function () {
            patientTypingDone();

            appendBotMessage("Unable to process the uploaded document.");
        },
    });
});
