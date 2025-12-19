document.addEventListener('DOMContentLoaded', () => {

    const inputHeader = document.getElementById('search-input');
    const overlay = document.getElementById('overlay-busqueda');
    const inputModal = document.getElementById('search-modal-input');
    const resultados = document.getElementById('resultados-busqueda');
    const loader = document.getElementById('loader-busqueda');
    const cerrar = document.getElementById('cerrar-busqueda');

    if (!inputHeader || !overlay || !inputModal) return;

    let tipo = 'productos';
    let timeout = null;

    /* Abrir modal al escribir */
    inputHeader.addEventListener('input', () => {
        overlay.style.display = 'flex';
        inputModal.value = inputHeader.value;
        buscar();
    });

    /* Seguir buscando desde el modal */
    inputModal.addEventListener('input', () => {
        inputHeader.value = inputModal.value;
        buscar();
    });

    /* Tabs */
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            tipo = tab.dataset.tipo;
            buscar();
        });
    });

    function buscar() {
        const q = inputModal.value.trim();
        clearTimeout(timeout);

        if (q.length < 2) {
            resultados.innerHTML = '';
            loader.style.display = 'none';
            return;
        }

        loader.style.display = 'block';

        timeout = setTimeout(() => {
            fetch(`/buscar?q=${encodeURIComponent(q)}&tipo=${tipo}`)
                .then(r => r.text())
                .then(html => {
                    resultados.innerHTML = html;
                    loader.style.display = 'none';
                });
        }, 300);
    }

    /* Cerrar */
    cerrar.addEventListener('click', cerrarModal);
    overlay.addEventListener('click', e => {
        if (e.target === overlay) cerrarModal();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') cerrarModal();
    });

    function cerrarModal() {
        overlay.style.display = 'none';
        resultados.innerHTML = '';
        inputHeader.blur();
    }

});

