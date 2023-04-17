const menuItem = document.querySelector(".menu_item");
const menuNavDropdown = document.querySelector(".menu_nav_dropdown");

menuItem.addEventListener("click", function () {
    menuNavDropdown.classList.toggle("hidden");
});
