const cookie = document.getElementById("cookie");
const counterDisplay = document.getElementById("counterName");

cookie.addEventListener("click", function(){
    fetch("update_user_counter.php")
    .then(res => res.text())  
    .then(data => counterDisplay.textContent = data);
});