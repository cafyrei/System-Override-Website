<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/patches.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@300;400;700&display=swap" rel="stylesheet">
    <title>System Override | Patches</title>
</head>

<body class="text-white">
    <div class="stars"></div>
    <canvas id="matrix-bg"></canvas>
    <div class="cyber-grid"></div>
    <div class="dust-field" id="dust-container" style="position:fixed; inset:0; z-index:4; pointer-events:none;"></div>

    <?= $this->include('partials/navbar') ?>

    <main class="relative z-10 max-w-7xl mx-auto px-6 py-20">
        <div class="relative border-l-4 border-cyan-500 pl-10 mb-40">
            <span class="inline-block px-3 py-1 mb-4 text-[10px] bg-cyan-500/10 text-cyan-400 border border-cyan-500/30 uppercase tracking-[0.4em]">
                Patch Network // Deployed
            </span>
            <h1 class="text-7xl font-black mt-2 mb-6 tracking-tighter uppercase italic">
                Core <span class="text-cyan-400" style="text-shadow: 0 0 20px rgba(0,242,255,0.3)">Patches</span>
            </h1>
            <p class="text-gray-500 max-w-lg text-sm leading-relaxed border-t border-white/5 pt-8">
                Deployed system modifications from <span class="text-gray-300 font-bold tracking-widest">SYSTEM_OVERRIDE</span> core.
                Patch manifests decrypted and verified.
            </p>
        </div>

        <div class="space-y-64">
            <!-- PATCH 1 -->
            <section class="grid grid-cols-12 items-center gap-16 relative group">
                <div class="absolute -right-50 top-1/2 -translate-y-1/2 text-[300px] font-black number-badge">1</div>

                <div class="col-span-12 md:col-span-6 md:col-start-2 z-20">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="font-mono text-xs text-cyan-500 uppercase tracking-[0.3em]">PATCH_01</span>
                        <div class="h-px flex-1 bg-linear-to-r from-cyan-500/30 to-transparent"></div>
                    </div>

                    <h2 class="text-5xl font-bold mb-8 tracking-tight group-hover:text-cyan-400 transition-all duration-500 italic">
                        Neural Network Optimization
                    </h2>

                    <div class="content-card p-10 relative overflow-hidden group-hover:bg-cyan-500/5 transition-all">
                        <div class="absolute top-0 left-0 w-1 h-full bg-cyan-500/40"></div>
                        <p class="text-gray-400 leading-relaxed text-md mb-6">Enhanced neural pathway processing with 247% efficiency gain. Quantum entanglement stabilized for multi-core operations.</p>
                        
                        <div class="flex flex-wrap gap-4 pt-6 border-t border-white/10">
                            <span class="px-3 py-1 text-[11px] bg-green-500/20 text-green-400 border border-green-500/30 uppercase tracking-wider">v2.1.3</span>
                            <span class="px-3 py-1 text-[11px] bg-purple-500/20 text-purple-400 border border-purple-500/30 uppercase tracking-wider">PERFORMANCE</span>
                            <span class="px-3 py-1 text-[11px] bg-orange-500/20 text-orange-400 border border-orange-500/30 uppercase tracking-wider">JAN 2024</span>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-5 z-20">
                    <div class="image-container group relative">
                        <div class="overflow-hidden cyber-glow rounded-xl">
                            <div class="w-full aspect-[4/3] bg-gradient-to-br from-gray-900/80 to-gray-800/80 flex items-center justify-center border-2 border-dashed border-gray-600/50 rounded-xl">
                                <div class="text-center">
                                    <div class="w-16 h-16 border-2 border-cyan-500/50 border-t-cyan-500 rounded-full animate-spin mx-auto mb-4"></div>
                                    <span class="text-gray-500 text-sm font-mono tracking-wider">PATCH VISUAL</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 pointer-events-none"></div>
                        
                        <div class="absolute -top-2 -left-2 w-6 h-6 border-t-2 border-l-2 border-cyan-500"></div>
                        <div class="absolute -bottom-2 -right-2 w-6 h-6 border-b-2 border-r-2 border-cyan-500"></div>
                        
                    </div>
                </div>
            </section>

            <!-- PATCH 2 -->
            <section class="grid grid-cols-12 items-center gap-16 relative group">
                <div class="absolute -left-50 top-1/2 -translate-y-1/2 text-[300px] font-black number-badge">2</div>

                <div class="col-span-12 md:col-span-6 md:order-2 md:col-start-7 z-20">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="font-mono text-xs text-cyan-500 uppercase tracking-[0.3em]">PATCH_02</span>
                        <div class="h-px flex-1 bg-linear-to-r from-transparent to-cyan-500/30"></div>
                    </div>

                    <h2 class="text-5xl font-bold mb-8 tracking-tight group-hover:text-cyan-400 transition-all duration-500 italic">
                        Security Matrix Upgrade
                    </h2>

                    <div class="content-card p-10 relative overflow-hidden group-hover:bg-cyan-500/5 transition-all">
                        <div class="absolute top-0 left-0 w-1 h-full bg-cyan-500/40"></div>
                        <p class="text-gray-400 leading-relaxed text-md mb-6">Quantum encryption protocols hardened against temporal incursions. Firewall integrity increased to 99.999%.</p>
                        
                        <div class="flex flex-wrap gap-4 pt-6 border-t border-white/10">
                            <span class="px-3 py-1 text-[11px] bg-green-500/20 text-green-400 border border-green-500/30 uppercase tracking-wider">v1.9.8</span>
                            <span class="px-3 py-1 text-[11px] bg-purple-500/20 text-purple-400 border border-purple-500/30 uppercase tracking-wider">SECURITY</span>
                            <span class="px-3 py-1 text-[11px] bg-orange-500/20 text-orange-400 border border-orange-500/30 uppercase tracking-wider">DEC 2023</span>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-5 md:order-1 z-20">
                    <div class="image-container group relative">
                        <div class="overflow-hidden cyber-glow rounded-xl">
                            <div class="w-full aspect-[4/3] bg-gradient-to-br from-emerald-900/70 to-emerald-800/70 flex items-center justify-center border-2 border-dashed border-emerald-600/50 rounded-xl">
                                <div class="text-center">
                                    <div class="w-16 h-16 border-2 border-emerald-500/50 border-t-emerald-500 rounded-full animate-spin mx-auto mb-4"></div>
                                    <span class="text-emerald-400 text-sm font-mono tracking-wider">SECURE</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 pointer-events-none"></div>
                        
                        <div class="absolute -top-2 -left-2 w-6 h-6 border-t-2 border-l-2 border-cyan-500"></div>
                        <div class="absolute -bottom-2 -right-2 w-6 h-6 border-b-2 border-r-2 border-cyan-500"></div>
                        
                    </div>
                </div>
            </section>
        </div>

        <footer class="mt-48 pt-10 border-t border-white/5 flex flex-wrap justify-between gap-6 text-gray-600 font-mono text-[9px] tracking-[0.4em]">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                PATCH DEPLOYMENT: 2 ACTIVE
            </div>
            <span>// SYSTEM INTEGRITY: VERIFIED</span>
            <span>SYSTEM_OVERRIDE_VER_2.6</span>
        </footer>
    </main>

</body>

</html>