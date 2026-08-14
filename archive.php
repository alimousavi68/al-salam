<?php
/**
 * The template for displaying archive pages (Category, Tag, Author, Date archives)
 * 
 * @package alsalam
 */

defined('ABSPATH') || exit;

get_header();

$cat_title = single_term_title('', false);
if (is_rtl()) {
    $hero_title = sprintf('أرشيف: <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">%s</span>', esc_html($cat_title));
} else {
    $hero_title = sprintf('Category: <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">%s</span>', esc_html($cat_title));
}

$hero_subtitle = get_the_archive_description() ?: __('Explore articles and updates registered under this category.', 'alsalam');
$categories    = get_categories(['hide_empty' => false]);
$current_cat   = get_queried_object_id();
?>

<!-- Main Content Layout -->
<main class="flex-grow">
  
  <!-- SUBPAGE HERO / BANNER -->
  <section class="relative bg-[#041424] min-h-[400px] flex flex-col justify-end pb-16 overflow-hidden">
    <!-- Layer 1: Teal/Slate gradient overlay with glassmorphism matching homepage hero -->
    <div class="absolute inset-0 z-[1] bg-gradient-to-tr from-[#041424]/95 via-[#05293b]/80 to-[#0a3d3f]/55 backdrop-blur-[2px]"></div>
    <div class="absolute inset-0 z-[2] bg-primary/10 backdrop-blur-sm"></div>

    <!-- Layer 2: Decoration PNG Images matching homepage hero -->
    <img 
      src="<?php echo esc_url(alsalam_img('top-right-bg.png')); ?>" 
      alt="" 
      class="absolute top-0 end-0 w-auto h-auto max-w-[65%] lg:max-w-[50%] object-contain pointer-events-none z-[3]" 
      role="presentation"
    >
    <img 
      src="<?php echo esc_url(alsalam_img('bottom-left.png')); ?>" 
      alt="" 
      class="absolute bottom-0 start-0 w-auto h-auto max-w-[65%] lg:max-w-[50%] object-contain pointer-events-none z-[3]" 
      role="presentation"
    >

    <!-- Hero Banner Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center pt-36">
      <!-- Breadcrumbs -->
      <nav class="flex items-center justify-center gap-2 mb-4 text-xs font-semibold text-white/50 tracking-wider uppercase font-sans">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-light transition-colors duration-200"><?php esc_html_e('Home', 'alsalam'); ?></a>
        <span class="text-white/30 font-light">/</span>
        <a href="<?php echo esc_url(home_url('/news')); ?>" class="hover:text-primary-light transition-colors duration-200"><?php esc_html_e('News & Events', 'alsalam'); ?></a>
        <span class="text-white/30 font-light">/</span>
        <span class="text-white/85"><?php echo esc_html($cat_title); ?></span>
      </nav>
      
      <!-- Title -->
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight font-heading leading-tight mb-4">
        <?php echo wp_kses_post($hero_title); ?>
      </h1>
      
      <!-- Subtitle -->
      <p class="max-w-2xl mx-auto text-base sm:text-lg text-white/70 font-normal leading-relaxed">
        <?php echo wp_kses_post($hero_subtitle); ?>
      </p>
    </div>
  </section>

  <!-- SECTION: NEWS LISTING -->
  <section class="py-16 pb-24 bg-[#F4F7FE]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Category Filter Bar -->
      <div class="flex flex-wrap justify-center items-center gap-3 mb-16">
        <a 
          href="<?php echo esc_url(get_post_type_archive_link('post') ?: home_url('/news')); ?>" 
          class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200"
        >
          <?php esc_html_e('All Updates', 'alsalam'); ?>
        </a>
        <?php foreach ($categories as $cat): ?>
          <a 
            href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" 
            class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 <?php echo ($current_cat === $cat->term_id) ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'; ?>"
          >
            <?php echo esc_html($cat->name); ?>
          </a>
        <?php endforeach; ?>
      </div>

      <?php if (have_posts()): ?>
      <!-- News Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php while (have_posts()) : the_post(); ?>
        <!-- Article Card -->
        <article class="bg-white rounded-[30px] p-6 flex flex-col relative transition-shadow duration-500 w-full h-[540px] max-w-[344px] mx-auto border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
          <!-- Image Area & Step Cutout Date Badge -->
          <div class="relative w-full h-[300px] max-w-[296px] rounded-[30px] ltr:rounded-br-none rtl:rounded-bl-none overflow-hidden mb-6">
            <?php if (has_post_thumbnail()): ?>
              <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover']); ?>
            <?php else: ?>
              <img src="<?php echo esc_url(alsalam_img('news1.jpg')); ?>" class="w-full h-full object-cover" alt="<?php the_title_attribute(); ?>" loading="lazy" />
            <?php endif; ?>
            
            <!-- The Step Cutout (Date Wrapper) -->
            <div class="absolute bottom-0 end-0 bg-white py-2.5 ps-5 pe-4 rounded-[30px] ltr:rounded-br-none rtl:rounded-bl-none flex items-center gap-1.5 shadow-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span class="text-xs font-bold text-slate-800"><?php echo get_the_date('Y/m/d'); ?></span>
            </div>
          </div>

          <!-- Typography & Content -->
          <h3 class="text-xl font-bold text-slate-900 mb-2 leading-tight tracking-tight font-heading">
            <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors"><?php the_title(); ?></a>
          </h3>
          <p class="text-sm text-slate-500 mb-6 line-clamp-2 leading-relaxed">
            <?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
          </p>

          <!-- Read More Button -->
          <a href="<?php the_permalink(); ?>" class="flex items-center justify-between w-full bg-teal-500 text-white px-5 py-3 rounded-full mt-auto hover:bg-teal-600 transition-colors duration-300 font-semibold group shadow-md shadow-teal-500/10">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span class="font-medium text-sm"><?php esc_html_e('Read More', 'alsalam'); ?></span>
            </div>
            
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transform transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 rtl:-scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H7M17 7V17" />
            </svg>
          </a>
        </article>
        <?php endwhile; ?>
      </div>

      <!-- WordPress Standard Pagination -->
      <div class="flex items-center justify-center gap-2 mt-16">
        <?php
        the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 rtl:rotate-180"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>',
            'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 rtl:rotate-180"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>',
        ]);
        ?>
      </div>
      <?php else: ?>
        <p class="text-center text-slate-500 font-semibold py-12"><?php esc_html_e('No articles found in this category.', 'alsalam'); ?></p>
      <?php endif; ?>

    </div>
  </section>

</main>

<?php get_footer(); ?>
