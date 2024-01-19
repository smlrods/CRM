import Layout from "@/Shared/Layout";
import ResouceLayout from "@/Shared/ResourceLayout";
import Table from "@/Shared/Table";
import TableActions from "@/Shared/TableActions";
import TablePagination from "@/Shared/TablePagination";
import { Button, Spinner, TextInput } from "flowbite-react";
import capitalizeFirstLetter from "@/Shared/utils/capitalizeFirstLetter";


const AddRoleForm = ({
    data,
    setData,
    errors,
    onSubmit,
    processing,
    formData,
}) => {
    return (
        <form
            onSubmit={onSubmit}
            className="space-y-6 flex flex-col items-center"
        >
            <div className="w-full">
                <TextInput
                    id="name"
                    placeholder="Name"
                    value={data.name}
                    onChange={(e) => setData("name", e.target.value)}
                    required
                    color={errors.memberInfo ? "failure" : null}
                    helperText={errors.memberInfo ?? null}
                    autoComplete="off"
                />
            </div>
            {/* permissions */}
            <div>
                {Object.keys(formData).map((key) => (
                    <div key={key}>
                        <h1 className="font-bold">
                            {capitalizeFirstLetter(key)}
                        </h1>
                        {Object.values(formData[key]).map((permission) => (
                            <div key={permission.value}>
                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    onChange={(e) => {
                                        if (e.target.checked) {
                                            setData(
                                                "permissions",
                                                data.permissions.concat(
                                                    permission.value,
                                                ),
                                            );
                                        } else {
                                            setData(
                                                "permissions",
                                                data.permissions.filter(
                                                    (p) =>
                                                        p !== permission.value,
                                                ),
                                            );
                                        }
                                    }}
                                    id={permission.value}
                                    value={permission.value}
                                />
                                <label
                                    htmlFor={permission.value}
                                    className="ml-2"
                                >
                                    {permission.label}
                                </label>
                            </div>
                        ))}
                    </div>
                ))}
            </div>
            <div>
                <Button
                    type="submit"
                    disabled={processing ?? false}
                    color="blue"
                >
                    {processing && <Spinner size="sm" />}
                    <span className={processing ? "ml-2" : ""}>
                        {processing ? "Loading" : "Add Role"}
                    </span>
                </Button>
            </div>
        </form>
    );
};

function EditRoleForm({
    formData,
    data,
    setData,
    errors,
    onSubmit,
    processing,
}) {
    return (
        <form
            onSubmit={onSubmit}
            className="space-y-6 flex flex-col items-center"
        >
            <div className="w-full">
                <TextInput
                    id="name"
                    placeholder="Name"
                    value={capitalizeFirstLetter(data.name)}
                    onChange={(e) => setData("name", e.target.value)}
                    required
                    color={errors.name ? "failure" : null}
                    helperText={errors.name ?? null}
                    autoComplete="off"
                />
            </div>
            {/* permissions */}
            <div>
                {Object.keys(formData).map((key) => (
                    <div key={key}>
                        <h1 className="font-bold">
                            {capitalizeFirstLetter(key)}
                        </h1>
                        {Object.values(formData[key]).map((permission) => (
                            <div key={permission.value}>
                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    checked={data.permissions.includes(
                                        permission.value,
                                    )}
                                    onChange={(e) => {
                                        if (e.target.checked) {
                                            setData(
                                                "permissions",
                                                data.permissions.concat(
                                                    permission.value,
                                                ),
                                            );
                                        } else {
                                            setData(
                                                "permissions",
                                                data.permissions.filter(
                                                    (p) =>
                                                        p !== permission.value,
                                                ),
                                            );
                                        }
                                    }}
                                    id={permission.value}
                                    value={permission.value}
                                />
                                <label
                                    htmlFor={permission.value}
                                    className="ml-2"
                                >
                                    {permission.label}
                                </label>
                            </div>
                        ))}
                    </div>
                ))}
            </div>
            <div>
                <Button
                    type="submit"
                    disabled={processing ?? false}
                    color="blue"
                >
                    {processing && <Spinner size="sm" />}
                    <span className={processing ? "ml-2" : ""}>
                        {processing ? "Loading" : "Update Role"}
                    </span>
                </Button>
            </div>
        </form>
    );
}

const Roles = ({ pagination, permissions }) => {
    return (
        <>
            <TableActions
                searchRoute={"roles.index"}
                resourceType={"Roles"}
                storeRoute={"roles.store"}
                ResourceForm={AddRoleForm}
                resourceInfo={[
                    ["name", ""],
                    ["permissions", []],
                ]}
                formData={permissions}
            />
            <Table
                data={pagination.data}
                columns={[
                    { header: "Name", key: "name" },
                    { header: "Created At", key: "created_at" },
                    { header: "Updated At", key: "updated_at" },
                ]}
                resourceName={"roles"}
                EditResourceForm={EditRoleForm}
                editFormData={permissions}
                resourceInfoKeys={["name", "permissions"]}
            />
            <TablePagination pagination={pagination} />
        </>
    );
};

Roles.layout = (page) => (
    <Layout title="Roles">
        <ResouceLayout children={page} title="Roles" />
    </Layout>
);

export default Roles;
