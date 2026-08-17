<?php
/**
 * Gallery Section Template Part
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

$args = [
    'post_type'      => 'alsalam_gallery',
    'posts_per_page' => 10,
    'post_status'    => 'publish'
];
$gallery_query = new WP_Query($args);
?>

<section class="relative w-full px-4 mb-24 z-10">
  <div class="bg-[#0a1120] rounded-[1.5rem] sm:rounded-[2.5rem] relative overflow-hidden w-full max-w-[90rem] min-h-[460px] sm:min-h-[600px] lg:h-[720px] mx-auto py-8 sm:py-16 px-4 sm:px-12 lg:px-20 shadow-2xl">

    <svg class="absolute inset-0 w-full h-full opacity-5 pointer-events-none stroke-teal-500/30" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
      <defs>
        <pattern id="gallery-grid" width="40" height="40" patternUnits="userSpaceOnUse">
          <path d="M 40 0 L 0 0 0 40" fill="none" stroke-width="0.5" />
          <circle cx="40" cy="40" r="1" fill="currentColor" />
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#gallery-grid)" />
    </svg>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 sm:mb-16 gap-4 relative z-10 gsap-fade-up">
      <div class="space-y-2">
        <span class="text-teal-500 text-xl md:text-2xl font-bold tracking-wider block font-heading uppercase"><?php echo esc_html(pll__('AL-SALAM')); ?></span>
        <h2 class="text-white text-3xl md:text-5xl font-extrabold tracking-tight font-heading"><?php echo esc_html(pll__('Company Gallery')); ?></h2>
      </div>
      <a href="<?php echo esc_url(get_post_type_archive_link('alsalam_gallery') ?: home_url('/gallery')); ?>" class="bg-teal-500 hover:bg-teal-600 active:scale-95 text-white font-semibold px-7 py-3 rounded-full flex items-center gap-2.5 transition-all duration-300 shadow-lg shadow-teal-500/20 group">
        <span><?php echo esc_html(pll__('All Photos')); ?></span>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transform transition-transform duration-300 group-hover:translate-x-1 rtl:group-hover:-translate-x-1 rtl:-scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </a>
    </div>

    <div class="relative w-full pb-8 gsap-fade-up">

      <div class="gallery-nav-btn gallery-prev hidden sm:flex" id="gallery-prev" role="button" aria-label="<?php esc_attr_e('Previous slide', 'alsalam'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
      </div>

      <div class="gallery-nav-btn gallery-next hidden sm:flex" id="gallery-next" role="button" aria-label="<?php esc_attr_e('Next slide', 'alsalam'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </div>

      <!-- Mobile: horizontal scroll, sm+: accordion -->
      <div id="gallery-accordion" class="flex w-full h-[260px] sm:h-[340px] lg:h-[420px] gap-[10px] sm:gap-[20px] overflow-x-auto sm:overflow-hidden scroll-smooth snap-x snap-mandatory sm:snap-none"
           style="scrollbar-width: none; -ms-overflow-style: none;">

        <?php 
        if ($gallery_query->have_posts()): 
            while ($gallery_query->have_posts()): $gallery_query->the_post();
                $media_type = get_post_meta(get_the_ID(), '_alsalam_gallery_media_type', true) ?: 'image';
                $isPlay = ($media_type === 'video');
                $g_cats = get_the_terms(get_the_ID(), 'gallery_cat');
                $g_cat_name = !empty($g_cats) && !is_wp_error($g_cats) ? $g_cats[0]->name : __('Facility', 'alsalam');
                $g_cat_name = pll__($g_cat_name);
                $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : alsalam_img('gallery/p1.webp');
        ?>
        <a href="<?php the_permalink(); ?>" class="gallery-item block group">
          <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
          <div class="gallery-play-wrapper">
            <div class="gallery-play-btn group-hover:scale-110 group-hover:bg-teal-500/50 transition-all duration-300" role="button" aria-label="<?php echo $isPlay ? esc_attr__('Play video', 'alsalam') : esc_attr__('View gallery', 'alsalam'); ?>">
              <?php if ($isPlay): ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="26" height="26">
                  <path d="M8 5v14l11-7z"/>
                </svg>
              <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="26" height="26">
                  <path d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-11-4l2.03 2.71L16 11l4 5H8l3-4zM2 6v14c0 1.1.9 2 2 2h14v-2H4V6H2z"/>
                </svg>
              <?php endif; ?>
            </div>
          </div>
          <div class="gallery-slide-overlay">
            <div class="gallery-slide-info">
              <span class="text-teal-400 text-xs font-semibold uppercase tracking-wider"><?php echo esc_html($g_cat_name); ?></span>
              <h3 class="text-white text-lg sm:text-xl font-bold mt-1 group-hover:text-teal-300 transition-colors duration-300 whitespace-nowrap overflow-hidden text-ellipsis"><?php the_title(); ?></h3>
            </div>
          </div>
        </a>
        <?php 
            endwhile;
            wp_reset_postdata();
        endif; 
        ?>

      </div>
    </div>

  </div>
</section>
