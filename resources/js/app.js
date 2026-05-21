import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const nav = document.getElementById('main-nav');
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const menuClose = document.getElementById('menu-close');

    const toggleMenu = (open) => {
        mobileMenu?.classList.toggle('hidden', !open);
        menuIcon?.classList.toggle('hidden', open);
        menuClose?.classList.toggle('hidden', !open);
        menuBtn?.setAttribute('aria-expanded', String(open));
    };

    menuBtn?.addEventListener('click', () => {
        const isOpen = mobileMenu?.classList.contains('hidden');
        toggleMenu(isOpen);
    });

    mobileMenu?.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => toggleMenu(false));
    });

    const scrolledClass = 'nav-scrolled';

    const updateNav = () => {
        if (!nav) return;
        const scrolled = window.scrollY > 20;
        nav.classList.toggle('shadow-md', scrolled);
        nav.classList.toggle('bg-white/95', scrolled);
        nav.classList.toggle('backdrop-blur-md', scrolled);
        nav.classList.toggle('bg-transparent', !scrolled);
        nav.classList.toggle(scrolledClass, scrolled);
    };

    window.addEventListener('scroll', updateNav);
    updateNav();

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-6');
                }
            });
        },
        { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
    );

    document.querySelectorAll('[data-reveal]').forEach((el) => observer.observe(el));
});
