document.addEventListener("DOMContentLoaded", () => {
    const bodyTag = document.body;
    const currentTrackPath = bodyTag.getAttribute("data-audio");

    if (!currentTrackPath) {
        console.log("No background soundtrack assigned to this module.");
        return;
    }

    const gameMusic = new Audio(currentTrackPath);
    gameMusic.loop = true;
    gameMusic.volume = 0.3;

    const storageKeyMute = "audio_global_muted";

    // Restore previous mute state
    gameMusic.muted = localStorage.getItem(storageKeyMute) === "true";

    const startAudioGrid = () => {
        gameMusic.play().catch(() => {
            console.log("Autoplay blocked until user interaction.");
        });

        document.removeEventListener("click", startAudioGrid);
    };

    document.addEventListener("click", startAudioGrid);

    // Expose controls globally
    window.CyberAudio = {
        toggleMute() {
            gameMusic.muted = !gameMusic.muted;
            localStorage.setItem(storageKeyMute, gameMusic.muted);
            return gameMusic.muted;
        },

        mute() {
            gameMusic.muted = true;
        },

        unmute() {
            gameMusic.muted = false;
        }
    };
});

// -------------------------
// YouTube IFrame API
// -------------------------

let player;

function onYouTubeIframeAPIReady() {
    player = new YT.Player("trailer-iframe", {
        events: {
            onStateChange: onPlayerStateChange
        }
    });
}

function onPlayerStateChange(event) {

    // Video is playing
    if (event.data === YT.PlayerState.PLAYING) {
        window.CyberAudio?.mute();
    }

    // Video is paused or ended
    if (
        event.data === YT.PlayerState.PAUSED ||
        event.data === YT.PlayerState.ENDED
    ) {
        window.CyberAudio?.unmute();
    }
}