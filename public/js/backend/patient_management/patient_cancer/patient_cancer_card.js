/**
 * ==========================================================================
 * Patient Cancer Card
 * ==========================================================================
 * File:
 * patient_cancer_card.js
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
function createCancerPreviewCard(file) {
    const info = getCancerImageInfo(file);

    const card = document.createElement("div");
    card.className = "cancer-card";
    card.dataset.filename = file.name;

    card.innerHTML = `
        <div class="cancer-card-image">

            <img
                class="cancer-preview-image"
                src=""
                alt="${info.name}"
            >

            <button
                type="button"
                class="btn btn-danger btn-sm cancer-remove-btn"
                title="Remove Image">
                <i class="fas fa-times"></i>
            </button>

        </div>

        <div class="cancer-card-body">

            <div class="cancer-file-name" title="${info.name}">
                ${info.name}
            </div>

            <div class="cancer-file-size">
                ${info.size}
            </div>

            <div class="cancer-progress-wrapper">

                <svg
                    class="cancer-progress-circle"
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

            <div class="cancer-status badge badge-secondary mt-2">
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
function createCancerErrorCard(file, message) {
    const size = formatCancerFileSize(file.size);

    const card = document.createElement("div");

    card.className = "cancer-card cancer-error-card";

    card.innerHTML = `
        <div class="cancer-card-image cancer-error-image">

            <i
                class="fas fa-exclamation-circle text-danger"
                style="font-size:55px;">
            </i>

        </div>

        <div class="cancer-card-body">

            <div class="cancer-file-name text-danger" title="${file.name}">
                ${file.name}
            </div>

            <div class="cancer-file-size">
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
function updateCancerCardProgress(card, percent) {
    const circle = card.querySelector(".progress-bar");
    const text = card.querySelector(".progress-text");
    const status = card.querySelector(".cancer-status");

    if (!circle || !text || !status) return;

    const radius = 28;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = circumference;

    const offset = circumference - (percent / 100) * circumference;

    circle.style.strokeDashoffset = offset;

    text.textContent = percent + "%";

    if (percent >= 100) {
        status.className = "cancer-status badge badge-success mt-2";

        status.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Ready';

        card.classList.add("cancer-ready");
    }
}

/**
 * Mark Error
 *
 * @param {HTMLElement} card
 * @param {String} message
 */
function markCancerCardError(card, message) {
    const status = card.querySelector(".cancer-status");

    if (!status) return;

    status.className = "cancer-status badge badge-danger mt-2";

    status.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Error';

    const alert = document.createElement("div");

    alert.className = "alert alert-danger mt-2 mb-0 p-2";

    alert.innerHTML = `<small>${message}</small>`;

    card.querySelector(".cancer-card-body").appendChild(alert);

    card.classList.add("cancer-error-card");
}

/**
 * Change Status Text
 *
 * @param {HTMLElement} card
 * @param {String} text
 * @param {String} badgeClass
 */
function setCancerCardStatus(card, text, badgeClass = "badge-info") {
    const status = card.querySelector(".cancer-status");

    if (!status) return;

    status.className = `cancer-status badge ${badgeClass} mt-2`;

    status.textContent = text;
}
