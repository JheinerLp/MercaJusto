<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Solicitud Rechazada</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f8f8f8; padding:20px;">
    <div style="max-width:600px; margin:auto; background:white; padding:25px; border-radius:10px;">
        
        <h2 style="color:#dc3545;">Solicitud Rechazada</h2>

        <p>Hola <strong>{{ $solicitud->nombre }}</strong>,</p>

        <p>Lamentamos informarte que tu solicitud para ser proveedor en <strong>Mercajusto</strong> fue rechazada.</p>

        <p><strong>Motivo:</strong></p>

        <div style="background:#f8d7da; padding:15px; border-radius:8px; color:#721c24;">
            {{ $solicitud->motivo_rechazo }}
        </div>

        <p style="margin-top:20px;">
            Si deseas volver a enviar la solicitud, puedes hacerlo en cualquier momento.
        </p>

        <p style="font-size:12px; margin-top:30px; color:#777;">
            Este mensaje es informativo. No respondas a este correo.
        </p>

    </div>
</body>
</html>
