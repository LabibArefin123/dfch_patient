document.addEventListener("DOMContentLoaded", function () {
    const welcomeUrl = window.appConfig?.welcomeUrl;

    if (!welcomeUrl) return;

    document.querySelectorAll('a.nav-link[href^="#"]').forEach((link) => {
        link.addEventListener("click", function (e) {
            const targetId = this.getAttribute("href");

            if (window.location.pathname !== new URL(welcomeUrl).pathname) {
                e.preventDefault();
                window.location.href = welcomeUrl + targetId;
            }
        });
    });
});
