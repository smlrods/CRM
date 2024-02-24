import Layout from "@/Shared/Layout";
import ResouceLayout from "@/Shared/ResourceLayout";
import TableActions from "@/Shared/TableActions";
import TablePagination from "@/Shared/TablePagination";
import {
    Button,
    Datepicker,
    Spinner,
    TextInput,
    Textarea,
} from "flowbite-react";
import capitalizeFirstLetter from "@/Shared/utils/capitalizeFirstLetter";
import Table from "@/Shared/Table";
import Select from "react-select";
import ComboBox from "@/Shared/ComboBox";

function DealForm({
    formData,
    data,
    setData,
    errors,
    onSubmit,
    processing,
    updating = false,
}) {
    function toSqlDateFormat(date) {
        var year = date.getFullYear();
        var month = (date.getMonth() + 1).toString().padStart(2, "0"); // Adds leading zero if needed
        var day = date.getDate().toString().padStart(2, "0"); // Adds leading zero if needed

        return year + "-" + month + "-" + day;
    }

    return (
        <form
            onSubmit={onSubmit}
            className="space-y-6 flex flex-col items-center"
        >
            <div className="w-full">
                <TextInput
                    id="name"
                    placeholder="Name"
                    value={data.name ?? ""}
                    onChange={(e) => setData("name", e.target.value)}
                    required
                    color={errors.name ? "failure" : null}
                    helperText={errors.name ?? null}
                    autoComplete="off"
                />
            </div>
            <div className="w-full">
                <TextInput
                    id="value"
                    placeholder="Value"
                    type="number"
                    step={0.01}
                    value={data.value ?? ""}
                    onChange={(e) => setData("value", e.target.value)}
                    required
                    color={errors.value ? "failure" : null}
                    helperText={errors.value ?? null}
                    autoComplete="off"
                />
            </div>
            <div className="w-full">
                <TextInput
                    id="currency"
                    placeholder="Currency"
                    type="text"
                    value={data.currency ? data.currency.toUpperCase() : ""}
                    onChange={(e) => setData("currency", e.target.value)}
                    required
                    color={errors.currency ? "failure" : null}
                    helperText={errors.currency ?? null}
                    autoComplete="off"
                />
            </div>
            <div className="w-full">
                <Datepicker
                    title="Close Date"
                    onSelectedDateChanged={(date) =>
                        setData("close_date", toSqlDateFormat(date))
                    }
                    defaultDate={
                        data.close_date ? new Date(data.close_date) : new Date()
                    }
                />
            </div>
            <div className="w-full">
                <Select
                    onChange={(data) => setData("status", data.value)}
                    options={[
                        { value: "pending", label: "Pending" },
                        { value: "won", label: "Won" },
                        { value: "lost", label: "Lost" },
                    ]}
                    placeholder="Status"
                    defaultInputValue={capitalizeFirstLetter(data.status ?? "")}
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
            <div className="w-full">
                <ComboBox
                    onChange={(data) => setData("lead_id", data.value)}
                    apiUrlPath={"/api/leads-options"}
                    placeholder={"Lead"}
                />
            </div>
            <div className="w-full">
                <ComboBox
                    onChange={(data) => setData("company_id", data.value)}
                    apiUrlPath={"/api/companies-options"}
                    placeholder={"Company"}
                />
            </div>
            <div className="w-full">
                <ComboBox
                    onChange={(data) => setData("contact_id", data.value)}
                    apiUrlPath={"/api/contacts-options"}
                    placeholder={"Contact"}
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
                        {processing
                            ? "Loading"
                            : updating
                              ? "Update Deal"
                              : "Add Deal"}
                    </span>
                </Button>
            </div>
        </form>
    );
}

const Deals = ({ pagination }) => {
    return (
        <>
            <TableActions
                searchRoute={"deals.index"}
                resourceType={"Deals"}
                storeRoute={"deals.store"}
                ResourceForm={DealForm}
                resourceInfo={[
                    ["lead_id", null],
                    ["contact_id", null],
                    ["company_id", null],
                    ["name", null],
                    ["value", null],
                    ["currency", null],
                    ["close_date", null],
                    ["status", null],
                    ["description", ""],
                ]}
            />
            <Table
                data={pagination.data}
                columns={[
                    { header: "Name", key: "name" },
                    { header: "Value", key: "value" },
                    { header: "Currency", key: "currency" },
                    { header: "Close date", key: "close_date" },
                    { header: "Status", key: "status" },
                    { header: "Description", key: "description" },
                    { header: "Company", key: "company_name" },
                    { header: "Contact", key: "contact_fullname" },
                ]}
                resourceName={"deals"}
                EditResourceForm={DealForm}
                resourceInfoKeys={[
                    "lead_id",
                    "contact_id",
                    "company_id",
                    "name",
                    "value",
                    "currency",
                    "close_date",
                    "status",
                    "description",
                ]}
            />
            <TablePagination pagination={pagination.links} />
        </>
    );
};

Deals.layout = (page) => (
    <Layout>
        <ResouceLayout children={page} title="Deals" />
    </Layout>
);

export default Deals;
