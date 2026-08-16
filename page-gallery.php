<?php
/**
 * Template Name: Company Gallery
 * Dedicated Gallery Page - AL-SALAM
 * Premium modern aesthetics, interactive category filtering for facility photos.
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

get_header();

$meta = function($key, $default = '') {
    $val = get_post_meta(get_the_ID(), $key, true);
    return $val === '' ? $default : $val;
};

$show_hero = $meta('_alsalam_show_hero') !== '0';
$hero_title = $meta('_alsalam_hero_title') ?: 'Company <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">Gallery</span>';
$hero_subtitle = $meta('_alsalam_hero_subtitle', 'Take a look inside our sterile cleanroom operations, high-tech BFS processing systems, and microbiological laboratories.');

// Fetch gallery categories
$gallery_cats = get_terms([
    'taxonomy'   => 'gallery_cat',
    'hide_empty' => false,
]);
?>

<!-- Main Content Layout -->
<main class="flex-grow">
  
  <?php if ($show_hero): ?>
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
        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-light transition-colors duration-200"><?php echo esc_html(alsalam_str('home', 'Home')); ?></a>
        <span class="text-white/30 font-light">/</span>
        <span class="text-white/85"><?php echo esc_html(alsalam_str('gallery', 'Gallery')); ?></span>
      </nav>
      
      <!-- Title -->
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight font-heading leading-tight mb-4">
        <?php echo wp_kses_post(alsalam_str('', $hero_title)); ?>
      </h1>
      
      <!-- Subtitle -->
      <p class="max-w-2xl mx-auto text-base sm:text-lg text-white/70 font-normal leading-relaxed">
        <?php echo esc_html(alsalam_str('', $hero_subtitle)); ?>
      </p>
    </div>
  </section>
  <?php endif; ?>

  <!-- SECTION: GALLERY FILTER & GRID -->
  <section class="py-20 lg:py-24 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <!-- Filtering Pills Bar -->
      <div class="flex flex-wrap items-center justify-center gap-3 mb-12">
        <a href="<?php echo esc_url(get_permalink()); ?>" class="px-6 py-2.5 rounded-full text-sm font-semibold tracking-wide border transition-all duration-300 bg-slate-900 text-white border-slate-900 shadow-lg">
          <?php echo esc_html(alsalam_str('all_photos', 'All Photos')); ?>
        </a>
        <?php if (!empty($gallery_cats) && !is_wp_error($gallery_cats)): ?>
          <?php foreach ($gallery_cats as $cat): ?>
            <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="px-6 py-2.5 rounded-full text-sm font-semibold tracking-wide border border-slate-200 text-slate-600 hover:border-slate-900 hover:text-slate-900 transition-all duration-300 bg-white">
              <?php echo esc_html(alsalam_str('', $cat->name)); ?>
            </a>
          <?php endforeach; ?>
        <?php else: ?>
          <span class="px-6 py-2.5 rounded-full text-sm font-semibold border border-slate-200 text-slate-600 bg-white"><?php echo esc_html(alsalam_str('', 'R&D Center')); ?></span>
          <span class="px-6 py-2.5 rounded-full text-sm font-semibold border border-slate-200 text-slate-600 bg-white"><?php echo esc_html(alsalam_str('', 'Quality Assurance')); ?></span>
          <span class="px-6 py-2.5 rounded-full text-sm font-semibold border border-slate-200 text-slate-600 bg-white"><?php echo esc_html(alsalam_str('', 'Manufacturing')); ?></span>
        <?php endif; ?>
      </div>

      <?php
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      $args = [
          'post_type'      => 'alsalam_gallery',
          'posts_per_page' => 9,
          'paged'          => $paged
      ];
      $gallery_query = new WP_Query($args);

      if ($gallery_query->have_posts()):
      ?>
        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <?php while ($gallery_query->have_posts()): $gallery_query->the_post(); ?>
            <!-- Card Linking to single view -->
            <a 
              href="<?php the_permalink(); ?>"
              class="group relative bg-slate-50 rounded-[30px] overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 border border-slate-100 flex flex-col h-[380px]"
            >
              <!-- Image Container -->
              <div class="relative w-full flex-grow overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent z-10 opacity-70 group-hover:opacity-85 transition-opacity duration-300"></div>
                <?php if (has_post_thumbnail()): ?>
                  <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover transition-transform duration-750 ease-out group-hover:scale-105']); ?>
                <?php else: ?>
                  <img src="<?php echo esc_url(alsalam_img('news1.jpg')); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-750 ease-out group-hover:scale-105" />
                <?php endif; ?>
                
                <!-- Arrow Indicator overlay -->
                <div class="absolute inset-0 flex items-center justify-center z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                  <div class="w-14 h-14 rounded-full bg-primary/95 flex items-center justify-center text-white shadow-xl scale-90 group-hover:scale-100 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 rtl:-scale-x-100">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Information Panel -->
              <div class="absolute bottom-0 start-0 end-0 p-6 z-20">
                <?php
                $g_cats = get_the_terms(get_the_ID(), 'gallery_cat');
                $g_cat_name = !empty($g_cats) && !is_wp_error($g_cats) ? $g_cats[0]->name : __('Facility', 'alsalam');
                ?>
                <span class="inline-block rounded-full bg-primary/20 border border-white/10 px-3 py-1 text-[10px] font-bold tracking-wider text-primary-light uppercase mb-2">
                  <?php echo esc_html($g_cat_name); ?>
                </span>
                <h3 class="text-white text-lg font-bold font-heading leading-tight group-hover:text-primary-light transition-colors duration-200">
                  <?php the_title(); ?>
                </h3>
              </div>
            </a>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-center gap-2 mt-16">
          <?php
          the_posts_pagination([
              'mid_size'  => 2,
              'prev_text' => '‹',
              'next_text' => '›',
          ]);
          ?>
        </div>
      <?php else: ?>
        <!-- Demo Gallery Cards if no CPT items added yet -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <?php 
          $sample_gallery = [
              ['title' => 'BFS Sterile Bottling Line', 'cat' => 'Manufacturing'],
              ['title' => 'Microbiological QA Testing Lab', 'cat' => 'Quality Assurance'],
              ['title' => 'Cleanroom Class A Atmosphere', 'cat' => 'R&D Center'],
              ['title' => 'Temperature Controlled Logistics', 'cat' => 'Logistics']
          ];
          foreach ($sample_gallery as $g):
          ?>
          <div class="group relative bg-slate-50 rounded-[30px] overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 border border-slate-100 flex flex-col h-[380px]">
            <div class="relative w-full flex-grow overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent z-10 opacity-70 group-hover:opacity-85 transition-opacity duration-300"></div>
              <img src="<?php echo esc_url(alsalam_img('news1.jpg')); ?>" alt="" class="w-full h-full object-cover transition-transform duration-750 ease-out group-hover:scale-105" />
            </div>
            <div class="absolute bottom-0 start-0 end-0 p-6 z-20">
              <span class="inline-block rounded-full bg-primary/20 border border-white/10 px-3 py-1 text-[10px] font-bold tracking-wider text-primary-light uppercase mb-2">
                <?php echo esc_html($g['cat']); ?>
              </span>
              <h3 class="text-white text-lg font-bold font-heading leading-tight group-hover:text-primary-light transition-colors duration-200">
                <?php echo esc_html($g['title']); ?>
              </h3>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </div>
  </section>

</main>

<?php get_footer(); ?>
