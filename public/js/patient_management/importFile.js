$(document).on("click", ".import-excel, .import-word", function (e) {
    e.preventDefault();
    let route = $(this).attr("href");
    let title = $(this).hasClass("import-excel")
        ? "Import Excel"
        : "Import Word";
    let color = $(this).hasClass("import-excel") ? "#007bff" : "#6f42c1";

    $("#importFileForm").attr("action", route);
    $("#importModalTitle").text(title);
    $("#importProgressCircle").css("stroke", color);
    $("#importProgressPercent").text("0%");
    $("#importProgressCircle").css("stroke-dashoffset", 327);
    $("#importFileModal").modal("show");
});

$(document)
    .off("submit", "#importFileForm")
    .on("submit", "#importFileForm", function (e) {
        e.preventDefault();
        const form = $(this);
        const formData = new FormData(this);
        const url = form.attr("action");

        const circle = $("#importProgressCircle")[0];
        const text = $("#importProgressText");
        const percentText = $("#importProgressPercent");
        const radius = 52;
        const circumference = 2 * Math.PI * radius;

        circle.style.strokeDasharray = circumference;
        circle.style.strokeDashoffset = circumference;

        $("#importFileModal input, #importFileModal button").prop(
            "disabled",
            true,
        );

        const updateProgress = (p, msg) => {
            circle.style.strokeDashoffset =
                circumference - (p / 100) * circumference;
            percentText.text(p + "%");
            text.text(msg);
        };

        // Animate stages sequentially
        const stages = [
            [10, "Stage 1/4: File is Processing..."],
            [30, "Stage 2/4: File is Validating..."],
            [60, "Stage 3/4: Uploading to Server..."],
        ];

        let delay = 0;
        stages.forEach(([p, msg]) => {
            setTimeout(() => updateProgress(p, msg), delay);
            delay += 600;
        });

        setTimeout(() => {
            $.ajax({
                url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),
                },
                success: (res) => {
                    updateProgress(100, "Stage 4/4: Import Completed ✅");
                    setTimeout(() => {
                        text.text(
                            "✔ Patients Imported Successfully into Database",
                        );
                        setTimeout(() => {
                            $("#importFileModal").modal("hide");
                            location.reload();
                        }, 1200);
                    }, 600);
                },
                error: (err) => {
                    let message = "Upload failed ❌";
                    if (err.responseJSON?.errors) {
                        message = Object.values(err.responseJSON.errors)
                            .flat()
                            .join("\n");
                    } else if (err.responseJSON?.message) {
                        message = err.responseJSON.message;
                    }
                    alert(message);
                    $("#importFileModal input, #importFileModal button").prop(
                        "disabled",
                        false,
                    );
                    updateProgress(0, "Upload failed ❌");
                },
            });
        }, delay);
    });
