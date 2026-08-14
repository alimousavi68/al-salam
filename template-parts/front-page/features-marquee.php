<?php
/**
 * Features Marquee / Ticker Section Template Part
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;
?>
<?php if (get_theme_mod('_alsalam_marquee_enable', '1') !== '1') return; ?>
<section class="w-full gsap-fade-up">
    <div class="bg-[#0a1120] relative w-full py-6 shadow-sm flex justify-center">
        <div class="w-full max-w-7xl px-4 overflow-hidden">
            <div class="flex w-full group">
            <?php
            $pills_json = get_theme_mod('_alsalam_marquee_items');
            $pills = json_decode($pills_json, true);
            
            if (!is_array($pills) || empty($pills)) {
                $pills = array(
                    array('type' => 'B', 'text' => 'Trusted Quality', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 4h6v2h-6z"/><path d="M16 6v14a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V6"/><path d="M4 14h6"/><path d="M7 14v4"/><path d="M9 14v4"/><path d="M11 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>'),
                    array('type' => 'A', 'text' => 'Sterile Solutions', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 2v7.31"/><path d="M14 9.3V1.99"/><path d="M8.5 2h7"/><path d="M14 9.3a6.5 6.5 0 1 1-4 0"/><path d="M5.52 16h12.96"/></svg>'),
                    array('type' => 'B', 'text' => 'Precision in Sterile Care', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>'),
                    array('type' => 'A', 'text' => 'Iraqi Excellence', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"/><path d="M8 15v8"/><path d="M5 10h6"/><path d="M11.8 3.2a9 9 0 0 0 8.8 9.1c1.2.1 2.4.6 2.4 1.7v2c0 1.1-1.2 1.6-2.4 1.7A9 9 0 0 1 11.8 20.8"/><circle cx="20" cy="18" r="2"/></svg>'),
                    array('type' => 'B', 'text' => 'European Standards', 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>')
                );
            }

            for ($i = 0; $i < 2; $i++) {
                echo '<div class="flex shrink-0 animate-marquee items-center justify-around gap-12 pe-12 group-hover:[animation-play-state:paused]" ' . ($i === 1 ? 'aria-hidden="true"' : '') . '>';
                foreach ($pills as $pill) {
                    echo '<article class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full pe-6 ps-2 py-2 cursor-pointer hover:bg-white/10 transition-colors shrink-0">';
                    
                    if (!empty($pill['icon'])) {
                        // Image URL
                        echo '<div class="w-10 h-10 rounded-full ' . (isset($pill['type']) && $pill['type'] === 'A' ? 'bg-white shadow-sm' : 'border border-white/20 bg-white/5') . ' flex items-center justify-center shrink-0 overflow-hidden p-2">';
                        echo '<img src="' . esc_url($pill['icon']) . '" alt="" class="w-full h-full object-contain" loading="lazy" />';
                        echo '</div>';
                    } elseif (!empty($pill['svg'])) {
                        // Inline SVG
                        echo '<div class="w-10 h-10 rounded-full ' . (isset($pill['type']) && $pill['type'] === 'A' ? 'bg-white shadow-sm text-slate-900' : 'border border-white/20 bg-white/5 text-white') . ' flex items-center justify-center shrink-0">';
                        echo $pill['svg'];
                        echo '</div>';
                    }
                    
                    $title = !empty($pill['title']) ? $pill['title'] : (!empty($pill['text']) ? $pill['text'] : '');
                    echo '<span class="text-white font-medium text-sm md:text-base whitespace-nowrap">' . esc_html($title) . '</span>';
                    echo '</article>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>
