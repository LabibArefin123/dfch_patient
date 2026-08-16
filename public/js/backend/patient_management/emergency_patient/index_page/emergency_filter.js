$(function () {
    "use strict";

    const filterButton = $("#emergencyFilterButton");
    const filterPanel = $("#emergencyFilterPanel");
    const tableBody = $("#emergencyTableBody");
    const loading = $("#emergencyFilterLoading");
    const resultCount = $("#emergencyResultCount");

    filterButton.on("click", function () {
        filterPanel.toggleClass("d-none");
        $(this).find("i").toggleClass("fa-filter fa-times");
    });

    function escapeHtml(value) {
        return $("<div>")
            .text(value ?? "")
            .html();
    }

    function formatReason(reason) {
        reason = reason || "-";
        const words = reason.trim().split(/\s+/);

        if (words.length <= 10) {
            return escapeHtml(reason);
        }

        const shortReason = words.slice(0, 10).join(" ");

        return `
        <span>${escapeHtml(shortReason)}</span>
        <button type="button" class="btn btn-link btn-sm p-0 patient-full-reason-btn" data-reason="${escapeHtml(reason)}">
            [....]
        </button>
    `;
    }

    function renderRows(rows) {
        if (!rows.length) {
            tableBody.html(`
            <tr>
                <td colspan="9" class="text-center text-muted py-4">
                    <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                    No emergency history found.
                </td>
            </tr>
        `);
            return;
        }

        let html = "";

        $.each(rows, function (index, item) {
            const status = item.is_emergency
                ? '<span class="badge bg-danger">Emergency</span>'
                : '<span class="badge bg-success">Normal</span>';

            html += `
            <tr>
                <td class="text-center">${index + 1}</td>
                <td class="text-center">
                    <img src="${escapeHtml(item.patient_photo)}" class="rounded shadow-sm" style="width:70px;height:70px;object-fit:cover;">
                </td>
                <td>${escapeHtml(item.patient_code)}</td>
                <td>${escapeHtml(item.patient_name)}</td>
                <td class="text-center">${status}</td>
                <td>${formatReason(item.reason)}</td>
                <td class="text-center">${escapeHtml(item.emergency_date)}</td>
                <td class="text-center">${escapeHtml(item.created_at)}</td>
                <td class="text-center">
                    <a href="${window.patientEmergencyRoutes.show.replace("__ID__", item.id)}" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> Show
                    </a>
                    <a href="${window.patientEmergencyRoutes.edit.replace("__ID__", item.id)}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="${window.patientEmergencyRoutes.destroy.replace("__ID__", item.id)}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this emergency history?');">
                        <input type="hidden" name="_token" value="${window.patientEmergencyRoutes.csrf}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        `;
        });

        tableBody.html(html);
    }

    function loadEmergencyData() {
        const search = $("#emergencySearch").val() || "";
        const status = $("#emergencyStatus").val() || "";
        const dateFilter = $("#emergencyDateFilter").val() || "";
        const dateFrom = $("#emergencyDateFrom").val() || "";
        const dateTo = $("#emergencyDateTo").val() || "";

        loading.removeClass("d-none");
        tableBody.css("opacity", "0.4");

        $.ajax({
            url: window.location.href,
            type: "GET",
            data: {
                search: search,
                status: status,
                date_filter: dateFilter,
                date_from: dateFrom,
                date_to: dateTo,
            },
            dataType: "json",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
            success: function (response) {
                if (response.status) {
                    renderRows(response.data);
                    resultCount.text(
                        `Showing ${response.count} emergency history record(s)`,
                    );
                }
            },
            error: function (xhr) {
                console.error("Emergency filter error:", xhr.responseText);

                tableBody.html(`
                <tr>
                    <td colspan="9" class="text-center text-danger py-4">
                        <i class="fas fa-exclamation-triangle fa-2x mb-2 d-block"></i>
                        Unable to load emergency history.
                    </td>
                </tr>
            `);

                resultCount.text("Unable to load records");
            },
            complete: function () {
                loading.addClass("d-none");
                tableBody.css("opacity", "1");
            },
        });
    }

    let searchTimer;

    $("#emergencySearch").on("input", function () {
        clearTimeout(searchTimer);

        searchTimer = setTimeout(function () {
            loadEmergencyData();
        }, 400);
    });

    $("#emergencyStatus").on("change", function () {
        loadEmergencyData();
    });

    $("#emergencyDateFilter").on("change", function () {
        const value = $(this).val();

        if (value === "custom") {
            $("#emergencyCustomDate").removeClass("d-none");
            return;
        }

        $("#emergencyCustomDate").addClass("d-none");
        $("#emergencyDateFrom").val("");
        $("#emergencyDateTo").val("");

        loadEmergencyData();
    });

    $("#emergencyDateFrom,#emergencyDateTo").on("change", function () {
        if ($("#emergencyDateFilter").val() === "custom") {
            if ($("#emergencyDateFrom").val() && $("#emergencyDateTo").val()) {
                loadEmergencyData();
            }
        }
    });
});
