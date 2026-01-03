import ProductController from '@/actions/App/Http/Controllers/ProductController';
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
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

interface Product {
    id: number;
    codigo: number;
    nombre: string;
    descripcion: string;
    stock: number;
    valor_total: number;
    m3_total: number;
    created_at: Date;
    updated_at: Date;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

export default function Dashboard({ products }: { products: Product[] }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <Table>
                <TableCaption>Dashboard</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Código</TableHead>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Descripción</TableHead>
                        <TableHead>Stock</TableHead>
                        <TableHead>Valor Total</TableHead>
                        <TableHead>M3 Total</TableHead>
                        <TableHead>Creacion</TableHead>
                        <TableHead>Ultima Actualizacion</TableHead>
                    </TableRow>
                </TableHeader>
                {products.length > 0 && (
                    <TableBody>
                        {products.map((product) => (
                            <TableRow key={product.codigo}>
                                <TableCell>{product.codigo}</TableCell>
                                <TableCell>
                                    {product.nombre.length > 30
                                        ? product.nombre.substring(0, 30) +
                                          '...'
                                        : product.nombre}
                                </TableCell>
                                <TableCell>
                                    {product.descripcion?.length > 50
                                        ? product.descripcion.substring(0, 50) +
                                          '...'
                                        : (product.descripcion ??
                                          'Sin Descripcion')}
                                </TableCell>
                                <TableCell>{product.stock}</TableCell>
                                <TableCell>{product.valor_total}</TableCell>
                                <TableCell>{product.m3_total}</TableCell>
                                <TableCell>
                                    {new Date(
                                        product.created_at,
                                    ).toLocaleString('es-MX')}
                                </TableCell>
                                <TableCell>
                                    {new Date(
                                        product.updated_at,
                                    ).toLocaleString('es-MX')}
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                )}
            </Table>
        </AppLayout>
    );
}
