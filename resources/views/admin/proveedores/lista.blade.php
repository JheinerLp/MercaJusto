<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proveedores</title>
    @include('components.favicon')
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
    background-color: #f44336; /* rojo para errores */
}
.toast.show {
    opacity: 1;
    transform: translateY(0);
}

/* ===== MODAL DE CONFIRMACIÓN PERSONALIZADO ===== */
.modal-confirm {
    position: fixed;
    z-index: 10000;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.5);
    display: none;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(4px);
}

.modal-confirm.show {
    display: flex;
}

.modal-confirm-content {
    background: #fff;
    border-radius: 12px;
    padding: 28px 24px;
    width: 90%;
    max-width: 420px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    text-align: center;
    transform: scale(0.9);
    transition: transform 0.3s ease;
}

.modal-confirm.show .modal-confirm-content {
    transform: scale(1);
}

.modal-confirm .modal-icon {
    font-size: 2.8rem;
    margin-bottom: 12px;
}

.modal-confirm h3 {
    margin: 0 0 10px;
    color: #d40f0f;
    font-size: 1.35rem;
    font-weight: 700;
}

.modal-confirm p {
    color: #555;
    font-size: 0.93rem;
    line-height: 1.55;
    margin-bottom: 24px;
}

.modal-confirm-buttons {
    display: flex;
    gap: 12px;
    justify-content: center;
}

.btn-confirm-btn {
    padding: 10px 22px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.btn-confirm-btn.btn-danger  { background: #d40f0f; color: #fff; }
.btn-confirm-btn.btn-danger:hover  { background: #a80c0c; }
.btn-confirm-btn.btn-secondary { background: #e0e0e0; color: #333; }
.btn-confirm-btn.btn-secondary:hover { background: #c8c8c8; }
</style>

@include('components.header')
@include('components.lupa')

<main class="admin-panel">
    <h2>Lista de Proveedores</h2>
<button class="tab-button" onclick="window.location='{{ route('admin.dashboard') }}'">
    Dashboard
</button>
<x-search-filters
    action="{{ route('admin.proveedores') }}"
    placeholder="Buscar empresa o correo"
/>
    <table class="tabla-solicitudes">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Categoría</th>
                <th>Representante</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($proveedores as $p)
            <tr>
    <td>{{ $p->empresa }}</td>
    <td>{{ $p->categoria->nombre ?? 'Sin categoría' }}</td>
    <td>{{ $p->nombre_dueño }}</td> <!-- Nombre del dueño desde User -->
    <td>{{ $p->correo_dueño }}</td> <!-- Correo desde User -->
    <td>{{ $p->whatsapp }}</td> <!-- WhatsApp desde Proveedor -->
    <td>{{ $p->suspendido ? 'Suspendido' : 'Activo' }}</td>
    <td style="display:flex; gap:10px; align-items:center;">
        @if(!$p->suspendido)
            <form action="{{ route('admin.proveedor.suspender', $p->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-rechazar">
                    Suspender
                </button>
            </form>
        @else
           {{-- REACTIVAR --}}
        <form action="{{ route('admin.proveedor.reactivar', $p->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-aceptar">
                Reactivar
            </button>
        </form>

        {{-- ELIMINAR --}}
        <button type="button" class="btn-eliminar"
            onclick="abrirModalEliminar('{{ route('admin.proveedor.eliminar', $p->id) }}', '{{ addslashes($p->empresa) }}')"
        >
            Eliminar
        </button>
        @endif
    </td>
</tr>

            @endforeach
        </tbody>
    </table>
</main>
{{ $proveedores->appends(request()->query())->links('vendor.pagination.catalogo') }}
<style>
/* ===== PAGINACIÓN PERSONALIZADA ===== */
.paginacion-custom {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.paginacion-custom ul {
    display: flex;
    list-style: none;
    gap: 8px;
    padding: 0;
}

.paginacion-custom li a,
.paginacion-custom li span {
    min-width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
    border: 1px solid #ddd;
    color: #007bff;
    transition: all 0.2s ease;
}

.paginacion-custom li a:hover {
    background: #007bff;
    color: #fff;
}

.paginacion-custom li span.activo {
    background: #007bff;
    color: #fff;
    border-color: #007bff;



   
}


    </style>

<footer class="footer-container">
    @include('components.footer')
</footer>

<script src="{{ asset('js/Generalidades.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toast = document.getElementById('toast');
    if (toast) {
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }
});

function abrirModalEliminar(action, empresa) {
    document.getElementById('modalEmpresaNombre').textContent = empresa;
    document.getElementById('formEliminarProveedor').action = action;
    const modal = document.getElementById('modalEliminarProveedor');
    modal.style.display = 'flex';
    setTimeout(() => modal.classList.add('show'), 10);
}

function cerrarModalEliminar() {
    const modal = document.getElementById('modalEliminarProveedor');
    modal.classList.remove('show');
    setTimeout(() => modal.style.display = 'none', 300);
}
</script>

<!-- Modal de Confirmación: Eliminar Proveedor -->
<div id="modalEliminarProveedor" class="modal-confirm" style="display:none;">
    <div class="modal-confirm-content">
        <div class="modal-icon">⚠️</div>
        <h3>¿Eliminar proveedor?</h3>
        <p>
            Estás a punto de eliminar permanentemente a
            <strong id="modalEmpresaNombre"></strong>.
            Esta acción también eliminará todos sus productos y no se puede deshacer.
        </p>
        <div class="modal-confirm-buttons">
            <form id="formEliminarProveedor" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm-btn btn-danger">Sí, eliminar</button>
            </form>
            <button type="button" class="btn-confirm-btn btn-secondary" onclick="cerrarModalEliminar()">Cancelar</button>
        </div>
    </div>
</div>

</body>
</html>
