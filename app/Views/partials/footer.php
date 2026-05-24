<footer class="relative z-10 border-t border-cyan-500/10 bg-black/70 backdrop-blur-md mt-32 overflow-hidden">

    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-start">

            <div>
                <h3 class="text-white font-bold uppercase tracking-widest text-sm mb-5">
                    Navigation
                </h3>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li>
                        <a href="<?= base_url('characters') ?>" class="hover:text-cyan-400 transition duration-300">
                            Characters
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('gallery') ?>" class="hover:text-cyan-400 transition duration-300">
                            Gallery
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold uppercase tracking-widest text-sm mb-5">
                    Development Team
                </h3>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li>Sean Paul Nieves</li>
                    <li>Rafhielle Allen Alcabaza</li>
                    <li>Angelito Jose Regero</li>
                    <li>Serge Edmund Barcelon</li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold uppercase tracking-widest text-sm mb-5">
                    Connect
                </h3>
                <div class="flex gap-4">
                    <a href="#" class="w-12 h-12 rounded-xl border border-cyan-500/20 flex items-center justify-center text-cyan-400 hover:bg-cyan-500/10 hover:border-cyan-400 transition duration-300">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-12 h-12 rounded-xl border border-cyan-500/20 flex items-center justify-center text-cyan-400 hover:bg-cyan-500/10 hover:border-cyan-400 transition duration-300">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="w-12 h-12 rounded-xl border border-cyan-500/20 flex items-center justify-center text-cyan-400 hover:bg-cyan-500/10 hover:border-cyan-400 transition duration-300">
                        <i class="fa-brands fa-github"></i>
                    </a>
                </div>
            </div>

        </div>
        <div class="border-t border-cyan-500/10 mt-14 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
            <p>
                &copy; <?= date('Y') ?> System Override. All Rights Reserved.
            </p>
            <p class="tracking-[0.2em] uppercase text-cyan-500/70 text-xs font-semibold">
                Powered by MONTRIX
            </p>
        </div>

    </div>
</footer>
