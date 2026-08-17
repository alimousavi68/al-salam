<?php
/**
 * Testimonials Section Template Part
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;
?>
<?php if (get_theme_mod('_alsalam_testi_enable', '1') !== '1') return; ?>
<section class="w-full mt-16 sm:mt-20 overflow-hidden">
    <div class="w-full max-w-7xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row w-full lg:max-h-[420px] lg:h-[420px] relative shadow-sm">
            <div class="w-full lg:w-1/2 relative flex flex-col justify-center px-5 sm:px-8 lg:px-16 py-8 z-10">
                <div class="absolute inset-y-0 end-0 w-full lg:w-[50vw] bg-[#239BA8] -z-10"></div>
                
                <header class="flex items-center gap-3 mb-8 text-white gsap-fade-up">
                    <img src="<?php echo esc_url(alsalam_img('chats-text.svg')); ?>" alt="Customer Comments" class="w-10 h-10 drop-shadow-sm" loading="lazy">
                    <h2 class="text-3xl font-bold font-heading">
                        <?php echo wp_kses_post(pll__(get_theme_mod('_alsalam_testi_title', 'What Our Partners Say'))); ?>
                    </h2>
                </header>

                <div class="relative w-full gsap-fade-up">
                    <div class="swiper comment-swiper w-full pb-6">
                        <div class="swiper-wrapper">
                            <?php 
                            $current_lang = function_exists('pll_current_language') ? pll_current_language() : (is_rtl() ? 'ar' : 'en');
                            $suffix       = ($current_lang === 'ar') ? '_ar' : '';
                            $reviews_json = get_theme_mod('_alsalam_testi_reviews' . $suffix) ?: get_theme_mod('_alsalam_testi_reviews');
                            $reviews      = json_decode($reviews_json, true);
                            
                            if (!is_array($reviews) || empty($reviews)) {
                                $reviews = array();
                            }

                            foreach ($reviews as $review): 
                                if (empty($review['name'])) continue;
                            ?>
                            <div class="swiper-slide pt-4 pb-6">
                                <article class="bg-[#F8FAFC] rounded-[2rem] p-8 relative w-[88%] mx-auto shadow-xl shadow-black/5">
                                    <div class="absolute -top-2 end-6 ltr:translate-x-[20%] rtl:-translate-x-[20%] z-20 bg-black/30 backdrop-blur-md rounded-full px-5 py-2 flex items-center gap-2.5 shadow-lg">
                                        <span class="text-white text-base font-bold">(<?php echo esc_html($review['rating'] ?? '5.0'); ?>)</span>
                                        <div class="flex gap-1">
                                            <?php 
                                            $rating = floatval($review['rating'] ?? 5.0);
                                            $stars = round($rating);
                                            if ($stars > 5) $stars = 5;
                                            if ($stars < 1) $stars = 1;
                                            for ($i = 0; $i < $stars; $i++): 
                                            ?>
                                                <img src="<?php echo esc_url(alsalam_img('rating-star.svg')); ?>" alt="Star" class="w-5 h-5 object-contain" loading="lazy">
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <?php 
                                        $avatar = !empty($review['avatar']) ? $review['avatar'] : alsalam_img('avatar-man.jpg');
                                        ?>
                                        <img src="<?php echo esc_url($avatar); ?>" alt="Avatar" class="w-14 h-14 rounded-full border-2 border-white shadow-sm object-cover" loading="lazy">
                                        <div class="ms-4 flex flex-col">
                                            <span class="font-bold text-slate-900 font-heading"><?php echo esc_html(pll__($review['name'])); ?></span>
                                            <span class="text-sm text-slate-500 font-sans"><?php echo esc_html(pll__($review['role'] ?? '')); ?></span>
                                        </div>
                                        <span class="text-xs text-slate-400 ms-auto font-medium bg-slate-100 px-2 py-1 rounded-md font-sans"><?php echo esc_html(pll__($review['date'] ?? '')); ?></span>
                                    </div>

                                    <p class="text-slate-600 leading-relaxed mt-4 text-sm lg:text-base line-clamp-3 font-sans">
                                        "<?php echo esc_html(pll__($review['comment'] ?? '')); ?>"
                                    </p>
                                </article>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="comment-pagination flex justify-center mt-2 relative z-10"></div>
                    </div>

                    <button class="comment-prev absolute top-[45%] -translate-y-1/2 start-0 lg:-start-6 z-20 text-white font-bold p-3 hover:bg-white/10 backdrop-blur-sm rounded-full transition-all focus:outline-none flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 rtl:rotate-180">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <button class="comment-next absolute top-[45%] -translate-y-1/2 end-0 lg:-end-6 z-20 text-white font-bold p-3 hover:bg-white/10 backdrop-blur-sm rounded-full transition-all focus:outline-none flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 rtl:rotate-180">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="w-full lg:w-1/2 relative h-[280px] sm:h-[350px] lg:h-auto z-20">
                <a href="<?php echo esc_url(get_theme_mod('_alsalam_testi_btn_link', '#')); ?>" class="peer absolute bottom-12 start-0 ltr:-translate-x-1/2 rtl:translate-x-1/2 z-30 bg-[#239BA8] text-white px-6 py-2.5 rounded-full flex items-center gap-2 shadow-lg hover:bg-teal-600 transition-colors cursor-pointer whitespace-nowrap">
                    <span class="font-medium font-heading"><?php echo esc_html(pll__(get_theme_mod('_alsalam_testi_btn_text', 'All Comments'))); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </a>

                <div class="absolute inset-y-0 start-0 w-full lg:w-[50vw] bg-slate-100 -z-10 overflow-hidden [&>img]:transition-transform [&>img]:duration-700 peer-hover:[&>img]:scale-110">
                    <img src="<?php echo esc_url(get_theme_mod('_alsalam_testi_image', alsalam_img('testominals.webp'))); ?>" class="testi-bg-parallax w-full h-full object-cover" alt="Doctor Client" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>
