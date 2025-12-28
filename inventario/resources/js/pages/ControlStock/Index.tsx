import ControlStockController from '@/actions/App/Http/Controllers/ControlStockController';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/react';
import { CirclePlus } from 'lucide-react';

interface ControlStock {
    id: number;
    codigo: number;
    nombre: string;
    stock_previo: number;
    stock_actual: number;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Control Stock',
        href: ControlStockController.index().url,
    },
];

export default function Index({ Historial }: { Historial: ControlStock[] }) {


    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Ver Productos" />
            <nav className="flex-row">
                <Link href={ControlStockController.create().url}>
                    <Button className="m-4 bg-green-500 hover:bg-green-700">
                        <CirclePlus />
                        Actualizar Stock
                    </Button>
                </Link>
            </nav>

            <Table>
                <TableCaption>Historial Stock</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Código</TableHead>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Stock Previo</TableHead>
                        <TableHead>Stock Actual</TableHead>
                    </TableRow>
                </TableHeader>
                {Historial.length > 0 && (
                    <TableBody>
                        {Historial.map((historial) => (
                            <TableRow key={historial.codigo}>
                                <TableCell>{historial.codigo}</TableCell>
                                <TableCell>
                                    {historial.nombre.length > 30
                                        ? historial.nombre.substring(0, 30) +
                                          '...'
                                        : historial.nombre}
                                </TableCell>
                                <TableCell>{historial.stock_previo}</TableCell>
                                <TableCell>{historial.stock_actual}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                )}
            </Table>
        </AppLayout>
    );
}
