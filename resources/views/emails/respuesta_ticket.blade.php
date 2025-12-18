<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Respuesta a tu ticket</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Hola {{ $ticket->nombre_contacto ?? $ticket->user->name ?? $ticket->proveedor->user->name }},</h2>

    <p>Hemos respondido a tu ticket titulado: <strong>{{ $ticket->titulo }}</strong></p>

    <p><strong>Mensaje del admin:</strong></p>
    <div style="background:#f1f1f1; padding:10px; border-radius:5px;">
        {{ $mensaje }}
    </div>

    <p>Gracias por contactarnos. Si tienes más dudas, puedes responder a este ticket.</p>
</body>
</html>
