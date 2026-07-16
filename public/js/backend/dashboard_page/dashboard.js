/**
 * Main Dashboard JavaScript
 */

document.addEventListener("DOMContentLoaded", function () {
    /*
    |--------------------------------------------------------------------------
    | Dashboard View Toggle
    |--------------------------------------------------------------------------
    */

    if (window.DashboardViewToggle) {
        DashboardViewToggle.init();
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Charts
    |--------------------------------------------------------------------------
    */

    if (window.DashboardCharts) {
        DashboardCharts.init({
            todayPatients: window.dashboardData.todayPatients,

            weeklyPatients: window.dashboardData.weeklyPatients,

            monthlyPatients: window.dashboardData.monthlyPatients,

            todayRecommendedPatients:
                window.dashboardData.todayRecommendedPatients,

            monthlyRecommendedPatients:
                window.dashboardData.monthlyRecommendedPatients,
        });
    }
});
