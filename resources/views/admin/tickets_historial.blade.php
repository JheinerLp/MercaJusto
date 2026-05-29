<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Tickets</title>
    @include('components.favicon')

    <link rel="stylesheet" href="{{ asset('css/pages/Gestion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/Menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/pages/solicitudes.css') }}">

    <style>
        /* ===== TOAST ===== */
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

        /* ===== BOTONES ===== */
        .btn-rechazar {
            padding: 10px 18px;
            background-color: #d40f0f;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-rechazar:hover {
            background-color: #b30c0c;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        /* ===== MODAL DE CONFIRMACIÓN PERSONALIZADO ===== */
        .modal-confirm {
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(4px);
            transition: all 0.3s ease;
        }

        .modal-confirm-content {
            background-color: #fff;
            border-radius: 12px;
            padding: 25px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            text-align: center;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal-confirm.show {
            display: flex;
        }

        .modal-confirm.show .modal-confirm-content {
            transform: scale(1);
        }

        .modal-confirm h3 {
            margin-top: 0;
            color: #d40f0f;
            font-size: 1.35rem;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .modal-confirm p {
            color: #555;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .modal-confirm-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn-confirm-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .btn-confirm-btn.btn-danger {
            background-color: #d40f0f;
            color: white;
        }

        .btn-confirm-btn.btn-danger:hover {
            background-color: #b30c0c;
        }

        .btn-confirm-btn.btn-secondary {
            background-color: #e0e0e0;
            color: #333;
        }

        .btn-confirm-btn.btn-secondary:hover {
            background-color: #cccccc;
        }
    </style>
</head>
<body>

@include('components.header')
@include('components.lupa')




<main class="admin-panel">
    <h2>Historial de Tickets Finalizados</h2>

    <div style="display:flex; gap:10px; margin-bottom:20px;">
        <button class="tab-button" onclick="window.location='{{ route('admin.tickets') }}'">
            Volver
        </button>

        <form id="formEliminarHistorial" action="{{ route('admin.tickets.historial.eliminar') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn-rechazar" onclick="mostrarConfirmacion()">
                Eliminar historial
            </button>
        </form>
    </div>
   <x-search-filters
    action="{{ route('admin.tickets.historial') }}"
    placeholder="Buscar nombre o correo"
 />

    <table class="tabla-solicitudes">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Solicitante</th>
            <th>Correo</th>
            <th>Fecha cierre</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->titulo }}</td>

                <td>
                    {{ $ticket->proveedor->empresa
                        ?? $ticket->user->name
                        ?? $ticket->nombre_contacto
                        ?? '—' }}
                </td>

                <td>
                    {{ $ticket->proveedor->user->email
                        ?? $ticket->user->email
                        ?? $ticket->correo_contacto
                        ?? '—' }}
                </td>

                <td>{{ $ticket->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center;">
                    No hay tickets finalizados
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</main>

{{ $tickets->appends(request()->query())->links('vendor.pagination.catalogo') }}
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

<!-- Modal de Confirmación Personalizado -->
<div id="modalConfirmar" class="modal-confirm">
    <div class="modal-confirm-content">
        <h3>¿Estás seguro?</h3>
        <p>Esta acción es irreversible y eliminará de forma permanente todo el historial de tickets finalizados.</p>
        <div class="modal-confirm-buttons">
            <button id="btnConfirmarAceptar" class="btn-confirm-btn btn-danger">Eliminar</button>
            <button id="btnConfirmarCancelar" class="btn-confirm-btn btn-secondary">Cancelar</button>
        </div>
    </div>
</div>

<script>
function mostrarConfirmacion() {
    const modal = document.getElementById('modalConfirmar');
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function cerrarConfirmacion() {
    const modal = document.getElementById('modalConfirmar');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

document.getElementById('btnConfirmarCancelar').addEventListener('click', cerrarConfirmacion);
document.getElementById('btnConfirmarAceptar').addEventListener('click', function() {
    document.getElementById('formEliminarHistorial').submit();
});
</script>
</body>