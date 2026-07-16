/**
 * Dashboard Emergency Charts
 */

window.DashboardEmergency = (() => {
    function createChart(elementId, data) {
        const canvas = document.getElementById(elementId);

        if (!canvas || typeof Chart === "undefined") {
            return;
        }

        new Chart(canvas.getContext("2d"), {
            type: "bar",

            data: {
                labels: ["Today", "This Week", "This Month"],

                datasets: [
                    {
                        label: "Emergency Patient History",

                        data: data,

                        backgroundColor: ["#ffc107", "#fd7e14", "#dc3545"],

                        borderRadius: 6,

                        borderWidth: 0,
                    },
                ],
            },

            options: {
                responsive: true,

                maintainAspectRatio: false,

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0,
                        },
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
        createChart("emergencyHistoryChartExt", [
            data.todayEmergencyPatientHistory,
            data.weeklyEmergencyPatientHistory,
            data.monthlyEmergencyPatientHistory,
        ]);
    }

    return {
        init,
    };
})();
