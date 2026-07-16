// Position of the spray nozzle tip within the bottle photo, as a fraction of
// the image's own width/height. Tune these two numbers if you swap in a
// different bottle photo and the mist no longer lines up with the nozzle.
const ORIGIN_X_PCT = 0.49;
const ORIGIN_Y_PCT = 0.1;

const BURST_INTERVAL_MS = 3600;
const PARTICLES_PER_BURST = 90;
const SPAWN_SPREAD_MS = 350;
const CONE_HALF_ANGLE_DEG = 55;

function makeMistSprite() {
    const size = 64;
    const canvas = document.createElement('canvas');
    canvas.width = size;
    canvas.height = size;
    const ctx = canvas.getContext('2d');

    const gradient = ctx.createRadialGradient(size / 2, size / 2, 0, size / 2, size / 2, size / 2);
    gradient.addColorStop(0, 'rgba(255, 253, 245, 0.9)');
    gradient.addColorStop(0.45, 'rgba(243, 230, 195, 0.4)');
    gradient.addColorStop(1, 'rgba(212, 175, 106, 0)');

    ctx.fillStyle = gradient;
    ctx.fillRect(0, 0, size, size);

    return canvas;
}

export function initBottleSpray(canvas, heroSection, bottleImage) {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const ctx = canvas.getContext('2d');
    const sprite = makeMistSprite();

    let particles = [];
    let width = 0;
    let height = 0;
    let dpr = Math.min(window.devicePixelRatio || 1, 2);

    function resize() {
        const rect = heroSection.getBoundingClientRect();
        width = rect.width;
        height = rect.height;
        canvas.width = width * dpr;
        canvas.height = height * dpr;
        canvas.style.width = `${width}px`;
        canvas.style.height = `${height}px`;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    resize();
    window.addEventListener('resize', resize);

    function currentOrigin() {
        const heroRect = heroSection.getBoundingClientRect();
        const imgRect = bottleImage.getBoundingClientRect();

        return {
            x: imgRect.left - heroRect.left + imgRect.width * ORIGIN_X_PCT,
            y: imgRect.top - heroRect.top + imgRect.height * ORIGIN_Y_PCT,
            unit: imgRect.width,
        };
    }

    function spawnBurst() {
        const { x: originX, y: originY, unit } = currentOrigin();
        const coneRad = (CONE_HALF_ANGLE_DEG * Math.PI) / 180;

        for (let i = 0; i < PARTICLES_PER_BURST; i++) {
            const angle = -Math.PI / 2 + (Math.random() - 0.5) * coneRad * 2;
            const speed = (0.55 + Math.random() * 1.7) * unit;

            particles.push({
                x: originX,
                y: originY,
                vx: Math.cos(angle) * speed,
                vy: Math.sin(angle) * speed,
                delay: -(Math.random() * SPAWN_SPREAD_MS) / 1000,
                life: 0,
                maxLife: 1.3 + Math.random() * 1.1,
                size: (0.055 + Math.random() * 0.09) * unit,
                peakAlpha: 0.2 + Math.random() * 0.16,
                drag: 0.6 + Math.random() * 1.1,
                buoyancy: unit * (0.25 + Math.random() * 0.4),
                wobbleSeed: Math.random() * Math.PI * 2,
                wobbleSpeed: 1.8 + Math.random() * 2,
                wobbleAmp: unit * (0.05 + Math.random() * 0.08),
            });
        }

        bottleImage.classList.add('spray-press');
        setTimeout(() => bottleImage.classList.remove('spray-press'), 140);
    }

    let lastTime = performance.now();
    let lastBurst = -BURST_INTERVAL_MS;
    let frameId = null;
    let visible = true;

    function step(now) {
        if (!visible) return;
        frameId = requestAnimationFrame(step);

        const dt = Math.min((now - lastTime) / 1000, 0.05);
        lastTime = now;

        if (now - lastBurst >= BURST_INTERVAL_MS) {
            lastBurst = now;
            spawnBurst();
        }

        ctx.clearRect(0, 0, width, height);
        ctx.globalCompositeOperation = 'lighter';

        particles = particles.filter((p) => p.delay + p.life < p.maxLife);

        for (const p of particles) {
            p.delay += dt;
            if (p.delay < 0) continue;

            p.life += dt;
            const t = Math.min(p.life / p.maxLife, 1);

            const dragFactor = 1 - Math.min(dt * p.drag, 1);
            p.vx *= dragFactor;
            p.vy *= dragFactor;
            p.vy -= p.buoyancy * dt;

            p.x += p.vx * dt + Math.sin(p.life * p.wobbleSpeed + p.wobbleSeed) * p.wobbleAmp * dt;
            p.y += p.vy * dt;

            const fadeIn = Math.min(t / 0.12, 1);
            const fadeOut = 1 - Math.max((t - 0.45) / 0.55, 0);
            const opacity = Math.max(Math.min(fadeIn, fadeOut), 0) * p.peakAlpha;
            const scale = 0.7 + t * 2.1;
            const drawSize = p.size * scale;

            ctx.globalAlpha = opacity;
            ctx.drawImage(sprite, p.x - drawSize / 2, p.y - drawSize / 2, drawSize, drawSize);
        }

        ctx.globalAlpha = 1;
        ctx.globalCompositeOperation = 'source-over';
    }

    document.addEventListener('visibilitychange', () => {
        visible = document.visibilityState === 'visible';
        if (visible && !prefersReducedMotion) {
            lastTime = performance.now();
            frameId = requestAnimationFrame(step);
        }
    });

    if (!prefersReducedMotion) {
        frameId = requestAnimationFrame(step);
    }

    return () => {
        cancelAnimationFrame(frameId);
        window.removeEventListener('resize', resize);
    };
}
