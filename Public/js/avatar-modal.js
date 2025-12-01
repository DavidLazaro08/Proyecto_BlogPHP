document.addEventListener("DOMContentLoaded", () => {

    const avatar = document.getElementById("profileAvatar");
    const modal = document.getElementById("avatarModal");
    const btnClose = document.getElementById("avatarClose");

    if (!avatar || !modal || !btnClose) return;

    avatar.addEventListener("click", () => {
        modal.classList.add("active");
    });

    btnClose.addEventListener("click", () => {
        modal.classList.remove("active");
    });

    modal.addEventListener("click", e => {
        if (e.target === modal) modal.classList.remove("active");
    });

});
