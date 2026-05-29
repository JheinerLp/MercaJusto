<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Catálogo de {{ $sede->nombre }}</title>
@include('components.favicon')

<link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
<link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
<link rel="stylesheet" href="{{ asset('css/components/productos.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* ===== FILTROS ===== */
.filtros {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
    align-items: center;
}

.filtros select {
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.letrero-categoria{
    background-image: url('/images/LetreroMercajustoMadera.png');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;

    width: 260px;
    height: 180px;

    margin: -3px auto 15px auto; /* Centrado y subido para que las cuerdas toquen lo rojo */

    display: flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
}

.texto-letrero{
    color: white;
    font-weight: bold;
    font-size: 18px;
    text-align: center;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
    padding-top: 30px; /* Centrado vertical en la madera del letrero */
    padding-left: 15px;
    padding-right: 15px;
}

/* Responsivo para el letrero */
@media (max-width: 768px) {
    .letrero-categoria {
        width: 200px;
        height: 140px;
        margin: -3px auto 10px auto;
    }
    .texto-letrero {
        font-size: 14px;
        padding-top: 20px;
    }
}
</style>
</head>

<body>

<header class="header">
    @include('components.header')
</header>

@include('components.lupa')

<div class="contenedor">
    
    <h1 style="display:none;">Catálogo de {{ $sede->nombre }}</h1>

    <div class="letrero-categoria">
        <span class="texto-letrero">Catálogo de {{ $sede->nombre }}</span>
    </div>

    <!-- 🔍 FILTRO POR CATEGORÍA -->
    <form method="GET" class="filtros">
        <select name="categoria" onchange="this.form.submit()">
            <option value="">Todas las categorías</option>
            @foreach ($categorias as $cat)
                <option value="{{ $cat->id }}"
                    {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->nombre }}
                </option>
            @endforeach
        </select>
    </form>

    <!-- 📦 PRODUCTOS -->
    <div class="grid-productos">
        @foreach ($productos as $p)
            @include('components.card-producto', ['p' => $p, 'mostrarPerfil' => true])
        @endforeach
    </div>

    <!-- 📦 PAGINACIÓN -->
    <div class="paginacion">
        {{ $productos->withQueryString()->links('vendor.pagination.catalogo') }}

    </div>
    <style>
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
</div>



<footer class="footer-container">
    @include('components.footer')
</footer>


<script src="{{ asset('Js/Generalidades.js') }}"></script>
</body>
</html>




