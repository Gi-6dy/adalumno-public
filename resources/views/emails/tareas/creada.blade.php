<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva tarea creada</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; color: #111827;">
    <p>Hola {{ $usuario?->name ?? 'usuario' }},</p>

    <p>
        Tu tarea <strong>{{ $tarea->nombre }}</strong> se registró correctamente en la plataforma.
    </p>

    <p>Resumen:</p>
    <ul>
        <li><strong>Descripción:</strong> {{ $tarea->descripcion }}</li>
        <li><strong>Fecha de entrega:</strong> {{ optional($tarea->fecha_entrega)->format('d/m/Y') }}</li>
    </ul>

    <p>
        Puedes consultarla en cualquier momento entrando a tu panel de tareas.
    </p>

    <p>¡Gracias por mantener tus actividades al día!</p>
</body>
</html>
