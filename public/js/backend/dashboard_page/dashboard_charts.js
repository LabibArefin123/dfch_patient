/**
 * Dashboard Charts
 *
 * Handles:
 * - Normal View Patient Chart
 * - Normal View Recommended Chart
 * - Extended View Patient Chart
 * - Extended View Recommended Chart
 */

window.DashboardCharts = (() => {
    function createPatientChart(elementId, data) {
        const canvas = document.getElementById(elementId);

        if (!canvas) {
            return;
        }

        new Chart(canvas.getContext("2d"), {
            type: "doughnut",

            data: {
                labels: ["Today", "This Week", "This Month"],

                datasets: [
                    {
                        data: data,

                        backgroundColor: ["#17a2b8", "#007bff", "#6c757d"],
                    },
                ],
            },

            options: {
                responsive: true,

                plugins: {
                    legend: {
                        position: "bottom",
                    },
                },
            },
        });
    }

    function createRecommendedChart(elementId, data) {
        const canvas = document.getElementById(elementId);

        if (!canvas) {
            return;
        }

        new Chart(canvas.getContext("2d"), {
            type: "bar",

            data: {
                labels: ["Today", "This Month"],

                datasets: [
                    {
                        label: "Recommended Patients",

                        data: data,

                        backgroundColor: ["#ffc107", "#28a745"],
                    },
                ],
            },

            options: {
                responsive: true,

                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },

                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });
    }

    function init(data) {
        // Normal View
        createPatientChart("patientsPieChart", [
            data.todayPatients,
            data.weeklyPatients,
            data.monthlyPatients,
        ]);

        createRecommendedChart("recommendedBarChart", [
            data.todayRecommendedPatients,
            data.monthlyRecommendedPatients,
        ]);

        // Extended View
        createPatientChart("patientsPieChartExt", [
            data.todayPatients,
            data.weeklyPatients,
            data.monthlyPatients,
        ]);

        createRecommendedChart("recommendedBarChartExt", [
            data.todayRecommendedPatients,
            data.monthlyRecommendedPatients,
        ]);
    }

    return {
        init,
    };
})();
