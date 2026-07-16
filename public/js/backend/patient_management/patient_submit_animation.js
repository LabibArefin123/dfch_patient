window.patientEmergencySubmit = {
    submitting: false,

    start() {
        this.submitting = true;

        const $form = $("#patientEmergencyForm");
        const $btn = $form.find("button[type=submit]");

        $btn.prop("disabled", true);

        this.progress = 0;

        $("#submitProgressModal").modal({
            backdrop: "static",
            keyboard: false,
        });

        $("#submitProgressModal").modal("show");

        $("#submitProgressText").text("Preparing request...");
        $("#submitProgressPercent").text("0%");

        this.interval = setInterval(() => {
            if (this.progress >= 95) {
                return;
            }

            this.progress++;

            $("#submitProgressBar")
                .css("width", this.progress + "%")
                .attr("aria-valuenow", this.progress);

            $("#submitProgressPercent").text(this.progress + "%");

            if (this.progress < 20) {
                $("#submitProgressText").text("Preparing...");
            } else if (this.progress < 45) {
                $("#submitProgressText").text("Validating patients...");
            } else if (this.progress < 70) {
                $("#submitProgressText").text("Updating emergency status...");
            } else {
                $("#submitProgressText").text("Saving history...");
            }
        }, 30);
    },

    finish(callback = null) {
        clearInterval(this.interval);

        this.progress = 100;

        $("#submitProgressBar").css("width", "100%");
        $("#submitProgressPercent").text("100%");
        $("#submitProgressText").text("Completed");

        setTimeout(() => {
            bootstrap.Modal.getInstance(
                document.getElementById("submitProgressModal"),
            )?.hide();

            this.submitting = false;

            $("#patientEmergencyForm button[type='submit']").prop(
                "disabled",
                false,
            );

            if (callback) {
                callback();
            }
        }, 500);
    },

    failed() {
        clearInterval(this.interval);

        $("#submitProgressModal").modal("hide");

        $("#patientEmergencyForm")
            .find("button[type=submit]")
            .prop("disabled", false);

        this.submitting = false;
    },
};
