/**
 * ==========================================================================
 * Patient Investigate Manager
 * ==========================================================================
 * File:
 * patient_investigation_manager.js
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
function initializeInvestigateRemoveButtons(input, previewContainer) {
    if (!input || !previewContainer) return;

    previewContainer
        .querySelectorAll(".investigation-remove-btn")
        .forEach((button) => {
            button.onclick = function (e) {
                e.preventDefault();
                e.stopPropagation();

                const card = this.closest(".investigation-card");

                if (!card) return;

                removeInvestigateImage(card, input, previewContainer);
            };
        });
}

/**
 * Remove One Image
 */
function removeInvestigateImage(card, input, previewContainer) {
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

        refreshInvestigateGrid(previewContainer);

        if (input.files.length === 0) {
            previewContainer.innerHTML = "";
        }
    }, 250);
}

/**
 * Refresh Grid Numbering
 */
function refreshInvestigateGrid(previewContainer) {
    const cards = previewContainer.querySelectorAll(".investigation-card");

    cards.forEach((card, index) => {
        card.dataset.index = index;
    });
}

/**
 * Remove All Images
 */
function clearInvestigateImages(input, previewContainer) {
    if (!input || !previewContainer) return;

    input.value = "";
    previewContainer.innerHTML = "";
}

/**
 * Get Valid Files
 */
function getInvestigateFiles(input) {
    return Array.from(input.files);
}

/**
 * Count Files
 */
function getInvestigateFileCount(input) {
    return input.files.length;
}

/**
 * Check if Empty
 */
function hasInvestigateImages(input) {
    return input.files.length > 0;
}

/**
 * Append New Files
 *
 * Optional helper for future drag & drop support.
 */
function appendInvestigateFiles(input, files) {
    const dataTransfer = new DataTransfer();

    Array.from(input.files).forEach((file) => {
        dataTransfer.items.add(file);
    });

    Array.from(files).forEach((file) => {
        const validation = validateInvestigateImage(file);

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
function rebuildInvestigatePreview(input, previewContainer) {
    previewContainer.innerHTML = "";

    Array.from(input.files).forEach((file) => {
        const card = createInvestigatePreviewCard(file);

        previewContainer.appendChild(card);

        const reader = new FileReader();

        reader.onload = function (e) {
            const image = card.querySelector(".investigation-preview-image");

            if (image) {
                image.src = e.target.result;
            }

            completeInvestigateProgress(card);
        };

        reader.readAsDataURL(file);
    });

    initializeInvestigateRemoveButtons(input, previewContainer);
}
