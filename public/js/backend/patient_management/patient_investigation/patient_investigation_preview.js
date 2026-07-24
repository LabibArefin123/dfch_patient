/**
 * ==========================================================================
 * Patient Investigate Preview
 * ==========================================================================
 * Main Initializer
 *
 * Required Files:
 * - patient_investigation_validation.js
 * - patient_investigation_progress.js
 * - patient_investigation_card.js
 * - patient_investigation_manager.js
 *
 * Works for:
 * ✔ Create Page
 * ✔ Edit Page
 * ==========================================================================
 */

document.addEventListener("DOMContentLoaded", () => {
    initializeInvestigatePreview();
});

function initializeInvestigatePreview() {
    const fileInputs = document.querySelectorAll(
        'input[name="investigation_images[]"]',
    );

    if (!fileInputs.length) return;

    fileInputs.forEach((input, index) => {
        setupInvestigateInput(input, index);
    });
}

/**
 * Initialize Single Input
 */
function setupInvestigateInput(input, index) {
    const previewContainer = createInvestigateContainer(input, index);

    input.dataset.previewContainer = previewContainer.id;

    input.addEventListener("change", (e) => {
        handleInvestigateFiles(e.target, previewContainer);
    });
}

/**
 * Create Preview Container Automatically
 */
function createInvestigateContainer(input, index) {
    let container = input.parentElement.querySelector(
        ".investigation-preview-container",
    );

    if (container) return container;

    container = document.createElement("div");
    container.className = "investigation-preview-container";
    container.id = "investigation-preview-" + index;

    input.parentElement.appendChild(container);

    return container;
}

/**
 * Main Handler
 */
function handleInvestigateFiles(input, previewContainer) {
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
        const validation = validateInvestigateImage(file);

        if (!validation.valid) {
            const errorCard = createInvestigateErrorCard(
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
        const card = createInvestigatePreviewCard(file);

        previewContainer.appendChild(card);

        /**
         * Read Image
         */
        const reader = new FileReader();

        reader.onload = (event) => {
            const img = card.querySelector(".investigation-preview-image");

            if (img) {
                img.src = event.target.result;
            }

            /**
             * Start Progress Animation
             */
            animateInvestigateProgress(card);
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
    initializeInvestigateRemoveButtons(input, previewContainer);
}
