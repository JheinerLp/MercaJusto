<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $categoria->nombre }}</title>

<link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
<link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
<link rel="stylesheet" href="{{ asset('css/components/productos.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

@include('components.header')
@include('components.lupa')

<div class="contenedor">

    <div class="letrero-categoria">
        <h2>{{ $categoria->nombre }}</h2>
    </div>

    <div class="grid-productos">
        @foreach ($productos as $p)
            @include('components.card-producto', [
                'p' => $p,
                'mostrarPerfil' => true
            ])
        @endforeach
    </div>


  <style>


.letrero-categoria{
    background-image: url('/images/LetreroMercajustoMadera.png');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    
    width: 200px;
    height: 200px;

    margin: 0 0 0 0; /* reduce espacio debajo */

    display: flex;
    align-items: center;
    justify-content: center;
}

.letrero-categoria h2{
    color: white;
    font-size: 28px;
    font-weight: bold;
    text-align: center;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.7); /* para que resalte sobre la madera */
    margin: 0;
}
.contenedor{
    position: relative;
}

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
    
    {{-- PAGINACIÓN --}}
   <div class="paginacion">
    {{ $productos->withQueryString()->links('vendor.pagination.catalogo') }}
</div>
</div>

@include('components.footer')

<script src="{{ asset('js/productos.js') }}" defer></script>
<script src="{{ asset('js/generalidades.js') }}" defer></script>

</body>
</html>
