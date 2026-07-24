/**
 * ==========================================================================
 * Patient Refer Card
 * ==========================================================================
 * File:
 * patient_refer_card.js
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
function createReferPreviewCard(file) {
    const info = getReferImageInfo(file);

    const card = document.createElement("div");
    card.className = "refer-card";
    card.dataset.filename = file.name;

    card.innerHTML = `
        <div class="refer-card-image">

            <img
                class="refer-preview-image"
                src=""
                alt="${info.name}"
            >
            

            <button
                type="button"
                class="btn btn-danger btn-sm refer-remove-btn"
                title="Remove Image">
                <i class="fas fa-times"></i>
            </button>

        </div>

        <div class="refer-card-body">

            <div class="refer-file-name" title="${info.name}">
                ${info.name}
            </div>

            <div class="refer-file-size">
                ${info.size}
            </div>

            <div class="refer-progress-wrapper">

                <svg
                    class="refer-progress-circle"
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

            <div class="refer-status badge badge-secondary mt-2">
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
function createReferErrorCard(file, message) {
    const size = formatReferFileSize(file.size);

    const card = document.createElement("div");

    card.className = "refer-card refer-error-card";

    card.innerHTML = `
        <div class="refer-card-image refer-error-image">

            <i
                class="fas fa-exclamation-circle text-danger"
                style="font-size:55px;">
            </i>

        </div>

        <div class="refer-card-body">

            <div class="refer-file-name text-danger" title="${file.name}">
                ${file.name}
            </div>

            <div class="refer-file-size">
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
function updateReferCardProgress(card, percent) {
    const circle = card.querySelector(".progress-bar");
    const text = card.querySelector(".progress-text");
    const status = card.querySelector(".refer-status");

    if (!circle || !text || !status) return;

    const radius = 28;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = circumference;

    const offset = circumference - (percent / 100) * circumference;

    circle.style.strokeDashoffset = offset;

    text.textContent = percent + "%";

    if (percent >= 100) {
        status.className = "refer-status badge badge-success mt-2";

        status.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Ready';

        card.classList.add("refer-ready");
    }
}

/**
 * Mark Error
 *
 * @param {HTMLElement} card
 * @param {String} message
 */
function markReferCardError(card, message) {
    const status = card.querySelector(".refer-status");

    if (!status) return;

    status.className = "refer-status badge badge-danger mt-2";

    status.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Error';

    const alert = document.createElement("div");

    alert.className = "alert alert-danger mt-2 mb-0 p-2";

    alert.innerHTML = `<small>${message}</small>`;

    card.querySelector(".refer-card-body").appendChild(alert);

    card.classList.add("refer-error-card");
}

/**
 * Change Status Text
 *
 * @param {HTMLElement} card
 * @param {String} text
 * @param {String} badgeClass
 */
function setReferCardStatus(card, text, badgeClass = "badge-info") {
    const status = card.querySelector(".refer-status");

    if (!status) return;

    status.className = `refer-status badge ${badgeClass} mt-2`;

    status.textContent = text;
}
