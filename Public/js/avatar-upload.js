document.addEventListener("DOMContentLoaded", () => {

    const input = document.getElementById("avatarInput");
    const form  = document.getElementById("avatarForm");

    if (!input || !form) return; // Por si no estamos en el perfil

    input.addEventListener("change", () => {
        if (input.files.length > 0) {
            form.submit();
        }
    });

});
