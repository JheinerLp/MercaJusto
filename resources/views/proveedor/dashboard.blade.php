<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Proveedor</title>

    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/Menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/ProveedorVista.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
<header class="header">
    @include('components.header')
</header>

<main class="proveedor-vista">

    {{-- ============================
        BANNER DEL PROVEEDOR
    ============================= --}}
    <section class="proveedor-banner" onclick="abrirModal('modalBanner')">

    <img src="{{ $proveedor->banner ?? asset('img/default-banner.jpg') }}" alt="Banner proveedor">

    <div class="overlay-banner">
        <i class="fas fa-camera"></i>
        <span>Cambiar banner</span>
    </div>

</section>

    {{-- ============================
         FOTO + INFO DEL PROVEEDOR
    ============================= --}}
    <section class="proveedor-info">

        {{-- FOTO --}}
        <div class="foto-container" onclick="abrirModal('modalFoto')">

        <img src="{{ $proveedor->foto ?? asset('img/default-foto.jpg') }}" alt="Foto proveedor">

        <div class="overlay-camara">
        <i class="fas fa-camera"></i>
    </div>

</div>

        {{-- NOMBRE --}}
        <h2 class="nombre-proveedor">{{ $proveedor->empresa ?? 'Proveedor sin nombre' }}</h2>

        {{-- CATEGORÍA --}}
        <p class="categoria">
            <strong>Categoría:</strong> {{ $proveedor->categoria->nombre ?? 'Sin categoría' }}
        </p>


        <div class="datos-proveedor">

    {{-- CREDENCIALES --}}
    <div class="dato credenciales-box">
        <p><strong>Cuenta</strong><br>Configura tu acceso</p>

        <button class="btn-guardar btn-credenciales"
                onclick="abrirModalCredenciales()">
            Credenciales
        </button>
    </div>

    <div class="dato">
        <p><strong>Descripción:</strong> {{ $proveedor->descripcion ?? 'Sin descripción' }}</p>
        <button class="btn-guardar" onclick="abrirModal('modalDescripcion')">
            Actualizar
        </button>
    </div>

    <div class="dato">
        <p><strong>Dirección:</strong> {{ $proveedor->ubicacion ?? 'Sin dirección' }}</p>
        <button class="btn-guardar" onclick="abrirModal('modalDireccion')">
            Actualizar
        </button>
    </div>

    <div class="dato">
        <p><strong>Celular / WhatsApp:</strong> {{ $proveedor->whatsapp ?? 'Sin celular' }}</p>
        <button class="btn-guardar" onclick="abrirModal('modalCelular')">
            Actualizar
        </button>
    </div>

</div>

    </section>

  {{-- ============================
       PRODUCTOS
============================= --}}
<section class="productos-lista">
    <h3>Mis Productos</h3>

    {{-- BOTÓN AÑADIR PRODUCTO --}}
    <button class="btn-agregar-producto" onclick="abrirModal('modalAgregarProducto')">
        + Añadir Producto
    </button>

    <div class="contenedor-productos">
        @forelse($productos as $p)
            <div class="card-producto">
                <img src="{{ $p->foto ?? asset('img/default-producto.jpg') }}" alt="Imagen"  class="imagen-producto">
                <h4>{{ $p->nombre ?? 'Producto sin nombre' }}</h4>
                <p class="precio">Precio: ${{ number_format($p->precio ?? 0, 0, ',', '.') }}</p>

                {{-- BOTÓN EDITAR --}}
                <button class="btn-editar" onclick="abrirModal('modalEditarProducto{{ $p->id }}')">
                    <i class="fas fa-edit"></i> Editar
                </button>

                {{-- BOTÓN ELIMINAR --}}
                <button class="btn-eliminar" onclick="abrirModal('modalEliminarProducto{{ $p->id }}')">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </div>

            {{-- MODAL EDITAR PRODUCTO --}}
            <div id="modalEditarProducto{{ $p->id }}" class="modal">
                <div class="modal-content">
                    <h3>Editar Producto</h3>
                    <form action="{{ route('proveedor.productos.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="text" name="nombre" value="{{ $p->nombre }}" placeholder="Nombre del producto">
                        <input type="number" name="precio" value="{{ $p->precio }}" placeholder="Precio">
                        <input type="text" name="descripcion" value="{{ $p->descripcion }}" placeholder="Descripción del producto">
                        <input type="file" name="foto">
                        <button class="btn-guardar">Guardar</button>
                    </form>
                    <span class="cerrar" onclick="cerrarModal('modalEditarProducto{{ $p->id }}')">&times;</span>
                </div>
            </div>

            {{-- MODAL ELIMINAR PRODUCTO --}}
            <div id="modalEliminarProducto{{ $p->id }}" class="modal">
                <div class="modal-content">
                    <h3>Eliminar Producto</h3>
                    <p>¿Deseas eliminar "{{ $p->nombre }}"?</p>
                    <form action="{{ route('proveedor.productos.destroy', $p->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn-eliminar">Eliminar</button>
                    </form>
                    <span class="cerrar" onclick="cerrarModal('modalEliminarProducto{{ $p->id }}')">&times;</span>
                </div>
            </div>

        @empty
            <p>No tienes productos registrados aún.</p>
        @endforelse
    </div>
</section>

