import Layout from "@/Shared/Layout";
import ResouceLayout from "@/Shared/ResourceLayout";
import Table from "@/Shared/Table";
import TableActions from "@/Shared/TableActions";
import TablePagination from "@/Shared/TablePagination";
import { Button, Modal, Spinner, TextInput } from "flowbite-react";

const AddMemberForm = ({ data, setData, errors, onSubmit, processing }) => {
    return (
        <form
            onSubmit={onSubmit}
            className="space-y-6 flex flex-col items-center"
        >
            <div className="w-full">
                <TextInput
                    id="member-info"
                    placeholder="Username or Email"
                    value={data.memberInfo}
                    onChange={(e) => setData("memberInfo", e.target.value)}
                    required
                    color={errors.memberInfo ? "failure" : null}
                    helperText={errors.memberInfo ?? null}
                    autoComplete="off"
                />
            </div>
            <div>
                <Button
                    type="submit"
                    disabled={processing ?? false}
                    color="blue"
                >
                    {processing && <Spinner size="sm" />}
                    <span className="ml-2">
                        {processing ? "Loading" : "Send Invitation"}
                    </span>
                </Button>
            </div>
        </form>
    );
};

const EditMemberForm = ({
    data,
    setData,
    errors,
    onSubmit,
    processing,
    formData,
    item,
}) => {
    return (
        <form
            onSubmit={onSubmit}
            className="space-y-6 flex flex-col items-center"
        >
            <div className="w-full text-center">
                <h1 className="text-lg">{item.full_name}</h1>
            </div>
            <div>
                {formData.map((role) => (
                    <div key={role.id}>
                        <input checked={data.role_id === role.id} onChange={() => setData('role_id', role.id)} name="role" type="radio" id={role.id} />
                        <label className="ml-2" htmlFor={role.id}>{role.name}</label>
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
                    <span className="ml-2">
                        {processing ? "Loading" : "Save"}
                    </span>
                </Button>
            </div>
        </form>
    );
};

const Members = ({ pagination, rolesData }) => {
    return (
        <>
            <TableActions
                searchRoute={"members.index"}
                resourceType={"Members"}
                storeRoute={"invitations.store"}
                ResourceForm={AddMemberForm}
                resourceInfo={[["memberInfo", ""]]}
            />
            <Table
                data={pagination.data}
                columns={[
                    { header: "Name", key: "full_name" },
                    { header: "Email", key: "email" },
                    { header: "Role", key: "role_name" },
                ]}
                resourceName={"members"}
                propertyIdPath={"membership.id"}
                EditResourceForm={EditMemberForm}
                editFormData={rolesData.data}
                resourceInfoKeys={["role_id"]}
            />
            <TablePagination pagination={pagination.links} />
        </>
    );
};

Members.layout = (page) => (
    <Layout>
        <ResouceLayout children={page} title="Members" />
    </Layout>
);

export default Members;
