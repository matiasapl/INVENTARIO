import LotesController from '@/actions/App/Http/Controllers/LotesController';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { CircleCheck } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ver Lote',
        href: LotesController.view('').url,
    },
];

interface Lote {
    id: number;
    codigo: string;
    descripcion: string;
    producto: string;
    cantidad: string;
    almacen: string;
    estado: boolean;
}

export default function View({ VerLote }: { VerLote: Lote }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Ver Lote" />
            <div className="w-8/12 p-4">
                <form method="post">
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Codigo" className="mb-1.5 block">
                            Codigo de Lote:
                        </Label>
                        <Input
                            type="text"
                            id="Codigo"
                            placeholder="UUID"
                            value={VerLote.codigo}
                            disabled
                        ></Input>
                    </div>
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Descripcion" className="mb-1.5 block">
                            Descripcion de Lote:
                        </Label>
                        <Input
                            id="Descripcion"
                            placeholder="Descripcion"
                            minLength={3}
                            maxLength={30}
                            value={VerLote.descripcion}
                            disabled
                        ></Input>
                    </div>
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="producto" className="mb-1.5 block">
                            Producto del Lote:
                        </Label>
                        <Input
                            id="producto"
                            placeholder="producto"
                            value={VerLote.producto}
                            disabled
                        ></Input>
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="cantidad" className="mb-1.5 block">
                           Stock del Lote:
                        </Label>
                        <Input
                            id="cantidad"
                            placeholder="cantidad"
                            value={VerLote.cantidad}
                            disabled
                        ></Input>
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="almacen" className="mb-1.5 block">
                            Almacen del Lote:
                        </Label>
                        <Input
                            id="almacen"
                            placeholder="almacen"
                            value={VerLote.almacen}
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
                            value={VerLote.estado == true ? 'Activo' : 'Inactivo'}
                            disabled
                        ></Input>
                    </div>
                    <div className="flex-row space-x-2">
                        <Link href={LotesController.index().url}>
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
