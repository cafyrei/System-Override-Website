document.addEventListener("DOMContentLoaded", () => {
  // =============================
  // ELEMENTS
  // =============================
  const fileInput = document.getElementById("fileInput");
  const uploadArea = document.getElementById("uploadArea");
  const previewArea = document.getElementById("previewArea");
  const galleryActions = document.getElementById("gallery-actions");

  const imagePreview = document.getElementById("imagePreview");
  const fileName = document.getElementById("fileName");
  const fileSize = document.getElementById("fileSize");

  const form = document.getElementById("galleryForm");
  const titleInput = document.getElementById("gallery-title");
  const descInput = document.getElementById("form-desc");
  const editId = document.getElementById("edit-id");

  const formTitle = document.getElementById("gallery-form-title");
  const submitText = document.getElementById("submit-btn-text");

  // =============================
  // FILE UPLOAD HANDLING
  // =============================
  if (fileInput) fileInput.addEventListener("change", handleFiles);

  if (uploadArea) {
    uploadArea.addEventListener("dragover", handleDragOver);
    uploadArea.addEventListener("dragleave", handleDragLeave);
    uploadArea.addEventListener("drop", handleDrop);
  }

  function handleFiles(e) {
    const files = e.target.files;
    if (files.length > 0) showPreview(files[0]);
  }

  function handleDragOver(e) {
    e.preventDefault();
    uploadArea.classList.add("bg-blue-50", "border-blue-400", "ring-2");
  }

  function handleDragLeave(e) {
    e.preventDefault();
    uploadArea.classList.remove("bg-blue-50", "border-blue-400", "ring-2");
  }

  function handleDrop(e) {
    e.preventDefault();
    uploadArea.classList.remove("bg-blue-50", "border-blue-400", "ring-2");

    const files = e.dataTransfer.files;
    if (files.length > 0 && files[0].type.startsWith("image/")) {
      const dt = new DataTransfer();
      dt.items.add(files[0]);
      fileInput.files = dt.files;

      showPreview(files[0]);
    }
  }

  function showPreview(file) {
    const reader = new FileReader();

    reader.onload = (e) => {
      imagePreview.src = e.target.result;
      fileName.textContent = file.name;
      fileSize.textContent = formatFileSize(file.size);
    };

    reader.readAsDataURL(file);

    uploadArea.classList.add("hidden");
    previewArea.classList.remove("hidden");
    galleryActions.classList.remove("hidden");
  }

  function resetUploadUI() {
    fileInput.value = "";

    imagePreview.src = "";
    fileName.textContent = "";
    fileSize.textContent = "";

    previewArea.classList.add("hidden");
    uploadArea.classList.remove("hidden");
  }

  // =============================
  // STATE SYSTEM (IMPORTANT PART)
  // =============================

  function setAddMode() {
    form.reset();
    editId.value = "";

    resetUploadUI();

    formTitle.innerText = "Add New Image";
    submitText.innerText = "Save to Gallery";

    galleryActions.classList.add("hidden");

    document.querySelectorAll(".gallery-item").forEach((el) => {
      el.classList.remove("border-blue-500");
    });
  }

  function setEditMode(item, event) {
    document.querySelectorAll(".gallery-item").forEach((el) => {
      el.classList.remove("border-blue-500");
    });

    event.currentTarget.classList.add("border-blue-500");

    editId.value = item.gallery_id;
    titleInput.value = item.gallery_title;
    descInput.value = item.gallery_description;

    imagePreview.src = window.baseUrl + "/" + item.image_path;
    fileName.textContent = "Existing Image";
    fileSize.textContent = "";

    uploadArea.classList.add("hidden");
    previewArea.classList.remove("hidden");
    galleryActions.classList.remove("hidden");

    formTitle.innerText = "Edit Image";
    submitText.innerText = "Update Image";
  }

  // =============================
  // GLOBAL ACTIONS (CALLED FROM HTML)
  // =============================

  window.showGalleryDetail = function (event, item) {
    setEditMode(item, event);
  };

  window.resetForm = function () {
    setAddMode();
  };

  window.deleteGalleryItem = function () {
    const id = editId.value;

    if (!id) return;

    if (!confirm("Delete this image permanently?")) return;

    fetch(`${window.deleteGalleryUrl}/${id}`, {
      method: "POST",
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          setAddMode();
          location.reload();
        }
      })
      .catch((err) => console.error(err));
  };

  // =============================
  // SECTION SWITCHING
  // =============================
  window.showSection = function (sectionId, event) {
    document.querySelectorAll(".admin-section").forEach((section) => {
      section.classList.add("hidden");
    });

    document.getElementById(sectionId).classList.remove("hidden");

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

    if (event) {
      event.currentTarget.classList.add("bg-slate-800", "text-white");
    }
  };

  // =============================
  // UTIL
  // =============================
  function formatFileSize(bytes) {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const sizes = ["Bytes", "KB", "MB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + " " + sizes[i];
  }
});
