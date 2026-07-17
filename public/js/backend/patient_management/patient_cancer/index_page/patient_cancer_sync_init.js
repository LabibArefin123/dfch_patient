/**
 * |--------------------------------------------------------------------------
 * | Patient Cancer Sync - Initialization
 * |--------------------------------------------------------------------------
 */

document.addEventListener("DOMContentLoaded", function () {
    console.log("[CANCER SYNC][STEP 1] DOMContentLoaded");

    const syncButton = document.getElementById("syncCancerPatientsBtn");

    if (!syncButton) {
        console.warn("[CANCER SYNC][STEP 1] Sync button not found");

        return;
    }

    console.log("[CANCER SYNC][STEP 1 SUCCESS] Sync button found");

    const modalElement = document.getElementById("cancerPatientSyncModal");

    if (!modalElement) {
        console.error("[CANCER SYNC][STEP 1 FAILED] Modal not found");

        return;
    }

    console.log("[CANCER SYNC][STEP 1 SUCCESS] Modal found");

    const modal = $("#cancerPatientSyncModal");

    const elements = {
        modalTitle: document.getElementById("syncModalTitle"),

        statusText: document.getElementById("syncStatusText"),

        description: document.getElementById("syncDescription"),

        progressBar: document.getElementById("syncProgressBar"),

        counter: document.getElementById("syncCounter"),

        animation: document.getElementById("syncAnimation"),

        modalIcon: document.getElementById("syncModalIcon"),

        closeButton: document.getElementById("syncCloseBtn"),
    };

    const missingElements = Object.entries(elements)
        .filter(([key, element]) => !element)
        .map(([key]) => key);

    if (missingElements.length > 0) {
        console.error(
            "[CANCER SYNC][STEP 2 FAILED] Missing elements:",
            missingElements,
        );

        return;
    }

    console.log("[CANCER SYNC][STEP 2 SUCCESS] All modal elements found");

    syncButton.addEventListener("click", function () {
        console.log("[CANCER SYNC][STEP 3] Sync button clicked");

        resetSyncModal(elements);

        openSyncModal(modal);

        startSyncPreparation(elements);
    });

    console.log("[CANCER SYNC][STEP 3 SUCCESS] Click event attached");
});
