import ApexCharts from "apexcharts";

const getChartData = (data) => {
    return Object.values(data);
}

const getLabels = (data) => {
    return Object.keys(data);
}

const chartData = getChartData(dataTasks);
const labels = getLabels(dataTasks);

const taskStatusColors = [
  "#CBD5E0", // Not Started
  "#1E40AF", // In Progress
  "#D97706", // On Hold
  "#48BB78", // Completed
  "#EF4444", // Delayed
  "#DC2626", // Blocked
  "#6B7280", // Cancelled
  "#9333EA", // Needs Review
  "#DC2626", // High Priority
  "#D97706", // Low Priority
];

// ApexCharts options and config
window.addEventListener("load", function() {
    const getChartOptions = () => {
        return {
            series: chartData,
            colors: taskStatusColors,
            chart: {
                height: 320,
                width: "100%",
                type: "donut",
            },
            stroke: {
                colors: ["transparent"],
                lineCap: "",
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontFamily: "Inter, sans-serif",
                                offsetY: 20,
                            },
                            total: {
                                showAlways: true,
                                show: true,
                                label: "Total Tasks",
                                fontFamily: "Inter, sans-serif",
                                formatter: function(w) {
                                    const sum = w.globals.seriesTotals.reduce((a, b) => {
                                        return a + b
                                    }, 0)
                                    return `${sum}`
                                },
                            },
                            value: {
                                show: true,
                                fontFamily: "Inter, sans-serif",
                                offsetY: -20,
                            },
                        },
                        size: "80%",
                    },
                },
            },
            grid: {
                padding: {
                    top: -2,
                },
            },
            labels: labels,
            dataLabels: {
                enabled: false,
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
            xaxis: {
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
        }
    }

    if (document.getElementById("donut-chart-tasks") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("donut-chart-tasks"), getChartOptions());
        chart.render();
    }
});
