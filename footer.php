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
                <?php echo wp_kses_post(pll__(get_theme_mod('_alsalam_footer_title', 'Excellence <br/> in Parenteral Manufacturing'))); ?>
            </h2>

            <form id="alsalam-newsletter-form" class="relative flex flex-col mb-8" method="POST">
                <div class="relative flex items-center bg-white rounded-full p-1.5 shadow-sm">
                    <input type="email" name="email" required placeholder="<?php echo esc_attr(pll__(get_theme_mod('_alsalam_footer_newsletter', 'Enter your email address'))); ?>" class="flex-1 bg-transparent border-none outline-none ps-4 text-sm text-slate-600 placeholder-slate-400">
                    <?php wp_nonce_field('alsalam_newsletter_submit', 'newsletter_nonce'); ?>
                    <button type="submit" class="w-10 h-10 rounded-full bg-teal-500 hover:bg-teal-600 text-white flex items-center justify-center transition-colors shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:-scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
                <div id="newsletter-form-msg" class="hidden mt-2 text-sm text-center font-medium w-full"></div>
            </form>

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
        <?php
        $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'en';
        $suffix       = ($current_lang === 'ar') ? '_ar' : '';

        $quick_menu_id     = get_theme_mod('_alsalam_footer_quick_menu' . $suffix) ?: get_theme_mod('_alsalam_footer_quick_menu');
        $services_menu_id  = get_theme_mod('_alsalam_footer_services_menu' . $suffix) ?: get_theme_mod('_alsalam_footer_services_menu');
        $resources_menu_id = get_theme_mod('_alsalam_footer_resources_menu' . $suffix) ?: get_theme_mod('_alsalam_footer_resources_menu');
        ?>
        <div class="lg:col-span-2 flex flex-col lg:col-start-6">
            <h3 class="text-slate-900 font-bold text-lg mb-6"><?php echo esc_html(pll__('Quick Access')); ?></h3>
            <?php
            if ($quick_menu_id) {
                wp_nav_menu(array(
                    'menu' => $quick_menu_id,
                    'container' => false,
                    'menu_class' => 'flex flex-col gap-4',
                    'walker' => new Alsalam_Footer_Nav_Walker(),
                    'fallback_cb' => false,
                ));
            }
            ?>
        </div>

        <div class="lg:col-span-2 flex flex-col">
            <h3 class="text-slate-900 font-bold text-lg mb-6"><?php echo esc_html(pll__('Services')); ?></h3>
            <?php
            if ($services_menu_id) {
                wp_nav_menu(array(
                    'menu' => $services_menu_id,
                    'container' => false,
                    'menu_class' => 'flex flex-col gap-4',
                    'walker' => new Alsalam_Footer_Nav_Walker(),
                    'fallback_cb' => false,
                ));
            }
            ?>
        </div>
        
        <div class="lg:col-span-2 flex flex-col">
            <h3 class="text-slate-900 font-bold text-lg mb-6"><?php echo esc_html(pll__('Resources')); ?></h3>
            <?php
            if ($resources_menu_id) {
                wp_nav_menu(array(
                    'menu' => $resources_menu_id,
                    'container' => false,
                    'menu_class' => 'flex flex-col gap-4',
                    'walker' => new Alsalam_Footer_Nav_Walker(),
                    'fallback_cb' => false,
                ));
            }
            ?>
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
            <span><?php echo esc_html(pll__('Designed & Developed by')); ?></span>
            <a href="https://ihasht.ir/" target="_blank" class="text-[#e21b2c] hover:text-[#e21b2c] font-extrabold text-[12px] font-title transition-all duration-300 hover:-translate-y-0.5">Hasht Behesht</a>
        </div>
        <?php else : ?>
        <div></div>
        <?php endif; ?>
        <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 text-center sm:text-start">
            <p class="text-xs md:text-sm text-slate-600 font-medium">
                <?php 
                $copyright = pll__(get_theme_mod('_alsalam_footer_copyright', 'Copyright © [year] AL-SALAM. All rights reserved.'));
                echo wp_kses_post(str_replace('[year]', alsalam_number(date('Y')), $copyright)); 
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

        // Newsletter Form Handling
        var newsletterForm = document.getElementById('alsalam-newsletter-form');
        var newsletterMsg = document.getElementById('newsletter-form-msg');
        
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                var formData = new FormData(newsletterForm);
                formData.append('action', 'alsalam_submit_newsletter');
                
                var btn = newsletterForm.querySelector('button[type="submit"]');
                var originalBtnContent = btn.innerHTML;
                btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
                btn.disabled = true;
                
                newsletterMsg.classList.add('hidden');
                newsletterMsg.classList.remove('text-red-500', 'text-teal-500');
                
                fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    newsletterMsg.innerHTML = data.data.message;
                    newsletterMsg.classList.remove('hidden');
                    
                    if (data.success) {
                        newsletterMsg.classList.add('text-teal-500');
                        newsletterForm.reset();
                    } else {
                        newsletterMsg.classList.add('text-red-500');
                    }
                })
                .catch(error => {
                    newsletterMsg.innerHTML = '<?php echo esc_js(pll__("An unexpected error occurred. Please try again.")); ?>';
                    newsletterMsg.classList.remove('hidden');
                    newsletterMsg.classList.add('text-red-500');
                })
                .finally(() => {
                    btn.innerHTML = originalBtnContent;
                    btn.disabled = false;
                });
            });
        }
    });
</script>

<?php wp_footer(); ?>
</body>
</html>
