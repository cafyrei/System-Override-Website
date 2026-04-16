<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Slackey&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Athiti:wght@200;300;400;500;600;700&family=Black+Han+Sans&family=Slackey&display=swap" rel="stylesheet">
    <title>System Override</title>
</head>

<body class="relative min-h-screen">

    <!-- Background Layer -->
    <div
        class="absolute inset-0 -z-10 bg-cover bg-center bg-no-repeat brightness-75"
        style="background-image: url('<?= base_url('images/backgrounds/m-background.png') ?>');">
    </div>

    <!-- Content Layer -->

    <div class="relative z-10 font-athiti text-xl text-white min-h-screen flex flex-col">

    <?= $this->include('partials/navbar') ?>

    <div class="div">
        <?php for($i = 0; $i < 15; $i++) { ?>
            <p>Item <?= $i ?></p>
        <?php } ?>
    </div>

    <div class="container mt-auto flex w-full justify-between items-center mx-auto px-6 pb-16">

        <!-- LEFT -->
        <div class="w-1/2 flex flex-col">
            <h1 class="text-5xl font-black-han-sans">Initializing System</h1>
            <h2 class="text-4xl font-black-han-sans">Entering: Overdrive</h2>

            <p class="mb-4 font-semibold max-w-lg">
                A puzzle-driven game where you redesign the systems that govern a city
            </p>

            <div class="flex w-[60%] gap-4 mb-4 font-slackey">
                <button class="w-1/2 border-4 border-[#4CF8FE] px-4 py-2 rounded-lg bg-blue-500/20 hover:bg-blue-500/40 transition">
                    Play Demo
                </button>

                <button class="w-1/2 border-4 border-white px-4 py-2 rounded-lg bg-white/20 hover:bg-white/40 transition">
                    Watch Trailer
                </button>
            </div>

            <p class="font-semibold">Developed as an academic game project</p>
        </div>

        <!-- RIGHT -->
        <div class="w-1/2 flex justify-end">
            <img class="w-full max-w-md h-auto object-contain"
                src="<?= base_url('images/main-logo.png') ?>" />
        </div>

    </div>
</div>

</body>

</html>