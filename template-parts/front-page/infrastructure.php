<?php
/**
 * Infrastructure Section Template Part
 */

defined('ABSPATH') || exit;

if (get_theme_mod('_alsalam_infra_enable', '1') !== '1') return; 

$current_lang = function_exists('pll_current_language') ? pll_current_language() : (is_rtl() ? 'ar' : 'en');
$suffix       = ($current_lang === 'ar') ? '_ar' : '';

$title = get_theme_mod('_alsalam_infra_title', 'Advanced <span class="text-teal-500">Pharmaceutical</span> Infrastructure');
$badge = get_theme_mod('_alsalam_infra_sub', 'AL-SALAM');

$items_json = get_theme_mod('_alsalam_infra_items' . $suffix) ?: get_theme_mod('_alsalam_infra_items');
$items      = json_decode($items_json, true);

if (!is_array($items) || empty($items)) {
    $items = [
        [
            'icon' => 'Shield.svg', 
            'title' => 'Sterile Production', 
            'desc' => 'Manufactured under strict GMP guidelines with high sterility standards to ensure product purity.'
        ],
        [
            'icon' => 'Search copy.svg', 
            'title' => 'Quality Control', 
            'desc' => 'Rigorous testing and analytical inspection to ensure full compliance with global pharmacopeia standards.'
        ],
        [
            'icon' => 'Star.svg', 
            'title' => 'Facility & Utilities', 
            'desc' => 'State-of-the-art cleanroom facilities powered by intelligent climate control (HVAC) systems.'
        ],
        [
            'icon' => 'Graph.svg', 
            'title' => 'Storage & Packaging', 
            'desc' => 'Advanced packaging and validation protocols including thermal processing for maximum safety.'
        ]
    ];
}
$total_items = count($items);
?>
<section id="infrastructure" class="py-4 sm:py-20 px-4 max-w-7xl mx-auto">
    
    <header class="flex flex-col items-center text-center mb-8 sm:mb-12 gsap-fade-up">
        <h2 class="text-slate-900 text-3xl sm:text-4xl font-extrabold tracking-tight font-heading">
            <?php echo wp_kses_post(pll__($title)); ?>
        </h2>
        <div class="flex items-center gap-2 mt-4">
            <span class="inline-flex items-center justify-center text-teal-500 w-7 h-8" aria-hidden="true">
                <?php 
                $badge_svg = ALSALAM_DIR . '/assets/images/badge-check.svg';
                if (file_exists($badge_svg)) include $badge_svg;
                ?>
            </span>
            <span class="text-slate-500 text-base font-normal font-sans">
                <?php echo esc_html(pll__($badge)); ?>
            </span>
        </div>
    </header>

    <div class="bg-[#041424] rounded-[30px] relative overflow-hidden py-10 sm:py-16 px-5 sm:px-8 lg:px-12 shadow-2xl">
        <div class="hidden sm:block absolute top-0 end-0 -translate-y-1/2 translate-x-1/4 w-64 h-64 bg-[#239BA8] opacity-50 blur-[60px] rounded-full pointer-events-none z-0" aria-hidden="true"></div>
        <div class="hidden sm:block absolute bottom-0 start-0 translate-y-1/4 -translate-x-1/4 w-64 h-64 bg-[#239BA8] opacity-50 blur-[60px] rounded-full pointer-events-none z-0" aria-hidden="true"></div>
        
        <img src="<?php echo esc_url(alsalam_fix_asset_url(get_theme_mod('_alsalam_infra_mask_fixed', alsalam_img('Mask group.svg')))); ?>" class="infra-bg-parallax absolute inset-0 w-full h-full object-cover pointer-events-none opacity-100 z-0" alt="" aria-hidden="true" loading="lazy" />

        <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12 relative z-10" role="list">
            
            <?php 
            foreach ($items as $index => $item) :
                if (empty($item['title'])) continue;
                $icon_file = isset($item['icon']) ? basename($item['icon']) : '';
                $icon_path = ALSALAM_DIR . '/assets/images/' . $icon_file;
            ?>
            <li class="infra-stagger-item flex flex-col items-center text-center relative group">
                <div class="w-24 h-24 rounded-[30px] bg-white/10 backdrop-blur-md flex items-center justify-center mb-6 transition-transform duration-300 group-hover:-translate-y-2" aria-hidden="true">
                    <span class="w-16 h-16 flex items-center justify-center text-white">
                        <?php 
                        if (!empty($icon_file) && file_exists($icon_path)) {
                            // If it's an SVG file, include it inline so it renders in white
                            if (strpos($icon_file, '.svg') !== false) {
                                include $icon_path;
                            } else {
                                echo '<img src="' . esc_url(alsalam_img($icon_file)) . '" class="w-full h-full object-contain invert" alt="" />';
                            }
                        }
                        ?>
                    </span>
                </div>
                <h3 class="text-white text-xl font-bold mb-3 min-h-[3.5rem] flex items-center justify-center"><?php echo esc_html(pll__($item['title'])); ?></h3>
                <p class="text-white/80 text-sm leading-relaxed max-w-xs">
                    <?php echo wp_kses_post(pll__($item['desc'])); ?>
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
