// Matrix Rain Implementation
const canvas = document.getElementById("matrix-bg");
const ctx = canvas.getContext("2d");
let width, height, columns, drops;

function initMatrix() {
  width = canvas.width = window.innerWidth;
  height = canvas.height = window.innerHeight;
  columns = Math.floor(width / 20);
  drops = Array(columns).fill(1);
}

const chars = "01ｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜﾝ".split("");

function drawMatrix() {
  ctx.fillStyle = "rgba(3, 4, 6, 0.1)";
  ctx.fillRect(0, 0, width, height);
  ctx.fillStyle = "#00f2ff";
  ctx.font = "15px monospace";

  for (let i = 0; i < drops.length; i++) {
    const text = chars[Math.floor(Math.random() * chars.length)];
    ctx.fillText(text, i * 20, drops[i] * 20);
    if (drops[i] * 20 > height && Math.random() > 0.975) drops[i] = 0;
    drops[i]++;
  }
}

initMatrix();
window.addEventListener("resize", initMatrix);
setInterval(drawMatrix, 50);

// Dust Particle System
function createDust() {
  const container = document.getElementById("dust-container");
  const dust = document.createElement("div");
  dust.className = "dust";
  dust.style.left = Math.random() * 100 + "%";
  dust.style.bottom = "-10px";

  const duration = 10 + Math.random() * 15;
  dust.style.transition = `all ${duration}s linear`;
  container.appendChild(dust);

  setTimeout(() => {
    dust.style.transform = `translateY(-110vh) translateX(${(Math.random() - 0.5) * 200}px)`;
    dust.style.opacity = "0";
  }, 100);

  setTimeout(() => dust.remove(), duration * 1000);
}
setInterval(createDust, 400);
