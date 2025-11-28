<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="light dark">
        <title>@yield('title', config('app.name', 'Aplicación'))</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                color: #1f2933;
                background-color: #f4f5f7;
                margin: 0;
            }

            header {
                background-color: #1c64f2;
                color: #fff;
                padding: 1rem;
            }

            main {
                padding: 2rem;
                max-width: 900px;
                margin: 0 auto;
            }

            a {
                color: #1c64f2;
            }

            .card {
                background-color: #fff;
                border-radius: 0.5rem;
                padding: 1.5rem;
                box-shadow: 0 5px 15px rgba(15, 23, 42, 0.1);
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table th,
            table td {
                padding: 0.75rem;
                border-bottom: 1px solid #e5e7eb;
                text-align: left;
            }

            form.inline {
                display: inline;
            }

            .actions a,
            .actions button {
                margin-right: 0.5rem;
            }

            .alert {
                border-radius: 0.5rem;
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .alert-success {
                background-color: #dcfce7;
                color: #166534;
            }

            .alert-danger {
                background-color: #fee2e2;
                color: #991b1b;
            }

            label {
                display: block;
                font-weight: 600;
                margin-bottom: 0.5rem;
            }

            input,
            select {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #d1d5db;
                border-radius: 0.375rem;
                margin-bottom: 1rem;
            }

            button {
                background-color: #1c64f2;
                color: #fff;
                border: none;
                padding: 0.75rem 1.25rem;
                border-radius: 0.375rem;
                cursor: pointer;
            }

            nav a {
                color: #fff;
                margin-right: 1rem;
                font-weight: 500;
                text-decoration: none;
            }

            .user-info {
                margin-bottom: 15px;
                padding: 10px;
                background: #f0f0f0;
                border-radius: 4px;
            }

            @media (prefers-color-scheme: dark) {
                body {
                    color: #e5e7eb;
                    background-color: #020617;
                }

                header {
                    background-color: #020617;
                    color: #e5e7eb;
                }

                a {
                    color: #60a5fa;
                }

                .card {
                    background-color: #020617;
                    border: 1px solid #1f2937;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6);
                }

                table th,
                table td {
                    border-bottom-color: #1f2937;
                }

                nav a {
                    color: #e5e7eb;
                }

                .alert-success {
                    background-color: #14532d;
                    color: #bbf7d0;
                }

                .alert-danger {
                    background-color: #7f1d1d;
                    color: #fee2e2;
                }

                .user-info {
                    background: #111827;
                    color: #e5e7eb;
                }

                button {
                    background-color: #2563eb;
                    color: #e5e7eb;
                }
            }

            /* Forzado manual: html.theme-dark / html.theme-light
               - theme-dark: aplica modo oscuro aunque el sistema sea claro
               - theme-light: fuerza modo claro aunque el sistema sea oscuro */
            html.theme-dark body {
                color: #e5e7eb;
                background-color: #020617;
            }

            html.theme-dark header {
                background-color: #020617;
                color: #e5e7eb;
            }

            html.theme-dark a {
                color: #60a5fa;
            }

            html.theme-dark .card {
                background-color: #020617;
                border: 1px solid #1f2937;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6);
            }

            html.theme-dark table th,
            html.theme-dark table td {
                border-bottom-color: #1f2937;
            }

            html.theme-dark nav a {
                color: #e5e7eb;
            }

            html.theme-dark .alert-success {
                background-color: #14532d;
                color: #bbf7d0;
            }

            html.theme-dark .alert-danger {
                background-color: #7f1d1d;
                color: #fee2e2;
            }

            html.theme-dark .user-info {
                background: #111827;
                color: #e5e7eb;
            }

            html.theme-dark button {
                background-color: #2563eb;
                color: #e5e7eb;
            }

            html.theme-light body {
                color: #1f2933;
                background-color: #f4f5f7;
            }

            html.theme-light header {
                background-color: #1c64f2;
                color: #fff;
            }

            html.theme-light a {
                color: #1c64f2;
            }

            html.theme-light .card {
                background-color: #fff;
                border: none;
                box-shadow: 0 5px 15px rgba(15, 23, 42, 0.1);
            }

            html.theme-light table th,
            html.theme-light table td {
                border-bottom-color: #e5e7eb;
            }

            html.theme-light nav a {
                color: #fff;
            }

            html.theme-light .alert-success {
                background-color: #dcfce7;
                color: #166534;
            }

            html.theme-light .alert-danger {
                background-color: #fee2e2;
                color: #991b1b;
            }

            html.theme-light .user-info {
                background: #f0f0f0;
                color: #1f2933;
            }

            html.theme-light button {
                background-color: #1c64f2;
                color: #fff;
            }
        </style>
        @stack('head')
    </head>
    <body>
        <header>
            <nav>
                <a href="{{ route('alumnos.index') }}">Alumnos</a>
                <a href="{{ route('secciones.index') }}">Secciones</a>
                <a href="{{ route('tareas.index') }}">Tareas</a>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <button type="button" id="theme-toggle">Tema: Sistema</button>
            </nav>
        </header>
        <main>
            @yield('content')
        </main>
        @stack('scripts')
        <script>
            (function () {
                var storageKey = 'theme';
                var root = document.documentElement;

                function applyTheme(theme) {
                    root.classList.remove('theme-light', 'theme-dark');

                    if (theme === 'dark') {
                        root.classList.add('theme-dark');
                    } else if (theme === 'light') {
                        root.classList.add('theme-light');
                    }

                    var metaColorScheme = document.querySelector('meta[name="color-scheme"]');
                    if (metaColorScheme) {
                        if (theme === 'dark') {
                            metaColorScheme.setAttribute('content', 'dark');
                        } else if (theme === 'light') {
                            metaColorScheme.setAttribute('content', 'light');
                        } else {
                            metaColorScheme.setAttribute('content', 'light dark');
                        }
                    }

                    var btn = document.getElementById('theme-toggle');
                    if (btn) {
                        var label = 'Sistema';
                        if (theme === 'dark') {
                            label = 'Oscuro';
                        } else if (theme === 'light') {
                            label = 'Claro';
                        }
                        btn.textContent = 'Tema: ' + label;
                    }
                }

                var saved = localStorage.getItem(storageKey) || 'system';
                applyTheme(saved);

                window.addEventListener('DOMContentLoaded', function () {
                    var btn = document.getElementById('theme-toggle');
                    if (!btn) {
                        return;
                    }

                    btn.addEventListener('click', function () {
                        var current = localStorage.getItem(storageKey) || 'system';
                        var next = current === 'system' ? 'dark' : current === 'dark' ? 'light' : 'system';

                        localStorage.setItem(storageKey, next);
                        applyTheme(next);
                    });
                });
            })();
        </script>
    </body>
</html>
