<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/feedback.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@300;400;700&display=swap" rel="stylesheet">
    <title>System Override | Feedback Terminal</title>
</head>

<body class="text-white h-screen">

    <canvas id="matrix-bg"></canvas>
    <div class="cyber-grid"></div>
    <div id="dust-container" style="position:fixed; inset:0; z-index:3; pointer-events:none;"></div>

    <?= $this->include('partials/navbar') ?>

    <main class="relative z-10 h-[calc(100vh-80px)] flex flex-col items-center justify-center px-6">

        <header class="text-center mb-10">
            <h1 class="text-4xl md:text-6xl font-black tracking-tighter uppercase italic mb-2">
                Feedback <span class="text-cyan-400" style="text-shadow: 0 0 20px rgba(0,242,255,0.4)">Terminal</span>
            </h1>
            <div class="flex justify-center items-center gap-4">
                <div class="h-px w-12 bg-cyan-500/50"></div>
                <span class="text-[9px] uppercase tracking-[0.5em] text-gray-500">Transmission Node 04</span>
                <div class="h-px w-12 bg-cyan-500/50"></div>
            </div>
        </header>

        <div class="terminal-panel w-full max-w-xl p-8 md:p-12 rounded-sm">

            <form action="<?= base_url('feedback/send_feedback') ?>" method="post" class="space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[9px] text-cyan-500/60 uppercase tracking-widest mb-2 font-bold">// Packet_Type</label>
                        <select name="feedback_type" class="cyber-input w-full h-11 px-4 text-xs rounded-sm appearance-none">
                            <option value="" disabled selected>Select Protocol</option>
                            <option value="suggestion">Optimization Suggestion</option>
                            <option value="bug_report">Glitch Report</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[9px] text-cyan-500/60 uppercase tracking-widest mb-2 font-bold">// User_ID</label>
                        <input type="text" name="name" placeholder="User-X" class="cyber-input w-full h-11 px-4 text-xs rounded-sm" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[9px] text-cyan-500/60 uppercase tracking-widest mb-2 font-bold">// Neural_Link_Address</label>
                    <input type="email" name="email" placeholder="name@network.sys" class="cyber-input w-full h-11 px-4 text-xs rounded-sm" required>
                </div>

                <div>
                    <label class="block text-[9px] text-cyan-500/60 uppercase tracking-widest mb-2 font-bold">// Raw_Data_Payload</label>
                    <textarea name="message" rows="4" placeholder="Input transmission content..." class="cyber-input w-full px-4 py-3 text-xs rounded-sm resize-none" required></textarea>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-6 border-t border-white/5">
                    <label class="flex items-center gap-3 text-[9px] text-gray-500 uppercase cursor-pointer group">
                        <input type="checkbox" name="terms" class="accent-cyan-500 w-4 h-4" required>
                        <span class="group-hover:text-cyan-400 transition-colors">Authorize Encryption</span>
                    </label>

                    <button type="submit" class="transmit-btn w-full md:w-auto px-12 py-3 text-[10px] rounded-sm">
                        Initiate_Transmit
                    </button>
                </div>
            </form>
        </div>

        <footer class="mt-12 text-[10px] text-gray-700 font-mono tracking-[0.6em] uppercase">
            Protocol: Override_Core // Ver_2.6
        </footer>

    </main>
    <script src="<?= base_url('js/main/feedback.js') ?>"></script>
</body>

</html>