import LotesController from '@/actions/App/Http/Controllers/LotesController';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { CircleCheck, CircleX } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lotes',
        href: LotesController.index().url,
    },
    {
        title: 'Crear Lote',
        href: '#',
    },
];

interface Product {
    id: number;
    uuid: string;
    nombre: string;
}

interface Almacen {
    id: number;
    uuid: string;
    nombre: string;
}

interface Props {
    products: Product[];
    almacens: Almacen[];
}

export default function Create({ products, almacens }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        descripcion: '',
        producto_id: null as number | null,
        cantidad: '',
        almacen_id: null as number | null,
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        post(LotesController.store().url);
    };

    // Helpers para obtener el nombre seleccionado
    const getProductName = (id: number | null) =>
        products.find((p) => p.id === id)?.nombre || 'CLICK AQUI !!!';

    const getAlmacenName = (id: number | null) =>
        almacens.find((a) => a.id === id)?.nombre || 'CLICK AQUI !!!';

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Lote" />
            <div className="w-8/12 p-4">
                <form onSubmit={handleSubmit}>
                    {/* Descripción */}
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="descripcion" className="mb-1.5 block">
                            Descripción de Lote:
                        </Label>
                        <Input
                            id="descripcion"
                            placeholder="Ej: Lote de emergencia Mayo"
                            value={data.descripcion}
                            onChange={(e) =>
                                setData('descripcion', e.target.value)
                            }
                        />
                        {errors.descripcion && (
                            <div className="mt-1 text-sm text-red-500">
                                {errors.descripcion}
                            </div>
                        )}
                    </div>

                    {/* Producto (Estilo Dropdown MVP) */}
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Producto" className="mb-1.5 block">
                            Producto:
                        </Label>
                        <DropdownMenu>
                            <DropdownMenuTrigger className="w-full text-left">
                                <Input
                                    id="Producto"
                                    placeholder="CLICK AQUI !!!"
                                    value={
                                        data.producto_id
                                            ? getProductName(data.producto_id)
                                            : ''
                                    }
                                    disabled={true}
                                    className="cursor-pointer"
                                />
                            </DropdownMenuTrigger>
                            <DropdownMenuContent className="w-[var(--radix-dropdown-menu-trigger-width)]">
                                <DropdownMenuLabel>
                                    Selecciona Producto
                                </DropdownMenuLabel>
                                {products.map((p) => (
                                    <DropdownMenuItem
                                        key={p.uuid}
                                        onClick={() =>
                                            setData('producto_id', p.id)
                                        }
                                    >
                                        {p.nombre}
                                    </DropdownMenuItem>
                                ))}
                            </DropdownMenuContent>
                        </DropdownMenu>
                        {errors.producto_id && (
                            <div className="mt-1 text-sm text-red-500">
                                {errors.producto_id}
                            </div>
                        )}
                    </div>

                    {/* Cantidad */}
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="cantidad" className="mb-1.5 block">
                            Unidades:
                        </Label>
                        <Input
                            id="cantidad"
                            type="number"
                            placeholder="0"
                            value={data.cantidad}
                            onChange={(e) =>
                                setData('cantidad', e.target.value)
                            }
                        />
                        {errors.cantidad && (
                            <div className="mt-1 text-sm text-red-500">
                                {errors.cantidad}
                            </div>
                        )}
                    </div>

                    {/* Almacén (Estilo Dropdown MVP) */}
                    <div className="mb-4 gap-1.5">
                        <Label htmlFor="Almacen" className="mb-1.5 block">
                            Almacén de destino:
                        </Label>
                        <DropdownMenu>
                            <DropdownMenuTrigger className="w-full text-left">
                                <Input
                                    id="Almacen"
                                    placeholder="CLICK AQUI !!!"
                                    value={
                                        data.almacen_id
                                            ? getAlmacenName(data.almacen_id)
                                            : ''
                                    }
                                    disabled={true}
                                    className="cursor-pointer"
                                />
                            </DropdownMenuTrigger>
                            <DropdownMenuContent className="w-[var(--radix-dropdown-menu-trigger-width)]">
                                <DropdownMenuLabel>
                                    Selecciona Almacén
                                </DropdownMenuLabel>
                                {almacens.map((a) => (
                                    <DropdownMenuItem
                                        key={a.uuid}
                                        onClick={() =>
                                            setData('almacen_id', a.id)
                                        }
                                    >
                                        {a.nombre}
                                    </DropdownMenuItem>
                                ))}
                            </DropdownMenuContent>
                        </DropdownMenu>
                        {errors.almacen_id && (
                            <div className="mt-1 text-sm text-red-500">
                                {errors.almacen_id}
                            </div>
                        )}
                    </div>

                    {/* Botones de Acción */}
                    <div className="flex flex-row space-x-2 pt-4">
                        <Button
                            className="bg-green-600 hover:bg-green-700"
                            type="submit"
                            disabled={processing}
                        >
                            <CircleCheck className="mr-2 h-4 w-4" /> Registrar
                            Lote
                        </Button>

                        <Link href={LotesController.index().url}>
                            <Button
                                className="bg-red-500 hover:bg-red-700"
                                type="button"
                            >
                                <CircleX className="mr-2 h-4 w-4" /> Cancelar
                            </Button>
                        </Link>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
