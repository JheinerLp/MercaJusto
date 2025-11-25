<button class="lupa" id="lupaBtn" aria-label="Ampliar contenido" title="Ampliar contenido">
    <i class="fas fa-search-plus search-icon" aria-hidden="true"></i>
</button>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        let zoomActive = false;
        const lupaBtn = document.getElementById('lupaBtn');

        document.addEventListener('mousemove', function (e) {
            if (zoomActive) {
                document.body.style.transformOrigin = `${e.clientX}px ${e.clientY}px`;
            }
        });

        lupaBtn.addEventListener('click', function () {
            zoomActive = !zoomActive;

            if (zoomActive) {
                document.body.style.transform = "scale(1.5)";
                document.body.style.transition = "transform 0.3s ease";
            } else {
                document.body.style.transform = "scale(1)";
                document.body.style.transformOrigin = ""; // 🔁 Reinicia el origen para que no quede "pegado"
            }
        });
    });
</script>