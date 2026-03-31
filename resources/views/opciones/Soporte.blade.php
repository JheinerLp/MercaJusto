<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/Soporte.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header class="header">
        @include('components.header') 
    </header>
    @include('components.lupa')
 <section class="soporte-section">
        <div class="soporte-img">
            <img src="{{ asset('Images/Soporte.png') }}" alt="Soporte técnico MercaJusto" class="pulse">
        </div>
        
        <div class="soporte-texto">
            <h1>¿Necesitas ayuda?</h1>
            <p>Si presentas inconvenientes, puedes contactarnos:</p>
            <ul>
                <li>📧 jheiner.larrahondo@correounivalle.edu.co</li>
                <li>📧 santiago.gualguan@correounivalle.edu.co</li>
            </ul>

            <div class="botones-contacto">
                <a href="https://wa.me/573248810172" target="_blank" class="btn-whatsapp">
                    💬 Hablar por WhatsApp
                </a>

                

                <button class="btn-soporte" onclick="abrirModalSoporte()">
                  📨 Solicitar soporte
                  </button>
            </div>
        </div>
    <main class="contenedor">
        
</main>
<section class="faq-section">
    <h2>Preguntas Frecuentes</h2>
   <div class="faq-item">
    <h3 onclick="toggleFaq(this)">1. ¿Cómo puedo contactar a un proveedor?</h3>
    <p class="faq-answer">Puedes hacerlo mediante la sección de soporte por medio de un correo electrónico.</p>
 </div>
  <div class="faq-item">
    <h3 onclick="toggleFaq(this)">2. ¿Cómo puedo verificar un pago?</h3>
    <p class="faq-answer">Revisa tu correo o comunícate con soporte si no has recibido confirmación en 24h.</p>
  </div>
  <div class="faq-item">
    <h3 onclick="toggleFaq(this)">3. ¿Puedo devolver un producto?</h3>
    <p class="faq-answer">Los productos artesanales no tienen devolución, pero puedes reportar inconsistencias a soporte.</p>
  </div>

 <style>
  /* CONTENEDOR BOTONES */
.botones-contacto {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 20px;
    align-items: center;
}

/* ESTILO UNIFICADO PARA TODOS LOS BOTONES */
.botones-contacto .btn-whatsapp,
.botones-contacto .btn-bot,
.botones-contacto .btn-soporte {
    padding: 12px 18px;
    border-radius: 30px; /* igual que btn-soporte */
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    border: none;
}

/* COLORES ESPECÍFICOS */
.btn-whatsapp {
    background-color: #25D366;
}

.btn-whatsapp:hover {
    background-color: #1ebe5b;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.btn-bot {
    background-color: #007bff;
}

.btn-bot:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.btn-soporte {
    background: #d63909ff;
}

.btn-soporte:hover {
    background: #ff0800ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .contenedor {
        flex-direction: column;
        text-align: center;
    }

    .descripcion {
        max-width: 90%;
    }

    .Soporte img {
        max-width: 80%;
    }

    .botones-contacto {
        justify-content: center;
    }
}

.modal-soporte {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0, 0, 0, 0.65);
    backdrop-filter: blur(4px);
    animation: fadeIn 0.3s ease;

    overflow-y: auto; /* permite scroll vertical */
    -webkit-overflow-scrolling: touch; /* suaviza en móviles */
}


.modal-contenido {
    background: #ffffff;
    max-width: 480px;
    width: 90%;
    margin: 40px auto; /* un pequeño margen para no pegarse al top */
    padding: 28px;
    border-radius: 16px;
    position: relative;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    animation: slideDown 0.4s ease;

    display: flex;
    flex-direction: column;
    max-height: 90vh; /* limitar altura para que entre en pantalla */
    overflow-y: auto;  /* scroll solo dentro del modal si es necesario */
}


