import ProductController from '@/actions/App/Http/Controllers/ProductController';
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
        title: 'Productos',
        href: ProductController.index().url,
    },
    {
        title: 'Ver Producto',
        href: '#',
    },
];
interface Product {
    id: number;
    codigo: number;
    nombre: string;
    precio_unitario: number;
    M3_unitario: number;
    estado: boolean;
    descripcion: string;
}

export default function View({ product }: { product: Product }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Ver Producto" />
            <div className="w-8/12 p-4">
                <form method="post">
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Codigo" className="mb-1.5 block">
                            Codigo de Producto:
                        </Label>
                        <Input
                            type="text"
                            id="Codigo"
                            placeholder="UUID"
                            value={product.codigo}
                            disabled
                        ></Input>
                    </div>
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Nombre" className="mb-1.5 block">
                            Nombre de Producto:
                        </Label>
                        <Input
                            id="Nombre"
                            placeholder="Nombre de tu producto"
                            minLength={3}
                            maxLength={30}
                            value={product.nombre}
                            disabled
                        ></Input>
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label
                            htmlFor="precio_unitario"
                            className="mb-1.5 block"
                        >
                            Precio Unitario:
                        </Label>
                        <Input
                            type="Number"
                            id="precio_unitario"
                            placeholder="0.00"
                            min={0}
                            max={10000000}
                            value={product.precio_unitario}
                            disabled
                        ></Input>
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="M3_unitario" className="mb-1.5 block">
                            M3_unitario:
                        </Label>
                        <Input
                            type="Number"
                            id="M3_unitario"
                            placeholder="0.00000"
                            min={0}
                            max={10000000}
                            value={product.M3_unitario}
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
                                product.estado == true ? 'Activo' : 'Inactivo'
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
                            value={product.descripcion}
                            disabled
                        ></Textarea>
                    </div>
                    <div className="flex-row space-x-2">
                        <Link href={ProductController.index().url}>
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
