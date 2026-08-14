<?php
/**
 * The template for displaying the footer
 *
 * @package alsalam
 */
defined('ABSPATH') || exit;
?>
<footer class="relative w-full bg-[#EAF3F5] pt-20 pb-8 overflow-hidden z-0 mt-auto">
    <!-- Background Patterns -->
    <div class="absolute bottom-0 start-0 opacity-100 w-[450px] pointer-events-none">
        <img src="<?php echo esc_url(alsalam_img('bottom-left.svg')); ?>" alt="Pattern" class="w-full h-auto object-cover opacity-90" style="filter: brightness(0) invert(1);" />
    </div>
    <div class="absolute top-0 end-0 opacity-100 w-80 pointer-events-none">
        <img src="<?php echo esc_url(alsalam_img('top-right-bg.svg')); ?>" alt="Pattern" class="w-full h-auto object-cover opacity-90" style="filter: brightness(0) invert(1);" />
    </div>
    <!-- Decorative Blurs -->
    <div style="position: absolute; width: 134.17px; height: 375.09px; left: -75px; bottom: -50px; background: #239BA8; filter: blur(119.9px); border-radius: 273px; transform: matrix(0.95, -0.31, 0.37, 0.93, 0, 0); pointer-events: none;"></div>
    <div style="position: absolute; width: 183.58px; height: 538.95px; right: -50px; top: -100px; background: #239BA8; filter: blur(151.9px); border-radius: 92.8206px; transform: matrix(0.95, -0.31, 0.37, 0.93, 0, 0); pointer-events: none;"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-6 mb-12">
        <!-- Col 1: Branding & Newsletter -->
        <div class="lg:col-span-4 flex flex-col">
            <h2 class="text-3xl font-extrabold mb-8 leading-tight">
                <?php echo wp_kses_post(alsalam_str('footer_tagline', '<span class="text-teal-500">Excellence</span> <br/>in Parenteral Manufacturing')); ?>
            </h2>

            <div class="relative flex items-center bg-white rounded-full p-1.5 shadow-sm mb-8">
                <input type="email" placeholder="<?php echo esc_attr(alsalam_str('footer_email_placeholder', 'Enter your email...')); ?>" class="flex-1 bg-transparent border-none outline-none ps-4 text-sm text-slate-600 placeholder-slate-400">
                <button type="submit" class="w-10 h-10 rounded-full bg-teal-500 hover:bg-teal-600 text-white flex items-center justify-center transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:-scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>

            <div class="flex items-center gap-3">
                <a href="#" aria-label="Telegram" class="w-11 h-11 rounded-full flex items-center justify-center text-white bg-teal-500 transition-transform hover:-translate-y-1 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                </a>
                <a href="#" aria-label="LinkedIn" class="w-11 h-11 rounded-full flex items-center justify-center text-white bg-slate-900 transition-transform hover:-translate-y-1 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                </a>
                <a href="#" aria-label="Instagram" class="w-11 h-11 rounded-full flex items-center justify-center text-white bg-teal-500 transition-transform hover:-translate-y-1 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                </a>
                <a href="#" aria-label="WhatsApp" class="w-11 h-11 rounded-full flex items-center justify-center text-white bg-slate-900 transition-transform hover:-translate-y-1 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </a>
            </div>
        </div>

        <!-- Cols 2 to 5: Links -->
        <div class="lg:col-span-2 flex flex-col lg:col-start-6">
            <h3 class="text-slate-900 font-bold text-lg mb-6"><?php echo esc_html(alsalam_str('footer_quick_access', 'Quick Access')); ?></h3>
            <ul class="flex flex-col gap-4">
                <li>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 group">
                        <span class="w-2.5 h-1.5 rounded-full bg-teal-500 shrink-0 transition-all group-hover:w-4"></span>
                        <span class="text-slate-700 hover:text-teal-600 text-sm font-medium transition-colors"><?php echo esc_html(alsalam_str('home', 'Home')); ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/about')); ?>" class="flex items-center gap-3 group">
                        <span class="w-2.5 h-1.5 rounded-full bg-teal-500 shrink-0 transition-all group-hover:w-4"></span>
                        <span class="text-slate-700 hover:text-teal-600 text-sm font-medium transition-colors"><?php echo esc_html(alsalam_str('about_us', 'About Us')); ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/#infrastructure')); ?>" class="flex items-center gap-3 group">
                        <span class="w-2.5 h-1.5 rounded-full bg-teal-500 shrink-0 transition-all group-hover:w-4"></span>
                        <span class="text-slate-700 hover:text-teal-600 text-sm font-medium transition-colors"><?php echo esc_html(alsalam_str('our_infrastructure', 'Our Infrastructure')); ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="flex items-center gap-3 group">
                        <span class="w-2.5 h-1.5 rounded-full bg-teal-500 shrink-0 transition-all group-hover:w-4"></span>
                        <span class="text-slate-700 hover:text-teal-600 text-sm font-medium transition-colors"><?php echo esc_html(alsalam_str('contact_us', 'Contact')); ?></span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="lg:col-span-2 flex flex-col">
            <h3 class="text-slate-900 font-bold text-lg mb-6"><?php echo esc_html(alsalam_str('footer_services', 'Services')); ?></h3>
            <ul class="flex flex-col gap-4">
                <li>
                    <a href="#" class="flex items-center gap-3 group">
                        <span class="w-2.5 h-1.5 rounded-full bg-teal-500 shrink-0 transition-all group-hover:w-4"></span>
                        <span class="text-slate-700 hover:text-teal-600 text-sm font-medium transition-colors"><?php echo esc_html(alsalam_str('footer_service_1', 'Parenteral Mfg')); ?></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 group">
                        <span class="w-2.5 h-1.5 rounded-full bg-teal-500 shrink-0 transition-all group-hover:w-4"></span>
                        <span class="text-slate-700 hover:text-teal-600 text-sm font-medium transition-colors"><?php echo esc_html(alsalam_str('footer_service_2', 'Quality Control')); ?></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 group">
                        <span class="w-2.5 h-1.5 rounded-full bg-teal-500 shrink-0 transition-all group-hover:w-4"></span>
                        <span class="text-slate-700 hover:text-teal-600 text-sm font-medium transition-colors"><?php echo esc_html(alsalam_str('footer_service_3', 'R&D')); ?></span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="lg:col-span-2 flex flex-col">
            <h3 class="text-slate-900 font-bold text-lg mb-6"><?php echo esc_html(alsalam_str('footer_resources', 'Resources')); ?></h3>
            <ul class="flex flex-col gap-4">
                <li>
                    <a href="<?php echo esc_url(home_url('/news')); ?>" class="flex items-center gap-3 group">
                        <span class="w-2.5 h-1.5 rounded-full bg-teal-500 shrink-0 transition-all group-hover:w-4"></span>
                        <span class="text-slate-700 hover:text-teal-600 text-sm font-medium transition-colors"><?php echo esc_html(alsalam_str('news_events', 'News & Events')); ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/gallery')); ?>" class="flex items-center gap-3 group">
                        <span class="w-2.5 h-1.5 rounded-full bg-teal-500 shrink-0 transition-all group-hover:w-4"></span>
                        <span class="text-slate-700 hover:text-teal-600 text-sm font-medium transition-colors"><?php echo esc_html(alsalam_str('gallery', 'gallery')); ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/#join-us')); ?>" class="flex items-center gap-3 group">
                        <span class="w-2.5 h-1.5 rounded-full bg-teal-500 shrink-0 transition-all group-hover:w-4"></span>
                        <span class="text-slate-700 hover:text-teal-600 text-sm font-medium transition-colors"><?php echo esc_html(alsalam_str('footer_careers', 'Careers')); ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Divider & Policy Links -->
    <div class="relative z-10 max-w-7xl mx-auto px-4">
        <div class="flex flex-wrap items-center gap-4 text-xs font-bold text-slate-600 mb-4">
            <a href="#" class="hover:text-teal-600 transition-colors"><?php echo esc_html(alsalam_str('footer_terms', 'Terms & Conditions')); ?></a>
            <span class="text-slate-300">|</span>
            <a href="#" class="hover:text-teal-600 transition-colors"><?php echo esc_html(alsalam_str('footer_rules', 'Rules & Regulations')); ?></a>
            <span class="text-slate-300">|</span>
            <a href="#" class="hover:text-teal-600 transition-colors"><?php echo esc_html(alsalam_str('footer_privacy', 'Privacy Policy')); ?></a>
        </div>
        <hr class="border-slate-300/50 mb-6" />
    </div>

    <!-- Copyright Pill & Back to Top -->
    <div class="relative z-10 bg-white rounded-[2rem] sm:rounded-full p-3 sm:p-2 px-6 flex flex-col sm:flex-row justify-between items-center shadow-sm max-w-7xl mx-4 lg:mx-auto gap-4 sm:gap-0">
        <div class="flex items-center gap-1 select-none text-xs text-slate-500">
            <span><?php echo esc_html(alsalam_str('designed_by', 'Designed & Developed by')); ?></span>
            <a href="https://ihasht.ir/" target="_blank" class="text-[#e21b2c] hover:text-[#e21b2c] font-extrabold text-[12px] font-title transition-all duration-300 hover:-translate-y-0.5">Hasht Behesht</a>
        </div>
        <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 text-center sm:text-start">
            <p class="text-xs md:text-sm text-slate-600 font-medium">
                &copy; <?php echo date('Y'); ?> <?php echo esc_html(alsalam_str('brand_name', 'AL-SALAM')); ?>. <?php echo esc_html(alsalam_str('footer_copyright', 'All Rights Reserved.')); ?>
            </p>
            <button id="scrollToTopBtn" class="w-10 h-10 rounded-full bg-slate-900 hover:bg-teal-500 hover:-translate-y-1 hover:shadow-lg text-white flex items-center justify-center shrink-0 cursor-pointer transition-all duration-300 group" aria-label="<?php echo esc_attr(alsalam_str('back_to_top', 'Back to Top')); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform duration-300 group-hover:-translate-y-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
            </button>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var btn = document.getElementById('scrollToTopBtn');
        if(btn) {
            btn.addEventListener('click', function() {
              window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
</script>

<?php wp_footer(); ?>
</body>
</html>
