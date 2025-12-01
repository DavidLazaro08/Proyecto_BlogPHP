document.addEventListener("DOMContentLoaded", () => {

    const menuIcon = document.querySelector(".user-menu-icon");
    const bubble = document.querySelector(".user-bubble");
    const dropdown = document.querySelector(".user-dropdown");

    function toggleMenu() {
        dropdown.classList.toggle("open");
        menuIcon.classList.toggle("active");
    }

    // CLIC EN LA HAMBURGUESA
    menuIcon.addEventListener("click", (e) => {
        e.stopPropagation();
        toggleMenu();
    });

    // CLIC EN EL BUBBLE (nombre + avatar)
    bubble.addEventListener("click", (e) => {
        e.stopPropagation();
        toggleMenu();
    });

    // CERRAR AL HACER CLICK FUERA
    document.addEventListener("click", () => {
        dropdown.classList.remove("open");
        menuIcon.classList.remove("active");
    });
});