import AlmacenController from '@/actions/App/Http/Controllers/AlmacenController';
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
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { CircleCheck, CircleX } from 'lucide-react';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Editar Almacen',
        href: '/almacen/edit',
    },
];
interface Almacen {
    id: number;
    nombre: string;
    descripcion: string;
    ubicacion: string;
    estado: boolean;
}

export default function Edit({ Almacen }: { Almacen: Almacen }) {
    const [showModal, setShowModal] = useState(false);

    const { data, setData, put, processing, errors } = useForm({
        nombre: Almacen.nombre,
        ubicacion: Almacen.ubicacion,
        estado: Almacen.estado,
        descripcion: Almacen.descripcion,
    });

    const preUpdate = (e: React.FormEvent) => {
        e.preventDefault();
        setShowModal(true);
    };

    const confirmUpdate = () => {
        setShowModal(false);
        put(AlmacenController.update(Almacen.id).url);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar Almacen" />
            <div className="w-8/12 p-4">
                <form method="post" onSubmit={preUpdate}>
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Nombre" className="mb-1.5 block">
                            Nombre de Almacen:
                        </Label>
                        <Input
                            id="Nombre"
                            placeholder="Nombre de tu Almacen"
                            minLength={3}
                            maxLength={30}
                            value={data.nombre}
                            onChange={(e) => setData('nombre', e.target.value)}
                        ></Input>
                        {errors.nombre && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.nombre}
                            </div>
                        )}
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Ubicacion" className="mb-1.5 block">
                            Ubicacion de Almacen:
                        </Label>
                        <Input
                            id="Ubicacion"
                            placeholder="Ubicacion de tu Almacen"
                            minLength={3}
                            maxLength={30}
                            value={data.ubicacion}
                            onChange={(e) =>
                                setData('ubicacion', e.target.value)
                            }
                        ></Input>
                        {errors.ubicacion && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.ubicacion}
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

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="descripcion" className="mb-1.5 block">
                            Descripcion:
                        </Label>
                        <Textarea
                            id="descripcion"
                            placeholder="Una brebe descricion sobre tu Almacen"
                            minLength={0}
                            maxLength={255}
                            value={data.descripcion}
                            onChange={(e) =>
                                setData('descripcion', e.target.value)
                            }
                        ></Textarea>
                        {errors.descripcion && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.descripcion}
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

                        <Link href={AlmacenController.index().url}>
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
                                ¿Seguro que quieres editar este Almacen?
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
