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
                <?php echo wp_kses_post(get_theme_mod('_alsalam_footer_title', 'Excellence <br/> in Parenteral Manufacturing')); ?>
            </h2>

            <div class="relative flex items-center bg-white rounded-full p-1.5 shadow-sm mb-8">
                <input type="email" placeholder="<?php echo esc_attr(get_theme_mod('_alsalam_footer_newsletter', 'Enter your email address')); ?>" class="flex-1 bg-transparent border-none outline-none ps-4 text-sm text-slate-600 placeholder-slate-400">
                <button type="submit" class="w-10 h-10 rounded-full bg-teal-500 hover:bg-teal-600 text-white flex items-center justify-center transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:-scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>

            <div class="flex items-center gap-3">
                <?php
                $socials = json_decode(get_theme_mod('_alsalam_social_links', '[]'), true);
                if (is_array($socials) && !empty($socials)) {
                    foreach ($socials as $social) {
                        if (!empty($social['icon']) && !empty($social['url'])) {
                            echo '<a href="' . esc_url($social['url']) . '" class="w-11 h-11 rounded-full flex items-center justify-center text-white bg-teal-500 hover:bg-teal-600 transition-transform hover:-translate-y-1 shadow-sm">';
                            if (strpos($social['icon'], '<svg') !== false) {
                                echo $social['icon'];
                            } else {
                                echo '<img src="' . esc_url($social['icon']) . '" class="w-5 h-5 invert" alt="" />';
                            }
                            echo '</a>';
                        }
                    }
                }
                ?>
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
            <?php
            $policy_menu_id = get_theme_mod('_alsalam_footer_policy_menu');
            if ($policy_menu_id) {
                wp_nav_menu(array(
                    'menu' => $policy_menu_id,
                    'container' => false,
                    'menu_class' => 'flex flex-wrap items-center gap-4',
                    'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                    'fallback_cb' => false,
                ));
            }
            ?>
        </div>
        <hr class="border-slate-300/50 mb-6" />
    </div>

    <!-- Copyright Pill & Back to Top -->
    <div class="relative z-10 bg-white rounded-[2rem] sm:rounded-full p-3 sm:p-2 px-6 flex flex-col sm:flex-row justify-between items-center shadow-sm max-w-7xl mx-4 lg:mx-auto gap-4 sm:gap-0">
        <?php if (get_theme_mod('_alsalam_footer_dev_credit', '1') === '1') : ?>
        <div class="flex items-center gap-1 select-none text-xs text-slate-500">
            <span><?php esc_html_e('Designed & Developed by', 'alsalam'); ?></span>
            <a href="https://ihasht.ir/" target="_blank" class="text-[#e21b2c] hover:text-[#e21b2c] font-extrabold text-[12px] font-title transition-all duration-300 hover:-translate-y-0.5">Hasht Behesht</a>
        </div>
        <?php else : ?>
        <div></div>
        <?php endif; ?>
        <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 text-center sm:text-start">
            <p class="text-xs md:text-sm text-slate-600 font-medium">
                <?php 
                $copyright = get_theme_mod('_alsalam_footer_copyright', 'Copyright © [year] AL-SALAM. All rights reserved.');
                echo wp_kses_post(str_replace('[year]', date('Y'), $copyright)); 
                ?>
            </p>
            <?php if (get_theme_mod('_alsalam_footer_scroll_top', '1') === '1') : ?>
            <button id="scrollToTopBtn" class="w-10 h-10 rounded-full bg-slate-900 hover:bg-teal-500 hover:-translate-y-1 hover:shadow-lg text-white flex items-center justify-center shrink-0 cursor-pointer transition-all duration-300 group" aria-label="<?php esc_attr_e('Back to Top', 'alsalam'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform duration-300 group-hover:-translate-y-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
            </button>
            <?php endif; ?>
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
