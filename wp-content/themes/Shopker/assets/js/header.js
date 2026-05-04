console.log('header.js loaded');

// Wait for DOM to be ready
function domReady(cb) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', cb);
    } else {
        cb();
    }
}

domReady(function() {
    console.log('DOM is ready, initializing header');

    // ===== PROMO SLIDER =====
    const slides = document.querySelectorAll('.promo-slide');
    const totalSlides = slides.length;
    const indicators = document.querySelectorAll('.indicator-dot');
    const wrapper = document.querySelector('.promo-slider-wrapper');
    
    if (wrapper && totalSlides > 1) {
        console.log('Initializing promo slider with', totalSlides, 'slides');
        let currentSlide = 0;

        function updateSlide() {
            wrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
            indicators.forEach((dot, index) => {
                if (index === currentSlide) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        // Auto advance every 5 seconds
        setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlide();
        }, 5000);

        // Click indicators
        indicators.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                updateSlide();
            });
        });
    }

    // ===== MOBILE MENU =====
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const mobileNav = document.getElementById('mobile-nav');
    const bodyElement = document.body;

    if (menuToggle && mobileNav) {
        console.log('Initializing mobile menu');

        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Menu toggle clicked');
            
            mobileNav.classList.toggle('active');
            menuToggle.classList.toggle('active');
            
            if (mobileNav.classList.contains('active')) {
                bodyElement.style.overflow = 'hidden';
                console.log('Menu opened');
            } else {
                bodyElement.style.overflow = 'auto';
                console.log('Menu closed');
            }
        });

        // Close menu when link is clicked
        const navLinks = mobileNav.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileNav.classList.remove('active');
                menuToggle.classList.remove('active');
                bodyElement.style.overflow = 'auto';
                console.log('Menu closed via link click');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = mobileNav.contains(event.target) || menuToggle.contains(event.target);
            if (!isClickInside && mobileNav.classList.contains('active')) {
                mobileNav.classList.remove('active');
                menuToggle.classList.remove('active');
                bodyElement.style.overflow = 'auto';
                console.log('Menu closed via outside click');
            }
        });
    } else {
        console.log('Menu toggle or nav not found', { menuToggle, mobileNav });
    }

    // ===== CART =====
    const cartIcon = document.getElementById('shopker-cart-icon');
    if (cartIcon) {
        console.log('Initializing cart icon');
        cartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            if (typeof openCartSidebar === 'function') {
                openCartSidebar();
            }
        });
    }
});
