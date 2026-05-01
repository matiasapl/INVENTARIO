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
import {
    Boxes,
    CircleCheck,
    CircleX,
    Eye,
    PencilLine,
    Trash2,
} from 'lucide-react';
import { useState } from 'react';
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
];

export default function Index({ Lotes }: { Lotes: any }) {
    const [showModal, setShowModal] = useState(false);
    const [selectedLote, setSelectedLote] = useState<Lote | null>(null);

    const openModal = (Lotes: Lote) => {
        setSelectedLote(Lotes);
        setShowModal(true);
    };

    const closeModal = () => {
        setSelectedLote(null);
        setShowModal(false);
    };

    const confirmDisable = () => {
        if (selectedLote) {
            router.get(LotesController.deshabilitar(selectedLote.id).url);
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Lotes" />
            <nav className="flex-row">
                <Link href={LotesController.create().url}>
                    <Button className="m-4 bg-green-500 hover:bg-green-700">
                        <Boxes /> Crear Lote
                    </Button>
                </Link>

                <Link href={LotesController.papelera().url}>
                    <Button className="m-4 bg-red-500 hover:bg-red-700">
                        <Trash2 /> Papelera
                    </Button>
                </Link>
            </nav>

            <div className="pagination mx-4 flex justify-center gap-2">
                {Lotes.links.map((link: any, index: number) => (
                    <a
                        key={index}
                        href={link.url || '#'}
                        className={`rounded border px-3 py-1 ${link.active ? 'bg-blue-500 text-white' : ''}`}
                        dangerouslySetInnerHTML={{ __html: link.label }}
                    />
                ))}
            </div>

            <Table>
                <TableCaption>Lotes</TableCaption>
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
                                        ? 'Disponible'
                                        : 'Usado'}
                                </TableCell>
                                <TableCell className="flex-row space-x-2">
                                    <Link
                                        href={LotesController.view(Lote.id).url}
                                    >
                                        <Button className="bg-yellow-500 hover:bg-yellow-700">
                                            <Eye />
                                        </Button>
                                    </Link>
                                    <Link
                                        href={LotesController.edit(Lote.id).url}
                                    >
                                        <Button className="bg-orange-500 hover:bg-orange-700">
                                            <PencilLine />
                                        </Button>
                                    </Link>
                                    <Button
                                        className="bg-red-500 hover:bg-red-700"
                                        onClick={() => openModal(Lote)}
                                    >
                                        <Trash2 />
                                    </Button>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                )}
            </Table>

            {showModal && selectedLote && (
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
                                <strong>{selectedLote.descripcion}</strong> a la
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
