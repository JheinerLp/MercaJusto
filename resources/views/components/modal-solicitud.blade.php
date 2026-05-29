
{{-- TOAST --}}
<div id="toast" class="toast"></div>

<style>
.toast {
    position: fixed;
    bottom: 25px;
    right: 25px;
    background: #2ecc71;
    color: #fff;
    padding: 14px 22px;
    border-radius: 8px;
    font-size: 14px;
    opacity: 0;
    pointer-events: none;
    transition: all 0.4s ease;
    z-index: 10000;
}
.toast.show { opacity: 1; transform: translateY(-10px); }
.toast.error { background: #e63946; }
</style>


{{-- MODAL --}}
<div id="modalSolicitudProveedor" class="modal">
    <div class="modal-content">
        <span class="cerrar" onclick="cerrarModal('modalSolicitudProveedor')">&times;</span>

        <h3 style="font-size: 1.5rem; font-weight: 700; color: #2c3e50; text-align: center; margin-bottom: 5px;">Solicitud de Proveedor</h3>
        <p style="text-align: center; color: #666; margin-bottom: 20px; font-size: 0.88rem; line-height: 1.4;">
            Completa tu información para unirte como proveedor en MercaJusto. Revisaremos tus datos y, una vez aprobada tu solicitud, te enviaremos las credenciales de acceso a tu correo electrónico.
        </p>

        <form id="formSolicitudProveedor"
              action="{{ route('solicitud.proveedor.store') }}"
              method="POST">
            @csrf

            <div class="form-group-modal">
                <label for="nombre">Nombre Completo <span class="required-star">*</span></label>
                <input type="text" name="nombre" id="nombre" placeholder="Ej: Juan Carlos Pérez" required>
                <span class="help-text">Tu nombre completo como representante legal o contacto principal del negocio.</span>
            </div>

            <div class="form-group-modal">
                <label for="correo">Correo Electrónico <span class="required-star">*</span></label>
                <input type="email" name="correo" id="correo" placeholder="Ej: contacto@tudominio.com" required>
                <span class="help-text">A este correo te enviaremos la confirmación del registro y tus datos de acceso.</span>
            </div>

            <div class="form-group-modal">
                <label for="nombre_empresa">Nombre de la Empresa o Marca <span class="required-star">*</span></label>
                <input type="text" name="nombre_empresa" id="nombre_empresa" placeholder="Ej: Granja Agroecológica El Paraíso" required>
                <span class="help-text">El nombre comercial con el que se identificarán tus productos en el catálogo.</span>
            </div>

            <div class="form-group-modal">
                <label for="categoria_id">Categoría del Negocio <span class="required-star">*</span></label>
                <select name="categoria_id" id="categoria_id" required>
                    <option value="">-- Seleccione una categoría --</option>
                    <option value="1">Frutas y Verduras</option>
                    <option value="2">Lácteos y Carnes</option>
                    <option value="3">Transformados</option>
                    <option value="4">Cosméticos</option>
                    <option value="5">Artesanías</option>
                    <option value="6">Certificados</option>
                    <option value="7">Otros</option>
                </select>
                <span class="help-text">Clasificación principal para que los clientes encuentren tus productos más fácilmente.</span>
            </div>

            <div class="form-group-modal">
                <label for="sede_id">Sede Principal de Operación <span class="required-star">*</span></label>
                <select name="sede_id" id="sede_id" required>
                    <option value="">-- Seleccione sede más cercana --</option>
                    <option value="1">Cali Melendez</option>
                    <option value="2">Buenaventura</option>
                    <option value="3">Palmira</option>
                    <option value="4">Yumbo</option>
                    <option value="5">Buga</option>
                    <option value="6">Tulua</option>
                    <option value="7">Zarzal</option>
                    <option value="8">Cartago</option>
                    <option value="9">Caicedonia</option>
                    <option value="10">Sede Norte </option>
                </select>
                <span class="help-text">Ubicación regional donde gestionas o distribuyes tus entregas.</span>
            </div>

            <div class="form-group-modal">
                <label for="direccion">Dirección Física (Opcional)</label>
                <input type="text" name="direccion" id="direccion" placeholder="Ej: Carrera 100 # 13-22, Finca La Aurora">
                <span class="help-text">Dirección del establecimiento, oficina o finca de producción.</span>
            </div>

            <div class="form-group-modal">
                <label for="descripcion">Descripción del Negocio (Opcional)</label>
                <textarea name="descripcion" id="descripcion" placeholder="Ej: Producimos hortalizas 100% orgánicas y derivados lácteos artesanales..." rows="3"></textarea>
                <span class="help-text">Cuéntanos un poco sobre tu emprendimiento y qué tipo de productos ofreces.</span>
            </div>

            <div class="form-group-modal">
                <label for="telefono">Celular / WhatsApp de Contacto <span class="required-star">*</span></label>
                <input type="text" name="telefono" id="telefono" placeholder="Ej: 3157654321" required>
                <span class="help-text">Número móvil activo. Los compradores podrán contactarte directamente por WhatsApp.</span>
            </div>

            <button type="submit" class="btn-guardar" style="width: 100%; margin-top: 10px; font-weight: bold; background-color: #df0f0f; color: white;">
                Enviar Solicitud de Registro
            </button>
        </form>
    </div>
</div>

<style>
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.modal-content {
    background: #fff;
    padding: 25px;
    width: 95%;
    max-width: 600px;
    border-radius: 12px;
    position: relative;
    max-height: 90vh;
    overflow-y: auto;
}
.cerrar {
    position: absolute;
    top: 12px;
    right: 15px;
    font-size: 28px;
    cursor: pointer;
    color: #999;
    transition: color 0.2s;
}
.cerrar:hover {
    color: #333;
}
</style>



<script>
function abrirModal(id) {
    document.getElementById(id).style.display = 'flex';
}
function cerrarModal(id) {
    document.getElementById(id).style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formSolicitudProveedor');
    const toast = document.getElementById('toast');

    if (!form) return;

    function mostrarToast(msg, error = false) {
        toast.textContent = msg;
        toast.className = 'toast show' + (error ? ' error' : '');
        setTimeout(() => toast.className = 'toast', 3000);
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: new FormData(form)
        })
        .then(async r => {
            const data = await r.json();
            if (!r.ok) throw data;
            mostrarToast(data.message);
            cerrarModal('modalSolicitudProveedor');
            setTimeout(() => location.reload(), 1500);
        })
        .catch(err => mostrarToast(err.message || 'Error', true));
    });
});
</script>

