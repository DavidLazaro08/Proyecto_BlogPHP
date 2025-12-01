// Efecto de aurora dinámica para el fondo de The Blue Room.
// Genera ondas de luz azuladas en movimiento continuo usando un canvas 2D.

const canvas = document.getElementById("blueRoomCanvas");
const ctx = canvas.getContext("2d");

// Ajusta el lienzo al tamaño de la ventana
function resize() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}
resize();
window.addEventListener("resize", resize);

// ---------------- AURORA BLUE ROOM — V6.5 ----------------
// Tonos fríos, movimiento suave y luminiscencia azul.
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

        gradient.addColorStop(0, "rgba(60, 120, 255, 0.16)");   // azul vivo
        gradient.addColorStop(0.45, "rgba(30, 60, 140, 0.10)"); // azul profundo
        gradient.addColorStop(1, "rgba(0, 0, 0, 0)");           // desvanecido limpio

        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    }

    t += 0.0014; // velocidad del movimiento
    requestAnimationFrame(drawAurora);
}

drawAurora();
