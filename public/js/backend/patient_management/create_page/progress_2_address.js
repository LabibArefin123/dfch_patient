document.addEventListener("DOMContentLoaded", () => {
    const progressCard = document.querySelector(".patient-progress-card");
    if (!progressCard) return;

    const progressItems = progressCard.querySelectorAll(".progress-item");
    if (progressItems.length < 2) return;

    const addressItem = progressItems[1];
    const step = addressItem.querySelector(".step");

    injectAddressWaterCSS();

    const sectionCards = document.querySelectorAll(".patient-section-card");
    if (sectionCards.length < 2) return;

    const addressSection = sectionCards[1];

    const fields = Array.from(
        addressSection.querySelectorAll(
            'input:not([type="hidden"]):not([type="file"]), select, textarea',
        ),
    ).filter((field) => !field.disabled);

    function isFilled(field) {
        if (field.type === "checkbox" || field.type === "radio") {
            return field.checked;
        }

        return field.value.trim() !== "";
    }

    function updateAddressProgress() {
        let filled = 0;

        fields.forEach((field) => {
            if (isFilled(field)) {
                filled++;
            }
        });

        const percent = Math.round((filled / fields.length) * 100);

        step.style.setProperty("--fill", percent + "%");

        if (percent >= 100) {
            addressItem.classList.add("completed");
        } else {
            addressItem.classList.remove("completed");
        }
    }

    fields.forEach((field) => {
        field.addEventListener("input", updateAddressProgress);
        field.addEventListener("change", updateAddressProgress);
    });

    updateAddressProgress();
});

function injectAddressWaterCSS() {
    if (document.getElementById("address-progress-style")) return;

    const style = document.createElement("style");

    style.id = "address-progress-style";

    style.innerHTML = `

.patient-progress-card .progress-item:nth-child(3) .step{
    position:relative;
    overflow:hidden;
}

.patient-progress-card .progress-item:nth-child(3) .step::before{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    height:var(--fill,0%);
    background:linear-gradient(180deg,#42c5ff,#0b8fff);
    transition:height .4s ease;
    z-index:0;
}

.patient-progress-card .progress-item:nth-child(3) .step::after{
    content:"";
    position:absolute;
    left:-50%;
    width:200%;
    height:14px;
    bottom:calc(var(--fill,0%) - 7px);
    background:rgba(255,255,255,.35);
    border-radius:50%;
    animation:addressWave 2.5s linear infinite;
    z-index:1;
}

.patient-progress-card .progress-item:nth-child(3) .step i{
    position:relative;
    z-index:2;
}

@keyframes addressWave{
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
