doctorItems.forEach((item) => {
    const index = Number(item.dataset.index);

    item.addEventListener("mouseenter", () => {
        updateDoctor(index, false);
    });

    item.addEventListener("click", () => {
        updateDoctor(index, true);
    });
});

stripItems.forEach((item) => {
    const index = Number(item.dataset.index);

    item.addEventListener("mouseenter", () => {
        updateDoctor(index, false);
    });

    item.addEventListener("mouseleave", () => {
        updateDoctor(currentDoctor, false);
    });

    item.addEventListener("click", (e) => {
        e.preventDefault();
        updateDoctor(index, true);
    });
});

document.addEventListener("DOMContentLoaded", () => {
    updateDoctor(0);
    startAutoSlide();
});
