<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Slackey&family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/pages/index.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/global.css') ?>">
    <style>
        .home-page {
            background:
                linear-gradient(rgba(3, 4, 6, 0.85), rgba(3, 4, 6, 0.04)),
                url('images/backgrounds/m-background.png') top / cover no-repeat;
        }
    </style>
    <title>System Override | Neural Core</title>
</head>

<body class="home-page">

    <canvas id="matrix-bg"></canvas>
    <div class="cyber-grid"></div>
    <div id="dust-container" style="position:fixed; inset:0; z-index:3; pointer-events:none;"></div>

    <?= $this->include('partials/navbar') ?>

    <?= $this->include('partials/cyber-preloader') ?>

    <main class="relative z-10">
        <section class="hero-section px-6 md:px-24">
            <div class="container mx-auto grid lg:grid-cols-2 gap-12 items-center">

                <div class="hero-glass-card">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-2 h-2 bg-cyan-400 rounded-full animate-pulse shadow-[0_0_10px_#00f2ff]"></span>
                        <span class="text-[10px] font-mono tracking-[0.4em] text-cyan-500">NEURAL_LINK: ESTABLISHED</span>
                    </div>

                    <h1 class="glitch-hero text-6xl md:text-8xl font-black mb-2" data-text="INITIALIZING">
                        INITIALIZING
                    </h1>
                    <h2 class="text-4xl md:text-5xl font-black text-cyan-400 italic mb-8 tracking-tighter">
                        SYSTEM_OVERRIDE
                    </h2>

                    <p class="text-gray-400 text-lg leading-relaxed max-w-md mb-12 border-l-2 border-cyan-500/30 pl-6">
                        A puzzle-driven game where you redesign the systems that govern a city. </br>
                        <span class="text-white underline decoration-cyan-500">Nova Axiom</span>. Liberate the citizens. Restore control.
                    </p>

                    <div class="flex flex-wrap gap-6">
                        <a href="#" class="cyber-btn primary px-10 py-4 font-black text-sm hover:translate-x-2">
                            RUN_DEMO.EXE
                        </a>
                        <a href="#" class="cyber-btn bg-white/5 border border-white/10 px-10 py-4 font-black text-sm hover:bg-white/10">
                            WATCH_TRAILER
                        </a>
                    </div>
                </div>

                <div class="hero-logo-container">
                    <div class="logo-glow"></div>
                    <img id="parallax-logo" src="<?= base_url('images/main-logo.png') ?>" alt="Logo" class="w-full h-auto drop-shadow-[0_0_30px_rgba(0,242,255,0.3)] transition-transform duration-200">

                    <div class="relative -bottom-6 right-0 left-2/4 font-mono text-[9px] text-cyan-500/40 text-right space-y-1">
                        <div>LATENCY: 12ms</div>
                        <div>PACKET_LOSS: 0%</div>
                        <div>ENCRYPTION: AES_256</div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?= $this->include('partials/footer') ?>

    <script src="<?= base_url('js/partials/loading.js') ?>"></script>
    <script src="<?= base_url('js/main/index.js') ?>"></script>
</body>

</html>