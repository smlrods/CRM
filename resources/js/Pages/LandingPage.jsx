import { Head, Link, usePage } from "@inertiajs/react";
import { Button, Navbar } from "flowbite-react";

function NavbarLP() {
    const { user } = usePage().props.auth;

    return (
        <Navbar
            fluid
            rounded
            border
            theme={{
                root: {
                    inner: {
                        base: "mx-auto flex flex-wrap items-center justify-between max-w-screen-xl",
                    },
                },
            }}
        >
            <Navbar.Brand href="/">
                <span className="self-center whitespace-nowrap text-xl font-semibold dark:text-white">
                    CRM
                </span>
            </Navbar.Brand>
            <div className="flex md:order-2 items-center gap-3">
                {user ? (
                    <Link href="/dashboard">
                        <Button color="blue">Dashboard</Button>
                    </Link>
                ) : (
                    <>
                        <Link href="/login">Log in</Link>
                        <Link href="/register">
                            <Button color="blue">Get started</Button>
                        </Link>
                    </>
                )}
                <Navbar.Toggle />
            </div>
            <Navbar.Collapse>
                <Navbar.Link href="#home">Home</Navbar.Link>
                <Navbar.Link href="#features">Features</Navbar.Link>
                <Navbar.Link href="#pricing">Pricing</Navbar.Link>
                <Navbar.Link href="#faq">F.A.Q</Navbar.Link>
            </Navbar.Collapse>
        </Navbar>
    );
}

function HeroSection() {
    const { user } = usePage().props.auth;

    return (
        <>
            <section
                id="home"
                className="bg-white dark:bg-gray-900 sm:min-h-screen"
            >
                <div className="py-8 px-4 mx-auto max-w-screen-xl text-center min-h-[50vh] flex flex-col justify-center lg:py-16">
                    <h1 className="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                        Streamline Your Business with Powerful CRM
                    </h1>
                    <p className="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400">
                        Organize your contacts, manage deals, and boost your
                        team collaboration.
                    </p>
                    {user ? (
                        <div>
                            <Button
                                className="inline-block w-full sm:w-auto"
                                href="/dashboard"
                                as={Link}
                                color="blue"
                            >
                                Go to Dashboard
                            </Button>
                        </div>
                    ) : (
                        <div className="flex justify-center w-full">
                            <Button href="/register" as={Link} color="blue">
                                Get started
                            </Button>
                        </div>
                    )}
                </div>
                <div className="sm:flex justify-center hidden pb-10">
                    <img
                        src="/images/dashboard_screen.png"
                        className="max-w-5xl w-full shadow-xl -mt-10"
                        alt="crm image"
                    />
                </div>
            </section>
        </>
    );
}

function FeaturesSection() {
    return (
        <>
            <h2 className="text-4xl px-2 font-bold dark:text-white text-center pt-10">
                Unleash the Power of CRM's Features
            </h2>
            <section id="features" className="dark:bg-gray-800">
                <div className="flex flex-col items-center sm:flex-row gap-5 justify-center py-16">
                    <div className="max-w-sm p-6 rounded-lg text-center flex flex-col items-center gap-3">
                        <svg
                            className="w-10 h-10 text-gray-800 dark:text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 19"
                        >
                            <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                            <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                        </svg>

                        <h5 className="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Organize your world
                        </h5>
                        <p className="font-normal text-gray-700 dark:text-gray-400">
                            Create and manage organizations, invite team
                            members, and assign roles with predefined
                            permissions.
                        </p>
                    </div>

                    <div className="max-w-sm p-6 rounded-lg text-center flex flex-col items-center gap-3">
                        <svg
                            className="w-10 h-10 text-gray-800 dark:text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 18 20"
                        >
                            <path d="M16 0H4a2 2 0 0 0-2 2v1H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v2H1a1 1 0 0 0 0 2h1v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4.5a3 3 0 1 1 0 6 3 3 0 0 1 0-6ZM13.929 17H7.071a.5.5 0 0 1-.5-.5 3.935 3.935 0 1 1 7.858 0 .5.5 0 0 1-.5.5Z" />
                        </svg>

                        <h5 className="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Centralized contact management
                        </h5>
                        <p className="font-normal text-gray-700 dark:text-gray-400">
                            Create, view, update, and delete contacts, keeping
                            all your customer information organized in one
                            place.
                        </p>
                    </div>

                    <div className="max-w-sm p-6 rounded-lg dark:bg-gray-80 text-center flex flex-col items-center gap-3">
                        <svg
                            className="w-10 h-10 text-gray-800 dark:text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 14"
                        >
                            <path d="M18 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM2 6h7v6H2V6Zm9 6V6h7v6h-7Z" />
                        </svg>

                        <h5 className="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Streamline your sales pipeline
                        </h5>
                        <p className="font-normal text-gray-700 dark:text-gray-400">
                            Manage companies, leads, deals, and activities,
                            gaining a clear overview of your sales process.
                        </p>
                    </div>
                </div>
            </section>
        </>
    );
}

