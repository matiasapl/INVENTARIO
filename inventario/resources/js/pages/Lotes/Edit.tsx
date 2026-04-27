import LotesController from '@/actions/App/Http/Controllers/LotesController';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { CircleCheck, CircleX } from 'lucide-react';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Editar Lote',
        href: '/lotes/edit',
    },
];
interface Lote {
    id: number;
    codigo: string;
    descripcion: string;
    producto_id: number;
    cantidad: string;
    almacen_id: number;
    estado: boolean;
}

export default function Edit({ Lote }: { Lote: Lote }) {
    const [showModal, setShowModal] = useState(false);

    const { data, setData, put, processing, errors } = useForm({
        descripcion: Lote.descripcion,
        producto_id: Lote.producto_id,
        cantidad: Lote.cantidad,
        almacen_id: Lote.almacen_id,
        estado: Lote.estado,
    });

    const preUpdate = (e: React.FormEvent) => {
        e.preventDefault();
        setShowModal(true);
    };

    const confirmUpdate = () => {
        setShowModal(false);
        put(LotesController.update(Lote.id).url);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar Lote" />
            <div className="w-8/12 p-4">
                <form method="post" onSubmit={preUpdate}>
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Descripcion" className="mb-1.5 block">
                            Descripcion de Lote:
                        </Label>
                        <Input
                            id="Descripcion"
                            placeholder="Descripcion de tu Lote"
                            minLength={3}
                            maxLength={30}
                            value={data.descripcion}
                            onChange={(e) =>
                                setData('descripcion', e.target.value)
                            }
                        ></Input>
                        {errors.descripcion && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.descripcion}
                            </div>
                        )}
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Producto" className="mb-1.5 block">
                            Producto:
                        </Label>
                        <DropdownMenu>
                            <DropdownMenuTrigger>
                                <Input
                                    id="Producto"
                                    placeholder="CLICK AQUI !!!"
                                    value={data.producto_id}
                                    disabled={true}
                                />
                            </DropdownMenuTrigger>
                            <DropdownMenuContent>
                                <DropdownMenuLabel>
                                    Seleccion Producto
                                </DropdownMenuLabel>
                                <DropdownMenuItem
                                    onClick={() => {
                                        setData('producto_id', 1);
                                    }}
                                >
                                    Primer Producto
                                </DropdownMenuItem>
                                <DropdownMenuItem
                                    onClick={() => {
                                        setData('producto_id', 2);
                                    }}
                                >
                                    Segundo Producto
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                        {errors.producto_id && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.producto_id}
                            </div>
                        )}
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Cantidad" className="mb-1.5 block">
                            Stock de Producto:
                        </Label>
                        <Input
                            id="Cantidad"
                            placeholder="Cantidad de tu Lote"
                            value={data.cantidad}
                            onChange={(e) =>
                                setData('cantidad', e.target.value)
                            }
                        ></Input>
                        {errors.cantidad && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.cantidad}
                            </div>
                        )}
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Almacen" className="mb-1.5 block">
                            Almacen:
                        </Label>
                        <DropdownMenu>
                            <DropdownMenuTrigger>
                                <Input
                                    id="Almacen"
                                    placeholder="CLICK AQUI !!!"
                                    value={data.almacen_id}
                                    disabled={true}
                                />
                            </DropdownMenuTrigger>
                            <DropdownMenuContent>
                                <DropdownMenuLabel>
                                    Seleccion Almacen
                                </DropdownMenuLabel>
                                <DropdownMenuItem
                                    onClick={() => {
                                        setData('almacen_id', 1);
                                    }}
                                >
                                    Primer Almacen
                                </DropdownMenuItem>
                                <DropdownMenuItem
                                    onClick={() => {
                                        setData('almacen_id', 2);
                                    }}
                                >
                                    Calcetines Largos
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                        {errors.almacen_id && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.almacen_id}
                            </div>
                        )}
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Estado" className="mb-1.5 block">
                            Estado:
                        </Label>
                        <DropdownMenu>
                            <DropdownMenuTrigger>
                                <Input
                                    id="Estado"
                                    placeholder="CLICK AQUI !!!"
                                    value={
                                        data.estado == true
                                            ? 'Activo'
                                            : 'Inactivo'
                                    }
                                    disabled={true}
                                />
                            </DropdownMenuTrigger>
                            <DropdownMenuContent>
                                <DropdownMenuLabel>
                                    Seleccion Estado
                                </DropdownMenuLabel>
                                <DropdownMenuItem
                                    onClick={() => {
                                        setData('estado', true);
                                    }}
                                >
                                    Activo
                                </DropdownMenuItem>
                                <DropdownMenuItem
                                    onClick={() => {
                                        setData('estado', false);
                                    }}
                                >
                                    Inactivo
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                        {errors.estado && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.estado}
                            </div>
                        )}
                    </div>

                    <div className="flex-row space-x-2">
                        <Button
                            className="mb-4 bg-yellow-500 hover:bg-yellow-700"
                            type="submit"
                            disabled={processing}
                        >
                            <CircleCheck /> Editar Almacen
                        </Button>

                        <Link href={LotesController.index().url}>
                            <Button
                                className="mb-4 bg-green-500 hover:bg-green-700"
                                type="button"
                            >
                                <CircleX /> Cancelar
                            </Button>
                        </Link>
                    </div>
                </form>
            </div>

            {showModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                    <div className="relative w-full max-w-sm rounded-lg bg-white p-6 shadow-lg dark:bg-slate-900">
                        {/* Botón X de cierre */}
                        <button
                            onClick={() => setShowModal(false)}
                            className="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
                        >
                            <CircleX />
                        </button>

                        <div className="text-center">
                            <h3 className="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                ¿Seguro que quieres editar este Lote?
                            </h3>
                            <div className="flex justify-center gap-4">
                                <Button
                                    variant="outline"
                                    onClick={() => setShowModal(false)}
                                >
                                    <CircleX /> Cancelar
                                </Button>
                                <Button
                                    className="bg-green-600 hover:bg-green-700"
                                    onClick={confirmUpdate}
                                >
                                    <CircleCheck />
                                    Sí, confirmo
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </AppLayout>
    );
}
