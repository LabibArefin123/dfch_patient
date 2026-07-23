/**
 * ==========================================================================
 * Patient Treatment Manager
 * ==========================================================================
 * File:
 * patient_treatment_manager.js
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
function initializeTreatmentRemoveButtons(input, previewContainer) {
    if (!input || !previewContainer) return;

    previewContainer
        .querySelectorAll(".treatment-remove-btn")
        .forEach((button) => {
            button.onclick = function (e) {
                e.preventDefault();
                e.stopPropagation();

                const card = this.closest(".treatment-card");

                if (!card) return;

                removeTreatmentImage(card, input, previewContainer);
            };
        });
}

/**
 * Remove One Image
 */
function removeTreatmentImage(card, input, previewContainer) {
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

        refreshTreatmentGrid(previewContainer);

        if (input.files.length === 0) {
            previewContainer.innerHTML = "";
        }
    }, 250);
}

/**
 * Refresh Grid Numbering
 */
function refreshTreatmentGrid(previewContainer) {
    const cards = previewContainer.querySelectorAll(".treatment-card");

    cards.forEach((card, index) => {
        card.dataset.index = index;
    });
}

/**
 * Remove All Images
 */
function clearTreatmentImages(input, previewContainer) {
    if (!input || !previewContainer) return;

    input.value = "";
    previewContainer.innerHTML = "";
}

/**
 * Get Valid Files
 */
function getTreatmentFiles(input) {
    return Array.from(input.files);
}

/**
 * Count Files
 */
function getTreatmentFileCount(input) {
    return input.files.length;
}

/**
 * Check if Empty
 */
function hasTreatmentImages(input) {
    return input.files.length > 0;
}

/**
 * Append New Files
 *
 * Optional helper for future drag & drop support.
 */
function appendTreatmentFiles(input, files) {
    const dataTransfer = new DataTransfer();

    Array.from(input.files).forEach((file) => {
        dataTransfer.items.add(file);
    });

    Array.from(files).forEach((file) => {
        const validation = validateTreatmentImage(file);

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
function rebuildTreatmentPreview(input, previewContainer) {
    previewContainer.innerHTML = "";

    Array.from(input.files).forEach((file) => {
        const card = createTreatmentPreviewCard(file);

        previewContainer.appendChild(card);

        const reader = new FileReader();

        reader.onload = function (e) {
            const image = card.querySelector(".treatment-preview-image");

            if (image) {
                image.src = e.target.result;
            }

            completeTreatmentProgress(card);
        };

        reader.readAsDataURL(file);
    });

    initializeTreatmentRemoveButtons(input, previewContainer);
}
