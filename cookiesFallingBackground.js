const canvas = document.getElementById("canvas1");
const ctx = canvas.getContext("2d");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const particleAmount = 300;
const particleHolder = [];

// Bild laden
const img = new Image();
img.src = "img/CookieBreh.png";

// Fenstergröße anpassen
window.addEventListener("resize", function(){
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

// ------------------------------
// Particle-Klasse
// ------------------------------
class Particle {
    constructor(){
        this.reset(true); // beim ersten Mal gleichmäßig verteilt starten
    }

    reset(initial = false){
        this.x = Math.random() * canvas.width;
        this.size = Math.random() < 0.5 ? 20 : 40; 
        this.speedX = 0;
        this.speedY = Math.random() * 1.5 + 1.5;

        if(initial){
            // Zufällige Y-Position für gleichmäßige Startverteilung
            this.y = Math.random() * canvas.height;
        } else {
            // Normaler Reset: oben starten
            this.y = -this.size;
        }
    }

    update(){
        this.x += this.speedX;
        this.y += this.speedY;

        // Wenn unten, wieder oben starten
        if (this.y > canvas.height) {
            this.reset();
        }
    }

    draw(){
        if (img.complete) {
            ctx.drawImage(img, this.x, this.y, this.size, this.size);
        }
    }
}

// ------------------------------
// Partikel erzeugen
// ------------------------------
function createParticle(){
    for(let i = 0; i < particleAmount; i++){
        particleHolder.push(new Particle());
    }
}
createParticle();

// ------------------------------
// Kontrolle / Zeichnen
// ------------------------------
function particleControl(){
    for(let i = 0; i < particleHolder.length; i++){
        particleHolder[i].update();
        particleHolder[i].draw();
    }
}

// ------------------------------
// Animation
// ------------------------------
function animate(){
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particleControl();
    requestAnimationFrame(animate);
}
animate();
