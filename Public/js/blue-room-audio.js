document.addEventListener("DOMContentLoaded", () => {

    const audio = document.getElementById("ambientAudio");
    const toggle = document.getElementById("soundToggle");

    if (!audio || !toggle) return; // seguridad por si la vista no tiene audio

    // ===== Volumen inicial suave =====
    audio.volume = 0.12;

    // ===== Recuperar estado guardado =====
    let soundState = localStorage.getItem("blueRoomSound") || "off";

    if (soundState === "on") {
        fadeIn(audio);
        toggle.classList.add("active");
        toggle.textContent = "🔇";
    }

    // ===== Evento click =====
    toggle.addEventListener("click", () => {
        if (toggle.classList.contains("active")) {
            fadeOut(audio);
            toggle.classList.remove("active");
            toggle.textContent = "🔊";
            localStorage.setItem("blueRoomSound", "off");
        } else {
            fadeIn(audio);
            toggle.classList.add("active");
            toggle.textContent = "🔇";
            localStorage.setItem("blueRoomSound", "on");
        }
    });

    // ===== Fade in =====
    function fadeIn(aud) {
        aud.volume = 0;
        aud.play();
        let vol = 0;
        const fade = setInterval(() => {
            if (vol < 0.12) {
                vol += 0.01;
                aud.volume = vol;
            } else {
                clearInterval(fade);
            }
        }, 120);
    }

    // ===== Fade out =====
    function fadeOut(aud) {
        let vol = aud.volume;
        const fade = setInterval(() => {
            if (vol > 0) {
                vol -= 0.015;
                aud.volume = vol;
            } else {
                aud.pause();
                aud.currentTime = 0;
                clearInterval(fade);
            }
        }, 120);
    }

});
