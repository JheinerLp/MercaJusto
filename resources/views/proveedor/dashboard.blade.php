<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Proveedor</title>
    @include('components.favicon')

    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/Menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/ProveedorVista.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
<header class="header">
    @include('components.header')
</header>

@include('components.lupa')

@php
    // 🔥 SE EJECUTA UNA SOLA VEZ (OPTIMIZACIÓN CLAVE)
    $prov = proveedorActual();
@endphp

<main class="proveedor-vista">

    {{-- ============================
        BANNER DEL PROVEEDOR
    ============================ --}}
    <section class="proveedor-banner" onclick="abrirModal('modalBanner')">

        <img src="{{ $prov?->banner ? asset($prov->banner) : asset('images/Banner.png') }}"
             onerror="this.src='{{ asset('images/Banner.png') }}'"
             alt="Banner proveedor">

        <div class="overlay-banner">
            <i class="fas fa-camera"></i>
            <span>Cambiar banner</span>
        </div>

    </section>

    {{-- ============================
         FOTO + INFO DEL PROVEEDOR
    ============================= --}}
    <section class="proveedor-info">

        {{-- FOTO --}}
        <div class="foto-container" onclick="abrirModal('modalFoto')">

            <img src="{{ $prov?->foto ? asset($prov->foto) : asset('images/Usuario.jpg') }}"
                 onerror="this.src='{{ asset('images/Usuario.jpg') }}'"
                 alt="Foto proveedor">

            <div class="overlay-camara">
                <i class="fas fa-camera"></i>
            </div>

        </div>

        {{-- NOMBRE --}}
        <h2 class="nombre-proveedor">{{ $proveedor->empresa ?? 'Proveedor sin nombre' }}</h2>

        {{-- CATEGORÍA --}}
        <p class="categoria">
            <strong>Categoría:</strong> {{ $proveedor->categoria->nombre ?? 'Sin categoría' }}
        </p>

        <div class="datos-proveedor">

            <div class="dato credenciales-box">
                <p><strong>Cuenta</strong><br>Configura tu acceso</p>

                <button class="btn-guardar btn-credenciales"
                        onclick="abrirModalCredenciales()">
                    Credenciales
                </button>
            </div>

            <div class="dato">
                <p><strong>Descripción:</strong> {{ $proveedor->descripcion ?? 'Sin descripción' }}</p>
                <button class="btn-guardar" onclick="abrirModal('modalDescripcion')">
                    Actualizar
                </button>
            </div>

            <div class="dato">
                <p><strong>Dirección:</strong> {{ $proveedor->ubicacion ?? 'Sin dirección' }}</p>
                <button class="btn-guardar" onclick="abrirModal('modalDireccion')">
                    Actualizar
                </button>
            </div>

            <div class="dato">
                <p><strong>Celular / WhatsApp:</strong> {{ $proveedor->whatsapp ?? 'Sin celular' }}</p>
                <button class="btn-guardar" onclick="abrirModal('modalCelular')">
                    Actualizar
                </button>
            </div>

        </div>

    </section>

    {{-- ============================
       PRODUCTOS
    ============================= --}}
    <section class="productos-lista">
        <h3>Mis Productos</h3>

        <button class="btn-agregar-producto" onclick="abrirModal('modalAgregarProducto')">
            + Añadir Producto
        </button>

        <div class="contenedor-productos">
            @forelse($productos as $p)
                <div class="card-producto">
                    <img src="{{ $p->foto ?? asset('img/default-producto.jpg') }}"
                         alt="Imagen"
                         class="imagen-producto">

                    <h4>{{ $p->nombre ?? 'Producto sin nombre' }}</h4>

                    <p class="precio">
                        Precio: ${{ number_format($p->precio ?? 0, 0, ',', '.') }}
                    </p>

                    <button class="btn-editar" onclick="abrirModal('modalEditarProducto{{ $p->id }}')">
                        <i class="fas fa-edit"></i> Editar
                    </button>

                    <button class="btn-eliminar" onclick="abrirModal('modalEliminarProducto{{ $p->id }}')">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>

                {{-- MODAL EDITAR --}}
                <div id="modalEditarProducto{{ $p->id }}" class="modal">
                    <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
                        <span class="cerrar" onclick="cerrarModal('modalEditarProducto{{ $p->id }}')">&times;</span>
                        <h3 style="font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px;">Editar Producto</h3>
                        <p style="font-size: 0.85rem; color: #666; margin-bottom: 15px;">Actualiza la información de tu producto en el catálogo público.</p>

                        <form action="{{ route('proveedor.productos.update', $p->id) }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group-modal">
                                <label for="edit_nombre_{{ $p->id }}">Nombre del Producto <span class="required-star">*</span></label>
                                <input type="text" name="nombre" id="edit_nombre_{{ $p->id }}" value="{{ $p->nombre }}" required placeholder="Ej: Café Orgánico Molido 500g">
                                <span class="help-text">Nombre claro y descriptivo del artículo.</span>
                            </div>

                            <div class="form-group-modal">
                                <label for="edit_precio_{{ $p->id }}">Precio en Pesos ($) <span class="required-star">*</span></label>
                                <input type="number" name="precio" id="edit_precio_{{ $p->id }}" value="{{ $p->precio }}" required placeholder="Ej: 15000">
                                <span class="help-text">Ingresa el valor total sin puntos, comas ni símbolos.</span>
                            </div>

                            <div class="form-group-modal">
                                <label for="edit_descripcion_{{ $p->id }}">Descripción del Producto <span class="required-star">*</span></label>
                                <textarea name="descripcion" id="edit_descripcion_{{ $p->id }}" rows="3" required placeholder="Detalla peso, presentación, ingredientes, etc.">{{ $p->descripcion }}</textarea>
                                <span class="help-text">Describe las características principales para convencer al comprador.</span>
                            </div>

                            <div class="form-group-modal">
                                <label for="edit_foto_{{ $p->id }}">Cambiar Imagen del Producto</label>
                                <input type="file" name="foto" id="edit_foto_{{ $p->id }}" accept="image/*">
                                <span class="help-text">Deja este campo vacío si deseas conservar la imagen actual. Formatos permitidos: JPG, JPEG o PNG. Tamaño máximo: 4MB.</span>
                            </div>

                            <button type="submit" class="btn-guardar" style="width: 100%; font-weight: bold; background-color: #df0f0f; color: white;">Guardar Cambios</button>
                        </form>
                    </div>
                </div>

                {{-- MODAL ELIMINAR --}}
                <div id="modalEliminarProducto{{ $p->id }}" class="modal">
                    <div class="modal-content">
                        <span class="cerrar" onclick="cerrarModal('modalEliminarProducto{{ $p->id }}')">&times;</span>
                        <h3 style="font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px;">Eliminar Producto</h3>
                        
                        <p style="font-size: 0.9rem; color: #333; line-height: 1.5; margin-bottom: 20px;">
                            ¿Estás seguro de que deseas eliminar permanentemente el producto <strong>"{{ $p->nombre }}"</strong>? Esta acción no se puede deshacer.
                        </p>

                        <form action="{{ route('proveedor.productos.destroy', $p->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div style="display: flex; gap: 10px;">
                                <button type="button" class="btn-guardar" onclick="cerrarModal('modalEliminarProducto{{ $p->id }}')" style="flex: 1; background-color: #7f8c8d; color: white; border: none; margin: 0;">Cancelar</button>
                                <button type="submit" class="btn-eliminar" style="flex: 1; margin: 0; background-color: #df0f0f; color: white;">Sí, Eliminar</button>
                            </div>
                        </form>
                    </div>
                </div>

            @empty
                <p>No tienes productos registrados aún.</p>
            @endforelse
        </div>
    </section>

    {{-- MODAL AGREGAR --}}
    {{-- MODAL AGREGAR --}}
    <div id="modalAgregarProducto" class="modal">
        <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
            <span class="cerrar" onclick="cerrarModal('modalAgregarProducto')">&times;</span>
            <h3 style="font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px;">Agregar Producto</h3>
            <p style="font-size: 0.85rem; color: #666; margin-bottom: 15px;">Registra un nuevo producto para que sea visible en el catálogo de MercaJusto.</p>

            <form action="{{ route('proveedor.productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group-modal">
                    <label for="add_nombre">Nombre del Producto <span class="required-star">*</span></label>
                    <input type="text" name="nombre" id="add_nombre" required placeholder="Ej: Manzana Roja Seleccionada (1kg)">
                    <span class="help-text">Indica claramente el nombre y la presentación/cantidad del producto.</span>
                </div>

                <div class="form-group-modal">
                    <label for="add_precio">Precio en Pesos ($) <span class="required-star">*</span></label>
                    <input type="number" name="precio" id="add_precio" required placeholder="Ej: 5000">
                    <span class="help-text">Ingresa el precio de venta al público en números enteros (sin símbolos ni puntos).</span>
                </div>

                <div class="form-group-modal">
                    <label for="add_descripcion">Descripción del Producto <span class="required-star">*</span></label>
                    <textarea name="descripcion" id="add_descripcion" rows="3" required placeholder="Ej: Manzanas frescas cosechadas en el departamento de Boyacá, excelente tamaño y dulzura..."></textarea>
                    <span class="help-text">Proporciona detalles sobre el cultivo, origen, peso u otras especificaciones importantes.</span>
                </div>

                <div class="form-group-modal">
                    <label for="add_foto">Foto del Producto <span class="required-star">*</span></label>
                    <input type="file" name="foto" id="add_foto" accept="image/*" required>
                    <span class="help-text">Sube una foto clara y atractiva de tu producto. Formatos permitidos: JPG, JPEG o PNG. Máximo: 4MB.</span>
                </div>

                <button type="submit" class="btn-guardar" style="width: 100%; font-weight: bold; background-color: #df0f0f; color: white;">Publicar Producto</button>
            </form>
        </div>
    </div>

