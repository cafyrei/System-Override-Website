// File Upload Verification & Preview
document.addEventListener("DOMContentLoaded", function () {
  const fileInput = document.getElementById("fileInput");
  const uploadArea = document.getElementById("uploadArea");
  const previewArea = document.getElementById("previewArea");
  const imagePreviews = document.getElementById("imagePreviews");
  const changeImagesBtn = document.getElementById("changeImages");

  // File selection handler
  fileInput.addEventListener("change", handleFiles);

  // Drag & Drop handlers
  uploadArea.addEventListener("dragover", handleDragOver);
  uploadArea.addEventListener("dragleave", handleDragLeave);
  uploadArea.addEventListener("drop", handleDrop);

  // Change images button
  changeImagesBtn?.addEventListener("click", resetUploadArea);

  function handleFiles(e) {
    const files = e.target.files;
    if (files.length > 0) {
      showPreview(files);
    }
  }

  function handleDragOver(e) {
    e.preventDefault();
    uploadArea.classList.add(
      "bg-blue-50",
      "border-blue-400",
      "ring-2",
      "ring-blue-200",
    );
  }

  function handleDragLeave(e) {
    e.preventDefault();
    uploadArea.classList.remove(
      "bg-blue-50",
      "border-blue-400",
      "ring-2",
      "ring-blue-200",
    );
  }

  function handleDrop(e) {
    e.preventDefault();
    uploadArea.classList.remove(
      "bg-blue-50",
      "border-blue-400",
      "ring-2",
      "ring-blue-200",
    );

    const files = e.dataTransfer.files;
    if (files.length > 0) {
      const dataTransfer = new DataTransfer();
      Array.from(files).forEach((file) => {
        if (file.type.startsWith("image/")) {
          dataTransfer.items.add(file);
        }
      });
      fileInput.files = dataTransfer.files;
      showPreview(files);
    }
  }

  function showPreview(files) {
    // Hide upload area, show preview
    uploadArea.classList.add("hidden");
    previewArea.classList.remove("hidden");

    // Clear previous previews
    imagePreviews.innerHTML = "";

    // Generate previews
    Array.from(files)
      .slice(0, 8)
      .forEach((file, index) => {
        // Limit to 8 images
        if (file.type.startsWith("image/") && file.size <= 10 * 1024 * 1024) {
          // 10MB limit
          const reader = new FileReader();
          reader.onload = function (e) {
            const preview = createPreviewHTML(
              e.target.result,
              file.name,
              file.size,
            );
            imagePreviews.insertAdjacentHTML("beforeend", preview);
          };
          reader.readAsDataURL(file);
        }
      });
  }

  function createPreviewHTML(imageSrc, fileName, fileSize) {
    return `
            <div class="group relative bg-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <img src="${imageSrc}" 
                     class="w-full h-24 md:h-28 object-cover" 
                     alt="${fileName}">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all"></div>
                <div class="absolute top-1 right-1 bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                    ${formatFileSize(fileSize)}
                </div>
                <p class="text-xs text-gray-600 mt-1 truncate px-1">${fileName}</p>
            </div>
        `;
  }

  function resetUploadArea() {
    fileInput.value = "";
    previewArea.classList.add("hidden");
    uploadArea.classList.remove("hidden");
    imagePreviews.innerHTML = "";
  }

  function formatFileSize(bytes) {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const sizes = ["Bytes", "KB", "MB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + " " + sizes[i];
  }
});

function showSection(sectionId) {
  document.querySelectorAll(".admin-section").forEach((section) => {
    section.classList.add("hidden");
  });

  // Show the selected one
  document.getElementById(sectionId).classList.remove("hidden");

  const titles = {
    dashboard: "Dashboard Overview",
    patches: "Manage Game Patches",
    gallery: "Gallery & Media Management",
    feedback: "Player Feedback & Suggestions",
  };
  document.getElementById("page-title").innerText = titles[sectionId];

  // Update Sidebar Styles
  document.querySelectorAll(".nav-link").forEach((link) => {
    link.classList.remove("bg-slate-800", "text-white");
    link.classList.add("hover:bg-slate-800", "transition");
  });
  event.currentTarget.classList.add("bg-slate-800", "text-white");
}
