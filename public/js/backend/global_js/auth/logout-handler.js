document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.querySelector(
        'a[href="#"][onclick*="logout-form"]',
    );
    const logoutForm = document.getElementById("logout-form");

    if (logoutButton && logoutForm) {
        // Remove direct inline click to prevent execution conflicts
        logoutButton.removeAttribute("onclick");
        logoutButton.addEventListener("click", function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure you want to log out?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, log out",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(() => logoutForm.submit(), 200);
                }
            });
        });
    }
});
