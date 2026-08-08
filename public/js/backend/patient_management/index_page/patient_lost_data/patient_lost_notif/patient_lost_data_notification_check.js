function checkPendingPatientDrafts() {
    const url =
        window.patientRoutes?.lostDataPending || "patient-drafts/pending";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (
                !response ||
                !response.success ||
                !response.count ||
                !response.drafts ||
                !response.drafts.length
            )
                return;
            const draft = response.drafts[0];
            showLostPatientDataNotification(response.count, draft);
        },
        error: function (xhr) {
            console.warn("Unable to check patient lost data.", xhr);
        },
    });
}
