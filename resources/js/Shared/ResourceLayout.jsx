import { Head } from "@inertiajs/react";

const ResouceLayout = ({ children, title }) => {
    return (
        <>
            <Head title={title} />
            <div className="pr-3">
                <h1 className="text-2xl font-bold mb-5">{title}</h1>
                {children}
            </div>
        </>
    );
};

export default ResouceLayout;
