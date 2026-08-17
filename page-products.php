<?php
/**
 * Template Name: Products Portfolio
 * Dedicated Products Portfolio Page - AL-SALAM
 * Displays our sterile pharmaceutical portfolio in a structured grid with category filters and pagination.
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
$hero_title = $meta('_alsalam_hero_title') ?: 'Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">Products</span>';
$hero_subtitle = $meta('_alsalam_hero_subtitle', 'Explore our comprehensive portfolio of European GMP certified sterile infusion solutions, parenteral electrolytes, and specialized APIs.');

// Fetch product categories
$product_cats = get_terms([
    'taxonomy'   => 'product_cat',
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
        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-light transition-colors duration-200"><?php echo esc_html(pll__('Home')); ?></a>
        <span class="text-white/30 font-light">/</span>
        <span class="text-white/85"><?php echo esc_html(pll__('Our Products')); ?></span>
      </nav>
      
      <!-- Title -->
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight font-heading leading-tight mb-4">
        <?php echo wp_kses_post(pll__($hero_title)); ?>
      </h1>
      
      <!-- Subtitle -->
      <p class="max-w-2xl mx-auto text-base sm:text-lg text-white/70 font-normal leading-relaxed">
        <?php echo esc_html(pll__($hero_subtitle)); ?>
      </p>
    </div>
  </section>
  <?php endif; ?>

  <!-- SECTION: PRODUCTS PORTFOLIO -->
  <section class="py-20 lg:py-24 bg-[#F4F7FE]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Category Filter Pills Bar -->
      <div class="flex flex-wrap justify-center items-center gap-3 mb-16">
        <a href="<?php echo esc_url(get_permalink()); ?>" class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-primary text-white shadow-md shadow-primary/20">
          <?php echo esc_html(pll__('All Products')); ?>
        </a>
        <?php if (!empty($product_cats) && !is_wp_error($product_cats)): ?>
          <?php foreach ($product_cats as $cat): ?>
            <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200">
              <?php echo esc_html(pll__($cat->name)); ?>
            </a>
          <?php endforeach; ?>
        <?php else: ?>
          <span class="px-6 py-2.5 rounded-full text-sm font-semibold bg-white text-slate-700 border border-slate-200"><?php echo esc_html(pll__('Electrolyte Solutions')); ?></span>
          <span class="px-6 py-2.5 rounded-full text-sm font-semibold bg-white text-slate-700 border border-slate-200"><?php echo esc_html(pll__('Sterile Fluids')); ?></span>
        <?php endif; ?>
      </div>

      <?php
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      $args = [
          'post_type'      => 'alsalam_product',
          'posts_per_page' => 12,
          'paged'          => $paged
      ];
      $products_query = new WP_Query($args);

      if ($products_query->have_posts()):
      ?>
        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="products-grid">
          <?php while ($products_query->have_posts()): $products_query->the_post(); ?>
            <?php
            $tag1 = get_post_meta(get_the_ID(), '_alsalam_product_tag1', true) ?: 'BFS Bottle';
            $tag2 = get_post_meta(get_the_ID(), '_alsalam_product_tag2', true) ?: '500ml';
            $tag3 = get_post_meta(get_the_ID(), '_alsalam_product_tag3', true) ?: 'GMP Certified';
            ?>
            <!-- Product Card -->
            <div class="bg-white p-6 border border-slate-100 rounded-[2rem] flex flex-col justify-between items-center text-center shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
              <div class="w-full flex flex-col items-center">
                <!-- Frame for Product Image -->
                <div class="w-40 h-[137px] rounded-t-[100px] rounded-b-[20px] bg-slate-100/50 flex items-center justify-center mb-6 overflow-hidden relative">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('medium', ['class' => 'absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition-transform duration-500']); ?>
                  <?php else: ?>
                    <img src="<?php echo esc_url(alsalam_img('news1.jpg')); ?>" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition-transform duration-500" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                  <?php endif; ?>
                </div>
                
                <!-- Product Info -->
                <h3 class="text-xl font-bold text-slate-850 mb-2 font-heading tracking-tight leading-tight">
                  <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors"><?php the_title(); ?></a>
                </h3>
                <p class="text-slate-500 text-xs px-2 leading-relaxed mb-6">
                  <?php echo wp_trim_words(get_the_excerpt(), 14, '...'); ?>
                </p>
                
                <!-- Features / Tags Layout -->
                <div class="w-full flex flex-col gap-2.5 mb-6">
                  <div class="flex items-center gap-2 px-3 py-2 bg-slate-50 rounded-full border border-slate-100/80 justify-center">
                    <span class="text-xs font-semibold text-slate-600"><?php echo esc_html($tag1); ?></span>
                  </div>
                  
                  <div class="grid grid-cols-2 gap-2.5">
                    <div class="flex items-center gap-2 px-2.5 py-2 bg-slate-50 rounded-full border border-slate-100/80 justify-center">
                      <span class="text-xs font-semibold text-slate-600"><?php echo esc_html($tag2); ?></span>
                    </div>
                    <div class="flex items-center gap-2 px-2.5 py-2 bg-slate-50 rounded-full border border-slate-100/80 justify-center">
                      <span class="text-xs font-semibold text-slate-600"><?php echo esc_html($tag3); ?></span>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Action Button -->
              <a href="<?php the_permalink(); ?>" class="w-full h-[40px] bg-[#31858A] hover:bg-[#286f73] text-white ps-5 pe-0 rounded-full flex items-center justify-between transition-all duration-300 font-semibold group shadow-md shadow-teal-700/10">
                <span class="text-sm"><?php echo esc_html(pll__('View Details')); ?></span>
                <div class="w-[40px] h-[40px] rounded-full bg-white/10 flex items-center justify-center group-hover:translate-x-1 transition-transform duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-white rtl:-scale-x-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                  </svg>
                </div>
              </a>
            </div>
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
        <!-- Default Demo Grid if no CPT posts entered yet -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
          <?php 
          $sample_products = [
              ['title' => 'Sodium Chloride 0.9%', 'desc' => 'Isotonic parenteral electrolyte solution for fluid resuscitation.', 'tag1' => 'BFS Sterile Bottle', 'tag2' => '500ml', 'tag3' => 'GMP Certified'],
              ['title' => 'Glucose 5% Infusion', 'desc' => 'Sterile parenteral carbohydrate solution for caloric replenishment.', 'tag1' => 'Aseptic BFS Pack', 'tag2' => '500ml', 'tag3' => 'USP Standard'],
              ['title' => 'Ringer\'s Lactate', 'desc' => 'Balanced electrolyte replacement for surgical and trauma care.', 'tag1' => 'Class A Cleanroom', 'tag2' => '500ml', 'tag3' => 'European GMP'],
              ['title' => 'Metronidazole 500mg', 'desc' => 'Sterile antimicrobial infusion for critical hospital care.', 'tag1' => 'BFS Container', 'tag2' => '100ml', 'tag3' => 'Sterile API']
          ];
          foreach ($sample_products as $p):
          ?>
          <div class="bg-white p-6 border border-slate-100 rounded-[2rem] flex flex-col justify-between items-center text-center shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-full flex flex-col items-center">
              <div class="w-40 h-[137px] rounded-t-[100px] rounded-b-[20px] bg-slate-100/50 flex items-center justify-center mb-6 overflow-hidden relative">
                <img src="<?php echo esc_url(alsalam_img('news1.jpg')); ?>" class="absolute inset-0 w-full h-full object-cover" alt="" />
              </div>
              <h3 class="text-xl font-bold text-slate-850 mb-2 font-heading tracking-tight leading-tight"><?php echo esc_html($p['title']); ?></h3>
              <p class="text-slate-500 text-xs px-2 leading-relaxed mb-6"><?php echo esc_html($p['desc']); ?></p>
              <div class="w-full flex flex-col gap-2.5 mb-6">
                <div class="flex items-center gap-2 px-3 py-2 bg-slate-50 rounded-full border border-slate-100/80 justify-center">
                  <span class="text-xs font-semibold text-slate-600"><?php echo esc_html($p['tag1']); ?></span>
                </div>
                <div class="grid grid-cols-2 gap-2.5">
                  <div class="flex items-center gap-2 px-2.5 py-2 bg-slate-50 rounded-full border border-slate-100/80 justify-center">
                    <span class="text-xs font-semibold text-slate-600"><?php echo esc_html($p['tag2']); ?></span>
                  </div>
                  <div class="flex items-center gap-2 px-2.5 py-2 bg-slate-50 rounded-full border border-slate-100/80 justify-center">
                    <span class="text-xs font-semibold text-slate-600"><?php echo esc_html($p['tag3']); ?></span>
                  </div>
                </div>
              </div>
            </div>
            <a href="<?php echo esc_url(home_url('/inquiry?product=' . urlencode($p['title']))); ?>" class="w-full h-[40px] bg-[#31858A] hover:bg-[#286f73] text-white ps-5 pe-0 rounded-full flex items-center justify-between transition-all duration-300 font-semibold group shadow-md shadow-teal-700/10">
              <span class="text-sm"><?php echo esc_html(pll__('Request Inquiry')); ?></span>
              <div class="w-[40px] h-[40px] rounded-full bg-white/10 flex items-center justify-center group-hover:translate-x-1 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-white rtl:-scale-x-100">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
              </div>
            </a>
          </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </div>
  </section>

  <!-- SECTION: QUALITY STANDARDS BLOCK -->
  <section class="py-20 lg:py-24 bg-[#EAF3F5] relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(49,133,138,0.08),transparent_50%)]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-5">
          <h2 class="text-3xl sm:text-4xl font-extrabold text-[#071D2C] tracking-tight leading-tight font-heading mb-6">
            <?php echo esc_html(pll__('Stability & Sterility Assurance')); ?>
          </h2>
          <p class="text-slate-600 leading-relaxed mb-6">
            <?php echo esc_html(pll__('Our BFS parenteral formulations undergo 100% automated particulate and pyrogen testing to ensure zero contamination across critical supply chains.')); ?>
          </p>
          <ul class="space-y-4">
            <li class="flex items-center gap-3">
              <span class="w-6 h-6 rounded-full bg-teal-500/10 text-teal-600 flex items-center justify-center shrink-0">✓</span>
              <span class="text-sm text-slate-700 font-medium"><?php echo esc_html(pll__('Automated Leak Testing & Pyrogen Controls')); ?></span>
            </li>
            <li class="flex items-center gap-3">
              <span class="w-6 h-6 rounded-full bg-teal-500/10 text-teal-600 flex items-center justify-center shrink-0">✓</span>
              <span class="text-sm text-slate-700 font-medium"><?php echo esc_html(pll__('European Union GMP Class A Filling Standards')); ?></span>
            </li>
            <li class="flex items-center gap-3">
              <span class="w-6 h-6 rounded-full bg-teal-500/10 text-teal-600 flex items-center justify-center shrink-0">✓</span>
              <span class="text-sm text-slate-700 font-medium"><?php echo esc_html(pll__('High Thermal & Chemical Stability Packaging')); ?></span>
            </li>
          </ul>
        </div>
        <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h4 class="font-bold text-slate-850 mb-2 font-heading"><?php echo esc_html(pll__('Aseptic Validation')); ?></h4>
            <p class="text-slate-500 text-xs leading-relaxed"><?php echo esc_html(pll__('Every batch undergoes real-time parametric release testing to ensure compliance.')); ?></p>
          </div>
          <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <h4 class="font-bold text-slate-850 mb-2 font-heading"><?php echo esc_html(pll__('Regulatory Dossiers')); ?></h4>
            <p class="text-slate-500 text-xs leading-relaxed"><?php echo esc_html(pll__('Full CTD/eCTD dossier availability for hospital registration and tenders.')); ?></p>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
