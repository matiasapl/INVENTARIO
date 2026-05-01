import AlmacenController from '@/actions/App/Http/Controllers/AlmacenController';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { CircleCheck } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Almacenes',
        href: AlmacenController.index().url,
    },
    {
        title: 'Ver Almacen',
        href: '#',
    },
];

interface Almacen {
    id: number;
    codigo: number;
    nombre: string;
    descripcion: string;
    ubicacion: string;
    estado: boolean;
}

export default function View({ Almacen }: { Almacen: Almacen }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Ver Almacen" />
            <div className="w-8/12 p-4">
                <form method="post">
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Codigo" className="mb-1.5 block">
                            Codigo de Almacen:
                        </Label>
                        <Input
                            type="text"
                            id="Codigo"
                            placeholder="UUID"
                            value={Almacen.codigo}
                            disabled
                        ></Input>
                    </div>
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Nombre" className="mb-1.5 block">
                            Nombre de Almacen:
                        </Label>
                        <Input
                            id="Nombre"
                            placeholder="Nombre de tu almacen"
                            minLength={3}
                            maxLength={30}
                            value={Almacen.nombre}
                            disabled
                        ></Input>
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Ubicacion" className="mb-1.5 block">
                            Ubicacion de Almacen:
                        </Label>
                        <Input
                            id="Ubicacion"
                            placeholder="Ubicacion de tu almacen"
                            minLength={3}
                            maxLength={30}
                            value={Almacen.ubicacion}
                            disabled
                        ></Input>
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Estado" className="mb-1.5 block">
                            Estado:
                        </Label>
                        <Input
                            type="text"
                            id="Estado"
                            value={
                                Almacen.estado == true ? 'Activo' : 'Inactivo'
                            }
                            disabled
                        ></Input>
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="descripcion" className="mb-1.5 block">
                            Descripcion:
                        </Label>
                        <Textarea
                            id="descripcion"
                            placeholder="Una brebe descricion sobre tu producto"
                            minLength={0}
                            maxLength={255}
                            value={Almacen.descripcion}
                            disabled
                        ></Textarea>
                    </div>
                    <div className="flex-row space-x-2">
                        <Link href={AlmacenController.index().url}>
                            <Button
                                className="mb-4 bg-green-500 hover:bg-green-700"
                                type="button"
                            >
                                <CircleCheck /> Volver
                            </Button>
                        </Link>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
