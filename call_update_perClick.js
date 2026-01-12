
const cookie = document.getElementById("mainCookiepng");
const counterDisplay = document.getElementById("mainCookieCounter");

cookie.addEventListener("click", function(){
    fetch("update_user_counter.php")
    .then(res => res.text())  
    .then(data => counterDisplay.textContent = data);
});