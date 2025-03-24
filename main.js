let header = document.querySelector('header');
let menu = document.querySelector('.menu-icon');
let navbar = document.querySelector('.navbar');

window.addEventListener('scroll', () => {
    header.classList.toggle('active', window.scrollY > 0);
});
menu.onclick = () => {
    navbar.classList.toggle('active')
}
window.onscroll = () =>{
    navbar.classList.remove('active')
}
//mode
var mode = document.getElementById("mode");
mode.onclick = function() {
    document.body.classList.toggle("dark-theme");
    if (document.body.classList.contains("dark-theme")) {
        mode.classList.remove("ri-moon-line");
        mode.classList.add("ri-sun-line");
    } else {
        mode.classList.remove("ri-sun-line");
        mode.classList.add("ri-moon-line");
    }
}

// Carousel
const carousel = document.querySelector(".carousel");
const arrowBtns = document.querySelectorAll(".wrapper i");
const firstCardWidth = carousel.querySelector(".card").offsetWidth;
const carouselChildren = [...carousel.children];

let isDragging = false, startX, startScrollLeft;

let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);

carouselChildren.slice(-cardPerView).reverse().forEach(card => {
    carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
});

carouselChildren.slice(0, cardPerView).forEach(card => {
    carousel.insertAdjacentHTML("beforeend", card.outerHTML);
});

arrowBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        carousel.scrollLeft += btn.classList.contains("ri-skip-left-fill") ? -firstCardWidth : firstCardWidth;
    });
});

const dragStart = (e) => {
    isDragging = true;
    carousel.classList.add("dragging");
    startX = e.pageX;
    startScrollLeft = carousel.scrollLeft;
};

const dragging = (e) => {
    if (!isDragging) return;
    e.preventDefault();
    const x = e.pageX - startX;
    carousel.scrollLeft = startScrollLeft - x;
};

const dragStop = () => {
    isDragging = false;
    carousel.classList.remove("dragging");
};

const infiniteScroll = () => {
    if (carousel.scrollLeft === 0) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
        carousel.classList.remove("no-transition");
    } else if (Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.offsetWidth;
        carousel.classList.remove("no-transition");
    }
};

carousel.addEventListener("mousedown", dragStart);
carousel.addEventListener("mousemove", dragging);
document.addEventListener("mouseup", dragStop);
carousel.addEventListener("scroll", infiniteScroll);

//Mouse Fire Emoji
const canvas = document.querySelector("#canvas");
const ctx = canvas.getContext("2d");

let fireImage = new Image();
fireImage.src = "Asset/fire.201x256.png";

let w, h, fire = [];
let mouse = { x: undefined, y: undefined };

function init() {
    resizeReset();
    animationLoop();
}

function resizeReset() {
    w = canvas.width = window.innerWidth;
    h = canvas.height = window.innerHeight;
}

function animationLoop() {
    ctx.clearRect(0, 0, w, h);
    ctx.globalCompositeOperation = 'lighter';
    drawFire();

    let temp = [];
    for (let i = 0; i < fire.length; i++) {
        if (fire[i].time <= fire[i].ttl) {
            temp.push(fire[i]);
        }
    }
    fire = temp;

    requestAnimationFrame(animationLoop);
}

function drawFire() {
    for (let i = 0; i < fire.length; i++) {
        fire[i].update();
        fire[i].draw();
    }
}

function mousemove(e) {
    mouse.x = e.x;
    mouse.y = e.y;

    fire.push(new Fire());
}

function mouseout() {
    mouse.x = undefined;
    mouse.y = undefined;
}

function getRandomInt(min, max) {
    return Math.round(Math.random() * (max - min)) + min;
}

function easeOutQuart(x) {
    return 1 - Math.pow(1 - x, 4);
}

class Fire {
    constructor() {
        this.start = {
            x: mouse.x + getRandomInt(-20, 20),
            y: mouse.y + getRandomInt(-20, 20),
            size: fireImage.width * 0.3
        }
        this.end = {
            x: this.start.x + getRandomInt(-200, 200),
            y: this.start.y + getRandomInt(-600, -400)
        }

        this.x = this.start.x;
        this.y = this.start.y;
        this.size = this.start.size;

        this.time = 0;
        this.ttl = 180;
    }
    draw() {
        ctx.drawImage(fireImage, this.x - this.size / 2, this.y - this.size / 2, this.size, this.size);
    }
    update() {
        if (this.time <= this.ttl) {
            let progress = 1 - (this.ttl - this.time) / this.ttl;

            this.size = this.start.size * (1 - easeOutQuart(progress));
            this.x = this.x + (this.end.x - this.x) * 0.005;
            this.y = this.y + (this.end.y - this.y) * 0.005;
        }
        this.time++;
    }
}

window.addEventListener("DOMContentLoaded", init);
window.addEventListener("resize", resizeReset);
window.addEventListener("mousemove", mousemove);
window.addEventListener("mouseout", mouseout);

// --- Kode AJAX untuk form kontak ---

document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const loading = document.getElementById('loading');
    const notification = document.getElementById('notification');
  
    if (contactForm) {
      contactForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Cegah form submit default (reload halaman)
  
        // Tampilkan loading indicator dan sembunyikan notifikasi
        loading.style.display = 'block';
        notification.style.display = 'none';
  
        // Ambil data form menggunakan FormData
        const formData = new FormData(contactForm);
  
        // Kirim data ke server via fetch (AJAX) ke file submitContact.php
        fetch('submitContact.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          // Sembunyikan loading indicator
          loading.style.display = 'none';
  
          // Tampilkan notifikasi
          notification.style.display = 'block';
          if (data.status === 'success') {
            // Feedback visual hijau untuk sukses
            notification.style.backgroundColor = '#d4edda';
            notification.style.color = '#155724';
            notification.innerText = data.message;
  
            // Reset form setelah sukses
            contactForm.reset();
          } else {
            // Feedback visual merah untuk error
            notification.style.backgroundColor = '#f8d7da';
            notification.style.color = '#721c24';
            notification.innerText = data.message;
          }
        })
        .catch(error => {
          // Sembunyikan loading indicator dan tampilkan error jika terjadi kesalahan
          loading.style.display = 'none';
          notification.style.display = 'block';
          notification.style.backgroundColor = '#f8d7da';
          notification.style.color = '#721c24';
          notification.innerText = 'Terjadi kesalahan: ' + error;
        });
      });
    }
  });
  