import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/app-layout';
import alumnos from '@/routes/alumnos';
import { dashboard } from '@/routes';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Panel de control',
        href: dashboard().url,
    },
];

export default function Dashboard() {
    const { alumnos: alumnosList } = usePage<
        SharedData & { alumnos: AlumnoSummary[] }
    >().props;

    const totalAlumnos = alumnosList.length;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Panel de control" />
            <div className="flex h-full flex-1 flex-col gap-6 overflow-hidden p-4 md:p-6">
                <section className="grid gap-4 md:grid-cols-3">
                    <div className="rounded-2xl border border-sidebar-border/70 bg-gradient-to-br from-[#1c64f2] via-[#1e3a8a] to-[#111827] p-6 text-white shadow-lg dark:border-sidebar-border">
                        <span className="text-xs uppercase tracking-[0.3em] text-white/80">
                            Total de alumnos
                        </span>
                        <p className="mt-3 text-4xl font-semibold">
                            {totalAlumnos}
                        </p>
                        <p className="mt-6 text-sm text-white/70">
                            Gestiona el registro, seguimiento y contacto desde
                            un solo lugar.
                        </p>
                    </div>
                    <div className="rounded-2xl border border-sidebar-border/70 bg-card p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg dark:border-sidebar-border">
                        <h3 className="text-sm font-medium text-muted-foreground">
                            Acciones rápidas
                        </h3>
                        <div className="mt-4 flex flex-col gap-3">
                            <Button asChild variant="outline">
                                <Link href={alumnos.index().url}>Ver alumnos</Link>
                            </Button>
                            <Button asChild>
                                <Link href={alumnos.create().url}>
                                    Registrar alumno
                                </Link>
                            </Button>
                        </div>
                    </div>
                    <div className="rounded-2xl border border-sidebar-border/70 bg-card p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg dark:border-sidebar-border">
                        <h3 className="text-sm font-medium text-muted-foreground">
                            Indicadores clave
                        </h3>
                        <ul className="mt-4 space-y-3 text-sm leading-6 text-muted-foreground">
                            <li>
                                • Revisa los datos de contacto para asegurar una
                                comunicación ágil.
                            </li>
                            <li>
                                • Mantén la información académica actualizada
                                para reportes confiables.
                            </li>
                        </ul>
                    </div>
                </section>

                <section className="flex flex-1 flex-col overflow-hidden rounded-2xl border border-sidebar-border/70 bg-card shadow-sm dark:border-sidebar-border">
                    <div className="flex flex-col gap-2 border-b border-sidebar-border/70 p-6 pb-4 dark:border-sidebar-border md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 className="text-lg font-semibold">
                                Listado de alumnos
                            </h2>
                            <p className="text-sm text-muted-foreground">
                                Vista general de los alumnos registrados en
                                Adalumno.
                            </p>
                        </div>
                        <Button asChild size="sm" variant="default">
                            <Link href={alumnos.create().url}>
                                Añadir alumno
                            </Link>
                        </Button>
                    </div>

                    <div className="flex-1 overflow-auto">
                        {alumnosList.length === 0 ? (
                            <div className="flex h-full flex-col items-center justify-center gap-3 p-10 text-center text-muted-foreground">
                                <p className="text-sm">
                                    Aún no has registrado alumnos. Comienza
                                    creando uno nuevo.
                                </p>
                                <Button asChild size="sm">
                                    <Link href={alumnos.create().url}>
                                        Registrar alumno
                                    </Link>
                                </Button>
                            </div>
                        ) : (
                            <div className="overflow-x-auto">
                                <table className="min-w-full divide-y divide-border">
                                    <thead>
                                        <tr className="text-left text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                                            <th className="px-6 py-4">Alumno</th>
                                            <th className="px-6 py-4">
                                                Código
                                            </th>
                                            <th className="px-6 py-4">
                                                Correo
                                            </th>
                                            <th className="px-6 py-4">
                                                Carrera
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-border text-sm">
                                        {alumnosList.map((alumno) => (
                                            <tr
                                                key={alumno.id}
                                                className="transition hover:bg-muted/40"
                                            >
                                                <td className="px-6 py-4 font-medium text-foreground">
                                                    {alumno.nombre}
                                                </td>
                                                <td className="px-6 py-4 text-muted-foreground">
                                                    {alumno.codigo}
                                                </td>
                                                <td className="px-6 py-4 text-muted-foreground">
                                                    {alumno.correo}
                                                </td>
                                                <td className="px-6 py-4">
                                                    <Badge
                                                        variant="secondary"
                                                        className="rounded-full px-3 py-1 text-xs font-medium"
                                                    >
                                                        {alumno.carrera}
                                                    </Badge>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        )}
                    </div>
                </section>
            </div>
        </AppLayout>
    );
}

interface AlumnoSummary {
    id: number;
    nombre: string;
    codigo: string;
    correo: string;
    carrera: string;
}
