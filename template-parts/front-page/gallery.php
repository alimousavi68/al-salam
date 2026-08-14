<?php
/**
 * Gallery Section Template Part
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

$galleryItems = array(
    array(
        'title'    => esc_html__('Sterile R&D Clean Room', 'alsalam'),
        'category' => esc_html__('Research & Development', 'alsalam'),
        'image'    => alsalam_img('gallery/p1.webp')
    ),
    array(
        'title'    => esc_html__('Microbiology Quality Lab', 'alsalam'),
        'category' => esc_html__('Quality Assurance', 'alsalam'),
        'image'    => alsalam_img('gallery/p2.webp')
    ),
    array(
        'title'    => esc_html__('Automated Production Line', 'alsalam'),
        'category' => esc_html__('Manufacturing', 'alsalam'),
        'image'    => alsalam_img('gallery/p3.webp')
    ),
    array(
        'title'    => esc_html__('Chemical Analysis Center', 'alsalam'),
        'category' => esc_html__('Quality Assurance', 'alsalam'),
        'image'    => alsalam_img('gallery/p4.webp')
    ),
    array(
        'title'    => esc_html__('Smart Storage Facility', 'alsalam'),
        'category' => esc_html__('Logistics', 'alsalam'),
        'image'    => alsalam_img('gallery/p5.webp')
    )
);
?>

<section class="relative w-full px-4 mb-24 z-10">
  <div class="bg-[#0a1120] rounded-[2.5rem] relative overflow-hidden w-full max-w-[90rem] h-[720px] mx-auto py-16 px-6 sm:px-12 lg:px-20 shadow-2xl">

    <svg class="absolute inset-0 w-full h-full opacity-5 pointer-events-none stroke-teal-500/30" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
      <defs>
        <pattern id="gallery-grid" width="40" height="40" patternUnits="userSpaceOnUse">
          <path d="M 40 0 L 0 0 0 40" fill="none" stroke-width="0.5" />
          <circle cx="40" cy="40" r="1" fill="currentColor" />
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#gallery-grid)" />
    </svg>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-16 gap-6 relative z-10 gsap-fade-up">
      <div class="space-y-2">
        <span class="text-teal-500 text-xl md:text-2xl font-bold tracking-wider block font-heading uppercase">AL-SALAM</span>
        <h2 class="text-white text-3xl md:text-5xl font-extrabold tracking-tight font-heading"><?php esc_html_e('Company Gallery', 'alsalam'); ?></h2>
      </div>
      <a href="#" class="bg-teal-500 hover:bg-teal-600 active:scale-95 text-white font-semibold px-7 py-3 rounded-full flex items-center gap-2.5 transition-all duration-300 shadow-lg shadow-teal-500/20 group">
        <span><?php esc_html_e('All Photos', 'alsalam'); ?></span>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transform transition-transform duration-300 group-hover:translate-x-1 rtl:group-hover:-translate-x-1 rtl:-scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </a>
    </div>

    <div class="relative w-full pb-8 gsap-fade-up">

      <div class="gallery-nav-btn gallery-prev" id="gallery-prev" role="button" aria-label="<?php esc_attr_e('Previous slide', 'alsalam'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
      </div>

      <div class="gallery-nav-btn gallery-next" id="gallery-next" role="button" aria-label="<?php esc_attr_e('Next slide', 'alsalam'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </div>

      <div id="gallery-accordion" class="flex w-full h-[340px] sm:h-[420px] gap-[20px] overflow-hidden">

        <?php foreach ($galleryItems as $index => $item): 
            $isPlay = ($index % 2 === 0);
        ?>
        <a href="#" class="gallery-item block group">
          <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy" />
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
              <span class="text-teal-400 text-xs font-semibold uppercase tracking-wider"><?php echo esc_html($item['category']); ?></span>
              <h3 class="text-white text-lg sm:text-xl font-bold mt-1 group-hover:text-teal-300 transition-colors duration-300 whitespace-nowrap overflow-hidden text-ellipsis"><?php echo esc_html($item['title']); ?></h3>
            </div>
          </div>
        </a>
        <?php endforeach; ?>

      </div>
    </div>

  </div>
</section>
