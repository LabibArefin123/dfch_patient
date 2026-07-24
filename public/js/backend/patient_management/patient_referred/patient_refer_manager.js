/**
 * ==========================================================================
 * Patient Refer Manager
 * ==========================================================================
 * File:
 * patient_refer_manager.js
 *
 * Responsibilities
 * ----------------
 * ✔ Remove selected image
 * ✔ Sync <input type="file"> using DataTransfer
 * ✔ Refresh preview after removal
 * ✔ Keep valid images only
 * ==========================================================================
 */

/**
 * Initialize Remove Buttons
 *
 * @param {HTMLInputElement} input
 * @param {HTMLElement} previewContainer
 */
function initializeReferRemoveButtons(input, previewContainer) {
    if (!input || !previewContainer) return;

    previewContainer.querySelectorAll(".refer-remove-btn").forEach((button) => {
        button.onclick = function (e) {
            e.preventDefault();
            e.stopPropagation();

            const card = this.closest(".refer-card");

            if (!card) return;

            removeReferImage(card, input, previewContainer);
        };
    });
}

/**
 * Remove One Image
 */
function removeReferImage(card, input, previewContainer) {
    const fileName = card.dataset.filename;

    if (!fileName) {
        card.remove();
        return;
    }

    const dataTransfer = new DataTransfer();

    Array.from(input.files).forEach((file) => {
        if (file.name !== fileName) {
            dataTransfer.items.add(file);
        }
    });

    input.files = dataTransfer.files;

    card.style.transition = "all .25s ease";
    card.style.opacity = "0";
    card.style.transform = "scale(.9)";

    setTimeout(() => {
        card.remove();

        refreshReferGrid(previewContainer);

        if (input.files.length === 0) {
            previewContainer.innerHTML = "";
        }
    }, 250);
}

/**
 * Refresh Grid Numbering
 */
function refreshReferGrid(previewContainer) {
    const cards = previewContainer.querySelectorAll(".refer-card");

    cards.forEach((card, index) => {
        card.dataset.index = index;
    });
}

/**
 * Remove All Images
 */
function clearReferImages(input, previewContainer) {
    if (!input || !previewContainer) return;

    input.value = "";
    previewContainer.innerHTML = "";
}

/**
 * Get Valid Files
 */
function getReferFiles(input) {
    return Array.from(input.files);
}

/**
 * Count Files
 */
function getReferFileCount(input) {
    return input.files.length;
}

/**
 * Check if Empty
 */
function hasReferImages(input) {
    return input.files.length > 0;
}

/**
 * Append New Files
 *
 * Optional helper for future drag & drop support.
 */
function appendReferFiles(input, files) {
    const dataTransfer = new DataTransfer();

    Array.from(input.files).forEach((file) => {
        dataTransfer.items.add(file);
    });

    Array.from(files).forEach((file) => {
        const validation = validateReferImage(file);

        if (validation.valid) {
            dataTransfer.items.add(file);
        }
    });

    input.files = dataTransfer.files;
}

/**
 * Rebuild Preview
 *
 * Optional helper.
 */
function rebuildReferPreview(input, previewContainer) {
    previewContainer.innerHTML = "";

    Array.from(input.files).forEach((file) => {
        const card = createReferPreviewCard(file);

        previewContainer.appendChild(card);

        const reader = new FileReader();

        reader.onload = function (e) {
            const image = card.querySelector(".refer-preview-image");

            if (image) {
                image.src = e.target.result;
            }

            completeReferProgress(card);
        };

        reader.readAsDataURL(file);
    });

    initializeReferRemoveButtons(input, previewContainer);
}
