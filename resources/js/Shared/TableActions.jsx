import { router } from "@inertiajs/react";
import AddResourceModal from "./AddResourceModal";

const TableActions = ({
    searchRoute,
    storeRoute,
    resourceType,
    resourceInfo,
    ResourceForm,
    formData = null,
}) => {
    return (
        <div className="flex items-center justify-between mb-3">
            <input
                className="border border-gray-100 rounded"
                placeholder={"Search for " + resourceType.toLowerCase()}
                onKeyDown={(e) =>
                    e.key === "Enter" &&
                    router.get(
                        route(searchRoute, { query: e.target.value }),
                        {},
                        { preserveState: true },
                    )
                }
            />
            <AddResourceModal
                resourceType={resourceType}
                storeRoute={storeRoute}
                resourceInfo={resourceInfo}
                buttonTexts={["Add", resourceType]}
                ResourceForm={ResourceForm}
                formData={formData}
            />
        </div>
    );
};

export default TableActions;
