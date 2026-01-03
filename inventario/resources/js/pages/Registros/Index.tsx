import RegistroController from '@/actions/App/Http/Controllers/RegistroController';
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
        title: 'Registros',
        href: RegistroController.index().url,
    },
];

export default function Index({ Registros }: { Registros: ControlStock[] }) {


    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Registros" />

            <Table>
                <TableCaption>Registros</TableCaption>
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
                {Registros.length > 0 && (
                    <TableBody>
                        {Registros.map((Registros) => (
                            <TableRow key={Registros.codigo}>
                                <TableCell>{Registros.codigo}</TableCell>
                                <TableCell>
                                    {Registros.nombre.length > 30
                                        ? Registros.nombre.substring(0, 30) +
                                          '...'
                                        : Registros.nombre}
                                </TableCell>
                                <TableCell>{Registros.stock_previo}</TableCell>
                                <TableCell>{Registros.stock_actual}</TableCell>
                                <TableCell>{Registros.accion}</TableCell>
                                <TableCell>{Registros.tipo}</TableCell>
                                <TableCell>{Registros.responsable}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                )}
            </Table>
        </AppLayout>
    );
}
