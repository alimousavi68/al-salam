<?php
/**
 * The template for displaying single posts (News & Blog Articles)
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

get_header();

while (have_posts()) : the_post();
    $current_id = get_the_ID();
    $categories = get_the_category();
    $primary_cat = !empty($categories) ? $categories[0] : null;
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
        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-light transition-colors duration-200"><?php echo esc_html(__('Home', 'alsalam')); ?></a>
        <span class="text-white/30 font-light">/</span>
        <a href="<?php echo esc_url(get_post_type_archive_link('post') ?: home_url('/news')); ?>" class="hover:text-primary-light transition-colors duration-200"><?php echo esc_html(__('News & Events', 'alsalam')); ?></a>
        <span class="text-white/30 font-light">/</span>
        <span class="text-white/85"><?php echo esc_html(__('Article Details', 'alsalam')); ?></span>
      </nav>
      
      <!-- Title -->
      <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight font-heading leading-tight mb-4">
        <?php the_title(); ?>
      </h1>
      
      <!-- Metadata -->
      <div class="flex items-center justify-center gap-4 text-xs font-bold text-slate-300 tracking-wider uppercase">
        <?php if ($primary_cat): ?>
          <a href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>" class="inline-block rounded-full bg-primary/30 border border-white/20 px-3.5 py-1 text-[10px] text-primary-light hover:bg-primary/50 transition-colors">
            <?php echo esc_html($primary_cat->name); ?>
          </a>
        <?php endif; ?>
        <span class="flex items-center gap-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span><?php echo alsalam_date('Y/m/d'); ?></span>
        </span>
      </div>
    </div>
  </section>

  <!-- SECTION: ARTICLE BODY -->
  <section class="py-20 lg:py-24 bg-white relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 relative z-10 text-start">
      
      <!-- Featured Image Card -->
      <?php if (has_post_thumbnail()): ?>
        <div class="relative rounded-[35px] overflow-hidden shadow-2xl mb-12 border border-slate-100/50 max-h-[460px]">
          <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
        </div>
      <?php endif; ?>

      <!-- Article Content -->
      <div class="prose max-w-none space-y-8 text-[#3A3A3A] text-[16px] sm:text-[17px] leading-relaxed">
        <?php the_content(); ?>
      </div>

    </div>
  </section>

  <!-- SECTION: RELATED NEWS -->
  <?php
  $related_args = [
      'post_type'      => 'post',
      'posts_per_page' => 3,
      'post__not_in'   => [$current_id],
      'orderby'        => 'date',
      'order'          => 'DESC'
  ];
  if ($primary_cat) {
      $related_args['cat'] = $primary_cat->term_id;
  }
  $related_query = new WP_Query($related_args);
  if ($related_query->have_posts()):
  ?>
  <section class="py-20 bg-[#EAF3F5] border-t border-slate-100 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <header class="flex flex-col items-center text-center mb-16">
        <h2 class="text-[#071D2C] text-2xl sm:text-3xl font-extrabold tracking-tight font-heading">
          <?php echo wp_kses_post(__('Related <span class="text-teal-500">News</span> &amp; Updates', 'alsalam')); ?>
        </h2>
        <div class="w-12 h-1 bg-primary mt-3 rounded-full"></div>
      </header>

      <!-- Related Cards Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php while ($related_query->have_posts()): $related_query->the_post(); ?>
          <a 
            href="<?php the_permalink(); ?>" 
            class="group bg-white rounded-[30px] p-6 shadow-sm hover:shadow-xl border border-slate-100 flex flex-col justify-between h-[360px] transition-all duration-300 transform hover:-translate-y-1.5"
          >
            <div class="relative w-full h-[180px] bg-[#EAF3F5] rounded-2xl overflow-hidden mb-6">
              <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
              <?php else: ?>
                <img src="<?php echo esc_url(alsalam_img('news1.jpg')); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
              <?php endif; ?>
            </div>
            <div class="text-start">
              <?php
              $r_cats = get_the_category();
              $r_cat_name = !empty($r_cats) ? $r_cats[0]->name : '';
              ?>
              <?php if ($r_cat_name): ?>
                <span class="text-primary text-[10px] font-bold tracking-wider uppercase mb-1 block">
                  <?php echo esc_html($r_cat_name); ?>
                </span>
              <?php endif; ?>
              <h3 class="text-[#071D2C] text-base font-bold font-heading group-hover:text-primary transition-colors duration-200 truncate">
                <?php the_title(); ?>
              </h3>
            </div>
          </a>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>

    </div>
  </section>
  <?php endif; ?>

</main>

<?php 
endwhile;
get_footer(); 
?>
