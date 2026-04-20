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
    <title>System Override | Feedback</title>
</head>

<body>

    <!-- Background Layer -->
    <div
        class="absolute inset-0 -z-10 bg-cover bg-center bg-no-repeat brightness-75"
        style="background-image: url('<?= base_url('images/backgrounds/m-background.png') ?>');">
    </div>

    <!-- Content Container -->
    <div class="font-slackey text-white">
        <?= $this->include('partials/navbar') ?>

        <div class="wrapper mt-12">
            <div class="container flex mx-auto px-2 py-8 justify-center items-center flex-col">
                <h1 class="text-5xl mb-4 ">Feedback & Suggestions</h1>
                <p class="font-athiti font-semibold">Shape the System Override experience by sharing your thoughts and ideas!</p>

                <h2 class="mt-8">Send us your Ideas, Suggestions, and Feedback</h2>

                <form action="#" class="w-full ">

                    <div class="w-full max-w-md mx-auto mt-6">
                        <select class="w-full h-full border outline-none rounded-md px-4 py-2 text-sm text-[#525252] bg-white">
                            <option>Select</option>
                            <option>Suggestions</option>
                            <option>Bug Reports</option>
                        </select>
                    </div>

                    <div class="w-full max-w-md mx-auto">
                        <input placeholder="Your Name" type="text" id="name" name="name" class="mt-6 block w-full rounded-md text-[#525252]
                         bg-white border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-4 py-2 font-athiti font-normal placeholder:font-slackey">
                    </div>

                    <div class="w-full max-w-md mx-auto">
                        <input placeholder="Your Email" type="email" id="email" name="email" class="mt-6 block w-full rounded-md text-[#525252]
                         bg-white border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-4 py-2 font-athiti font-normal placeholder:font-slackey">
                    </div>

                    <div class="w-full max-w-md mx-auto">
                        <textarea placeholder="Your Message" id="message" name="message" rows="4"
                            class="mt-6 block w-full rounded-md text-[#525252] bg-white px-4 py-2 font-athiti font-normal placeholder:font-slackey"></textarea>
                    </div>

                    <div class="w-full max-w-lg mx-auto mt-4">

                        <label class="flex items-start gap-3 text-sm text-gray-600">
                            <input type="checkbox" class="mt-1 rounded  border-gray-300 text-indigo-600 focus:ring-indigo-500">

                            <span class="text-white">
                                I agree to the
                                <a href="#" class="text-indigo-600 hover:underline">Terms and Conditions</a>
                                and
                                <a href="#" class="text-indigo-600 hover:underline">Privacy Policy</a>.
                            </span>
                        </label>

                    </div>

                    <button
                        type="submit"
                        class="block mx-auto bg-cyan-600/70 font-normal shadow-sm hover:bg-cyan-600 text-white py-2 px-12 rounded mt-6 text-center">
                        Submit Feedback
                    </button>
                </form>

            </div>
        </div>
    </div>

</body>

</html>