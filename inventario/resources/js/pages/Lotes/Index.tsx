import LotesController from '@/actions/App/Http/Controllers/LotesController';
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
        title: 'Lotes',
        href: LotesController.index().url,
    },
];

export default function Index() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Lotes" />

            <Table>
                <TableCaption>Lotes</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Código</TableHead>
                        <TableHead>Descripción</TableHead>
                        <TableHead>Producto</TableHead>
                        <TableHead>Cantidad</TableHead>
                        <TableHead>Almacen</TableHead>
                        <TableHead>Estado</TableHead>
                        <TableHead>Acciones</TableHead>
                    </TableRow>
                </TableHeader>
            </Table>
        </AppLayout>
    );
}
