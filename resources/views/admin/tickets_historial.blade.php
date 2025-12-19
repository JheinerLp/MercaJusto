<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Tickets</title>

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

        <form action="{{ route('admin.tickets.historial.eliminar') }}" method="POST"
              onsubmit="return confirm('⚠ ¿Eliminar TODO el historial de tickets?')">
            @csrf
            @method('DELETE')
            <button class="btn-rechazar">
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
@include('components.botsoporte')

<footer class="footer-container">
    @include('components.footer')
</footer>

<script src="{{ asset('js/Generalidades.js') }}"></script>
    </body>