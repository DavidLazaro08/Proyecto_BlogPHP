let lastScroll = 0;
const header = document.querySelector(".private-header-bar");

window.addEventListener("scroll", () => {
    const current = window.pageYOffset;

    if (current > lastScroll && current > 80) {
        // Bajando → ocultar cabecera
        header.classList.add("private-header-hidden");
    } else {
        // Subiendo → mostrar cabecera
        header.classList.remove("private-header-hidden");
    }

    lastScroll = current;
});
