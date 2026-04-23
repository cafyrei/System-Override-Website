<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/partials/navbar.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Slackey&family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <title>System Override</title>
</head>

<body class="relative overflow-x-hidden">
    
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            
            <!-- Logo -->
            <a href="<?= base_url('/') ?>" class="navbar-logo">
                <img class="h-12 w-auto transition-all duration-300" src="<?= base_url('images/navbar-logo.png') ?>" alt="System Override">
            </a>

            <!-- Desktop Links -->
            <div class="hidden md:flex items-center space-x-2">
                <a href="<?= base_url('/patches') ?>" class="nav-link">Patches</a>
                <a href="<?= base_url('/gallery') ?>" class="nav-link">Gallery</a>
                <a href="<?= base_url('/') ?>" class="nav-link">Home</a>
                <a href="<?= base_url('/feedback') ?>" class="nav-link">Feedback</a>
                <a href="#" class="nav-link">About</a>
            </div>

            <!-- Download Button -->
            <a href="#" class="download-btn px-8 py-3 rounded-full text-sm font-bold shadow-lg">
                Download Now
            </a>

            <button class="md:hidden text-white p-2 rounded-lg hover:bg-white/10 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </nav>
    <div class="h-20 md:h-24"></div>

    <script src="<?= base_url('js/partials/navbar.js') ?>"  ></script>
</body>
</html>