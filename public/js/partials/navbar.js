let lastScroll = 0;
window.addEventListener("scroll", () => {
  const nav = document.querySelector("nav");
  if (window.scrollY > 50) {
    nav.classList.add("scrolled");
  } else {
    nav.classList.remove("scrolled");
  }
  lastScroll = window.scrollY;
});

// Active link highlighting
document.querySelectorAll(".nav-link").forEach((link) => {
  if (window.location.pathname.includes(link.textContent.toLowerCase())) {
    link.classList.add("active");
  }
});

// Mobile menu toggle
document.querySelector(".mobile-menu-btn")?.addEventListener("click", () => {
  const links = document.querySelector(".nav-links");
  links.classList.toggle("hidden");
});
