<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proveedores</title>
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
        <form action="{{ route('admin.proveedor.eliminar', $p->id) }}" method="POST"
              onsubmit="return confirm('⚠ ¿Seguro que deseas eliminar este proveedor? Esta acción no se puede deshacer.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-eliminar">
                Eliminar
            </button>
        </form>
        @endif
    </td>
</tr>

            @endforeach
        </tbody>
    </table>
</main>


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
        }, 3000); // desaparece después de 3 segundos
    }
});
</script>

</body>
</html>
