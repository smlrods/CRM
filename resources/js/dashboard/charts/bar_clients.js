import ApexCharts from "apexcharts";

const getTotalUsers = (data) => {
    return Object.values(data).map(item => item.totalDay);
}

const getTotalNewUsers = (data) => {
    return Object.values(data).map(item => item.totalNew);
}

// ApexCharts options and config
window.addEventListener("load", function() {
var options = {
    series: [
    {
        name: "Total Clients",
        color: "#1d4ed8",
        data: getTotalUsers(dataUsers),
    },
    {
        name: "New Clients",
        data: getTotalNewUsers(dataUsers),
        color: "#10b981",
    }
    ],
    chart: {
        sparkline: {
            enabled: false,
        },
            type: "bar",
            width: "100%",
            height: 400,
            toolbar: {
                show: false,
            }
        },
        fill: {
            opacity: 1,
        },
    plotOptions: {
    bar: {
        horizontal: true,
        columnWidth: "100%",
        borderRadiusApplication: "end",
        borderRadius: 6,
        dataLabels: {
            position: "top",
        },
    },
    },
    legend: {
        show: true,
        position: "bottom",
    },
    dataLabels: {
        enabled: false,
    },
    tooltip: {
        shared: true,
        intersect: false,
        formatter: function (value) {
            return value
        }
    },
    xaxis: {
        labels: {
            show: true,
            style: {
                fontFamily: "Inter, sans-serif",
                cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
            },
            formatter: function(value) {
                return value
            },
        },
        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        axisTicks: {
            show: false,
        },
        axisBorder: {
            show: false,
        },
    },
    yaxis: {
        labels: {
            show: true,
            style: {
                fontFamily: "Inter, sans-serif",
                cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
            }
        }
    },
    grid: {
        show: true,
        strokeDashArray: 4,
        padding: {
            left: 10,
            right: 10,
            top: -20
        },
    },
    fill: {
        opacity: 1,
    }
}

if(document.getElementById("bar-chart-clients") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.getElementById("bar-chart-clients"), options);
    chart.render();
}});
