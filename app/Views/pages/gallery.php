<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/patches.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@300;400;700&display=swap" rel="stylesheet">
    <title>System Override | Gallery</title>
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
                System Archive // Active
            </span>
            <h1 class="text-7xl font-black mt-2 mb-6 tracking-tighter uppercase italic">
                In-game <span class="text-cyan-400" style="text-shadow: 0 0 20px rgba(0,242,255,0.3)">Scenes</span>
            </h1>
            <p class="text-gray-500 max-w-lg text-sm leading-relaxed border-t border-white/5 pt-8">
                Recovered visual data from <span class="text-gray-300 font-bold tracking-widest">SYSTEM_OVERRIDE</span> core.
                Neural fragments decrypted for public viewing.
            </p>
        </div>

        <div class="space-y-64">
            <?php foreach ($galleries as $index => $item): ?>
                <?php $even = $index % 2 === 1; ?>
                <section class="grid grid-cols-12 items-center gap-16 relative group">

                    <div class="absolute <?= $even ? '-left-50' : '-right-50' ?> top-1/2 -translate-y-1/2 text-[300px] font-black number-badge">
                        <?= $index + 1 ?>
                    </div>

                    <div class="col-span-12 md:col-span-6 <?= $even ? 'md:order-2 md:col-start-7' : 'md:col-start-2' ?> z-20">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="font-mono text-xs text-cyan-500 uppercase tracking-[0.3em]">Entry_0<?= $index + 1 ?></span>
                            <div class="h-px flex-1 bg-linear-to-r <?= $even ? 'from-transparent to-cyan-500/30' : 'from-cyan-500/30 to-transparent' ?>"></div>
                        </div>

                        <h2 class="text-5xl font-bold mb-8 tracking-tight group-hover:text-cyan-400 transition-all duration-500 italic">
                            <?= esc($item['gallery_title']) ?>
                        </h2>

                        <div class="content-card p-10 relative overflow-hidden group-hover:bg-cyan-500/5 transition-all">
                            <div class="absolute top-0 left-0 w-1 h-full bg-cyan-500/40"></div>
                            <p class="text-gray-400 leading-relaxed text-md">"<?= esc($item['gallery_description']) ?>"</p>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-5 <?= $even ? 'md:order-1' : '' ?> z-20">
                        <div class="image-container group">
                            <div class="overflow-hidden cyber-glow">
                                <img src="<?= base_url($item['image_path']) ?>"
                                    alt="<?= esc($item['gallery_title']) ?>"
                                    class="w-full aspect-[4/3] object-cover grayscale-[40%] group-hover:grayscale-0 transition-all duration-1000 scale-110 group-hover:scale-100"
                                    loading="lazy">
                            </div>
                            <div class="absolute -top-2 -left-2 w-6 h-6 border-t-2 border-l-2 border-cyan-500"></div>
                            <div class="absolute -bottom-2 -right-2 w-6 h-6 border-b-2 border-r-2 border-cyan-500"></div>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>

        <footer class="mt-48 pt-10 border-t border-white/5 flex flex-wrap justify-between gap-6 text-gray-600 font-mono text-[9px] tracking-[0.4em]">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                SIGNAL STRENGTH: OPTIMAL
            </div>
            <span>// <?= count($galleries) ?> FRAGMENTS SYNCED</span>
            <span>SYSTEM_OVERRIDE_VER_2.6</span>
        </footer>
    </main>


    <?= $this->include('partials/footer') ?>

    <script src="<?= base_url('js/partials/loading.js') ?>"></script>
    <script src="<?= base_url('js/main/gallery.js') ?>"></script>
</body>

</html>