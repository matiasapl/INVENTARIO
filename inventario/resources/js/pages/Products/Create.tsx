import ProductController from '@/actions/App/Http/Controllers/ProductController';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { useForm }  from '@inertiajs/react';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crear Producto',
        href: ProductController.create().url,
    },
];

export default function Create() {

    const { data, setData, post, processing, errors } = useForm({
        codigo: 0,
        nombre: '',
        stock: 0,
        precio_unitario: 0,
        M3_unitario: 0,
        descripcion: '',
    });


    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => { 
        e.preventDefault();
        post(ProductController.store().url);
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Producto" />
            <div className="w-8/12 p-4">
                <form method="post" onSubmit={handleSubmit}>
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Codigo" className="mb-1.5 block">
                            Codigo de Producto:
                        </Label>
                        <Input
                            id="Codigo"
                            placeholder="001"
                            value={data.codigo}
                            onChange={(e) =>
                                setData('codigo', Number(e.target.value))
                            }
                        ></Input>
                    </div>
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Nombre" className="mb-1.5 block">
                            Nombre de Producto:
                        </Label>
                        <Input
                            id="Nombre"
                            placeholder="Nombre de tu producto"
                            value={data.nombre}
                            onChange={(e) => setData('nombre', e.target.value)}
                        ></Input>
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Stock" className="mb-1.5 block">
                            Stock Inicial:
                        </Label>
                        <Input
                            id="Stock"
                            placeholder="0"
                            value={data.stock}
                            onChange={(e) =>
                                setData('stock', Number(e.target.value))
                            }
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
                            id="precio_unitario"
                            placeholder="0"
                            value={data.precio_unitario}
                            onChange={(e) =>
                                setData(
                                    'precio_unitario',
                                    Number(e.target.value),
                                )
                            }
                        ></Input>
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="M3_unitario" className="mb-1.5 block">
                            M3_unitario:
                        </Label>
                        <Input
                            id="M3_unitario"
                            placeholder="0"
                            value={data.M3_unitario}
                            onChange={(e) =>
                                setData('M3_unitario', Number(e.target.value))
                            }
                        ></Input>
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="descripcion" className="mb-1.5 block">
                            Descripcion:
                        </Label>
                        <Textarea
                            id="descripcion"
                            placeholder="0"
                            value={data.descripcion}
                            onChange={(e) =>
                                setData('descripcion', e.target.value)
                            }
                        ></Textarea>
                    </div>

                    <Button className="mb-4 bg-green-500 hover:bg-green-700"
                    type="submit">
                        Registrar Producto
                    </Button>
                </form>
            </div>
        </AppLayout>
    );
}
