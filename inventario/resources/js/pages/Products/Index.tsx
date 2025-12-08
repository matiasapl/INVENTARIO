import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link} from '@inertiajs/react';
import ProductController from '@/actions/App/Http/Controllers/ProductController';
interface Product {
    codigo: number;
    nombre: string;
    descripcion: string;
    stock: number;
    precio_unitario: number;
    M3_unitario: number;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ver Productos',
        href: ProductController.index().url
    },
];

export default function Index({ products }: { products: Product[] }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Ver Productos" />
            <Link href={ProductController.create().url}>
                <Button className="m-4 bg-green-500 hover:bg-green-700">Crear Producto</Button>
            </Link>
            <Table>
                <TableCaption>Lista de Productos</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Código</TableHead>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Descripción</TableHead>
                        <TableHead>Stock</TableHead>
                        <TableHead>Precio Unitario</TableHead>
                        <TableHead>M3 Unitario</TableHead>
                        <TableHead>Acciones</TableHead>
                    </TableRow>
                </TableHeader>
                {products.length > 0 && (
                    <TableBody>
                        {products.map((product) => (
                            <TableRow key={product.codigo}>
                                <TableCell>{product.codigo}</TableCell>
                                <TableCell>{product.nombre}</TableCell>
                                <TableCell>{product.descripcion}</TableCell>
                                <TableCell>{product.stock}</TableCell>
                                <TableCell>{product.precio_unitario}</TableCell>
                                <TableCell>{product.M3_unitario}</TableCell>
                                <TableCell>
                                    <button className="btn btn-primary">
                                        Editar
                                    </button>
                                    <button className="btn btn-danger">
                                        Eliminar
                                    </button>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                )}
            </Table>
        </AppLayout>
    );
}
