<?php
/**
 * About Section Template Part
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;
?>
<?php if (get_theme_mod('_alsalam_about_enable', '1') !== '1') return; ?>
<section id="about" class="relative overflow-hidden py-20 lg:py-24">
    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 items-center lg:grid-cols-2">
            
            <!-- Left Column (Visuals) -->
            <div class="relative w-full max-w-xl mx-auto lg:max-w-none flex justify-center lg:justify-start">
                <div class="relative group w-[432px] h-[437px]">
                    <img 
                        src="<?php echo esc_url(get_theme_mod('_alsalam_about_deco', alsalam_img('image-icon.png'))); ?>" 
                        alt="" 
                        class="absolute top-[-62px] left-[-56px] w-[192px] h-[217px] z-20 pointer-events-none transform transition-transform duration-500 group-hover:scale-105"
                    />

                    <div class="absolute -inset-4 rounded-[3rem] bg-gradient-to-tr from-primary/10 to-transparent blur-2xl opacity-75 transition duration-500 group-hover:scale-105"></div>
                    
                    <div class="relative w-[432px] h-[437px] overflow-hidden rounded-[50px] shadow-2xl border border-slate-100 bg-slate-100 z-10">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/50 via-primary/10 to-transparent pointer-events-none z-10 mix-blend-normal"></div>
                        
                        <img 
                            src="<?php echo esc_url(get_theme_mod('_alsalam_about_img', alsalam_img('about-bg.jpg'))); ?>" 
                            alt="<?php esc_attr_e('AL-SALAM Sterile Manufacturing Facility', 'alsalam'); ?>" 
                            loading="lazy" 
                            class="about-img-parallax h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                        />
                    </div>

                    <a 
                        href="<?php echo esc_url(get_theme_mod('_alsalam_about_btn_link', '#')); ?>" 
                        class="absolute bottom-[25px] end-[-54px] flex items-center justify-center gap-3 bg-[#071D2C] hover:bg-primary active:scale-95 text-white font-medium rounded-full shadow-2xl transition-all duration-300 group/btn focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 z-20 font-sans min-w-[223px] min-h-[65px]"
                        aria-label="<?php esc_attr_e('Learn More', 'alsalam'); ?>"
                    >
                        <span class="text-base font-semibold tracking-wide"><?php echo esc_html(get_theme_mod('_alsalam_about_btn_text', __('Learn More', 'alsalam'))); ?></span>
                        <svg 
                            class="w-4 h-4 transition-transform duration-300 ltr:group-hover/btn:translate-x-1 rtl:group-hover/btn:-translate-x-1 rtl:rotate-180" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24" 
                            stroke-width="3"
                            aria-hidden="true"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex flex-col text-start">
                <div class="self-start mb-4 gsap-fade-up">
                    <span class="inline-block rounded-full bg-[#E5F0F6] px-4 py-1.5 text-sm font-semibold tracking-wide text-slate-800 font-sans">
                        <?php echo esc_html(get_theme_mod('_alsalam_about_badge', __('About Us', 'alsalam'))); ?>
                    </span>
                </div>

                <h2 class="text-3xl sm:text-4xl lg:text-4.5xl font-bold text-[#071D2C] tracking-tight mb-6 leading-tight font-heading gsap-fade-up">
                    <?php echo wp_kses_post(get_theme_mod('_alsalam_about_title', __('About AL-SALAM', 'alsalam'))); ?>
                </h2>

                <p class="text-[#3A3A3A] text-base sm:text-[17px] leading-relaxed mb-8 font-normal font-sans gsap-fade-up">
                    <?php echo wp_kses_post(get_theme_mod('_alsalam_about_desc1', __('AL-SALAM Pharmaceutical Industry is a sterile manufacturing facility...', 'alsalam'))); ?>
                </p>

                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8 gsap-fade-up" role="list">
                    <?php 
                    $features = json_decode(get_theme_mod('_alsalam_about_features', '[]'), true);
                    if (is_array($features)) :
                        foreach ($features as $feature) : 
                            if (empty($feature['title'])) continue;
                    ?>
                    <li class="flex items-center gap-4 group/item">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full bg-primary p-[5px] flex items-center justify-center shadow-md transition-all duration-300 group-hover/item:scale-105" aria-hidden="true">
                            <?php if (!empty($feature['icon'])) : ?>
                            <img src="<?php echo esc_url($feature['icon']); ?>" class="w-full h-full" alt="" loading="lazy" />
                            <?php endif; ?>
                        </div>
                        <span class="text-[#071D2C] font-bold text-base leading-snug tracking-tight font-heading">
                            <?php echo esc_html($feature['title']); ?>
                        </span>
                    </li>
                    <?php 
                        endforeach;
                    endif; 
                    ?>
                </ul>

                <p class="text-[#3A3A3A] text-base sm:text-[17px] leading-relaxed font-normal font-sans gsap-fade-up">
                    <?php echo wp_kses_post(get_theme_mod('_alsalam_about_desc2', __('We combine advanced production, strict quality control...', 'alsalam'))); ?>
                </p>
            </div>
            
        </div>
    </div>
</section>
