document.addEventListener("DOMContentLoaded", function () {
    const config = window.Laravel || {};
    const userRole = config.userRole;

    // Secure UI: Hide and remove delete triggers from unauthorized roles
    if (userRole && userRole !== "admin" && userRole !== "manager") {
        document
            .querySelectorAll("button.btn-danger.btn-sm")
            .forEach((button) => {
                const form = button.closest("form");
                if (form) {
                    form.remove();
                } else {
                    button.remove();
                }
            });
    }

    // Set globally so blade action calls can call it (e.g. onclick="triggerDeleteModal('url')")
    window.triggerDeleteModal = function (actionUrl) {
        if (userRole !== "admin" && userRole !== "manager") return;

        Swal.fire({
            title: "Are you sure?",
            text: "This record will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = actionUrl;

                const csrfField = document.createElement("input");
                csrfField.type = "hidden";
                csrfField.name = "_token";
                csrfField.value = config.csrfToken;

                const methodField = document.createElement("input");
                methodField.type = "hidden";
                methodField.name = "_method";
                methodField.value = "DELETE";

                form.appendChild(csrfField);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    };
});
