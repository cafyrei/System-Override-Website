<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/pages/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/about.css') ?>">

    <title>System Override | About</title>
</head>

<body>

    <canvas id="matrix-bg"></canvas>
    <div class="cyber-grid"></div>

    <?= $this->include('partials/navbar') ?>

    <main class="about-container">

        <!-- PROJECT OVERVIEW -->
        <section class="about-hero flex justify-center items-center flex-col px-4">


            <div class="w-320 h-120 mb-10">
                <img src="<?= base_url('images/image-placeholder.png') ?>">
            </div>
            
            <h2 class="section-title">PROJECT OVERVIEW</h2>

            <p class="section-text">
                <span class="highlight">System Override</span> is a glitch-themed arcade adventure where players
                infiltrate a futuristic computer network. Navigate data clusters, bypass firewalls,
                and survive rogue AI systems while uncovering the truth behind
                <span class="accent">A.R.C.H.O.N.</span>.
            </p>
        </section>

        <!-- MONTRIX -->
        <section class="about-hero flex justify-center items-center flex-col px-4">

            <div class="w-64 h-64">
                <img src="<?= base_url('images/montrix-logo.png') ?>">
            </div>

            <h2 class="section-title">MONTRIX</h2>

            <p class="section-text">
                <span class="highlight">MONTRIX</span> is a glitch-themed arcade adventure where players
                infiltrate a futuristic computer network. Navigate data clusters, bypass firewalls,
                and survive rogue AI systems while uncovering the truth behind
                <span class="accent">A.R.C.H.O.N.</span>.
            </p>
        </section>

        <!-- CREW -->
        <section class="crew-section px-4">
            <h2 class="section-title text-center">MEET THE CREW</h2>

            <div class="grid grid-cols-2 gap-6 justify-items-center">

                <?php
                $team = [
                    ['name' => 'Sean Paul Nieves', 'role' => 'Programmer'],
                    ['name' => 'Rafhielle Allen Alcabaza', 'role' => 'Project Manager'],
                    ['name' => 'Angelito Jose Regero', 'role' => '3D Artist'],
                    ['name' => 'Serge Edmund Barcelon', 'role' => '3D Environment Artist'],
                ];
                foreach ($team as $m):
                ?>

                    <div class="crew text-center">
                        <div class="crew-img-wrap">
                            <img src="<?= base_url('images/about/placeholder.jpg') ?>">
                        </div>
                        <p class="crew-name"><?= $m['name'] ?></p>
                        <span class="crew-role"><?= $m['role'] ?></span>
                    </div>

                <?php endforeach; ?>

            </div>
        </section>

        <!-- ADVISER -->
        <section class="highlight-section flex flex-col md:flex-row items-center text-center md:text-left px-4">

            <div class="highlight-circle mb-6 md:mb-0">
                <img src="<?= base_url('images/about/sir-tinga.jpg') ?>" alt="sir-tinga">
            </div>

            <div class="highlight-text max-w-md">
                <h3>Prof. Abricam S. Tinga</h3>
                <span>Project Adviser</span>
                <p class="text-blue-400">FEU Institute of Technology</p>

                <p class="mt-3 text-gray-400 text-sm leading-relaxed">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo natus cupiditate tenetur debitis itaque ipsam error sequi.
                </p>
            </div>
        </section>

        <!-- CLIENT -->
        <section class="highlight-section flex flex-col md:flex-row items-center text-center md:text-left px-4">

            <div class="highlight-circle mb-6 md:mb-0">
                <img src="<?= base_url('images/about/client-logo.png') ?>">
            </div>

            <div class="highlight-text max-w-md">
                <h3>ULTIMEDIA PRODUCTIONS</h3>
                <span>Industry Partner</span>
                <p class="text-gray-400 text-sm">External Entity</p>

                <p class="mt-3 text-gray-400 text-sm leading-relaxed">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo natus cupiditate tenetur debitis itaque ipsam error sequi.
                </p>
            </div>

        </section>

    </main>

</body>

</html>