{{-- MODAL AÑADIR PRODUCTO --}}
<div id="modalAgregarProducto" class="modal">
    <div class="modal-content">
        <h3>Agregar Producto</h3>
        <form action="{{ route('proveedor.productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="nombre" placeholder="Nombre del producto" required>
            <input type="number" name="precio" placeholder="Precio" required>
            <input type="text" name="descripcion" placeholder="Descripción del producto" required>
            <input type="file" name="foto" required>
            <button class="btn-guardar">Guardar</button>
        </form>
        <span class="cerrar" onclick="cerrarModal('modalAgregarProducto')">&times;</span>
    </div>
</div>

</main>



<footer class="footer-container">
    @include('components.footer')
</footer>

<script src="{{ asset('js/Generalidades.js') }}"></script>

{{-- =====================================================
                MODALES
===================================================== --}}

{{-- Modal Actualizar Banner --}}
<div id="modalBanner" class="modal">
    <div class="modal-content">
        <h3>Actualizar Banner</h3>
        <form action="{{ route('proveedor.banner') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="banner" required>
            <button class="btn-guardar">Guardar</button>
        </form>
        <span class="cerrar" onclick="cerrarModal('modalBanner')">&times;</span>
    </div>
</div>

{{-- Modal Actualizar Foto --}}
<div id="modalFoto" class="modal">
    <div class="modal-content">
        <h3>Actualizar Foto</h3>
        <form action="{{ route('proveedor.foto') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="foto" required>
            <button class="btn-guardar">Guardar</button>
        </form>
        <span class="cerrar" onclick="cerrarModal('modalFoto')">&times;</span>
    </div>
</div>

{{-- Modal Actualizar Descripción --}}
<div id="modalDescripcion" class="modal">
    <div class="modal-content">
        <h3>Editar Descripción</h3>
        <form action="{{ route('proveedor.descripcion') }}" method="POST">
            @csrf
            <textarea name="descripcion" class="input-admin" rows="5"></textarea>
            <button class="btn-guardar">Guardar</button>
        </form>
        <span class="cerrar" onclick="cerrarModal('modalDescripcion')">&times;</span>
    </div>
</div>

{{-- Modal Actualizar Dirección --}}
<div id="modalDireccion" class="modal">
    <div class="modal-content">
        <h3>Editar Dirección</h3>
        <form action="{{ route('proveedor.direccion') }}" method="POST">
            @csrf
            <input type="text" name="direccion" class="input-admin">
            <button class="btn-guardar">Guardar</button>
        </form>
        <span class="cerrar" onclick="cerrarModal('modalDireccion')">&times;</span>
    </div>
</div>

{{-- Modal Actualizar Celular --}}
<div id="modalCelular" class="modal">
    <div class="modal-content">
        <h3>Editar Número de Celular</h3>
        <form action="{{ route('proveedor.celular') }}" method="POST">
            @csrf
            <input type="text" name="celular" class="input-admin">
            <button class="btn-guardar">Guardar</button>
        </form>
        <span class="cerrar" onclick="cerrarModal('modalCelular')">&times;</span>
    </div>
</div>

{{-- MODAL CREDENCIALES PROVEEDOR --}}
<div id="modalCredenciales" class="modal">
    <div class="modal-content modal-credenciales">
        <h3>Actualizar Credenciales</h3>
        <p class="subtitulo-modal">
            Modifica tu información de acceso
        </p>

        <form id="formCredenciales"
              action="{{ route('proveedor.credenciales') }}"
              method="POST">
            @csrf

            <div class="form-group-credenciales">
                <label>Correo Electrónico</label>
                <input type="email" id="email" name="email"
                       value="{{ auth()->user()->email }}"
                       class="input-credenciales" required>
            </div>

            <div class="form-group-credenciales">
    <label>Confirmar Correo Electrónico</label>
    <input type="email"
           id="email_confirmation"
           name="email_confirmation"
           class="input-credenciales"
           required>
</div>

            <div class="form-group-credenciales">
                <label>Nueva Contraseña</label>
                <input type="password" id="password" name="password"
                       class="input-credenciales"
                       placeholder="Dejar vacío si no deseas cambiarla">
                <small>Mínimo 8 caracteres</small>
            </div>

            <div class="form-group-credenciales">
    <label>Confirmar Nueva Contraseña</label>
    <input type="password"
           id="password_confirmation"
           name="password_confirmation"
           class="input-credenciales">
</div>

            <button class="btn-guardar">Guardar cambios</button>
        </form>

        <span class="cerrar" onclick="cerrarModalCredenciales()">&times;</span>
    </div>
</div>

{{-- SCRIPT PARA ABRIR/CERRAR MODALES --}}
<script>
function abrirModal(id) {
    document.getElementById(id).style.display = 'flex';
}

function cerrarModal(id) {
    document.getElementById(id).style.display = 'none';
}
</script>

<script>
function abrirModalCredenciales() {
    document.getElementById('modalCredenciales').style.display = 'flex';

    const email = document.getElementById('email').value;
    document.getElementById('email_confirmation').value = email;
}

function cerrarModalCredenciales() {
    document.getElementById('modalCredenciales').style.display = 'none';

    document.getElementById('password').value = '';
    document.getElementById('password_confirmation').value = '';
}

document.getElementById('formCredenciales')
?.addEventListener('submit', function(e) {

    const email = document.getElementById('email').value;
    const emailConfirmation = document.getElementById('email_confirmation').value;
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;

    if (email !== emailConfirmation) {
        e.preventDefault();
        alert('Los correos no coinciden');
        return;
    }

    if (password && password !== passwordConfirmation) {
        e.preventDefault();
        alert('Las contraseñas no coinciden');
        return;
    }

    if (password && password.length < 8) {
        e.preventDefault();
        alert('La contraseña debe tener al menos 8 caracteres');
    }
});
</script>

</body>
</html>
