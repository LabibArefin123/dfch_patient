const address = "726/A Satmasjid Road, Dhaka 1209, Bangladesh";

document.addEventListener("DOMContentLoaded", function () {
    const openBtn = document.getElementById("openMapModal");
    const modal = document.getElementById("mapModal");
    const closeBtn = document.querySelector(".close-modal");

    if (openBtn && modal) {
        openBtn.addEventListener("click", function (e) {
            e.preventDefault();
            modal.style.display = "flex";
        });
    }

    if (closeBtn && modal) {
        closeBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });
    }

    if (modal) {
        modal.addEventListener("click", function (e) {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });
    }
});

// ✅ MUST be global for onclick buttons
function openMap(app) {
    const encoded = encodeURIComponent(address);

    const links = {
        google: `https://www.google.com/maps/search/?api=1&query=${encoded}`,
        pathao: `pathao://maps?destination=${encoded}`,
        uber: `uber://?action=setPickup&dropoff[formatted_address]=${encoded}`,
    };

    const fallbackUrl = links.google;
    const targetUrl = links[app] || fallbackUrl;

    let fallbackTriggered = false;

    const fallbackTimer = setTimeout(() => {
        fallbackTriggered = true;
        window.open(fallbackUrl, "_blank");
    }, 800);

    window.location.href = targetUrl;

    window.addEventListener(
        "blur",
        () => {
            if (!fallbackTriggered) {
                clearTimeout(fallbackTimer);
            }
        },
        {
            once: true,
        },
    );
}
