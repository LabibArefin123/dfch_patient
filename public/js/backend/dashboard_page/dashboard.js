/**
 * Main Dashboard JavaScript
 */

document.addEventListener("DOMContentLoaded", function () {
    /*
    |--------------------------------------------------------------------------
    | View Toggle
    |--------------------------------------------------------------------------
    */

    if (window.DashboardViewToggle) {
        DashboardViewToggle.init();
    }

    /*
    |--------------------------------------------------------------------------
    | Main Patient Charts
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

    /*
    |--------------------------------------------------------------------------
    | Emergency Dashboard
    |--------------------------------------------------------------------------
    */

    if (window.DashboardEmergency) {
        DashboardEmergency.init({
            todayEmergencyPatientHistory:
                window.dashboardData.todayEmergencyPatientHistory,

            weeklyEmergencyPatientHistory:
                window.dashboardData.weeklyEmergencyPatientHistory,

            monthlyEmergencyPatientHistory:
                window.dashboardData.monthlyEmergencyPatientHistory,
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Cancer Dashboard
    |--------------------------------------------------------------------------
    */

    if (window.DashboardCancer) {
        DashboardCancer.init({
            todayCancerPatientHistory:
                window.dashboardData.todayCancerPatientHistory,

            weeklyCancerPatientHistory:
                window.dashboardData.weeklyCancerPatientHistory,

            monthlyCancerPatientHistory:
                window.dashboardData.monthlyCancerPatientHistory,
        });
    }
});
