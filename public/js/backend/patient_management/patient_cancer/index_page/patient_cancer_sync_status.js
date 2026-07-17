/**
 * |--------------------------------------------------------------------------
 * | Patient Cancer Sync - Status
 * |--------------------------------------------------------------------------
 */

function showAlreadySynced(data, elements) {
    console.log("[CANCER SYNC][STATUS] Already synchronized");

    elements.modalTitle.textContent = "Already Synchronized";

    elements.statusText.textContent = "All Cancer Patients Are Synced";

    elements.description.textContent =
        "No patient records required synchronization.";

    elements.counter.innerHTML = `
        <strong>
            ${data.total_patients}
        </strong>
        cancer photo patients are already synchronized.
    `;

    elements.modalIcon.className = "fas fa-check-circle text-success mr-2";

    elements.animation.innerHTML = `
        <div class="sync-success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
    `;

    elements.progressBar.className = "progress-bar bg-success";

    elements.closeButton.classList.remove("d-none");
}

function showSyncSuccess(data, elements) {
    console.log("[CANCER SYNC][STATUS] Synchronization successful");

    elements.modalTitle.textContent = "Synchronization Complete";

    elements.statusText.textContent = "Cancer Patients Successfully Synced";

    elements.description.textContent =
        "All patients with cancer photos have been synchronized.";

    elements.counter.innerHTML = `
        <strong>
            ${data.synced_now}
        </strong>
        patients synchronized successfully.
    `;

    elements.modalIcon.className = "fas fa-check-circle text-success mr-2";

    elements.animation.innerHTML = `
        <div class="sync-success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
    `;

    elements.progressBar.className = "progress-bar bg-success";

    elements.closeButton.classList.remove("d-none");
}

function showSyncError(error, elements) {
    console.error("[CANCER SYNC][STATUS] Synchronization failed:", error);

    elements.modalTitle.textContent = "Synchronization Failed";

    elements.statusText.textContent = "Something Went Wrong";

    elements.description.textContent = error.message;

    elements.counter.textContent = "Please try again.";

    elements.modalIcon.className =
        "fas fa-exclamation-triangle text-danger mr-2";

    elements.animation.innerHTML = `
        <div class="sync-error-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
    `;

    elements.progressBar.style.width = "100%";

    elements.progressBar.className = "progress-bar bg-danger";

    elements.closeButton.classList.remove("d-none");
}
