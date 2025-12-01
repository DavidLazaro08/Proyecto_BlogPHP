// Controla el menú del usuario (hamburguesa + burbuja del avatar).
// Permite abrir/cerrar el menú y lo oculta al hacer clic fuera.

document.addEventListener("DOMContentLoaded", () => {

    const menuIcon = document.querySelector(".user-menu-icon");
    const bubble   = document.querySelector(".user-bubble");
    const dropdown = document.querySelector(".user-dropdown");

    // Abre/cierra el menú
    function toggleMenu() {
        dropdown.classList.toggle("open");
        menuIcon.classList.toggle("active");
    }

    // Clic en el icono "hamburguesa"
    menuIcon.addEventListener("click", (e) => {
        e.stopPropagation();
        toggleMenu();
    });

    // Clic en la burbuja (avatar + nombre)
    bubble.addEventListener("click", (e) => {
        e.stopPropagation();
        toggleMenu();
    });

    // Cerrar al hacer clic fuera del menú
    document.addEventListener("click", () => {
        dropdown.classList.remove("open");
        menuIcon.classList.remove("active");
    });
});
