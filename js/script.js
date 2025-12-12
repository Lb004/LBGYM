// Tu código JavaScript original se mantiene igual
let navbar = document.querySelector("#navbar");
let menu = document.querySelector("#menu-icon");

menu.addEventListener("click", () => {
  navbar.classList.toggle("active");
});

menu.addEventListener("click", () => {
  menu.classList.toggle("menu-active");
});

window.addEventListener("resize", () => {
  const screenWidth = window.innerWidth;
  const breakpoint = 720;

  if (screenWidth > breakpoint) {
    navbar.classList.remove("active");
    menu.classList.remove("menu-active");
  }
});