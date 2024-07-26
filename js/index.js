function updateCountdown() {
  const targetDate = new Date("2023-12-21T15:00:00").getTime();
  const now = new Date().getTime();
  const distance = targetDate - now;

  if (distance <= 0) {
    document.getElementById("countdown").innerHTML = "Kết thúc";
    return;
  }

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor(
    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
  );
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  const countdownString = `${days} : ${hours} : ${minutes} : ${seconds}`;

  document.getElementById("countdown").innerHTML = countdownString;
  document.getElementById("countdown").style.fontSize = "20px";
  document.getElementById("countdown").style.fontWeight = "bold";
  document.getElementById("countdown").style.color = "#63666b";
}

setInterval(updateCountdown, 1000);

function gh() {
  var inputPassword = document.querySelectorAll("password");
  if (inputPassword.type == "password") {
    inputPassword.type = "text";
  } else {
    inputPassword.type = "password";
  }
}
