  const cookie = document.getElementById("tryCookie");
  const counterDisplay = document.getElementById("tryCookieCounter");

  cookie.addEventListener("click", function () {
    fetch("update.php", { method: "POST" })
      .then(response => response.text())
      .then(newCount => {
        counterDisplay.textContent = "Counter: " + newCount;
      });
  });