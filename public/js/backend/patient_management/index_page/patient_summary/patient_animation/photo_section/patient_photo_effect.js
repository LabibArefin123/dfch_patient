(function () {
    function typing(message, speed = 25) {
        return new Promise((resolve) => {
            const target = $(".patient-ai-status");

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
            const target = $(".patient-ai-status");

            let dots = 0;

            const interval = setInterval(() => {
                dots++;

                target.text("Analyzing Patient Profile" + ".".repeat(dots % 4));
            }, 400);

            setTimeout(() => {
                clearInterval(interval);

                resolve();
            }, seconds * 1000);
        });
    }

    window.PatientPhotoAnimate.typing = typing;
    window.PatientPhotoAnimate.thinking = thinking;
})();
