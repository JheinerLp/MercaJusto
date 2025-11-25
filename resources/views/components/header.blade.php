<header class="header" role="banner">
    <div class="Header_Conter_blanco">
        <img src="{{ asset('Images/logounivallemenu.JPG') }}" alt="Logo de la Universidad del Valle" class="imagen">
        <h1>Universidad del Valle</h1>
    </div>

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
                    <input type="text" id="search-input" placeholder="Buscar..." class="search-input" aria-label="Buscar productos">
                </div>

                <!-- Menú Hamburguesa y Navegación Principal -->
                <div class="Navegacion">
                    <button class="menu-hamburguesa" onclick="toggleMenu()" aria-label="Abrir menú de navegación" aria-controls="menu" aria-expanded="false">
                        <span></span><span></span><span></span>
                    </button>

                    <nav class="menu" id="menu" aria-label="Menú principal de categorías">
                     <ul>
    <li><a href="{{ url('/categoria/frutas-y-verduras') }}">Frutas y verduras</a></li>
    <li><a href="{{ url('/categoria/lacteos-y-carnes') }}">Lácteos y Carnes</a></li>
    <li><a href="{{ url('/categoria/transformados') }}">Transformados</a></li>
    <li><a href="{{ url('/categoria/cosmeticos') }}">Cosméticos</a></li>
    <li><a href="{{ url('/categoria/artesanias') }}">Artesanías</a></li>
    <li><a href="{{ url('/categoria/certificado') }}">Certificados</a></li>
    <li><a href="{{ url('/categoria/otros') }}">Otro</a></li>
</ul>

                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
