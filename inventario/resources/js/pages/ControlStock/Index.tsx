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
    accion: string;
    tipo: string;
    responsable: string;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Control Stock',
        href: ControlStockController.index().url,
    },
];

export default function Index({ Historial }: { Historial: any }) {


    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Control Stock" />

            <nav className="flex-row">
                <Link href={ControlStockController.create().url}>
                    <Button className="m-4 bg-green-500 hover:bg-green-700">
                        <CirclePlus />
                        Actualizar Stock
                    </Button>
                </Link>
            </nav>
            {/* Paginación */}
            <div className="pagination mt-4 flex justify-center gap-2">
                {Historial.links.map((link: any, index: number) => (
                    <a
                        key={index}
                        href={link.url || '#'}
                        className={`rounded border px-3 py-1 ${link.active ? 'bg-blue-500 text-white' : ''}`}
                        dangerouslySetInnerHTML={{ __html: link.label }}
                    />
                ))}
            </div>
            <Table>
                <TableCaption>Historial Stock</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Código</TableHead>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Stock Previo</TableHead>
                        <TableHead>Stock Actual</TableHead>
                        <TableHead>Accion</TableHead>
                        <TableHead>Tipo</TableHead>
                        <TableHead>Responsable</TableHead>
                    </TableRow>
                </TableHeader>
                {Historial.data.length > 0 && (
                    <TableBody>
                        {Historial.data.map((historial: any) => (
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
                                <TableCell>{historial.accion}</TableCell>
                                <TableCell>{historial.tipo}</TableCell>
                                <TableCell>{historial.responsable}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                )}
            </Table>
            {/* Paginación */}
            <div className="pagination mt-4 flex justify-center gap-2">
                {Historial.links.map((link: any, index: number) => (
                    <a
                        key={index}
                        href={link.url || '#'}
                        className={`rounded border px-3 py-1 ${link.active ? 'bg-blue-500 text-white' : ''}`}
                        dangerouslySetInnerHTML={{ __html: link.label }}
                    />
                ))}
            </div>
        </AppLayout>
    );
}
