<?php
/**
 * Why Choose Us Section Template Part
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;
?>
<?php if (get_theme_mod('_alsalam_why_enable', '1') !== '1') return; ?>
<section class="py-20 pt-28 lg:pt-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <div class="relative w-full h-full lg:pe-8 group lg:mt-0">
                <div class="hidden sm:block absolute top-1/2 start-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-gradient-to-tr from-teal-100/50 to-transparent rounded-full blur-xl -z-10 pointer-events-none"></div>

                <div class="relative w-full h-[400px] sm:h-[480px] lg:h-full min-h-[350px] rounded-[2rem] overflow-hidden bg-background-page isolate">
                    <img src="<?php echo esc_url(alsalam_fix_asset_url(get_theme_mod('_alsalam_why_img', alsalam_img('Why Choose Us.jpg')))); ?>" 
                        alt="<?php esc_attr_e('Why Choose Us', 'alsalam'); ?>" 
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.05]" loading="lazy" />
                    
                    <div class="absolute -top-[2px] -start-[2px] w-[calc(50%+2px)] h-[calc(25%+2px)] rtl:w-[calc(40%+2px)] rtl:h-[28.5%] bg-background-page z-10 rounded-ee-[2.5rem] hidden lg:block"></div>
                    
                    <svg class="absolute top-0 start-1/2 rtl:start-[40%] w-8 h-8 z-10 text-background-page -ms-[1px] rtl:-scale-x-100 hidden lg:block" fill="currentColor" viewBox="0 0 100 100">
                        <path d="M0 0 L100 0 A100 100 0 0 0 0 100 Z" />
                    </svg>
                    
                    <svg class="absolute top-1/4 rtl:top-[28%] start-0 w-8 h-8 z-10 text-background-page -mt-[1px] rtl:-scale-x-100 hidden lg:block" fill="currentColor" viewBox="0 0 100 100">
                        <path d="M0 0 L100 0 A100 100 0 0 0 0 100 Z" />
                    </svg>
                </div>

                <!-- Title Card: RELATIVE on mobile (in-flow), ABSOLUTE on lg+ (floating) -->
                <div class="why-header-card relative lg:absolute lg:-top-[13%] lg:-start-[12%] z-20 mt-5 mb-2 lg:mt-0 lg:mb-0 max-w-full lg:max-w-[85%] flex flex-col items-start gap-3 lg:gap-4 transition-transform duration-500 hover:-translate-y-1 gsap-fade-up">
                    <span class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-50 to-white border border-teal-100 text-teal-800 rounded-full px-4 py-1.5 text-sm font-bold shadow-md">
                        <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                        <?php echo esc_html(pll__(get_theme_mod('_alsalam_why_badge_floating', 'Flexible IV Bag Technology'))); ?>
                    </span>

                    <div class="pt-1 pb-0">
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-1 sm:mb-2 tracking-tight font-heading">
                            <?php echo esc_html(pll__(get_theme_mod('_alsalam_why_badge_title', 'Why Choose Us'))); ?>
                        </h2>
                        <p class="text-slate-500 text-base font-normal leading-relaxed font-sans">
                            <?php echo esc_html(pll__(get_theme_mod('_alsalam_why_badge_desc', 'A transversal vision with infinite solutions'))); ?>
                        </p>
                    </div>
                </div>

                <div class="why-question-icon-wrap absolute top-[-20px] end-[20px] sm:end-[60px] lg:end-[60px] rtl:end-[10px] sm:rtl:end-[30px] translate-x-1/4 -translate-y-1/4 z-30 transition-transform duration-700 hover:rotate-12 hover:scale-110 w-16 h-16 sm:w-auto sm:h-auto">
                    <img src="<?php echo esc_url(alsalam_fix_asset_url(get_theme_mod('_alsalam_why_img_deco', alsalam_img('question_mark_sign_blue_01 copy 1 1.svg')))); ?>" 
                        alt="Question Mark" 
                        class="w-full h-full object-contain drop-shadow-[0_15px_25px_rgba(20,184,166,0.4)]" loading="lazy" />
                </div>
            </div>

            <div class="text-start">
                <header class="mb-4 gsap-fade-up">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 leading-tight font-heading">
                        <?php echo wp_kses_post(pll__(get_theme_mod('_alsalam_why_title', 'Safer, Smarter Infusion Solutions'))); ?>
                    </h2>
                    <p class="text-slate-500 text-base font-normal font-sans leading-relaxed">
                        <?php echo wp_kses_post(pll__(get_theme_mod('_alsalam_why_desc', 'Advanced flexible IV bags designed to improve safety, handling, and efficiency compared to conventional glass bottles.'))); ?>
                    </p>
                </header>

                <ul class="flex flex-col gap-4">
                    <?php 
                    $current_lang  = function_exists('pll_current_language') ? pll_current_language() : (is_rtl() ? 'ar' : 'en');
                    $suffix        = ($current_lang === 'ar') ? '_ar' : '';
                    $features_json = get_theme_mod('_alsalam_why_features' . $suffix) ?: get_theme_mod('_alsalam_why_features');
                    $features      = json_decode($features_json, true);
                    
                    if (!is_array($features) || empty($features)) {
                        $features = [
                            ['icon' => alsalam_img('medal-star.svg'), 'title' => 'Enhanced Safety', 'desc' => 'Reduced risk of breakage and contamination in clinical settings.'],
                            ['icon' => alsalam_img('truck.svg'), 'title' => 'Better Handling', 'desc' => 'Lightweight and easy to transport, optimizing logistics.'],
                            ['icon' => alsalam_img('target.svg'), 'title' => 'Clinical Efficiency', 'desc' => 'Streamlined design for medical staff and fast setup.'],
                            ['icon' => alsalam_img('layer-group.svg'), 'title' => 'Advanced Materials', 'desc' => 'Multi-layered technology for optimal medical protection.']
                        ];
                    }

                    foreach ($features as $feature) :
                        if (empty($feature['title'])) continue;
                        $icon_url = !empty($feature['icon']) ? alsalam_fix_asset_url($feature['icon']) : '';
                    ?>
                    <li class="why-stagger-item flex items-center gap-4 bg-white rounded-full py-1.5 ps-3 pe-4 shadow-md shadow-slate-200/50 transition-transform duration-300 hover:-translate-y-1 cursor-default border border-slate-100">
                        <?php if (!empty($icon_url)) : ?>
                        <img src="<?php echo esc_url($icon_url); ?>" alt="" class="w-8 h-8 shrink-0" loading="lazy">
                        <?php endif; ?>
                        <article class="flex flex-col">
                            <h3 class="text-slate-800 font-bold text-base font-heading"><?php echo esc_html(pll__($feature['title'])); ?></h3>
                            <p class="text-slate-500 text-sm line-clamp-2 font-sans"><?php echo esc_html(pll__($feature['desc'])); ?></p>
                        </article>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
