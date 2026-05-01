import LotesController from '@/actions/App/Http/Controllers/LotesController';
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

interface Lote {
    id: number;
    codigo: string;
    descripcion: string;
    producto: string;
    cantidad: string;
    almacen: string;
    estado: boolean;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lotes',
        href: LotesController.index().url,
    },
    {
        title: 'Papelera',
        href: '#',
    },
];

export default function Index({ Lotes }: { Lotes: any }) {
    // 2. Definir estados para el modal
    const [showModal, setShowModal] = useState(false);
    const [selectedLote, setSelectedLote] = useState<Lote | null>(null);

    const openModal = (Lote: Lote) => {
        setSelectedLote(Lote);
        setShowModal(true);
    };

    const closeModal = () => {
        setSelectedLote(null);
        setShowModal(false);
    };

    // 3. Función de eliminación definitiva
    const confirmDelete = () => {
        if (selectedLote) {
            router.delete(LotesController.eliminar(selectedLote.id).url, {
                onSuccess: () => closeModal(),
            });
        }
    };
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Papelera de Lotes" />
            <nav className="flex-row">
                <Link href={LotesController.index().url}>
                    <Button className="m-4 bg-green-500 hover:bg-green-700">
                        <ArrowBigLeft /> Volver
                    </Button>
                </Link>
            </nav>

            <Table>
                <TableCaption>Papelera de Lotes</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Código</TableHead>
                        <TableHead>Descripción</TableHead>
                        <TableHead>Producto</TableHead>
                        <TableHead>Cantidad</TableHead>
                        <TableHead>Almacen</TableHead>
                        <TableHead>Estado</TableHead>
                        <TableHead>Acciones</TableHead>
                    </TableRow>
                </TableHeader>
                {Lotes.data.length > 0 && (
                    <TableBody>
                        {Lotes.data.map((Lote: any) => (
                            <TableRow key={Lote.codigo}>
                                <TableCell>{Lote.codigo}</TableCell>

                                <TableCell>
                                    {Lote.descripcion?.length > 50
                                        ? Lote.descripcion.substring(0, 50) +
                                          '...'
                                        : (Lote.descripcion ??
                                          'Sin Descripcion')}
                                </TableCell>
                                <TableCell>{Lote.producto}</TableCell>
                                <TableCell>{Lote.cantidad}</TableCell>
                                <TableCell>{Lote.almacen}</TableCell>
                                <TableCell>
                                    {Lote.estado == true
                                        ? 'Activo'
                                        : 'Inactivo'}
                                </TableCell>
                                <TableCell className="flex-row space-x-2">
                                    <Link
                                        href={
                                            LotesController.habilitar(Lote.id)
                                                .url
                                        }
                                    >
                                        <Button className="bg-green-500 hover:bg-green-700">
                                            <RotateCcw />
                                        </Button>
                                    </Link>

                                    <Button
                                        className="bg-red-500 hover:bg-red-700"
                                        onClick={() => openModal(Lote)}
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
            {showModal && selectedLote && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                    <div className="relative w-full max-w-sm rounded-lg bg-white p-6 shadow-lg dark:bg-slate-900">
                        <div className="text-center">
                            <h3 className="mb-5 text-lg font-normal text-gray-500">
                                ¿Estás seguro de eliminar{' '}
                                <strong>definitivamente</strong> el Lote{' '}
                                {selectedLote.descripcion}?
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
