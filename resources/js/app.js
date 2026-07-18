const menuToggle = document.getElementById('menu-toggle');
const mobileMenu = document.getElementById('mobile-menu');
const bar1 = document.getElementById('menu-bar-1');
const bar2 = document.getElementById('menu-bar-2');
const bar3 = document.getElementById('menu-bar-3');

function setMenuOpen(isOpen) {
    menuToggle.setAttribute('aria-expanded', String(isOpen));
    mobileMenu.classList.toggle('hidden', !isOpen);

    bar1.style.transform = isOpen ? 'translateY(6px) rotate(45deg)' : 'none';
    bar2.style.opacity = isOpen ? '0' : '1';
    bar3.style.transform = isOpen ? 'translateY(-6px) rotate(-45deg)' : 'none';
}

if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', () => {
        setMenuOpen(menuToggle.getAttribute('aria-expanded') !== 'true');
    });

    mobileMenu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setMenuOpen(false));
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            setMenuOpen(false);
        }
    });
}

const bottleSprayCanvas = document.getElementById('bottle-spray');
const heroSection = document.getElementById('hero-section');
const bottleImage = document.getElementById('hero-bottle-image');

if (bottleSprayCanvas && heroSection && bottleImage) {
    import('./bottle-spray.js').then(({ initBottleSpray }) => {
        initBottleSpray(bottleSprayCanvas, heroSection, bottleImage);
    });
}

if (document.querySelector('.stat-counter')) {
    import('./stat-counters.js').then(({ initStatCounters }) => {
        initStatCounters();
    });
}

const searchToggle = document.getElementById('search-toggle');
const searchBar = document.getElementById('search-bar');

if (searchToggle && searchBar) {
    searchToggle.addEventListener('click', () => {
        const isOpen = searchToggle.getAttribute('aria-expanded') === 'true';
        searchToggle.setAttribute('aria-expanded', String(!isOpen));
        searchBar.classList.toggle('hidden', isOpen);

        if (!isOpen) {
            searchBar.querySelector('input')?.focus();
        }
    });
}

if (document.getElementById('checkout-form')) {
    import('./checkout-payment.js').then(({ initCheckoutPayment }) => {
        initCheckoutPayment();
    });
}
