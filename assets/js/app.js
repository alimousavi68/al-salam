document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    // ==========================================
    // Header Logic
    // ==========================================
    (function () {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const closeBtn = document.getElementById('mobile-menu-close');
        const menu = document.getElementById('mobile-menu');

        function openMenu() {
            menu.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                menu.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                menu.classList.add('opacity-100', 'scale-100');
            }, 20);
            toggleBtn.setAttribute('aria-expanded', 'true');
        }

        function closeMenu() {
            menu.classList.remove('opacity-100', 'scale-100');
            menu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            document.body.style.overflow = '';
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300);
            toggleBtn.setAttribute('aria-expanded', 'false');
        }

        if (toggleBtn && menu) {
            toggleBtn.addEventListener('click', openMenu);
        }
        if (closeBtn) {
            closeBtn.addEventListener('click', closeMenu);
        }

        // ==========================================
        // Mobile Language Panel Logic
        // ==========================================
        const langPanelToggle = document.getElementById('mobile-lang-toggle');
        const langPanelClose  = document.getElementById('mobile-lang-panel-close');
        const langPanel       = document.getElementById('mobile-lang-panel');

        function openLangPanel() {
            if (!langPanel) return;
            langPanel.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                langPanel.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                langPanel.classList.add('opacity-100', 'scale-100');
            }, 20);
            if (langPanelToggle) langPanelToggle.setAttribute('aria-expanded', 'true');
        }

        function closeLangPanel() {
            if (!langPanel) return;
            langPanel.classList.remove('opacity-100', 'scale-100');
            langPanel.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            document.body.style.overflow = '';
            setTimeout(() => {
                langPanel.classList.add('hidden');
            }, 300);
            if (langPanelToggle) langPanelToggle.setAttribute('aria-expanded', 'false');
        }

        if (langPanelToggle && langPanel) {
            langPanelToggle.addEventListener('click', openLangPanel);
        }
        if (langPanelClose) {
            langPanelClose.addEventListener('click', closeLangPanel);
        }

        // Close lang panel on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeLangPanel();
            }
        });

        // Active State Management for Navigation
        const navLinks = document.querySelectorAll('[data-nav-link]');
        const mobileLinks = document.querySelectorAll('[data-nav-link-mobile]');

        function updateActiveState(targetUrl) {
            // Desktop
            navLinks.forEach(function (link) {
                const url = link.getAttribute('href');
                const dot = link.querySelector('.nav-dot');
                const label = link.querySelector('.nav-label');
                if (url === targetUrl) {
                    if (dot) { dot.classList.remove('opacity-0', 'scale-0'); dot.classList.add('opacity-100', 'scale-100'); }
                    if (label) { label.classList.add('text-primary-light', 'font-semibold'); }
                } else {
                    if (dot) { dot.classList.add('opacity-0', 'scale-0'); dot.classList.remove('opacity-100', 'scale-100'); }
                    if (label) { label.classList.remove('text-primary-light', 'font-semibold'); }
                }
            });

            // Mobile
            mobileLinks.forEach(function (link) {
                const url = link.getAttribute('href');
                const label = link.querySelector('span');
                if (url === targetUrl) {
                    if (label) { label.classList.add('text-primary-light'); }
                } else {
                    if (label) { label.classList.remove('text-primary-light'); }
                }
            });
        }

        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                updateActiveState(this.getAttribute('href'));
            });
        });

        mobileLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                updateActiveState(this.getAttribute('href'));
                closeMenu();
            });
        });

        // Language Switcher Dropdown Logic
        const langBtn = document.getElementById('lang-switcher-btn');
        const langMenu = document.getElementById('lang-dropdown-menu');
        const langChevron = document.getElementById('lang-chevron');

        if (langBtn && langMenu) {
            // Toggle dropdown using custom show class (avoids JIT dynamic class compilation issues)
            const toggleDropdown = (show) => {
                const isOpen = langMenu.classList.contains('show');
                const shouldOpen = show !== undefined ? show : !isOpen;

                if (shouldOpen) {
                    langMenu.classList.add('show');
                    if (langChevron) langChevron.classList.add('rotate-180');
                } else {
                    langMenu.classList.remove('show');
                    if (langChevron) langChevron.classList.remove('rotate-180');
                }
            };

            langBtn.addEventListener('click', (e) => {
                toggleDropdown();
            });

            // Close when clicking outside using modern container check
            document.addEventListener('click', (e) => {
                const container = document.getElementById('language-switcher-container');
                if (container && !container.contains(e.target)) {
                    toggleDropdown(false);
                }
            });

            // Close dropdown when a language is clicked
            const langButtons = document.querySelectorAll('[data-lang-btn]');
            langButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    toggleDropdown(false);
                });
            });
        }
    })();

    // ==========================================
    // Hero Logic
    // ==========================================
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.slide-indicator-dot');
    const prevBtn = document.getElementById('slide-prev');
    const nextBtn = document.getElementById('slide-next');
    const sliderContainer = document.getElementById('hero-slider');
    let currentSlide = 0;
    let autoplayTimer;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.remove('hidden');
                setTimeout(() => {
                    slide.classList.remove('opacity-0', 'translate-y-4');
                    slide.classList.add('opacity-100', 'translate-y-0');
                }, 30);
            } else {
                slide.classList.add('hidden', 'opacity-0', 'translate-y-4');
                slide.classList.remove('opacity-100', 'translate-y-0');
            }
        });

        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.remove('bg-white/40');
                dot.classList.add('bg-white', 'w-4');
            } else {
                dot.classList.remove('bg-white', 'w-4');
                dot.classList.add('bg-white/40');
            }
        });

        currentSlide = index;
        resetAutoplay();
    }

    function nextSlide() {
        if (slides.length > 0) {
            let nextIndex = (currentSlide + 1) % slides.length;
            showSlide(nextIndex);
        }
    }

    function prevSlide() {
        if (slides.length > 0) {
            let prevIndex = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prevIndex);
        }
    }

    function startAutoplay() {
        autoplayTimer = setInterval(nextSlide, 7000);
    }

    function resetAutoplay() {
        clearInterval(autoplayTimer);
        startAutoplay();
    }

    if (slides.length > 0) {
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showSlide(index));
        });

        if (sliderContainer) {
            let touchStartX = 0;
            let touchEndX = 0;

            sliderContainer.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            sliderContainer.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleGesture();
            }, { passive: true });

            function handleGesture() {
                if (touchEndX < touchStartX - 50) {
                    nextSlide();
                }
                if (touchEndX > touchStartX + 50) {
                    prevSlide();
                }
            }
        }

        showSlide(0);
        startAutoplay();
    }

    const playBtn = document.getElementById('play-video-btn');
    const modal = document.getElementById('video-modal');
    const closeModal = document.getElementById('close-modal');

    if (playBtn && modal && closeModal) {
        playBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    }

    // ==========================================
    // Products Swiper Logic
    // ==========================================
    if (document.querySelector('.swiper-container-products')) {
        const productsSwiper = new Swiper('.swiper-container-products', {
            slidesPerView: 3,
            centeredSlides: true,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            navigation: {
                nextEl: '.products-section .custom-next',
                prevEl: '.products-section .custom-prev',
            },
            pagination: {
                el: '.products-section .swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                320: { slidesPerView: 1.2, spaceBetween: 20 },
                768: { slidesPerView: 2.2, spaceBetween: 25 },
                1024: { slidesPerView: 3, spaceBetween: 30 }
            }
        });
    }

    // ==========================================
    // Gallery Accordion Logic
    // ==========================================
    const galleryAccordion = document.getElementById('gallery-accordion');
    if (galleryAccordion) {
        const items = galleryAccordion.querySelectorAll('.gallery-item');
        const prevBtn = document.getElementById('gallery-prev');
        const nextBtn = document.getElementById('gallery-next');
        let currentIndex = 2; // Default active item (center of 5)

        function updateGallery(index) {
            items.forEach((item, i) => {
                if (i === index) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
            currentIndex = index;
        }

        // Initialize
        updateGallery(currentIndex);

        // Click event for items
        items.forEach((item, index) => {
            item.addEventListener('click', (e) => {
                if (!item.classList.contains('active')) {
                    e.preventDefault();
                    updateGallery(index);
                }
            });
        });

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                let nextIndex = (currentIndex + 1) % items.length;
                updateGallery(nextIndex);
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                let prevIndex = (currentIndex - 1 + items.length) % items.length;
                updateGallery(prevIndex);
            });
        }
    }

    // ==========================================
    // News Swiper Logic
    // ==========================================
    if (document.querySelector('.news-swiper')) {
        window.newsSwiper = new Swiper('.news-swiper', {
            slidesPerView: 1,
            centeredSlides: true,
            spaceBetween: 16,
            loop: true,
            speed: 600,
            grabCursor: true,
            navigation: {
                nextEl: '.news-swiper-container .news-next',
                prevEl: '.news-swiper-container .news-prev',
            },
            pagination: {
                el: '.news-swiper-container .swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: { slidesPerView: 3, spaceBetween: 24 },
                1024: { slidesPerView: 3, spaceBetween: 30 }
            }
        });
    }

    // ==========================================
    // Testimonials Swiper Logic
    // ==========================================
    if (document.querySelector('.comment-swiper')) {
        new Swiper('.comment-swiper', {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.comment-next',
                prevEl: '.comment-prev',
            },
            pagination: {
                el: '.comment-pagination',
                clickable: true,
            }
        });
    }

});

// Global functions (like switchNewsTab)
window.switchNewsTab = function (category) {
    const tabLatest = document.getElementById('tab-latest');
    const tabEducational = document.getElementById('tab-educational');

    if (category === 'latest') {
        tabLatest.className = "px-6 py-2 bg-teal-500 text-white font-medium rounded-full cursor-pointer shadow-md transition-all duration-300";
        tabEducational.className = "px-6 py-2 text-teal-600 font-medium rounded-full cursor-pointer transition-all duration-300 hover:text-teal-700";
    } else {
        tabLatest.className = "px-6 py-2 text-teal-600 font-medium rounded-full cursor-pointer transition-all duration-300 hover:text-teal-700";
        tabEducational.className = "px-6 py-2 bg-teal-500 text-white font-medium rounded-full cursor-pointer shadow-md transition-all duration-300";
    }

    if (window.newsSwiper) {
        const slides = window.newsSwiper.slides;
        let targetIndex = -1;
        for (let i = 0; i < slides.length; i++) {
            const slideCategory = slides[i].getAttribute('data-category');
            if (slideCategory === category) {
                targetIndex = i;
                break;
            }
        }
        if (targetIndex !== -1) {
            window.newsSwiper.slideTo(targetIndex);
        }
    }
};
