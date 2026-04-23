// =========================
// SHARED UI ANIMATIONS
// =========================

function staggerFadeIn(items, delay = 60, y = 15) {
  items.forEach((item, index) => {
    item.style.opacity = "0";
    item.style.transform = `translateY(${y}px)`;
    item.style.transition = "all 0.4s ease";

    setTimeout(() => {
      item.style.opacity = "1";
      item.style.transform = "translateY(0)";
    }, index * delay);
  });
}