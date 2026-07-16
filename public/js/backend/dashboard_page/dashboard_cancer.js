/**
 * Dashboard Cancer Charts
 */

window.DashboardCancer = (() => {
    function createChart(elementId, data) {
        const canvas = document.getElementById(elementId);

        if (!canvas || typeof Chart === "undefined") {
            return;
        }

        new Chart(canvas.getContext("2d"), {
            type: "line",

            data: {
                labels: ["Today", "This Week", "This Month"],

                datasets: [
                    {
                        label: "Cancer Patient History",

                        data: data,

                        tension: 0.4,

                        fill: true,

                        borderWidth: 3,

                        pointRadius: 5,

                        pointHoverRadius: 7,
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
        createChart("cancerHistoryChartExt", [
            data.todayCancerPatientHistory,
            data.weeklyCancerPatientHistory,
            data.monthlyCancerPatientHistory,
        ]);
    }

    return {
        init,
    };
})();
