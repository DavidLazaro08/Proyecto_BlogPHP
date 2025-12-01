const canvas = document.getElementById("blueRoomCanvas");
const ctx = canvas.getContext("2d");

function resize() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}
resize();
window.addEventListener("resize", resize);

// -------------- AURORA BLUE ROOM — V6.5 ------------------
// Azul frío + negro profundo + movimiento más perceptible

let t = 0;

function drawAurora() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let i = 0; i < 3; i++) {
        ctx.beginPath();

        const gradient = ctx.createRadialGradient(
            canvas.width * (0.35 + 0.35 * Math.sin(t + i * 1.2)),
            canvas.height * (0.35 + 0.35 * Math.cos(t * 0.55 + i * 1.4)),
            0,
            canvas.width * 0.6,
            canvas.height * 0.6,
            canvas.width * 1.1
        );

        // Tonos tipo Blue Room originales + más contraste
        gradient.addColorStop(0, "rgba(60, 120, 255, 0.16)");   // azul vivo (más fuerte)
        gradient.addColorStop(0.45, "rgba(30, 60, 140, 0.10)"); // azul profundo
        gradient.addColorStop(1, "rgba(0, 0, 0, 0)");           // desaparición limpia

        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    }

    t += 0.0014;  // movimiento suave pero visible (antes era 0.0008)
    requestAnimationFrame(drawAurora);
}

drawAurora();

