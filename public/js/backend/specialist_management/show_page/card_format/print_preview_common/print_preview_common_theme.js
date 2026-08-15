$(function () {
    "use strict";

    const Print = window.patientCardPrint;

    if (!Print) {
        console.error("patientCardPrint is not initialized.");
        return;
    }

    Print.getTheme = function () {
        return $("#card_theme").val() || "1";
    };

    Print.getThemeContainer = function () {
        const theme = Print.getTheme();

        let container = $(
            Print.themeContainers[parseInt(theme, 10) - 1],
        ).first();

        if (!container.length) {
            container = $(
                ".card-preview-middle," +
                    ".card-preview-container," +
                    ".card-preview-container2," +
                    ".card-preview-container3",
            )
                .filter(":visible")
                .first();
        }

        return container;
    };
});