import { Card } from "flowbite-react";

function PricingCard() {
    return (
        <div id="pricing" className="px-2">
            <Card className="max-w-sm">
                <h5 className="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">
                    Free plan
                </h5>
                <div className="flex items-baseline text-gray-900 dark:text-white">
                    <span className="text-3xl font-semibold">$</span>
                    <span className="text-5xl font-extrabold tracking-tight">
                        0
                    </span>
                </div>
                <ul className="my-7 space-y-5">
                    <li className="flex space-x-3">
                        <svg
                            className="h-5 w-5 shrink-0 text-cyan-600 dark:text-cyan-500"
                            fill="blue"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fillRule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clipRule="evenodd"
                            />
                        </svg>
                        <span className="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">
                            5 team members
                        </span>
                    </li>
                    <li className="flex space-x-3">
                        <svg
                            className="h-5 w-5 shrink-0 text-cyan-600 dark:text-cyan-500"
                            fill="blue"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fillRule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clipRule="evenodd"
                            />
                        </svg>
                        <span className="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">
                            20GB Cloud storage
                        </span>
                    </li>
                    <li className="flex space-x-3">
                        <svg
                            className="h-5 w-5 shrink-0 text-cyan-600 dark:text-cyan-500"
                            fill="blue"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fillRule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clipRule="evenodd"
                            />
                        </svg>
                        <span className="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">
                            Integration help
                        </span>
                    </li>
                    <li className="flex space-x-3 line-through decoration-gray-500">
                        <svg
                            className="h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fillRule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clipRule="evenodd"
                            />
                        </svg>
                        <span className="text-base font-normal leading-tight text-gray-500">
                            Sketch Files
                        </span>
                    </li>
                    <li className="flex space-x-3 line-through decoration-gray-500">
                        <svg
                            className="h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fillRule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clipRule="evenodd"
                            />
                        </svg>
                        <span className="text-base font-normal leading-tight text-gray-500">
                            API Access
                        </span>
                    </li>
                    <li className="flex space-x-3 line-through decoration-gray-500">
                        <svg
                            className="h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fillRule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clipRule="evenodd"
                            />
                        </svg>
                        <span className="text-base font-normal leading-tight text-gray-500">
                            Complete documentation
                        </span>
                    </li>
                    <li className="flex space-x-3 line-through decoration-gray-500">
                        <svg
                            className="h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fillRule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clipRule="evenodd"
                            />
                        </svg>
                        <span className="text-base font-normal leading-tight text-gray-500">
                            24×7 phone & email support
                        </span>
                    </li>
                </ul>
                <Button type="button" color="blue">
                    Choose plan
                </Button>
            </Card>
        </div>
    );
}

function PricingSection() {
    return (
        <>
            <div className="flex justify-center items-center min-[200px] bg-white py-10">
                <PricingCard />
            </div>
        </>
    );
}

