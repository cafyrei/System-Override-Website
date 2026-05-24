    <div id="cyber-preloader"
        style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; z-index: 99999; background-color: #030406; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.5s ease-in-out;">

        <div class="relative flex flex-col items-center">
            <div class="w-20 h-20 rounded-full border-2 border-cyan-500/10 border-t-cyan-400 animate-spin shadow-[0_0_20px_rgba(0,242,255,0.2)]"></div>
            <div class="absolute top-2 w-16 h-16 rounded-full border-2 border-emerald-500/10 border-b-emerald-400 animate-[spin_1s_linear_infinite_reverse] shadow-[0_0_15px_rgba(16,185,129,0.2)]"></div>

            <div class="mt-8 font-mono text-center space-y-2">
                <p class="text-xs tracking-[0.4em] text-cyan-400 font-bold uppercase animate-pulse">
                    CONNECTING_TO_CORE...
                </p>
                <p id="preloader-percent" class="text-[10px] text-gray-500 tracking-widest font-bold">
                    SYS_STATUS: FETCHING_DATA
                </p>
            </div>
        </div>

    </div>