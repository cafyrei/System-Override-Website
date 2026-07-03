<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Override Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="bg-slate-950 font-sans flex items-center justify-center min-h-screen relative overflow-hidden">

    <div class="absolute w-[500px] h-[500px] bg-blue-500/10 blur-[120px] rounded-full top-[-10%] left-[-10%] pointer-events-none"></div>
    <div class="absolute w-[400px] h-[400px] bg-emerald-500/5 blur-[100px] rounded-full bottom-[-10%] right-[-10%] pointer-events-none"></div>

    <div class="w-full max-w-md p-8 relative z-10">
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-3 mb-2">
                <div class="w-9 h-9 bg-blue-500 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <i class="fas fa-terminal text-white text-sm"></i>
                </div>
                <span class="text-2xl font-black text-white tracking-tighter">
                    OVERRIDE <span class="text-xs font-normal text-slate-400">ADMIN</span>
                </span>
            </div>
            <p class="text-slate-400 text-sm">Enter your credentials to access the terminal panel</p>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 text-sm p-4 rounded-xl mb-6 flex items-start gap-3">
                <i class="fas fa-exclamation-circle mt-0.5"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-2xl">
            <form action="<?= site_url('admin/login/authenticate') ?>" method="POST" class="space-y-5">
                <?= csrf_field() ?>

                <div>
                    <label for="identity" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Username or Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                            <i class="fas fa-user-shield text-sm"></i>
                        </span>
                        <input type="text" name="identity" id="identity" required
                            value="<?= old('identity') ?>"
                            class="w-full bg-slate-950 border border-slate-800 rounded-xl py-3 pl-11 pr-4 text-white text-sm placeholder-slate-600 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                            placeholder="admin@system.local">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Password</label>
                        <a href="#" class="text-xs text-blue-400 hover:underline">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                            <i class="fas fa-lock text-sm"></i>
                        </span>
                        <input type="password" name="password" id="password" required
                            class="w-full bg-slate-950 border border-slate-800 rounded-xl py-3 pl-11 pr-4 text-white text-sm placeholder-slate-600 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                            placeholder="••••••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-800 bg-slate-950 text-blue-600 focus:ring-blue-500/20 focus:ring-offset-slate-900">
                        <span class="text-xs text-slate-400 group-hover:text-slate-300 transition">Keep me logged in</span>
                    </label>
                </div>

                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-blue-600/10 hover:shadow-blue-500/20 flex items-center justify-center gap-2 mt-2">
                    <span>Access Dashboard</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-slate-600 mt-8">
            &copy; <?= date('Y') ?> Montrix Interactive. All rights reserved.
        </p>
    </div>

</body>
</html>