.modal-contenido .cerrar {
    position: absolute;
    top: 15px;
    right: 18px;
    font-size: 26px;
    color: #999;
    cursor: pointer;
    transition: color 0.2s ease;
}

.modal-contenido .cerrar:hover {
    color: #d40f0f;
}

.modal-contenido h2 {
    margin-bottom: 20px;
    color: #d40f0f;
    text-align: center;
}

.modal-contenido label {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
}

.modal-contenido input,
.modal-contenido textarea {
    width: 80%;
    padding: 10px 12px;
    margin-bottom: 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.modal-contenido input:focus,
.modal-contenido textarea:focus {
    outline: none;
    border-color: #1e88e5;
}


.btn-enviar {
    width: 100%;
    padding: 12px;
    background: #d40f0f;
    color: #fff;
    font-size: 15px;
    font-weight: bold;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-enviar:hover {
    background: #b30c0c;
    transform: translateY(-1px);
}


@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideDown {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@media (max-width: 480px) {
    .modal-contenido {
        margin: 20% auto;
        padding: 22px;
    }
}


</style>
  <style>
.faq-section {
  width: 90%;
  max-width: 900px;
  margin: 60px auto;
}
.faq-section h2 {
  font-size: 2em;
  color: #d40f0f;
  margin-bottom: 25px;
}
.faq-item {
  background: #fff;
    border-radius: 10px;
    margin-bottom: 12px;
    padding: 18px 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid #eee;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}
.faq-item:hover {
    transform: translateY(-3px);
    background: #fafafa;
}


.faq-item h3 {
  display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 17px;
    margin: 0;
}
.faq-item h3::after {
    content: "+";
    font-size: 20px;
    transition: transform 0.3s;
}

.faq-item.active h3::after {
    content: "-";
}
.faq-answer {
  display: none;
  padding-top: 5px;
  font-size: 16px;
}

</style>
</section>
    
    <footer class="footer-container">
        @include('components.footer')  
    </footer>

    <script src="{{ asset('js/Generalidades.js') }}"></script>
   <script>
    function toggleFaq(elem) {
  const answer = elem.nextElementSibling;
  answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
}
</script>
<div id="modalSoporte" class="modal-soporte">
    <div class="modal-contenido">
        <span class="cerrar" onclick="cerrarModalSoporte()">&times;</span>

        <h2>Solicitar Soporte</h2>

        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf

             <label>Nombre</label>
            <input type="text" name="nombre_contacto" placeholder="Tu nombre" required>

            <label>Título</label>
            <input type="text" name="titulo" required>

            <label>Descripción</label>
            <textarea name="descripcion" rows="4" required></textarea>

            <label>Correo de contacto</label>
            <input type="email" name="correo_contacto" required>

            <button type="submit" class="btn-enviar">
                Enviar solicitud
            </button>
        </form>
    </div>
</div>


<script>
function abrirModalSoporte() {
    document.getElementById('modalSoporte').style.display = 'block';
}

function cerrarModalSoporte() {
    document.getElementById('modalSoporte').style.display = 'none';
}
</script>
<div id="toast" class="toast">Ticket enviado, nos contactaremos contigo lo más pronto posible. ¡Gracias!</div>
<style>
  .toast {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background-color: #28a745; /* verde éxito */
    color: #fff;
    padding: 14px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    opacity: 0;
    pointer-events: none;
    transform: translateY(20px);
    transition: all 0.4s ease;
    z-index: 10000;
}

.toast.show {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
}

  </style>

  <script>
const formSoporte = document.querySelector('#modalSoporte form');
const toast = document.getElementById('toast');

formSoporte.addEventListener('submit', function(e) {
    // Aquí podemos mostrar el toast
    toast.classList.add('show');

    // Ocultar toast después de 4 segundos
    setTimeout(() => {
        toast.classList.remove('show');
    }, 4000);

    // El formulario sigue enviándose normalmente
});
</script>

</body>
</html>
