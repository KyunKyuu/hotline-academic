import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

window.Alpine = Alpine;

Alpine.plugin(collapse);

Alpine.data('siteNav', () => ({
    open: false,
    scrolled: false,
    init() {
        this.scrolled = window.scrollY > 12;
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 12;
        }, { passive: true });
    },
    close() {
        this.open = false;
    },
}));

Alpine.data('tabSwitcher', (initial = 0) => ({
    active: initial,
    isActive(index) {
        return this.active === index;
    },
}));

Alpine.data('accordionGroup', (initial = null) => ({
    openIndex: initial,
    toggle(index) {
        this.openIndex = this.openIndex === index ? null : index;
    },
    isOpen(index) {
        return this.openIndex === index;
    },
}));

Alpine.start();

function initScrollReveal() {
    const targets = document.querySelectorAll('[data-reveal]');

    if (!('IntersectionObserver' in window) || targets.length === 0) {
        targets.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
    );

    targets.forEach((el) => observer.observe(el));
}

function initScrollProgress() {
    const bar = document.getElementById('scroll-progress');
    if (!bar) return;

    const update = () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const ratio = docHeight > 0 ? scrollTop / docHeight : 0;
        bar.style.transform = `scaleX(${Math.min(1, Math.max(0, ratio))})`;
    };

    update();
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
}

document.addEventListener('DOMContentLoaded', () => {
    initScrollReveal();
    initScrollProgress();
});
