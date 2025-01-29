document.addEventListener("DOMContentLoaded", () => {
    const likeButtons = document.querySelectorAll(".like");
    if (likeButtons.length > 0) {
        likeButtons.forEach((button) => {
            button.addEventListener("click", async (event) => {
                event.preventDefault();
                const componentId = button.getAttribute("data-component-id");

                try {
                    const response = await fetch("/toggleLike", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ componentID: componentId }),
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    const icon = button.querySelector("img");
                    if (data.liked) {
                        icon.src = "/assets/icons/heart_fill.svg";
                    } else {
                        icon.src = "/assets/icons/heart_nofill.svg";
                    }
                } catch (error) {
                    console.error("Error:", error);
                }
            });
        });
    }
});