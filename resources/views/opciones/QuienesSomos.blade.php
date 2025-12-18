<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Quiénes somos? - MercaJusto | Universidad del Valle</title>


    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/Quienes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header class="header">
        @include('components.header')
    </header>

    @include('components.lupa')

    <main>
        <div class="contenedor">
            <div class="imagen_que_somos">
                <img src="{{ asset('Images/Quesomos.jpeg') }}" alt="Comerciantes agroindustriales y productos locales">
            </div>

            <div class="descripcion">
                <h1>¿Quiénes somos?</h1>
                <p>
                    MercaJusto es un programa de la Universidad del Valle que apoya a pequeños productores y comerciantes en la promoción de productos agroindustriales, naturales y artesanales. Fomentamos el comercio justo y la economía local a través de ferias, plataformas digitales y colaboraciones comunitarias.
                </p>
            </div>
        </div>

        <!-- NUEVAS SECCIONES -->
        <section class="info-section" id="que-es">
            <div class="info-content">
                <img src="{{ asset('Images/Oyucos.jpeg') }}" alt="Equipo">
                <div class="info-text">
                    <h2>¿Qué es MercaJusto?</h2>
                    <p>MercaJusto es una iniciativa que busca visibilizar productos naturales y artesanales, fortaleciendo la conexión entre productores y consumidores responsables.</p>
                </div>
            </div>
        </section>

        <section class="info-section" id="programa">
            <div class="info-content reverse">
                <img src="{{ asset('Images/EquipoMercajustoprueba.jpeg') }}" alt="Equipo">
                <div class="info-text">
                    <h2>¿De qué trata el programa?</h2>
                    <p>El programa impulsa económicamente a emprendedores locales a través de eventos presenciales, exposiciones y canales digitales para comercializar sus productos.</p>
                </div>
                <img src="{{ asset('Images/DeQuetrataelprograma.jpeg') }}" alt="Feria universitaria de productos">
            </div>
        </section>

        <section class="info-section" id="objetivos">
            <div class="info-content">
                <img src="{{ asset('Images/Objetivosdelproyecto.jpeg') }}" alt="Misión y objetivos">
                <div class="info-text">
                    <h2>Objetivos del proyecto</h2>
                    <p>Promover el consumo responsable, ofrecer espacios de visibilidad para emprendedores y formar redes de colaboración entre la comunidad universitaria y el entorno local.</p>
                </div>
            </div>
        </section>

        <section class="info-section" id="equipo">
            <div class="info-content reverse">
                <div class="info-text">
                    <h2>Nuestro equipo</h2>
                    <p>Somos estudiantes, docentes y voluntarios comprometidos con el desarrollo social, que trabajamos desde la tecnología, la comunicación y la gestión para impulsar el emprendimiento justo.</p>
                </div>
                <img src="{{ asset('Images/EquipoMercajustoprueba.jpeg') }}" alt="Equipo de trabajo de MercaJusto">
            </div>
        
    <div class="boton-centro">
    <a href="javascript:void(0)" class="boton-rojo"
       onclick="abrirModal('modalSolicitudProveedor')">
        Quiero promocionar mis productos
    </a>
</div>
<div id="modalSolicitudProveedor" class="modal">
    <div class="modal-content">
        <h3>Solicitud para promocionar productos</h3>

        <form action="{{ route('solicitud.proveedor.store') }}" method="POST">
            @csrf

            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="text" name="nombre_empresa" placeholder="Nombre de la empresa" required>

            {{-- CATEGORÍA --}}
            <select name="categoria_id" required>
                <option value="">Seleccione una categoría</option>
                <option value="1">Frutas y Verduras</option>
                <option value="2">Lácteos y Carnes</option>
                <option value="3">Transformados</option>
                <option value="4">Cosméticos</option>
                <option value="5">Artesanías</option>
                <option value="6">Certificados</option>
                <option value="7">Otros</option>
            </select>

            {{-- SEDE --}}
            <select name="sede_id" required>
                <option value="">Seleccione su sede</option>
                <option value="1">Cali Melendez</option>
                <option value="2">Buenaventura</option>
                <option value="3">Palmira</option>
                <option value="4">Yumbo</option>
                <option value="5">Buga</option>
                <option value="6">Tuluá</option>
                <option value="7">Zarzal</option>
                <option value="8">Cartago</option>
                <option value="9">Caicedonia</option>
            </select>

            <input type="text" name="direccion" placeholder="Ubicación del local (opcional)">
            <textarea name="descripcion" placeholder="Descripción (opcional)"></textarea>
            <input type="text" name="telefono" placeholder="Celular / WhatsApp" required>

            <button class="btn-guardar">Enviar solicitud</button>
        </form>

        <span class="cerrar" onclick="cerrarModal('modalSolicitudProveedor')">&times;</span>
    </div>
</div>
<style>
/* FONDO DEL MODAL */
.modal {
    display: none; /* MUY IMPORTANTE */
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
}

/* CONTENIDO */
.modal-content {
    background: #fff;
    padding: 25px;
    width: 90%;
    max-width: 800px;
    border-radius: 12px;
    position: relative;
    animation: fadeIn 0.3s ease;
}

/* BOTÓN CERRAR */
.cerrar {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 28px;
    cursor: pointer;
    font-weight: bold;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style> 

</div>

        </section>
    </main>
    @include('components.botsoporte')
    <footer class="footer-container">
        @include('components.footer')
    </footer>

    <script src="{{ asset('Js/Generalidades.js') }}"></script>
    <script>
function abrirModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'flex';
    }
}

function cerrarModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'none';
    }
}
</script>

</body>
</html>
