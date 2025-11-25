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


let zoomActivo = false;

document.getElementById("lupaBtn").addEventListener("click", () => {
  zoomActivo = !zoomActivo;
  document.body.style.transform = zoomActivo ? "scale(1.2)" : "scale(1)";
  document.body.style.transformOrigin = "top center";
});


function toggleInfo() {
    var infoDiv = document.getElementById("infoProveedor");
    if (infoDiv.style.display === "none") {
        infoDiv.style.display = "block";
    } else {
        infoDiv.style.display = "none";
    }
}



 




