/**
|--------------------------------------------------------------------------
| Patient Cancer Effects
|--------------------------------------------------------------------------
| Responsible for:
| - Typing Animation
| - Thinking Animation
|--------------------------------------------------------------------------
*/

(function () {
    /**
     * Typing Animation
     */
    function typing(message, speed = 25) {
        return new Promise((resolve) => {
            const target = $(".patient-cancer-status");

            target.text("");

            let i = 0;

            const interval = setInterval(() => {
                target.text(message.substring(0, i + 1));

                i++;

                if (i >= message.length) {
                    clearInterval(interval);

                    resolve();
                }
            }, speed);
        });
    }

    /**
     * Thinking Animation
     */
    function thinking(seconds = 2) {
        return new Promise((resolve) => {
            const target = $(".patient-cancer-status");

            let dots = 0;

            const interval = setInterval(() => {
                dots++;

                target.text("Analyzing Cancer Reports" + ".".repeat(dots % 4));
            }, 400);

            setTimeout(() => {
                clearInterval(interval);

                resolve();
            }, seconds * 1000);
        });
    }

    window.PatientCancerAnimate.typing = typing;
    window.PatientCancerAnimate.thinking = thinking;
})();
