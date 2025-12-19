@props([
    'p',
    'mostrarPerfil' => true, // true = redirige al perfil del proveedor
])

<div class="card-producto"
     @if($mostrarPerfil)
        onclick="window.location='{{ route('proveedor.perfil', $p->proveedor->id) }}'"
     @endif
>

    <!-- Imagen -->
    <img src="{{ $p->foto ? asset('storage/' . $p->foto) : asset('Images/no-image.png') }}"
         alt="{{ $p->nombre ?? 'Producto sin nombre' }}"
         class="imagen-producto">

    <!-- Nombre -->
    <h3>{{ $p->nombre ?? 'Producto sin nombre' }}</h3>

    <!-- Proveedor -->
    <p>Proveedor: {{ $p->proveedor->empresa ?? 'Desconocido' }}</p>

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
