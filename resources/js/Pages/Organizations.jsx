import Alert from "@/Shared/Alert";
import { Head, router, usePage } from "@inertiajs/react";
import { Button, Card, Label, Modal, TextInput } from "flowbite-react";
import { useState } from "react";
import { HiMailOpen } from "react-icons/hi";

const OrganizationItem = ({ membership }) => {
    const [openModal, setOpenModal] = useState(false);
    const { auth } = usePage().props;

    const organization = membership.organization;

    const handleOrganizationSelection = () => {
        setOpenModal(false);

        router.put(route("users.organization"), {
            organization_id: organization.id,
        });
    };

    const handleOrganizationDeletion = () => {
        setOpenModal(false);

        if (auth.user.id === organization.user_id) {
            return router.delete(route("organizations.destroy", organization.id));
        }

        router.delete(route("members.destroy", membership.id));
    };

    return (
        <>
            <Button
                color="light"
                className="capitalize min-w-[200px]"
                onClick={() => setOpenModal(true)}
            >
                {organization.name}
                {auth.organization &&
                auth.organization.id === organization.id ? (
                    <span className="bg-blue-200 text-xs font-medium text-blue-800 text-center p-0.5 leading-none rounded-full px-2 dark:bg-blue-900 dark:text-blue-200 absolute -translate-y-1/2 translate-x-1/2 left-auto top-0 right-0">
                        selected
                    </span>
                ) : null}
            </Button>
            <Modal
                show={openModal}
                size="md"
                onClose={() => setOpenModal(false)}
                popup
            >
                <Modal.Header />
                <Modal.Body>
                    <div className="text-center">
                        <h3 className="mb-5 text-2xl font-bold capitalize">
                            {organization.name}
                        </h3>
                        <div className="mb-4">
                            <h2 className="font-bold">Owner by: </h2>
                            <p>{organization.user.username}</p>
                        </div>
                        <div className="flex justify-center gap-4">
                            <Button
                                color="blue"
                                onClick={handleOrganizationSelection}
                                size="sm"
                            >
                                {"Choose"}
                            </Button>
                            <Button
                                color="gray"
                                size="sm"
                                onClick={handleOrganizationDeletion}
                            >
                                {auth.user.id === organization.user_id
                                    ? "Delete"
                                    : "Leave"}
                            </Button>
                        </div>
                    </div>
                </Modal.Body>
            </Modal>
        </>
    );
};

const InvitationItem = ({ invitation }) => {
    const [openModal, setOpenModal] = useState(false);

    const handleInvitation = (accepted) => {
        setOpenModal(false);

        router.put(route("invitations.update", invitation.id), {
            status: accepted,
        });
    };

    return (
        <>
            <Button color="light" onClick={() => setOpenModal(true)}>
                {invitation.organization.name}
            </Button>
            <Modal
                show={openModal}
                size="md"
                onClose={() => setOpenModal(false)}
                popup
            >
                <Modal.Header />
                <Modal.Body>
                    <div className="text-center">
                        <HiMailOpen className="mx-auto mb-4 h-14 w-14 text-gray-400 dark:text-gray-200" />
                        <h3 className="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                            You have been invited to join this organization
                        </h3>
                        <div className="flex justify-center gap-4">
                            <Button
                                color="blue"
                                onClick={() => handleInvitation(true)}
                                size="sm"
                            >
                                {"Join Now"}
                            </Button>
                            <Button
                                color="gray"
                                size="sm"
                                onClick={() => handleInvitation(false)}
                            >
                                Decline
                            </Button>
                        </div>
                    </div>
                </Modal.Body>
            </Modal>
        </>
    );
};

const CreateOrganizationModal = () => {
    const [openModal, setOpenModal] = useState(false);
    const [name, setName] = useState("");

    function onCloseModal() {
        setOpenModal(false);
        setName("");
    }

    function onSubmit(e) {
        e.preventDefault();

        router.post(route("organizations.store"), {
            name,
        });
        onCloseModal();
    }

    return (
        <>
            <Button color="blue" size="sm" onClick={() => setOpenModal(true)}>
                Create
            </Button>
            <Modal show={openModal} size="md" onClose={onCloseModal} popup>
                <Modal.Header />
                <Modal.Body>
                    <form onSubmit={onSubmit}>
                        <div className="space-y-6">
                            <h3 className="text-xl font-medium text-gray-900 dark:text-white">
                                Create Organization
                            </h3>
                            <div>
                                <div className="mb-2 block">
                                    <Label htmlFor="name" value="Name" />
                                </div>
                                <TextInput
                                    id="name"
                                    placeholder="Enter Organization Name"
                                    autoComplete="off"
                                    value={name}
                                    onChange={(event) =>
                                        setName(event.target.value)
                                    }
                                    required
                                />
                            </div>
                            <div className="w-full">
                                <Button type="submit" color="blue">
                                    Create
                                </Button>
                            </div>
                        </div>
                    </form>
                </Modal.Body>
            </Modal>
        </>
    );
};

const Organizations = ({ memberships, invitations }) => {
    return (
        <>
            <Head title="Organizations" />
            <div className="flex justify-center items-center min-h-screen">
                <Card>
                    <div className="flex flex-col items-center px-10 md:min-w-[500px] min-w-full w-full">
                        <header className="flex gap-2">
                            <h1 className="text-3xl font-bold">
                                Organizations
                            </h1>
                            <CreateOrganizationModal />
                        </header>
                        {memberships.length ? (
                            <>
                                <div className="my-5 flex flex-col items-center gap-3">
                                    {memberships.map((membership) => (
                                        <OrganizationItem
                                            key={membership.organization.id}
                                            membership={membership}
                                        />
                                    ))}
                                </div>
                            </>
                        ) : null}
                        {invitations.length ? (
                            <>
                                <div className="my-5 flex flex-col items-center gap-3">
                                    <h2 className="text-2xl">Invitations</h2>
                                    {invitations.map((invitation) => (
                                        <InvitationItem
                                            key={"inv-" + invitation.id}
                                            invitation={invitation}
                                        />
                                    ))}
                                </div>
                            </>
                        ) : null}
                    </div>
                </Card>
            </div>
            <Alert />
        </>
    );
};

export default Organizations;
