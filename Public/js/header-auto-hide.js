let lastScroll = 0;
const header = document.querySelector(".private-header-bar");
const dropdown = document.querySelector(".user-dropdown");
const menuIcon = document.querySelector(".user-menu-icon");

window.addEventListener("scroll", () => {
    const current = window.pageYOffset;

    if (current > lastScroll && current > 80) {
        // Bajando → ocultar cabecera
        header.classList.add("private-header-hidden");

        // Cerrar menú si está abierto
        dropdown.classList.remove("open");
        menuIcon.classList.remove("active");

    } else {
        // Subiendo → mostrar cabecera
        header.classList.remove("private-header-hidden");
    }

    lastScroll = current;
});
