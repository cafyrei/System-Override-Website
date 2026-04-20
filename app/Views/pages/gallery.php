<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">
    <title>System Override | Gallery</title>
</head>

<body>
    <div
        class="absolute inset-0 -z-10 bg-cover bg-center bg-no-repeat brightness-75"
        style="background-image: url('<?= base_url('images/backgrounds/skybackground.png') ?>');">
    </div>

    <?= $this->include('partials/navbar') ?>

    <main class="relative z-10 font-athiti text-xl text-white flex flex-col items-center justify-center">

        <h1 class="text-4xl font-slackey text-white">
            Gallery & In-game Scene
        </h1>

        <?php foreach ($galleries as $index => $item): ?>

            <div class="w-full max-w-screen-2xl mt-8 flex items-center justify-between gap-12 rounded-lg p-6 font-slackey <?= $index % 2 === 1 ? 'flex-row-reverse' : '' ?>">

                <img
                    class="w-112.5 aspect-3/2 object-cover rounded-lg"
                    src="<?= base_url($item['image']) ?>"
                    alt="Gallery Image">

                <div class="flex-1">
                    <h2 class="text-4xl mb-2"><?= $item['title'] ?></h2>
                    <p class="text-white text-base">
                        <?= $item['description'] ?>
                </div>
            </div>

        <?php endforeach; ?>

    </main>
</body>

</html>