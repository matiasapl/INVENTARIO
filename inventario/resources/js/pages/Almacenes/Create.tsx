import AlmacenController from '@/actions/App/Http/Controllers/AlmacenController';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { CircleCheck, CircleX } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Almacenes',
        href: AlmacenController.index().url,
    },
    {
        title: 'Crear Almacen',
        href: '#',
    },
];

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        nombre: '',
        descripcion: '',
        ubicacion: '',
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        post(AlmacenController.store().url);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Almacen" />
            <div className="w-8/12 p-4">
                <form method="post" onSubmit={handleSubmit}>
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Nombre" className="mb-1.5 block">
                            Nombre de Almacen:
                        </Label>
                        <Input
                            id="Nombre"
                            placeholder="Nombre de tu Almacen"
                            minLength={3}
                            maxLength={30}
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
                        <Label htmlFor="descripcion" className="mb-1.5 block">
                            Descripcion:
                        </Label>
                        <Textarea
                            id="descripcion"
                            placeholder="Una brebe descricion sobre tu almacen"
                            minLength={0}
                            maxLength={255}
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
                            className="mb-4 bg-green-500 hover:bg-green-700"
                            type="submit"
                            disabled={processing}
                        >
                            <CircleCheck /> Registrar Almacen
                        </Button>

                        <Link href={AlmacenController.index().url}>
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
