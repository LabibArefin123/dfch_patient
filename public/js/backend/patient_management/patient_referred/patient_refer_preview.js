/**
 * ==========================================================================
 * Patient Refer Preview
 * ==========================================================================
 * Main Initializer
 *
 * Required Files:
 * - patient_refer_validation.js
 * - patient_refer_progress.js
 * - patient_refer_card.js
 * - patient_refer_manager.js
 *
 * Works for:
 * ✔ Create Page
 * ✔ Edit Page
 * ==========================================================================
 */

document.addEventListener("DOMContentLoaded", () => {
    initializeReferPreview();
});

function initializeReferPreview() {
    const fileInputs = document.querySelectorAll('input[name="documents[]"]');

    if (!fileInputs.length) return;

    fileInputs.forEach((input, index) => {
        setupReferInput(input, index);
    });
}

/**
 * Initialize Single Input
 */
function setupReferInput(input, index) {
    const previewContainer = createPreviewContainer(input, index);
    input.dataset.previewContainer = previewContainer.id;

    input.addEventListener("change", (e) => {
        handleReferFiles(e.target, previewContainer);
    });
}

/**Create Preview Container Automatically*/
function createPreviewContainer(input) {
    let container = document.getElementById("referPreviewContainer");

    if (!container) {
        container = document.createElement("div");
        container.id = "referPreviewContainer";
        container.className = "refer-preview-container mt-3";

        input.closest(".form-group").appendChild(container);
    }

    return container;
}

/** Main Handler*/
function handleReferFiles(input, previewContainer) {
    if (!input.files.length) {
        previewContainer.innerHTML = "";
        return;
    }

    previewContainer.innerHTML = "";
    const dataTransfer = new DataTransfer();
    Array.from(input.files).forEach((file) => {
        /** Validate */
        const validation = validateReferImage(file);

        if (!validation.valid) {
            const errorCard = createReferErrorCard(file, validation.message);

            previewContainer.appendChild(errorCard);
            return;
        }

        /** Keep valid image */
        dataTransfer.items.add(file);

        /**Create Card*/
        const card = createReferPreviewCard(file);

        previewContainer.appendChild(card);

        /** Read Image */
        // const img = card.querySelector(".refer-preview-image");

        if (file.type === "application/pdf") {
            animateReferProgress(card);
        } else {
            const img = card.querySelector(".refer-preview-image");

            const reader = new FileReader();

            reader.onload = function (e) {
                img.src = e.target.result;
                animateReferProgress(card);
            };

            reader.readAsDataURL(file);
        }
    });

    /** Replace FileList*/
    input.files = dataTransfer.files;

    /**Activate Remove Button*/
    initializeReferRemoveButtons(input, previewContainer);
}
