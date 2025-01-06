document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".like").forEach((button) => {
    button.addEventListener("click", async (event) => {
      event.preventDefault();
      const componentId = button.getAttribute("data-component-id");
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
      try {
        const response = await fetch("/toggleLike", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
          },
          body: JSON.stringify({ componentID: componentId }),
        });
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();
        const icon = button.querySelector("img");
        if (result.liked) {
          icon.src = "/assets/icons/heart_fill.svg";
        } else {
          icon.src = "/assets/icons/heart_nofill.svg";
        }
      } catch (error) {
        console.error("Error:", error);
      }
    });
  });
});
