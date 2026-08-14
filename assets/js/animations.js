document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    // Ensure GSAP and ScrollTrigger are loaded
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
        console.warn('GSAP or ScrollTrigger is not loaded.');
        return;
    }

    gsap.registerPlugin(ScrollTrigger);

    // ==========================================
    // 1. Hero Section Animations & Parallax
    // ==========================================
    const heroWrapper = document.getElementById('hero-wrapper');
    if (heroWrapper) {
        // Parallax for decorative top-right image
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

        // Parallax for decorative bottom-left image
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

    // ==========================================
    // 2. About Section Animations
    // ==========================================
    const aboutSection = document.getElementById('about');
    if (aboutSection) {
        // Image Parallax Effect
        gsap.set('.about-img-parallax', { scale: 1.15 });
        gsap.to('.about-img-parallax', {
            yPercent: 15,
            ease: 'none',
            scrollTrigger: {
                trigger: aboutSection,
                start: 'top bottom',
                end: 'bottom top',
                scrub: true
            }
        });

        // Left Visual Container Entrance
        gsap.fromTo(aboutSection.querySelector('.group.w-\\[432px\\]'), 
            { autoAlpha: 0, x: -50 },
            {
                autoAlpha: 1, x: 0, duration: 1, ease: 'power3.out',
                scrollTrigger: {
                    trigger: aboutSection,
                    start: 'top 75%'
                }
            }
        );

        // Staggered Text Entrance
        gsap.fromTo(aboutSection.querySelectorAll('.gsap-fade-up'),
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

    // ==========================================
    // 3. Infrastructure Section Animations
    // ==========================================
    const infraSection = document.getElementById('infrastructure');
    if (infraSection) {
        // Section Header Fade Up
        gsap.fromTo(infraSection.querySelector('header.gsap-fade-up'),
            { autoAlpha: 0, y: 30 },
            {
                autoAlpha: 1, y: 0, duration: 0.8, ease: 'power3.out',
                scrollTrigger: {
                    trigger: infraSection,
                    start: 'top 80%'
                }
            }
        );

        // Background Image Parallax
        const infraBg = infraSection.querySelector('.infra-bg-parallax');
        if (infraBg) {
            gsap.set(infraBg, { scale: 1.1 });
            gsap.to(infraBg, {
                yPercent: 10,
                ease: 'none',
                scrollTrigger: {
                    trigger: infraSection.querySelector('.bg-\\[\\#041424\\]'),
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true
                }
            });
        }

        // Staggered Feature Items
        const infraItems = infraSection.querySelectorAll('.infra-stagger-item');
        if (infraItems.length > 0) {
            gsap.fromTo(infraItems,
                { autoAlpha: 0, y: 40 },
                {
                    autoAlpha: 1, y: 0, duration: 0.8, stagger: 0.15, ease: 'power3.out',
                    scrollTrigger: {
                        trigger: infraSection.querySelector('ul'),
                        start: 'top 80%'
                    }
                }
            );
        }
    }

    // ==========================================
    // 4. Products Section Animations
    // ==========================================
    const productsSection = document.querySelector('.products-section');
    if (productsSection) {
        gsap.fromTo(productsSection.querySelectorAll('.gsap-fade-up'),
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

    // ==========================================
    // 5. Gallery Section Animations
    // ==========================================
    const gallerySection = document.querySelector('#gallery-accordion')?.closest('section');
    if (gallerySection) {
        gsap.fromTo(gallerySection.querySelectorAll('.gsap-fade-up'),
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

    // ==========================================
    // 6. Why Choose Us Animations
    // ==========================================
    const whyStaggerItems = document.querySelectorAll('.why-stagger-item');
    if (whyStaggerItems.length > 0) {
        const whySection = whyStaggerItems[0].closest('section');
        gsap.fromTo(whySection.querySelectorAll('.gsap-fade-up'),
            { autoAlpha: 0, y: 30 },
            {
                autoAlpha: 1, y: 0, duration: 0.8, ease: 'power3.out',
                scrollTrigger: {
                    trigger: whySection,
                    start: 'top 80%'
                }
            }
        );
        gsap.fromTo(whyStaggerItems,
            { autoAlpha: 0, x: -30 },
            {
                autoAlpha: 1, x: 0, duration: 0.6, stagger: 0.15, ease: 'power3.out',
                scrollTrigger: {
                    trigger: whySection.querySelector('ul'),
                    start: 'top 80%'
                }
            }
        );
    }

    // ==========================================
    // 7. News Section Animations
    // ==========================================
    const newsSection = document.querySelector('.news-swiper-container')?.closest('section');
    if (newsSection) {
        gsap.fromTo(newsSection.querySelectorAll('.gsap-fade-up'),
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

    // ==========================================
    // 8. Testimonials Section Animations
    // ==========================================
    const testiSection = document.querySelector('.comment-swiper')?.closest('section');
    if (testiSection) {
        gsap.fromTo(testiSection.querySelectorAll('.gsap-fade-up'),
            { autoAlpha: 0, y: 30 },
            {
                autoAlpha: 1, y: 0, duration: 0.8, stagger: 0.2, ease: 'power3.out',
                scrollTrigger: {
                    trigger: testiSection,
                    start: 'top 80%'
                }
            }
        );
        
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

    // ==========================================
    // 9. Features Marquee Animations
    // ==========================================
    const marqueeSection = document.querySelector('.animate-marquee')?.closest('section.gsap-fade-up');
    if (marqueeSection) {
        gsap.fromTo(marqueeSection,
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

    // Refresh ScrollTrigger after all assets (images) are fully loaded
    window.addEventListener('load', () => {
        ScrollTrigger.refresh();
    });

});
