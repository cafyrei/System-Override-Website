document.getElementById("patchForm").addEventListener("submit", function () {
  const major = document.getElementById("major").value || 0;
  const minor = document.getElementById("minor").value || 0;
  const patch = document.getElementById("patch").value || 0;

  const version = `${major}.${minor}.${patch}`;
  document.getElementById("patch_version").value = version;
});

function editPatch(patch) {
  const cleanV = patch.patch_version.replace("v", "");

  document.getElementById("patch-form-title").innerHTML =
    `<i class="fas fa-edit text-blue-500"></i> Edit Patch: v${cleanV}`;
  document.querySelector('#patchForm button[type="submit"]').textContent =
    "Update Patch";

  const deleteBtn = document.getElementById("delete-patch-btn");
  deleteBtn.classList.remove("hidden");

  document.getElementById("edit-patch-id").value = patch.patch_id;
  document.getElementById("patch-title").value = patch.patch_title;
  document.getElementById("patch-type").value = patch.patch_type;
  document.getElementById("patch-release").value = patch.patch_release;
  document.getElementById("patch-desc").value = patch.patch_description;

  const vParts = cleanV.split(".");
  document.getElementById("major").value = vParts[0] || 0;
  document.getElementById("minor").value = vParts[1] || 0;
  document.getElementById("patch").value = vParts[2] || 0;
}

function resetPatchForm() {
  document.getElementById("patch-form-title").innerHTML =
    `<i class="fas fa-upload text-blue-500"></i> New Patch Release`;
  document.querySelector('#patchForm button[type="submit"]').textContent =
    "Publish Update";
  document.getElementById("delete-patch-btn").classList.add("hidden");

  document.getElementById("patchForm").reset();
  document.getElementById("edit-patch-id").value = "";
}

document
  .getElementById("delete-patch-btn")
  .addEventListener("click", function () {
    const patchId = document.getElementById("edit-patch-id").value;
    const patchTitle = document.getElementById("patch-title").value;

    if (
      patchId &&
      confirm(`Are you sure you want to delete "${patchTitle}"?`)
    ) {
      const finalUrl = DELETE_PATCH_BASE_URL + patchId;

      console.log("Attempting to delete ID:", patchId);
      console.log("Full URL:", finalUrl);

      fetch(finalUrl)
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            window.location.reload();
          } else {
            alert(
              "Failed to delete the patch: " +
                (data.message || "Unknown error"),
            );
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("An error occurred. Check the console for details.");
        });
    }
  });
