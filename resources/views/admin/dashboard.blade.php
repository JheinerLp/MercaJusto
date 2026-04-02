<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/Menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/Admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/Gestion.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <header class="header">
    @include('components.header')
    </header>
    @include('components.lupa')
    

   <main class="admin-panel">
    <h2 style="text-align: center;">Administración</h2>

    <div class="tabs">
        <button class="tab-button" onclick="abrirModalCredenciales()">
    Credenciales
</button>
        <a href="{{ route('admin.solicitudes') }}" class="tab-button" style="text-decoration:none;">
            Solicitudes</a>
       <button class="tab-button" onclick="window.location='{{ route('admin.proveedores') }}'">
    Proveedores
</button>
     <button class="tab-button" onclick="window.location='{{ route('admin.productos') }}'">
    Productos
</button>

        <button class="tab-button" onclick="window.location='{{ route('admin.tickets') }}'">
    Soporte
</button>

        <button class="tab-button" onclick="abrirModalCarrusel()">
    Carrusel
</button>

    </div>

    <section id="dashboard" class="tab-content active">
        <!-- Aquí van estadísticas rápidas -->
       <div class="dashboard">
   <div class="card">
        <h4>Proveedores</h4>
        <p>{{ $totalActivos }}</p>
    </div>
<div class="card">
    <h4>Productos</h4>
    <p> {{ $totalProductos }}</p>
</div>

   <div class="card">
    <h4>Solicitudes Pendientes</h4>
    <p class="numero-solicitudes">
        {{ $solicitudesPendientes->count() }}
    </p>
</div>

  <div class="card">
    <h4>Soporte</h4>
    <p>{{ $totalTickets }}</p>
</div>
</div>
    </section>

    <section>
        
</section>

    <section id="proveedores" class="tab-content">
        <h3>Proveedores Registrados</h3>
        <div class="contenedor-cards" id="contenedorProveedores"></div>
    </section>

    <section id="clientes" class="tab-content">
        <h3>Clientes Registrados</h3>
        <!-- Aquí una tabla o lista de clientes -->
    </section>

    <section id="soporte" class="tab-content">
        <h3>Mensajes de Soporte</h3>
        <!-- Lista de mensajes enviados desde la sección de soporte -->
    </section>
</main>

{{-- Modal del Carrusel --}}
<div id="modalCarrusel" class="modal">
    <div class="modal-content">
        <span class="cerrar" onclick="cerrarModalCarrusel()">&times;</span>
        <h3>Gestión del Carrusel Principal</h3>
        <p style="text-align: center; color: #666; margin-bottom: 20px;">
            Actualiza las imágenes que se muestran en el carrusel de la página principal
        </p>

        <form action="{{ route('admin.carrusel.actualizar') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="carrusel-grid">
                @php
                    $imagenes = ['Carrusel.jpg', 'Carrusel2.jpeg', 'Carrusel3.jpeg', 'Carrusel4.jpeg'];
                @endphp
                @for($i = 1; $i <= 4; $i++)
                <div class="imagen-item">
                    <h4>Imagen {{ $i }}</h4>
                    @php
                        $rutaImagen = public_path('Images/' . $imagenes[$i-1]);
                        $existeImagen = file_exists($rutaImagen);
                    @endphp
                    <img src="{{ $existeImagen ? asset('Images/' . $imagenes[$i-1]) . '?v=' . time() : 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjE1MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMjAwIiBoZWlnaHQ9IjE1MCIgZmlsbD0iI2YwZjBmMCIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiM5OTk5OTkiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5TdWJpciBpbWFnZW48L3RleHQ+PC9zdmc+' }}" 
                         alt="Carrusel {{ $i }}" 
                         class="imagen-preview" 
                         id="preview{{ $i }}"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjE1MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMjAwIiBoZWlnaHQ9IjE1MCIgZmlsbD0iI2YwZjBmMCIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiM5OTk5OTkiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5JbWFnZW4gbm8gZGlzcG9uaWJsZTwvdGV4dD48L3N2Zz4='">
                    
                    <input type="file" 
                           name="imagen{{ $i }}" 
                           id="imagen{{ $i }}" 
                           accept="image/jpeg,image/jpg,image/png,image/webp" 
                           onchange="previewImage({{ $i }}, this)">
                    <p class="info-text">Máximo 5MB - JPG, PNG o WEBP</p>
                </div>
                @endfor
            </div>

            <button type="submit" class="btn-guardar-carrusel">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </form>
    </div>
</div>

{{-- Modal de Credenciales --}}
<div id="modalCredenciales" class="modal">
    <div class="modal-content modal-credenciales">
        <span class="cerrar" onclick="cerrarModalCredenciales()">&times;</span>
        <h3>Actualizar Credenciales de Administrador</h3>
        <p style="text-align: center; color: #666; margin-bottom: 20px;">
            Modifica tu información personal y credenciales de acceso
        </p>

        <form action="{{ route('admin.credenciales.actualizar') }}" method="POST" id="formCredenciales">
            @csrf

            <div class="form-group-credenciales">
                <label for="name">Nombre Completo</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ auth()->user()->name }}" 
                       class="input-credenciales"
                       required>
            </div>

            <div class="form-group-credenciales">
                <label for="email">Correo Electrónico</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="{{ auth()->user()->email }}" 
                       class="input-credenciales"
                       required>
            </div>

            <div class="form-group-credenciales">
                <label for="email_confirmation">Confirmar Correo Electrónico</label>
                <input type="email" 
                       name="email_confirmation" 
                       id="email_confirmation" 
                       placeholder="Repite el correo electrónico" 
                       class="input-credenciales"
                       required>
            </div>

            <div class="form-group-credenciales">
                <label for="password">Nueva Contraseña</label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       placeholder="Dejar vacío si no quieres cambiar la contraseña" 
                       class="input-credenciales"
                       minlength="8">
                <small style="color: #666; font-size: 0.85rem;">Mínimo 8 caracteres</small>
            </div>

            <div class="form-group-credenciales">
                <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                <input type="password" 
                       name="password_confirmation" 
                       id="password_confirmation" 
                       placeholder="Repite la nueva contraseña" 
                       class="input-credenciales"
                       minlength="8">
                      
            </div>
             <!-- 🔥 BOTÓN OTP AQUÍ -->
