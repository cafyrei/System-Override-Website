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

    <?= $this->include('partials/cyber-preloader') ?>

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

        <?php $count = 1; ?>
        <?php foreach ($patches as $patch): ?>

            <section class="grid grid-cols-12 items-center gap-16 relative group">

                <!-- Big number -->
                <div class="absolute <?= $count % 2 === 0 ? '-left-50' : '-right-50' ?> top-1/2 -translate-y-1/2 text-[300px] font-black number-badge">
                    <?= $count ?>
                </div>

                <!-- Content -->
                <div class="col-span-12 md:col-span-6 <?= $count % 2 === 0 ? 'md:order-2 md:col-start-7' : 'md:col-start-2' ?> z-20">

                    <div class="flex items-center gap-4 mb-6">
                        <span class="font-mono text-xs text-cyan-500 uppercase tracking-[0.3em]">
                            PATCH_<?= str_pad($count, 2, '0', STR_PAD_LEFT) ?>
                        </span>
                        <div class="h-px flex-1 bg-linear-to-r from-cyan-500/30 to-transparent"></div>
                    </div>

                    <h2 class="text-5xl font-bold mb-8 tracking-tight group-hover:text-cyan-400 transition-all duration-500 italic">
                        <?= esc($patch['patch_title']) ?>
                    </h2>

                    <div class="content-card p-10 relative overflow-hidden group-hover:bg-cyan-500/5 transition-all">
                        <div class="absolute top-0 left-0 w-1 h-full bg-cyan-500/40"></div>

                        <p class="text-gray-400 leading-relaxed text-md mb-6">
                            <?= esc($patch['patch_description']) ?>
                        </p>

                        <div class="flex flex-wrap gap-4 pt-6 border-t border-white/10">
                            <span class="px-3 py-1 text-[11px] bg-green-500/20 text-green-400 border border-green-500/30 uppercase tracking-wider">
                                <?= esc($patch['patch_version']) ?>
                            </span>

                            <span class="px-3 py-1 text-[11px] bg-purple-500/20 text-purple-400 border border-purple-500/30 uppercase tracking-wider">
                                <?= strtoupper($patch['patch_type']) ?>
                            </span>

                            <span class="px-3 py-1 text-[11px] bg-orange-500/20 text-orange-400 border border-orange-500/30 uppercase tracking-wider">
                                <?= date('M Y', strtotime($patch['patch_release'])) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Visual -->
                <div class="col-span-12 md:col-span-5 <?= $count % 2 === 0 ? 'md:order-1' : '' ?> z-20">
                    <div class="image-container relative">
                        <div class="overflow-hidden cyber-glow rounded-xl">

                            <!-- Optional: show file or placeholder -->
                            <div class="w-full aspect-[4/3] flex items-center justify-center border-2 border-dashed border-gray-600/50 rounded-xl">
                                <span class="text-gray-500 text-sm font-mono tracking-wider">
                                    PATCH FILE
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

            <?php $count++; ?>
        <?php endforeach; ?>

        <footer class="mt-48 pt-10 border-t border-white/5 flex flex-wrap justify-between gap-6 text-gray-600 font-mono text-[9px] tracking-[0.4em]">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                PATCH DEPLOYMENT: 2 ACTIVE
            </div>
            <span>// SYSTEM INTEGRITY: VERIFIED</span>
            <span>SYSTEM_OVERRIDE_VER_2.6</span>
        </footer>
    </main>

    <?= $this->include('partials/footer') ?>

    <script src="<?= base_url('js/partials/loading.js') ?>"></script>
</body>

</html>