import AlmacenController from '@/actions/App/Http/Controllers/AlmacenController';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Eye, PackagePlus, PencilLine, Trash2 } from 'lucide-react';

interface Almacen {
    id: number;
    codigo: number;
    nombre: string;
    descripcion: string;
    ubicacion: string;
    estado: boolean;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Almacenes',
        href: AlmacenController.index().url,
    },
];

export default function Index({ Almacenes }: { Almacenes: any }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Almacenes" />
            <nav className="flex-row">
                <Link href={AlmacenController.create().url}>
                    <Button className="m-4 bg-green-500 hover:bg-green-700">
                        <PackagePlus /> Crear Almacen
                    </Button>
                </Link>

                <Link href={AlmacenController.papelera().url}>
                    <Button className="m-4 bg-red-500 hover:bg-red-700">
                        <Trash2 /> Papelera
                    </Button>
                </Link>
            </nav>
            <Table>
                <TableCaption>Almacenes</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Código</TableHead>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Descripción</TableHead>
                        <TableHead>Ubicación</TableHead>
                        <TableHead>Estado</TableHead>
                        <TableHead>Acciones</TableHead>
                    </TableRow>
                </TableHeader>
                {Almacenes.data.length > 0 && (
                    <TableBody>
                        {Almacenes.data.map((Almacenes: any) => (
                            <TableRow key={Almacenes.codigo}>
                                <TableCell>{Almacenes.codigo}</TableCell>
                                <TableCell>
                                    {Almacenes.nombre.length > 30
                                        ? Almacenes.nombre.substring(0, 30) +
                                          '...'
                                        : Almacenes.nombre}
                                </TableCell>
                                <TableCell>
                                    <TableCell>
                                        {Almacenes.descripcion?.length > 50
                                            ? Almacenes.descripcion.substring(
                                                  0,
                                                  50,
                                              ) + '...'
                                            : (Almacenes.descripcion ??
                                              'Sin Descripcion')}
                                    </TableCell>
                                </TableCell>
                                <TableCell>{Almacenes.ubicacion}</TableCell>
                                <TableCell>
                                    {Almacenes.estado == true
                                        ? 'Activo'
                                        : 'Inactivo'}
                                </TableCell>
                                <TableCell className="flex-row space-x-2">
                                    <Link href={'localhost'}>
                                        <Button className="bg-yellow-500 hover:bg-yellow-700">
                                            <Eye />
                                        </Button>
                                    </Link>
                                    <Link href={'#'}>
                                        <Button className="bg-orange-500 hover:bg-orange-700">
                                            <PencilLine />
                                        </Button>
                                    </Link>
                                    <Button
                                        className="bg-red-500 hover:bg-red-700"
                                        onClick={() => {}}
                                    >
                                        <Trash2 />
                                    </Button>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                )}
            </Table>
        </AppLayout>
    );
}
