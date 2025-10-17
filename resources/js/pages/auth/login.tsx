import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/react';

interface LoginProps {
    status?: string;
    canResetPassword: boolean;
}

export default function Login({ status, canResetPassword }: LoginProps) {
    return (
        <>
            <Head title="Inicia sesión" />
            <div className="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] md:justify-center md:p-10 dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
                <div className="grid w-full max-w-4xl overflow-hidden rounded-3xl border border-[#19140020] bg-white shadow-[0px_30px_60px_-30px_rgba(0,0,0,0.45)] dark:border-[#3E3E3A] dark:bg-[#161615] lg:grid-cols-[1.1fr_1fr]">
                    <div className="relative hidden min-h-[18rem] bg-[#F8B803] lg:flex dark:bg-[#FF4433]">
                        <PlaceholderPattern className="absolute inset-0 size-full stroke-[#1b1b18]/30 opacity-30 dark:stroke-white/20" />
                        <div className="relative z-10 flex flex-col justify-between p-10 text-[#1b1b18] dark:text-[#FFF7ED]">
                            <div className="flex flex-col gap-2 text-sm uppercase tracking-[0.3em] text-[#1b1b18]/60 dark:text-[#FFF7ED]/70">
                                <span>Adalumno</span>
                                <span>Gestión Académica</span>
                            </div>
                            <div className="space-y-3">
                                <h2 className="text-3xl font-semibold leading-tight">
                                    Bienvenido de nuevo
                                </h2>
                                <p className="text-sm leading-relaxed text-[#1b1b18]/80 dark:text-[#FFF7ED]/80">
                                    Centraliza la información de tus alumnos y
                                    mantén todo sincronizado en un solo lugar.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div className="flex flex-col gap-8 p-6 sm:p-10">
                        <div className="flex flex-col gap-2 text-left">
                            <h1 className="text-2xl font-semibold">
                                Inicia sesión
                            </h1>
                            <p className="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                Ingresa tu nombre y contraseña para continuar.
                            </p>
                        </div>

                        {status && (
                            <div className="rounded-lg bg-green-100 px-4 py-3 text-sm font-medium text-green-700 dark:bg-green-500/10 dark:text-green-300">
                                {status}
                            </div>
                        )}

                        <Form
                            {...store.form()}
                            resetOnSuccess={['password']}
                            className="flex flex-col gap-6"
                        >
                            {({ processing, errors }) => (
                                <>
                                    <div className="grid gap-6">
                                        <div className="grid gap-2">
                                            <Label htmlFor="name">
                                                Nombre de usuario
                                            </Label>
                                            <Input
                                                id="name"
                                                type="text"
                                                name="name"
                                                required
                                                autoFocus
                                                tabIndex={1}
                                                autoComplete="username"
                                                placeholder="Ej. juan.perez"
                                            />
                                            <InputError message={errors.name} />
                                        </div>

                                        <div className="grid gap-2">
                                            <div className="flex items-center">
                                                <Label htmlFor="password">
                                                    Contraseña
                                                </Label>
                                                {canResetPassword && (
                                                    <TextLink
                                                        href={request()}
                                                        className="ml-auto text-sm"
                                                        tabIndex={5}
                                                    >
                                                        ¿Olvidaste tu
                                                        contraseña?
                                                    </TextLink>
                                                )}
                                            </div>
                                            <Input
                                                id="password"
                                                type="password"
                                                name="password"
                                                required
                                                tabIndex={2}
                                                autoComplete="current-password"
                                                placeholder="••••••••"
                                            />
                                            <InputError
                                                message={errors.password}
                                            />
                                        </div>

                                        <div className="flex items-center space-x-3">
                                            <Checkbox
                                                id="remember"
                                                name="remember"
                                                tabIndex={3}
                                            />
                                            <Label htmlFor="remember">
                                                Recordarme
                                            </Label>
                                        </div>

                                        <Button
                                            type="submit"
                                            className="mt-2 w-full"
                                            tabIndex={4}
                                            disabled={processing}
                                            data-test="login-button"
                                        >
                                            {processing && <Spinner />}
                                            Entrar
                                        </Button>
                                    </div>

                                    <div className="text-center text-sm text-muted-foreground">
                                        ¿Aún no tienes cuenta?{' '}
                                        <TextLink href={register()} tabIndex={6}>
                                            Regístrate
                                        </TextLink>
                                    </div>
                                </>
                            )}
                        </Form>
                    </div>
                </div>
            </div>
        </>
    );
}
