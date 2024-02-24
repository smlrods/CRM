import { router } from "@inertiajs/react";
import { Select } from "flowbite-react";
import { useEffect, useState } from "react";
import Chart from "react-apexcharts";

const DealsPieChart = ({ data, range }) => {
    const [series, setSeries] = useState([]);

    useEffect(() => {
        setSeries([data.pending ?? 0, data.won ?? 0, data.lost ?? 0]);
    }, [data]);

    const handleRangeData = (range) => {
        router.reload({
            data: {
                "deals-pie-chart-range": range,
            },
        });
    };

    return (
        <div className="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
            <h1 className="text-xl font-bold">Deal Type Distribution</h1>
            <Chart
                type="pie"
                series={series}
                options={{
                    labels: ["Pending", "Won", "Lost"],
                    legend: { position: "bottom" },
                    colors: ["#FACA15", "#1C64F2", "#7E3AF2"],
                }}
                height={500}
            />
            <div className="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                <div className="flex justify-between items-center pt-5">
                    <div>
                        <Select
                            id="pie-chart-range-deals"
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

export default DealsPieChart;
