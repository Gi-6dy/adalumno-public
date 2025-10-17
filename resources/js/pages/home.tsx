import AppLogoIcon from '@/components/app-logo-icon';
import { Button } from '@/components/ui/button';
import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import alumnos from '@/routes/alumnos';
import { dashboard, login, register } from '@/routes';
import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

interface PageProps extends SharedData {
    totalAlumnos: number;
    recentAlumnos: AlumnoPreview[];
}

export default function Home() {
    const { auth, totalAlumnos, recentAlumnos } = usePage<PageProps>().props;

    return (
        <>
            <Head title="Adalumno" />
            <div className="flex min-h-screen flex-col bg-[#FDFDFC] text-[#1b1b18] antialiased dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
                <header className="flex items-center justify-between px-6 py-4 lg:px-12">
                    <Link
                        href={auth.user ? dashboard() : login()}
                        className="flex items-center gap-3 font-semibold"
                    >
                        <AppLogoIcon className="size-9 fill-current text-[#1b1b18] dark:text-[#EDEDEC]" />
                        <span className="hidden text-lg tracking-wide sm:inline">
                            Adalumno
                        </span>
                    </Link>

                    <nav className="flex items-center gap-3 text-sm">
                        {auth.user ? (
                            <Button asChild variant="outline">
                                <Link href={dashboard()}>Ir al dashboard</Link>
                            </Button>
                        ) : (
                            <>
                                <Button asChild variant="ghost">
                                    <Link href={login()}>Iniciar sesión</Link>
                                </Button>
                                <Button asChild>
                                    <Link href={register()}>Crear cuenta</Link>
                                </Button>
                            </>
                        )}
                    </nav>
                </header>

                <main className="flex flex-1 flex-col justify-center px-6 pb-12 lg:px-12">
                    <div className="grid gap-8 lg:grid-cols-[1.1fr_1fr]">
                        <div className="relative overflow-hidden rounded-3xl border border-[#19140020] bg-white p-8 shadow-[0px_30px_60px_-30px_rgba(0,0,0,0.35)] dark:border-[#3E3E3A] dark:bg-[#161615] lg:p-12">
                            <PlaceholderPattern className="pointer-events-none absolute inset-0 size-full stroke-[#1b1b18]/10 opacity-50 dark:stroke-white/10" />
                            <div className="relative z-10 max-w-xl space-y-6">
                                <span className="inline-flex items-center rounded-full border border-[#19140035] px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#706f6c] dark:border-[#3E3E3A] dark:text-[#A1A09A]">
                                    Gestión académica
                                </span>
                                <h1 className="text-3xl font-semibold leading-tight sm:text-4xl">
                                    Centraliza la información de tus alumnos y
                                    agiliza la toma de decisiones.
                                </h1>
                                <p className="text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                                    Crea perfiles completos, consulta historiales
                                    y mantén actualizada la comunicación con tu
                                    comunidad educativa desde un panel intuitivo.
                                </p>

                                <div className="grid gap-4 sm:grid-cols-2">
                                    <div className="rounded-2xl bg-[#F8B803] p-5 text-[#1b1b18] shadow-lg dark:bg-[#FF4433] dark:text-[#FFF7ED]">
                                        <span className="text-xs font-semibold uppercase tracking-[0.3em] text-[#1b1b18]/70 dark:text-[#FFF7ED]/80">
                                            Total de alumnos
                                        </span>
                                        <p className="mt-2 text-3xl font-semibold">
                                            {totalAlumnos}
                                        </p>
                                        <p className="mt-3 text-xs text-[#1b1b18]/80 dark:text-[#FFF7ED]/80">
                                            Gestiona expedientes y seguimientos
                                            en segundos.
                                        </p>
                                    </div>

                                    <div className="rounded-2xl border border-[#19140020] bg-white p-5 shadow-sm dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <h2 className="text-xs font-semibold uppercase tracking-[0.3em] text-[#706f6c] dark:text-[#A1A09A]">
                                            Últimos registros
                                        </h2>
                                        <ul className="mt-3 space-y-2 text-sm">
                                            {recentAlumnos.length === 0 ? (
                                                <li className="text-[#706f6c] dark:text-[#A1A09A]">
                                                    Aún no hay alumnos registrados.
                                                </li>
                                            ) : (
                                                recentAlumnos.map((alumno) => (
                                                    <li
                                                        key={alumno.id}
                                                        className="flex items-center justify-between text-[#1b1b18] dark:text-[#EDEDEC]"
                                                    >
                                                        <span className="font-medium">
                                                            {alumno.nombre}
                                                        </span>
                                                        <span className="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                                            {alumno.carrera}
                                                        </span>
                                                    </li>
                                                ))
                                            )}
                                        </ul>
                                    </div>
                                </div>

                                <div className="flex flex-wrap gap-3 pt-2">
                                    <Button asChild>
                                        <Link
                                            href={
                                                auth.user
                                                    ? alumnos.create().url
                                                    : register()
                                            }
                                        >
                                            {auth.user
                                                ? 'Registrar alumno'
                                                : 'Comenzar ahora'}
                                        </Link>
                                    </Button>
                                    <Button asChild variant="outline">
                                        <Link href={alumnos.index().url}>
                                            Ver listado
                                        </Link>
                                    </Button>
                                </div>
                            </div>
                        </div>

                        <aside className="flex flex-col justify-between gap-6 rounded-3xl border border-[#19140020] bg-[#FDF7EB] p-8 shadow-[0px_20px_40px_-40px_rgba(0,0,0,0.35)] dark:border-[#3E3E3A] dark:bg-[#1E1E1C] lg:p-10">
                            <div className="space-y-4 text-sm leading-relaxed text-[#383835] dark:text-[#C5C3BD]">
                                <h2 className="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                    Diseñado para equipos académicos modernos
                                </h2>
                                <p>
                                    Adalumno proporciona herramientas visuales y
                                    colaborativas para simplificar la gestión de
                                    expedientes, seguimiento de carreras y
                                    comunicación con estudiantes.
                                </p>
                                <ul className="space-y-2">
                                    <li>• Panel intuitivo con métricas clave.</li>
                                    <li>
                                        • Registro completo de datos escolares y
                                        personales.
                                    </li>
                                    <li>
                                        • Integración con flujos de trabajo
                                        administrativos.
                                    </li>
                                </ul>
                            </div>
                            <div className="rounded-2xl bg-white/70 p-6 text-sm text-[#1b1b18] shadow-inner dark:bg-black/20 dark:text-[#EDEDEC]">
                                <p className="font-semibold">
                                    “Centralizamos nuestra gestión académica en
                                    cuestión de días. El equipo tiene acceso a la
                                    misma información y trabajamos con mayor
                                    foco.”
                                </p>
                                <p className="mt-4 text-xs uppercase tracking-[0.3em] text-[#706f6c] dark:text-[#A1A09A]">
                                    Coordinación académica
                                </p>
                            </div>
                        </aside>
                    </div>
                </main>
            </div>
        </>
    );
}

interface AlumnoPreview {
    id: number;
    nombre: string;
    codigo: string;
    carrera: string;
}
