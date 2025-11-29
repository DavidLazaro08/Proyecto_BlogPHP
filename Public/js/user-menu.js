
//  MENÚ PRO: AVATAR + HAMBURGUESA + CLIC FUERA

document.addEventListener("DOMContentLoaded", () => {
    const bubble = document.querySelector(".user-bubble");
    const dropdown = document.querySelector(".user-dropdown");
    const burger = document.querySelector(".user-menu-icon");

    if (!bubble || !dropdown) return;

    // ---- PULSAR AVATAR ----
    bubble.addEventListener("click", (e) => {
        e.stopPropagation();
        bubble.classList.toggle("active");
        burger.classList.remove("active");
    });

    // ---- PULSAR HAMBURGUESA ----
    burger.addEventListener("click", (e) => {
        e.stopPropagation();
        burger.classList.toggle("active");
        bubble.classList.toggle("active");
    });

    // ---- CLIC FUERA (CIERRA TODO) ----
    document.addEventListener("click", () => {
        bubble.classList.remove("active");
        burger.classList.remove("active");
    });
});
