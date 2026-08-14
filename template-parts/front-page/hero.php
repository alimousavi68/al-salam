<?php
/**
 * Hero Section Template Part
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

$heroSlides = array(
    array(
        'badge_company' => 'AL-SALAM',
        'badge_text'    => esc_html__('COMPANY', 'alsalam'),
        'title'         => esc_html__('Sterile Pharmaceutical', 'alsalam'),
        'subtitle'      => esc_html__('Manufacturing Built on European GMP Standards', 'alsalam'),
        'desc'          => esc_html__('Delivering high-quality parenteral solutions conforming to global regulatory frameworks with state-of-the-art sterile processing facilities. All lines operate with automated aseptic safety protocols.', 'alsalam')
    ),
    array(
        'badge_company' => 'AL-SALAM',
        'badge_text'    => esc_html__('TECHNOLOGY', 'alsalam'),
        'title'         => esc_html__('Advanced Aseptic Lines', 'alsalam'),
        'subtitle'      => esc_html__('High-Tech Bio-Processing Operations', 'alsalam'),
        'desc'          => esc_html__('Utilizing advanced barrier systems (RABS) and blow-fill-seal methodologies to eliminate intervention vectors, ensuring the absolute highest safety indexes in parenteral formulation.', 'alsalam')
    ),
    array(
        'badge_company' => 'AL-SALAM',
        'badge_text'    => esc_html__('HEALTHCARE', 'alsalam'),
        'title'         => esc_html__('Global Core Logistics', 'alsalam'),
        'subtitle'      => esc_html__('Reliable Essential Critical-Care Distribution', 'alsalam'),
        'desc'          => esc_html__('Supplying life-saving intravenous solutions and vial parenterals globally. Our robust supply channels secure critical hospital networks with seamless therapeutic solutions continuous-uptime assurance.', 'alsalam')
    )
);
?>
<!-- Hero Section -->
<section id="home" class="relative bg-background-page pt-4 pb-4 sm:pt-4 sm:pb-6 lg:pt-4 lg:pb-8">
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Hero Wrapper: Large rounded card -->
    <div id="hero-wrapper" class="hero-container relative overflow-hidden rounded-[2rem] sm:rounded-[2.5rem] lg:rounded-[3rem] min-h-[800px] flex flex-col justify-between shadow-2xl">

      <!-- Background Layers -->
      <video 
        autoplay 
        muted 
        loop 
        playsinline 
        class="absolute inset-0 w-full h-full object-cover z-0 select-none pointer-events-none"
      >
        <source src="<?php echo esc_url(ALSALAM_URI . '/assets/video/HomePageVideo.mp4'); ?>" type="video/mp4">
      </video>

      <!-- Teal/Slate overlay with glassmorphism -->
      <div class="absolute inset-0 z-[1] bg-gradient-to-tr from-[#041424]/90 via-[#05293b]/70 to-[#0a3d3f]/45 backdrop-blur-[2px]"></div>
      <div class="absolute inset-0 z-[2] bg-primary/10 backdrop-blur-sm"></div>

      <!-- Fixed Absolute Decoration Images on Overlay -->
      <img 
        src="<?php echo esc_url(alsalam_img('top-right-bg.png')); ?>" 
        alt="" 
        class="hero-deco-top absolute top-0 end-0 w-auto h-auto max-w-[60%] lg:max-w-[50%] object-contain pointer-events-none z-[3] rtl:-scale-x-100" 
        role="presentation"
      >
      <img 
        src="<?php echo esc_url(alsalam_img('bottom-left.png')); ?>" 
        alt="" 
        class="hero-deco-bottom absolute bottom-0 start-0 w-auto h-auto max-w-[60%] lg:max-w-[50%] object-contain pointer-events-none z-[3] rtl:-scale-x-100" 
        role="presentation"
      >

      <!-- Content -->
      <div class="relative z-10 flex flex-col flex-grow justify-between">
        
        <!-- HERO BODY -->
        <div class="flex-grow flex items-center px-6 sm:px-12 md:px-20 lg:ps-32 lg:pe-24 pt-36 pb-20 w-full">
          <div class="w-full flex flex-col justify-center">

            <div class="relative w-full max-w-3xl min-h-[320px] md:min-h-[350px] flex flex-col justify-center text-start">

              <div id="hero-slider" class="relative w-full">
                <?php foreach ($heroSlides as $index => $slide): ?>
                  <article class="hero-slide duration-700 ease-out transition-all transform opacity-0 translate-y-4 hidden" data-slide-index="<?php echo esc_attr($index); ?>">
                    <header class="inline-flex items-center gap-2 border border-white/20 rounded-full p-1 pe-4 bg-white/5 backdrop-blur-sm self-start mb-6" style="font-family: 'Inter', sans-serif; font-weight: 500; font-size: 14px; line-height: 18px;">
                      <span class="bg-[#041424] text-primary-light px-3 py-0.5 rounded-full text-xs font-bold"><?php echo esc_html($slide['badge_company']); ?></span>
                      <span class="text-white/90"><?php echo esc_html($slide['badge_text']); ?></span>
                    </header>
                    
                    <h2 class="hero-title tracking-tight mb-4">
                      <?php echo esc_html($slide['title']); ?>
                    </h2>
                    <h3 class="hero-subtitle mb-5 leading-normal">
                      <?php echo esc_html($slide['subtitle']); ?>
                    </h3>
                    <p class="hero-desc mb-8 max-w-xl">
                      <?php echo esc_html($slide['desc']); ?>
                    </p>
                  </article>
                <?php endforeach; ?>
              </div>

              <!-- CTA Buttons Group -->
              <div class="flex flex-wrap items-center gap-4 mt-2">
                <a href="#about" style="font-family: 'Inter', sans-serif; font-weight: 500; font-size: 16px; line-height: 20px; color: #041424;" class="inline-flex items-center justify-center bg-white hover:bg-slate-100 active:bg-slate-200 px-6 py-2.5 rounded-full shadow-md transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-white">
                  <?php esc_html_e('About Us', 'alsalam'); ?>
                </a>
                
                <div class="flex items-center gap-2.5 group cursor-pointer focus-within:ring-2 focus-within:ring-primary-light rounded-full">
                  <a href="#products" style="font-family: 'Inter', sans-serif; font-weight: 500; font-size: 16px; line-height: 20px;" class="inline-flex items-center justify-center border border-white/30 text-white px-5 py-2.5 rounded-full group-hover:bg-white/10 group-hover:border-white transition-all duration-200 focus:outline-none">
                    <?php esc_html_e('Our Products', 'alsalam'); ?>
                  </a>
                  <a href="#products" 
                     class="flex items-center justify-center w-10 h-10 rounded-full border border-white/30 text-white bg-transparent group-hover:border-primary-light group-hover:bg-primary/10 group-hover:text-primary-light transition-all duration-200 transform group-hover:scale-105 group-hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-primary-light"
                     aria-hidden="true" tabindex="-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                    </svg>
                  </a>
                </div>
              </div>

            </div>

          </div>
        </div>

      </div>

      <!-- Controls -->
      <div class="hidden lg:flex absolute start-2 sm:start-3 top-1/2 -translate-y-1/2 flex flex-col items-center gap-4 z-20">
        <button id="slide-prev" 
                type="button" 
                class="flex items-center justify-center w-12 h-12 rounded-full border border-white/20 bg-black/10 backdrop-blur-sm text-white hover:border-primary-light hover:text-primary-light hover:bg-primary/10 active:scale-95 focus:outline-none focus:ring-2 focus:ring-primary-light transition-all duration-200"
                aria-label="<?php esc_attr_e('Previous Slide', 'alsalam'); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
          </svg>
        </button>

        <div class="flex flex-col gap-2 py-1">
          <span class="slide-indicator-dot w-2 h-2 rounded-full transition-all duration-200 bg-white cursor-pointer" data-dot-index="0"></span>
          <span class="slide-indicator-dot w-2 h-2 rounded-full transition-all duration-200 bg-white/40 cursor-pointer" data-dot-index="1"></span>
          <span class="slide-indicator-dot w-2 h-2 rounded-full transition-all duration-200 bg-white/40 cursor-pointer" data-dot-index="2"></span>
        </div>

        <button id="slide-next" 
                type="button" 
                class="flex items-center justify-center w-12 h-12 rounded-full border border-white/20 bg-black/10 backdrop-blur-sm text-white hover:border-primary-light hover:text-primary-light hover:bg-primary/10 active:scale-95 focus:outline-none focus:ring-2 focus:ring-primary-light transition-all duration-200"
                aria-label="<?php esc_attr_e('Next Slide', 'alsalam'); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
        </button>
      </div>

      <!-- Play Video Button -->
      <div class="absolute bottom-8 end-8 sm:bottom-12 sm:end-12 z-20">
        <button id="play-video-btn" 
                type="button" 
                class="group relative flex items-center justify-center w-16 h-16 rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-lg shadow-black/10 hover:bg-white/20 hover:border-white/30 hover:scale-105 active:scale-95 focus:outline-none transition-all duration-300"
                aria-label="<?php esc_attr_e('Play company video', 'alsalam'); ?>">
          <span class="absolute inset-0 rounded-full bg-primary/20 animate-ping opacity-75 group-hover:bg-primary-light/30 transition-all duration-300"></span>
          <img src="<?php echo esc_url(alsalam_img('play (2).svg')); ?>" alt="Play Icon" class="w-6 h-6 select-none pointer-events-none transition-transform duration-300 group-hover:scale-110">
        </button>
      </div>

    </div>

  </div>
</section>

<!-- Video Modal -->
<div id="video-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-md transition-opacity duration-200 p-4">
  <div class="relative w-full max-w-4xl bg-neutral-dark rounded-2xl overflow-hidden border border-white/10 shadow-2xl">
    <button id="close-modal" 
            class="absolute top-4 end-4 flex items-center justify-center w-10 h-10 rounded-full bg-black/60 text-white hover:text-primary-light hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-primary-light transition-all duration-200 z-10"
            aria-label="<?php esc_attr_e('Close Video Modal', 'alsalam'); ?>">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
    <div class="aspect-video w-full bg-[#041424] flex flex-col items-center justify-center gap-4 text-center p-8">
      <div class="w-16 h-16 rounded-full bg-primary/10 border border-primary-light text-primary-light flex items-center justify-center animate-pulse">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
        </svg>
      </div>
      <div>
        <h3 class="text-xl font-bold text-white mb-2 font-heading"><?php esc_html_e('Corporate Video Placeholder', 'alsalam'); ?></h3>
        <p class="text-white/60 text-sm max-w-md font-sans">
          <?php esc_html_e('High-fidelity corporate video demonstration.', 'alsalam'); ?>
        </p>
      </div>
    </div>
  </div>
</div>
