(function () {
    function typing(message, speed = 25) {
        return new Promise((resolve) => {
            const target = $(".patient-information-status");

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

    function thinking(seconds = 2) {
        return new Promise((resolve) => {
            const target = $(".patient-information-status");

            let dots = 0;

            const interval = setInterval(() => {
                dots++;

                target.text(
                    "Analyzing Patient Information" + ".".repeat(dots % 4),
                );
            }, 400);

            setTimeout(() => {
                clearInterval(interval);

                resolve();
            }, seconds * 1000);
        });
    }

    window.PatientInformationAnimate.typing = typing;
    window.PatientInformationAnimate.thinking = thinking;
})();
