$(function () {
    "use strict";

    const filterButton = $("#patientCancerFilterButton");
    const filterPanel = $("#patientCancerFilterPanel");
    const tableBody = $("#patientCancerTableBody");
    const loading = $("#patientCancerFilterLoading");
    const resultCount = $("#patientCancerResultCount");

    filterButton.on("click", function () {
        filterPanel.toggleClass("d-none");
        $(this).find("i").toggleClass("fa-filter fa-times");
    });

    function escapeHtml(value) {
        return $("<div>")
            .text(value ?? "")
            .html();
    }

    function escapeAttribute(value) {
        return String(value ?? "")
            .replace(/&/g, "&amp;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");
    }

    function formatPreview(value) {
        value = value || "-";

        const words = value.trim().split(/\s+/);

        if (words.length <= 10) {
            return escapeHtml(value).replace(/\n/g, "<br>");
        }

        const shortText = words.slice(0, 10).join(" ");

        return `
        <span>${escapeHtml(shortText)}</span>
        <button type="button"
            class="btn btn-link btn-sm p-0 patient-cancer-full-text-btn"
            data-text="${escapeAttribute(value)}">
            [....]
        </button>
    `;
    }

    function renderRows(rows) {
        if (!rows || !rows.length) {
            tableBody.html(`
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                    No cancer history found.
                </td>
            </tr>
        `);
            return;
        }

        let html = "";

        $.each(rows, function (index, item) {
            const description = item.description_preview || "-";
            const remarks = item.remarks_preview || "-";

            html += `
            <tr>
                <td class="text-center">
                    ${index + 1}
                </td>

                <td class="text-center">
                    <img src="${escapeAttribute(item.patient_photo)}"
                        class="rounded shadow-sm"
                        style="width:70px;height:70px;object-fit:cover;">
                </td>

                <td>
                    ${escapeHtml(item.patient_code)}
                </td>

                <td>
                    ${escapeHtml(item.patient_name)}
                </td>

                <td>
                    ${formatPreview(description)}
                </td>

                <td>
                    ${formatPreview(remarks)}
                </td>

                <td class="text-center">
                    ${escapeHtml(item.created_at)}
                </td>

                <td class="text-center">

                    <a href="${window.patientCancerRoutes.show.replace("__ID__", item.id)}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i>
                        Show
                    </a>

                    <a href="${window.patientCancerRoutes.edit.replace("__ID__", item.id)}"
                        class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>

                    <form action="${window.patientCancerRoutes.destroy.replace("__ID__", item.id)}"
                        method="POST"
                        class="d-inline"
                        onsubmit="return confirm('Are you sure you want to delete this cancer history?');">

                        <input type="hidden"
                            name="_token"
                            value="${window.patientCancerRoutes.csrf}">

                        <input type="hidden"
                            name="_method"
                            value="DELETE">

                        <button type="submit"
                            class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>

                    </form>

                </td>
            </tr>
        `;
        });

        tableBody.html(html);
    }

    function loadCancerData() {
        const search = $("#patientCancerSearch").val() || "";

        loading.removeClass("d-none");
        tableBody.css("opacity", "0.4");

        $.ajax({
            url: window.location.pathname,
            type: "GET",

            data: {
                search: search,
            },

            dataType: "json",

            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },

            success: function (response) {
                if (response.status === true) {
                    renderRows(response.data);

                    resultCount.text(
                        `Showing ${response.count} cancer history record(s)`,
                    );
                }
            },

            error: function (xhr) {
                console.error(
                    "Patient cancer filter error:",
                    xhr.status,
                    xhr.responseText,
                );

                tableBody.html(`
                <tr>
                    <td colspan="8"
                        class="text-center text-danger py-4">

                        <i class="fas fa-exclamation-triangle fa-2x mb-2 d-block"></i>

                        Unable to load cancer history.

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

    $("#patientCancerSearch").on("input", function () {
        clearTimeout(searchTimer);

        searchTimer = setTimeout(function () {
            loadCancerData();
        }, 400);
    });
});
