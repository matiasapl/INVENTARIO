import AlmacenController from '@/actions/App/Http/Controllers/AlmacenController';
import {
    Table,
    TableCaption,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Almacenes',
        href: AlmacenController.index().url,
    },
];

export default function Index() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Almacenes" />

            <Table>
                <TableCaption>Almacenes</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Código</TableHead>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Descripción</TableHead>
                        <TableHead>Ubicación</TableHead>
                        <TableHead>Estado</TableHead>
                        <TableHead>Acciones</TableHead>
                    </TableRow>
                </TableHeader>
            </Table>
        </AppLayout>
    );
}
