<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/Mapa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header class="header">
    @include('components.header')  
    </header>

    @include('components.lupa')

    <div class="contenedor">
        <div class="Mapa" style="position: relative;">
            <img src="{{ asset('Images/MapaNew.png') }}" alt="Imagen Mapa" style="width: 100%; display: block;">

            {{-- Puntos interactivos sobre el mapa --}}
            @php
                $sedes = [
                    ['id' => 'Cartago', 'top' => '18%', 'left' => '65%', 'productos' => ['Papa', 'Zanahoria', 'Miel Premium']],
                    ['id' => 'Zarzal', 'top' => '33%', 'left' => '59%', 'productos' => ['Tomate', 'Cebolla', 'Aguacate']],
                    ['id' => 'Caicedonia', 'top' => '35%', 'left' => '68%', 'productos' => ['Tomate', 'Cafe', 'Aguacate']],
                    ['id' => 'Tulua', 'top' => '45%', 'left' => '55%', 'productos' => ['Pepino', 'Cafe', 'Aguacate']],
                    ['id' => 'Buga', 'top' => '53%', 'left' => '52%', 'productos' => ['Pepino', 'Cafe', 'Cafe-aragua']],
                    ['id' => 'Buenaventura', 'top' => '53%', 'left' => '24%', 'productos' => ['Pepino', 'Semillas de chia', 'Cafe-aragua']],
                    ['id' => 'Yumbo', 'top' => '65%', 'left' => '45%', 'productos' => ['Pepino', 'Semillas de chia', 'Cafe-aragua']],
                    ['id' => 'Cali', 'top' => '72%', 'left' => '44%', 'productos' => ['Pepino', 'Semillas de chia', 'Cafe-aragua']],
                    ['id' => 'Palmira', 'top' => '68%', 'left' => '52%', 'productos' => ['Pepino', 'Semillas de chia', 'Cafe-aragua']],
                    ['id' => 'Santander de quilichao', 'top' => '89%', 'left' => '35%', 'productos' => ['Pepino', 'Semillas de chia', 'Cafe-aragua']],
                ];
            @endphp

            @foreach ($sedes as $sede)
                <div class="tooltip-area"
                    role="button"
                    aria-label="Ver productos en sede {{ $sede['id'] }}"
                    style="position: absolute; top: {{ $sede['top'] }}; left: {{ $sede['left'] }}; width: 40px; height: 40px; cursor: pointer;"
                    onclick="abrirModal('modal{{ $sede['id'] }}')"
                    tabindex="0"
                    onkeypress="if(event.key === 'Enter'){abrirModal('modal{{ $sede['id'] }}')}">
                <div class="tooltip">
                <strong>Sede {{ $sede['id'] }}</strong><br>Haz clic para ver productos
        </div>
    </div>
            @endforeach
        </div>
    </div>

    {{-- Modales por sede --}}
    @foreach ($sedes as $sede)
        <div id="modal{{ $sede['id'] }}" class="modal">
            <div class="modal-content">
                <span class="close" onclick="cerrarModal('modal{{ $sede['id'] }}')">&times;</span>
                <h2>Productos en {{ $sede['id'] }}</h2>
                <ul>
                    @foreach ($sede['productos'] as $producto)
                        <li>{{ $producto }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach

    <script>
        function abrirModal(id) {
            document.getElementById(id).style.display = 'block';
        }
        function cerrarModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
    @include('components.botsoporte')
    <footer class="footer-container">
        @include('components.footer')
    </footer>

    <script src="{{ asset('Js/Generalidades.js') }}"></script>
</body>
</html>
