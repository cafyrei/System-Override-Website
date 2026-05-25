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

    const isGlobalMuted = localStorage.getItem(storageKeyMute) === "true";

    const startAudioGrid = () => {
        gameMusic.play().catch(err => console.log("Autoplay context initialization pending interaction."));
        document.removeEventListener("click", startAudioGrid);
    };
    document.addEventListener("click", startAudioGrid);

    window.CyberAudio = {
        toggleMute: () => {
            gameMusic.muted = !gameMusic.muted;
            localStorage.setItem(storageKeyMute, gameMusic.muted);
            return gameMusic.muted;
        }
    };
});