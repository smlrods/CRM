import { router } from "@inertiajs/react";
import { Select } from "flowbite-react";
import { useEffect, useState } from "react";
import Chart from "react-apexcharts";

const ActivitiesPieChart = ({ data, range }) => {
    const [series, setSeries] = useState([]);

    useEffect(() => {
        setSeries([
            data.call ?? 0,
            data.email ?? 0,
            data.meeting ?? 0,
            data.other ?? 0,
        ]);
    }, [data]);

    const handleRangeData = (range) => {
        router.reload({
            data: {
                "activities-pie-chart-range": range,
            },
        });
    };

    return (
        <div className="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
            <h1 className="text-xl font-bold">Activity Type Distribution</h1>
            <Chart
                type="pie"
                series={series ?? []}
                options={{
                    labels: ["Call", "Email", "Meeting", "Other"],
                    legend: { position: "bottom" },
                    colors: ["#E02424", "#057A55", "#1C64F2", "#7E3AF2"],
                }}
                height={500}
            />
            <div className="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                <div className="flex justify-between items-center pt-5">
                    <div>
                        <Select
                            id="pie-chart-range-activities"
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

export default ActivitiesPieChart;
