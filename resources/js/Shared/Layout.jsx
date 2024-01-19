import { useState } from "react";
import Navbar from "./Navbar";
import Sidebar from "./Sidebar";
import Alert from "./Alert";

const Layout = ({ children }) => {
    const [sidebarOpen, setSidebarOpen] = useState(true);

    const toggleSidebar = () => {
        setSidebarOpen(!sidebarOpen);

        const contentElement = document.getElementById("content");
        if (!sidebarOpen) {
            contentElement.style.paddingLeft = "";
        } else {
            contentElement.style.paddingLeft = "17rem";
        }
    };

    return (
        <div>
            <Alert />
            <Navbar toggleSidebar={toggleSidebar} />
            <Sidebar sidebarOpen={sidebarOpen} />
            <div id="content" className="pt-20 sm:pl-20 pl-5 truncate">
                {children}
            </div>
        </div>
    );
};

export default Layout;
