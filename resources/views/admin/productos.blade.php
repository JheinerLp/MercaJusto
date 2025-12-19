<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="{{ asset('css/pages/Gestion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/Menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/pages/solicitudes.css') }}">
</head>
<body>

@if(session('success'))
<div id="toast" class="toast">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div id="toast" class="toast error">
    {{ session('error') }}
</div>
@endif

<style>
.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #4caf50;
    color: white;
    padding: 15px 25px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    z-index: 1000;
    opacity: 0;
    transform: translateY(-20px);
    transition: opacity 0.5s ease, transform 0.5s ease;
}
.toast.error {
    background-color: #f44336;
}
.toast.show {
    opacity: 1;
    transform: translateY(0);
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 2000;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fff;
    margin: auto;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    text-align: left;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}
</style>

@include('components.header')
@include('components.lupa')

<main class="admin-panel">
    <h2>Lista de Productos</h2>
<button class="tab-button" onclick="window.location='{{ route('admin.dashboard') }}'">
    Dashboard
</button>
<x-search-filters
    action="{{ route('admin.productos') }}"
    placeholder="Buscar producto o empresa"
/>

    <table class="tabla-solicitudes">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Empresa</th>
                <th>Dueño</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($productos as $producto)
            <tr>
                <td class="producto-img">
                    <img src="{{ asset('storage/' . $producto->foto) }}" alt="{{ $producto->nombre }}" width="80">
                </td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                <td>{{ $producto->proveedor->empresa ?? 'Sin empresa' }}</td>
                <td>{{ $producto->proveedor->user->name ?? 'Sin dueño' }}</td>
                <td style="display:flex; gap:10px; align-items:center;">
                    <button class="btn-rechazar" onclick="abrirModal({{ $producto->id }})">Eliminar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>

<!-- Modal -->
<div id="modalEliminar" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <h3>Eliminar Producto</h3>
        <form id="formEliminar" method="POST">
            @csrf
            <label for="motivo">Motivo de eliminación:</label>
            <textarea name="motivo" id="motivo" rows="4" required style="width:100%; padding:5px;"></textarea>
            <button type="submit" class="btn-rechazar" style="margin-top:10px;">Confirmar</button>
        </form>
    </div>
</div>

@include('components.botsoporte')
<footer class="footer-container">
    @include('components.footer')
</footer>

<script src="{{ asset('js/Generalidades.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toast = document.getElementById('toast');
    if (toast) {
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }
});

// Modal
let modal = document.getElementById('modalEliminar');
let form = document.getElementById('formEliminar');

function abrirModal(productoId) {
    modal.style.display = 'block';
    form.action = '/admin/productos/eliminar/' + productoId; // Actualiza la acción del form
}

function cerrarModal() {
    modal.style.display = 'none';
}

// Cerrar modal al hacer click fuera
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>

</body>
</html>
