document.addEventListener('DOMContentLoaded', () => {

    let lastScroll = 0;
    const nav = document.querySelector("nav");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 50) {
            nav?.classList.add("scrolled");
        } else {
            nav?.classList.remove("scrolled");
        }
        lastScroll = window.scrollY;
    });

    // Maps your clean URLs like '/patches' or '/gallery' to highlight the navigation links
    document.querySelectorAll(".nav-link").forEach((link) => {
        const pathName = window.location.pathname.toLowerCase();
        const linkText = link.textContent.trim().toLowerCase();
        
        if (pathName.includes(linkText) || (linkText === 'home' && pathName === '/')) {
            link.classList.add("active");
        }
    });

    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', (e) => {
            e.stopPropagation(); 
            mobileMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!menuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    }
});