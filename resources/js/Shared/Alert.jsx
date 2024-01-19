import { usePage } from "@inertiajs/react";
import { Alert as AlertComponent } from "flowbite-react";
import { useEffect, useState } from "react";

const Alert = () => {
    const { flash } = usePage().props;
    const [showAlert, setShowAlert] = useState(false);

    useEffect(() => {
        if (flash.alert.message) {
            return setShowAlert(true);
        }
        setShowAlert(false);
    }, [flash]);

    return (
        <>
            {showAlert ? (
                <div className="fixed top-0 left-0 flex justify-center w-full pointer-events-none p-5 z-50">
                    <AlertComponent
                        className="pointer-events-auto"
                        color={flash.alert.type ?? "success"}
                        onDismiss={() => {
                            setShowAlert(false);
                        }}
                    >
                        {flash.alert.message}
                    </AlertComponent>
                </div>
            ) : null}
        </>
    );
};

export default Alert;