</main>

<footer class="footer-container">
    @include('components.footer')
</footer>

<script src="{{ asset('js/Generalidades.js') }}"></script>

{{-- ================= MODALES ================= --}}

<div id="modalBanner" class="modal">
    <div class="modal-content">
        <span class="cerrar" onclick="cerrarModal('modalBanner')">&times;</span>
        <h3 style="font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px;">Actualizar Banner de Portada</h3>
        <p style="font-size: 0.85rem; color: #666; margin-bottom: 15px;">Sube una imagen amplia para personalizar el encabezado de tu tienda.</p>
        
        <form action="{{ route('proveedor.banner') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group-modal">
                <label for="banner_input">Seleccionar Banner <span class="required-star">*</span></label>
                <input type="file" name="banner" id="banner_input" accept="image/*" required>
                <span class="help-text">Se sugiere resolución de 1200x400 px. Formatos: JPG, PNG o WEBP. Máx 5MB.</span>
            </div>
            <button type="submit" class="btn-guardar" style="width: 100%; font-weight: bold; background-color: #df0f0f; color: white;">Subir Banner</button>
        </form>
    </div>
</div>

<div id="modalFoto" class="modal">
    <div class="modal-content">
        <span class="cerrar" onclick="cerrarModal('modalFoto')">&times;</span>
        <h3 style="font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px;">Actualizar Foto de Perfil</h3>
        <p style="font-size: 0.85rem; color: #666; margin-bottom: 15px;">Sube un logotipo o fotografía que identifique tu marca de proveedor.</p>
        
        <form action="{{ route('proveedor.foto') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group-modal">
                <label for="foto_input">Seleccionar Foto <span class="required-star">*</span></label>
                <input type="file" name="foto" id="foto_input" accept="image/*" required>
                <span class="help-text">Se recomienda relación de aspecto 1:1 (cuadrada). Formatos: JPG, PNG, WEBP. Máx 3MB.</span>
            </div>
            <button type="submit" class="btn-guardar" style="width: 100%; font-weight: bold; background-color: #df0f0f; color: white;">Subir Foto</button>
        </form>
    </div>
