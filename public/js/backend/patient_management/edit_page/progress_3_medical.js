document.addEventListener("DOMContentLoaded", () => {
    const progressCard = document.querySelector(".patient-progress-card");
    if (!progressCard) return;

    const progressItems = progressCard.querySelectorAll(".progress-item");
    if (progressItems.length < 3) return;

    const medicalItem = progressItems[2];
    const step = medicalItem.querySelector(".step");

    injectMedicalWaterCSS();
    const problemField = document.querySelector(
        "#edit_patient_problem_description",
    );
    const drugField = document.querySelector("#edit_patient_drug_description");
    const remarksField = document.querySelector("textarea[name='remarks']");

    function getEditorValue(textarea) {
        if (!textarea) return "";

        if (textarea.ckeditorInstance) {
            return textarea.ckeditorInstance
                .getData()
                .replace(/<[^>]*>/g, "")
                .replace(/&nbsp;/g, "")
                .trim();
        }

        return $.trim(textarea.value);
    }

    function updateMedicalProgress() {
        let percent = 0;

        if (getEditorValue(problemField) !== "") {
            percent += 30;
        }

        if (getEditorValue(drugField) !== "") {
            percent += 30;
        }

        if (remarksField && remarksField.value.trim() !== "") {
            percent += 40;
        }

        step.style.setProperty("--fill", percent + "%");

        medicalItem.classList.toggle("completed", percent === 100);
    }

    // Normal textarea
    if (remarksField) {
        remarksField.addEventListener("input", updateMedicalProgress);
        remarksField.addEventListener("change", updateMedicalProgress);
    }

    // Wait until CKEditor finishes creating
    const waitEditors = setInterval(() => {
        let ready = true;

        [problemField, drugField].forEach((textarea) => {
            if (!textarea) return;

            if (!textarea.ckeditorInstance) {
                ready = false;
            }
        });

        if (!ready) return;

        clearInterval(waitEditors);

        problemField.ckeditorInstance.model.document.on(
            "change:data",
            updateMedicalProgress,
        );

        drugField.ckeditorInstance.model.document.on(
            "change:data",
            updateMedicalProgress,
        );

        updateMedicalProgress();
    }, 200);
});

function injectMedicalWaterCSS() {
    if (document.getElementById("medical-progress-style")) return;

    const style = document.createElement("style");

    style.id = "medical-progress-style";

    style.innerHTML = `
.patient-progress-card .progress-item:nth-child(5) .step{
    position:relative;
    overflow:hidden;
}

.patient-progress-card .progress-item:nth-child(5) .step::before{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    height:var(--fill,0%);
    background:linear-gradient(180deg,#10b981,#059669);
    transition:height .4s ease;
    z-index:0;
}

.patient-progress-card .progress-item:nth-child(5) .step::after{
    content:"";
    position:absolute;
    left:-50%;
    width:200%;
    height:14px;
    bottom:calc(var(--fill,0%) - 7px);
    background:rgba(255,255,255,.35);
    border-radius:50%;
    animation:medicalWave 2.5s linear infinite;
    z-index:1;
}

.patient-progress-card .progress-item:nth-child(5) .step i{
    position:relative;
    z-index:2;
}

@keyframes medicalWave{
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
