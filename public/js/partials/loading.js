window.addEventListener("load", function () {
  const preloader = document.getElementById("cyber-preloader");

  if (preloader) {
    preloader.classList.add("opacity-0");

    // Disables element layout block layers immediately on complete
    preloader.style.pointerEvents = "none";

    setTimeout(() => {
      preloader.style.display = "none";
    }, 500);
  }
});
