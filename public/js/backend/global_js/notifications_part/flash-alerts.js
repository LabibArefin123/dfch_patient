document.addEventListener("DOMContentLoaded", function () {
    const config = window.Laravel || {};

    if (config.sessions) {
        // ==========================================
        // Auth Flow Notifications
        // ==========================================
        if (config.sessions.loginSuccess) {
            setTimeout(() => {
                Swal.fire({
                    icon: "success",
                    title: "Welcome back!",
                    text: config.sessions.loginSuccess,
                    timer: 2500,
                    showConfirmButton: false,
                });
            }, 300);
        }

        if (config.sessions.logoutSuccess) {
            setTimeout(() => {
                Swal.fire({
                    icon: "info",
                    title: "Logged Out",
                    text: config.sessions.logoutSuccess,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK",
                });
            }, 300);
        }

        if (config.sessions.loginError) {
            setTimeout(() => {
                Swal.fire({
                    icon: "error",
                    title: "Login Failed",
                    text: config.sessions.loginError,
                    confirmButtonColor: "#d33",
                });
            }, 300);
        }

        // ==========================================
        // Standard Action Notifications
        // ==========================================
        if (config.sessions.success) {
            Swal.fire({
                icon: "success",
                title: "Success",
                text: config.sessions.success,
                timer: 2000,
                showConfirmButton: false,
            });
        }

        if (config.sessions.error) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: config.sessions.error,
                timer: 2500,
                showConfirmButton: false,
            });
        }

        if (config.sessions.warning) {
            Swal.fire({
                icon: "warning",
                title: "Warning",
                text: config.sessions.warning,
                timer: 2500,
                showConfirmButton: false,
            });
        }

        if (config.sessions.info) {
            Swal.fire({
                icon: "info",
                title: "Info",
                text: config.sessions.info,
                timer: 2500,
                showConfirmButton: false,
            });
        }
    }
});
