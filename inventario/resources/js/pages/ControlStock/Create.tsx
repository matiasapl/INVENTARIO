import ControlStockController from '@/actions/App/Http/Controllers/ControlStockController';
import { useState } from 'react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/react';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { DropdownMenu, DropdownMenuItem, DropdownMenuTrigger, DropdownMenuContent,DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import { useForm }  from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { CircleX, CircleCheck } from 'lucide-react';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Actualizar Stock',
        href: ControlStockController.create().url,
    },
];

interface DropDown {
    id: number
    codigo: number;
    nombre: string;
    stock: number;
}

export default function Create({ DropDown }: { DropDown: DropDown[] }) {
    const { data, setData, post, processing, errors } = useForm({
        codigo: 0,
        nombre: '',
        stock_previo: 0,
        cantidad: 0,
    });

    const [accion, setAccion] = useState('');
    const [codigo, setCodigo] = useState('');
    const [nombre, setNombre] = useState('');
    const [cantidad, setCantidad] = useState(0);
    const [ID, setID] = useState(0);






const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();

    const rutaDestino =
        accion === 'Sumar'
            ? ControlStockController.sumar(ID).url
            : ControlStockController.restar(ID).url;

    // Actualizamos el formulario con la cantidad

setData((prev) => ({
    ...prev,
    cantidad,
}));

post(rutaDestino, {
    preserveScroll: true,
    onSuccess: () => {
        setAccion('');
        setCodigo('');
        setNombre('');
        setCantidad(0);
        setID(0);
    },
});
};

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Producto" />
            <div className="w-8/12 p-4">
                <form method="post" onSubmit={handleSubmit}>
                    {/* Dropdown para Código */}
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Codigo" className="mb-1.5 block">
                            Código
                        </Label>
                        <DropdownMenu>
                            <DropdownMenuTrigger>
                                <Input
                                    id="Codigo"
                                    placeholder="CLICK AQUI !!!"
                                    value={codigo}
                                    disabled={true}
                                />
                            </DropdownMenuTrigger>
                            <DropdownMenuContent>
                                <DropdownMenuLabel>
                                    Selecciona Código de Producto a Actualizar
                                </DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                {DropDown.map((item) => (
                                    <DropdownMenuItem
                                        key={item.codigo}
                                        onClick={() => {
                                            setCodigo(item.codigo.toString());
                                            setNombre(item.nombre);
                                            setData('codigo', item.codigo);
                                            setData('nombre', item.nombre);
                                            setData('stock_previo', item.stock);
                                            setID(item.id);
                                        }}
                                    >
                                        {item.codigo}
                                    </DropdownMenuItem>
                                ))}
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>

                    {/* Input para Nombre */}
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Nombre" className="mb-1.5 block">
                            Nombre de Producto:
                        </Label>
                        <Input
                            id="Nombre"
                            placeholder="Nombre de tu producto"
                            value={nombre}
                            disabled={true}
                        />
                        {errors.nombre && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.nombre}
                            </div>
                        )}
                    </div>

                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Accion" className="mb-1.5 block">
                            Accion:
                        </Label>
                        <DropdownMenu>
                            <DropdownMenuTrigger>
                                <Input
                                    id="Accion"
                                    placeholder="CLICK AQUI !!!"
                                    value={accion}
                                    disabled={true}
                                ></Input>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent>
                                <DropdownMenuLabel>
                                    QUE QUIERES HACER?
                                </DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem
                                    onClick={() => {
                                        setAccion('Sumar');
                                    }}
                                >
                                    Sumar
                                </DropdownMenuItem>
                                <DropdownMenuItem
                                    onClick={() => {
                                        setAccion('Restar');
                                    }}
                                >
                                    Restar
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
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
                            onChange={(e) => {setData('cantidad', Number(e.target.value));}}
                        ></Input>
                        {errors.cantidad && (
                            <div className="mt-1 flex items-center text-sm text-red-500">
                                {errors.cantidad}
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
