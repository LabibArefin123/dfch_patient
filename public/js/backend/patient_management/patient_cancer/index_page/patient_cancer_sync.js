document.addEventListener("DOMContentLoaded", function () {
    const syncButton = document.getElementById("syncCancerPatientsBtn");

    if (!syncButton) {
        console.error("[CANCER SYNC] Sync button not found");

        return;
    }

    const modal = $("#cancerPatientSyncModal");

    const modalTitle = document.getElementById("syncModalTitle");

    const statusText = document.getElementById("syncStatusText");

    const description = document.getElementById("syncDescription");

    const progressBar = document.getElementById("syncProgressBar");

    const counter = document.getElementById("syncCounter");

    const animation = document.getElementById("syncAnimation");

    const modalIcon = document.getElementById("syncModalIcon");

    const closeButton = document.getElementById("syncCloseBtn");

    syncButton.addEventListener("click", function () {
        console.log("[CANCER SYNC] Synchronization started");

        // Reset modal
        modalTitle.textContent = "Synchronizing Cancer Patients";

        statusText.textContent = "Preparing synchronization...";

        description.textContent =
            "Please wait while cancer patients are being synchronized.";

        counter.textContent = "Starting...";

        progressBar.style.width = "0%";

        progressBar.className =
            "progress-bar progress-bar-striped progress-bar-animated";

        modalIcon.className = "fas fa-sync-alt text-primary mr-2";

        animation.innerHTML = `
                <div class="sync-spinner">
                    <i class="fas fa-dna"></i>
                </div>
            `;

        closeButton.classList.add("d-none");

        modal.modal({
            backdrop: "static",
            keyboard: false,
        });

        // Slow animation before request
        setTimeout(function () {
            statusText.textContent = "Checking cancer patients...";

            description.textContent =
                "Searching for patients with cancer photos.";

            counter.textContent = "Checking patient records...";

            progressBar.style.width = "30%";

            startSynchronization();
        }, 900);
    });

    function startSynchronization() {
        console.log("[CANCER SYNC] Sending sync request");

        fetch("{{ route('patient-cancer-photos.sync') }}", {
            method: "POST",

            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),

                Accept: "application/json",

                "Content-Type": "application/json",
            },
        })
            .then(function (response) {
                console.log("[CANCER SYNC] Response status:", response.status);

                if (!response.ok) {
                    throw new Error("Synchronization failed");
                }

                return response.json();
            })
            .then(function (data) {
                console.log("[CANCER SYNC] Sync response:", data);

                progressBar.style.width = "100%";

                if (data.status === "already_synced") {
                    showAlreadySynced(data);

                    return;
                }

                showSyncSuccess(data);
            })
            .catch(function (error) {
                console.error("[CANCER SYNC] Error:", error);

                showSyncError(error);
            });
    }

    function showAlreadySynced(data) {
        modalTitle.textContent = "Already Synchronized";

        statusText.textContent = "All Cancer Patients Are Synced";

        description.textContent =
            "No patient records required synchronization.";

        counter.innerHTML = `
            <strong>
                ${data.total_patients}
            </strong>
            cancer photo patients are already synchronized.
        `;

        modalIcon.className = "fas fa-check-circle text-success mr-2";

        animation.innerHTML = `
            <div
                style="
                    font-size: 80px;
                    color: #198754;
                "
            >
                <i class="fas fa-check-circle"></i>
            </div>
        `;

        progressBar.className = "progress-bar bg-success";

        closeButton.classList.remove("d-none");
    }

    function showSyncSuccess(data) {
        modalTitle.textContent = "Synchronization Complete";

        statusText.textContent = "Cancer Patients Successfully Synced";

        description.textContent =
            "All patients with cancer photos have been synchronized.";

        counter.innerHTML = `
            <strong>
                ${data.synced_now}
            </strong>
            patients synchronized successfully.
        `;

        modalIcon.className = "fas fa-check-circle text-success mr-2";

        animation.innerHTML = `
            <div
                style="
                    font-size: 80px;
                    color: #198754;
                "
            >
                <i class="fas fa-check-circle"></i>
            </div>
        `;

        progressBar.className = "progress-bar bg-success";

        closeButton.classList.remove("d-none");
    }

    function showSyncError(error) {
        modalTitle.textContent = "Synchronization Failed";

        statusText.textContent = "Something Went Wrong";

        description.textContent = error.message;

        counter.textContent = "Please try again.";

        modalIcon.className = "fas fa-exclamation-triangle text-danger mr-2";

        animation.innerHTML = `
            <div
                style="
                    font-size: 80px;
                    color: #dc3545;
                "
            >
                <i class="fas fa-exclamation-circle"></i>
            </div>
        `;

        progressBar.style.width = "100%";

        progressBar.className = "progress-bar bg-danger";

        closeButton.classList.remove("d-none");
    }
});
