import Layout from "@/Shared/Layout";
import ResouceLayout from "@/Shared/ResourceLayout";
import TableActions from "@/Shared/TableActions";
import TablePagination from "@/Shared/TablePagination";
import { Button, Dropdown, Spinner, TextInput, Textarea } from "flowbite-react";
import capitalizeFirstLetter from "@/Shared/utils/capitalizeFirstLetter";
import Table from "@/Shared/Table";
import ComboBox from "@/Shared/ComboBox";
import { router } from "@inertiajs/react";
import Select from "react-select";

const LeadForm = ({
    data,
    setData,
    errors,
    onSubmit,
    processing,
    formData,
    updating = false,
}) => {
    return (
        <form
            onSubmit={onSubmit}
            className="space-y-6 flex flex-col items-center"
        >
            <div className="w-full">
                <ComboBox
                    onChange={(data) => setData("company_id", data.value)}
                    apiUrlPath={"/api/companies-options"}
                />
            </div>
            <div className="w-full">
                <ComboBox
                    onChange={(data) => setData("contact_id", data.value)}
                    apiUrlPath={"/api/contacts-options"}
                />
            </div>
            <div className="w-full">
                <Select
                    onChange={(data) => setData("source", data.value)}
                    options={[
                        { value: "website", label: "Website" },
                        { value: "referral", label: "Referral" },
                        { value: "social_media", label: "Social Media" },
                        { value: "other", label: "Other" },
                    ]}
                    placeholder="Source"
                    defaultValue={
                        data.source
                            ? {
                                  value: data.source,
                                  label: capitalizeFirstLetter(
                                      data.source ?? "",
                                  ),
                              }
                            : null
                    }
                    styles={{
                        menuPortal: (base) => ({ ...base, zIndex: 9999 }),
                    }}
                    menuPortalTarget={document.body}
                />
            </div>
            <div className="w-full">
                <Select
                    onChange={(data) => setData("status", data.value)}
                    options={[
                        { value: "open", label: "Open" },
                        { value: "closed", label: "Closed" },
                        { value: "converted", label: "Converted" },
                    ]}
                    placeholder="Status"
                    defaultValue={
                        data.status
                            ? {
                                  value: data.status,
                                  label: capitalizeFirstLetter(
                                      data.status ?? "",
                                  ),
                              }
                            : null
                    }
                    styles={{
                        menuPortal: (base) => ({ ...base, zIndex: 9999 }),
                    }}
                    menuPortalTarget={document.body}
                />
            </div>
            <div className="w-full">
                <Textarea
                    onChange={(e) => setData("description", e.target.value)}
                    id="description"
                    placeholder="Description"
                    required
                    rows={4}
                    color="blue"
                    value={data.description}
                />
            </div>
            <div>
                <Button
                    type="submit"
                    disabled={processing ?? false}
                    color="blue"
                >
                    {processing && <Spinner size="sm" />}
                    <span className={processing ? "ml-2" : ""}>
                        {processing ? "Loading" : updating ? "Update Lead" : "Add Lead"}
                    </span>
                </Button>
            </div>
        </form>
    );
};

const Leads = ({ pagination }) => {
    return (
        <>
            <TableActions
                searchRoute={"leads.index"}
                resourceType={"Leads"}
                storeRoute={"leads.store"}
                ResourceForm={LeadForm}
                resourceInfo={[
                    ["source", null],
                    ["status", null],
                    ["description", ""],
                    ["contact_id", null],
                    ["company_id", null],
                ]}
            />
            <Table
                data={pagination.data}
                columns={[
                    { header: "Company", key: "company_name" },
                    { header: "Contact", key: "contact_fullname" },
                    { header: "Description", key: "description" },
                    { header: "Source", key: "source" },
                    { header: "Status", key: "status" },
                ]}
                resourceName={"leads"}
                EditResourceForm={LeadForm}
                resourceInfoKeys={[
                    "source",
                    "status",
                    "description",
                    "contact_id",
                    "company_id",
                ]}
            />
            <TablePagination pagination={pagination.links} />
        </>
    );
};

Leads.layout = (page) => (
    <Layout>
        <ResouceLayout children={page} title="Leads" />
    </Layout>
);

export default Leads;
