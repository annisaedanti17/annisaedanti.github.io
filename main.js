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
