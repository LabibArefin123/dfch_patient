/**
 * |--------------------------------------------------------------------------
 * | Patient Cancer Sync - Request
 * |--------------------------------------------------------------------------
 */

function startSynchronization(elements) {
    console.log("[CANCER SYNC][REQUEST] Starting request");

    const syncUrl = window.PatientCancerSync?.syncUrl;

    if (!syncUrl) {
        console.error("[CANCER SYNC][REQUEST FAILED] Sync URL is missing");

        showSyncError(new Error("Synchronization URL is missing."), elements);

        return;
    }

    console.log("[CANCER SYNC][REQUEST] Sync URL:", syncUrl);

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    if (!csrfToken) {
        console.error("[CANCER SYNC][REQUEST FAILED] CSRF token not found");

        showSyncError(new Error("CSRF token not found."), elements);

        return;
    }

    fetch(syncUrl, {
        method: "POST",

        headers: {
            "X-CSRF-TOKEN": csrfToken,

            Accept: "application/json",

            "Content-Type": "application/json",

            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then(function (response) {
            console.log("[CANCER SYNC][REQUEST] HTTP status:", response.status);

            if (!response.ok) {
                throw new Error(
                    `Synchronization failed. HTTP ${response.status}`,
                );
            }

            return response.json();
        })
        .then(function (data) {
            console.log("[CANCER SYNC][REQUEST SUCCESS] Response:", data);

            elements.progressBar.style.width = "100%";

            if (data.status === "already_synced") {
                showAlreadySynced(data, elements);

                return;
            }

            showSyncSuccess(data, elements);
        })
        .catch(function (error) {
            console.error("[CANCER SYNC][REQUEST ERROR]", error);

            showSyncError(error, elements);
        });
}
