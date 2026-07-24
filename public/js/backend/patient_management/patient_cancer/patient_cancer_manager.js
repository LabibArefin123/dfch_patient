/**
 * ==========================================================================
 * Patient Cancer Manager
 * ==========================================================================
 * File:
 * patient_cancer_manager.js
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
function initializeCancerRemoveButtons(input, previewContainer) {
    if (!input || !previewContainer) return;

    previewContainer
        .querySelectorAll(".cancer-remove-btn")
        .forEach((button) => {
            button.onclick = function (e) {
                e.preventDefault();
                e.stopPropagation();

                const card = this.closest(".cancer-card");

                if (!card) return;

                removeCancerImage(card, input, previewContainer);
            };
        });
}

/**
 * Remove One Image
 */
function removeCancerImage(card, input, previewContainer) {
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

        refreshCancerGrid(previewContainer);

        if (input.files.length === 0) {
            previewContainer.innerHTML = "";
        }
    }, 250);
}

/**
 * Refresh Grid Numbering
 */
function refreshCancerGrid(previewContainer) {
    const cards = previewContainer.querySelectorAll(".cancer-card");

    cards.forEach((card, index) => {
        card.dataset.index = index;
    });
}

/**
 * Remove All Images
 */
function clearCancerImages(input, previewContainer) {
    if (!input || !previewContainer) return;

    input.value = "";
    previewContainer.innerHTML = "";
}

/**
 * Get Valid Files
 */
function getCancerFiles(input) {
    return Array.from(input.files);
}

/**
 * Count Files
 */
function getCancerFileCount(input) {
    return input.files.length;
}

/**
 * Check if Empty
 */
function hasCancerImages(input) {
    return input.files.length > 0;
}

/**
 * Append New Files
 *
 * Optional helper for future drag & drop support.
 */
function appendCancerFiles(input, files) {
    const dataTransfer = new DataTransfer();

    Array.from(input.files).forEach((file) => {
        dataTransfer.items.add(file);
    });

    Array.from(files).forEach((file) => {
        const validation = validateCancerImage(file);

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
function rebuildCancerPreview(input, previewContainer) {
    previewContainer.innerHTML = "";

    Array.from(input.files).forEach((file) => {
        const card = createCancerPreviewCard(file);

        previewContainer.appendChild(card);

        const reader = new FileReader();

        reader.onload = function (e) {
            const image = card.querySelector(".cancer-preview-image");

            if (image) {
                image.src = e.target.result;
            }

            completeCancerProgress(card);
        };

        reader.readAsDataURL(file);
    });

    initializeCancerRemoveButtons(input, previewContainer);
}
