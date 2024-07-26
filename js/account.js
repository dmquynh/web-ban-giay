var lock = document.querySelector(".bxs-lock-alt");
var icon = document.getElementById("icon");
var password = document.getElementById("password");
var icon1 = document.getElementById("icon1");
var password1 = document.getElementById("password1");
lock.addEventListener("click", function () {
  if (password.type == "password") {
    password.type = "text";
    icon.classList.add("bxs-lock-open-alt");
  } else {
    password.type = "password";
    icon.classList.remove("bxs-lock-open-alt");
  }
});

lock.addEventListener("click", function () {
  if (password1.type == "password") {
    password1.type = "text";
    icon1.classList.add("bxs-lock-open-alt");
  } else {
    password1.type = "password";
    icon1.classList.remove("bxs-lock-open-alt");
  }
});
