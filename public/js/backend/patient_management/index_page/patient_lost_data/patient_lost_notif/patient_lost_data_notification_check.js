/*PATIENT LOST DATA - CHECK PENDING DRAFTS*/
function checkPendingPatientDrafts() {
    /* Route*/
    const url =
        window.patientRoutes?.draftPending || "/patients/drafts/pending";
    console.log("Checking patient drafts:", url);

    /* Request */
    $.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        headers: {
            Accept: "application/json",
        },

        success: function (response) {
            console.log("Pending patient drafts:", response);

            /*No Draft */
            if (
                !response ||
                !response.success ||
                !response.count ||
                !Array.isArray(response.drafts) ||
                !response.drafts.length
            ) {
                hideLostPatientDataNotification();

                return;
            }

            /*Latest Draft*/
            const draft = response.drafts[0];

            /* Show Notification  */
            showLostPatientDataNotification(response.count, draft);
        },

        error: function (xhr) {
            console.error("Unable to check patient lost data.", xhr);
            console.error("Status:", xhr.status);
            console.error("Response:", xhr.responseText);
        },
    });
}
