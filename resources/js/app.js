import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

Alpine.plugin(collapse);
window.Alpine = Alpine;
Alpine.start();

gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', () => {
    const isLanding = document.body.classList.contains('portfolio-page');
    if (!isLanding) {
        return;
    }

    initSmoothScroll();
    initHeroIntro();
    initScrollReveal();
    initProjectCards();
    initProjectsParallax();
    initCursor();

    setTimeout(() => ScrollTrigger.refresh(), 120);
});

function initSmoothScroll() {
    const lenis = new Lenis({
        duration: 1.08,
        smoothWheel: true,
        wheelMultiplier: 0.95,
        touchMultiplier: 1.5,
    });

    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });
    gsap.ticker.lagSmoothing(0);

    window.__lenis = lenis;
}

function initHeroIntro() {
    if (!document.querySelector('#hero')) {
        return;
    }

    const timeline = gsap.timeline({ defaults: { ease: 'power3.out' }, delay: 0.12 });

    timeline
        .from('#hero .section-kicker', { y: 20, autoAlpha: 0, duration: 0.55 })
        .from('#hero .hero-title', { y: 34, autoAlpha: 0, duration: 0.82 }, '-=0.2')
        .from('#hero .hero-text, #hero .hero-actions', {
            y: 26,
            autoAlpha: 0,
            duration: 0.66,
            stagger: 0.1,
        }, '-=0.44')
        .from('#hero .hero-panel', { x: 36, autoAlpha: 0, duration: 0.75 }, '-=0.56')
        .from('#hero .hero-marquee', { y: 18, autoAlpha: 0, duration: 0.52 }, '-=0.2');
}

function initScrollReveal() {
    const revealItems = gsap.utils.toArray('.scroll-reveal');
    revealItems.forEach((item) => {
        if (item.closest('#hero')) {
            return;
        }

        gsap.fromTo(
            item,
            { y: 30, autoAlpha: 0 },
            {
                y: 0,
                autoAlpha: 1,
                duration: 0.8,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: item,
                    start: 'top 84%',
                    toggleActions: 'play none none none',
                    once: true,
                },
            },
        );
    });

    const revealRightItems = gsap.utils.toArray('.scroll-reveal-right');
    revealRightItems.forEach((item) => {
        if (item.closest('#hero')) {
            return;
        }

        gsap.fromTo(
            item,
            { x: 30, autoAlpha: 0 },
            {
                x: 0,
                autoAlpha: 1,
                duration: 0.8,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: item,
                    start: 'top 84%',
                    toggleActions: 'play none none none',
                    once: true,
                },
            },
        );
    });
}

function initProjectCards() {
    const cards = gsap.utils.toArray('.project-card');
    if (!cards.length) {
        return;
    }

    const isFinePointer = window.matchMedia('(pointer: fine)').matches;

    cards.forEach((card, index) => {
        const bg = card.querySelector('.project-bg');

        gsap.fromTo(
            card,
            { y: 48, autoAlpha: 0, scale: 0.93 },
            {
                y: 0,
                autoAlpha: 1,
                scale: 1,
                duration: 0.85,
                ease: 'power3.out',
                delay: index * 0.04,
                scrollTrigger: {
                    trigger: card,
                    start: 'top 86%',
                    toggleActions: 'play none none none',
                    once: true,
                },
            },
        );

        ScrollTrigger.create({
            trigger: card,
            start: 'top bottom',
            end: 'bottom top',
            onUpdate: (self) => {
                const focus = 1 - Math.abs(self.progress - 0.5) * 2;
                const scale = 0.96 + focus * 0.04;
                gsap.to(card, {
                    scale,
                    duration: 0.22,
                    ease: 'power1.out',
                    overwrite: 'auto',
                });
            },
        });

        if (!bg || !isFinePointer) {
            return;
        }

        const onMove = (event) => {
            const bounds = card.getBoundingClientRect();
            const x = ((event.clientX - bounds.left) / bounds.width - 0.5) * 2;
            const y = ((event.clientY - bounds.top) / bounds.height - 0.5) * 2;

            gsap.to(card, {
                rotateY: x * 4,
                rotateX: -y * 3,
                transformPerspective: 1000,
                transformOrigin: 'center',
                duration: 0.34,
                ease: 'power2.out',
                overwrite: 'auto',
            });

            gsap.to(bg, {
                x: x * 8,
                y: y * 8,
                filter: 'contrast(1.08) saturate(1.12)',
                duration: 0.34,
                ease: 'power2.out',
                overwrite: 'auto',
            });
        };

        const onLeave = () => {
            gsap.to(card, {
                rotateY: 0,
                rotateX: 0,
                duration: 0.46,
                ease: 'power3.out',
                overwrite: 'auto',
            });

            gsap.to(bg, {
                x: 0,
                y: 0,
                filter: 'contrast(1) saturate(1)',
                duration: 0.46,
                ease: 'power3.out',
                overwrite: 'auto',
            });
        };

        card.addEventListener('mousemove', onMove);
        card.addEventListener('mouseleave', onLeave);
    });
}

