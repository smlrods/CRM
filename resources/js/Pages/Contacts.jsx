import Layout from "@/Shared/Layout"; import ResouceLayout from "@/Shared/ResourceLayout";
import TableActions from "@/Shared/TableActions";
import TablePagination from "@/Shared/TablePagination";
import { Button, Spinner, TextInput, Textarea } from "flowbite-react";
import capitalizeFirstLetter from "@/Shared/utils/capitalizeFirstLetter";
import Table from "@/Shared/Table";

const ContactForm = ({
    data,
    setData,
    errors,
    onSubmit,
    processing,
    formData,
    updating = false
}) => {
    return (
        <form
            onSubmit={onSubmit}
            className="space-y-6 flex flex-col items-center"
        >
            <div className="w-full grid grid-cols-2 gap-2">
                <TextInput
                    id="first_name"
                    placeholder="First Name"
                    value={data.first_name}
                    onChange={(e) => setData("first_name", capitalizeFirstLetter(e.target.value))}
                    required
                    color={errors.first_name ? "failure" : null}
                    helperText={errors.first_name ?? null}
                    autoComplete="off"
                />
                <TextInput
                    id="Last Name"
                    placeholder="Last Name"
                    value={data.last_name}
                    onChange={(e) => setData("last_name", capitalizeFirstLetter(e.target.value))}
                    required
                    color={errors.last_name ? "failure" : null}
                    helperText={errors.last_name ?? null}
                    autoComplete="off"
                />
            </div>
            <div className="w-full">
                <Textarea
                    id="description"
                    name="description"
                    placeholder="Description"
                    defaultValue={data.description}
                    onChange={(e) => setData("description", e.target.value)}
                    required
                    rows="10"
                    color={errors.description ? "failure" : null}
                    helperText={errors.description ?? null}
                />
            </div>
            <div className="w-full">
                <TextInput
                    id="email"
                    placeholder="Email"
                    value={data.email}
                    onChange={(e) => setData("email", e.target.value)}
                    required
                    color={errors.email ? "failure" : null}
                    helperText={errors.email ?? null}
                    autoComplete="off"
                />
            </div>
            <div className="w-full">
                <TextInput
                    id="job_title"
                    placeholder="Job Title"
                    value={data.job_title}
                    onChange={(e) => setData("job_title", e.target.value)}
                    required
                    color={errors.job_title ? "failure" : null}
                    helperText={errors.job_title ?? null}
                    autoComplete="off"
                />
            </div>
            <div className="w-full">
                <TextInput
                    id="organization_name"
                    placeholder="Organization Name"
                    value={data.organization_name}
                    onChange={(e) =>
                        setData("organization_name", e.target.value)
                    }
                    required
                    color={errors.organization_name ? "failure" : null}
                    helperText={errors.organization_name ?? null}
                    autoComplete="off"
                />
            </div>
            <div className="w-full">
                <TextInput
                    id="phone_number"
                    placeholder="Phone Number"
                    value={data.phone_number}
                    onChange={(e) => setData("phone_number", e.target.value)}
                    required
                    color={errors.phone_number ? "failure" : null}
                    helperText={errors.phone_number ?? null}
                    autoComplete="off"
                />
            </div>
            {/* permissions */}
            <div>
                <Button
                    type="submit"
                    disabled={processing ?? false}
                    color="blue"
                >
                    {processing && <Spinner size="sm" />}
                    <span className={processing ? "ml-2" : ""}>
                        {processing ? "Loading" : updating ? "Update Contact" : "Add Contact"}
                    </span>
                </Button>
            </div>
        </form>
    );
};

const Contacts = ({ pagination }) => {
    return (
        <>
            <TableActions
                searchRoute={"contacts.index"}
                resourceType={"Contacts"}
                storeRoute={"contacts.store"}
                ResourceForm={ContactForm}
                resourceInfo={[
                    ["first_name", ""],
                    ["last_name", ""],
                    ["email", ""],
                    ["phone_number", ""],
                    ["organization_name", ""],
                    ["job_title", ""],
                    ["description", ""],
                ]}
            />
            <Table
                data={pagination.data}
                columns={[
                    { header: "Name", key: "full_name" },
                    { header: "Email", key: "email" },
                    { header: "Phone Number", key: "phone_number" },
                    { header: "Organization", key: "organization_name" },
                    { header: "Job Title", key: "job_title" },
                ]}
                resourceName={"contacts"}
                EditResourceForm={ContactForm}
                resourceInfoKeys={[
                    "first_name",
                    "last_name",
                    "email",
                    "phone_number",
                    "organization_name",
                    "job_title",
                    "description",
                ]}
            />
            <TablePagination pagination={pagination.links} />
        </>
    );
};

Contacts.layout = (page) => (
    <Layout>
        <ResouceLayout children={page} title="Contacts" />
    </Layout>
);

export default Contacts;
