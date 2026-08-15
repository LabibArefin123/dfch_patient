(function (window, $) {
    "use strict";

    window.patientCardPrint = window.patientCardPrint || {};

    const Print = window.patientCardPrint;

    /*
    |--------------------------------------------------------------------------
    | GET FRONT CARD
    |--------------------------------------------------------------------------
    */

    Print.getFront = function () {
        const container = Print.getThemeContainer();

        if (!container.length) {
            console.error("Card theme container not found.");
            return $();
        }

        const selectors = [".doctor-card", ".doctor-card-3", ".wide-card"];

        for (const selector of selectors) {
            const card = container.find(selector).first();

            if (
                card.length &&
                !card.hasClass("doctor-card-back") &&
                !card.hasClass("doctor-card-back-3") &&
                !card.hasClass("wide-card-back")
            ) {
                return card;
            }
        }

        return container
            .find(".doctor-card, .doctor-card-3, .wide-card")
            .filter(function () {
                return (
                    !$(this).hasClass("doctor-card-back") &&
                    !$(this).hasClass("doctor-card-back-3") &&
                    !$(this).hasClass("wide-card-back")
                );
            })
            .first();
    };

    /*
    |--------------------------------------------------------------------------
    | GET BACK CARD
    |--------------------------------------------------------------------------
    */

    Print.getBack = function () {
        const container = Print.getThemeContainer();

        if (!container.length) {
            console.error("Card theme container not found.");
            return $();
        }

        const selectors = [
            ".doctor-card-back",
            ".doctor-card-back-3",
            ".wide-card-back",
        ];

        for (const selector of selectors) {
            const card = container.find(selector).first();

            if (card.length) {
                return card;
            }
        }

        return $();
    };

    /*
    |--------------------------------------------------------------------------
    | GET CARD TYPE
    |--------------------------------------------------------------------------
    */

    Print.getCardType = function () {
        const front = Print.getFront();

        if (!front.length) {
            return "vertical";
        }

        if (front.hasClass("wide-card")) {
            return "wide";
        }

        return "vertical";
    };

    /*
    |--------------------------------------------------------------------------
    | GET COPIES
    |--------------------------------------------------------------------------
    */

    Print.getCopies = function () {
        const value = parseInt($("#cardPrintCopies").val(), 10);

        return Math.max(1, value || 1);
    };

    /*
    |--------------------------------------------------------------------------
    | CLEAN CARD
    |--------------------------------------------------------------------------
    */

    Print.clean = function (element) {
        if (!element || !element.length) {
            return $();
        }

        const clone = element.clone(false);

        clone.removeAttr("id");

        clone
            .find(
                [
                    ".print-card-actions",
                    ".whole-card-action-buttons",
                    ".lanyard-action-buttons",
                    ".whole-lanyard-action-buttons",
                ].join(","),
            )
            .remove();

        return clone;
    };
})(window, jQuery);
