import { useState } from 'react'; // 1. Importar useState
import { router, Head, Link } from '@inertiajs/react';
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
import { CircleX, ArrowBigLeft, RotateCcw } from 'lucide-react';
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
        title: 'Papelera de Productos',
        href: ProductController.papelera().url
    },
];

export default function Index({ products }: { products: Product[] }) {
    // 2. Definir estados para el modal
    const [showModal, setShowModal] = useState(false);
    const [selectedProduct, setSelectedProduct] = useState<Product | null>(
        null,
    );

    const openModal = (product: Product) => {
        setSelectedProduct(product);
        setShowModal(true);
    };

    const closeModal = () => {
        setSelectedProduct(null);
        setShowModal(false);
    };

    // 3. Función de eliminación definitiva
    const confirmDelete = () => {
        if (selectedProduct) {
            router.delete(ProductController.eliminar(selectedProduct.id).url, {
                onSuccess: () => closeModal(),
            });
        }
    };
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Papelera de Productos" />
            <nav className="flex-row">
                <Link href={ProductController.index().url}>
                    <Button className="m-4 bg-green-500 hover:bg-green-700">
                        <ArrowBigLeft /> Volver
                    </Button>
                </Link>
            </nav>

            <Table>
                <TableCaption>Papelera de Productos</TableCaption>
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
                                    {product.descripcion?.length > 50
                                        ? product.descripcion.substring(0, 50) +
                                          '...'
                                        : (product.descripcion ??
                                          'Sin Descripcion')}
                                </TableCell>

                                <TableCell>{product.stock}</TableCell>
                                <TableCell>{product.precio_unitario}</TableCell>
                                <TableCell>{product.M3_unitario}</TableCell>
                                <TableCell className="flex-row space-x-2">
                                    <Link
                                        href={
                                            ProductController.habilitar(
                                                product.id,
                                            ).url
                                        }
                                    >
                                        <Button className="bg-green-500 hover:bg-green-700">
                                            <RotateCcw />
                                        </Button>
                                    </Link>

                                    <Button
                                        className="bg-red-500 hover:bg-red-700"
                                        onClick={() => openModal(product)}
                                    >
                                        <CircleX />
                                    </Button>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                )}
            </Table>

            {/* 5. El Modal de Confirmación */}
            {showModal && selectedProduct && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                    <div className="relative w-full max-w-sm rounded-lg bg-white p-6 shadow-lg dark:bg-slate-900">
                        <div className="text-center">
                            <h3 className="mb-5 text-lg font-normal text-gray-500">
                                ¿Estás seguro de eliminar{' '}
                                <strong>definitivamente</strong> el producto{' '}
                                {selectedProduct.nombre}?
                                <br />
                                <span className="text-sm text-red-400">
                                    Esta acción no se puede deshacer.
                                </span>
                            </h3>
                            <div className="flex justify-center gap-4">
                                <Button variant="outline" onClick={closeModal}>
                                    Cancelar
                                </Button>
                                <Button
                                    className="bg-red-600 hover:bg-red-800"
                                    onClick={confirmDelete}
                                >
                                    Eliminar para siempre
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </AppLayout>
    );
}
