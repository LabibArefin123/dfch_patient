(function (window, $) {
    "use strict";

    window.patientCardPrint = window.patientCardPrint || {};

    const Print = window.patientCardPrint;

    Print.getTheme = function () {
        return $("#card_theme").val() || "1";
    };

    Print.getThemeContainer = function () {
        const theme = parseInt(Print.getTheme(), 10) || 1;

        const selector =
            Print.themeContainers && Print.themeContainers[theme - 1];

        let container = selector ? $(selector).first() : $();

        if (!container.length) {
            container = $(
                ".card-preview-middle, " +
                    ".card-preview-container, " +
                    ".card-preview-container2, " +
                    ".card-preview-container3",
            )
                .filter(":visible")
                .first();
        }

        return container;
    };
})(window, jQuery);
