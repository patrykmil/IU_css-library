const hamburger = document.querySelector(".menu_show");
const menu = document.querySelector("nav  ul");
const mobile_only = document.querySelectorAll(".mobile_only");

hamburger.addEventListener("click", () => {
  menu.classList.toggle("active");
  mobile_only.forEach((element) => {
    element.classList.toggle("active");
  });
});
