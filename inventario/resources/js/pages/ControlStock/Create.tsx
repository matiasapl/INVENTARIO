import ControlStockController from '@/actions/App/Http/Controllers/ControlStockController';
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
        title: 'Actualizar Stock',
        href: ControlStockController.create().url,
    },
];

export default function Create() {

    const { data, setData, post, processing, errors } = useForm({
        codigo: 0,
        nombre: '',
        stock_previo: 0,
        stock_actual: 0,
    });


    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => { 
        e.preventDefault();
        //post(ControlStockController.store().url);
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
                            type="Number"
                            id="Codigo"
                            max={10000000}
                            min={0}
                            maxLength={8}
                            placeholder="0"
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
                            onChange={(e) => setData('nombre', e.target.value)}
                        ></Input>
                        {errors.nombre && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.nombre}
                            </div>
                        )}
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Stock_Previo" className="mb-1.5 block">
                            Accion:
                        </Label>
                        <Input
                            type="number"
                            id="Stock_Previo"
                            placeholder="0"
                            min={0}
                            max={10000000}
                            onChange={(e) =>
                                setData('stock_previo', Number(e.target.value))
                            }
                        ></Input>
                        {errors.stock_previo && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.stock_previo}
                            </div>
                        )}
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Stock_Actual" className="mb-1.5 block">
                            Cantidad:
                        </Label>
                        <Input
                            type="number"
                            id="Stock_Actual"
                            placeholder="0"
                            min={0}
                            max={10000000}
                            onChange={(e) =>
                                setData('stock_actual', Number(e.target.value))
                            }
                        ></Input>
                        {errors.stock_actual && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.stock_actual}
                            </div>
                        )}
                    </div>
                    <div className="flex-row space-x-2">
                        <Button
                            className="mb-4 bg-green-500 hover:bg-green-700"
                            type="submit"
                            disabled={processing}
                        >
                            <CircleCheck /> Actualizar
                        </Button>

                        <Link href={ControlStockController.index().url}>
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
