document.addEventListener("DOMContentLoaded", () => {
    const progressCard = document.querySelector(".patient-progress-card");

    if (!progressCard) return;

    /*
    |--------------------------------------------------------------------------
    | Find Treatment Progress Item
    |--------------------------------------------------------------------------
    | Uses data-target instead of nth-child().
    |
    | Example:
    | <div class="progress-item" data-target="part_5_treatment">
    |--------------------------------------------------------------------------
    */

    const treatmentItem = progressCard.querySelector(
        '.progress-item[data-target="part_5_treatment"]',
    );

    if (!treatmentItem) {
        console.warn(
            "Treatment progress item not found: data-target='part_5_treatment'",
        );
        return;
    }

    const step = treatmentItem.querySelector(".step");

    if (!step) return;

    injectTreatmentWaterCSS();

    /*
    |--------------------------------------------------------------------------
    | Fields
    |--------------------------------------------------------------------------
    */

    const statusField = document.getElementById("is_treatment");

    const typeField = document.getElementById("treatment_type");

    const imageField = document.querySelector(
        "input[name='treatment_images[]']",
    );

    /*
    | IMPORTANT
    | Create page may use treatment_information
    | Edit page uses edit_treatment_information
    */

    const summaryField =
        document.getElementById("edit_treatment_information") ||
        document.getElementById("treatment_information");

    /*
    |--------------------------------------------------------------------------
    | Existing Treatment Images
    |--------------------------------------------------------------------------
    |
    | Edit page already contains images.
    | We detect them from the treatment section.
    |--------------------------------------------------------------------------
    */

    const treatmentSection = document.getElementById("part_5_treatment");

    /*
    |--------------------------------------------------------------------------
    | CKEditor Value
    |--------------------------------------------------------------------------
    */

    function getEditorValue(textarea) {
        if (!textarea) return "";

        /*
        | CKEditor 5
        */

        if (textarea.ckeditorInstance) {
            return textarea.ckeditorInstance
                .getData()
                .replace(/<[^>]*>/g, "")
                .replace(/&nbsp;/gi, " ")
                .trim();
        }

        /*
        | Normal textarea
        */

        return textarea.value.trim();
    }

    /*
    |--------------------------------------------------------------------------
    | Check Existing Treatment Images
    |--------------------------------------------------------------------------
    */

    function hasExistingTreatmentImages() {
        if (!treatmentSection) return false;

        /*
        | Existing images are inside the Treatment Images card.
        |
        | We specifically look for images with the treatment image class
        | or images inside the treatment section.
        */

        const existingImages =
            treatmentSection.querySelectorAll(".magnify-img");

        return existingImages.length > 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Check New Uploaded Images
    |--------------------------------------------------------------------------
    */

    function hasNewTreatmentImages() {
        return imageField && imageField.files && imageField.files.length > 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Treatment Progress
    |--------------------------------------------------------------------------
    */

    function updateTreatmentProgress() {
        if (!step) return;

        let percent = 0;

        /*
        |--------------------------------------------------------------------------
        | Treatment Disabled
        |--------------------------------------------------------------------------
        */

        if (!statusField || statusField.value !== "1") {
            step.style.setProperty("--fill", "0%");

            treatmentItem.classList.remove("completed");

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Treatment Enabled
        |--------------------------------------------------------------------------
        |
        | Treatment status itself means the patient has treatment information.
        |
        | We divide the progress:
        |
        | Treatment Type        = 30%
        | Treatment Information = 40%
        | Treatment Images      = 30%
        |--------------------------------------------------------------------------
        */

        /*
        | Treatment Type
        */

        if (typeField && typeField.value.trim() !== "") {
            percent += 30;
        }

        /*
        | Treatment Information
        */

        if (getEditorValue(summaryField) !== "") {
            percent += 40;
        }

        /*
        | Treatment Images
        |
        | Either existing images OR newly selected images count.
        */

        if (hasExistingTreatmentImages() || hasNewTreatmentImages()) {
            percent += 30;
        }

        /*
        |--------------------------------------------------------------------------
        | Apply Progress
        |--------------------------------------------------------------------------
        */

        step.style.setProperty("--fill", percent + "%");

        treatmentItem.classList.toggle("completed", percent === 100);
    }

    /*
    |--------------------------------------------------------------------------
    | Normal Fields
    |--------------------------------------------------------------------------
    */

    if (statusField) {
        statusField.addEventListener("change", updateTreatmentProgress);
    }

    if (typeField) {
        typeField.addEventListener("change", updateTreatmentProgress);

        typeField.addEventListener("input", updateTreatmentProgress);
    }

    /*
    |--------------------------------------------------------------------------
    | New Treatment Images
    |--------------------------------------------------------------------------
    */

    if (imageField) {
        imageField.addEventListener("change", updateTreatmentProgress);
    }

    /*
    |--------------------------------------------------------------------------
    | CKEditor
    |--------------------------------------------------------------------------
    */

    if (summaryField) {
        const waitEditor = setInterval(() => {
            /*
            | If CKEditor is not ready yet, wait.
            */

            if (!summaryField.ckeditorInstance) {
                return;
            }

            clearInterval(waitEditor);

            summaryField.ckeditorInstance.model.document.on(
                "change:data",
                updateTreatmentProgress,
            );

            /*
            | Initial calculation after CKEditor is ready
            */

            updateTreatmentProgress();
        }, 200);
    }

    /*
    |--------------------------------------------------------------------------
    | Initial Calculation
    |--------------------------------------------------------------------------
    |
    | Important for EDIT page.
    | Existing database values are already present.
    |--------------------------------------------------------------------------
    */

    updateTreatmentProgress();
});

/*
|--------------------------------------------------------------------------
| Treatment Water Animation
|--------------------------------------------------------------------------
*/

function injectTreatmentWaterCSS() {
    if (document.getElementById("treatment-progress-style")) {
        return;
    }

    const style = document.createElement("style");

    style.id = "treatment-progress-style";

    style.innerHTML = `
        /*
        |--------------------------------------------------------------------------
        | Treatment Step
        |--------------------------------------------------------------------------
        */

        .patient-progress-card
        .progress-item[data-target="part_5_treatment"]
        .step {
            position: relative;
            overflow: hidden;
        }


        /*
        |--------------------------------------------------------------------------
        | Water Fill
        |--------------------------------------------------------------------------
        */

        .patient-progress-card
        .progress-item[data-target="part_5_treatment"]
        .step::before {
            content: "";

            position: absolute;

            left: 0;
            right: 0;
            bottom: 0;

            height: var(--fill, 0%);

            background: linear-gradient(
                180deg,
                #14b8a6,
                #0f766e
            );

            transition: height 0.4s ease;

            z-index: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | Moving Water Surface
        |--------------------------------------------------------------------------
        */

        .patient-progress-card
        .progress-item[data-target="part_5_treatment"]
        .step::after {
            content: "";

            position: absolute;

            left: -50%;

            width: 200%;
            height: 14px;

            bottom: calc(
                var(--fill, 0%) - 7px
            );

            background: rgba(
                255,
                255,
                255,
                0.35
            );

            border-radius: 50%;

            animation:
                treatmentWave
                2.5s linear infinite;

            z-index: 1;
        }


        /*
        |--------------------------------------------------------------------------
        | Icon
        |--------------------------------------------------------------------------
        */

        .patient-progress-card
        .progress-item[data-target="part_5_treatment"]
        .step i {
            position: relative;

            z-index: 2;
        }


        /*
        |--------------------------------------------------------------------------
        | Animation
        |--------------------------------------------------------------------------
        */

        @keyframes treatmentWave {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(50%);
            }
        }
    `;

    document.head.appendChild(style);
}
