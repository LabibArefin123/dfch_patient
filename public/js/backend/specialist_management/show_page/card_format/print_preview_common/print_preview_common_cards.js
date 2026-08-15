$(function () {
    "use strict";

    const Print = window.patientCardPrint;

    if (!Print) {
        console.error("patientCardPrint is not initialized.");
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | GET FRONT CARD
    |--------------------------------------------------------------------------
    */

    Print.getFront = function () {
        const container = Print.getThemeContainer();

        if (!container.length) {
            return $();
        }

        const selectors = [".doctor-card", ".wide-card", ".doctor-card-3"];

        for (const selector of selectors) {
            const card = container.find(selector).first();

            if (card.length) {
                return card;
            }
        }

        return container
            .find("[class*='doctor-card']," + "[class*='wide-card']")
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
            return $();
        }

        const selectors = [
            ".doctor-card-back",
            ".wide-card-back",
            ".doctor-card-back-3",
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

        if (front.hasClass("doctor-card-3")) {
            return "vertical";
        }

        return "vertical";
    };

    /*
    |--------------------------------------------------------------------------
    | GET COPIES
    |--------------------------------------------------------------------------
    */

    Print.getCopies = function () {
        return Math.max(1, parseInt($("#cardPrintCopies").val(), 10) || 1);
    };

    /*
    |--------------------------------------------------------------------------
    | CLEAN CARD CLONE
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
                ".print-card-actions," +
                    ".whole-card-action-buttons," +
                    ".lanyard-action-buttons," +
                    ".whole-lanyard-action-buttons",
            )
            .remove();

        return clone;
    };
});
