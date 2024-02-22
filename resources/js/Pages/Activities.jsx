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

const AddActivityForm = ({
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

function EditActivityForm({
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

const ActivityForm = ({
    data,
    setData,
    errors,
    onSubmit,
    processing,
    formData,
    updating = false,
}) => {
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
                <ComboBox
                    onChange={(data) => setData("contact_id", data.value)}
                    apiUrlPath={"/api/contacts-options"}
                    placeholder={"Contacts"}
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
                <Select
                    onChange={(data) => setData("type", data.value)}
                    options={[
                        { value: "call", label: "Call" },
                        { value: "email", label: "Email" },
                        { value: "meeting", label: "Meeting" },
                        { value: "other", label: "Other" },
                    ]}
                    placeholder="Status"
                    defaultInputValue={capitalizeFirstLetter(data.type ?? "")}
                    styles={{
                        menuPortal: (base) => ({ ...base, zIndex: 9999 }),
                    }}
                    menuPortalTarget={document.body}
                />
            </div>
            <div className="w-full">
                <Datepicker
                    title="Date"
                    onSelectedDateChanged={(date) =>
                        setData("date", toSqlDateFormat(date))
                    }
                    defaultDate={data.date ? new Date(data.date) : new Date()}
                    color={errors.date ? "failure" : null}
                    helperText={errors.date ?? null}
                />
            </div>
            <div className="w-full">
                <TextInput
                    id="time"
                    placeholder="Time"
                    value={data.time ?? ""}
                    type="time"
                    onChange={(e) => setData("time", e.target.value)}
                    required
                    step={5}
                    color={errors.time ? "failure" : null}
                    helperText={errors.time ?? null}
                    autoComplete="off"
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
                        {processing
                            ? "Loading"
                            : updating
                              ? "Update Activity"
                              : "Add Activity"}
                    </span>
                </Button>
            </div>
        </form>
    );
};

const Activities = ({ pagination }) => {
    return (
        <>
            <TableActions
                searchRoute={"activities.index"}
                resourceType={"Activities"}
                storeRoute={"activities.store"}
                ResourceForm={ActivityForm}
                resourceInfo={[
                    ["contact_id", null],
                    ["lead_id", null],
                    ["type", null],
                    ["date", null],
                    ["time", null],
                    ["description", ""],
                ]}
            />
            <Table
                data={pagination.data}
                columns={[
                    { header: "Contact", key: "contact_fullname" },
                    { header: "Type", key: "type" },
                    { header: "Date", key: "date" },
                    { header: "Time", key: "time" },
                    { header: "Description", key: "description" },
                ]}
                resourceName={"activities"}
                EditResourceForm={ActivityForm}
                resourceInfoKeys={[
                    "contact_id",
                    "lead_id",
                    "type",
                    "date",
                    "time",
                    "description",
                ]}
            />
            <TablePagination pagination={pagination.links} />
        </>
    );
};

Activities.layout = (page) => (
    <Layout>
        <ResouceLayout children={page} title="Activities" />
    </Layout>
);

export default Activities;