<button type="button" onclick="enviarCodigo()" class="btn-guardar-carrusel">
    📩 Enviar código de verificación
</button>

<!-- 🔐 INPUT DEL CÓDIGO -->
<div class="form-group-credenciales">
    <label for="otp_code">Código de verificación</label>
    <input type="text" 
           name="otp_code" 
           id="otp_code"
           placeholder="Ingresa el código enviado al correo" 
           class="input-credenciales"
           required>
           <small id="mensajeOTP" class="mensaje-otp" style="display:none;">
    📩 Código enviado, revisa tu correo
</small>
<style>
.mensaje-otp {
    display: block;
    margin-top: 10px;
    padding: 10px 15px;
    background: linear-gradient(135deg, #4caf50, #66bb6a);
    color: white;
    border-radius: 10px;
    font-size: 0.9rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    animation: slideIn 0.4s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
    </style>

</div>
            <button type="submit" class="btn-guardar-carrusel">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </form>
    </div>
</div>

@if(session('success'))
<div id="toastSuccess" class="toast-success show">
    {{ session('success') }}
</div>
<script>
    setTimeout(() => {
        const toast = document.getElementById('toastSuccess');
        if (toast) {
            toast.classList.remove('show');
        }
    }, 3000);
</script>
@endif

@if(session('error'))
<div id="toastError" class="toast-success show" style="background-color: #f44336;">
    {{ session('error') }}
</div>
<script>
    setTimeout(() => {
        const toast = document.getElementById('toastError');
        if (toast) {
            toast.classList.remove('show');
        }
    }, 4000);
</script>
@endif

    

    
    <script>
        
    function showTab(tabId) {
        const contents = document.querySelectorAll('.tab-content');
        const buttons = document.querySelectorAll('.tab-button');

        contents.forEach(c => c.classList.remove('active'));
        buttons.forEach(b => b.classList.remove('active'));

        document.getElementById(tabId).classList.add('active');
        event.target.classList.add('active');
    }

   

    // Funciones para el modal del carrusel
    function abrirModalCarrusel() {
        document.getElementById('modalCarrusel').style.display = 'flex';
    }

    function cerrarModalCarrusel() {
        document.getElementById('modalCarrusel').style.display = 'none';
    }

    function previewImage(num, input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview' + num).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Cerrar modal al hacer clic fuera
    window.onclick = function(event) {
        const modalCarrusel = document.getElementById('modalCarrusel');
        const modalCredenciales = document.getElementById('modalCredenciales');
        
        if (event.target == modalCarrusel) {
            cerrarModalCarrusel();
        }
        
        if (event.target == modalCredenciales) {
            cerrarModalCredenciales();
        }
    }

    // Funciones para el modal de credenciales
    function abrirModalCredenciales() {
        document.getElementById('modalCredenciales').style.display = 'flex';
        // Llenar el campo de confirmación de email con el email actual
        const email = document.getElementById('email').value;
        document.getElementById('email_confirmation').value = email;
    }

    function cerrarModalCredenciales() {
        document.getElementById('modalCredenciales').style.display = 'none';
        // Limpiar campos de contraseña al cerrar
        document.getElementById('password').value = '';
        document.getElementById('password_confirmation').value = '';
    }

    // Validación del formulario de credenciales
    document.getElementById('formCredenciales').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const emailConfirmation = document.getElementById('email_confirmation').value;
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;

        // Validar que los correos coincidan
        if (email !== emailConfirmation) {
            e.preventDefault();
            alert('Los correos electrónicos no coinciden');
            return false;
        }

        // Si se ingresa contraseña, validar que coincidan
        if (password && password !== passwordConfirmation) {
            e.preventDefault();
            alert('Las contraseñas no coinciden');
            return false;
        }

        // Si se ingresa contraseña, validar longitud mínima
        if (password && password.length < 10) {
            e.preventDefault();
            alert('La contraseña debe tener al menos 10 caracteres');
            return false;
        }
    });
</script>
<script>
    function enviarCodigo() {
    fetch("{{ route('admin.enviar.codigo') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(() => {
        const mensaje = document.getElementById('mensajeOTP');
        mensaje.style.display = 'block';

        // Ocultar después de 5 segundos
        setTimeout(() => {
            mensaje.style.display = 'none';
        }, 5000);
    })
    .catch(() => {
        alert("Error al enviar código");
    });
}
    </script>
    <script src="{{ asset('js/Generalidades.js') }}"></script>
    
    
    @include('components.footer')
    
</body>
</html>
