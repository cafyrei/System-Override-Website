<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Slackey&family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/pages/index.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/global.css') ?>">
    <style>
        .home-page {
            background:
                linear-gradient(rgba(3, 4, 6, 0.88), rgba(3, 4, 6, 0.60)),
                url('<?= base_url("images/backgrounds/m-background.png") ?>') top / cover no-repeat fixed;
        }

        body:has(#cyber-preloader:not(.opacity-0)) {
            overflow: hidden !important;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
    <title>System Override | Learn Core</title>
</head>

<body class="home-page min-h-screen flex flex-col justify-between">

    <canvas id="matrix-bg"></canvas>
    <div class="cyber-grid"></div>
    <div id="dust-container" style="position:fixed; inset:0; z-index:3; pointer-events:none;"></div>

    <?= $this->include('partials/navbar') ?>

    <?= $this->include('partials/cyber-preloader') ?>

    <main class="relative z-10 py-20 px-6 md:px-24 flex-grow">
        <div class="container mx-auto max-w-6xl">

            <div class="mb-16 border-b border-cyan-500/20 pb-10">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_10px_#10b981]"></span>
                    <span class="text-[10px] font-mono tracking-[0.4em] text-emerald-400">CURRICULUM::COMP_PROG_1</span>
                </div>

                <h1 class="text-4xl md:text-6xl font-black text-white font-mono tracking-tight mb-4">
                    LOGIC_<span class="text-emerald-400">FOUNDATIONS</span>
                </h1>
                <p class="text-gray-400 text-lg max-w-3xl border-l-2 border-emerald-500/30 pl-6 leading-relaxed">
                    Welcome to the Neural Core training module. To hack into Nova Axiom's networks, you must first master the 4 foundational pillars of basic computer programming logic.
                </p>
            </div>

            <div class="border border-emerald-500/20 bg-black/60 rounded-xl overflow-hidden backdrop-blur-md shadow-[0_0_30px_rgba(16,185,129,0.05)]">

                <div class="bg-white/5 border-b border-white/10 px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500/50"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500/50"></div>
                        <div class="w-3 h-3 rounded-full bg-emerald-500/50"></div>
                        <span class="text-xs font-mono text-gray-400 ml-2">PROGRAMMING_BASICS_101.py</span>
                    </div>
                    <span class="text-xs font-mono text-emerald-400/60 bg-emerald-500/10 px-2 py-0.5 rounded">STATUS: LEVEL_01</span>
                </div>

                <div class="p-6 md:p-10 space-y-16">

                    <div class="grid md:grid-cols-2 gap-8 items-start">
                        <div>
                            <div class="text-xs font-mono text-emerald-400 mb-2">[WEEK_01-04::VARIABLES_&_IO]</div>
                            <h4 class="text-white font-bold text-xl mb-3 font-mono">1. Inputs, Outputs, & Data Types</h4>
                            <p class="text-gray-400 text-sm leading-relaxed mb-4">
                                Programs need to accept user data (`input()`) and display information back to the screen (`print()`). Variables act as labeled containers that hold specific types of data, such as whole numbers (Integers), decimals (Floats), or text (Strings).
                            </p>
                            <div class="text-xs text-gray-500 font-mono bg-white/5 p-3 rounded border border-white/5">
                                <span class="text-emerald-400 font-bold">Game Blueprint:</span> Entering your player name or storing the current level number.
                            </div>
                        </div>
                        <div class="bg-black/40 border border-white/5 rounded-lg p-5 font-mono text-xs text-gray-300 leading-relaxed">
                            <span class="text-gray-500"># Storing Data (Variables)</span><br>
                            player_name = <span class="text-amber-300">"Hacker_Nova"</span> <span class="text-gray-500"># String (Text)</span><br>
                            current_score = <span class="text-cyan-400">0</span> <span class="text-gray-500"># Integer (Whole Number)</span><br>
                            battery_power = <span class="text-emerald-400">98.5</span> <span class="text-gray-500"># Float (Decimal)</span><br><br>

                            <span class="text-gray-500"># Outputting to Terminal</span><br>
                            <span class="text-cyan-400">print</span>(<span class="text-amber-300">"System Booted Successfully!"</span>)
                        </div>
                    </div>

                    <div class="border-t border-white/5"></div>

                    <div class="grid md:grid-cols-2 gap-8 items-start">
                        <div>
                            <div class="text-xs font-mono text-emerald-400 mb-2">[WEEK_05-07::ARITHMETIC_OPERATORS]</div>
                            <h4 class="text-white font-bold text-xl mb-3 font-mono">2. Arithmetic & Expressions</h4>
                            <p class="text-gray-400 text-sm leading-relaxed mb-4">
                                Computers perform mathematical operations using standard symbols: add (`+`), subtract (`-`), multiply (`*`), divide (`/`), and remainder (`%` or Modulo). Modulo is highly useful for checking things like even/odd cycles.
                            </p>
                            <div class="text-xs text-gray-500 font-mono bg-white/5 p-3 rounded border border-white/5">
                                <span class="text-emerald-400 font-bold">Game Blueprint:</span> Calculating remaining energy after passing through an encryption firewall.
                            </div>
                        </div>
                        <div class="bg-black/40 border border-white/5 rounded-lg p-5 font-mono text-xs text-gray-300 leading-relaxed">
                            <span class="text-gray-500"># Mathematical Calculations</span><br>
                            initial_energy = <span class="text-cyan-400">100</span><br>
                            firewall_drain = <span class="text-cyan-400">15</span> * <span class="text-cyan-400">2</span> <span class="text-gray-500"># Multiplication</span><br><br>

                            remaining_energy = initial_energy - firewall_drain<br>
                            <span class="text-cyan-400">print</span>(remaining_energy)<br>
                            <span class="text-gray-500"># Output: 70</span>
                        </div>
                    </div>

                    <div class="border-t border-white/5"></div>

                    <div class="grid md:grid-cols-2 gap-8 items-start">
                        <div>
                            <div class="text-xs font-mono text-emerald-400 mb-2">[WEEK_08-12::CONDITIONAL_STRUCTURES]</div>
                            <h4 class="text-white font-bold text-xl mb-3 font-mono">3. Decision Making (If / Else)</h4>
                            <p class="text-gray-400 text-sm leading-relaxed mb-4">
                                Conditional structures allow your program to make choices. By checking if a statement is true or false using <code class="text-emerald-300 bg-white/5 px-1 rounded">if</code>, <code class="text-emerald-300 bg-white/5 px-1 rounded">elif</code> (else if), and <code class="text-emerald-300 bg-white/5 px-1 rounded">else</code>, you control which block of code runs.
                            </p>
                            <div class="text-xs text-gray-500 font-mono bg-white/5 p-3 rounded border border-white/5">
                                <span class="text-emerald-400 font-bold">Game Blueprint:</span> Determining if a player has the correct passcode to open a network gate.
                            </div>
                        </div>
                        <div class="bg-black/40 border border-white/5 rounded-lg p-5 font-mono text-xs text-gray-300 leading-relaxed">
                            <span class="text-gray-500"># Evaluating Security Access</span><br>
                            entered_passcode = <span class="text-amber-300">"1234"</span><br><br>

                            <span class="text-purple-400">if</span> entered_passcode == <span class="text-amber-300">"ADMIN_CORE_99"</span>:<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-cyan-400">print</span>(<span class="text-amber-300">"ACCESS GRANTED"</span>)<br>
                            <span class="text-purple-400">else</span>:<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-cyan-400">print</span>(<span class="text-amber-300">"ACCESS DENIED: WRONG PASSWORD"</span>)
                        </div>
                    </div>

                    <div class="border-t border-white/5"></div>

                    <div class="grid md:grid-cols-2 gap-8 items-start">
                        <div>
                            <div class="text-xs font-mono text-emerald-400 mb-2">[WEEK_13-18::LOOPING_STRUCTURES]</div>
                            <h4 class="text-white font-bold text-xl mb-3 font-mono">4. Repetition Structures (Loops)</h4>
                            <p class="text-gray-400 text-sm leading-relaxed mb-4">
                                Instead of writing the exact same code 10 times, loops repeat code blocks automatically. A **While Loop** runs *as long as* a condition remains true. A **For Loop** runs a *set number of times* (commonly using the `range()` utility).
                            </p>
                            <div class="text-xs text-gray-500 font-mono bg-white/5 p-3 rounded border border-white/5">
                                <span class="text-emerald-400 font-bold">Game Blueprint:</span> Looping the countdown timer or printing loading bars on screen.
                            </div>
                        </div>
                        <div class="bg-black/40 border border-white/5 rounded-lg p-5 font-mono text-xs text-gray-300 leading-relaxed">
                            <span class="text-gray-500"># Loop a fixed number of times (For Loop)</span><br>
                            <span class="text-purple-400">for</span> attempt <span class="text-purple-400">in</span> <span class="text-cyan-400">range</span>(<span class="text-cyan-400">1</span>, <span class="text-cyan-400">4</span>):<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-cyan-400">print</span>(f<span class="text-amber-300">"Connecting attempt #{attempt}..."</span>)<br><br>

                            <span class="text-gray-500"># Output:<br># Connecting attempt #1...<br># Connecting attempt #2...<br># Connecting attempt #3...</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-24 text-center">
                <p class="text-xs font-mono text-cyan-500 uppercase tracking-[0.3em] mb-4">Training Complete. Ready to initialize simulation?</p>
                <a href="<?= base_url('/') ?>" class="inline-block bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 hover:bg-emerald-500/20 px-8 py-3 rounded-lg font-mono text-sm tracking-widest transition-all duration-300 hover:shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                    LAUNCH_LOGIC_OVERRIDE_&gt;
                </a>
            </div>

        </div>
    </main>

    <?= $this->include('partials/footer') ?>

    <script src="<?= base_url('js/partials/loading.js') ?>"></script>
    
</body>

</html>