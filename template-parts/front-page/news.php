<?php
/**
 * News Section Template Part
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

if (get_theme_mod('_alsalam_news_enable', '1') !== '1') return;

// Detect current language
$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';

// Dynamically resolve Educational Category ID for ANY active language
$edu_term_id = 0;
if ($current_lang) {
    $terms = get_terms(array(
        'taxonomy'   => 'category',
        'hide_empty' => false,
    ));
    foreach ($terms as $term) {
        if (strpos(strtolower($term->slug), 'educational') !== false) {
            if (function_exists('pll_get_term_language')) {
                if (pll_get_term_language($term->term_id) === $current_lang) {
                    $edu_term_id = $term->term_id;
                    break;
                }
            } else {
                $edu_term_id = $term->term_id;
                break;
            }
        }
    }
}

// Retrieve Latest Posts (exclude educational category dynamically for current language)
$latest_args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

if ($edu_term_id) {
    $latest_args['category__not_in'] = array($edu_term_id);
}

$latest_query = new WP_Query($latest_args);

// Retrieve Educational Posts (dynamically for current language)
$educational_args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

if ($edu_term_id) {
    $educational_args['cat'] = $edu_term_id;
}

$educational_query = new WP_Query($educational_args);

// Fallback: If both queries return empty for any reason, fetch recent posts of current language
if (!$latest_query->have_posts() && !$educational_query->have_posts()) {
    $fallback_args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 6,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    $latest_query = new WP_Query($fallback_args);
}

// Combine posts into a structured array for Swiper
$swiper_slides = array();

if ($latest_query->have_posts()) {
    while ($latest_query->have_posts()) {
        $latest_query->the_post();
        $swiper_slides[] = array(
            'title'    => get_the_title(),
            'date'     => alsalam_date('Y/m/d'),
            'image'    => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : alsalam_img('news1.jpg'),
            'desc'     => get_the_excerpt(),
            'category' => 'latest',
            'link'     => get_permalink()
        );
    }
    wp_reset_postdata();
}

if ($educational_query->have_posts()) {
    while ($educational_query->have_posts()) {
        $educational_query->the_post();
        $swiper_slides[] = array(
            'title'    => get_the_title(),
            'date'     => alsalam_date('Y/m/d'),
            'image'    => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : alsalam_img('news2.jpg'),
            'desc'     => get_the_excerpt(),
            'category' => 'educational',
            'link'     => get_permalink()
        );
    }
    wp_reset_postdata();
}
?>
<section class="relative w-full pb-8 sm:pb-24 overflow-hidden bg-transparent z-0">
  <div class="absolute top-0 start-0 w-full h-[220px] sm:h-[300px] lg:h-[385px] bg-[#E5EFF2] -z-10"></div>

  <img src="<?php echo esc_url(alsalam_img('news-bg-pattern-top-left.png')); ?>" class="absolute top-0 left-0 -z-10 max-h-[300px] md:max-h-[400px] object-contain opacity-95 pointer-events-none" alt="" loading="lazy" />
  <img src="<?php echo esc_url(alsalam_img('news-bg-pattern-bootom-right.png')); ?>" class="absolute bottom-0 right-0 -z-10 max-h-[300px] md:max-h-[400px] object-contain opacity-95 pointer-events-none" alt="" loading="lazy" />

  <div class="max-w-7xl mx-auto px-4 pt-8 pb-4 flex flex-col md:flex-row justify-between items-center gap-6 relative z-10 gsap-fade-up">
    <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight font-heading">
      <?php echo wp_kses_post(pll__(get_theme_mod('_alsalam_news_title', 'News & Events'))); ?>
    </h2>

    <div class="flex items-center bg-white rounded-full p-1 shadow-sm border border-slate-100 shrink-0" id="news-tab-wrapper">
      <button onclick="switchNewsTab('latest')" id="tab-latest" class="px-4 sm:px-6 py-2 bg-teal-500 text-white font-medium rounded-full cursor-pointer shadow-md transition-all duration-300 whitespace-nowrap text-sm sm:text-base">
        <?php echo esc_html(pll__(get_theme_mod('_alsalam_news_tab1_label', 'Latest'))); ?>
      </button>
      <button onclick="switchNewsTab('educational')" id="tab-educational" class="px-4 sm:px-6 py-2 text-teal-600 font-medium rounded-full cursor-pointer transition-all duration-300 hover:text-teal-700 whitespace-nowrap text-sm sm:text-base">
        <?php echo esc_html(pll__(get_theme_mod('_alsalam_news_tab2_label', 'Educational'))); ?>
      </button>
    </div>
  </div>

  <div class="relative max-w-7xl mx-auto px-2 sm:px-4 py-3 news-swiper-container gsap-fade-up">
    <!-- Desktop-only absolute nav buttons (hidden on mobile) -->
    <button class="news-prev news-nav-btn hidden sm:flex absolute start-4 md:start-8 top-[42%] -translate-y-1/2 focus:outline-none" aria-label="<?php esc_attr_e('Previous slide', 'alsalam'); ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transform rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <button class="news-next news-nav-btn hidden sm:flex absolute end-4 md:end-8 top-[42%] -translate-y-1/2 focus:outline-none" aria-label="<?php esc_attr_e('Next slide', 'alsalam'); ?>">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transform rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
      </svg>
    </button>

    <div class="swiper news-swiper w-full max-w-[94vw] sm:max-w-[344px] md:max-w-[768px] lg:max-w-[1092px] mx-auto h-[560px] sm:h-[600px]">
      <div class="swiper-wrapper">
        
        <?php foreach ($swiper_slides as $item): ?>
        <div class="swiper-slide" data-category="<?php echo esc_attr($item['category']); ?>">
          <article class="bg-white rounded-[30px] p-5 sm:p-6 flex flex-col relative transition-shadow duration-500 w-full h-[540px] max-w-[344px] mx-auto border border-slate-100 shadow-none sm:shadow-[0_8px_32px_rgba(0,0,0,0.08)]">
            <div class="relative w-full h-[300px] max-w-[296px] rounded-[30px] ltr:rounded-br-none rtl:rounded-bl-none overflow-hidden mb-6">
              <img src="<?php echo esc_url($item['image']); ?>" class="w-full h-full object-cover" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy" />
              
              <div class="absolute bottom-0 end-0 bg-white py-2.5 ps-5 pe-4 rounded-[30px] ltr:rounded-br-none rtl:rounded-bl-none flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-xs font-bold text-slate-800"><?php echo esc_html($item['date']); ?></span>
              </div>
            </div>

            <h3 class="text-xl font-bold text-slate-900 mb-2 leading-tight tracking-tight font-heading">
              <?php echo esc_html(pll__($item['title'])); ?>
            </h3>
            <p class="text-sm text-slate-500 mb-6 line-clamp-2 leading-relaxed">
              <?php echo esc_html(pll__($item['desc'])); ?>
            </p>

            <a href="<?php echo esc_url($item['link']); ?>" class="flex items-center justify-between w-full bg-teal-500 text-white px-5 py-3 rounded-full mt-auto hover:bg-teal-600 transition-colors duration-300 font-semibold group shadow-md shadow-teal-500/10">
              <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-sm"><?php echo esc_html(pll__('Read More')); ?></span>
              </div>
              
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transform transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 rtl:-scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H7M17 7V17" />
              </svg>
            </a>
          </article>
        </div>
        <?php endforeach; ?>

      </div>

      <div class="swiper-pagination"></div>
    </div>

    <!-- Mobile-only nav row: prev | dots | next — OUTSIDE the fixed-height swiper div to prevent crop -->
    <div class="flex items-center justify-center gap-6 mt-4 sm:hidden news-mobile-nav-row">
      <button class="news-prev news-nav-btn shrink-0" aria-label="<?php esc_attr_e('Previous slide', 'alsalam'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button class="news-next news-nav-btn shrink-0" aria-label="<?php esc_attr_e('Next slide', 'alsalam'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </div>
</section>
