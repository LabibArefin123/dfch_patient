(function (window, $) {
    "use strict";

    window.patientCardPrint = window.patientCardPrint || {};

    const Print = window.patientCardPrint;

    Print.mode = null;

    Print.themeContainers = [
        ".card-preview-container",
        ".card-preview-container2",
        ".card-preview-container3",
    ];
})(window, jQuery);
