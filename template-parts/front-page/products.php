<?php
/**
 * Template part for displaying the Products section on the front page.
 */

$enable = get_theme_mod('_alsalam_products_enable', '1');
if ($enable !== '1') return;

$title = pll__(get_theme_mod('_alsalam_products_title', 'Reliable Sterile Solutions'));
$subtitle = pll__(get_theme_mod('_alsalam_products_sub', 'European Standards, Iraqi Excellence'));
$btn_text = pll__(get_theme_mod('_alsalam_products_btn_text', 'All Products'));
$btn_link = get_theme_mod('_alsalam_products_btn_link', '#products');
$post_count = get_theme_mod('_alsalam_products_count', 10);

$current_lang = function_exists('pll_current_language') ? pll_current_language() : (is_rtl() ? 'ar' : 'en');

$args = array(
    'post_type'      => 'alsalam_product',
    'posts_per_page' => $post_count,
    'post_status'    => 'publish',
);
$products_query = new WP_Query($args);
?>
<section class="products-section relative w-full py-12 lg:py-24 z-0" id="products" style="overflow:visible;">
  <!-- The Background Band — hidden on mobile, visible on lg+ -->
  <div class="hidden lg:block absolute top-1/2 -translate-y-1/2 start-0 w-full h-[293px] bg-[#E5EEF4] -z-10 overflow-hidden">
    <!-- Left Background Pattern (Enlarged) -->
    <img src="<?php echo esc_url(alsalam_img('bg-pattern-left.svg')); ?>" class="h-[150%] max-w-none object-contain opacity-90 ltr:block rtl:hidden" alt="" loading="lazy" />
    <img src="<?php echo esc_url(alsalam_img('bg-pattern-right.svg')); ?>" class="h-[150%] max-w-none object-contain opacity-90 rtl:block ltr:hidden" alt="" loading="lazy" />
    
    <!-- Right Background Pattern (Enlarged) -->
    <img src="<?php echo esc_url(alsalam_img('bg-pattern-right.svg')); ?>" class="h-[150%] max-w-none object-contain opacity-90 ltr:block rtl:hidden" alt="" loading="lazy" />
    <img src="<?php echo esc_url(alsalam_img('bg-pattern-left.svg')); ?>" class="h-[150%] max-w-none object-contain opacity-90 rtl:block ltr:hidden" alt="" loading="lazy" />
  </div>

  <!-- Main Grid -->
  <div class="max-w-7xl mx-auto px-4 flex flex-col lg:flex-row items-center gap-12 lg:h-[560px]">
    <!-- Left Column (Width: lg:w-1/3 - Max 300px width on large screens) -->
    <div class="w-full lg:w-1/3 lg:max-w-[300px] text-center sm:text-start flex flex-col justify-center items-center sm:items-start">
      <h2 class="pt-[25px] text-[30px] sm:text-[36px] lg:text-[40px] font-extrabold tracking-tight leading-tight font-heading gsap-fade-up">
        <?php echo wp_kses_post($title); ?>
      </h2>
      
      <p class="text-slate-500 text-base mt-4 mb-8 font-sans leading-relaxed gsap-fade-up">
        <?php echo esc_html($subtitle); ?>
      </p>
      
      <a href="<?php echo esc_url($btn_link); ?>" class="inline-flex items-center justify-center gap-3 bg-[#071D2C] hover:bg-teal-700 active:scale-95 text-white font-medium rounded-full shadow-lg transition-all duration-300 group focus:outline-none min-w-[200px] h-[55px] font-sans self-center sm:self-start gsap-fade-up">
        <span class="text-base font-semibold tracking-wide"><?php echo esc_html($btn_text); ?></span>
        <svg class="w-4 h-4 transition-transform duration-300 ltr:group-hover:translate-x-1 rtl:group-hover:-translate-x-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </a>
    </div>

    <!-- Right Column (Swiper Carousel - Width: lg:w-2/3) -->
    <div class="w-full lg:w-2/3 h-full overflow-hidden flex flex-col justify-center">
      <!-- Mobile prev/next nav: displayed below the card, above dots -->
      <div class="swiper swiper-container-products relative h-full pb-14">
        <div class="swiper-wrapper flex items-stretch h-full">
          
          <?php 
          if ($products_query->have_posts()):
              while ($products_query->have_posts()): $products_query->the_post();
                  $tag1 = pll__(get_post_meta(get_the_ID(), '_alsalam_product_tag1', true) ?: 'BFS Bottle');
                  $tag2 = pll__(get_post_meta(get_the_ID(), '_alsalam_product_tag2', true) ?: '500ml');
                  $tag3 = pll__(get_post_meta(get_the_ID(), '_alsalam_product_tag3', true) ?: 'GMP Certified');
                  $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : alsalam_img('product.png');
                  $excerpt = get_the_excerpt();
                  if (empty($excerpt)) $excerpt = wp_trim_words(get_the_content(), 12, '...');
          ?>
          <!-- Swiper Slide Card -->
          <div class="swiper-slide swiper-slide-product lg:!h-[465px] p-6 border border-slate-100 rounded-[2rem] flex flex-col justify-between items-center text-center">
            <div class="w-full flex flex-col items-center">
              <!-- Frame for Product Image (Enlarged on mobile) -->
              <div class="w-48 sm:w-40 h-[165px] sm:h-[137px] rounded-t-[100px] rounded-b-[20px] bg-slate-100/50 flex items-center justify-center mb-6 overflow-hidden relative">
                <img src="<?php echo esc_url($image_url); ?>" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition-transform duration-500 rounded-none" alt="<?php the_title_attribute(); ?>" loading="lazy" />
              </div>
              
              <!-- Product Info -->
              <h3 class="text-xl font-bold text-slate-850 mb-2 font-heading tracking-tight leading-tight"><?php echo esc_html(pll__(get_the_title())); ?></h3>
              <p class="text-slate-500 text-xs px-2 leading-relaxed mb-6">
                <?php echo esc_html(pll__($excerpt)); ?>
              </p>
              
              <!-- Features / Tags Layout -->
              <div class="w-full flex flex-col gap-2.5 mb-6">
                <!-- Tag 1 -->
                <div class="flex items-center gap-2 px-3 py-2 h-[38px] bg-white rounded-full border border-slate-100/80 shadow-sm justify-center">
                  <img src="<?php echo esc_url(alsalam_img('papers-text (1).svg')); ?>" class="w-4 h-4 opacity-80" alt="" loading="lazy" />
                  <span class="text-xs font-semibold text-slate-600 truncate max-w-full"><?php echo esc_html($tag1); ?></span>
                </div>
                
                <!-- Tag 2 & 3 -->
                <div class="grid grid-cols-2 gap-2.5 items-stretch">
                  <div class="flex items-center gap-2 px-2.5 py-2 h-[38px] bg-white rounded-full border border-slate-100/80 shadow-sm justify-center overflow-hidden">
                    <img src="<?php echo esc_url(alsalam_img('test-tube-alt (1).svg')); ?>" class="w-4 h-4 opacity-80 shrink-0" alt="" loading="lazy" />
                    <span class="text-xs font-semibold text-slate-600 truncate"><?php echo esc_html($tag2); ?></span>
                  </div>
                  <div class="flex items-center gap-2 px-2.5 py-2 h-[38px] bg-white rounded-full border border-slate-100/80 shadow-sm justify-center overflow-hidden">
                    <img src="<?php echo esc_url(alsalam_img('award-star.png')); ?>" class="w-4 h-4 object-contain shrink-0" alt="" loading="lazy" />
                    <span class="text-xs font-semibold text-slate-600 truncate"><?php echo esc_html($tag3); ?></span>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Action Button: View Details -->
            <a href="<?php the_permalink(); ?>" class="w-full h-[34px] bg-[#31858A] hover:bg-[#286f73] text-white ps-5 pe-0 rounded-full flex items-center justify-between transition-all duration-300 font-semibold group shadow-md shadow-teal-700/10">
              <span class="text-sm"><?php echo esc_html(pll__('View Details')); ?></span>
              <div class="w-[34px] h-[34px] rounded-full bg-transparent flex items-center justify-center ltr:group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-300">
                <img src="<?php echo esc_url(alsalam_img('arrow-right.svg')); ?>" class="w-[17px] h-[17px] filter invert brightness-0 rtl:rotate-180" alt="Arrow" loading="lazy" />
              </div>
            </a>
          </div>
          <?php 
              endwhile;
              wp_reset_postdata();
          endif;
          ?>

        </div>

        <!-- Swiper Controls & Pagination Row -->
        <div class="flex items-center justify-center gap-4 mt-6 pt-2 relative z-10 products-controls-row">
          <button class="custom-prev w-10 h-10 rounded-full bg-white border border-slate-200 text-teal-600 shadow-sm flex items-center justify-center hover:bg-teal-50 shrink-0 transition-all active:scale-95 focus:outline-none" aria-label="<?php esc_attr_e('Previous slide', 'alsalam'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          
          <div class="swiper-pagination !static !w-auto flex items-center justify-center"></div>

          <button class="custom-next w-10 h-10 rounded-full bg-white border border-slate-200 text-teal-600 shadow-sm flex items-center justify-center hover:bg-teal-50 shrink-0 transition-all active:scale-95 focus:outline-none" aria-label="<?php esc_attr_e('Next slide', 'alsalam'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>
