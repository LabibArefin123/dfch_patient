/**
 * |--------------------------------------------------------------------------
 * | Patient Cancer Sync - UI
 * |--------------------------------------------------------------------------
 */

function openSyncModal(modal) {
    console.log("[CANCER SYNC][UI] Opening synchronization modal");

    if (!modal || modal.length === 0) {
        console.error("[CANCER SYNC][UI] Modal element does not exist");

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Force Modal Open
    |--------------------------------------------------------------------------
    */

    modal.modal("show");

    console.log("[CANCER SYNC][UI] Modal opened");
}

function resetSyncModal(elements) {
    console.log("[CANCER SYNC][UI] Resetting modal");

    elements.modalTitle.textContent = "Synchronizing Cancer Patients";

    elements.statusText.textContent = "Preparing synchronization...";

    elements.description.textContent =
        "Please wait while cancer patients are being synchronized.";

    elements.counter.textContent = "Starting...";

    elements.progressBar.style.width = "0%";

    elements.progressBar.className =
        "progress-bar progress-bar-striped progress-bar-animated";

    elements.modalIcon.className = "fas fa-sync-alt text-primary mr-2";

    elements.animation.innerHTML = `
        <div class="sync-spinner">
            <i class="fas fa-dna"></i>
        </div>
    `;

    elements.closeButton.classList.add("d-none");
}