function FaqSection() {
    return (
        <>
            <section
                id="faq"
                className="flex flex-col justify-center items-center gap-5 px-3 py-12"
            >
                <h2 className="text-4xl font-semibold dark:text-white text-center">
                    Frequently Asked Questions
                </h2>
                <p className="text-gray-400 sm:w-[45%] text-center">
                    we’re here to help you get started, migrate your existing
                    data, and answer questions with chat, email or phone. we
                    protect your information with full database encryption and
                    automatic backups.
                </p>
                <div className="max-w-2xl w-full">
                    <div
                        className="flex flex-col gap-3"
                        id="accordion-collapse"
                        data-accordion="collapse"
                    >
                        <div>
                            <h2 id="accordion-collapse-heading-1">
                                <button
                                    type="button"
                                    className="flex items-center justify-between w-full px-4 py-3 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                    data-accordion-target="#accordion-collapse-body-1"
                                    aria-expanded="true"
                                    aria-controls="accordion-collapse-body-1"
                                >
                                    <span className="w-full">
                                        What is CRM and why do I need it?
                                    </span>
                                    <svg
                                        data-accordion-icon
                                        className="w-3 h-3 rotate-180 shrink-0"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 10 6"
                                    >
                                        <path
                                            stroke="currentColor"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M9 5 5 1 1 5"
                                        />
                                    </svg>
                                </button>
                            </h2>
                            <div
                                id="accordion-collapse-body-1"
                                className="hidden"
                                aria-labelledby="accordion-collapse-heading-1"
                            >
                                <div className="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                    <p className="mb-2 text-gray-500 dark:text-gray-400">
                                        CRM, or customer relationship
                                        management, is a system that helps
                                        businesses manage interactions with
                                        current and potential customers. it
                                        boosts efficiency, enhances customer
                                        satisfaction, and drives growth.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2 id="accordion-collapse-heading-2">
                                <button
                                    type="button"
                                    className="flex items-center justify-between w-full px-4 py-3 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                    data-accordion-target="#accordion-collapse-body-2"
                                    aria-expanded="true"
                                    aria-controls="accordion-collapse-body-2"
                                >
                                    <span className="w-full">
                                        How can CRM benefit my business?
                                    </span>
                                    <svg
                                        data-accordion-icon
                                        className="w-3 h-3 rotate-180 shrink-0"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 10 6"
                                    >
                                        <path
                                            stroke="currentcolor"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M9 5 5 1 1 5"
                                        />
                                    </svg>
                                </button>
                            </h2>
                            <div
                                id="accordion-collapse-body-2"
                                className="hidden"
                                aria-labelledby="accordion-collapse-heading-2"
                            >
                                <div className="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                    <p className="mb-2 text-gray-500 dark:text-gray-400">
                                        CRM centralizes customer data,
                                        streamlines communication, and automates
                                        tasks. it improves customer service,
                                        increases sales, and provides valuable
                                        insights for better decision-making.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2 id="accordion-collapse-heading-3">
                                <button
                                    type="button"
                                    className="flex items-center justify-between w-full px-4 py-3 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                    data-accordion-target="#accordion-collapse-body-3"
                                    aria-expanded="true"
                                    aria-controls="accordion-collapse-body-3"
                                >
                                    <span className="w-full">
                                        Is CRM suitable for small businesses?
                                    </span>
                                    <svg
                                        data-accordion-icon
                                        className="w-3 h-3 rotate-180 shrink-0"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 10 6"
                                    >
                                        <path
                                            stroke="currentcolor"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M9 5 5 1 1 5"
                                        />
                                    </svg>
                                </button>
                            </h2>
                            <div
                                id="accordion-collapse-body-3"
                                className="hidden"
                                aria-labelledby="accordion-collapse-heading-3"
                            >
                                <div className="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                    <p className="mb-2 text-gray-500 dark:text-gray-400">
                                        Absolutely! crm systems come in various
                                        sizes and functionalities, making them
                                        adaptable to businesses of all scales.
                                        small businesses can benefit by
                                        organizing customer information,
                                        streamlining processes, and fostering
                                        stronger relationships.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2 id="accordion-collapse-heading-4">
                                <button
                                    type="button"
                                    className="flex items-center justify-between w-full px-4 py-3 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                    data-accordion-target="#accordion-collapse-body-4"
                                    aria-expanded="true"
                                    aria-controls="accordion-collapse-body-4"
                                >
                                    <span className="w-full">
                                        What features should I look for in a
                                        CRM?
                                    </span>
                                    <svg
                                        data-accordion-icon
                                        className="w-3 h-3 rotate-180 shrink-0"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 10 6"
                                    >
                                        <path
                                            stroke="currentcolor"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M9 5 5 1 1 5"
                                        />
                                    </svg>
                                </button>
                            </h2>
                            <div
                                id="accordion-collapse-body-4"
                                className="hidden"
                                aria-labelledby="accordion-collapse-heading-4"
                            >
                                <div className="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                    <p className="mb-2 text-gray-500 dark:text-gray-400">
                                        Look for features like contact
                                        management, lead tracking, email
                                        integration, and analytics.
                                        customization options, scalability, and
                                        ease of use are also crucial. for
                                        example, a crm that integrates with
                                        popular email platforms like gmail or
                                        outlook can streamline communication.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2 id="accordion-collapse-heading-5">
                                <button
                                    type="button"
                                    className="flex items-center justify-between w-full px-4 py-3 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                    data-accordion-target="#accordion-collapse-body-5"
                                    aria-expanded="true"
                                    aria-controls="accordion-collapse-body-5"
                                >
                                    <span className="w-full">
                                        How does CRM enhance customer
                                        communication?
                                    </span>
                                    <svg
                                        data-accordion-icon
                                        className="w-3 h-3 rotate-180 shrink-0"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 10 6"
                                    >
                                        <path
                                            stroke="currentcolor"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M9 5 5 1 1 5"
                                        />
                                    </svg>
                                </button>
                            </h2>
                            <div
                                id="accordion-collapse-body-5"
                                className="hidden"
                                aria-labelledby="accordion-collapse-heading-5"
                            >
                                <div className="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                    <p className="mb-2 text-gray-500 dark:text-gray-400">
                                        CRM enables personalized communication
                                        by storing customer preferences and
                                        interactions. automated features like
                                        email campaigns and follow-up reminders
                                        ensure timely and relevant
                                        communication. this can lead to
                                        increased customer satisfaction and
                                        loyalty.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2 id="accordion-collapse-heading-6">
                                <button
                                    type="button"
                                    className="flex items-center justify-between w-full px-4 py-3 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                    data-accordion-target="#accordion-collapse-body-6"
                                    aria-expanded="true"
                                    aria-controls="accordion-collapse-body-6"
                                >
                                    <span className="w-full">
                                        Can CRM help with sales and revenue
                                        growth?
                                    </span>
                                    <svg
                                        data-accordion-icon
                                        className="w-3 h-3 rotate-180 shrink-0"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 10 6"
                                    >
                                        <path
                                            stroke="currentcolor"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M9 5 5 1 1 5"
                                        />
                                    </svg>
                                </button>
                            </h2>
                            <div
                                id="accordion-collapse-body-6"
                                className="hidden"
                                aria-labelledby="accordion-collapse-heading-6"
                            >
                                <div className="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                                    <p className="mb-2 text-gray-500 dark:text-gray-400">
                                        Definitely! crm systems provide a
                                        360-degree view of your sales pipeline,
                                        helping you identify opportunities and
                                        prioritize leads. by analyzing customer
                                        data, you can tailor your approach,
                                        leading to more effective sales
                                        strategies and, ultimately, revenue
                                        growth. for instance, tracking leads and
                                        their status in the crm can optimize the
                                        sales process.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

import { Footer } from "flowbite-react";

function FooterSection() {
    return (
        <Footer container>
            <Footer.Copyright
                href="https://github.com/smlrods"
                by="smlrods™"
                year={2024}
            />
            <Footer.LinkGroup>
                <Footer.Link href="#">About</Footer.Link>
                <Footer.Link href="#">Privacy Policy</Footer.Link>
                <Footer.Link href="#">Licensing</Footer.Link>
                <Footer.Link href="#">Contact</Footer.Link>
            </Footer.LinkGroup>
        </Footer>
    );
}

const LandingPage = () => {
    return (
        <>
            <Head title="Welcome" />
            <div className="">
                <NavbarLP />
                <HeroSection />
                <FeaturesSection />
                <PricingSection />
                <FaqSection />
                <FooterSection />
            </div>
        </>
    );
};

export default LandingPage;
