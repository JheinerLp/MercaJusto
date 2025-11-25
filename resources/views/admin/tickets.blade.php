<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tickets de Soporte</title>
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
    <h2>Tickets de Soporte</h2>
    <button class="tab-button" onclick="window.location='{{ route('admin.dashboard') }}'">
    Dashboard
</button>

    <table class="tabla-solicitudes">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Solicitante</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->titulo }}</td>
                <td>{{ $ticket->descripcion }}</td>
                <td>
                    {{ $ticket->proveedor->empresa ?? $ticket->user->name ?? $ticket->nombre_contacto ?? 'Desconocido' }}
                </td>
                <td>
                    {{ $ticket->proveedor->user->email ?? $ticket->user->email ?? $ticket->correo_contacto ?? '-' }}
                </td>
                <td>{{ ucfirst($ticket->estado) }}</td>
                <td style="display:flex; gap:10px; align-items:center;">
                    <!-- Botón para enviar respuesta -->
                    <button class="btn-rechazar" onclick="abrirModal({{ $ticket->id }}, '{{ $ticket->proveedor->user->email ?? $ticket->user->email ?? $ticket->correo_contacto ?? '' }}')">
                        Responder
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>

<!-- Modal para responder -->
<div id="modalResponder" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <h3>Responder Ticket</h3>
        <form id="formResponder" method="POST">
            @csrf
            <input type="hidden" name="ticket_id" id="ticket_id">
            <label for="mensaje">Mensaje:</label>
            <textarea name="mensaje" id="mensaje" rows="4" required style="width:100%; padding:5px;"></textarea>
            <button type="submit" class="btn-rechazar" style="margin-top:10px;">Enviar</button>
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
let modal = document.getElementById('modalResponder');
let form = document.getElementById('formResponder');

function abrirModal(ticketId, correo) {
    modal.style.display = 'block';
    form.action = '/admin/tickets/responder/' + ticketId; // Ruta para enviar correo
    document.getElementById('ticket_id').value = ticketId;
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
