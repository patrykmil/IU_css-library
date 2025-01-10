document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".like").forEach((button) => {
        button.addEventListener("click", (event) => {
            event.preventDefault();
            const componentId = button.getAttribute("data-component-id");

            fetch("/toggleLike", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ componentID: componentId }),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const icon = button.querySelector("img");
                    if (data.liked) {
                        icon.src = "/assets/icons/heart_fill.svg";
                    } else {
                        icon.src = "/assets/icons/heart_nofill.svg";
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        });
    });
});