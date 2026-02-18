<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Catálogo de {{ $sede->nombre }}</title>

<link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
<link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">
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

/* ===== GRID ===== */
.grid-productos {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
}

/* ===== CARD ===== */
.card-producto {
    background: #fff;
    padding: 12px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.card-producto:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 22px rgba(0,0,0,0.2);
}

.card-producto img.imagen-producto {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 6px;
    margin-bottom: 8px;
    transition: transform 0.3s ease;
}

.card-producto:hover img {
    transform: scale(1.05);
}

/* ===== BOTONES ===== */
.botones-producto {
    display: flex;
    gap: 8px;
    margin-top: 8px;
}

.btn-contacto, .btn-detalles {
    flex: 1;
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    border: none;
}

.btn-contacto {
    background-color: #25D366;
    color: #fff;
}

.btn-detalles {
    background-color: #007bff;
    color: #fff;
}

/* ===== PAGINACIÓN ===== */
.paginacion {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

/* ===== MODAL ===== */
.modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.6);
}

.modal-content {
    background: #fff;
    margin: 60px auto;
    padding: 20px;
    border-radius: 8px;
    width: 50%;
    max-width: 700px;
}

.modal-body {
    display: flex;
    gap: 16px;
}

.modal-imagen img {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border-radius: 6px;
}

.modal-info {
    flex: 1;
}

.modal .close-btn {
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .modal-content {
        width: 90%;
    }

    .modal-body {
        flex-direction: column;
        align-items: center;
    }

    .modal-imagen img {
        width: 100%;
        height: auto;
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
    <h1>Catálogo de {{ $sede->nombre }}</h1>

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
        <div class="card-producto" onclick="window.location='{{ route('proveedor.perfil', $p->proveedor->id) }}'">
             
            <img src="{{ $p->foto ? asset('storage/' . $p->foto) : asset('Images/no-image.png') }}"
                 alt="{{ $p->nombre }}"
                 class="imagen-producto">

            <h3>{{ $p->nombre }}</h3>
            <p>Proveedor: {{ $p->proveedor->empresa ?? 'Desconocido' }}</p>
            <p>Precio: ${{ number_format($p->precio ?? 0, 0, ',', '.') }}</p>

            <div class="botones-producto">
                <a href="https://wa.me/{{ $p->proveedor->whatsapp ?? '' }}"
                   class="btn-contacto"> Contactar</a>

                <button class="btn-detalles"
                        onclick="abrirModal('modal-{{ $p->id }}')">
                    Detalles
                </button>
            </div>
        </div>

        <!-- MODAL -->
        <div class="modal" id="modal-{{ $p->id }}">
            <div class="modal-content">
                <span class="close-btn"
                      onclick="cerrarModal('modal-{{ $p->id }}')">&times;</span>

                <div class="modal-body">
                    <div class="modal-imagen">
                        <img src="{{ $p->foto ? asset('storage/' . $p->foto) : asset('Images/no-image.png') }}">
                    </div>

                    <div class="modal-info">
                        <h2>{{ $p->nombre }}</h2>
                        <p><strong>Proveedor:</strong> {{ $p->proveedor->empresa }}</p>
                        <p><strong>Precio:</strong> ${{ number_format($p->precio ?? 0, 0, ',', '.') }}</p>
                        <p><strong>Descripción:</strong> {{ $p->descripcion ?? 'Sin descripción' }}</p>

                        <a href="https://wa.me/{{ $p->proveedor->whatsapp ?? '' }}"
                           class="btn-contacto">💬 Contactar</a>
                    </div>
                </div>
            </div>
        </div>
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

<script>
function abrirModal(id) {
    document.getElementById(id).style.display = 'block';
}
function cerrarModal(id) {
    document.getElementById(id).style.display = 'none';
}
window.onclick = function(event) {
    document.querySelectorAll('.modal').forEach(modal => {
        if (event.target === modal) modal.style.display = 'none';
    });
}
</script>

<script src="{{ asset('Js/Generalidades.js') }}"></script>
</body>
</html>




