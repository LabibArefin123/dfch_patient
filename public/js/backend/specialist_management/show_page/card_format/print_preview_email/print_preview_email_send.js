(function (window, $) {
    "use strict";

    const Email = (window.specialistCardEmail =
        window.specialistCardEmail || {});

    Email.downloadCanvas = function (canvas, theme) {
        const link = document.createElement("a");

        link.download = "specialist-card-theme-" + theme + ".png";

        link.href = canvas.toDataURL("image/png");

        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);
    };

    Email.openEmailClient = function (email, theme) {
        const subject = "Specialist ID Card - Theme " + theme;

        const body =
            "Hello,%0D%0A%0D%0A" +
            "Please find the Specialist ID Card attached.%0D%0A" +
            "Card Theme: " +
            theme +
            "%0D%0A%0D%0A" +
            "Please attach the downloaded " +
            "specialist-card-theme-" +
            theme +
            ".png image to this email.%0D%0A%0D%0A" +
            "Thank you.";

        const mailto =
            "mailto:" +
            encodeURIComponent(email) +
            "?subject=" +
            encodeURIComponent(subject) +
            "&body=" +
            body;

        window.location.href = mailto;
    };
})(window, jQuery);
