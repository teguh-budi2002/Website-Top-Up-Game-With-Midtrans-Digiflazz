const searchIcon = document.querySelector(".search__icon");
const xButton = document.querySelector(".x_button");
const formInput = document.querySelector(".form__input");
const html = document.getElementsByTagName("html")[0];
let inputSearchBox = document.querySelector(".input__search");

searchIcon.addEventListener("click", function () {
    inputSearchBox.classList.remove("hidden");
    this.classList.add("fade_out_animation");
    this.classList.add("hidden");
    xButton.classList.remove("hidden");
});

xButton.addEventListener("click", function () {
    inputSearchBox.classList.add("hidden");
    this.classList.add("hidden");
    searchIcon.classList.remove("hidden");
});

html.onclick = (e) => {
    if (e.target == html) {
        inputSearchBox.classList.add("hidden");
        xButton.classList.add("hidden");
        searchIcon.classList.remove("hidden");
    }
};
