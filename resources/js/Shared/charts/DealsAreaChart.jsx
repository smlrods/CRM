import { router } from "@inertiajs/react";
import { Dropdown, Select } from "flowbite-react";
import React, { useEffect, useState } from "react";
import Chart from "react-apexcharts";
import { HiArrowNarrowDown, HiArrowNarrowUp } from "react-icons/hi";

const DealsChart = ({ data, range }) => {
    const [series, setSeries] = useState([]);

    const [options, setOptions] = useState({
        chart: {
            height: "100%",
            maxWidth: "100%",
            type: "area",
            fontFamily: "Inter, sans-serif",
            dropShadow: {
                enabled: false,
            },
            toolbar: {
                show: false,
            },
        },
        tooltip: {
            enabled: true,
            x: {
                show: false,
            },
            y: {
                formatter: function (value) {
                    return "$" + value;
                },
            },
        },
        fill: {
            type: "gradient",
            gradient: {
                opacityFrom: 0.55,
                opacityTo: 0,
                shade: "#1C64F2",
                gradientToColors: ["#1C64F2"],
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: 6,
        },
        grid: {
            show: false,
            strokeDashArray: 4,
            padding: {
                left: 2,
                right: 2,
                top: 0,
            },
        },
        xaxis: {
            labels: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            show: false,
        },
    });

    useEffect(() => {
        let serieValues = data.dailyTotals.map(
            (dailyTotal) => dailyTotal.value,
        );
        let serieCategories = data.dailyTotals.map(
            (dailyTotal) => dailyTotal.date,
        );

        setSeries([
            {
                name: "Deals",
                data: serieValues,
            },
        ]);

        setOptions({
            ...options,
            xaxis: {
                ...options.xaxis,
                categories: serieCategories,
            },
        });
    }, [data]);

    useEffect(() => {}, [range]);

    const handleRangeData = (range) => {
        router.reload({
            data: {
                "deals-range": range,
            },
        });
    };

    return (
        <div className="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
            <div className="flex justify-between">
                <div>
                    <h5 className="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">
                        ${(data.total / 1000).toFixed(1)}k
                    </h5>
                    <p className="text-base font-normal text-gray-500 dark:text-gray-400">
                        Deals total
                    </p>
                </div>
                <div
                    className={
                        "flex items-center px-2.5 py-0.5 text-base font-semibold text-center " +
                        (data.percentage !== 0
                            ? data.percentage > 0
                                ? "text-green-500 dark:text-green-500"
                                : "text-red-500 dark:text-red-500"
                            : null)
                    }
                >
                    {data.percentage.toFixed(1)}%
                    {data.percentage !== 0 ? (
                        data.percentage > 0 ? (
                            <HiArrowNarrowUp />
                        ) : (
                            <HiArrowNarrowDown />
                        )
                    ) : null}
                </div>
            </div>
            <div>
                <Chart
                    options={options}
                    height={200}
                    series={series}
                    type="area"
                />
            </div>
            <div className="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                <div className="flex justify-between items-center pt-5">
                    <div>
                        <Select
                            id="countries"
                            required
                            onChange={(e) => handleRangeData(+e.target.value)}
                            defaultValue={range}
                        >
                            <option value={7}>Last 7 days</option>
                            <option value={30}>Last 30 days</option>
                            <option value={90}>Last 90 days</option>
                        </Select>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default DealsChart;
