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
        title: 'Lotes',
        href: LotesController.index().url,
    },
    {
        title: 'Editar Lote',
        href: '#',
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

interface Item {
    id: number;
    nombre: string;
    codigo: string;
}

export default function Edit({
    Lote,
    products,
    almacens,
}: {
    Lote: Lote;
    products: Item[];
    almacens: Item[];
}) {
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

    // Funciones para obtener el nombre a mostrar en el input deshabilitado
    const getProductName = (id: number) =>
        products.find((p) => p.id === id)?.nombre || 'Selecciona Producto';
    const getAlmacenName = (id: number) =>
        almacens.find((a) => a.id === id)?.nombre || 'Selecciona Almacen';

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar Lote" />
            <div className="w-8/12 p-4">
                <form method="post" onSubmit={preUpdate}>
                    {/* Descripcion */}
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
                        />
                        {errors.descripcion && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.descripcion}
                            </div>
                        )}
                    </div>

                    {/* Producto Dinámico */}
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Producto" className="mb-1.5 block">
                            Producto:
                        </Label>
                        <DropdownMenu>
                            <DropdownMenuTrigger className="w-full">
                                <Input
                                    id="Producto"
                                    placeholder="CLICK AQUI !!!"
                                    value={getProductName(data.producto_id)}
                                    disabled={true}
                                    className="cursor-pointer"
                                />
                            </DropdownMenuTrigger>
                            <DropdownMenuContent className="w-[var(--radix-dropdown-menu-trigger-width)]">
                                <DropdownMenuLabel>
                                    Seleccion Producto
                                </DropdownMenuLabel>
                                {products.map((p) => (
                                    <DropdownMenuItem
                                        key={p.id}
                                        onClick={() =>
                                            setData('producto_id', p.id)
                                        }
                                    >
                                        {p.nombre}
                                    </DropdownMenuItem>
                                ))}
                            </DropdownMenuContent>
                        </DropdownMenu>
                        {errors.producto_id && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.producto_id}
                            </div>
                        )}
                    </div>

                    {/* Cantidad */}
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
                        />
                        {errors.cantidad && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.cantidad}
                            </div>
                        )}
                    </div>

                    {/* Almacen Dinámico */}
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Almacen" className="mb-1.5 block">
                            Almacen:
                        </Label>
                        <DropdownMenu>
                            <DropdownMenuTrigger className="w-full">
                                <Input
                                    id="Almacen"
                                    placeholder="CLICK AQUI !!!"
                                    value={getAlmacenName(data.almacen_id)}
                                    disabled={true}
                                    className="cursor-pointer"
                                />
                            </DropdownMenuTrigger>
                            <DropdownMenuContent className="w-[var(--radix-dropdown-menu-trigger-width)]">
                                <DropdownMenuLabel>
                                    Seleccion Almacen
                                </DropdownMenuLabel>
                                {almacens.map((a) => (
                                    <DropdownMenuItem
                                        key={a.id}
                                        onClick={() =>
                                            setData('almacen_id', a.id)
                                        }
                                    >
                                        {a.nombre}
                                    </DropdownMenuItem>
                                ))}
                            </DropdownMenuContent>
                        </DropdownMenu>
                        {errors.almacen_id && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.almacen_id}
                            </div>
                        )}
                    </div>

                    {/* Estado */}
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Estado" className="mb-1.5 block">
                            Estado:
                        </Label>
                        <DropdownMenu>
                            <DropdownMenuTrigger className="w-full">
                                <Input
                                    id="Estado"
                                    placeholder="CLICK AQUI !!!"
                                    value={data.estado ? 'Disponible' : 'Usado'}
                                    disabled={true}
                                    className="cursor-pointer"
                                />
                            </DropdownMenuTrigger>
                            <DropdownMenuContent className="w-[var(--radix-dropdown-menu-trigger-width)]">
                                <DropdownMenuLabel>
                                    Seleccion Estado
                                </DropdownMenuLabel>
                                <DropdownMenuItem
                                    onClick={() => setData('estado', true)}
                                >
                                    Disponible
                                </DropdownMenuItem>
                                <DropdownMenuItem
                                    onClick={() => setData('estado', false)}
                                >
                                    Usado
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>

                    {/* Botones */}
                    <div className="flex flex-row space-x-2">
                        <Button
                            className="mb-4 bg-yellow-500 hover:bg-yellow-700"
                            type="submit"
                            disabled={processing}
                        >
                            <CircleCheck className="mr-2 h-4 w-4" /> Editar Lote
                        </Button>

                        <Link href={LotesController.index().url}>
                            <Button
                                className="mb-4 bg-green-500 hover:bg-green-700"
                                type="button"
                            >
                                <CircleX className="mr-2 h-4 w-4" /> Cancelar
                            </Button>
                        </Link>
                    </div>
                </form>
            </div>

            {/* Modal Manual MVP */}
            {showModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                    <div className="relative w-full max-w-sm rounded-lg bg-white p-6 shadow-lg dark:bg-slate-900">
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
                                    <CircleX className="mr-2 h-4 w-4" />
                                    Cancelar
                                </Button>
                                <Button
                                    className="bg-green-600 hover:bg-green-700"
                                    onClick={confirmUpdate}
                                >
                                    <CircleCheck className="mr-2 h-4 w-4" /> Sí,
                                    confirmo
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </AppLayout>
    );
}
