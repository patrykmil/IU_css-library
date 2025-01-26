const hamburger = document.querySelector(".menu-show");
const menu = document.querySelector("nav  ul");
const mobile_only = document.querySelectorAll(".mobile-option");
const nav = document.querySelector("nav");
hamburger.addEventListener("click", () => {
  menu.classList.toggle("active");
  mobile_only.forEach((element) => {
    element.classList.toggle("active");
  });
    nav.classList.toggle("absolute");
});
