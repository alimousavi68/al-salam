<?php
/**
 * Infrastructure Section Template Part
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;
?>
<section id="infrastructure" class="py-20 px-4 max-w-7xl mx-auto">
    
    <header class="flex flex-col items-center text-center mb-12 gsap-fade-up">
        <h2 class="text-slate-900 text-4xl font-extrabold tracking-tight">
            <?php esc_html_e('Advanced Pharmaceutical Infrastructure', 'alsalam'); ?>
        </h2>
        <div class="flex items-center gap-2 mt-4">
            <span class="inline-flex items-center justify-center text-teal-500 w-7 h-8" aria-hidden="true">
                <?php 
                $badge_svg = ALSALAM_DIR . '/assets/images/badge-check.svg';
                if (file_exists($badge_svg)) include $badge_svg;
                ?>
            </span>
            <span class="text-slate-800 text-lg font-medium"><?php esc_html_e('Built on Quality. Driven by Care', 'alsalam'); ?></span>
        </div>
    </header>

    <div class="bg-[#041424] rounded-[30px] relative overflow-hidden py-16 px-8 lg:px-12 shadow-2xl">
        <div class="absolute top-0 end-0 -translate-y-1/2 translate-x-1/4 w-64 h-64 bg-[#239BA8] opacity-50 blur-[60px] rounded-full pointer-events-none z-0" aria-hidden="true"></div>
        <div class="absolute bottom-0 start-0 translate-y-1/4 -translate-x-1/4 w-64 h-64 bg-[#239BA8] opacity-50 blur-[60px] rounded-full pointer-events-none z-0" aria-hidden="true"></div>
        
        <img src="<?php echo esc_url(alsalam_img('Mask group.svg')); ?>" class="infra-bg-parallax absolute inset-0 w-full h-full object-cover pointer-events-none opacity-100 z-0" alt="" aria-hidden="true" loading="lazy" />

        <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12 relative z-10" role="list">
            
            <li class="infra-stagger-item flex flex-col items-center text-center relative group">
                <div class="w-24 h-24 rounded-[30px] bg-white/10 backdrop-blur-md flex items-center justify-center mb-6 transition-transform duration-300 group-hover:-translate-y-2" aria-hidden="true">
                    <span class="w-16 h-16 flex items-center justify-center text-white">
                        <?php 
                        $svg = ALSALAM_DIR . '/assets/images/Shield.svg';
                        if (file_exists($svg)) include $svg;
                        ?>
                    </span>
                </div>
                <h3 class="text-white text-xl font-bold mb-3"><?php esc_html_e('Sterile Production', 'alsalam'); ?></h3>
                <p class="text-white/80 text-sm leading-relaxed max-w-xs">
                    <?php esc_html_e('Manufactured under strict GMP guidelines with high sterility standards to ensure product purity.', 'alsalam'); ?>
                </p>

                <div class="hidden lg:block absolute top-12 start-[100%] translate-x-1/2 -translate-y-1/2 text-white/40 w-8 h-8 rtl:-scale-x-100 pointer-events-none" aria-hidden="true">
                    <?php 
                    $arrow = ALSALAM_DIR . '/assets/images/arrow.svg';
                    if (file_exists($arrow)) include $arrow;
                    ?>
                </div>
            </li>

            <li class="infra-stagger-item flex flex-col items-center text-center relative group">
                <div class="w-24 h-24 rounded-[30px] bg-white/10 backdrop-blur-md flex items-center justify-center mb-6 transition-transform duration-300 group-hover:-translate-y-2" aria-hidden="true">
                    <span class="w-16 h-16 flex items-center justify-center text-white">
                        <?php 
                        $svg = ALSALAM_DIR . '/assets/images/Search copy.svg';
                        if (file_exists($svg)) include $svg;
                        ?>
                    </span>
                </div>
                <h3 class="text-white text-xl font-bold mb-3"><?php esc_html_e('Quality Control', 'alsalam'); ?></h3>
                <p class="text-white/80 text-sm leading-relaxed max-w-xs">
                    <?php esc_html_e('Rigorous testing and analytical inspection to ensure full compliance with global pharmacopeia standards.', 'alsalam'); ?>
                </p>

                <div class="hidden lg:block absolute top-12 start-[100%] translate-x-1/2 -translate-y-1/2 text-white/40 w-8 h-8 rtl:-scale-x-100 pointer-events-none" aria-hidden="true">
                    <?php if (file_exists($arrow)) include $arrow; ?>
                </div>
            </li>

            <li class="infra-stagger-item flex flex-col items-center text-center relative group">
                <div class="w-24 h-24 rounded-[30px] bg-white/10 backdrop-blur-md flex items-center justify-center mb-6 transition-transform duration-300 group-hover:-translate-y-2" aria-hidden="true">
                    <span class="w-16 h-16 flex items-center justify-center text-white">
                        <?php 
                        $svg = ALSALAM_DIR . '/assets/images/Star.svg';
                        if (file_exists($svg)) include $svg;
                        ?>
                    </span>
                </div>
                <h3 class="text-white text-xl font-bold mb-3"><?php esc_html_e('Facility & Utilities', 'alsalam'); ?></h3>
                <p class="text-white/80 text-sm leading-relaxed max-w-xs">
                    <?php esc_html_e('State-of-the-art cleanroom facilities powered by intelligent climate control (HVAC) systems.', 'alsalam'); ?>
                </p>

                <div class="hidden lg:block absolute top-12 start-[100%] translate-x-1/2 -translate-y-1/2 text-white/40 w-8 h-8 rtl:-scale-x-100 pointer-events-none" aria-hidden="true">
                    <?php if (file_exists($arrow)) include $arrow; ?>
                </div>
            </li>

            <li class="infra-stagger-item flex flex-col items-center text-center relative group">
                <div class="w-24 h-24 rounded-[30px] bg-white/10 backdrop-blur-md flex items-center justify-center mb-6 transition-transform duration-300 group-hover:-translate-y-2" aria-hidden="true">
                    <span class="w-16 h-16 flex items-center justify-center text-white">
                        <?php 
                        $svg = ALSALAM_DIR . '/assets/images/Graph.svg';
                        if (file_exists($svg)) include $svg;
                        ?>
                    </span>
                </div>
                <h3 class="text-white text-xl font-bold mb-3"><?php esc_html_e('Storage & Packaging', 'alsalam'); ?></h3>
                <p class="text-white/80 text-sm leading-relaxed max-w-xs">
                    <?php esc_html_e('Advanced packaging and validation protocols including thermal processing for maximum safety.', 'alsalam'); ?>
                </p>
            </li>

        </ul>

    </div>
</section>