</div>

<div id="modalDescripcion" class="modal">
    <div class="modal-content">
        <span class="cerrar" onclick="cerrarModal('modalDescripcion')">&times;</span>
        <h3 style="font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px;">Editar Descripción del Negocio</h3>
        <p style="font-size: 0.85rem; color: #666; margin-bottom: 15px;">Escribe una reseña comercial atractiva para darte a conocer ante los compradores.</p>
        
        <form action="{{ route('proveedor.descripcion') }}" method="POST">
            @csrf
            <div class="form-group-modal">
                <label for="descripcion_input">Reseña o Descripción Comercial <span class="required-star">*</span></label>
                <textarea name="descripcion" id="descripcion_input" rows="5" required placeholder="Ej: Somos una cooperativa de agricultores locales enfocados en cultivos limpios y saludables...">{{ $proveedor->descripcion }}</textarea>
                <span class="help-text">Esta descripción aparecerá públicamente en tu perfil.</span>
            </div>
            <button type="submit" class="btn-guardar" style="width: 100%; font-weight: bold; background-color: #df0f0f; color: white;">Guardar Descripción</button>
        </form>
    </div>
</div>

<div id="modalDireccion" class="modal">
    <div class="modal-content">
        <span class="cerrar" onclick="cerrarModal('modalDireccion')">&times;</span>
        <h3 style="font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px;">Editar Dirección Física</h3>
        <p style="font-size: 0.85rem; color: #666; margin-bottom: 15px;">Modifica la ubicación de tu finca, local o punto de retiro.</p>
        
        <form action="{{ route('proveedor.direccion') }}" method="POST">
            @csrf
            <div class="form-group-modal">
                <label for="direccion_input">Dirección <span class="required-star">*</span></label>
                <input type="text" name="direccion" id="direccion_input" value="{{ $proveedor->ubicacion }}" required placeholder="Ej: Calle 2 Oeste # 14-50, Cali">
                <span class="help-text">Los compradores la usarán de referencia para ubicar tu cobertura.</span>
            </div>
            <button type="submit" class="btn-guardar" style="width: 100%; font-weight: bold; background-color: #df0f0f; color: white;">Guardar Dirección</button>
        </form>
    </div>
