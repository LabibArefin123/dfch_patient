$(document).ready(function () {
    function getSelectedIds() {
        return $(".row-checkbox:checked")
            .map(function () {
                return $(this).val();
            })
            .get();
    }

    $(".export-pdf").on("click", function (e) {
        e.preventDefault();

        const ids = getSelectedIds();
        console.log("Selected patient IDs:", ids); // Debug log

        if (ids.length === 0) {
            alert("Please select at least one patient to export.");
            return;
        }

        // Show progress modal
        $("#fileProcessModal").modal("show");
        $("#processTitle").text("Exporting PDF...");
        $("#processText").text("Please wait while we generate PDF file.");
        animateProgress();

        const token = $('meta[name="csrf-token"]').attr("content");
        const url = $(this).attr("href");

        $.ajax({
            url: url,
            type: "POST",
            data: { _token: token, ids: ids },
            xhrFields: { responseType: "blob" },
            success: function (data, status, xhr) {
                const blob = new Blob([data], { type: "application/pdf" });
                const link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);

                let filename = "patients.pdf";
                const disposition = xhr.getResponseHeader(
                    "Content-Disposition",
                );
                if (disposition && disposition.indexOf("filename=") !== -1) {
                    filename = disposition
                        .split("filename=")[1]
                        .replace(/"/g, "");
                }

                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                setTimeout(() => $("#fileProcessModal").modal("hide"), 500);
            },
            error: function (xhr, status, error) {
                // Full console logging
                console.error("Export PDF failed:");
                console.error("Status:", status);
                console.error("Error:", error);
                console.error("Response Text:", xhr.responseText);

                alert(
                    "Something went wrong while exporting PDF. Check console for details.",
                );
                $("#fileProcessModal").modal("hide");
            },
        });
    });

    // Animate progress circle in modal
    function animateProgress() {
        const circle = document.getElementById("progressCircle");
        const percentText = document.getElementById("progressPercent");
        const radius = 65;
        const circumference = 2 * Math.PI * radius;

        let percent = 0;
        let interval = setInterval(function () {
            percent += 5;
            const offset = circumference - (percent / 100) * circumference;
            if (circle) circle.style.strokeDashoffset = offset;
            if (percentText) percentText.innerText = percent + "%";

            if (percent >= 100) clearInterval(interval);
        }, 40);
    }
});
