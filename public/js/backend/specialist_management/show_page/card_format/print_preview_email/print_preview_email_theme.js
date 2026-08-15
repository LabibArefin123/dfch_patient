(function (window, $) {
    "use strict";

    const Email = (window.specialistCardEmail =
        window.specialistCardEmail || {});

    Email.getSelectedTheme = function () {
        return $("#card_theme").val() || "1";
    };

    Email.getThemeContainer = function (theme) {
        const containers = {
            1: ".card-preview-container",
            2: ".card-preview-container2",
            3: ".card-preview-container3",
        };

        let $container = $(containers[theme]).first();

        if (!$container.length) {
            $container = $(
                ".card-preview-container," +
                    ".card-preview-container2," +
                    ".card-preview-container3",
            )
                .filter(":visible")
                .first();
        }

        return $container;
    };

    Email.getThemeCards = function (theme) {
        const $container = Email.getThemeContainer(theme);

        if (!$container.length) {
            return {
                front: null,
                back: null,
            };
        }

        let $front = null;
        let $back = null;

        if (theme === "1") {
            $front = $container.find(".doctor-card").first();
            $back = $container.find(".doctor-card-back").first();
        }

        if (theme === "2") {
            $front = $container.find(".wide-card").first();
            $back = $container.find(".wide-card-back").first();
        }

        if (theme === "3") {
            $front = $container.find(".doctor-card-3").first();
            $back = $container.find(".doctor-card-back-3").first();
        }

        if (!$front || !$front.length) {
            $front = $container
                .find(".doctor-card,.wide-card,.doctor-card-3")
                .first();
        }

        if (!$back || !$back.length) {
            $back = $container
                .find(
                    ".doctor-card-back," +
                        ".wide-card-back," +
                        ".doctor-card-back-3",
                )
                .first();
        }

        return {
            front: $front && $front.length ? $front : null,
            back: $back && $back.length ? $back : null,
        };
    };
})(window, jQuery);
