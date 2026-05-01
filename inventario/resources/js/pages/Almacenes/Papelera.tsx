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
import { ArrowBigLeft, CircleCheck, CircleX, RotateCcw } from 'lucide-react';
import { useState } from 'react'; // 1. Importar useState
interface Almacen {
    id: number;
    codigo: number;
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
    {
        title: 'Papelera de Almacenes',
        href: '#',
    },
];

export default function Index({ Almacenes }: { Almacenes: Almacen[] }) {
    // 2. Definir estados para el modal
    const [showModal, setShowModal] = useState(false);
    const [selectedAlmacen, setSelectedAlmacen] = useState<Almacen | null>(
        null,
    );

    const openModal = (Almacen: Almacen) => {
        setSelectedAlmacen(Almacen);
        setShowModal(true);
    };

    const closeModal = () => {
        setSelectedAlmacen(null);
        setShowModal(false);
    };

    // 3. Función de eliminación definitiva
    const confirmDelete = () => {
        if (selectedAlmacen) {
            router.delete(AlmacenController.eliminar(selectedAlmacen.id).url, {
                onSuccess: () => closeModal(),
            });
        }
    };
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Papelera de Almacenes" />
            <nav className="flex-row">
                <Link href={AlmacenController.index().url}>
                    <Button className="m-4 bg-green-500 hover:bg-green-700">
                        <ArrowBigLeft /> Volver
                    </Button>
                </Link>
            </nav>

            <Table>
                <TableCaption>Papelera de Almacenes</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Codigo</TableHead>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Descripción</TableHead>
                        <TableHead>ubicacion</TableHead>
                    </TableRow>
                </TableHeader>
                {Almacenes.length > 0 && (
                    <TableBody>
                        {Almacenes.map((Almacen) => (
                            <TableRow key={Almacen.codigo}>
                                <TableCell>{Almacen.codigo}</TableCell>
                                <TableCell>
                                    {Almacen.nombre
                                        ? Almacen.nombre.length > 30
                                            ? Almacen.nombre.substring(0, 30) +
                                              '...'
                                            : Almacen.nombre
                                        : ''}
                                </TableCell>

                                <TableCell>
                                    {Almacen.descripcion?.length > 50
                                        ? Almacen.descripcion.substring(0, 50) +
                                          '...'
                                        : (Almacen.descripcion ??
                                          'Sin Descripcion')}
                                </TableCell>
                                <TableCell>{Almacen.ubicacion}</TableCell>
                                <TableCell className="flex-row space-x-2">
                                    <Link
                                        href={
                                            AlmacenController.habilitar(
                                                Almacen.id,
                                            ).url
                                        }
                                    >
                                        <Button className="bg-green-500 hover:bg-green-700">
                                            <RotateCcw />
                                        </Button>
                                    </Link>

                                    <Button
                                        className="bg-red-500 hover:bg-red-700"
                                        onClick={() => openModal(Almacen)}
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
            {showModal && selectedAlmacen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                    <div className="relative w-full max-w-sm rounded-lg bg-white p-6 shadow-lg dark:bg-slate-900">
                        <div className="text-center">
                            <h3 className="mb-5 text-lg font-normal text-gray-500">
                                ¿Estás seguro de eliminar{' '}
                                <strong>definitivamente</strong> el producto{' '}
                                {selectedAlmacen.nombre}?
                                <br />
                                <span className="text-sm text-red-400">
                                    Esta acción no se puede deshacer.
                                </span>
                            </h3>
                            <div className="flex justify-center gap-4">
                                <Button variant="outline" onClick={closeModal}>
                                    <CircleX />
                                    Cancelar
                                </Button>
                                <Button
                                    className="bg-red-600 hover:bg-red-800"
                                    onClick={confirmDelete}
                                >
                                    <CircleCheck /> Eliminar para siempre
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </AppLayout>
    );
}
