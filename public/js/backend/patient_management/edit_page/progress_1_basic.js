document.addEventListener("DOMContentLoaded", () => {
    const progressCard = document.querySelector(".patient-progress-card");

    if (!progressCard) return;

    const basicItem = progressCard.querySelector(".progress-item");

    if (!basicItem) return;

    const step = basicItem.querySelector(".step");

    const section = document.querySelector(".section-body");

    if (!section) return;

    injectWaterCSS();

   const fields = [
       document.querySelector('input[name="patient_name"]'),
       document.querySelector('input[name="patient_f_name"]'),
       document.querySelector('input[name="patient_m_name"]'),
       document.querySelector('input[name="age"]'),
       document.querySelector('select[name="gender"]'),
       document.querySelector('input[name="phone_1"]'),
   ].filter(Boolean);

    function getFilledPercent() {
        let total = 0;
        let filled = 0;

        fields.forEach((field) => {
            if (field.disabled) return;

            total++;

            if (field.type === "checkbox" || field.type === "radio") {
                if (field.checked) filled++;
            } else if ((field.value || "").trim() !== "") {
                filled++;
            }
        });

        if (total === 0) return 0;

        return Math.round((filled / total) * 100);
    }

    function updateProgress() {
        const percent = getFilledPercent();

        step.style.setProperty("--fill", percent + "%");

        step.setAttribute("data-progress", percent);

        if (percent >= 100) {
            basicItem.classList.add("completed");
        } else {
            basicItem.classList.remove("completed");
        }
    }

    fields.forEach((field) => {
        field.addEventListener("input", updateProgress);

        field.addEventListener("change", updateProgress);
    });

    updateProgress();
});

function injectWaterCSS() {
    if (document.getElementById("basic-progress-water-style")) return;

    const style = document.createElement("style");

    style.id = "basic-progress-water-style";

    style.innerHTML = `

.patient-progress-card .progress-item:first-child .step{

    position:relative;

    overflow:hidden;

}

.patient-progress-card .progress-item:first-child .step::before{

    content:"";

    position:absolute;

    left:0;

    right:0;

    bottom:0;

    height:var(--fill,0%);

    background:linear-gradient(180deg,#45b7ff,#007bff);

    transition:height .45s ease;

    z-index:0;

}

.patient-progress-card .progress-item:first-child .step::after{

    content:"";

    position:absolute;

    left:-50%;

    width:200%;

    height:14px;

    bottom:calc(var(--fill,0%) - 7px);

    background:rgba(255,255,255,.35);

    border-radius:50%;

    animation:basicWave 2.5s linear infinite;

    z-index:1;

}

.patient-progress-card .progress-item:first-child .step i{

    position:relative;

    z-index:2;

}

@keyframes basicWave{

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
