<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Universidad del Valle</title>

    <meta name="description" content="Portal de inicio de sesión de la Universidad del Valle para administradores y proveedores de la Muestra Agroindustrial, Artesanal y de Servicios.">

    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/Login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <link rel="icon" href="{{ asset('Images/favicon.ico') }}" type="image/x-icon">
</head>

<body>

    <header class="header" role="banner">
        <div class="Header_Conter_blanco">
            <img src="{{ asset('Images/logounivallemenu.JPG') }}" alt="Logo Universidad del Valle" class="imagen" width="80" height="auto">
            <h1>Universidad del Valle</h1>
        </div>
        <div class="menu-container" aria-hidden="true"></div>
    </header>
@include('components.toast')
    <main>
        <section class="Imagen-login" aria-hidden="true">
            <img src="{{ asset('Images/fondo-frutas-verduras-LOGIN.JPG') }}" alt="Imagen de fondo con frutas y verduras para el login">
        </section>

        <div class="container">

            <section class="login-section" aria-label="Formulario de acceso">
                <div class="login-box">
                    <div class="form-container">
                        <img src="{{ asset('Images/70_Rojo.jpg') }}" alt="Logo conmemorativo Universidad del Valle 70 años" class="form-logo" width="100">

                        <form method="POST" action="{{ route('login') }}" role="form" aria-labelledby="login-heading">
                            @csrf
                            <h2 id="login-heading">Iniciar sesión</h2>

                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email" placeholder="Ingrese su correo" required aria-required="true">

                            <label for="password">Contraseña</label>
                            <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required aria-required="true">

                            <button type="submit" aria-label="Entrar al sistema">Entrar</button>

                            <div class="links">
                                <a href="{{ url('/') }}">¿Olvidó su nombre o contraseña?</a>
                                <a href="#" onclick="abrirModal('modalSolicitudProveedor')">Registrarse</a>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            
            
        </div>
    </main>
    @include('components.modal-solicitud')
    <footer class="footer-container" role="contentinfo">
        @include('components.footer')
    </footer>

    

</body>

</html>
