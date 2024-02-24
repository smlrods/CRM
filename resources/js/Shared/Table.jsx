import { router, useForm } from "@inertiajs/react";
import {
    Button,
    Label,
    Modal,
    Table as TableFlowbite,
    TextInput,
} from "flowbite-react";
import { useEffect, useState } from "react";
import {
    HiOutlineExclamationCircle,
    HiPencilAlt,
    HiTrash,
} from "react-icons/hi";

function EditButton({
    item,
    resourceRoute,
    EditResourceForm,
    editFormData,
    resourceInfoKeys,
}) {
    const [openModal, setOpenModal] = useState(false);
    const {
        data,
        setData,
        put,
        processing,
        setDefaults,
        errors,
        reset,
    } = useForm(
        Object.fromEntries(resourceInfoKeys.map((key) => [key, item[key]])),
    );

    function onCloseModal() {
        setOpenModal(false);
    }

    useEffect(() => {
        if (!openModal) {
            reset();
        }
    }, [openModal]);

    function submit(e) {
        e.preventDefault();
        put(resourceRoute, {
            onSuccess: () => {
                onCloseModal();
                setDefaults();
            },
        });
    }

    return (
        <>
            <Button onClick={() => setOpenModal(true)} color="blue">
                <HiPencilAlt />
                <span className="ml-2 font-semibold">Edit</span>
            </Button>
            <Modal show={openModal} size="2xl" onClose={onCloseModal} popup>
                <Modal.Header />
                <Modal.Body>
                    <EditResourceForm
                        item={item}
                        formData={editFormData}
                        data={data}
                        setData={setData}
                        errors={errors}
                        onSubmit={submit}
                        processing={processing}
                        updating={true}
                    />
                </Modal.Body>
            </Modal>
        </>
    );
}

function DeleteButton({ resourceRoute }) {
    const [openModal, setOpenModal] = useState(false);
    const [processing, setProcessing] = useState(false);

    const handleDelete = () => {
        setOpenModal(false);

        router.delete(resourceRoute, {
            preserveState: true,
            onProgress: () => setProcessing(true),
            onSuccess: () => {
                setProcessing(false);
                setOpenModal(false);
            },
        });
    };

    return (
        <>
            <Button
                onClick={() => setOpenModal(true)}
                color="failure"
                size="sm"
                disabled={processing}
            >
                <HiTrash />
                <span className="ml-1.5">Delete</span>
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
                        <HiOutlineExclamationCircle className="mx-auto mb-4 h-14 w-14 text-gray-400 dark:text-gray-200" />
                        <h3 className="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                            Are you sure you want to delete this member?
                        </h3>
                        <div className="flex justify-center gap-4">
                            <Button
                                disabled={processing}
                                color="failure"
                                onClick={handleDelete}
                            >
                                {"Yes, I'm sure"}
                            </Button>
                            <Button
                                color="gray"
                                onClick={() => setOpenModal(false)}
                            >
                                No, cancel
                            </Button>
                        </div>
                    </div>
                </Modal.Body>
            </Modal>
        </>
    );
}

const Table = ({
    data,
    columns,
    resourceName,
    propertyIdPath,
    EditResourceForm,
    editFormData,
    resourceInfoKeys,
}) => {
    const getPropertyByPath = (obj, path) => {
        const keys = path.split(".");
        let result = obj;

        for (const key of keys) {
            if (result && typeof result === "object" && key in result) {
                result = result[key];
            } else {
                return undefined;
            }
        }

        return result;
    };
    return (
        <div className="overflow-x-auto">
            <TableFlowbite
                hoverable
                theme={{
                    head: {
                        base: "group/head text-xs uppercase text-white dark:text-gray-400",
                        cell: {
                            base: "group-first/head:first:rounded-tl-lg group-first/head:last:rounded-tr-lg bg-blue-500 dark:bg-gray-700 px-6 py-3",
                        },
                    },
                }}
            >
                <TableFlowbite.Head>
                    {columns.map((column) => (
                        <TableFlowbite.HeadCell key={column.key}>
                            {column.header}
                        </TableFlowbite.HeadCell>
                    ))}
                    <TableFlowbite.HeadCell>
                        <span className="sr-only">Edit</span>
                    </TableFlowbite.HeadCell>
                </TableFlowbite.Head>
                <TableFlowbite.Body className="divide-y">
                    {data.map((item) => (
                        <TableFlowbite.Row
                            key={resourceName + "-" + item.id}
                            className="bg-white dark:border-gray-700 dark:bg-gray-800"
                        >
                            {columns.map((column) => (
                                <TableFlowbite.Cell key={column.key + "body"}>
                                    {item[column.key] ?? "Not yet"}
                                </TableFlowbite.Cell>
                            ))}
                            <TableFlowbite.Cell>
                                <div className="flex gap-2">
                                    <EditButton
                                        item={item}
                                        resourceRoute={route(
                                            resourceName + ".update",
                                            item.id,
                                        )}
                                        EditResourceForm={EditResourceForm}
                                        editFormData={editFormData}
                                        resourceInfoKeys={resourceInfoKeys}
                                    />
                                    <DeleteButton
                                        resourceRoute={route(
                                            resourceName + ".destroy",
                                            propertyIdPath
                                                ? getPropertyByPath(
                                                      item,
                                                      propertyIdPath,
                                                  )
                                                : item.id,
                                        )}
                                    />
                                </div>
                            </TableFlowbite.Cell>
                        </TableFlowbite.Row>
                    ))}
                </TableFlowbite.Body>
            </TableFlowbite>
        </div>
    );
};

export default Table;
