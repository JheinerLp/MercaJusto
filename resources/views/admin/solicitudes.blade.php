<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes de Proveedor</title>
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

/* Clase que activa la animación */
.toast.show {
    opacity: 1;
    transform: translateY(0);
}
</style>


@include('components.header')

@include('components.lupa')

<main class="admin-panel">
    <h2>Solicitudes de Proveedor</h2>
<button class="tab-button" onclick="window.location='{{ route('admin.dashboard') }}'">
    Dashboard
</button>
<x-search-filters
    action="{{ route('admin.solicitudes') }}"
    placeholder="Buscar empresa o correo"
/>

    <table class="tabla-solicitudes">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Categoría</th>
                <th>Representante</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
           @foreach ($solicitudes as $s)
    <tr>
        <td>{{ $s->nombre_empresa }}</td>

        <td>{{ $s->categoria->nombre ?? 'Sin categoría' }}</td>

        <td>{{ $s->nombre }}</td> {{-- REPRESENTANTE --}}

        <td>{{ $s->correo }}</td>

        <td>{{ ucfirst($s->estado) }}</td>

        <td style="display:flex; gap:10px; align-items:center;">
            {{-- ACEPTAR --}}
            <form action="{{ route('admin.solicitudes.aceptar', $s->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-aceptar">
                    Aceptar
                </button>
            </form>

            {{-- RECHAZAR --}}
            <form action="{{ route('admin.solicitudes.rechazar', $s->id) }}" method="POST" style="display:flex; gap:5px;">
                @csrf
                <input 
                    type="text" 
                    name="motivo" 
                    placeholder="Motivo" 
                    required
                    class="input-rechazo"
                >
                <button type="submit" class="btn-rechazar">
                    Rechazar
                </button>
            </form>
        </td>
    </tr>
@endforeach


        </tbody>
    </table>

    <a href="{{ route('admin.solicitudes.historial') }}" class="btn btn-secondary mb-3">
    Historial de Solicitudes
</a>


</main>

{{ $solicitudes->appends(request()->query())->links('vendor.pagination.catalogo') }}
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
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000); // desaparece después de 3 segundos
    }
});
</script>


</body>
</html>
