$(document).ready(function () {
    let lastChecked = null;

    // =========================
    // SHIFT SELECT
    // =========================
    $(document).on("click", ".row-checkbox", function (e) {
        if (!lastChecked) {
            lastChecked = this;
        } else if (e.shiftKey) {
            let checkboxes = $(".row-checkbox");
            let start = checkboxes.index(this);
            let end = checkboxes.index(lastChecked);

            checkboxes
                .slice(Math.min(start, end), Math.max(start, end) + 1)
                .prop("checked", lastChecked.checked);
        }

        lastChecked = this;

        updateSelectAll();
        toggleActionButtons();
    });

    // =========================
    // SELECT ALL
    // =========================
    $(document).on("click", "#select-all", function () {
        const checked = $(this).prop("checked");
        $(".row-checkbox").prop("checked", checked);

        toggleActionButtons();
    });

    function updateSelectAll() {
        const total = $(".row-checkbox").length;
        const checked = $(".row-checkbox:checked").length;
        $("#select-all").prop("checked", total === checked);
    }

    // =========================
    // SHOW / HIDE DELETE BUTTON
    // =========================
    function toggleActionButtons() {
        const checkedCount = $(".row-checkbox:checked").length;

        if (checkedCount > 0) {
            $("#delete-selected").removeClass("d-none");
            $(".export-excel").removeClass("d-none");
            $(".export-pdf").removeClass("d-none");
        } else {
            $("#delete-selected").addClass("d-none");
            $(".export-excel").addClass("d-none");
            $(".export-pdf").addClass("d-none");
        }
    }

    // Also handle DataTable redraw
    $("#patientsTable").on("draw.dt", function () {
        toggleActionButtons();
    });

    // =========================
    // OPEN MODAL
    // =========================
    $("#delete-selected").on("click", function () {
        const ids = getSelectedIds();

        if (ids.length === 0) return;

        $("#selectedCount").text(ids.length);
        $("#selectPatientsModal").modal("show");
    });

    // =========================
    // CONFIRM DELETE
    // =========================
    $("#confirmDeleteSelected").on("click", function () {
        const ids = getSelectedIds();
        if (ids.length === 0) return;

        $("#selectPatientsModal").modal("hide");
        $("#fileProcessModal").modal("show");

        $("#processTitle").text("Deleting Patients...");
        $("#processText").text(
            "Please wait while we delete selected patients.",
        );

        animateProgress();

        $.ajax({
            url: "/patients/delete-selected",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                ids: ids,
            },
            success: function () {
                setTimeout(function () {
                    $("#fileProcessModal").modal("hide");
                    $("#patientsTable").DataTable().ajax.reload(null, false);
                }, 800);
            },
            error: function () {
                alert("Something went wrong.");
                $("#fileProcessModal").modal("hide");
            },
        });
    });

    function getSelectedIds() {
        return $(".row-checkbox:checked")
            .map(function () {
                return $(this).val();
            })
            .get();
    }

    // =========================
    // SMOOTH PROGRESS ANIMATION
    // =========================
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
