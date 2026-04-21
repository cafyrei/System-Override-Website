document.addEventListener("DOMContentLoaded", () => {
  // Cache all elements ONCE
  const ELEMENTS = {
    btn: document.getElementById("mark-reviewed"),
    deleteBtn: document.getElementById("delete-feedback"),
    filter: document.getElementById("feedback-filter"),
    title: document.getElementById("fb-title"),
    user: document.getElementById("fb-user"),
    email: document.getElementById("fb-email"),
    comment: document.getElementById("fb-comment"),
  };

  const items = document.querySelectorAll(".feedback-item");
  let selectedFeedback = null;

  // Animation & UI Helpers
  const animateStaggerIn = (elements, delay = 80) => {
    elements.forEach((el, index) => {
      setTimeout(() => {
        el.style.opacity = "1";
        el.style.transform = "translateY(0)";
      }, 100 + index * delay);
    });
  };

  const createRipple = (item, e) => {
    const rect = item.getBoundingClientRect();
    const ripple = document.createElement("div");
    ripple.style.cssText = `
      position: absolute;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(59,130,246,0.5) 0%, rgba(59,130,246,0.1) 70%, transparent 100%);
      width: 40px; height: 40px;
      animation: ripple 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      pointer-events: none;
      left: ${e.clientX - rect.left - 20}px;
      top: ${e.clientY - rect.top - 20}px;
      z-index: 20;
      transform: scale(0);
    `;
    item.style.position = "relative";
    item.style.overflow = "hidden";
    item.appendChild(ripple);
    return ripple;
  };

  const shakeButton = (button) => {
    button.animate(
      [{ transform: "translateX(-3px)" }, { transform: "translateX(3px)" }, { transform: "translateX(0)" }],
      { duration: 300, iterations: 2 }
    );
  };

  // Single Button State Manager
  const setButtonState = (enabled, isReviewed = false) => {
    const isActive = enabled && !isReviewed;
    
    [ELEMENTS.btn, ELEMENTS.deleteBtn].forEach(btn => {
      btn.disabled = !isActive;
      btn.classList.toggle("opacity-50", "cursor-not-allowed", !isActive);
    });

    if (isReviewed) {
      ELEMENTS.btn.innerText = "Reviewed";
      ELEMENTS.btn.classList.add("opacity-50", "cursor-not-allowed");
    } else if (isActive) {
      ELEMENTS.btn.innerText = "Mark as Reviewed";
      ELEMENTS.btn.classList.remove("opacity-50", "cursor-not-allowed");
    }
  };

  // UI Reset
  const resetUI = () => {
    ELEMENTS.title.innerText = "Feedback Detail";
    ELEMENTS.user.innerText = "";
    ELEMENTS.email.innerText = "";
    ELEMENTS.comment.innerText = "Select an item from the left to read the full player comment.";
    setButtonState(false);
  };

  // Update Selection UI (FIXED - Right side content works!)
  const updateSelectionUI = (item) => {
    const { username, email, comment, type, time, status } = item.dataset;

    // Stagger OUT animation for detail panel
    const detailElements = [ELEMENTS.title, ELEMENTS.user, ELEMENTS.email, ELEMENTS.comment];
    detailElements.forEach(el => {
      el.style.transition = "all 0.3s ease";
      el.style.opacity = "0";
      el.style.transform = "translateY(15px)";
    });

    // Update content IMMEDIATELY
    ELEMENTS.title.innerText = type.toUpperCase();
    ELEMENTS.user.innerText = `From: ${username} • ${time}`;
    ELEMENTS.email.innerText = email;
    ELEMENTS.comment.innerText = comment;

    // Selection highlight
    document.querySelectorAll(".feedback-item").forEach(i => 
      i.classList.remove("border-blue-500", "ring-2", "ring-blue-200/50")
    );
    item.classList.add("border-blue-500", "ring-2", "ring-blue-200/50");

    // Update button states
    setButtonState(true, status === "reviewed");

    // Stagger IN animation
    animateStaggerIn(detailElements);
  };

  // API Helper
  const apiCall = async (url, data) => {
    const res = await fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });
    const json = await res.json();
    if (!json.success) throw new Error(json.message || "Request failed");
    return json;
  };

  // Single Click Handler (FIXED - Selection works perfectly)
  document.addEventListener("click", (e) => {
    // 1. Feedback item selection (SHOWS CONTENT ON RIGHT)
    const item = e.target.closest(".feedback-item");
    if (item) {
      // Ripple + press effect
      const ripple = createRipple(item, e);
      item.style.transition = "all 0.15s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
      item.style.transform = "scale(0.97)";
      item.style.boxShadow = "0 8px 25px rgba(0,0,0,0.15)";

      setTimeout(() => {
        // Glow effect + selection
        item.style.transition = "all 0.25s ease";
        item.style.transform = "scale(1)";
        item.style.boxShadow = "0 12px 40px rgba(59, 130, 246, 0.25)";
        
        // THIS SELECTS AND SHOWS CONTENT
        selectedFeedback = item;
        updateSelectionUI(item);

        // Cleanup
        setTimeout(() => {
          item.style.boxShadow = "";
          ripple.remove();
        }, 300);
      }, 120);
      return;
    }

    // 2. Action buttons
    if (e.target.id === "mark-reviewed") handleMarkReviewed(e);
    if (e.target.id === "delete-feedback") handleDeleteFeedback(e);
  });

  // Filter Handler
  ELEMENTS.filter.addEventListener("change", () => {
    const value = ELEMENTS.filter.value;
    items.forEach((item, index) => {
      const type = item.dataset.type;
      const shouldShow = value === "all" || type === value;

      item.style.transition = "all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
      item.style.opacity = "0";
      item.style.transform = "translateX(-20px) scale(0.95)";

      setTimeout(() => {
        item.style.display = shouldShow ? "block" : "none";
        if (shouldShow) {
          setTimeout(() => {
            item.style.opacity = "1";
            item.style.transform = "translateX(0) scale(1)";
          }, 50);
        }
      }, index * 50);
    });
  });

  // Mark Reviewed Handler
  const handleMarkReviewed = async (e) => {
    e?.preventDefault();
    
    if (!selectedFeedback) {
      shakeButton(ELEMENTS.btn);
      alert("Select feedback first");
      return;
    }

    const originalText = ELEMENTS.btn.innerText;
    ELEMENTS.btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
    ELEMENTS.btn.disabled = true;

    try {
      await apiCall(window.markReviewedUrl, { id: selectedFeedback.dataset.id });
      
      ELEMENTS.btn.innerHTML = '<i class="fas fa-check mr-2"></i>Reviewed!';
      ELEMENTS.btn.style.backgroundColor = "#10b981";

      selectedFeedback.dataset.status = "reviewed";
      const statusSpan = selectedFeedback.querySelector("span:last-child");
      if (statusSpan) {
        statusSpan.innerText = "reviewed";
        statusSpan.classList.add("text-green-600", "animate-pulse");
      }

      setTimeout(() => {
        ELEMENTS.btn.innerText = "Reviewed";
        ELEMENTS.btn.style.backgroundColor = "";
        setButtonState(true, true); // Reviewed state
        if (statusSpan) statusSpan.classList.remove("animate-pulse");
      }, 2000);
    } catch (error) {
      ELEMENTS.btn.innerText = originalText;
      alert(error.message || "Failed to mark as reviewed");
    }
  };

  // Delete Handler
  const handleDeleteFeedback = async (e) => {
    e?.preventDefault();
    
    if (!selectedFeedback) {
      shakeButton(ELEMENTS.deleteBtn);
      alert("Select feedback first");
      return;
    }

    if (!confirm("Delete this feedback?")) return;

    const originalText = ELEMENTS.deleteBtn.innerText;
    ELEMENTS.deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Deleting...';

    try {
      await apiCall(window.deleteFeedbackUrl, { id: selectedFeedback.dataset.id });

      // Animate removal
      selectedFeedback.style.transition = "all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
      selectedFeedback.style.opacity = "0";
      selectedFeedback.style.transform = "scale(0.8) translateY(-30px)";

      setTimeout(() => {
        selectedFeedback.remove();
        selectedFeedback = null;
        resetUI();
      }, 400);

      alert("Deleted successfully");
    } catch (error) {
      ELEMENTS.deleteBtn.innerText = originalText;
      alert(error.message || "Failed to delete");
    }
  };

  // Initialize
  resetUI();
});