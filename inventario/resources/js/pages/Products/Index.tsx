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
import { Head, Link } from '@inertiajs/react';
import { Trash2, PencilLine, Eye, PackagePlus } from 'lucide-react';
import ProductController from '@/actions/App/Http/Controllers/ProductController';
interface Product {
    id: number;
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
            <nav className="flex-row">
                <Link href={ProductController.create().url}>
                    <Button className="m-4 bg-green-500 hover:bg-green-700">
                        <PackagePlus /> Crear Producto
                    </Button>
                </Link>
                <Link href={ProductController.papelera().url}>
                    <Button className="m-4 bg-red-500 hover:bg-red-700">
                        <Trash2 /> Papelera
                    </Button>
                </Link>
            </nav>

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
                                <TableCell>
                                    {product.nombre
                                        ? product.nombre.length > 30
                                            ? product.nombre.substring(0, 30) +
                                              '...'
                                            : product.nombre
                                        : ''}
                                </TableCell>

                                <TableCell>
                                    {product.descripcion
                                        ? product.descripcion.length > 50
                                            ? product.descripcion.substring(
                                                  0,
                                                  50,
                                              ) + '...'
                                            : product.descripcion
                                        : ''}
                                </TableCell>

                                <TableCell>{product.stock}</TableCell>
                                <TableCell>{product.precio_unitario}</TableCell>
                                <TableCell>{product.M3_unitario}</TableCell>
                                <TableCell className="flex-row space-x-2">
                                    <Link
                                        href={
                                            ProductController.view(product.id)
                                                .url
                                        }
                                    >
                                        <Button className="bg-yellow-500 hover:bg-yellow-700">
                                            <Eye />
                                        </Button>
                                    </Link>
                                    <Link
                                        href={
                                            ProductController.edit(product.id)
                                                .url
                                        }
                                    >
                                        <Button className="bg-orange-500 hover:bg-orange-700">
                                            <PencilLine />
                                        </Button>
                                    </Link>

                                    <Link
                                        href={
                                            ProductController.deshabilitar(
                                                product.id,
                                            ).url
                                        }
                                    >
                                        <Button className="bg-red-500 hover:bg-red-700">
                                            <Trash2 />
                                        </Button>
                                    </Link>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                )}
            </Table>
        </AppLayout>
    );
}
