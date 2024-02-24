import { useForm } from "@inertiajs/react";
import { Button, Modal } from "flowbite-react";
import { useState } from "react";

const AddResourceModal = ({
    resourceType,
    resourceInfo,
    storeRoute,
    ResourceForm,
    formData,
}) => {
    const [openModal, setOpenModal] = useState(false);
    const { data, setData, post, processing, reset, errors } = useForm(
        Object.fromEntries(resourceInfo),
    );

    function onCloseModal() {
        setOpenModal(false);
        reset();
    }

    function submit(e) {
        e.preventDefault();
        post(route(storeRoute), {
            onSuccess: () => {
                onCloseModal();
            },
        });
    }

    return (
        <>
            <Button onClick={() => setOpenModal(true)} color="blue">
                Add {resourceType}
            </Button>
            <Modal show={openModal} size="2xl" onClose={onCloseModal} popup>
                <Modal.Header />
                <Modal.Body>
                    <h3 className="text-2xl font-medium text-gray-900 dark:text-white text-center mb-3">
                        Add {resourceType}
                    </h3>
                    <ResourceForm
                        data={data}
                        setData={setData}
                        errors={errors}
                        onSubmit={submit}
                        processing={processing}
                        formData={formData}
                    />
                </Modal.Body>
            </Modal>
        </>
    );
};

export default AddResourceModal;