function initProjectsParallax() {
    const backgrounds = gsap.utils.toArray('.project-bg');
    backgrounds.forEach((bg) => {
        const card = bg.closest('.project-card');
        if (!card) {
            return;
        }

        gsap.fromTo(
            bg,
            { yPercent: -6, scale: 1.18 },
            {
                yPercent: 7,
                scale: 1.05,
                ease: 'none',
                scrollTrigger: {
                    trigger: card,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 0.65,
                },
            },
        );
    });
}

function initCursor() {
    if (!window.matchMedia('(pointer: fine)').matches) {
        return;
    }

    const dot = document.getElementById('cursor-dot');
    const ring = document.getElementById('cursor-ring');
    const label = document.getElementById('cursor-label');

    if (!dot || !ring) {
        return;
    }

    let mouseX = window.innerWidth * 0.5;
    let mouseY = window.innerHeight * 0.5;
    let dotX = mouseX;
    let dotY = mouseY;
    let ringX = mouseX;
    let ringY = mouseY;
    let labelX = mouseX;
    let labelY = mouseY;

    const hoverRules = [
        { selector: '.project-card', text: 'Voir' },
        { selector: '.button-primary, .button-ghost, .button-ghost-light, a, button', text: '' },
    ];

    document.addEventListener('mousemove', (event) => {
        mouseX = event.clientX;
        mouseY = event.clientY;

        let matched = null;
        for (const rule of hoverRules) {
            const target = event.target.closest(rule.selector);
            if (target) {
                matched = rule;
                break;
            }
        }

        if (matched) {
            dot.classList.add('hover');
            ring.classList.add('hover');

            if (label) {
                if (matched.text) {
                    label.textContent = matched.text;
                    label.classList.add('visible');
                } else {
                    label.classList.remove('visible');
                }
            }
            return;
        }

        dot.classList.remove('hover');
        ring.classList.remove('hover');
        if (label) {
            label.classList.remove('visible');
        }
    }, { passive: true });

    document.addEventListener('mousedown', () => {
        dot.classList.add('clicking');
        ring.classList.add('clicking');
    });

    document.addEventListener('mouseup', () => {
        dot.classList.remove('clicking');
        ring.classList.remove('clicking');
    });

    document.addEventListener('mouseleave', () => {
        dot.style.opacity = '0';
        ring.style.opacity = '0';
        if (label) {
            label.style.opacity = '0';
        }
    });

    document.addEventListener('mouseenter', () => {
        dot.style.opacity = '1';
        ring.style.opacity = '1';
        if (label) {
            label.style.opacity = '';
        }
    });

    const loop = () => {
        dotX += (mouseX - dotX) * 0.42;
        dotY += (mouseY - dotY) * 0.42;
        ringX += (mouseX - ringX) * 0.12;
        ringY += (mouseY - ringY) * 0.12;
        labelX += (mouseX - labelX) * 0.16;
        labelY += (mouseY - labelY) * 0.16;

        dot.style.left = `${dotX}px`;
        dot.style.top = `${dotY}px`;
        ring.style.left = `${ringX}px`;
        ring.style.top = `${ringY}px`;

        if (label) {
            label.style.left = `${labelX}px`;
            label.style.top = `${labelY}px`;
        }

        requestAnimationFrame(loop);
    };

    loop();
}
