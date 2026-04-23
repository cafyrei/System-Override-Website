// CORE ADMIN FUNCTIONS
// Navigation + Shared Utilities

function showSection(sectionId, event) {
  const target = document.getElementById(sectionId);
  if (!target) return;

  document.querySelectorAll(".admin-section").forEach((section) => {
    section.classList.add("hidden");
  });

  target.classList.remove("hidden");

  const titles = {
    dashboard: "Dashboard Overview",
    patches: "Manage Game Patches",
    gallery: "Gallery & Media Management",
    feedback: "Player Feedback & Suggestions",
  };

  document.getElementById("page-title").innerText =
    titles[sectionId] || "Admin Panel";

  document.querySelectorAll(".nav-link").forEach((link) => {
    link.classList.remove("bg-slate-800", "text-white");
  });

  if (event?.currentTarget) {
    event.currentTarget.classList.add("bg-slate-800", "text-white");
  }
}

// SINGLE SOURCE OF TRUTH - Used by gallery button
window.resetGalleryUI = function () {
  const elements = {
    fileInput: document.getElementById("fileInput"),
    uploadArea: document.getElementById("uploadArea"),
    previewArea: document.getElementById("previewArea"),
    galleryActions: document.getElementById("gallery-actions"),
    imagePreview: document.getElementById("imagePreview"),
    fileName: document.getElementById("fileName"),
    fileSize: document.getElementById("fileSize"),
    form: document.getElementById("galleryForm"),
    title: document.getElementById("form-title"),
    desc: document.getElementById("form-desc"),
  };

  // Reset file input
  elements.fileInput?.value = "";

  // Reset preview
  elements.imagePreview.src = "";
  elements.fileName.textContent = "";
  elements.fileSize.textContent = "";

  // Reset form
  elements.form?.reset();
  elements.title.value = "";
  elements.desc.value = "";

  // UI reset
  elements.previewArea?.classList.add("hidden");
  elements.uploadArea?.classList.remove("hidden");
  elements.galleryActions?.classList.add("hidden");
};

// Initialize navigation on DOM load
document.addEventListener("DOMContentLoaded", function () {
  // Auto-show dashboard
  showSection("dashboard");
});
