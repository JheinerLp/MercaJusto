<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Quiénes somos? - MercaJusto | Universidad del Valle</title>
    @include('components.favicon')

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/Quienes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

{{-- TOAST --}}
<div id="toast" class="toast"></div>

<style>
.toast {
    position: fixed;
    bottom: 25px;
    right: 25px;
    background: #2ecc71;
    color: #fff;
    padding: 14px 22px;
    border-radius: 8px;
    font-size: 14px;
    opacity: 0;
    pointer-events: none;
    transition: all 0.4s ease;
    z-index: 10000;
}
.toast.show { opacity: 1; transform: translateY(-10px); }
.toast.error { background: #e63946; }
</style>

<header class="header">
    @include('components.header')
</header>

@include('components.lupa')

<main>

    <div class="contenedor">
        <div class="imagen_que_somos">
            <img src="{{ asset('Images/Quesomos.jpeg') }}" alt="MercaJusto">
        </div>

        <div class="descripcion">
            <h1>¿Quiénes somos?</h1>
            <p>
                MercaJusto es un programa de la Universidad del Valle que apoya a pequeños productores y comerciantes
                en la promoción de productos agroindustriales, naturales y artesanales.
            </p>
        </div>
    </div>

    {{-- SECCIONES --}}
    <section class="info-section">
        <div class="info-content">
            <img src="{{ asset('Images/Oyucos.jpeg') }}" alt="Equipo">
            <div class="info-text">
                <h2>¿Qué es MercaJusto?</h2>
                <p>Una iniciativa que visibiliza productos locales y artesanales.</p>
            </div>
        </div>
    </section>

    <section class="info-section">
        <div class="info-content reverse">
            <img src="{{ asset('Images/EquipoMercajustoprueba.jpeg') }}">
            <div class="info-text">
                <h2>¿De qué trata el programa?</h2>
                <p>Impulsamos emprendedores locales a través de ferias y plataformas digitales.</p>
            </div>
        </div>
    </section>

    <section class="info-section">
        <div class="info-content">
            <img src="{{ asset('Images/Objetivosdelproyecto.jpeg') }}">
            <div class="info-text">
                <h2>Objetivos</h2>
                <p>Promover consumo responsable y comercio justo.</p>
            </div>
        </div>
    </section>

    {{-- BOTÓN SOLO SI NO ES PROVEEDOR NI TIENE SOLICITUD --}}
    @if (!$tieneSolicitud && !$esProveedor)
    <div class="boton-centro" id="botonPromocionar">
        <a href="javascript:void(0)" class="boton-rojo"
           onclick="abrirModal('modalSolicitudProveedor')">
            Quiero promocionar mis productos
        </a>
    </div>
    @endif

</main>

{{-- MODAL --}}
<div id="modalSolicitudProveedor" class="modal">
    <div class="modal-content">
        <span class="cerrar" onclick="cerrarModal('modalSolicitudProveedor')">&times;</span>

        <h3>Unetenos</h3>

        <form id="formSolicitudProveedor"
              action="{{ route('solicitud.proveedor.store') }}"
              method="POST">
            @csrf

            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="text" name="nombre_empresa" placeholder="Nombre de la empresa" required>

            <select name="categoria_id" required>
                <option value="">Seleccione categoría</option>
                <option value="1">Frutas y Verduras</option>
                <option value="2">Lácteos y Carnes</option>
                <option value="3">Transformados</option>
                <option value="4">Cosméticos</option>
                <option value="5">Artesanías</option>
                <option value="6">Certificados</option>
                <option value="7">Otros</option>
            </select>

            <select name="sede_id" required>
                <option value="">Seleccione sede</option>
                <option value="1">Cali Melendez</option>
                <option value="2">Buenaventura</option>
                <option value="3">Palmira</option>
                <option value="4">Yumbo</option>
                <option value="5">Buga</option>
                <option value="6">Tulua</option>
                <option value="7">Zarzal</option>
                <option value="8">Cartago</option>
                <option value="9">Caicedonia</option>
                <option value="10">Sede Norte </option>
            
            </select>

            <input type="text" name="direccion" placeholder="Dirección (opcional)">
            <textarea name="descripcion" placeholder="Descripción (opcional)"></textarea>
            <input type="text" name="telefono" placeholder="Celular / WhatsApp" required>

            <button class="btn-guardar">Enviar solicitud</button>
        </form>
    </div>
</div>

<style>
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.modal-content {
    background: #fff;
    padding: 25px;
    width: 90%;
    max-width: 600px;
    border-radius: 12px;
    position: relative;
}
.cerrar {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 28px;
    cursor: pointer;
}
</style>


@include('components.footer')

<script>
function abrirModal(id) {
    document.getElementById(id).style.display = 'flex';
}
function cerrarModal(id) {
    document.getElementById(id).style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formSolicitudProveedor');
    const toast = document.getElementById('toast');

    if (!form) return;

    function mostrarToast(msg, error = false) {
        toast.textContent = msg;
        toast.className = 'toast show' + (error ? ' error' : '');
        setTimeout(() => toast.className = 'toast', 3000);
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: new FormData(form)
        })
        .then(async r => {
            const data = await r.json();
            if (!r.ok) throw data;
            mostrarToast(data.message);
            cerrarModal('modalSolicitudProveedor');
            setTimeout(() => location.reload(), 1500);
        })
        .catch(err => mostrarToast(err.message || 'Error', true));
    });
});
</script>
<script src="{{ asset('Js/Generalidades.js') }}"></script>

</body>
</html>

