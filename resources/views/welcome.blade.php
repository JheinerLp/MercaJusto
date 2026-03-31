<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>

    <link rel="stylesheet" href="{{ asset('css/layout/Menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    
        @include('components.header')
    

    @include('components.lupa')

    <section class="contenedor-carrusel-menu" aria-label="Contenido principal del menú">
        <div class="carousel-container">


            <div class="carousel">
                <div class="carousel-images">
                    <img src="{{ asset('Images/Carrusel.jpg') }}" alt="Exposición de productos agroindustriales en Univalle">
                    <img src="{{ asset('Images/Carrusel2.jpeg') }}" alt="Stand de artesanías de la feria">
                    <img src="{{ asset('Images/Carrusel3.jpeg') }}" alt="Productos lácteos en exhibición">
                    <img src="{{ asset('Images/Carrusel4.jpeg') }}" alt="Visitantes en la muestra agroindustrial">
                </div>
            </div>
            <nav class="circle-menu" aria-label="Menú rápido de navegación">
    <div class="circle-item">
        <span class="arrow">➔</span>
        <p><a href="{{ route('quienes.somos') }}">QUIÉNES SOMOS</a></p>
    </div>
    <div class="circle-item">
        <span class="arrow">➔</span>
         <p><a href="{{ route('mapa.index') }}">MAPA</a></p>
    </div>
    <div class="circle-item">
        <span class="arrow">➔</span>
        <p><a href="{{ route('formas.pago') }}">FORMA DE PAGO</a></p>
    </div>
    <div class="circle-item">
        <span class="arrow">➔</span>
         <p><a href="{{ route('soporte') }}">SOPORTE</a></p>
    </div>


</nav>
@if (session('success'))
    <div id="toast-success" style="
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #d4edda;
        color: #155724;
        padding: 15px 20px;
        border-left: 5px solid #28a745;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        z-index: 9999;
        transition: transform 0.5s ease, opacity 0.5s ease;
    ">
        ✅ {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.style.transform = 'translateY(-100%)';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 600); // luego lo elimina
            }
        }, 2000); // 3 segundos visible xd xd
    </script>
@endif

 <script>
   
    </script>
            
    </section>
   
    <footer class="footer-container">
        @include('components.footer')
    </footer>

    <script src="{{ asset('js/Generalidades.js') }}"></script>
    <script>
        let index = 0;
        function moveCarousel() {
            const images = document.querySelector('.carousel-images');
            const carousel = document.querySelector('.carousel');
            // Calcula el ancho de una imagen basado en el ancho real del carrusel
            const imageWidth = carousel ? carousel.offsetWidth : 630;
            index = (index + 1) % 4;
            images.style.transform = `translateX(-${index * imageWidth}px)`;
        }
        setInterval(moveCarousel, 3000);
    </script>
</body>
</html>