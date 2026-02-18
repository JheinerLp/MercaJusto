<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/Pago.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header class="header">
        @include('components.header')  
    </header>

    @include('components.lupa')

    <section class="forma-pago">
    <h2>Forma de Pago</h2>
    <div class="pago-content">
        <div class="pago-img">
            <img src="{{ asset('Images/Nequi.jpg') }}" alt="Logo de Nequi">
        </div>
        <div class="pago-info">
            <p>
                Nuestros comerciantes prefieren <strong>Nequi</strong> por ser una opción rápida, segura y sin comisiones. 
                Puedes enviar y recibir dinero al instante sin necesidad de una cuenta bancaria tradicional. 
            </p>
            <ul>
                <li>✔️ Sin costo por transacción</li>
                <li>✔️ Fácil de usar desde cualquier celular</li>
                <li>✔️ No requiere cuenta bancaria</li>
            </ul>
            <p><a href="https://www.nequi.com.co/" target="_blank">🔗 Saber más en el sitio oficial de Nequi</a></p>
            <div class="whatsapp-soporte">
    <a href="https://wa.me/573001234567" target="_blank" rel="noopener noreferrer">
        💬 Contactar por WhatsApp
    </a>
</div>
        </div>
    </div>
</section>
<section class="problemas-comprobacion">
    <h2>Recomendaciones Importantes</h2>
    <p>Estos son algunos consejos </p>
    
    <div class="guia-comprobacion">
        <div class="paso">
            <img src="{{ asset('Images/Wassap.jpeg') }}" alt="Toma evidencia">
            <p><strong>Paso 1:</strong> Asegurese de que el numero suministrado por el proveedor es correcto no siempre es el de Wassap</p>
        </div>
        <div class="paso">
            <img src="{{ asset('Images/Robo.jpg') }}" alt="Contacto con soporte">
            <p><strong>Paso 2:</strong> Compruebe y guarde todas las evidencias de la compra en caso de robo hable con soporte para el decuado reporte del proveedor</p>
        </div>
    </div>
</section>
    <footer class="footer-container">
    @include('components.footer')
    </footer>

    <script src="{{ asset('Js/Generalidades.js') }}"></script>
</body>
</html>
