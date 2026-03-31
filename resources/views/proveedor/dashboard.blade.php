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

@include('components.lupa')

@php
    // 🔥 SE EJECUTA UNA SOLA VEZ (OPTIMIZACIÓN CLAVE)
    $prov = proveedorActual();
@endphp

<main class="proveedor-vista">

    {{-- ============================
        BANNER DEL PROVEEDOR
    ============================ --}}
    <section class="proveedor-banner" onclick="abrirModal('modalBanner')">

        <img src="{{ $prov?->banner ? asset($prov->banner) : asset('images/Banner.png') }}"
             onerror="this.src='{{ asset('images/Banner.png') }}'"
             alt="Banner proveedor">

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

            <img src="{{ $prov?->foto ? asset($prov->foto) : asset('images/Usuario.jpg') }}"
                 onerror="this.src='{{ asset('images/Usuario.jpg') }}'"
                 alt="Foto proveedor">

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

        <button class="btn-agregar-producto" onclick="abrirModal('modalAgregarProducto')">
            + Añadir Producto
        </button>

        <div class="contenedor-productos">
            @forelse($productos as $p)
                <div class="card-producto">
                    <img src="{{ $p->foto ?? asset('img/default-producto.jpg') }}"
                         alt="Imagen"
                         class="imagen-producto">

                    <h4>{{ $p->nombre ?? 'Producto sin nombre' }}</h4>

                    <p class="precio">
                        Precio: ${{ number_format($p->precio ?? 0, 0, ',', '.') }}
                    </p>

                    <button class="btn-editar" onclick="abrirModal('modalEditarProducto{{ $p->id }}')">
                        <i class="fas fa-edit"></i> Editar
                    </button>

                    <button class="btn-eliminar" onclick="abrirModal('modalEliminarProducto{{ $p->id }}')">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>

                {{-- MODAL EDITAR --}}
                <div id="modalEditarProducto{{ $p->id }}" class="modal">
                    <div class="modal-content">
                        <h3>Editar Producto</h3>

                        <form action="{{ route('proveedor.productos.update', $p->id) }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="text" name="nombre" value="{{ $p->nombre }}">
                            <input type="number" name="precio" value="{{ $p->precio }}">
                            <input type="text" name="descripcion" value="{{ $p->descripcion }}">
                            <input type="file" name="foto">

                            <small class="text-muted">
                                <strong>Aviso:</strong> JPG o PNG max 4MB
                            </small>

                            <button class="btn-guardar">Guardar</button>
                        </form>

                        <span class="cerrar" onclick="cerrarModal('modalEditarProducto{{ $p->id }}')">&times;</span>
                    </div>
                </div>

                {{-- MODAL ELIMINAR --}}
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

    {{-- MODAL AGREGAR --}}
    <div id="modalAgregarProducto" class="modal">
        <div class="modal-content">
            <h3>Agregar Producto</h3>

            <form action="{{ route('proveedor.productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="text" name="nombre" required>
                <input type="number" name="precio" required>
                <input type="text" name="descripcion" required>
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

{{-- ================= MODALES ================= --}}

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

<div id="modalDescripcion" class="modal">
    <div class="modal-content">
        <h3>Editar Descripción</h3>
        <form action="{{ route('proveedor.descripcion') }}" method="POST">
            @csrf
            <textarea name="descripcion" rows="5"></textarea>
            <button class="btn-guardar">Guardar</button>
        </form>
        <span class="cerrar" onclick="cerrarModal('modalDescripcion')">&times;</span>
    </div>
</div>

<div id="modalDireccion" class="modal">
    <div class="modal-content">
        <h3>Editar Dirección</h3>
        <form action="{{ route('proveedor.direccion') }}" method="POST">
            @csrf
            <input type="text" name="direccion">
            <button class="btn-guardar">Guardar</button>
        </form>
        <span class="cerrar" onclick="cerrarModal('modalDireccion')">&times;</span>
    </div>
</div>

<div id="modalCelular" class="modal">
    <div class="modal-content">
        <h3>Editar Celular</h3>
        <form action="{{ route('proveedor.celular') }}" method="POST">
            @csrf
            <input type="text" name="celular">
            <button class="btn-guardar">Guardar</button>
        </form>
        <span class="cerrar" onclick="cerrarModal('modalCelular')">&times;</span>
    </div>
</div>

{{-- CREDENCIALES --}}
<div id="modalCredenciales" class="modal">
    <div class="modal-content modal-credenciales">
        <h3>Actualizar Credenciales</h3>

        <form id="formCredenciales" action="{{ route('proveedor.credenciales') }}" method="POST">
            @csrf

            <input type="email" name="email" value="{{ auth()->user()?->email }}" required>
            <input type="email" name="email_confirmation" required>

            <input type="password" name="password">
            <input type="password" name="password_confirmation">

            <button type="button" onclick="enviarCodigo()" class="btn-guardar">
                📩 Enviar código
            </button>

            <input type="text" name="otp_code" required>

            <button class="btn-guardar">Guardar cambios</button>
        </form>

        <span class="cerrar" onclick="cerrarModalCredenciales()">&times;</span>
    </div>
</div>

{{-- TOASTS --}}
@if(session('success'))
<div id="toastSuccess" class="toast success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div id="toastError" class="toast error">{{ session('error') }}</div>
@endif

<script>
function abrirModal(id){ document.getElementById(id).style.display='flex'; }
function cerrarModal(id){ document.getElementById(id).style.display='none'; }

function abrirModalCredenciales(){
    document.getElementById('modalCredenciales').style.display='flex';
}

function cerrarModalCredenciales(){
    document.getElementById('modalCredenciales').style.display='none';
}

function enviarCodigo(){
    fetch("{{ route('proveedor.enviar.codigo') }}", {
        method:"POST",
        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":"{{ csrf_token() }}"
        }
    })
    .then(()=>{
        const t=document.createElement('div');
        t.className='toast success show';
        t.innerText='📩 Código enviado';
        document.body.appendChild(t);
        setTimeout(()=>t.remove(),3000);
    });
}

document.addEventListener('DOMContentLoaded',()=>{
    document.querySelectorAll('.toast').forEach(t=>{
        t.classList.add('show');
        setTimeout(()=>t.classList.remove('show'),3000);
    });
});
</script>

</body>
</html>