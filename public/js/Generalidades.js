//Hamburguesa//
function toggleMenu() {
    document.querySelector(".menu").classList.toggle("active");
}
 
 //Usuario// 
 function toggleUsuarioMenu() {
    const menu = document.getElementById("menuUsuario");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

// Cierra el menú si se hace clic fuera de él
document.addEventListener("click", function (event) {
    const menu = document.getElementById("menuUsuario");
    const boton = document.querySelector(".boton-usuario");
    if (!boton.contains(event.target)) {
        menu.style.display = "none";
    }
});

let zoomLevel = 1;

const lupaBtn = document.getElementById("lupaBtn");

lupaBtn.addEventListener("click", () => {
    if (zoomLevel === 1) {
        zoomLevel = 1.3;

        document.body.classList.add("zoom-activo"); // 👈 IMPORTANTE
    } else {
        zoomLevel = 1;

        document.body.classList.remove("zoom-activo"); // 👈 IMPORTANTE
    }

    document.body.style.zoom = zoomLevel;
});



function toggleInfo() {
    var infoDiv = document.getElementById("infoProveedor");
    if (infoDiv.style.display === "none") {
        infoDiv.style.display = "block";
    } else {
        infoDiv.style.display = "none";
    }
}

// ==============================
// FUNCIONES DEL MODAL PRODUCTO
// ==============================

function abrirModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = "flex";
    }
}

function cerrarModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = "none";
    }
}

// Cerrar modal al hacer clic fuera
document.addEventListener("click", function (event) {
    const modales = document.querySelectorAll(".modal");
    modales.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});



 




