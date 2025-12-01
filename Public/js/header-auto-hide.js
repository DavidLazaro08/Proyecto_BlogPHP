// Oculta y muestra la barra superior privada según el desplazamiento.
// Al bajar se esconde la cabecera; al subir vuelve a aparecer.

let lastScroll = 0;
const header = document.querySelector(".private-header-bar");
const dropdown = document.querySelector(".user-dropdown");
const menuIcon = document.querySelector(".user-menu-icon");

window.addEventListener("scroll", () => {
    const current = window.pageYOffset;

    // Si se hace scroll hacia abajo y ya se ha pasado cierto punto → ocultar cabecera
    if (current > lastScroll && current > 80) {
        header.classList.add("private-header-hidden");

        // Cerrar menú si estaba abierto
        dropdown.classList.remove("open");
        menuIcon.classList.remove("active");

    } else {
        // Si se sube → mostrar cabecera nuevamente
        header.classList.remove("private-header-hidden");
    }

    lastScroll = current;
});
