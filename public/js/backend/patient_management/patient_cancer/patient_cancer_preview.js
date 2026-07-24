/**
 * ==========================================================================
 * Patient Cancer Preview
 * ==========================================================================
 * Main Initializer
 *
 * Required Files:
 * - patient_cancer_validation.js
 * - patient_cancer_progress.js
 * - patient_cancer_card.js
 * - patient_cancer_manager.js
 *
 * Works for:
 * ✔ Create Page
 * ✔ Edit Page
 * ==========================================================================
 */

document.addEventListener("DOMContentLoaded", () => {
    initializeCancerPreview();
});

function initializeCancerPreview() {
    const fileInputs = document.querySelectorAll(
        'input[name="cancer_images[]"]',
    );

    if (!fileInputs.length) return;

    fileInputs.forEach((input, index) => {
        setupCancerInput(input, index);
    });
}

/**
 * Initialize Single Input
 */
function setupCancerInput(input, index) {
    const previewContainer = createPreviewContainer(input, index);

    input.dataset.previewContainer = previewContainer.id;

    input.addEventListener("change", (e) => {
        handleCancerFiles(e.target, previewContainer);
    });
}

/**
 * Create Preview Container Automatically
 */
function createPreviewContainer(input, index) {
    let container = document.getElementById("cancerPreviewContainer");

    if (container) {
        return container;
    }

    container = document.createElement("div");
    container.id = "cancer-preview-" + index;
    container.className = "cancer-preview-container";

    input.closest(".form-group").appendChild(container);

    return container;
}

/**
 * Main Handler
 */
function handleCancerFiles(input, previewContainer) {
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
        const validation = validateCancerImage(file);

        if (!validation.valid) {
            const errorCard = createCancerErrorCard(
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
        const card = createCancerPreviewCard(file);

        previewContainer.appendChild(card);

        /**
         * Read Image
         */
        const reader = new FileReader();

        reader.onload = (event) => {
            const img = card.querySelector(".cancer-preview-image");

            if (img) {
                img.src = event.target.result;
            }

            /**
             * Start Progress Animation
             */
            animateCancerProgress(card);
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
    initializeCancerRemoveButtons(input, previewContainer);
}
