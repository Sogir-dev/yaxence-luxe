function easeOutExpo(x) {
    return x === 1 ? 1 : 1 - Math.pow(2, -10 * x);
}

function animateCounter(el) {
    const target = parseFloat(el.dataset.target || '0');
    const decimals = parseInt(el.dataset.decimals || '0', 10);
    const suffix = el.dataset.suffix || '';
    const duration = 1600;
    const start = performance.now();

    function frame(now) {
        const progress = Math.min((now - start) / duration, 1);
        const value = target * easeOutExpo(progress);
        el.textContent = value.toFixed(decimals) + suffix;

        if (progress < 1) {
            requestAnimationFrame(frame);
        } else {
            el.textContent = target.toFixed(decimals) + suffix;
        }
    }

    requestAnimationFrame(frame);
}

export function initStatCounters() {
    const counters = document.querySelectorAll('.stat-counter');

    if (counters.length === 0) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        counters.forEach((el) => {
            const target = parseFloat(el.dataset.target || '0');
            const decimals = parseInt(el.dataset.decimals || '0', 10);
            const suffix = el.dataset.suffix || '';
            el.textContent = target.toFixed(decimals) + suffix;
        });
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.4 }
    );

    counters.forEach((el) => observer.observe(el));
}
