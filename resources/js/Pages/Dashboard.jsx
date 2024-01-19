import Layout from "@/Shared/Layout";
import { Head, router, usePage } from "@inertiajs/react";
import { Dropdown } from "flowbite-react";

const Dashboard = () => {
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
        </>
    );
};

Dashboard.layout = (page) => <Layout children={page} title="Organizations" />;

export default Dashboard;
