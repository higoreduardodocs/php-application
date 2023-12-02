const accountBox = document.querySelector(".admin-header > div .account-box");
const navbar = document.querySelector(".admin-header > div .navbar");

document.querySelector("#account-btn").addEventListener("click", () => {
  accountBox.classList.toggle("active");
  navbar.classList.remove("active");
});

document.querySelector("#menu-btn").addEventListener("click", () => {
  navbar.classList.toggle("active");
  accountBox.classList.remove("active");
});
