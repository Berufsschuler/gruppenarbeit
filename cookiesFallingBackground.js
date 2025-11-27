const canvas = document.getElementById("canvas1");
const ctx = canvas.getContext("2d");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const particleAmount = 500;
const particleHolder = [];

// Bild laden
const img = new Image();
img.src = "img/CookieBreh.png";

window.addEventListener("resize", function(){
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

// ------------------------------
// Particle-Klasse
// ------------------------------
class Particle {
    constructor(){
        this.reset();
    }

    reset(){
        this.x = Math.random() * canvas.width;  
        this.y = -550;
        this.size = Math.random() < 0.5 ? 20 : 40; // Bildgröße statt Kreisgröße
        this.speedX = 0;
        this.speedY = Math.random() * 1.5 + 1.5;
    }

    update(){
        this.x += this.speedX;
        this.y += this.speedY;

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
    ctx.clearRect(0,0, canvas.width,canvas.height);
    particleControl();
    requestAnimationFrame(animate);
}
animate();
