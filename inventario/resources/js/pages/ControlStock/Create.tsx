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
    const [showModal, setShowModal] = useState(false);
    const { data, setData, post, processing, errors } = useForm({
        codigo: 0,
        nombre: '',
        stock_previo: 0,
        cantidad: 0,
    });

    const [accion, setAccion] = useState('');
    const [codigo, setCodigo] = useState('');
    const [nombre, setNombre] = useState('');
    const [ID, setID] = useState(0);


    const preUpdate = (e: React.FormEvent) => {
        e.preventDefault();
        setShowModal(true);
    };



const confirmUpdate = (e: React.MouseEvent<HTMLButtonElement>) => {
    e.preventDefault();

    const rutaDestino =
        accion === 'Sumar'
            ? ControlStockController.sumar(ID).url
            : ControlStockController.restar(ID).url;

    post(rutaDestino, {
        preserveScroll: true,
        onSuccess: () => {
            setAccion('');
            setCodigo('');
            setNombre('');
            setID(0);
        },
    });
};

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Producto" />
            <div className="w-8/12 p-4">
                <form onSubmit={preUpdate}>
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
                            onChange={(e) => {
                                setData('cantidad', Number(e.target.value));
                            }}
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
                            <h3 className="mb-5 mr-2 mt-2 text-lg font-normal text-gray-500 dark:text-gray-400">
                                ¿Seguro que quieres actualizar el sotock de este
                                producto?
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
