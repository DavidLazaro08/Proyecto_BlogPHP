document.addEventListener("DOMContentLoaded", () => {

    const audio  = document.getElementById("ambientAudio");
    const toggle = document.getElementById("soundToggle");
    const introOverlay = document.getElementById("soundIntroOverlay");

    if (!audio || !toggle) return;

    const MAX_VOL = 0.12;

    // ===============================
    // 1) Recuperar estado y tiempo
    // ===============================

    let soundState = localStorage.getItem("blueRoomSound") || "off";
    let savedTime  = parseFloat(localStorage.getItem("blueRoomTime")) || 0;

    audio.currentTime = savedTime;

    if (soundState === "on") {
        toggle.textContent = "🔇";
        toggle.classList.add("active");
        fadeIn(audio);
    } else {
        toggle.textContent = "🎧";
        toggle.classList.remove("active");
    }

    // ===============================
    // 2) Guardar progreso del audio
    // ===============================
    setInterval(() => {
        if (!audio.paused) {
            localStorage.setItem("blueRoomTime", audio.currentTime);
        }
    }, 300);

    // ===============================
    // 3) Evento click del botón
    // ===============================
    toggle.addEventListener("click", () => {

        if (toggle.classList.contains("active")) {
            // APAGAR
            fadeOut(audio);
            toggle.classList.remove("active");
            toggle.textContent = "🎧";
            localStorage.setItem("blueRoomSound", "off");

        } else {
            // ENCENDER
            fadeIn(audio);
            toggle.classList.add("active");
            toggle.textContent = "🔇";
            localStorage.setItem("blueRoomSound", "on");

            // === Mostrar overlay Blue Room ===
            if (introOverlay) {
                introOverlay.classList.add("active");

                setTimeout(() => {
                    introOverlay.classList.remove("active");
                }, 8000);
            }
        }
    });

    // ===============================
    // 4) Fade IN
    // ===============================
    function fadeIn(aud) {
        aud.volume = 0;
        aud.play();

        let vol = 0;
        const fade = setInterval(() => {
            if (vol < MAX_VOL) {
                vol += 0.01;
                aud.volume = vol;
            } else {
                clearInterval(fade);
            }
        }, 120);
    }

    // ===============================
    // 5) Fade OUT
    // ===============================
    function fadeOut(aud) {
        let vol = aud.volume;
        const fade = setInterval(() => {
            if (vol > 0) {
                vol -= 0.015;
                aud.volume = vol;
            } else {
                aud.pause();
                clearInterval(fade);
            }
        }, 120);
    }

});
