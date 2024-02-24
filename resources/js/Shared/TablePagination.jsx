import { Link } from "@inertiajs/react";
import { Button } from "flowbite-react";

const TablePagination = ({ pagination }) => {
    return (
        <>
            <div className="flex justify-end overflow-x-auto py-5">
                <div className="inline-flex mt-2 xs:mt-0 gap-2 mx-1">
                    <Button
                        color="light"
                        className={
                            !pagination.prev
                                ? "pointer-events-none"
                                : null
                        }
                        as={Link}
                        href={pagination.prev}
                        preserveScroll
                        disabled={!pagination.prev}
                        preserveState
                    >
                        Prev
                    </Button>
                    <Button
                        color="light"
                        className={
                            !pagination.next
                                ? "pointer-events-none"
                                : null
                        }
                        as={Link}
                        href={pagination.next}
                        preserveScroll
                        disabled={!pagination.next}
                        preserveState
                    >
                        Next
                    </Button>
                </div>
            </div>
        </>
    );
};

export default TablePagination;
