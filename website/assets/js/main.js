jQuery(document).ready(function($) {

   if ($('.ds-testimonials-section').length) {
		$('.ds-testimonials-slider').slick({
		  	infinite: true,
		  	arrows: true,
		  	autoplay: true,
		  	autoplaySpeed: 4000,
		  	prevArrow:"<button type='button' class='slick-prev slick-arrow'><i class='ri-arrow-left-line'></i></button>",
		  	nextArrow:"<button type='button' class='slick-next slick-arrow'><i class='ri-arrow-right-line'></i></button>"
		});
    }
   

});
const container = document.querySelector('.container');

function createRandomSquare() {
    const square = document.createElement('div');
    square.classList.add('square');

    if (window.innerWidth <= 768) { // Adjust this breakpoint as needed
        maxX = window.innerWidth - 50; // Adjust the size of the squares
        maxY = window.innerHeight - 50; // Adjust the size of the squares
    } else {
        maxX = window.innerWidth - 100; // Adjust the size of the squares
        maxY = window.innerHeight - 100; // Adjust the size of the squares
    }
    const randomX = Math.random() * maxX;
    const randomY = Math.random() * maxY;

    square.style.left = randomX + 'px';
    square.style.top = randomY + 'px';

    container.appendChild(square);

    // Remove the square after the animation duration (3s)
    setTimeout(() => {
        container.removeChild(square);
    }, 2000);
}

// Create a new square every 2 seconds (adjust the interval as needed)
setInterval(createRandomSquare, 200);

// SCROLLLLLLYY

const imageShadow = document.querySelector('.ds-image-shadow');
let lastScrollTop = 0;
let isScrolling = false;

function updateShadow() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop) {
        // Scrolling down
        imageShadow.style.boxShadow = `35px -20px #c7f900`;
    } else if (scrollTop < lastScrollTop) {
        // Scrolling up
        imageShadow.style.boxShadow = `35px 20px #c7f900`;
    }

    lastScrollTop = scrollTop;

    if (isScrolling) {
        requestAnimationFrame(updateShadow);
    }
}

window.addEventListener('scroll', () => {
    isScrolling = true;
    requestAnimationFrame(updateShadow);
});

// Add a timeout to stop updating the shadow when not scrolling
let scrollTimeout;

window.addEventListener('scroll', () => {
    isScrolling = true;
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(() => {
        isScrolling = false;
    }, 200); // Adjust the timeout value as needed
});

