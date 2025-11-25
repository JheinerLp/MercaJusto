<div class="Header_derecha">
    <a href="{{ url('/Menu') }}" class="home-button" title="Volver al inicio">
        <i class="fas fa-home"></i>
    </a>
    <div class="boton-usuario" onclick="toggleUsuarioMenu()">
        <a href="#"><img src="{{ asset('Images/Usuario.jpg') }}" alt="Usuario"></a>
        <div class="menu-usuario" id="menuUsuario">
            <ul>
                <li><a href="#">🔧 Ajustes</a></li>
                <li><a href="{{ url('/Html/Login.html') }}">🔐 Iniciar sesión</a></li>
            </ul>
        </div>
    </div>
    <div class="search-bar">
        <input type="text" placeholder="Buscar..." class="search-input">
    </div>
    <div class="menu-Container">
        <div class="menu-hamburguesa" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <nav class="menu">
            <ul>
                <li><a href="{{ url('/Html/Categorias/Frutas_Verduras.html') }}">Frutas y verduras</a></li>
                <li><a href="{{ url('/Html/Categorias/LacteosyCarnes.html') }}">Lácteos y Carnes</a></li>
                <li><a href="{{ url('/Html/Categorias/Transformados.html') }}">Transformados</a></li>
                <li><a href="{{ url('/Html/Categorias/Cosmeticos.html') }}">Cosméticos</a></li>
                <li><a href="{{ url('/Html/Categorias/Artesanias.html') }}">Artesanías</a></li>
                <li><a href="{{ url('/Html/Categorias/Certificados.html') }}">Certificados</a></li>
                <li><a href="{{ url('/Html/Categorias/Otros.html') }}">Otro</a></li>
            </ul>
        </nav>
    </div>
</div>
