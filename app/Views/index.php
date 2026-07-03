<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= base_url('Override.png'); ?>" sizes="32x32">
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>" sizes="32x32">
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

<body class="home-page" data-audio="<?= base_url('./audio/override-sfx-zenith-protocol.MP3') ?>">

    <canvas id="matrix-bg"></canvas>
    <div class="cyber-grid"></div>
    <div id="dust-container" style="position:fixed; inset:0; z-index:3; pointer-events:none;"></div>

    <?= $this->include('partials/navbar') ?>
    <?= $this->include('partials/cyber-preloader') ?>

    <main class="relative z-10 w-full overflow-hidden">
        
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
                        A puzzle-driven game where you redesign the systems that govern a city. <br>
                        <span class="text-white underline decoration-cyan-500">Nova Axiom</span>. Liberate the citizens. Restore control.
                    </p>

                    <div class="flex flex-wrap gap-6">
                        <a href="https://play.unity.com/en/games/544cefa4-54a4-4ef8-973d-7ca526d5e010/system-override-prototype?fbclid=IwZXh0bgNhZW0CMTAAYnJpZBExVHhGMmFaZ3FpSnlKRmdxeHNydGMGYXBwX2lkEDIyMjAzOTE3ODgyMDA4OTIAAR6RmbrfIj79kl7SFISwo2ogu_CNToJq7YiLVHEsg410dYf3y3xQ-5Vgk-tKtQ_aem_1fXlfgPKDihGHaRlfhvbsg" class="cyber-btn primary px-10 py-4 font-black text-sm hover:translate-x-2">
                            RUN_DEMO.EXE
                        </a>
                        <a href="#" class="cyber-btn bg-white/5 border border-white/10 px-10 py-4 font-black text-sm hover:bg-white/10">
                            WATCH_TRAILER
                        </a>
                    </div>
                </div>

                <div class="hero-video-container relative group w-full">
                    <div class="absolute -inset-2 rounded-3xl bg-gradient-to-r via-blue-500/20 to-cyan-500/20 blur-2xl opacity-30 group-hover:opacity-60 transition-all duration-700"></div>
                    
                    <div class="absolute inset-0 pointer-events-none rounded-2xl opacity-10 z-30"
                         style="background:repeating-linear-gradient(to bottom, transparent 0px, transparent 3px, rgba(0,255,255,.15) 4px);">
                    </div>

                    <div id="trailer-frame" class="relative overflow-hidden border border-cyan-500/40 bg-black backdrop-blur-md shadow-[0_0_40px_rgba(0,242,255,.15)]">
                        <div class="absolute top-0 left-0 right-0 z-20 h-10 bg-black/70 border-b border-cyan-500/30 flex items-center justify-between px-4 font-mono text-[10px] tracking-widest">
                            <span class="text-cyan-400">SYSTEM_OVERRIDE://LIVE_FEED</span>
                            <span class="text-cyan-500/60">NODE-07</span>
                        </div>

                        <div class="pt-10">
                            <div class="relative aspect-video">
                                <iframe class="absolute inset-0 w-full h-full"
                                        src="https://www.youtube.com/embed/i4AUex3_jCg"
                                        title="Trailer"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                </iframe>
                            </div>
                        </div>

                        <div class="absolute top-3 left-3 w-6 h-6 border-l-2 border-t-2 border-cyan-400"></div>
                        <div class="absolute top-3 right-3 w-6 h-6 border-r-2 border-t-2 border-cyan-400"></div>
                        <div class="absolute bottom-3 left-3 w-6 h-6 border-l-2 border-b-2 border-cyan-400"></div>
                        <div class="absolute bottom-3 right-3 w-6 h-6 border-r-2 border-b-2 border-cyan-400"></div>

                        <div class="absolute bottom-5 left-5 z-20 flex items-center gap-2 bg-black/60 px-3 py-1 rounded-full font-mono text-[10px]">
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                            <span class="text-red-400">REC</span>
                        </div>

                        <div class="absolute bottom-5 right-5 z-20 font-mono text-[10px] text-cyan-400 text-right">
                            FPS : 60<br>
                            LATENCY : 12ms<br>
                            AES-256
                        </div>
                    </div>

                    <div class="flex justify-between mt-5 px-1 font-mono text-[10px] text-cyan-500/50">
                        <span>VIDEO_STREAM : ACTIVE</span>
                        <span>CONNECTION SECURE</span>
                    </div>
                </div>

            </div>
        </section>

        <section class="py-24 px-6 md:px-24 bg-slate-950/50 border-t border-b border-slate-900 relative overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-cyan-500/5 blur-[180px] rounded-full pointer-events-none"></div>

            <div class="container mx-auto relative z-10">
                <div class="text-center mb-16">
                    <span class="text-xs font-mono tracking-[0.4em] text-cyan-400">MODULE_02 // PLAYER_FEEDBACK</span>
                    <h2 class="mt-4 text-4xl md:text-5xl font-black text-white font-['Orbitron'] uppercase">Transmission Logs</h2>
                    <p class="mt-5 text-slate-400 max-w-2xl mx-auto">
                        Feedback collected from students and playtesters who successfully infiltrated the Nova Axiom network.
                    </p>
                </div>

                <?php if (!empty($feedbacks)): ?>
                    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">
                        <?php foreach ($feedbacks as $feedback): ?>
                            <div class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/50 backdrop-blur-md p-6 hover:border-cyan-500/50 transition-all duration-300">
                                <div class="absolute -top-12 -right-12 w-32 h-32 bg-cyan-500/10 blur-3xl rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                                <div class="flex justify-between items-start mb-5">
                                    <div>
                                        <h3 class="font-bold text-white text-lg"><?= esc($feedback['username']) ?></h3>
                                        <?php if (!empty($feedback['email'])): ?>
                                            <p class="text-xs text-slate-500"><?= esc($feedback['email']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <span class="text-[10px] uppercase font-mono px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-400 border border-cyan-500/20">
                                        <?= esc($feedback['feedback_type']) ?>
                                    </span>
                                </div>

                                <blockquote class="text-slate-300 leading-relaxed italic">
                                    "<?= esc($feedback['comment']) ?>"
                                </blockquote>

                                <div class="mt-6 pt-4 border-t border-slate-800 flex justify-between items-center">
                                    <span class="text-xs font-mono text-slate-500">VERIFIED LOG</span>
                                    <span class="text-xs text-cyan-500"><?= date('M d, Y', strtotime($feedback['created_at'])) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="rounded-2xl border border-dashed border-slate-700 py-16 px-8 text-center bg-slate-900/30">
                        <h3 class="text-xl font-bold text-white mb-3">No Feedback Available</h3>
                        <p class="text-slate-500">Player transmission logs have not yet been received.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="py-24 px-6 md:px-24 bg-slate-950/40 border-t border-b border-slate-900 backdrop-blur-sm relative">
            <div class="absolute top-0 left-1/4 w-1/2 h-[1px] bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent"></div>

            <div class="container mx-auto">
                <div class="mb-16 max-w-xl">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs font-mono tracking-[0.3em] text-emerald-400">MODULE_01 // CORE_CURRICULUM</span>
                    </div>
                    <h3 class="text-3xl md:text-4xl font-black text-white font-['Orbitron'] tracking-tight uppercase">
                        Master the Logic. <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">Reclaim Nova Axiom.</span>
                    </h3>
                    <p class="text-sm text-slate-400 font-mono mt-4 leading-relaxed">
                        The mainframe doesn't respond to raw force. To bypass the city security shields, you must learn to think in algorithmic steps, execute logical operations, and debug corrupted execution pipes.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-slate-900/40 border border-slate-800/80 rounded-2xl p-6 hover:border-cyan-500/40 transition-all duration-300 group flex flex-col justify-between backdrop-blur-md relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-cyan-500/5 blur-2xl rounded-full pointer-events-none group-hover:bg-cyan-500/10 transition-all"></div>
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-cyan-950/50 border border-cyan-800/30 flex items-center justify-center text-cyan-400 mb-6 group-hover:scale-110 transition-transform">
                                <i class="fas fa-sitemap text-lg"></i>
                            </div>
                            <h4 class="text-lg font-bold text-white font-['Orbitron'] mb-2 tracking-wide group-hover:text-cyan-400 transition-colors">
                                01 / SEQUENTIAL_FLOW
                            </h4>
                            <p class="text-slate-400 text-sm leading-relaxed font-sans">
                                Trace and control execution pathways. Arrange statements step-by-step to control mechanical structures, navigate drones, and cycle infrastructure state operations cleanly.
                            </p>
                        </div>
                        <div class="mt-8 pt-4 border-t border-slate-800/60 flex justify-between items-center text-[10px] font-mono text-slate-500">
                            <span>TOPIC: ALG_STRUCTURES</span>
                            <span class="text-cyan-500/60">ONLINE</span>
                        </div>
                    </div>

                    <div class="bg-slate-900/40 border border-slate-800/80 rounded-2xl p-6 hover:border-purple-500/40 transition-all duration-300 group flex flex-col justify-between backdrop-blur-md relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 blur-2xl rounded-full pointer-events-none group-hover:bg-purple-500/10 transition-all"></div>
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-purple-950/50 border border-purple-800/30 flex items-center justify-center text-purple-400 mb-6 group-hover:scale-110 transition-transform">
                                <i class="fas fa-code-branch text-lg"></i>
                            </div>
                            <h4 class="text-lg font-bold text-white font-['Orbitron'] mb-2 tracking-wide group-hover:text-purple-400 transition-colors">
                                02 / CONDITIONAL_GATES
                            </h4>
                            <p class="text-slate-400 text-sm leading-relaxed font-sans">
                                Intercept network routers and establish dynamic criteria nodes. Deploy Python-modeled conditionally structured <code class="bg-slate-950 px-1 py-0.5 rounded text-purple-300 text-xs font-mono">if/else</code> rules to route power and isolate corrupt automated sentries.
                            </p>
                        </div>
                        <div class="mt-8 pt-4 border-t border-slate-800/60 flex justify-between items-center text-[10px] font-mono text-slate-500">
                            <span>TOPIC: CONTROL_FLOW</span>
                            <span class="text-purple-500/60">READY</span>
                        </div>
                    </div>

                    <div class="bg-slate-900/40 border border-slate-800/80 rounded-2xl p-6 hover:border-emerald-500/40 transition-all duration-300 group flex flex-col justify-between backdrop-blur-md relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 blur-2xl rounded-full pointer-events-none group-hover:bg-emerald-500/10 transition-all"></div>
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-950/50 border border-emerald-800/30 flex items-center justify-center text-emerald-400 mb-6 group-hover:scale-110 transition-transform">
                                <i class="fas fa-redo text-lg"></i>
                            </div>
                            <h4 class="text-lg font-bold text-white font-['Orbitron'] mb-2 tracking-wide group-hover:text-emerald-400 transition-colors">
                                03 / ITERATIVE_LOOPS
                            </h4>
                            <p class="text-slate-400 text-sm leading-relaxed font-sans">
                                Optimize algorithms by eliminating repetitive tasks. Automate heavy grid data operations over huge data files using looping block constructs to mass-unlock encrypted sector records.
                            </p>
                        </div>
                        <div class="mt-8 pt-4 border-t border-slate-800/60 flex justify-between items-center text-[10px] font-mono text-slate-500">
                            <span>TOPIC: ITERATION</span>
                            <span class="text-emerald-500/60">LOCKED</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?= $this->include('partials/footer') ?>

    <script src="<?= base_url('js/partials/loading.js') ?>"></script>
    <script src="<?= base_url('js/main/index.js') ?>"></script>
    <script src="<?= base_url('js/partials/audio-manager.js') ?>"></script>
</body>

</html>