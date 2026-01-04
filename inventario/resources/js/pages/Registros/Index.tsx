import RegistroController from '@/actions/App/Http/Controllers/RegistroController';
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
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Registros',
        href: RegistroController.index().url,
    },
];


export default function Index({ Registros }: { Registros: any }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Registros" />

            <div className="pagination mx-4 flex justify-center gap-2">
                {Registros.links.map((link: any, index: number) => (
                    <a
                        key={index}
                        href={link.url || '#'}
                        className={`rounded border px-3 py-1 ${link.active ? 'bg-blue-500 text-white' : ''}`}
                        dangerouslySetInnerHTML={{ __html: link.label }}
                    />
                ))}
            </div>
            <Table>
                <TableCaption>Registros</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Código</TableHead>
                        <TableHead>Nombre</TableHead>
                        <TableHead>Acción</TableHead>
                        <TableHead>Tipo</TableHead>
                        <TableHead>Responsable</TableHead>
                    </TableRow>
                </TableHeader>
                {Registros.data.length > 0 && (
                    <TableBody>
                        {Registros.data.map((registro: any) => (
                            <TableRow key={registro.codigo}>
                                <TableCell>{registro.codigo}</TableCell>
                                <TableCell>
                                    {registro.nombre.length > 30
                                        ? registro.nombre.substring(0, 30) +
                                          '...'
                                        : registro.nombre}
                                </TableCell>
                                <TableCell>{registro.accion}</TableCell>
                                <TableCell>{registro.tipo}</TableCell>
                                <TableCell>{registro.responsable}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                )}
            </Table>

            {/* Paginación */}
            <div className="pagination mt-4 flex justify-center gap-2">
                {Registros.links.map((link: any, index: number) => (
                    <a
                        key={index}
                        href={link.url || '#'}
                        className={`rounded border px-3 py-1 ${link.active ? 'bg-blue-500 text-white' : ''}`}
                        dangerouslySetInnerHTML={{ __html: link.label }}
                    />
                ))}
            </div>
        </AppLayout>
    );
}

