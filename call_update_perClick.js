
const cookie = document.getElementById("mainCookiepng");
const counterDisplay = document.getElementById("mainCookieCounter");

cookie.addEventListener("click", function(){
    fetch("update_user_counter.php")
    .then(res => res.text())  
    .then(data => counterDisplay.textContent = data);



    //animation cookie click
    const rect = cookie.getBoundingClientRect();

    // Neues div erstellen
    const floatingCookie = document.createElement("div");
    floatingCookie.style.position = "fixed";
    floatingCookie.style.left = rect.left + rect.width / 2 + "px";
    floatingCookie.style.top = rect.top + rect.height / 2 + "px";
    floatingCookie.style.transform = "translate(-50%, -50%)";
    floatingCookie.style.pointerEvents = "none";
    floatingCookie.style.width = "100px";
    floatingCookie.style.height = "100px";
    floatingCookie.style.zIndex = 9999;
    floatingCookie.style.transition = "all 2s ease-out";

    // Bild einfügen
    const img = document.createElement("img");
    img.src = "img/cookie_1.png"; // Pfad zu deinem Bild
    img.style.width = "100%";
    img.style.height = "100%";
    floatingCookie.appendChild(img);

    document.body.appendChild(floatingCookie);

    // Zufällige Richtung in 360 Grad
    const angle = Math.random() * 2 * Math.PI; // 0 bis 2π
    const distance = Math.random() * 80 + 1050; // wie weit der Cookie fliegt
    const xMove = Math.cos(angle) * distance;
    const yMove = Math.sin(angle) * distance;

    // Animation starten
    requestAnimationFrame(() => {
        floatingCookie.style.transform = `translate(${xMove}px, ${yMove}px)`;
        floatingCookie.style.opacity = 0;
    });
});