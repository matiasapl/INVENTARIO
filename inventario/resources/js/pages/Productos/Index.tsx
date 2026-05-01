import ProductController from '@/actions/App/Http/Controllers/ProductController';
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
import {
    CircleCheck,
    CircleX,
    Eye,
    PackagePlus,
    PencilLine,
    Trash2,
} from 'lucide-react';
import { useState } from 'react';

interface Product {
    id: number;
    codigo: number;
    nombre: string;
    descripcion: string;
    precio_unitario: number;
    M3_unitario: number;
    estado: boolean;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Productos',
        href: ProductController.index().url,
    },
];

export default function Index({ products }: { products: any }) {
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

    const confirmDisable = () => {
        if (selectedProduct) {
            router.get(ProductController.deshabilitar(selectedProduct).url);
        }
    };

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

            <div className="pagination mx-4 flex justify-center gap-2">
                {products.links.map((link: any, index: number) => (
                    <a
                        key={index}
                        href={link.url || '#'}
                        className={`rounded border px-3 py-1 ${link.active ? 'bg-blue-500 text-white' : ''}`}
                        dangerouslySetInnerHTML={{ __html: link.label }}
                    />
                ))}
            </div>
            <Table>
                <TableCaption>Lista de Productos</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Código</TableHead>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Descripción</TableHead>
                        <TableHead>Precio Unitario</TableHead>
                        <TableHead>M3 Unitario</TableHead>
                        <TableHead>Estado</TableHead>
                        <TableHead>Acciones</TableHead>
                    </TableRow>
                </TableHeader>
                {products.data.length > 0 && (
                    <TableBody>
                        {products.data.map((product: any) => (
                            <TableRow key={product.codigo}>
                                <TableCell>{product.codigo}</TableCell>
                                <TableCell>
                                    {product.nombre.length > 30
                                        ? product.nombre.substring(0, 30) +
                                          '...'
                                        : product.nombre}
                                </TableCell>
                                <TableCell>
                                    <TableCell>
                                        {product.descripcion?.length > 50
                                            ? product.descripcion.substring(
                                                  0,
                                                  50,
                                              ) + '...'
                                            : (product.descripcion ??
                                              'Sin Descripcion')}
                                    </TableCell>
                                </TableCell>
                                <TableCell>{product.precio_unitario}</TableCell>
                                <TableCell>{product.M3_unitario}</TableCell>
                                <TableCell>
                                    {product.estado == true
                                        ? 'Activo'
                                        : 'Inactivo'}
                                </TableCell>
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
                                    <Button
                                        className="bg-red-500 hover:bg-red-700"
                                        onClick={() => openModal(product)}
                                    >
                                        <Trash2 />
                                    </Button>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                )}
            </Table>
            {/* Modal de confirmación */}
            {showModal && selectedProduct && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                    <div className="relative w-full max-w-sm rounded-lg bg-white p-6 shadow-lg dark:bg-slate-900">
                        <button
                            onClick={closeModal}
                            className="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
                        >
                            <CircleX />
                        </button>

                        <div className="text-center">
                            <h3 className="my-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                ¿Seguro que quieres enviar{' '}
                                <strong>{selectedProduct.nombre}</strong> a la
                                papelera?
                            </h3>
                            <div className="flex justify-center gap-4">
                                <Button variant="outline" onClick={closeModal}>
                                    <CircleX /> Cancelar
                                </Button>
                                <Button
                                    className="bg-red-600 hover:bg-red-700"
                                    onClick={confirmDisable}
                                >
                                    <CircleCheck /> Sí, eliminar
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </AppLayout>
    );
}
