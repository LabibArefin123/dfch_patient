/**
 * ==========================================================================
 * Patient Treatment Card
 * ==========================================================================
 * File:
 * patient_investigation_card.js
 *
 * Responsibilities
 * ----------------
 * ✔ Create Preview Card
 * ✔ Create Error Card
 * ✔ SVG Progress Circle
 * ==========================================================================
 */

/**
 * Create Preview Card
 *
 * @param {File} file
 * @returns {HTMLElement}
 */
function createTreatmentPreviewCard(file) {
    const info = getTreatmentImageInfo(file);

    const card = document.createElement("div");
    card.className = "investigation-card";
    card.dataset.filename = file.name;

    card.innerHTML = `
        <div class="investigation-card-image">

            <img
                class="investigation-preview-image"
                src=""
                alt="${info.name}"
            >

            <button
                type="button"
                class="btn btn-danger btn-sm investigation-remove-btn"
                title="Remove Image">
                <i class="fas fa-times"></i>
            </button>

        </div>

        <div class="investigation-card-body">

            <div class="investigation-file-name" title="${info.name}">
                ${info.name}
            </div>

            <div class="investigation-file-size">
                ${info.size}
            </div>

            <div class="investigation-progress-wrapper">

                <svg
                    class="investigation-progress-circle"
                    width="70"
                    height="70"
                    viewBox="0 0 70 70">

                    <circle
                        class="progress-bg"
                        cx="35"
                        cy="35"
                        r="28">
                    </circle>

                    <circle
                        class="progress-bar"
                        cx="35"
                        cy="35"
                        r="28"
                        stroke-dasharray="176"
                        stroke-dashoffset="176">
                    </circle>

                    <text
                        class="progress-text"
                        x="35"
                        y="35"
                        text-anchor="middle">
                        0%
                    </text>

                </svg>

            </div>

            <div class="investigation-status badge badge-secondary mt-2">
                Loading...
            </div>

        </div>
    `;

    return card;
}

/**
 * Error Card
 *
 * @param {File} file
 * @param {String} message
 * @returns {HTMLElement}
 */
function createTreatmentErrorCard(file, message) {
    const size = formatTreatmentFileSize(file.size);

    const card = document.createElement("div");

    card.className = "investigation-card investigation-error-card";

    card.innerHTML = `
        <div class="investigation-card-image investigation-error-image">

            <i
                class="fas fa-exclamation-circle text-danger"
                style="font-size:55px;">
            </i>

        </div>

        <div class="investigation-card-body">

            <div class="investigation-file-name text-danger" title="${file.name}">
                ${file.name}
            </div>

            <div class="investigation-file-size">
                ${size}
            </div>

            <div class="alert alert-danger p-2 mt-2 mb-0">
                <small>${message}</small>
            </div>

        </div>
    `;

    return card;
}

/**
 * Update Progress
 *
 * @param {HTMLElement} card
 * @param {Number} percent
 */
function updateTreatmentCardProgress(card, percent) {
    const circle = card.querySelector(".progress-bar");
    const text = card.querySelector(".progress-text");
    const status = card.querySelector(".investigation-status");

    if (!circle || !text || !status) return;

    const radius = 28;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = circumference;

    const offset = circumference - (percent / 100) * circumference;

    circle.style.strokeDashoffset = offset;

    text.textContent = percent + "%";

    if (percent >= 100) {
        status.className = "investigation-status badge badge-success mt-2";

        status.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Ready';

        card.classList.add("investigation-ready");
    }
}

/**
 * Mark Error
 *
 * @param {HTMLElement} card
 * @param {String} message
 */
function markTreatmentCardError(card, message) {
    const status = card.querySelector(".investigation-status");

    if (!status) return;

    status.className = "investigation-status badge badge-danger mt-2";

    status.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Error';

    const alert = document.createElement("div");

    alert.className = "alert alert-danger mt-2 mb-0 p-2";

    alert.innerHTML = `<small>${message}</small>`;

    card.querySelector(".investigation-card-body").appendChild(alert);

    card.classList.add("investigation-error-card");
}

/**
 * Change Status Text
 *
 * @param {HTMLElement} card
 * @param {String} text
 * @param {String} badgeClass
 */
function setTreatmentCardStatus(card, text, badgeClass = "badge-info") {
    const status = card.querySelector(".investigation-status");

    if (!status) return;

    status.className = `investigation-status badge ${badgeClass} mt-2`;

    status.textContent = text;
}
