<?php
/**
 * Single Gallery Item View for alsalam_gallery CPT
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

get_header();

while (have_posts()) : the_post();
    $current_id = get_the_ID();
    $g_cats = get_the_terms($current_id, 'gallery_cat');
    $g_cat_name = !empty($g_cats) && !is_wp_error($g_cats) ? $g_cats[0]->name : __('Facility', 'alsalam');
    $location = get_post_meta($current_id, '_alsalam_gallery_location', true);
    $photographer = get_post_meta($current_id, '_alsalam_gallery_photographer', true);
?>

<!-- Main Content Layout -->
<main class="flex-grow">
  
  <!-- SUBPAGE HERO / BANNER -->
  <section class="relative bg-[#041424] min-h-[400px] flex flex-col justify-end pb-16 overflow-hidden">
    <!-- Layer 1 -->
    <div class="absolute inset-0 z-[1] bg-gradient-to-tr from-[#041424]/95 via-[#05293b]/80 to-[#0a3d3f]/55 backdrop-blur-[2px]"></div>
    <div class="absolute inset-0 z-[2] bg-primary/10 backdrop-blur-sm"></div>

    <!-- Layer 2 -->
    <img src="<?php echo esc_url(alsalam_img('top-right-bg.png')); ?>" alt="" class="absolute top-0 end-0 w-auto h-auto max-w-[65%] lg:max-w-[50%] object-contain pointer-events-none z-[3]" role="presentation">
    <img src="<?php echo esc_url(alsalam_img('bottom-left.png')); ?>" alt="" class="absolute bottom-0 start-0 w-auto h-auto max-w-[65%] lg:max-w-[50%] object-contain pointer-events-none z-[3]" role="presentation">

    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center pt-36">
      <!-- Breadcrumbs -->
      <nav class="flex items-center justify-center gap-2 mb-4 text-xs font-semibold text-white/50 tracking-wider uppercase font-sans">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-light transition-colors duration-200"><?php echo esc_html(__('Home', 'alsalam')); ?></a>
        <span class="text-white/30 font-light">/</span>
        <a href="<?php echo esc_url(get_post_type_archive_link('alsalam_gallery') ?: home_url('/gallery')); ?>" class="hover:text-primary-light transition-colors duration-200"><?php echo esc_html(__('Gallery', 'alsalam')); ?></a>
        <span class="text-white/30 font-light">/</span>
        <span class="text-white/85"><?php the_title(); ?></span>
      </nav>
      
      <!-- Title -->
      <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight font-heading leading-tight mb-4">
        <?php the_title(); ?>
      </h1>
      
      <span class="inline-block rounded-full bg-primary/30 border border-white/20 px-3.5 py-1 text-[10px] font-bold tracking-wider text-primary-light uppercase">
        <?php echo esc_html($g_cat_name); ?>
      </span>
    </div>
  </section>

  <!-- SECTION: PHOTO & DETAILS -->
  <section class="py-20 lg:py-24 bg-white relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 relative z-10">
      
      <!-- Featured Photo -->
      <div class="relative rounded-[35px] overflow-hidden shadow-2xl mb-12 border border-slate-100/50">
        <?php if (has_post_thumbnail()): ?>
          <?php the_post_thumbnail('full', ['class' => 'w-full h-auto object-cover']); ?>
        <?php else: ?>
          <img src="<?php echo esc_url(alsalam_img('news1.jpg')); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-auto object-cover" />
        <?php endif; ?>
      </div>

      <?php if ($location || $photographer): ?>
      <div class="flex flex-wrap items-center gap-6 mb-8 text-sm text-slate-500 bg-slate-50 p-4 rounded-2xl border border-slate-100">
          <?php if ($location): ?>
          <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
              <span class="font-medium text-slate-700"><?php echo esc_html(__('Location:', 'alsalam')); ?></span> <?php echo esc_html($location); ?>
          </div>
          <?php endif; ?>
          <?php if ($photographer): ?>
          <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
              <span class="font-medium text-slate-700"><?php echo esc_html(__('Photographer:', 'alsalam')); ?></span> <?php echo esc_html($photographer); ?>
          </div>
          <?php endif; ?>
      </div>
      <?php endif; ?>

      <!-- Description Content -->
      <div class="prose max-w-none space-y-6 text-[#3A3A3A] text-[16px] leading-relaxed">
        <?php the_content(); ?>
      </div>

    </div>
  </section>

</main>

<?php 
endwhile;
get_footer();
?>
