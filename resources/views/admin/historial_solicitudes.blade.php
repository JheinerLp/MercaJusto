<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Solicitudes</title>
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
    <h2>Historial de Solicitudes</h2>

    <!-- Botón para volver a solicitudes pendientes -->
  <div style="display:flex; gap:10px; margin-bottom:20px;"> 
    <a href="{{ route('admin.solicitudes') }}" class="tab-button"> Volver a Solicitudes Pendientes </a>
     <form action="{{ route('admin.solicitudes.historial.eliminar') }}" method="POST" onsubmit="return confirm('⚠ ¿Eliminar TODO el historial de solicitudes?')">
    @csrf @method('DELETE') <button class="btn-rechazar"> Eliminar historial </button>
</form>

 </div>
 <x-search-filters
    action="{{ route('admin.solicitudes.historial') }}"
    placeholder="Buscar empresa o correo"
    :filters="[
        'estado' => [
            'aprobado' => 'Aprobado',
            'rechazado' => 'Rechazado'
        ]
    ]"
/>
    <table class="tabla-solicitudes">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Representante</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th>Motivo de Rechazo</th>
                <th>Fecha de Actualización</th>
            </tr>
        </thead>
        <tbody>
            @forelse($solicitudes as $s)
            <tr style="background-color: 
                @if($s->estado == 'aprobado') #d4edda
                @elseif($s->estado == 'rechazado') #f8d7da
                @endif
            ">
                <td>{{ $s->nombre_empresa }}</td>
                <td>{{ $s->nombre }}</td>
                <td>{{ $s->correo }}</td>
                <td>{{ $s->telefono }}</td>
                <td>{{ $s->direccion }}</td>
                <td class="text-capitalize">{{ $s->estado }}</td>
                <td>{{ $s->motivo_rechazo ?? '—' }}</td>
                <td>{{ $s->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No hay solicitudes en el historial.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

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
