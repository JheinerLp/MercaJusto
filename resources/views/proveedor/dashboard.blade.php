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
    <section class="proveedor-banner">
        <img src="{{ asset('img/proveedores/banners/' . ($proveedor->banner ?? 'default-banner.jpg')) }}" alt="Banner proveedor">
        <button class="btn-cambiar-banner" onclick="abrirModal('modalBanner')">Cambiar Banner</button>
    </section>

    {{-- ============================
         FOTO + INFO DEL PROVEEDOR
    ============================= --}}
    <section class="proveedor-info">

        {{-- FOTO --}}
        <div class="foto-container">
           <img src="{{ asset('img/proveedores/fotos/' . ($proveedor->foto ?? 'default-foto.jpg')) }}" alt="Foto proveedor">
            <button class="btn-cambiar-foto" onclick="abrirModal('modalFoto')">Cambiar Foto</button>
        </div>

        {{-- NOMBRE --}}
        <h2 class="nombre-proveedor">{{ $proveedor->empresa ?? 'Proveedor sin nombre' }}</h2>

        {{-- CATEGORÍA --}}
        <p class="categoria">
            <strong>Categoría:</strong> {{ $proveedor->categoria->nombre ?? 'Sin categoría' }}
        </p>

        {{-- DESCRIPCIÓN --}}
        <p><strong>Descripción:</strong> {{ $proveedor->descripcion ?? 'Sin descripción' }}</p>
        <button class="btn-guardar" onclick="abrirModal('modalDescripcion')">Actualizar Descripción</button>

        {{-- DIRECCIÓN --}}
        <p><strong>Dirección:</strong> {{ $proveedor->ubicacion ?? 'Sin dirección' }}</p>
        <button class="btn-guardar" onclick="abrirModal('modalDireccion')">Actualizar Dirección</button>

        {{-- CELULAR --}}
        <p><strong>Celular / WhatsApp:</strong> {{ $proveedor->whatsapp ?? 'Sin celular' }}</p>
        <button class="btn-guardar" onclick="abrirModal('modalCelular')">Actualizar Celular</button>

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
                <img src="{{ $p->foto ? asset('storage/' . $p->foto) : asset('img/default-producto.jpg') }}" alt="Imagen" class="imagen-producto">
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
            <input type="file" name="foto">
            <button class="btn-guardar">Guardar</button>
        </form>
        <span class="cerrar" onclick="cerrarModal('modalAgregarProducto')">&times;</span>
    </div>
</div>

</main>

@include('components.botsoporte')

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

{{-- SCRIPT PARA ABRIR/CERRAR MODALES --}}
<script>
function abrirModal(id) {
    document.getElementById(id).style.display = 'flex';
}

function cerrarModal(id) {
    document.getElementById(id).style.display = 'none';
}
</script>

</body>
</html>
