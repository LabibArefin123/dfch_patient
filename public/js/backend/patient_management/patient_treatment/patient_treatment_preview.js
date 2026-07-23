/**
 * ==========================================================================
 * Patient Treatment Preview
 * ==========================================================================
 * Main Initializer
 *
 * Required Files:
 * - patient_treatment_validation.js
 * - patient_treatment_progress.js
 * - patient_treatment_card.js
 * - patient_treatment_manager.js
 *
 * Works for:
 * ✔ Create Page
 * ✔ Edit Page
 * ==========================================================================
 */

document.addEventListener("DOMContentLoaded", () => {
    initializeTreatmentPreview();
});

function initializeTreatmentPreview() {
    const fileInputs = document.querySelectorAll(
        'input[name="treatment_images[]"]',
    );

    if (!fileInputs.length) return;

    fileInputs.forEach((input, index) => {
        setupTreatmentInput(input, index);
    });
}

/**
 * Initialize Single Input
 */
function setupTreatmentInput(input, index) {
    const previewContainer = createPreviewContainer(input, index);

    input.dataset.previewContainer = previewContainer.id;

    input.addEventListener("change", (e) => {
        handleTreatmentFiles(e.target, previewContainer);
    });
}

/**
 * Create Preview Container Automatically
 */
function createPreviewContainer(input, index) {
    let container = input.parentElement.querySelector(
        ".treatment-preview-container",
    );

    if (container) return container;

    container = document.createElement("div");
    container.className = "treatment-preview-container";
    container.id = "treatment-preview-" + index;

    input.parentElement.appendChild(container);

    return container;
}

/**
 * Main Handler
 */
function handleTreatmentFiles(input, previewContainer) {
    if (!input.files.length) {
        previewContainer.innerHTML = "";
        return;
    }

    previewContainer.innerHTML = "";

    const dataTransfer = new DataTransfer();

    Array.from(input.files).forEach((file) => {
        /**
         * Validate
         */
        const validation = validateTreatmentImage(file);

        if (!validation.valid) {
            const errorCard = createTreatmentErrorCard(
                file,
                validation.message,
            );

            previewContainer.appendChild(errorCard);

            return;
        }

        /**
         * Keep valid image
         */
        dataTransfer.items.add(file);

        /**
         * Create Card
         */
        const card = createTreatmentPreviewCard(file);

        previewContainer.appendChild(card);

        /**
         * Read Image
         */
        const reader = new FileReader();

        reader.onload = (event) => {
            const img = card.querySelector(".treatment-preview-image");

            if (img) {
                img.src = event.target.result;
            }

            /**
             * Start Progress Animation
             */
            animateTreatmentProgress(card);
        };

        reader.readAsDataURL(file);
    });

    /**
     * Replace FileList
     */
    input.files = dataTransfer.files;

    /**
     * Activate Remove Button
     */
    initializeTreatmentRemoveButtons(input, previewContainer);
}
