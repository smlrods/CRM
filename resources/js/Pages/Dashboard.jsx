import Layout from "@/Shared/Layout";
import ActivitiesPieChart from "@/Shared/charts/ActivitiesPieChart";
import DealsAreaChart from "@/Shared/charts/DealsAreaChart";
import DealsPieChart from "@/Shared/charts/DealsPieChart";
import { Head, router, usePage } from "@inertiajs/react";
import { Dropdown } from "flowbite-react";

const Dashboard = ({
    dealAreaChartData,
    dealAreaChartRange,
    dealPieChartData,
    dealPieChartRange,
    activityPieChartData,
    activityPieChartRange,
}) => {
    const { auth } = usePage().props;

    const handleOrganizationSelection = (organizationId) => {
        router.put(route("users.organization"), {
            organization_id: organizationId,
        });
    };

    return (
        <>
            <Head title="Dashboard" />
            <h1 className="text-2xl mb-5">
                <Dropdown label={auth.organization.name} inline>
                    {auth.user.memberships.map((membership) => (
                        <Dropdown.Item
                            onClick={() =>
                                handleOrganizationSelection(
                                    membership.organization.id,
                                )
                            }
                            key={"dashboard-" + membership.organization.id}
                        >
                            {membership.organization.name}
                        </Dropdown.Item>
                    ))}
                </Dropdown>
            </h1>
            <div className="space-y-5">
                <DealsAreaChart
                    data={dealAreaChartData}
                    range={dealAreaChartRange}
                />
                <div className="grid sm:grid-cols-2 grid-cols-1 space-x-5">
                    <div>
                        <DealsPieChart
                            data={dealPieChartData}
                            range={dealPieChartRange}
                        />
                    </div>
                    <div>
                        <ActivitiesPieChart
                            data={activityPieChartData}
                            range={activityPieChartRange}
                        />
                    </div>
                </div>
            </div>
        </>
    );
};

Dashboard.layout = (page) => <Layout children={page} title="Organizations" />;

export default Dashboard;
