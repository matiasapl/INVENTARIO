import ControlStockController from '@/actions/App/Http/Controllers/ControlStockController';
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import RegistroController from '@/actions/App/Http/Controllers/RegistroController';
import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';

import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import {
    Blocks,
    Boxes,
    LayoutDashboard,
    Logs,
    Package,
    Warehouse,
} from 'lucide-react';
import AppLogo from './app-logo';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutDashboard,
    },
    {
        title: 'Productos',
        href: ProductController.index().url,
        icon: Package,
    },
    {
        title: 'Almacenes',
        href: ControlStockController.index().url,
        icon: Warehouse,
    },
    {
        title: 'Lotes',
        href: ControlStockController.index().url,
        icon: Boxes,
    },
    {
        title: 'Control Stock',
        href: ControlStockController.index().url,
        icon: Blocks,
    },
    {
        title: 'Registros',
        href: RegistroController.index().url,
        icon: Logs,
    },
];

const footerNavItems: NavItem[] = [];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
