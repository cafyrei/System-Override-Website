<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Slackey&display=swap" rel="stylesheet">
    <title>System Override</title>
</head>

<body>
    <nav class="p-4 h-3/4 font-slackey">
        <div class="container mx-auto flex justify-between w-full items-center">
            <a href="#" class="text-white text-lg font-bold">
                <img class="h-10 w-auto" src="<?= base_url('images/navbar-logo.png') ?>" alt="Logo">
            </a>
            <div class="space-x-4 font-normal">
                <a href="#" class="text-white hover:text-gray-300">About</a>
                <a href="#" class="text-white hover:text-gray-300">Feedback</a>
                <a href="#" class="text-white hover:text-gray-300">Home</a>
                <a href="#" class="text-white hover:text-gray-300">Gallery</a>
                <a href="#" class="text-white hover:text-gray-300">Patches</a>
            </div>
            <div class="font-normal">
                <a class="my-2 text-black bg-white py-3 px-6 rounded-full hover:bg-gray-200 hover:text-black transition duration-200" href="#">
                    Download
                </a>
            </div>
        </div>
    </nav>
</body>

</html>