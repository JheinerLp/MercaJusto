<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Solicitud Aceptada</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f8f8f8; padding:20px;">
    <div style="max-width:600px; margin:auto; background:white; padding:25px; border-radius:10px;">
        
        <!-- Banner del Correo -->
        <div style="text-align: center; margin-bottom: 25px;">
            <img src="{{ $message->embed(public_path('images/Banneremail.JPG')) }}" alt="MercaJusto Banner" style="width: 100%; max-width: 600px; height: auto; border-radius: 8px;">
        </div>
        
        <h2 style="color:#28a745;">¡Felicidades {{ $user->name }}!</h2>

        <p>Tu solicitud para convertirte en proveedor de <strong>Mercajusto</strong> ha sido aceptada.</p>

        <p>A continuación encontrarás tus credenciales de acceso:</p>

        <div style="background:#f1f1f1; padding:15px; border-radius:8px; margin-top:10px;">
            <p><strong>Correo:</strong> {{ $user->email }}</p>
            <p><strong>Contraseña:</strong> {{ $password }}</p>
        </div>

        <p>Puedes iniciar sesión aquí:</p>

        <a href="{{ url('/login') }}"
           style="display:inline-block; padding:10px 18px; background:#28a745; color:white; 
                  border-radius:5px; text-decoration:none;">
            Iniciar Sesión
        </a>

        <p style="margin-top:25px;">¡Bienvenido a nuestra red de proveedores!</p>

        <p style="font-size:12px; margin-top:30px; color:#777;">
            Si no solicitaste este registro, ignora este mensaje.
        </p>

    </div>
</body>
</html>
