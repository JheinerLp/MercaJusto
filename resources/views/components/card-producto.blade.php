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
                    alt="{{ $p->nombre ?? 'Imagen del producto' }}">
            </div>

            <div class="modal-info">
                <h2 style="font-size: 1.6rem; color: #2c3e50; margin-bottom: 8px;">{{ $p->nombre }}</h2>
                
                <p style="margin: 4px 0;"><strong style="color: #2c3e50;">Precio:</strong> 
                    <span style="font-size: 1.25rem; font-weight: 700; color: #df0f0f;">
                        ${{ number_format($p->precio ?? 0, 0, ',', '.') }}
                    </span>
                </p>

                <p style="margin: 6px 0;"><strong style="color: #2c3e50;">Proveedor:</strong> {{ $p->proveedor->empresa }}</p>
                
                <p style="margin: 6px 0;"><strong style="color: #2c3e50;">Categoría:</strong> {{ $p->categoria->nombre ?? 'Sin categoría' }}</p>
                
                @if($p->proveedor->sede)
                    <p style="margin: 6px 0;"><strong style="color: #2c3e50;">Sede de Operación:</strong> {{ $p->proveedor->sede->nombre }}</p>
                @endif

                @if($p->proveedor->ubicacion)
                    <p style="margin: 6px 0;"><strong style="color: #2c3e50;">Dirección:</strong> {{ $p->proveedor->ubicacion }}</p>
                @endif

                <div style="background-color: #f7f9fa; border-left: 4px solid #df0f0f; padding: 10px 12px; border-radius: 4px; margin: 12px 0;">
                    <p style="margin: 0; font-size: 0.82rem; color: #555; line-height: 1.4;">
                        <strong>¿Cómo comprar?</strong><br>
                        En MercaJusto compras directo al productor. Haz clic en <strong>Contactar</strong> para enviarle un mensaje por WhatsApp, acordar el pago y coordinar la entrega.
                    </p>
                </div>

                <div style="margin-top: 15px;">
                    <a href="https://wa.me/{{ $p->proveedor->whatsapp }}"
                       class="btn-contacto"
                       style="display: inline-block; width: 100%; text-align: center; font-weight: bold; padding: 10px 0; border-radius: 8px;">
                         <i class="fab fa-whatsapp"></i> Contactar por WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>