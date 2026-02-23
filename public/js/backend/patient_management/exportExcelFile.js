$(document).ready(function () {
    function getSelectedIds() {
        return $(".row-checkbox:checked")
            .map(function () {
                return $(this).val();
            })
            .get();
    }

    $(".export-excel").on("click", function (e) {
        e.preventDefault();

        const ids = getSelectedIds();
        if (ids.length === 0) {
            alert("Please select at least one patient to export.");
            return;
        }

        $("#fileProcessModal").modal("show");
        $("#processTitle").text("Exporting Excel...");
        $("#processText").text("Please wait while we generate Excel file.");
        animateProgress();

        const token = $('meta[name="csrf-token"]').attr("content");
        const url = $(this).attr("href");

        $.ajax({
            url: url,
            type: "POST",
            data: { _token: token, ids: ids },
            xhrFields: {
                responseType: "blob", // important for downloading files
            },
            success: function (data, status, xhr) {
                const blob = new Blob([data], {
                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                });
                const link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                const filename = xhr
                    .getResponseHeader("Content-Disposition")
                    .split("filename=")[1]
                    .replace(/"/g, "");
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                setTimeout(() => $("#fileProcessModal").modal("hide"), 500);
            },
            error: function () {
                alert("Something went wrong while exporting Excel.");
                $("#fileProcessModal").modal("hide");
            },
        });
    });

    function animateProgress() {
        const circle = document.getElementById("progressCircle");
        const percentText = document.getElementById("progressPercent");
        const radius = 65;
        const circumference = 2 * Math.PI * radius;

        let percent = 0;
        let interval = setInterval(function () {
            percent += 5;
            const offset = circumference - (percent / 100) * circumference;
            circle.style.strokeDashoffset = offset;
            percentText.innerText = percent + "%";
            if (percent >= 100) clearInterval(interval);
        }, 40);
    }
});
