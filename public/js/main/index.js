const canvas = document.getElementById('matrix-bg');
const ctx = canvas.getContext('2d');
let width, height, columns, drops;

function init() {
width = canvas.width = window.innerWidth;
height = canvas.height = window.innerHeight;
columns = Math.floor(width / 25);
drops = Array(columns).fill(1);
}

function draw() {
ctx.fillStyle = 'rgba(3, 4, 6, 0.15)';
ctx.fillRect(0, 0, width, height);
ctx.fillStyle = '#00f2ff';
ctx.font = '10px monospace';
for (let i = 0; i < drops.length; i++) {
    const text=Math.random()> 0.5 ? "1" : "0";
    ctx.fillText(text, i * 25, drops[i] * 25);
    if (drops[i] * 25 > height && Math.random() > 0.975) drops[i] = 0;
    drops[i]++;
    }
    }

    window.addEventListener('resize', init);
    init();
    setInterval(draw, 80);

    setInterval(() => {
    const container = document.getElementById('dust-container');
    const dust = document.createElement('div');
    dust.className = 'dust';
    dust.style.left = Math.random() * 100 + '%';
    dust.style.bottom = '-10px';
    container.appendChild(dust);

    const dur = 10000 + Math.random() * 10000;
    const anim = dust.animate([{
    transform: 'translateY(0) opacity(0)',
    opacity: 0
    },
    {
    opacity: 0.5,
    offset: 0.1
    },
    {
    transform: `translateY(-110vh) translateX(${(Math.random()-0.5)*100}px)`,
    opacity: 0
    }
    ], {
    duration: dur,
    easing: 'linear'
    });

    anim.onfinish = () => dust.remove();
    }, 400);

    document.addEventListener('mousemove', (e) => {
    const logo = document.getElementById('parallax-logo');
    const moveX = (e.clientX - window.innerWidth / 2) / 40;
    const moveY = (e.clientY - window.innerHeight / 2) / 40;
    logo.style.transform = `translate(${moveX}px, ${moveY}px) rotateX(${-moveY}deg) rotateY(${moveX}deg)`;
    });