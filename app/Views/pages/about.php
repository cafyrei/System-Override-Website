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
            'content' => 'Montrix is an independent game production group dedicated to bridging the gap between immersive 3D gameplay and interactive education. System Override represents our Capstone project, crafted from the ground up to turn logical programming fundamentals into an engaging, high-energy gaming experience'
        ]
    ];

    $team = [
        [
            'name' => 'Sean Paul Nieves',
            'role' => 'Assistant Manager',

            'image' => 'images/about/nieves_seanpaul.jpg',
            'hoverImage' => 'images/about/nieves_hover.jpg',

            'details' => [
                'Implemented puzzle mechanics',
                'Main Game Frontend Developer',
                'Sub Game Backend Developer',
                'Designed gameplay concepts',
                'Handled game visuals 3D/2D',
                'Main 3D Modeler'
            ],

            'bio' => 'Focused on programming the systems and mechanics that power the System Override experience.'
        ],

        [
            'name' => 'Rafhielle Allen Alcabaza',
            'role' => 'Project Manager',

            'image' => 'images/about/alcabaza_rafhielleallen.jpg',
            'hoverImage' => 'images/about/alcabaza_hover.jpg',

            'details' => [
                'Managed project development',
                'Web Developer',
                'Sub Game Frontend Developer',
                'Main Game Backend Developer',
                'Designed gameplay concepts',
                'Developed game puzzle mechanics',
                'Prepared documentation and reports',
                '2D Visuals UI Concept'
            ],

            'bio' => 'Led the overall development process and ensured the successful completion of the System Override project.'
        ],

        [
            'name' => 'Angelito Jose Regero',
            'role' => '2D Artist',

            'image' => 'images/about/regero.jpg',
            'hoverImage' => 'images/about/regero_hover.jpg',

            'details' => [
                'Game Cutscenes',
            ],

            'bio' => 'Responsible for creating Cutscenes throughout the game.'
        ],

        [
            'name' => 'Serge Edmund Barcelon',
            'role' => '3D Environment Artist',

            'image' => 'images/about/barcelon.jpg',
            'hoverImage' => 'images/about/barcelon_serge_Hover.jpg',

            'details' => [
                'Designed game environments',
            ],

            'bio' => 'Focused on building the digital environments and atmosphere of System Override.'
        ]
    ];

    $highlights = [
        [
            'title' => 'Abricam S. Tinga, MSIT',
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

            <section class="flex flex-col items-center px-6 py-16 md:py-12 text-center max-w-5xl mx-auto">

                <header>
                    <h2 class="section-title text-3xl md:text-5xl font-black tracking-widest mb-4 text-cyan-400">
                        <?= $section['title'] ?>
                    </h2>
                </header>

                <div class="w-full max-w-xl aspect-video mb-8 shrink-0 overflow-hidden">
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

                <?php foreach ($team as $index => $member): ?>

                    <article
                        class="crew-card group cursor-pointer bg-white/5 border border-cyan-500/10 rounded-3xl overflow-hidden backdrop-blur-md transition duration-300 hover:-translate-y-2 hover:border-cyan-400/40 hover:shadow-[0_0_30px_rgba(0,255,255,0.15)]"
                        onclick="openProfile(<?= $index ?>)">

                        <div class="relative aspect-square overflow-hidden">

                            <!-- Default Image -->
                            <img
                                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 group-hover:opacity-0"
                                src="<?= base_url($member['image']) ?>"
                                alt="<?= $member['name'] ?>">

                            <!-- Hover Image -->
                            <img
                                class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                                src="<?= base_url($member['hoverImage']) ?>"
                                alt="<?= $member['name'] ?>">

                        </div>

                        <div class="p-6 text-center">

                            <h3 class="text-lg font-bold text-white">
                                <?= $member['name'] ?>
                            </h3>

                            <p class="text-cyan-400 uppercase text-sm tracking-wider">
                                <?= $member['role'] ?>
                            </p>

                            <p class="mt-3 text-xs text-cyan-300 opacity-0 group-hover:opacity-100 transition">
                                [ CLICK TO VIEW DOSSIER ]
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
                    <div class="w-64 h-64 md:w-80 md:h-80 rounded-full overflow-hidden border border-cyan-500/20 shadow-[0_0_40px_rgba(0,255,255,0.12)] shrink-0">
                        <img
                            class="w-full h-full object-cover"
                            src="<?= base_url($highlight['image']) ?>"
                            alt="<?= $highlight['alt'] ?>"
                            loading="lazy">
                    </div>

                    <!-- TEXT -->
                    <div class="max-w-2xl text-center lg:text-left">

                        <h2 class="text-3xl md:text-4xl font-white text-white mb-3">
                            <?= $highlight['title'] ?>
                        </h2>

                        <p class="text-white uppercase tracking-[0.2em] text-sm mb-2">
                            <?= $highlight['subtitle'] ?>
                        </p>

                        <p class="text-white mb-6">
                            <?= $highlight['organization'] ?>
                        </p>

                        <p class="text-white leading-8 text-base md:text-lg">
                            <?= $highlight['description'] ?>
                        </p>

                    </div>

                </div>

            </section>

        <?php endforeach; ?>

        <div
            id="profileModal"
            class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 backdrop-blur-md p-6">

            <div class="bg-zinc-900 border border-cyan-500 rounded-3xl p-8 max-w-2xl w-full">

                <h2 id="modalName" class="text-3xl font-black text-cyan-400 mb-2"></h2>

                <p id="modalRole" class="uppercase tracking-widest text-gray-400 mb-6"></p>

                <p id="modalBio" class="text-gray-300 mb-6"></p>

                <h3 class="text-cyan-400 font-bold mb-3">
                    CONTRIBUTIONS
                </h3>

                <ul id="modalDetails" class="space-y-2 text-gray-300"></ul>

                <button
                    onclick="closeProfile()"
                    class="mt-8 px-6 py-3 border border-cyan-500 rounded-xl hover:bg-cyan-500 hover:text-black transition cursor-pointer">
                    CLOSE DOSSIER
                </button>

            </div>

        </div>

    </main>



    <?= $this->include('partials/footer') ?>

    <script src="<?= base_url('js/partials/loading.js') ?>"></script>
    <script src="<?= base_url('js/partials/audio-manager.js') ?>"></script>
    <script>
        const teamProfiles = <?= json_encode($team) ?>;
    </script>

    <script>
        function openProfile(index) {
            const profile = teamProfiles[index];

            document.getElementById('modalName').textContent =
                profile.name;

            document.getElementById('modalRole').textContent =
                profile.role;

            document.getElementById('modalBio').textContent =
                profile.bio;

            const detailsList =
                document.getElementById('modalDetails');

            detailsList.innerHTML = '';

            profile.details.forEach(detail => {
                detailsList.innerHTML += `
            <li>> ${detail}</li>
        `;
            });

            document.getElementById('profileModal')
                .classList.remove('hidden');

            document.getElementById('profileModal')
                .classList.add('flex');
        }

        function closeProfile() {
            document.getElementById('profileModal')
                .classList.add('hidden');

            document.getElementById('profileModal')
                .classList.remove('flex');
        }
    </script>

</body>

</html>