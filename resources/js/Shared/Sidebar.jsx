import React, { useState, useEffect } from 'react';
import { Sidebar as SidebarComponent, Dropdown } from 'flowbite-react';
import { HiArrowSmRight, HiChartPie, HiInbox, HiShoppingBag, HiTable, HiUser, HiViewBoards } from 'react-icons/hi';
import { Link } from '@inertiajs/react';

const Sidebar = ({ sidebarOpen }) => {
    const [collapseBehavior, setCollapseBehavior] = useState(window.innerWidth < 1024 ? 'hide' : 'collapsed');

    useEffect(() => {
        const handleResize = () => {
            setCollapseBehavior(window.innerWidth < 1024 ? 'hide' : 'collapsed');
        };

        window.addEventListener('resize', handleResize);

        // Cleanup function to remove the event listener when the component unmounts
        return () => window.removeEventListener('resize', handleResize);
    }, []); // Empty dependency array means this effect runs once on mount and cleanup on unmount

    return (
        <div className='fixed left-0 top-0 h-full z-30'>
            <SidebarComponent theme={{ root: { inner: 'h-full overflow-y-auto pt-16 overflow-x-hidden rounded bg-white py-4 px-3 dark:bg-gray-800'}}} collapsed={sidebarOpen} collapseBehavior={collapseBehavior} aria-label="Default sidebar example">
                <SidebarComponent.Items>
                    <SidebarComponent.ItemGroup>
                        <SidebarComponent.Item as={Link} href={route('dashboard')} icon={HiChartPie}>
                            Dashboard
                        </SidebarComponent.Item>
                        <SidebarComponent.Item as={Link} href={route('members.index')} icon={HiViewBoards}>
                            Members
                        </SidebarComponent.Item>
                        <SidebarComponent.Item as={Link} href={route('contacts.index')} icon={HiInbox}>
                            Contacts
                        </SidebarComponent.Item>
                        <SidebarComponent.Item as={Link} href={route('companies.index')} icon={HiUser}>
                            Companies
                        </SidebarComponent.Item>
                        <SidebarComponent.Item as={Link} href={route('leads.index')} icon={HiShoppingBag}>
                            Leads
                        </SidebarComponent.Item>
                        <SidebarComponent.Item as={Link} href={route('deals.index')} icon={HiArrowSmRight}>
                            Deals
                        </SidebarComponent.Item>
                        <SidebarComponent.Item as={Link} href={route('activities.index')} icon={HiTable}>
                            Activities
                        </SidebarComponent.Item>
                    </SidebarComponent.ItemGroup>
                </SidebarComponent.Items>
            </SidebarComponent>
        </div>
    );
};

export default Sidebar;
