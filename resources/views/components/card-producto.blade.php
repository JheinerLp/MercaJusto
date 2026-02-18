@props([
    'p',
    'mostrarPerfil' => true,
])

<div class="card-producto"
     @if($mostrarPerfil)
        onclick="window.location='{{ route('proveedor.perfil', $p->proveedor->id) }}'"
     @endif
>

    <!-- Imagen -->
    <img 
        src="{{ $p->foto ? $p->foto : asset('Images/no-image.png') }}"
        alt="{{ $p->nombre ?? 'Producto sin nombre' }}"
        class="imagen-producto"
    >

    <!-- Nombre -->
    <h3>{{ $p->nombre ?? 'Producto sin nombre' }}</h3>

    <!-- Proveedor -->
    <p class="proveedor-nombre">
        Proveedor: {{ $p->proveedor->empresa ?? 'Desconocido' }}
    </p>

    <!-- Precio -->
    <p class="precio">
        ${{ number_format($p->precio ?? 0, 0, ',', '.') }}
    </p>

    <!-- Botones -->
    <div class="botones-producto" onclick="event.stopPropagation()">

        <a href="https://wa.me/{{ $p->proveedor->whatsapp ?? '' }}"
           class="btn-contacto">
             Contactar
        </a>

        <button class="btn-detalles" onclick="abrirModal('modal-{{ $p->id }}')">
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
               <img src="{{ $p->foto ? $p->foto : asset('Images/no-image.png') }}"  
                    alt="Imagen del producto">
            </div>

            <div class="modal-info">
                <h2>{{ $p->nombre }}</h2>
                <p><strong>Proveedor:</strong> {{ $p->proveedor->empresa }}</p>
                <p><strong>Precio:</strong>
                    ${{ number_format($p->precio ?? 0, 0, ',', '.') }}
                </p>
                <p>
                    <strong>Descripción:</strong>
                    {{ $p->descripcion ?? 'Sin descripción' }}
                </p>

                <a href="https://wa.me/{{ $p->proveedor->whatsapp }}"
                   class="btn-contacto">
                     Contactar
                </a>
            </div>
        </div>
    </div>
</div>
<style>

   
/* Información */
.modal-info {
    flex: 1;
}

/* Título */
.modal-info h2 {
    margin-bottom: 10px;
    color: #222; /* color oscuro */
}

/* Textos */
.modal-info p {
    margin: 6px 0;
    color: #444; /* gris oscuro para buena lectura */
}

.modal {
    display: none; /* oculto por defecto */
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    max-width: 700px;
    width: 90%;
    position: relative;
}

.modal-body {
    display: flex;
    gap: 20px;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 22px;
    cursor: pointer;
}


</style>