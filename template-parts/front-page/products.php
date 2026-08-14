<?php
/**
 * Template part for displaying the Products section on the front page.
 */

$enable = get_theme_mod('_alsalam_products_enable', '1');
if ($enable !== '1') return;

$title = get_theme_mod('_alsalam_products_title', 'Reliable Sterile Solutions');
$subtitle = get_theme_mod('_alsalam_products_sub', 'European Standards, Iraqi Excellence');
$btn_text = get_theme_mod('_alsalam_products_btn_text', 'All Products');
$btn_link = get_theme_mod('_alsalam_products_btn_link', '#products');
$post_count = get_theme_mod('_alsalam_products_count', 10);

$args = array(
    'post_type' => 'alsalam_product',
    'posts_per_page' => $post_count,
    'post_status' => 'publish',
);
$products_query = new WP_Query($args);
?>
<section class="products-section relative w-full py-24 overflow-hidden z-0" id="products">
  <!-- The Background Band (Set to exactly 293px height) -->
  <div class="absolute top-1/2 -translate-y-1/2 start-0 w-full h-[293px] bg-[#E5EEF4] -z-10 flex items-center justify-between overflow-hidden">
    <!-- Left Background Pattern (Enlarged) -->
    <img src="<?php echo esc_url(alsalam_img('bg-pattern-left.svg')); ?>" class="h-[150%] max-w-none object-contain opacity-90 ltr:block rtl:hidden" alt="" loading="lazy" />
    <img src="<?php echo esc_url(alsalam_img('bg-pattern-right.svg')); ?>" class="h-[150%] max-w-none object-contain opacity-90 rtl:block ltr:hidden" alt="" loading="lazy" />
    
    <!-- Right Background Pattern (Enlarged) -->
    <img src="<?php echo esc_url(alsalam_img('bg-pattern-right.svg')); ?>" class="h-[150%] max-w-none object-contain opacity-90 ltr:block rtl:hidden" alt="" loading="lazy" />
    <img src="<?php echo esc_url(alsalam_img('bg-pattern-left.svg')); ?>" class="h-[150%] max-w-none object-contain opacity-90 rtl:block ltr:hidden" alt="" loading="lazy" />
  </div>

  <!-- Main Grid -->
  <div class="max-w-7xl mx-auto px-4 flex flex-col lg:flex-row items-center gap-12 lg:h-[540px]">
    <!-- Left Column (Width: lg:w-1/3 - Max 300px width on large screens) -->
    <div class="w-full lg:w-1/3 lg:max-w-[300px] text-start flex flex-col justify-center">
      <h2 class="pt-[25px] text-[40px] font-extrabold tracking-tight leading-tight font-heading gsap-fade-up">
        <?php echo wp_kses_post($title); ?>
      </h2>
      <p class="text-slate-600 text-[20px] leading-relaxed font-sans gsap-fade-up mt-4">
        <?php echo esc_html($subtitle); ?>
      </p>
      
      <!-- Action & Navigation Stacked (Controls below the button) -->
      <div class="flex flex-col items-start gap-6 gsap-fade-up mt-8">
        <a href="<?php echo esc_url($btn_link); ?>" class="bg-teal-600 text-white px-6 py-3 rounded-full hover:bg-teal-700 font-semibold transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
          <span><?php echo esc_html($btn_text); ?></span>
          <img src="<?php echo esc_url(alsalam_img('arrow-right.svg')); ?>" class="w-4 h-4 filter invert brightness-0 rtl:rotate-180" alt="Arrow Right" loading="lazy" />
        </a>
        
        <!-- Controls Group (White background, theme teal-600 border, styled SVG icons) -->
        <div class="flex items-center gap-3">
          <button class="custom-prev w-12 h-12 rounded-full bg-white border-2 border-teal-600 hover:border-teal-700 text-teal-600 hover:bg-teal-50 flex items-center justify-center transition-all duration-300 focus:outline-none" aria-label="Previous slide">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button class="custom-next w-12 h-12 rounded-full bg-white border-2 border-teal-600 hover:border-teal-700 text-teal-600 hover:bg-teal-50 flex items-center justify-center transition-all duration-300 focus:outline-none" aria-label="Next slide">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Right Column - Swiper Setup (Width: lg:w-2/3 or expanded due to left max-width) -->
    <div class="w-full lg:flex-1 overflow-hidden h-full gsap-fade-up">
      <div class="swiper swiper-container-products relative h-full">
        <div class="swiper-wrapper flex items-stretch h-full">
          
          <?php 
          if ($products_query->have_posts()):
              while ($products_query->have_posts()): $products_query->the_post();
                  $tag1 = get_post_meta(get_the_ID(), '_alsalam_product_tag1', true) ?: 'BFS Bottle';
                  $tag2 = get_post_meta(get_the_ID(), '_alsalam_product_tag2', true) ?: '500ml';
                  $tag3 = get_post_meta(get_the_ID(), '_alsalam_product_tag3', true) ?: 'GMP Certified';
                  $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : alsalam_img('product.png');
                  $excerpt = get_the_excerpt();
                  if (empty($excerpt)) $excerpt = wp_trim_words(get_the_content(), 12, '...');
          ?>
          <!-- Swiper Slide Card -->
          <div class="swiper-slide swiper-slide-product lg:!h-[465px] p-6 border border-slate-100 rounded-[2rem] flex flex-col justify-between items-center text-center">
            <div class="w-full flex flex-col items-center">
              <!-- Frame for Product Image: top corners fully rounded (100%), bottom corners 20px, overflow hidden, containing product image filling the frame -->
              <div class="w-40 h-[137px] rounded-t-[100px] rounded-b-[20px] bg-slate-100/50 flex items-center justify-center mb-6 overflow-hidden relative">
                <img src="<?php echo esc_url($image_url); ?>" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition-transform duration-500 rounded-none" alt="<?php the_title_attribute(); ?>" loading="lazy" />
              </div>
              
              <!-- Product Info -->
              <h3 class="text-xl font-bold text-slate-850 mb-2 font-heading tracking-tight leading-tight"><?php the_title(); ?></h3>
              <p class="text-slate-500 text-xs px-2 leading-relaxed mb-6">
                <?php echo esc_html($excerpt); ?>
              </p>
              
              <!-- Features / Tags Layout -->
              <div class="w-full flex flex-col gap-2.5 mb-6">
                <!-- Tag 1: Electrolyte Solution (Full width) -->
                <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-full border border-slate-100/80 shadow-sm justify-center">
                  <img src="<?php echo esc_url(alsalam_img('papers-text (1).svg')); ?>" class="w-4 h-4 opacity-80" alt="Electrolyte" loading="lazy" />
                  <span class="text-xs font-semibold text-slate-600"><?php echo esc_html($tag1); ?></span>
                </div>
                
                <!-- Tag 2 & 3: Sterile & GMP (Split row) -->
                <div class="grid grid-cols-2 gap-2.5">
                  <div class="flex items-center gap-2 px-2.5 py-2 bg-white rounded-full border border-slate-100/80 shadow-sm justify-center">
                    <img src="<?php echo esc_url(alsalam_img('test-tube-alt (1).svg')); ?>" class="w-4 h-4 opacity-80" alt="Sterile" loading="lazy" />
                    <span class="text-xs font-semibold text-slate-600"><?php echo esc_html($tag2); ?></span>
                  </div>
                  <div class="flex items-center gap-2 px-2.5 py-2 bg-white rounded-full border border-slate-100/80 shadow-sm justify-center">
                    <img src="<?php echo esc_url(alsalam_img('award-star.png')); ?>" class="w-4 h-4 object-contain" alt="GMP" loading="lazy" />
                    <span class="text-xs font-semibold text-slate-600"><?php echo esc_html($tag3); ?></span>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Action Button: View Details -->
            <a href="<?php the_permalink(); ?>" class="w-full h-[34px] bg-[#31858A] hover:bg-[#286f73] text-white ps-5 pe-0 rounded-full flex items-center justify-between transition-all duration-300 font-semibold group shadow-md shadow-teal-700/10">
              <span class="text-sm"><?php esc_html_e('View Details', 'alsalam'); ?></span>
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

        <!-- Swiper Pagination (completely below cards) -->
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
</section>
