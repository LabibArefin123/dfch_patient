document.addEventListener("DOMContentLoaded", function () {
    let pendingAction = null;

    // Trigger confirmation modal for forms designated for Create
    document.querySelectorAll('form[data-confirm="create"]').forEach((form) => {
        form.addEventListener("submit", function (e) {
            if (!form.dataset.confirmed) {
                e.preventDefault();
                pendingAction = form;
                $("#createConfirmModal").modal("show");
            }
        });
    });

    // Trigger confirmation modal for forms designated for Edit
    document.querySelectorAll('form[data-confirm="edit"]').forEach((form) => {
        form.addEventListener("submit", function (e) {
            if (!form.dataset.confirmed) {
                e.preventDefault();
                pendingAction = form;
                $("#editConfirmModal").modal("show");
            }
        });
    });

    // Handle submit when confirmation action button is clicked inside Bootstrap Modals
    document
        .querySelectorAll(
            "#createConfirmModal .btn-success, #editConfirmModal .btn-info",
        )
        .forEach((button) => {
            button.addEventListener("click", function () {
                if (pendingAction) {
                    pendingAction.dataset.confirmed = true;
                    pendingAction.submit();
                    pendingAction = null;
                }
            });
        });
});
