/**
 * Dashboard View Toggle
 *
 * Handles:
 * - Normal View
 * - Extended View
 */

window.DashboardViewToggle = (() => {
    function init() {
        const toggleBtn = document.getElementById("toggleViewBtn");
        const tabs = document.getElementById("dashboardTabs");
        const extended = document.getElementById("extendedView");

        if (!toggleBtn || !tabs || !extended) {
            return;
        }

        let isNormalView = true;

        // Initial state
        tabs.style.display = "block";
        extended.style.display = "none";

        toggleBtn.addEventListener("click", function () {
            isNormalView = !isNormalView;

            if (isNormalView) {
                tabs.style.display = "block";
                extended.style.display = "none";

                toggleBtn.textContent = "Extended View";

                toggleBtn.classList.remove("btn-success");
                toggleBtn.classList.add("btn-primary");
            } else {
                tabs.style.display = "none";
                extended.style.display = "block";

                toggleBtn.textContent = "Normal View";

                toggleBtn.classList.remove("btn-primary");
                toggleBtn.classList.add("btn-success");
            }
        });
    }

    return {
        init,
    };
})();
