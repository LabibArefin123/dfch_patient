function startAutoSlide() {
    clearInterval(autoSlide);
    autoSlide = setInterval(nextDoctor, slideInterval);
}

function updateDoctor(index, resetTimer = true) {
    const doctor = doctors[index];

    const infoBox = document.getElementById("spec-info");
    const previewWrap = document.querySelector(".preview-wrap");

    infoBox.classList.add("fade-out");
    previewWrap.classList.add("fade-out");

    setTimeout(() => {
        stripItems.forEach((el, i) => {
            el.classList.toggle("active", i === index);
        });

        doctorItems.forEach((el, i) => {
            el.classList.toggle("active", i === index);
        });

        previewImg.src = doctorImageBasePath + "/" + doctor.image;

        docName.innerText = doctor.name;
        docDegree.innerText = doctor.degree;
        docDetails.innerHTML = doctor.details;

        if (doctor.route) {
            doctorLink.href = doctor.route;
            doctorLink.style.pointerEvents = "auto";
        } else {
            doctorLink.href = "javascript:void(0)";
            doctorLink.style.pointerEvents = "none";
        }

        infoBox.classList.remove("fade-out");
        previewWrap.classList.remove("fade-out");

        infoBox.classList.add("fade-in");
        previewWrap.classList.add("fade-in");
    }, 200);

    currentDoctor = index;

    if (resetTimer) {
        startAutoSlide();
    }
}

function nextDoctor() {
    updateDoctor((currentDoctor + 1) % doctors.length, false);
}
