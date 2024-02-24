import { Link, useForm } from "@inertiajs/react";
import { Button, Label, TextInput } from "flowbite-react";

const Register = () => {
    const { data, setData, post, processing, errors } = useForm({
        username: "",
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        password_confirmation: "",
        remember: false,
    });

    function submit(e) {
        e.preventDefault();
        post(route("register"));
    }

    function getColorErrors(field) {
        return errors[field] ? "failure" : null;
    }

    return (
        <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form onSubmit={submit} className="flex flex-col gap-4">
                    <div>
                        <div className="mb-2 block">
                            <Label htmlFor="username" value="Username" />
                        </div>
                        <TextInput
                            id="username"
                            value={data.username}
                            onChange={(e) =>
                                setData("username", e.target.value)
                            }
                            type="text"
                            placeholder="cskiles"
                            required
                            color={getColorErrors("username")}
                            helperText={errors.username}
                        />
                    </div>
                    <div className="flex gap-2">
                        <div className="w-full">
                            <div className="mb-2 block">
                                <Label
                                    htmlFor="first_name"
                                    value="First name"
                                />
                            </div>
                            <TextInput
                                id="first_name"
                                value={data.first_name}
                                onChange={(e) =>
                                    setData("first_name", e.target.value)
                                }
                                type="text"
                                placeholder="Oren"
                                required
                                color={getColorErrors("first_name")}
                                helperText={errors.first_name}
                            />
                        </div>
                        <div className="w-full">
                            <div className="mb-2 block">
                                <Label htmlFor="last_name" value="Last name" />
                            </div>
                            <TextInput
                                id="last_name"
                                value={data.last_name}
                                onChange={(e) =>
                                    setData("last_name", e.target.value)
                                }
                                type="text"
                                placeholder="Emmerich"
                                required
                                color={getColorErrors("last_name")}
                                helperText={errors.last_name}
                            />
                        </div>
                    </div>
                    <div>
                        <div className="mb-2 block">
                            <Label htmlFor="email" value="Email" />
                        </div>
                        <TextInput
                            id="email"
                            value={data.email}
                            onChange={(e) => setData("email", e.target.value)}
                            type="email"
                            placeholder="name@example.com"
                            required
                            color={getColorErrors("email")}
                            helperText={errors.email}
                        />
                    </div>
                    <div>
                        <div className="mb-2 block">
                            <Label htmlFor="password" value="Password" />
                        </div>
                        <TextInput
                            value={data.password}
                            onChange={(e) =>
                                setData("password", e.target.value)
                            }
                            id="password"
                            type="password"
                            placeholder="********"
                            required
                            color={getColorErrors("password")}
                            helperText={errors.password}
                        />
                    </div>
                    <div>
                        <div className="mb-2 block">
                            <Label
                                htmlFor="password_confirmation"
                                value="Confirmation Password"
                            />
                        </div>
                        <TextInput
                            id="password_confirmation"
                            value={data.password_confirmation}
                            onChange={(e) =>
                                setData("password_confirmation", e.target.value)
                            }
                            type="password"
                            placeholder="********"
                            required
                        />
                    </div>
                    <div className="flex w-full justify-end items-center gap-3">
                        <Link
                            href="/login"
                            className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Already registered?
                        </Link>
                        <Button
                            typeof="submit"
                            disabled={processing}
                            color="blue"
                            type="submit"
                        >
                            Submit
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default Register;
