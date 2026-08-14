<?php
/**
 * Infrastructure Section Template Part
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;
?>
<?php if (get_theme_mod('_alsalam_infra_enable', '1') !== '1') return; ?>
<section id="infrastructure" class="py-20 px-4 max-w-7xl mx-auto">
    
    <header class="flex flex-col items-center text-center mb-12 gsap-fade-up">
        <h2 class="text-slate-900 text-4xl font-extrabold tracking-tight">
            <?php echo wp_kses_post(get_theme_mod('_alsalam_infra_title', __('Robust <span>Pharmaceutical</span> Infrastructure', 'alsalam'))); ?>
        </h2>
        <div class="flex items-center gap-2 mt-4">
            <span class="inline-flex items-center justify-center text-teal-500 w-7 h-8" aria-hidden="true">
                <?php 
                $badge_svg = ALSALAM_DIR . '/assets/images/badge-check.svg';
                if (file_exists($badge_svg)) include $badge_svg;
                ?>
            </span>
            <span class="text-slate-800 text-lg font-medium">
                <?php echo esc_html(get_theme_mod('_alsalam_infra_sub', __('Built on Quality. Driven by Care.', 'alsalam'))); ?>
            </span>
        </div>
    </header>

    <div class="bg-[#041424] rounded-[30px] relative overflow-hidden py-16 px-8 lg:px-12 shadow-2xl">
        <div class="absolute top-0 end-0 -translate-y-1/2 translate-x-1/4 w-64 h-64 bg-[#239BA8] opacity-50 blur-[60px] rounded-full pointer-events-none z-0" aria-hidden="true"></div>
        <div class="absolute bottom-0 start-0 translate-y-1/4 -translate-x-1/4 w-64 h-64 bg-[#239BA8] opacity-50 blur-[60px] rounded-full pointer-events-none z-0" aria-hidden="true"></div>
        
        <img src="<?php echo esc_url(get_theme_mod('_alsalam_infra_mask', alsalam_img('Mask group.svg'))); ?>" class="infra-bg-parallax absolute inset-0 w-full h-full object-cover pointer-events-none opacity-100 z-0" alt="" aria-hidden="true" loading="lazy" />

        <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12 relative z-10" role="list">
            
            <?php 
            $items_json = get_theme_mod('_alsalam_infra_items');
            $items = json_decode($items_json, true);
            
            // Fallback if empty or not decoded properly
            if (!is_array($items) || empty($items)) {
                $items = [
                    ['icon' => alsalam_img('Shield.svg'), 'title' => 'Sterile Production', 'desc' => 'Manufactured under strict GMP guidelines with high sterility standards to ensure product purity.'],
                    ['icon' => alsalam_img('Search copy.svg'), 'title' => 'Quality Control', 'desc' => 'Rigorous testing and analytical inspection to ensure full compliance with global pharmacopeia standards.'],
                    ['icon' => alsalam_img('Star.svg'), 'title' => 'Facility & Utilities', 'desc' => 'State-of-the-art cleanroom facilities powered by intelligent climate control (HVAC) systems.'],
                    ['icon' => alsalam_img('Graph.svg'), 'title' => 'Storage & Packaging', 'desc' => 'Advanced packaging and validation protocols including thermal processing for maximum safety.']
                ];
            }

            $total_items = count($items);
            foreach ($items as $index => $item) :
                if (empty($item['title'])) continue;
            ?>
            <li class="infra-stagger-item flex flex-col items-center text-center relative group">
                <div class="w-24 h-24 rounded-[30px] bg-white/10 backdrop-blur-md flex items-center justify-center mb-6 transition-transform duration-300 group-hover:-translate-y-2" aria-hidden="true">
                    <span class="w-16 h-16 flex items-center justify-center text-white">
                        <?php if (!empty($item['icon'])) : ?>
                        <img src="<?php echo esc_url($item['icon']); ?>" class="w-full h-full object-contain invert" alt="" />
                        <?php endif; ?>
                    </span>
                </div>
                <h3 class="text-white text-xl font-bold mb-3"><?php echo esc_html($item['title']); ?></h3>
                <p class="text-white/80 text-sm leading-relaxed max-w-xs">
                    <?php echo esc_html($item['desc']); ?>
                </p>

                <?php if ($index < $total_items - 1) : ?>
                <div class="hidden lg:block absolute top-12 start-[100%] translate-x-1/2 -translate-y-1/2 text-white/40 w-8 h-8 rtl:-scale-x-100 pointer-events-none" aria-hidden="true">
                    <?php 
                    $arrow = ALSALAM_DIR . '/assets/images/arrow.svg';
                    if (file_exists($arrow)) include $arrow; 
                    ?>
                </div>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>

        </ul>

    </div>
</section>
