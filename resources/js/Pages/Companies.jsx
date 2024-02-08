import Layout from "@/Shared/Layout";
import ResouceLayout from "@/Shared/ResourceLayout";
import TableActions from "@/Shared/TableActions";
import TablePagination from "@/Shared/TablePagination";
import { Button, Spinner, TextInput, Textarea } from "flowbite-react";
import capitalizeFirstLetter from "@/Shared/utils/capitalizeFirstLetter";
import Table from "@/Shared/Table";

const CompanyForm = ({
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
                    id="industry"
                    placeholder="Industry"
                    value={data.industry}
                    onChange={(e) => setData("industry", e.target.value)}
                    required
                    color={errors.industry ? "failure" : null}
                    helperText={errors.industry ?? null}
                    autoComplete="off"
                />
            </div>
            <div className="w-full">
                <TextInput
                    id="website"
                    placeholder="Website"
                    value={data.website}
                    onChange={(e) => setData("website", e.target.value)}
                    required
                    color={errors.website ? "failure" : null}
                    helperText={errors.website ?? null}
                    autoComplete="off"
                />
            </div>
            <div className="w-full flex flex-col gap-2">
                <div className="w-full grid grid-cols-2 gap-2">
                    <TextInput
                        id="street_address"
                        placeholder="Street Address"
                        value={data.street_address}
                        onChange={(e) =>
                            setData("street_address", e.target.value)
                        }
                        required
                        color={errors.street_address ? "failure" : null}
                        helperText={errors.street_address ?? null}
                        autoComplete="off"
                    />
                    <TextInput
                        id="city"
                        placeholder="City"
                        value={data.city}
                        onChange={(e) => setData("city", e.target.value)}
                        required
                        color={errors.city ? "failure" : null}
                        helperText={errors.city ?? null}
                        autoComplete="off"
                    />
                </div>
                <div className="w-full grid grid-cols-2 gap-2">
                    <TextInput
                        id="state"
                        placeholder="State"
                        value={data.state}
                        onChange={(e) => setData("state", e.target.value)}
                        required
                        color={errors.state ? "failure" : null}
                        helperText={errors.state ?? null}
                        autoComplete="off"
                    />
                    <TextInput
                        id="zip_code"
                        placeholder="Zip Code"
                        value={data.zip_code}
                        onChange={(e) => setData("zip_code", e.target.value)}
                        required
                        color={errors.zip_code ? "failure" : null}
                        helperText={errors.zip_code ?? null}
                        autoComplete="off"
                    />
                </div>
            </div>
            <div>
                <Button
                    type="submit"
                    disabled={processing ?? false}
                    color="blue"
                >
                    {processing && <Spinner size="sm" />}
                    <span className={processing ? "ml-2" : ""}>
                        {processing ? "Loading" : "Add Company"}
                    </span>
                </Button>
            </div>
        </form>
    );
};

const Companies = ({ pagination }) => {
    return (
        <>
            <TableActions
                searchRoute={"companies.index"}
                resourceType={"Companies"}
                storeRoute={"companies.store"}
                ResourceForm={CompanyForm}
                resourceInfo={[
                    ["name", ""],
                    ["website", ""],
                    ["industry", ""],
                    ["street_address", ""],
                    ["city", ""],
                    ["state", ""],
                    ["zip_code", ""],
                    ["description", ""],
                ]}
            />
            <Table
                data={pagination.data.map(company => {
                    return {
                        ...company,
                        street_address: company.address.street_address,
                        city: company.address.city,
                        state: company.address.state,
                        zip_code: company.address.zip_code,
                    }
                })}
                columns={[
                    { header: "Name", key: "name" },
                    { header: "Website", key: "website" },
                    { header: "Industry", key: "industry" },
                    { header: "Address", key: "address_full" },
                ]}
                resourceName={"companies"}
                EditResourceForm={CompanyForm}
                resourceInfoKeys={[
                    "name",
                    "website",
                    "industry",
                    "address_id",
                    "description",
                    "street_address",
                    "city",
                    "state",
                    "zip_code",
                ]}
            />
            <TablePagination pagination={pagination.links} />
        </>
    );
};

Companies.layout = (page) => (
    <Layout>
        <ResouceLayout children={page} title="Companies" />
    </Layout>
);

export default Companies;
