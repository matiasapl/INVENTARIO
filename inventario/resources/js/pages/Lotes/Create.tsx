import LotesController from '@/actions/App/Http/Controllers/LotesController';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { CircleCheck, CircleX } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crear Lote',
        href: LotesController.create().url,
    },
];

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        descripcion: '',
        producto_id: '',
        cantidad: '',
        almacen_id: '',
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        post(LotesController.store().url);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Lote" />
            <div className="w-8/12 p-4">
                <form method="post" onSubmit={handleSubmit}>
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Descripcion" className="mb-1.5 block">
                            Descripcion de Lote:
                        </Label>
                        <Input
                            id="Descripcion"
                            placeholder="Nombre de tu Lote"
                            minLength={3}
                            maxLength={30}
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
                            Producto del Lote:
                        </Label>
                        <Input
                            id="Producto"
                            placeholder="Selecciona Producto"
                            onChange={(e) =>
                                setData('producto_id', e.target.value)
                            }
                        ></Input>
                        {errors.producto_id && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.producto_id}
                            </div>
                        )}
                    </div>
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Cantidad" className="mb-1.5 block">
                            Unidades de Producto:
                        </Label>
                        <Input
                            id="Cantidad"
                            placeholder="Cantidad del producto seleccionado que contiene este Lote"
                            type="numeric"
                            min={0}
                            max={10000000}
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
                            Almacen del Lote:
                        </Label>
                        <Input
                            id="Almacen"
                            placeholder="Selecciona Almacen donde se encuentra tu Lote"
                            onChange={(e) =>
                                setData('almacen_id', e.target.value)
                            }
                        ></Input>
                        {errors.almacen_id && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.almacen_id}
                            </div>
                        )}
                    </div>

                    <div className="flex-row space-x-2">
                        <Button
                            className="mb-4 bg-green-500 hover:bg-green-700"
                            type="submit"
                            disabled={processing}
                        >
                            <CircleCheck /> Registrar Lote
                        </Button>

                        <Link href={LotesController.index().url}>
                            <Button
                                className="mb-4 bg-red-500 hover:bg-red-700"
                                type="button"
                            >
                                <CircleX /> Cancelar
                            </Button>
                        </Link>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
