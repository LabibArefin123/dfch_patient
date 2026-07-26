/**
 * ==========================================================================
 * Progress 6 - Cancer
 * ==========================================================================
 * File:
 * progress_6_cancer.js
 *
 * Responsibilities
 * ----------------
 * ✔ Cancer Progress
 * ✔ Water Fill Animation
 * ✔ CKEditor Support
 * ==========================================================================
 */

document.addEventListener("DOMContentLoaded", () => {
    const progressCard = document.querySelector(".patient-progress-card");
    if (!progressCard) return;

    const progressItems = progressCard.querySelectorAll(".progress-item");

    // Cancer is the 7th progress item
    if (progressItems.length < 7) return;

    const cancerItem = progressItems[6];
    const step = cancerItem.querySelector(".step");

    injectCancerWaterCSS();

    const statusField = document.getElementById("is_old_cancer");
    const totalField = document.getElementById("total_cancer");
    const imageField = document.querySelector("input[name='xray_photo[]']");
    const remarksField = document.querySelector("textarea[name='remarks']");

    function getEditorValue(textarea) {
        if (!textarea) return "";

        if (textarea.ckeditorInstance) {
            return textarea.ckeditorInstance
                .getData()
                .replace(/<[^>]*>/g, "")
                .trim();
        }

        if (window.CKEDITOR && textarea.name) {
            const instance = Object.values(CKEDITOR.instances).find(
                function (editor) {
                    return editor.element.$.name === textarea.name;
                },
            );

            if (instance) {
                return instance
                    .getData()
                    .replace(/<[^>]*>/g, "")
                    .trim();
            }
        }

        return textarea.value.trim();
    }

    function updateCancerProgress() {
        let percent = 0;

        if (!statusField || statusField.value !== "1") {
            step.style.setProperty("--fill", "0%");
            cancerItem.classList.remove("completed");

            return;
        }

        // Total Reports = 25%
        if (totalField && parseInt(totalField.value) > 0) {
            percent += 25;
        }

        // Images = 35%
        if (imageField && imageField.files.length > 0) {
            percent += 35;
        }

        // Diagnostic Description = 20%
        const descriptions = document.querySelectorAll(
            "textarea[name='xray_description[]']",
        );

        let filled = true;

        descriptions.forEach(function (textarea) {
            if (textarea.value.trim() === "") {
                filled = false;
            }
        });

        if (descriptions.length > 0 && filled) {
            percent += 20;
        }

        // Doctor Remarks = 20%
        if (getEditorValue(remarksField) !== "") {
            percent += 20;
        }

        step.style.setProperty("--fill", percent + "%");

        cancerItem.classList.toggle("completed", percent === 100);
    }

    [statusField, totalField, imageField]
        .filter(Boolean)
        .forEach(function (field) {
            field.addEventListener("change", updateCancerProgress);
            field.addEventListener("input", updateCancerProgress);
        });

    document.addEventListener("input", function (e) {
        if (e.target.matches("textarea[name='xray_description[]']")) {
            updateCancerProgress();
        }
    });

    const waitEditor = setInterval(function () {
        if (!remarksField) return;

        if (remarksField.ckeditorInstance) {
            clearInterval(waitEditor);

            remarksField.ckeditorInstance.model.document.on(
                "change:data",
                updateCancerProgress,
            );

            updateCancerProgress();

            return;
        }

        if (window.CKEDITOR) {
            const instance = Object.values(CKEDITOR.instances).find(
                function (editor) {
                    return editor.element.$.name === "remarks";
                },
            );

            if (instance) {
                clearInterval(waitEditor);

                instance.on("change", updateCancerProgress);

                updateCancerProgress();
            }
        }
    }, 200);

    updateCancerProgress();
});

function injectCancerWaterCSS() {
    if (document.getElementById("cancer-progress-style")) return;

    const style = document.createElement("style");

    style.id = "cancer-progress-style";

    style.innerHTML = `
.patient-progress-card .progress-item:nth-child(13) .step{
    position:relative;
    overflow:hidden;
}

.patient-progress-card .progress-item:nth-child(13) .step::before{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    height:var(--fill,0%);
    background:linear-gradient(180deg,#ef4444,#b91c1c);
    transition:height .4s ease;
    z-index:0;
}

.patient-progress-card .progress-item:nth-child(13) .step::after{
    content:"";
    position:absolute;
    left:-50%;
    width:200%;
    height:14px;
    bottom:calc(var(--fill,0%) - 7px);
    background:rgba(255,255,255,.35);
    border-radius:50%;
    animation:cancerWave 2.5s linear infinite;
    z-index:1;
}

.patient-progress-card .progress-item:nth-child(13) .step i{
    position:relative;
    z-index:2;
}

@keyframes cancerWave{
    from{
        transform:translateX(0);
    }
    to{
        transform:translateX(50%);
    }
}
`;

    document.head.appendChild(style);
}
