document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    function revealAllElements() {
        document.querySelectorAll('.gsap-reveal, .gsap-fade-up, .gsap-zoom-in, .gsap-stagger-item, .infra-stagger-item, .why-stagger-item').forEach(el => {
            el.style.visibility = 'visible';
            el.style.opacity = '1';
        });
    }

    // Ensure GSAP and ScrollTrigger are loaded
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
        console.warn('GSAP or ScrollTrigger is not loaded.');
        revealAllElements();
        return;
    }

    try {
        gsap.registerPlugin(ScrollTrigger);
    } catch (e) {
        console.error('GSAP plugin registration failed:', e);
        revealAllElements();
        return;
    }

    // Helper for safe animations
    function safeFromTo(targets, fromVars, toVars) {
        if (!targets) return;
        if (typeof targets === 'string') {
            const els = document.querySelectorAll(targets);
            if (!els.length) return;
            targets = els;
        } else if (targets instanceof Element) {
            targets = [targets];
        } else if (targets instanceof NodeList || Array.isArray(targets)) {
            if (!targets.length) return;
        }
        try {
            gsap.fromTo(targets, fromVars, toVars);
        } catch (err) {
            console.warn('GSAP animation error:', err);
        }
    }

    // ==========================================
    // 1. Hero Section Animations & Parallax
    // ==========================================
    try {
        const heroWrapper = document.getElementById('hero-wrapper');
        if (heroWrapper) {
            if (document.querySelector('.hero-deco-top')) {
                gsap.to('.hero-deco-top', {
                    yPercent: 20,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: heroWrapper,
                        start: 'top top',
                        end: 'bottom top',
                        scrub: true
                    }
                });
            }

            if (document.querySelector('.hero-deco-bottom')) {
                gsap.to('.hero-deco-bottom', {
                    yPercent: -20,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: heroWrapper,
                        start: 'top top',
                        end: 'bottom top',
                        scrub: true
                    }
                });
            }
        }
    } catch (e) { console.warn('Hero GSAP error:', e); }

    // ==========================================
    // 2. About Section Animations
    // ==========================================
    try {
        const aboutSection = document.getElementById('about');
        if (aboutSection) {
            const aboutImg = aboutSection.querySelector('.about-img-parallax');
            if (aboutImg) {
                gsap.set(aboutImg, { scale: 1.15 });
                gsap.to(aboutImg, {
                    yPercent: 15,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: aboutSection,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: true
                    }
                });
            }

            const visualBox = aboutSection.querySelector('.group');
            if (visualBox) {
                safeFromTo(visualBox, 
                    { autoAlpha: 0, x: -50 },
                    {
                        autoAlpha: 1, x: 0, duration: 1, ease: 'power3.out',
                        scrollTrigger: {
                            trigger: aboutSection,
                            start: 'top 75%'
                        }
                    }
                );
            }

            const fadeUpItems = aboutSection.querySelectorAll('.gsap-fade-up');
            if (fadeUpItems.length) {
                safeFromTo(fadeUpItems,
                    { autoAlpha: 0, y: 30 },
                    {
                        autoAlpha: 1, y: 0, duration: 0.8, stagger: 0.15, ease: 'power3.out',
                        scrollTrigger: {
                            trigger: aboutSection,
                            start: 'top 70%'
                        }
                    }
                );
            }
        }
    } catch (e) { console.warn('About GSAP error:', e); }

    // ==========================================
    // 3. Infrastructure Section Animations
    // ==========================================
    try {
        const infraSection = document.getElementById('infrastructure');
        if (infraSection) {
            const header = infraSection.querySelector('header.gsap-fade-up');
            if (header) {
                safeFromTo(header,
                    { autoAlpha: 0, y: 30 },
                    {
                        autoAlpha: 1, y: 0, duration: 0.8, ease: 'power3.out',
                        scrollTrigger: {
                            trigger: infraSection,
                            start: 'top 80%'
                        }
                    }
                );
            }

            const infraBg = infraSection.querySelector('.infra-bg-parallax');
            if (infraBg) {
                gsap.set(infraBg, { scale: 1.1 });
                gsap.to(infraBg, {
                    yPercent: 10,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: infraSection,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: true
                    }
                });
            }

            const infraItems = infraSection.querySelectorAll('.infra-stagger-item');
            if (infraItems.length > 0) {
                safeFromTo(infraItems,
                    { autoAlpha: 0, y: 40 },
                    {
                        autoAlpha: 1, y: 0, duration: 0.8, stagger: 0.15, ease: 'power3.out',
                        scrollTrigger: {
                            trigger: infraSection,
                            start: 'top 80%'
                        }
                    }
                );
            }
        }
    } catch (e) { console.warn('Infra GSAP error:', e); }

    // ==========================================
    // 4. Products Section Animations
    // ==========================================
    try {
        const productsSection = document.querySelector('.products-section');
        if (productsSection) {
            const pFade = productsSection.querySelectorAll('.gsap-fade-up');
            if (pFade.length) {
                safeFromTo(pFade,
                    { autoAlpha: 0, y: 40 },
                    {
                        autoAlpha: 1, y: 0, duration: 0.8, stagger: 0.15, ease: 'power3.out',
                        scrollTrigger: {
                            trigger: productsSection,
                            start: 'top 75%'
                        }
                    }
                );
            }
        }
    } catch (e) { console.warn('Products GSAP error:', e); }

    // ==========================================
    // 5. Gallery Section Animations
    // ==========================================
    try {
        const gallerySection = document.querySelector('#gallery-accordion')?.closest('section');
        if (gallerySection) {
            const gFade = gallerySection.querySelectorAll('.gsap-fade-up');
            if (gFade.length) {
                safeFromTo(gFade,
                    { autoAlpha: 0, y: 40 },
                    {
                        autoAlpha: 1, y: 0, duration: 0.8, stagger: 0.2, ease: 'power3.out',
                        scrollTrigger: {
                            trigger: gallerySection,
                            start: 'top 75%'
                        }
                    }
                );
            }
        }
    } catch (e) { console.warn('Gallery GSAP error:', e); }

    // ==========================================
    // 6. Why Choose Us Animations
    // ==========================================
    try {
        const whyStaggerItems = document.querySelectorAll('.why-stagger-item');
        if (whyStaggerItems.length > 0) {
            const whySection = whyStaggerItems[0].closest('section');
            if (whySection) {
                const wFade = whySection.querySelectorAll('.gsap-fade-up');
                if (wFade.length) {
                    safeFromTo(wFade,
                        { autoAlpha: 0, y: 30 },
                        {
                            autoAlpha: 1, y: 0, duration: 0.8, ease: 'power3.out',
                            scrollTrigger: {
                                trigger: whySection,
                                start: 'top 80%'
                            }
                        }
                    );
                }
                safeFromTo(whyStaggerItems,
                    { autoAlpha: 0, x: -30 },
                    {
                        autoAlpha: 1, x: 0, duration: 0.6, stagger: 0.15, ease: 'power3.out',
                        scrollTrigger: {
                            trigger: whySection,
                            start: 'top 80%'
                        }
                    }
                );
            }
        }
    } catch (e) { console.warn('Why Choose Us GSAP error:', e); }

    // ==========================================
    // 7. News Section Animations
    // ==========================================
    try {
        const newsSection = document.querySelector('.news-swiper-container')?.closest('section');
        if (newsSection) {
            const nFade = newsSection.querySelectorAll('.gsap-fade-up');
            if (nFade.length) {
                safeFromTo(nFade,
                    { autoAlpha: 0, y: 30 },
                    {
                        autoAlpha: 1, y: 0, duration: 0.8, stagger: 0.2, ease: 'power3.out',
                        scrollTrigger: {
                            trigger: newsSection,
                            start: 'top 80%'
                        }
                    }
                );
            }
        }
    } catch (e) { console.warn('News GSAP error:', e); }

    // ==========================================
    // 8. Testimonials Section Animations
    // ==========================================
    try {
        const testiSection = document.querySelector('.comment-swiper')?.closest('section');
        if (testiSection) {
            const tFade = testiSection.querySelectorAll('.gsap-fade-up');
            if (tFade.length) {
                safeFromTo(tFade,
                    { autoAlpha: 0, y: 30 },
                    {
                        autoAlpha: 1, y: 0, duration: 0.8, stagger: 0.2, ease: 'power3.out',
                        scrollTrigger: {
                            trigger: testiSection,
                            start: 'top 80%'
                        }
                    }
                );
            }
            
            const testiBg = testiSection.querySelector('.testi-bg-parallax');
            if (testiBg) {
                gsap.set(testiBg, { scale: 1.15 });
                gsap.to(testiBg, {
                    yPercent: 15,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: testiSection,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: true
                    }
                });
            }
        }
    } catch (e) { console.warn('Testimonials GSAP error:', e); }

    // ==========================================
    // 9. Features Marquee Animations
    // ==========================================
    try {
        const marqueeSection = document.querySelector('.animate-marquee')?.closest('section');
        if (marqueeSection) {
            safeFromTo(marqueeSection,
                { autoAlpha: 0 },
                {
                    autoAlpha: 1, duration: 1.2, ease: 'power2.inOut',
                    scrollTrigger: {
                        trigger: marqueeSection,
                        start: 'top 95%'
                    }
                }
            );
        }
    } catch (e) { console.warn('Marquee GSAP error:', e); }

    // Refresh ScrollTrigger and safety fallback
    window.addEventListener('load', () => {
        try {
            ScrollTrigger.refresh();
        } catch (e) {}
        setTimeout(revealAllElements, 800);
    });

});
