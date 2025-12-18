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

    <main class="contenedor">
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
                <a href="https://wa.me/573001112233" target="_blank" class="btn-whatsapp">
                    💬 Hablar por WhatsApp
                </a>

                <button class="btn-bot">🤖 Hablar con el Bot</button>
            </div>
        </div>
    </section>
</main>
<section class="faq-section">
    <h2>Preguntas Frecuentes</h2>
   <div class="faq-item">
    <h3 onclick="toggleFaq(this)">1. ¿Cómo puedo contactar a un proveedor?</h3>
    <p class="faq-answer">Puedes hacerlo mediante la sección del proveedor o usando el bot para asistencia directa.</p>
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
.faq-section {
  width: 90%;
  max-width: 900px;
  margin: 60px auto;
}
.faq-section h2 {
  font-size: 2em;
  color: #d40f0f;
  margin-bottom: 20px;
}
.faq-item {
  border-bottom: 1px solid #ddd;
  padding: 10px 0;
}
.faq-item h3 {
  font-size: 18px;
  cursor: pointer;
  margin: 0;
}
.faq-answer {
  display: none;
  padding-top: 5px;
  font-size: 16px;
}

</style>
</section>
    @include('components.botsoporte')
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

</body>
</html>
