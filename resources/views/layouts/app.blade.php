<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
        </style>
        @stack('head')
    </head>
    <body>
        <header>
            <nav>
                <a href="{{ route('alumnos.index') }}">Alumnos</a>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </nav>
        </header>
        <main>
            @yield('content')
        </main>
        @stack('scripts')
    </body>
</html>
