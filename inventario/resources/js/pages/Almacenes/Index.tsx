import AlmacenController from '@/actions/App/Http/Controllers/AlmacenController';
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
    PencilLine,
    Trash2,
    Warehouse,
} from 'lucide-react';
import { useState } from 'react';
interface Almacen {
    id: number;
    codigo: string;
    nombre: string;
    descripcion: string;
    ubicacion: string;
    estado: boolean;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Almacenes',
        href: AlmacenController.index().url,
    },
];

export default function Index({ Almacenes }: { Almacenes: any }) {
    const [showModal, setShowModal] = useState(false);
    const [selectedAlmacen, setSelectedAlmacen] = useState<Almacen | null>(
        null,
    );

    const openModal = (Almacenes: Almacen) => {
        setSelectedAlmacen(Almacenes);
        setShowModal(true);
    };

    const closeModal = () => {
        setSelectedAlmacen(null);
        setShowModal(false);
    };

    const confirmDisable = () => {
        if (selectedAlmacen) {
            router.get(AlmacenController.deshabilitar(selectedAlmacen).url);
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Almacenes" />
            <nav className="flex-row">
                <Link href={AlmacenController.create().url}>
                    <Button className="m-4 bg-green-500 hover:bg-green-700">
                        <Warehouse /> Crear Almacen
                    </Button>
                </Link>

                <Link href={AlmacenController.papelera().url}>
                    <Button className="m-4 bg-red-500 hover:bg-red-700">
                        <Trash2 /> Papelera
                    </Button>
                </Link>
            </nav>
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
                {Almacenes.data.length > 0 && (
                    <TableBody>
                        {Almacenes.data.map((Almacenes: any) => (
                            <TableRow key={Almacenes.codigo}>
                                <TableCell>{Almacenes.codigo}</TableCell>
                                <TableCell>
                                    {Almacenes.nombre.length > 30
                                        ? Almacenes.nombre.substring(0, 30) +
                                          '...'
                                        : Almacenes.nombre}
                                </TableCell>
                                <TableCell>
                                    <TableCell>
                                        {Almacenes.descripcion?.length > 50
                                            ? Almacenes.descripcion.substring(
                                                  0,
                                                  50,
                                              ) + '...'
                                            : (Almacenes.descripcion ??
                                              'Sin Descripcion')}
                                    </TableCell>
                                </TableCell>
                                <TableCell>{Almacenes.ubicacion}</TableCell>
                                <TableCell>
                                    {Almacenes.estado == true
                                        ? 'Activo'
                                        : 'Inactivo'}
                                </TableCell>
                                <TableCell className="flex-row space-x-2">
                                    <Link
                                        href={
                                            AlmacenController.view(Almacenes.id)
                                                .url
                                        }
                                    >
                                        <Button className="bg-yellow-500 hover:bg-yellow-700">
                                            <Eye />
                                        </Button>
                                    </Link>
                                    <Link
                                        href={
                                            AlmacenController.edit(Almacenes.id)
                                                .url
                                        }
                                    >
                                        <Button className="bg-orange-500 hover:bg-orange-700">
                                            <PencilLine />
                                        </Button>
                                    </Link>
                                    <Button
                                        className="bg-red-500 hover:bg-red-700"
                                        onClick={() => openModal(Almacenes)}
                                    >
                                        <Trash2 />
                                    </Button>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                )}
            </Table>

            {showModal && selectedAlmacen && (
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
                                <strong>{selectedAlmacen.nombre}</strong> a la
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
