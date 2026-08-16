<?php
/**
 * Single Product Details View for alsalam_product CPT
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

get_header();

while (have_posts()) : the_post();
    $current_id = get_the_ID();
    $tag1 = get_post_meta($current_id, '_alsalam_product_tag1', true) ?: 'BFS Sterile Bottle';
    $tag2 = get_post_meta($current_id, '_alsalam_product_tag2', true) ?: '500ml';
    $tag3 = get_post_meta($current_id, '_alsalam_product_tag3', true) ?: 'GMP Certified';
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
        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-light transition-colors duration-200"><?php echo esc_html(alsalam_str('home', 'Home')); ?></a>
        <span class="text-white/30 font-light">/</span>
        <a href="<?php echo esc_url(get_post_type_archive_link('alsalam_product') ?: home_url('/products')); ?>" class="hover:text-primary-light transition-colors duration-200"><?php echo esc_html(alsalam_str('products', 'Products')); ?></a>
        <span class="text-white/30 font-light">/</span>
        <span class="text-white/85"><?php the_title(); ?></span>
      </nav>
      
      <!-- Title -->
      <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight font-heading leading-tight mb-4">
        <?php the_title(); ?>
      </h1>
      
      <!-- Category tags -->
      <div class="flex flex-wrap justify-center gap-2">
        <span class="inline-block rounded-full bg-primary/30 border border-white/20 px-3 py-1 text-[10px] font-bold tracking-wider text-primary-light uppercase">
          <?php echo esc_html(alsalam_str('', $tag1)); ?>
        </span>
        <span class="inline-block rounded-full bg-teal-500/20 border border-white/10 px-3 py-1 text-[10px] font-bold tracking-wider text-teal-300 uppercase">
          <?php echo esc_html(alsalam_str('', $tag2)); ?>
        </span>
        <span class="inline-block rounded-full bg-white/10 border border-white/10 px-3 py-1 text-[10px] font-bold tracking-wider text-white/85 uppercase">
          <?php echo esc_html(alsalam_str('', $tag3)); ?>
        </span>
      </div>
    </div>
  </section>

  <!-- SECTION: PRODUCT DETAIL SPECS -->
  <section class="py-20 lg:py-24 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
        
        <!-- Column 1: Image & Technical features -->
        <div class="lg:col-span-5 space-y-6">
          <div class="relative group rounded-[2.5rem] overflow-hidden shadow-2xl bg-[#EAF3F5] border border-slate-100 p-4 flex items-center justify-center min-h-[480px]">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-transparent pointer-events-none mix-blend-normal z-10"></div>
            <?php if (has_post_thumbnail()): ?>
              <?php the_post_thumbnail('large', ['class' => 'w-full h-auto max-h-[460px] object-contain rounded-[2rem] transition-transform duration-500 group-hover:scale-105']); ?>
            <?php else: ?>
              <img src="<?php echo esc_url(alsalam_img('news1.jpg')); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-auto max-h-[460px] object-contain rounded-[2rem] transition-transform duration-500 group-hover:scale-105" />
            <?php endif; ?>
          </div>
          
          <!-- Quality badging -->
          <div class="bg-[#F4F7FE] rounded-[30px] p-6 border border-slate-100 flex items-center gap-4 text-start">
            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div>
              <h4 class="font-bold font-heading text-[#071D2C] text-sm"><?php echo esc_html(alsalam_str('', 'European Standards Approved')); ?></h4>
              <p class="text-xs text-slate-500 mt-0.5"><?php echo esc_html(alsalam_str('', 'Tested & validation-indexed for therapeutic hospital networks.')); ?></p>
            </div>
          </div>
        </div>

        <!-- Column 2: Clinical Data & CTA -->
        <div class="lg:col-span-7 space-y-8 text-start">
          <div>
            <span class="inline-block rounded-full bg-[#E5F0F6] px-4 py-1.5 text-xs font-semibold tracking-wide text-slate-800 font-sans mb-4">
              <?php echo esc_html(alsalam_str('', 'Clinical Overview')); ?>
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#071D2C] tracking-tight mb-4 font-heading leading-tight">
              <?php echo esc_html(alsalam_str('', 'Product Formulation & Intent')); ?>
            </h2>
            <div class="prose max-w-none text-[#3A3A3A] text-[16px] leading-relaxed mb-6 font-normal">
              <?php the_content(); ?>
            </div>
          </div>

          <!-- Specifications Table -->
          <div class="border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
            <table class="w-full text-sm">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-[#071D2C] font-bold text-xs uppercase tracking-wider">
                  <th class="px-6 py-4 text-start font-heading"><?php echo esc_html(alsalam_str('', 'Specification Parameter')); ?></th>
                  <th class="px-6 py-4 text-start font-heading"><?php echo esc_html(alsalam_str('', 'Metric Details')); ?></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-slate-600">
                <tr>
                  <td class="px-6 py-4 font-medium text-[#071D2C]"><?php echo esc_html(alsalam_str('', 'Packaging presentation')); ?></td>
                  <td class="px-6 py-4"><?php echo esc_html(alsalam_str('', $tag1)); ?></td>
                </tr>
                <tr>
                  <td class="px-6 py-4 font-medium text-[#071D2C]"><?php echo esc_html(alsalam_str('', 'Volume Availability')); ?></td>
                  <td class="px-6 py-4"><?php echo esc_html(alsalam_str('', $tag2)); ?></td>
                </tr>
                <tr>
                  <td class="px-6 py-4 font-medium text-[#071D2C]"><?php echo esc_html(alsalam_str('', 'Quality Grade')); ?></td>
                  <td class="px-6 py-4"><?php echo esc_html(alsalam_str('', $tag3)); ?></td>
                </tr>
                <tr>
                  <td class="px-6 py-4 font-medium text-[#071D2C]"><?php echo esc_html(alsalam_str('', 'Shelf life')); ?></td>
                  <td class="px-6 py-4"><?php echo esc_html(alsalam_str('', '36 Months from packaging date')); ?></td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Request CTA Button -->
          <div class="pt-4">
            <a 
              href="<?php echo esc_url(home_url('/inquiry?product=' . urlencode(get_the_title()))); ?>" 
              class="inline-flex items-center justify-center gap-2.5 bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-8 py-4 rounded-full shadow-lg shadow-primary/20 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0"
            >
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span><?php echo esc_html(alsalam_str('request_inquiry', 'Request Commercial Inquiry')); ?></span>
            </a>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- SECTION: RELATED PRODUCTS -->
  <?php
  $args = [
      'post_type'      => 'alsalam_product',
      'posts_per_page' => 3,
      'post__not_in'   => [$current_id]
  ];
  $related_query = new WP_Query($args);
  if ($related_query->have_posts()):
  ?>
  <section class="py-20 bg-[#EAF3F5] border-t border-slate-100 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <header class="flex flex-col items-center text-center mb-16">
        <h2 class="text-[#071D2C] text-2xl sm:text-3xl font-extrabold tracking-tight font-heading">
          <?php echo wp_kses_post(alsalam_str('product_related_title', 'Related <span class="text-teal-500">Parenteral</span> Formulations')); ?>
        </h2>
        <div class="w-12 h-1 bg-primary mt-3 rounded-full"></div>
      </header>

      <!-- Product Cards Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php while ($related_query->have_posts()): $related_query->the_post(); ?>
          <a 
            href="<?php the_permalink(); ?>" 
            class="group bg-white rounded-[30px] p-6 shadow-sm hover:shadow-xl border border-slate-100/50 flex flex-col justify-between h-[360px] transition-all duration-300 transform hover:-translate-y-1.5"
          >
            <div class="relative w-full h-[180px] bg-[#EAF3F5] rounded-2xl flex items-center justify-center overflow-hidden mb-6">
              <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
              <?php else: ?>
                <img src="<?php echo esc_url(alsalam_img('news1.jpg')); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
              <?php endif; ?>
            </div>
            <div class="text-start">
              <span class="text-primary text-[10px] font-bold tracking-wider uppercase mb-1 block">
                <?php echo esc_html(get_post_meta(get_the_ID(), '_alsalam_product_tag1', true) ?: 'BFS Bottle'); ?>
              </span>
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
