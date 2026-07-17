/**
 * |--------------------------------------------------------------------------
 * | Patient Cancer Sync - Animation
 * |--------------------------------------------------------------------------
 */

function startSyncPreparation(elements) {
    console.log("[CANCER SYNC][ANIMATION] Preparation started");

    setTimeout(function () {
        console.log("[CANCER SYNC][ANIMATION] Preparation completed");

        elements.statusText.textContent = "Checking cancer patients...";

        elements.description.textContent =
            "Searching for patients with cancer photos.";

        elements.counter.textContent = "Checking patient records...";

        elements.progressBar.style.width = "30%";

        console.log("[CANCER SYNC][STEP 4] Starting server synchronization");

        startSynchronization(elements);
    }, 900);
}
