<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mapa de Sedes</title>
<link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/Mapa.css') }}">
<link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    /* Marcador en el mapa - ahora cuadro */
    .marker {
        position: absolute;
        width: 25px;    /* tamaño del cuadro */
        height: 25px;   /* tamaño del cuadro */
        background: transparent;
        border-radius: 0; /* 0 para cuadro, 50% para círculo */
        cursor: pointer;
        transform: translate(-50%, -50%);
        z-index: 5;
        transition: transform 0.2s;
    }

    .marker:hover {
        transform: translate(-50%, -50%) scale(1.2);
    }

    /* Tooltip desplegable con animación y semitransparente */
    .tooltip {
        display: none;
        position: absolute;
        top: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(-10px);
        background: rgba(255,255,255,0.95); /* semitransparente */
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 10;
        width: 220px;
        max-height: 200px; /* altura máxima */
        overflow-y: auto;  /* scroll vertical si hay muchos productos */
        opacity: 0;
        transition: opacity 0.3s, transform 0.3s;
    }

    .tooltip.show {
        display: block;
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    .tooltip strong {
        display: block;
        margin-bottom: 5px;
        font-size: 15px;
    }

    .tooltip span {
        display: block;
        margin-bottom: 3px;
    }

    .tooltip button {
        margin-top: 5px;
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        background: #007bff;
        color: #fff;
        cursor: pointer;
        width: 100%;
        font-size: 14px;
    }

    .tooltip .close-btn {
        position: absolute;
        top: 5px;
        right: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        color: #555;
    }
</style>
</head>
<body>

<header class="header">
    @include('components.header')  
</header>

@include('components.lupa')

<div class="contenedor">
    <div class="Mapa" style="position: relative;">
        <img src="{{ asset('Images/MapaNew.png') }}" alt="Imagen Mapa" style="width: 100%; display: block;">

        @foreach ($sedes as $sede)
            @php
                $productosSede = collect($sede->proveedores)->flatMap(fn($p) => $p->productos);
            @endphp

            <!-- Contenedor relativo a la sede -->
            <div style="position: absolute; top: {{ $sede->top }}; left: {{ $sede->left }}; transform: translate(-50%, -50%); z-index:5;">
                
                <!-- Marcador -->
                <div class="marker" onclick="toggleTooltip('tooltip-{{ $sede->id }}')"></div>

                <!-- Tooltip -->
                <div class="tooltip" id="tooltip-{{ $sede->id }}">
                    <span class="close-btn" onclick="toggleTooltip('tooltip-{{ $sede->id }}')">&times;</span>
                    <strong>{{ $sede->nombre }}</strong>
                    @foreach ($productosSede as $producto)
                        <span>{{ $producto->nombre }}</span>
                    @endforeach
                    <button onclick="window.location='{{ route('productos.catalogo', $sede->id) }}'">Catálogo</button>
                </div>
            </div>
        @endforeach

    </div>
</div>



<footer class="footer-container">
    @include('components.footer')
</footer>

<script>
    function toggleTooltip(id) {
        const tooltip = document.getElementById(id);
        if (tooltip) {
            tooltip.classList.toggle('show');
        }
    }

    // Cierra el tooltip al hacer clic fuera
    document.addEventListener('click', function(e) {
        const tooltips = document.querySelectorAll('.tooltip');
        tooltips.forEach(t => {
            const marker = t.previousElementSibling; // marcador hermano
            if (!t.contains(e.target) && !marker.contains(e.target)) {
                t.classList.remove('show');
            }
        });
    });
</script>

<script src="{{ asset('Js/Generalidades.js') }}"></script>
</body>
</html>
