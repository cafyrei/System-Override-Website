# Refined About Page (CodeIgniter + Tailwind)

```php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= base_url('Override.png'); ?>" sizes="32x32">
    <title>System Override | About</title>

    <!-- Tailwind Output -->
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Global Styles -->
    <link rel="stylesheet" href="<?= base_url('css/pages/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/about.css') ?>">
</head>

<body class="relative overflow-x-hidden bg-black text-white" data-audio="<?= base_url('./audio/override-sfx-starlight-horizon.mp3') ?>">

    <!-- Background Effects -->
    <canvas id="matrix-bg"></canvas>
    <div class="cyber-grid"></div>

    <!-- Navbar -->
    <?= $this->include('partials/navbar') ?>

    <?= $this->include('partials/cyber-preloader') ?>

    <?php

    $aboutSections = [
        [
            'title' => 'PROJECT OVERVIEW',
            'image' => 'images/image-placeholder.png',
            'alt' => 'System Override Overview',
            'content' => 'System Override is a glitch-themed arcade adventure where players infiltrate a futuristic computer network. Navigate dangerous data clusters, bypass firewalls, and survive rogue AI systems while uncovering the truth behind A.R.C.H.O.N.'
        ],
        [
            'title' => 'MONTRIX',
            'image' => 'images/montrix-logo.png',
            'alt' => 'Montrix Logo',
            'content' => 'MONTRIX serves as the central digital ecosystem within System Override, representing the unstable network infrastructure corrupted by rogue artificial intelligence and system anomalies.'
        ]
    ];

    $team = [
        [
            'name' => 'Sean Paul Nieves',
            'role' => 'Programmer',
            'image' => 'images/about/placeholder.jpg'
        ],
        [
            'name' => 'Rafhielle Allen Alcabaza',
            'role' => 'Project Manager',
            'image' => 'images/about/placeholder.jpg'
        ],
        [
            'name' => 'Angelito Jose Regero',
            'role' => '3D Artist',
            'image' => 'images/about/placeholder.jpg'
        ],
        [
            'name' => 'Serge Edmund Barcelon',
            'role' => '3D Environment Artist',
            'image' => 'images/about/placeholder.jpg'
        ]
    ];

    $highlights = [
        [
            'title' => 'Prof. Abricam S. Tinga',
            'subtitle' => 'Project Adviser',
            'organization' => 'FEU Institute of Technology',
            'description' => 'Guided the development and direction of the System Override project through technical consultation, research support, and project evaluation.',
            'image' => 'images/about/sir-tinga.jpg',
            'alt' => 'Professor Abricam S. Tinga',
            'reverse' => false
        ],
        [
            'title' => 'ULTIMEDIA PRODUCTIONS',
            'subtitle' => 'Industry Partner',
            'organization' => 'External Entity',
            'description' => 'Supported the project through industry insights, collaboration opportunities, and external evaluation of the game concept and presentation.',
            'image' => 'images/about/client-logo.png',
            'alt' => 'Ultimedia Productions Logo',
            'reverse' => true
        ]
    ];

    ?>

    <main class="relative z-10">

        <!-- HERO / OVERVIEW SECTIONS -->
        <?php foreach ($aboutSections as $section): ?>

            <section class="min-h-[75vh] lg:min-h-screen flex flex-col items-center justify-center px-6 py-12 text-center max-w-5xl mx-auto">

                <header>
                    <h2 class="section-title text-3xl md:text-5xl font-black tracking-widest mb-4 text-cyan-400">
                        <?= $section['title'] ?>
                    </h2>
                </header>

                <div class="w-full max-w-sm aspect-video sm:aspect-[2/1] md:max-w-md md:h-32 mb-8 shrink-0 overflow-hidden">
                    <img
                        class="w-full h-full object-cover rounded-3xl border border-cyan-500/20 shadow-[0_0_30px_rgba(0,255,255,0.12)]"
                        src="<?= base_url($section['image']) ?>"
                        alt="<?= $section['alt'] ?>"
                        loading="lazy">
                </div>

                <p class="section-text max-w-2xl text-gray-300 leading-relaxed text-sm md:text-base">
                    <?= $section['content'] ?>
                </p>

            </section>

        <?php endforeach; ?>


        <!-- CREW SECTION -->
        <section class="px-6 py-24">

            <header class="text-center mb-16">
                <h2 class="section-title text-3xl md:text-5xl font-black tracking-widest text-cyan-400">
                    MEET THE CREW
                </h2>
            </header>

            <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

                <?php foreach ($team as $member): ?>

                    <article class="crew-card group bg-white/5 border border-cyan-500/10 rounded-3xl overflow-hidden backdrop-blur-md transition duration-300 hover:-translate-y-2 hover:border-cyan-400/40 hover:shadow-[0_0_30px_rgba(0,255,255,0.15)]">

                        <div class="aspect-square overflow-hidden">
                            <img
                                class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                                src="<?= base_url($member['image']) ?>"
                                alt="<?= $member['name'] ?>"
                                loading="lazy">
                        </div>

                        <div class="p-6 text-center">
                            <h3 class="text-lg font-bold text-white mb-2">
                                <?= $member['name'] ?>
                            </h3>

                            <p class="text-cyan-400 text-sm uppercase tracking-wider">
                                <?= $member['role'] ?>
                            </p>
                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        </section>


        <!-- HIGHLIGHT SECTIONS -->
        <?php foreach ($highlights as $highlight): ?>

            <section class="px-6 py-24">

                <div class="max-w-6xl mx-auto flex flex-col <?= $highlight['reverse'] ? 'lg:flex-row-reverse' : 'lg:flex-row' ?> items-center gap-12">

                    <!-- IMAGE -->
                    <div class="w-64 h-64 md:w-80 md:h-80 rounded-full overflow-hidden border border-cyan-500/20 shadow-[0_0_40px_rgba(0,255,255,0.12)] flex-shrink-0">
                        <img
                            class="w-full h-full object-cover"
                            src="<?= base_url($highlight['image']) ?>"
                            alt="<?= $highlight['alt'] ?>"
                            loading="lazy">
                    </div>

                    <!-- TEXT -->
                    <div class="max-w-2xl text-center lg:text-left">

                        <h2 class="text-3xl md:text-4xl font-black text-white mb-3">
                            <?= $highlight['title'] ?>
                        </h2>

                        <p class="text-cyan-400 uppercase tracking-[0.2em] text-sm mb-2">
                            <?= $highlight['subtitle'] ?>
                        </p>

                        <p class="text-gray-400 mb-6">
                            <?= $highlight['organization'] ?>
                        </p>

                        <p class="text-gray-300 leading-8 text-base md:text-lg">
                            <?= $highlight['description'] ?>
                        </p>

                    </div>

                </div>

            </section>

        <?php endforeach; ?>

    </main>



    <?= $this->include('partials/footer') ?>

    <script src="<?= base_url('js/partials/loading.js') ?>"></script>
    <script src="<?= base_url('js/partials/audio-manager.js') ?>"></script>

</body>

</html>