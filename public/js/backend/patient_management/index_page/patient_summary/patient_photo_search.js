$("#patientPhotoBtn").on("click", function () {
    if (patientChatClosedWarning()) return;

    $("#patientPhotoInput").trigger("click");
});

$("#patientPhotoInput").on("change", function () {
    if (patientChatClosedWarning()) {
        $(this).val("");

        return;
    }

    if (!this.files.length) return;

    const formData = new FormData();

    formData.append("photo", this.files[0]);

    formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

    patientSearching();

    $.ajax({
        url: patientPhotoSearchUrl,

        type: "POST",

        data: formData,

        processData: false,

        contentType: false,

        cache: false,

        success: function (res) {
            patientTypingDone();

            if (!res.status) {
                appendBotMessage("📷 No matching patient photo found.");

                $("#patientPhotoInput").val("");

                return;
            }

            let message = `📷 Found ${res.count} matching patient`;

            if (res.count > 1) {
                message += "s";
            }

            message += ".";

            appendBotMessage(message);

            res.patients.forEach(function (patient) {
                appendBotMessage(
                    `🔍 Match Source: <strong>${patient.matched_image}</strong>`,
                );
            });

            appendDateSearchInfo(res.patients, "Uploaded Patient Photo");

            renderPatientResults(res.patients);

            $("#patientPhotoInput").val("");
        },

        error: function () {
            patientTypingDone();

            appendBotMessage("❌ Unable to process uploaded photo.");

            $("#patientPhotoInput").val("");
        },
    });
});
