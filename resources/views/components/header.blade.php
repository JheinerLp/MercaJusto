<header class="header" role="banner">
    <div class="Header_Conter_blanco">
        <img src="{{ asset('Images/logounivallemenu.JPG') }}" alt="Logo de la Universidad del Valle" class="imagen">
        <h1>Universidad del Valle</h1>
    </div>
<link rel="stylesheet" href="{{ asset('css/busqueda.css') }}">
    <div class="menu-container">
        <div class="Header_Na"> 
            <div class="Titulo_cabeza"> 
                <h2>MUESTRA AGROINDUSTRIAL ARTESANAL <br>Y DE SERVICIOS</h2>  
            </div>
        
            <div class="Header_derecha" style="position:relative;">
                <!-- Botón Usuario con accesibilidad -->
                <a href="{{ url('/') }}" class="home-button" title="Volver al inicio">
                        <i class="fas fa-home"></i>
                    </a>
                <button class="boton-usuario" onclick="toggleUsuarioMenu()" aria-label="Abrir menú de usuario" aria-controls="menuUsuario" aria-expanded="false">
                    <img src="{{ asset('Images/Usuario.jpg') }}" alt="Icono de usuario">
                </button>

                <!-- Menú Usuario -->
             <div class="menu-usuario" id="menuUsuario">
    <ul>
        @if(auth()->check())
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="menu-btn">
                        Cerrar sesión
                    </button>
                </form>
            </li>
        @else
            <li>
                <a href="{{ url('/login') }}" class="menu-link" rel="nofollow">
                    Iniciar sesión
                </a>
            </li>
        @endif
    </ul>
</div>








                <!-- Barra de Búsqueda -->
              <div class="search-bar">
    <label for="search-input" class="sr-only">Buscar productos</label>
    <input type="text"
           id="search-input"
           placeholder="Buscar productos, proveedores o categorías..."
           class="search-input"
           autocomplete="off">
</div>

<!-- OVERLAY DE BÚSQUEDA -->
<div id="overlay-busqueda" class="overlay-busqueda">

    <div class="contenedor-busqueda">

        <!-- HEADER DEL MODAL -->
        <div class="busqueda-header">
            <input type="text"
                   id="search-modal-input"
                   placeholder="Buscar productos, proveedores o categorías..."
                   autocomplete="off">

            <span class="cerrar-busqueda" id="cerrar-busqueda">&times;</span>
        </div>

        <!-- TABS -->
        <div class="tabs-busqueda">
            <button class="tab active" data-tipo="productos">Productos</button>
            <button class="tab" data-tipo="proveedores">Proveedores</button>
            <button class="tab" data-tipo="categorias">Categorías</button>
        </div>

        <!-- LOADER -->
        <div id="loader-busqueda" class="loader" style="display:none;"></div>

        <!-- RESULTADOS -->
        <div id="resultados-busqueda"></div>

    </div>
</div>


                <!-- Menú Hamburguesa y Navegación Principal -->
                <div class="Navegacion">
                    <button class="menu-hamburguesa" onclick="toggleMenu()" aria-label="Abrir menú de navegación" aria-controls="menu" aria-expanded="false">
                        <span></span><span></span><span></span>
                    </button>

                    <nav class="menu" id="menu" aria-label="Menú principal de categorías">
                     <ul>
    <li><a href="{{ route('categoria.show', 'frutas-y-verduras') }}">Frutas y verduras</a></li>
<li><a href="{{ route('categoria.show', 'lacteos-y-carnes') }}">Lácteos y Carnes</a></li>
<li><a href="{{ route('categoria.show', 'transformados') }}">Transformados</a></li>
<li><a href="{{ route('categoria.show', 'cosmeticos') }}">Cosméticos</a></li>
<li><a href="{{ route('categoria.show', 'artesanias') }}">Artesanías</a></li>
<li><a href="{{ route('categoria.show', 'certificados') }}">Certificados</a></li>
<li><a href="{{ route('categoria.show', 'otros') }}">Otros</a></li>
</ul>

                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<script src="{{ asset('js/busqueda.js') }}" defer></script>
