<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>{{ $proveedor->empresa }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
<link rel="stylesheet" href="{{ asset('css/components/productos.css') }}">
<link rel="stylesheet" href="{{ asset('css/layout/Menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
.banner-container {
    width: 100%;
    height: 350px; /* Puedes ajustar */
    overflow: hidden;
}

.banner-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}


.info-proveedor {
    display: flex;
    gap: 20px;
    margin-top: -60px;
    align-items: flex-end;
}

.foto-proveedor {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #fff;
}

.datos-proveedor h1 {
    margin: 0;
}

.grid-productos {
    margin-top: 40px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
}
</style>
</head>

<body>

@include('components.header')

<div class="contenedor">

    {{-- BANNER --}}
    <div class="banner-container">
        <img src="{{ optional(auth()->user()->proveedor)->banner ? asset(optional(auth()->user()->proveedor)->banner) : asset('images/Banner.png') }}"onerror="this.src='{{ asset('images/Banner.png') }}'"  alt="Banner de {{ $proveedor->empresa }}" class="banner-img">
</div>

    

    {{-- INFO --}}
    <div class="info-proveedor">
        <img src="{{ optional(optional(auth()->user())->proveedor)->foto ? asset(optional(auth()->user()->proveedor)->foto) : asset('images/Usuario.jpg') }}"onerror="this.src='{{ asset('images/Usuario.jpg') }}' "class="foto-proveedor" >

        <div class="datos-proveedor">
            <h1>{{ $proveedor->empresa }}</h1>
            <p>{{ $proveedor->descripcion }}</p>
            <p><strong>Dirección:</strong> {{ $proveedor->direccion }}</p>

            <a href="https://wa.me/{{ $proveedor->whatsapp }}" class="btn-contacto">
                💬 Contactar proveedor
            </a>
        </div>
    </div>

    {{-- PRODUCTOS --}}
    <h2 style="margin-top:40px">Productos</h2>

    <div class="grid-productos">
        @foreach ($proveedor->productos as $p)
            @include('components.card-producto', ['p' => $p, 'mostrarPerfil' => false])
        @endforeach
    </div>

</div>

@include('components.footer')
<script src="{{ asset('js/productos.js') }}" defer></script>
<script src="{{ asset('js/generalidades.js') }}" defer></script>

</body>
</html>
