const accountBoxAdmin = document.querySelector(
  ".admin-header > div .account-box"
);
const navbarAdmin = document.querySelector(".admin-header > div .navbar");
const accountBox = document.querySelector(
  ".header > div .account-box"
);
const navbar = document.querySelector(".header > div .navbar");

document.querySelector("#account-btn").addEventListener("click", () => {
  if (accountBox && navbar) {
    accountBox.classList.toggle("active");
    navbar.classList.remove("active");
  }
  if (accountBoxAdmin && navbarAdmin) {
    accountBoxAdmin.classList.toggle("active");
    navbarAdmin.classList.remove("active");
  }
});

document.querySelector("#menu-btn").addEventListener("click", () => {
  if (accountBox && navbar) {
    navbar.classList.toggle("active");
    accountBox.classList.remove("active");
  }
  if (accountBoxAdmin && navbarAdmin) {
    navbarAdmin.classList.toggle("active");
    accountBoxAdmin.classList.remove("active");
  }
});
