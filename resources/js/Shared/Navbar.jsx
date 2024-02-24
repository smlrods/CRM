import { Link, router, usePage } from "@inertiajs/react";
import { Dropdown, Navbar as Nav } from "flowbite-react";
import { HiMenuAlt1, HiOutlineUserCircle } from "react-icons/hi";

const Navbar = ({ toggleSidebar }) => {
    const { auth } = usePage().props;

    const handleOrganizationSelection = (organizationId) => {
        router.put(route("users.organization"), {
            organization_id: organizationId,
        });
    };

    return (
        <div className="fixed top-0 left-0 w-full z-40">
            <Nav fluid rounded border className="sm:px-3">
                <div className="flex">
                    <button
                        className="px-2 mr-2 hover:bg-gray-100"
                        onClick={toggleSidebar}
                    >
                        <HiMenuAlt1 className="text-2xl" />
                    </button>
                    <Nav.Brand as={Link} href="/dashboard">
                        <span className="self-center whitespace-nowrap text-xl font-semibold dark:text-white">
                            CRM
                        </span>
                    </Nav.Brand>
                </div>
                <div className="flex md:order-2 gap-2">
                    <Dropdown
                        color="light"
                        label={
                            auth.organization.name.length > 15
                                ? auth.organization.name.substring(0, 15) +
                                  "..."
                                : auth.organization.name
                        }
                        size="xs"
                    >
                        {auth.user.memberships.map((membership) => (
                            <Dropdown.Item
                                onClick={() =>
                                    handleOrganizationSelection(
                                        membership.organization.id,
                                    )
                                }
                                key={"navbar-" + membership.organization.id}
                            >
                                {membership.organization.name}
                            </Dropdown.Item>
                        ))}
                    </Dropdown>
                    <Dropdown
                        arrowIcon={false}
                        inline
                        label={<HiOutlineUserCircle className="text-3xl" />}
                    >
                        <Dropdown.Header>
                            <span className="block text-sm">
                                {auth.user.full_name}
                            </span>
                            <span className="block truncate text-sm font-medium">
                                {auth.user.email}
                            </span>
                        </Dropdown.Header>
                        <Dropdown.Item as={Link} href="/dashboard">
                            Dashboard
                        </Dropdown.Item>
                        <Dropdown.Divider />
                        <Dropdown.Item onClick={() => router.post("/logout")}>
                            Sign out
                        </Dropdown.Item>
                    </Dropdown>
                </div>
            </Nav>
        </div>
    );
};

export default Navbar;
