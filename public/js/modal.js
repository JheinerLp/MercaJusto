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