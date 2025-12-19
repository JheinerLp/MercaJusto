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
    <h1>{{ $categoria->nombre }}</h1>

    <div class="grid-productos">
        @foreach ($productos as $p)
            @include('components.card-producto', [
                'p' => $p,
                'mostrarPerfil' => true
            ])
        @endforeach
    </div>

    {{-- PAGINACIÓN --}}
    <div class="paginacion">
        {{ $productos->links() }}
    </div>
</div>

@include('components.footer')

<script src="{{ asset('js/productos.js') }}" defer></script>
<script src="{{ asset('js/generalidades.js') }}" defer></script>

</body>
</html>
