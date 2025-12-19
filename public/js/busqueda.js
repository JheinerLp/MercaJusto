const input = document.getElementById('search-input');
const overlay = document.getElementById('overlay-busqueda');
const resultados = document.getElementById('resultados-busqueda');
const cerrar = document.getElementById('cerrar-busqueda');

let timeout = null;

input.addEventListener('input', () => {
    const query = input.value.trim();

    clearTimeout(timeout);

    if (query.length < 2) {
        overlay.style.display = 'none';
        resultados.innerHTML = '';
        return;
    }

    timeout = setTimeout(() => {
        fetch(`/buscar?q=${encodeURIComponent(query)}`)
            .then(res => res.text())
            .then(html => {
                resultados.innerHTML = html;
                overlay.style.display = 'flex';
            });
    }, 350); // debounce
});

/* Cerrar */
cerrar.addEventListener('click', cerrarBusqueda);

overlay.addEventListener('click', e => {
    if (e.target === overlay) cerrarBusqueda();
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') cerrarBusqueda();
});

function cerrarBusqueda() {
    overlay.style.display = 'none';
}