</div>

<div id="modalCelular" class="modal">
    <div class="modal-content">
        <span class="cerrar" onclick="cerrarModal('modalCelular')">&times;</span>
        <h3 style="font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px;">Editar Número de Celular</h3>
        <p style="font-size: 0.85rem; color: #666; margin-bottom: 15px;">Modifica el teléfono de WhatsApp de tu negocio. Los clientes te enviarán mensajes directos aquí.</p>
        
        <form action="{{ route('proveedor.celular') }}" method="POST">
            @csrf
            <div class="form-group-modal">
                <label for="celular_input">Celular / WhatsApp <span class="required-star">*</span></label>
                <input type="text" name="celular" id="celular_input" value="{{ $proveedor->whatsapp }}" required placeholder="Ej: 3157654321">
                <span class="help-text">Escríbelo solo con números, sin espacios ni símbolos especiales.</span>
            </div>
            <button type="submit" class="btn-guardar" style="width: 100%; font-weight: bold; background-color: #df0f0f; color: white;">Guardar Celular</button>
        </form>
    </div>
</div>

{{-- CREDENCIALES --}}
<div id="modalCredenciales" class="modal">
    <div class="modal-content modal-credenciales" style="max-height: 90vh; overflow-y: auto;">
        <span class="cerrar" onclick="cerrarModalCredenciales()">&times;</span>
        <h3 style="font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px;">Actualizar Credenciales</h3>
        <p style="font-size: 0.85rem; color: #666; margin-bottom: 15px;">Modifica tu correo electrónico de acceso o tu contraseña. Por seguridad, se enviará un código OTP a tu correo actual.</p>

        <form id="formCredenciales" action="{{ route('proveedor.credenciales') }}" method="POST">
            @csrf

            <div class="form-group-modal">
                <label for="cred_email">Correo Electrónico <span class="required-star">*</span></label>
                <input type="email" name="email" id="cred_email" value="{{ auth()->user()?->email }}" required placeholder="contacto@tudominio.com">
                <span class="help-text">Dirección de correo electrónico asociada a tu cuenta.</span>
            </div>

            <div class="form-group-modal">
                <label for="cred_email_confirm">Confirmar Correo Electrónico <span class="required-star">*</span></label>
                <input type="email" name="email_confirmation" id="cred_email_confirm" required placeholder="Repite tu correo electrónico">
                <span class="help-text">Ambos correos deben coincidir para poder guardar los cambios.</span>
            </div>

            <div class="form-group-modal">
                <label for="cred_password">Nueva Contraseña (Opcional)</label>
                <input type="password" name="password" id="cred_password" placeholder="Dejar vacío si no deseas cambiarla">
                <span class="help-text">Escribe al menos 8 caracteres si decides cambiarla.</span>
            </div>

            <div class="form-group-modal">
                <label for="cred_password_confirm">Confirmar Nueva Contraseña</label>
                <input type="password" name="password_confirmation" id="cred_password_confirm" placeholder="Repite la nueva contraseña">
                <span class="help-text">Debe coincidir exactamente con la nueva contraseña ingresada.</span>
            </div>

            <div style="background-color: #f7f9fa; border: 1px solid #ddd; padding: 12px; border-radius: 8px; margin-bottom: 15px; text-align: center;">
                <p style="margin: 0 0 8px 0; font-size: 0.82rem; color: #555; line-height: 1.4;">
                    <strong>Confirmación de Identidad</strong><br>
                    Debes solicitar un código y digitarlo abajo para autorizar la actualización de tus credenciales.
                </p>
                <button type="button" onclick="enviarCodigo()" class="btn-guardar" style="margin: 0; background-color: #2c3e50; color: white; padding: 6px 12px; font-size: 0.85rem;">
                    📩 Enviar código al correo
                </button>
            </div>

            <div class="form-group-modal">
                <label for="cred_otp">Código de Verificación OTP <span class="required-star">*</span></label>
                <input type="text" name="otp_code" id="cred_otp" required placeholder="Ingresa el código de 6 dígitos">
                <span class="help-text">Digita el código recibido en tu correo electrónico.</span>
            </div>

            <button type="submit" class="btn-guardar" style="width: 100%; font-weight: bold; background-color: #df0f0f; color: white; margin-top: 10px;">Guardar Cambios de Acceso</button>
        </form>
    </div>
</div>

{{-- TOASTS --}}
@if(session('success'))
<div id="toastSuccess" class="toast success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div id="toastError" class="toast error">{{ session('error') }}</div>
@endif

<script>
function abrirModal(id){ document.getElementById(id).style.display='flex'; }
function cerrarModal(id){ document.getElementById(id).style.display='none'; }

function abrirModalCredenciales(){
    document.getElementById('modalCredenciales').style.display='flex';
}

function cerrarModalCredenciales(){
    document.getElementById('modalCredenciales').style.display='none';
}

function enviarCodigo(){
    fetch("{{ route('proveedor.enviar.codigo') }}", {
        method:"POST",
        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":"{{ csrf_token() }}"
        }
    })
    .then(()=>{
        const t=document.createElement('div');
        t.className='toast success show';
        t.innerText='📩 Código enviado';
        document.body.appendChild(t);
        setTimeout(()=>t.remove(),3000);
    });
}

document.addEventListener('DOMContentLoaded',()=>{
    document.querySelectorAll('.toast').forEach(t=>{
        t.classList.add('show');
        setTimeout(()=>t.classList.remove('show'),3000);
    });
});
</script>

</body>
</html>