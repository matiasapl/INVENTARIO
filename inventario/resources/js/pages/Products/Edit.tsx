import ProductController from '@/actions/App/Http/Controllers/ProductController';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { useForm }  from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { CircleX, CircleCheck } from 'lucide-react';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Editar Producto',
        href: '/products/edit',
    },
];
interface Product {
    id: number;
    codigo: number;
    nombre: string;
    stock: number;
    precio_unitario: number;
    M3_unitario: number;
    descripcion: string;
}

export default function Edit({ product }: {product: Product}) {

    const { data, setData, put, processing, errors } = useForm({
    id: product.id,
    codigo: product.codigo,
    nombre: product.nombre,
    stock: product.stock,
    precio_unitario: product.precio_unitario,
    M3_unitario: product.M3_unitario,
    descripcion: product.descripcion,
    });


    const handleUpdate = (e: React.FormEvent<HTMLFormElement>) => { 
        e.preventDefault();
        put(ProductController.update(product.id).url)
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Producto" />
            <div className="w-8/12 p-4">
                <form method="post" onSubmit={handleUpdate}>
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Codigo" className="mb-1.5 block">
                            Codigo de Producto:
                        </Label>
                        <Input
                            type="Number"
                            id="Codigo"
                            max={10000000}
                            min={0}
                            maxLength={8}
                            placeholder="0"
                            value={data.codigo}
                            onChange={(e) =>
                                setData('codigo', Number(e.target.value))
                            }
                        ></Input>
                        {errors.codigo && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.codigo}
                            </div>
                        )}
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
                        <Label htmlFor="Stock" className="mb-1.5 block">
                            Stock Inicial:
                        </Label>
                        <Input
                            type="Number"
                            id="Stock"
                            placeholder="0"
                            min={0}
                            max={10000000}
                            value={data.stock}
                            onChange={(e) =>
                                setData('stock', Number(e.target.value))
                            }
                        ></Input>
                        {errors.stock && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.stock}
                            </div>
                        )}
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label
                            htmlFor="precio_unitario"
                            className="mb-1.5 block"
                        >
                            Precio Unitario:
                        </Label>
                        <Input
                            type="number"
                            id="precio_unitario"
                            placeholder="0.00"
                            min={0}
                            step={0.01}
                            max={10000000}
                            value={data.precio_unitario}
                            onChange={(e) =>
                                setData(
                                    'precio_unitario',
                                    Number(e.target.value),
                                )
                            }
                        ></Input>
                        {errors.precio_unitario && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.precio_unitario}
                            </div>
                        )}
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="M3_unitario" className="mb-1.5 block">
                            M3_unitario:
                        </Label>
                        <Input
                            type="number"
                            id="M3_unitario"
                            placeholder="0.00000"
                            step={0.00001}
                            min={0}
                            max={10000000}
                            value={data.M3_unitario}
                            onChange={(e) =>
                                setData('M3_unitario', Number(e.target.value))
                            }
                        ></Input>
                        {errors.M3_unitario && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.M3_unitario}
                            </div>
                        )}
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
                            <CircleCheck /> Editar Producto
                        </Button>

                        <Link href={ProductController.index().url}>
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
        </AppLayout>
    );
}
