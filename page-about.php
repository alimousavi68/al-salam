<?php 
/**
 * Template Name: About Page
 * 
 * Dedicated About Us Page - AL-SALAM
 * Crafted with premium modern aesthetics, glassmorphism overlays, and hover micro-animations.
 */

get_header();

// Helper to get meta cleanly
$meta = function($key) {
    return get_post_meta(get_the_ID(), $key, true);
};

// Global variables
$lang = function_exists('pll_current_language') ? pll_current_language() : 'en';
$show_hero = $meta('_alsalam_show_hero') !== '0';
?>

  <!-- Main Content Layout -->
  <main class="flex-grow">
    
    <?php if ($show_hero) : ?>
    <!-- SUBPAGE HERO / BANNER -->
    <section class="relative bg-[#041424] min-h-[400px] flex flex-col justify-end pb-16 overflow-hidden">
      
      <!-- Layer 1: Teal/Slate gradient overlay with glassmorphism matching homepage hero -->
      <div class="absolute inset-0 z-[1] bg-gradient-to-tr from-[#041424]/95 via-[#05293b]/80 to-[#0a3d3f]/55 backdrop-blur-[2px]"></div>
      <div class="absolute inset-0 z-[2] bg-primary/10 backdrop-blur-sm"></div>

      <!-- Layer 2: Decoration PNG Images matching homepage hero -->
      <img 
        src="<?php echo alsalam_img('top-right-bg.png'); ?>" 
        alt="" 
        class="absolute top-0 end-0 w-auto h-auto max-w-[65%] lg:max-w-[50%] object-contain pointer-events-none z-[3]" 
        role="presentation"
      >
      <img 
        src="<?php echo alsalam_img('bottom-left.png'); ?>" 
        alt="" 
        class="absolute bottom-0 start-0 w-auto h-auto max-w-[65%] lg:max-w-[50%] object-contain pointer-events-none z-[3]" 
        role="presentation"
      >

      <!-- Hero Banner Content -->
      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center pt-40">
        <!-- Breadcrumbs -->
        <nav class="flex items-center justify-center gap-2 mb-4 text-xs font-semibold text-white/50 tracking-wider uppercase font-sans">
          <a href="<?php echo home_url('/'); ?>" class="hover:text-primary-light transition-colors duration-200"><?php echo __('Missing Text', 'alsalam'); ?></a>
          <span class="text-white/30 font-light">/</span>
          <span class="text-white/85"><?php echo get_the_title(); ?></span>
        </nav>
        
        <!-- Title -->
        <?php $hero_title = $meta('_alsalam_hero_title'); ?>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight font-heading leading-tight mb-4">
          <?php if ($hero_title): ?>
            <?php echo wp_kses_post($hero_title); ?>
          <?php else: ?>
            <?php echo wp_kses_post(__('About <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">AL-SALAM</span>', 'alsalam')); ?>
          <?php endif; ?>
        </h1>
        
        <!-- Subtitle -->
        <p class="max-w-2xl mx-auto text-base sm:text-lg text-white/70 font-normal leading-relaxed">
          <?php echo wp_kses_post($meta('_alsalam_hero_subtitle')); ?>
        </p>
      </div>
    </section>
    <?php endif; ?>

    <!-- SECTION 1: CORPORATE PROFILE -->
    <section class="py-20 lg:py-24 overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
          
          <!-- Visual Overlay Images -->
          <div class="lg:col-span-5 relative w-full max-w-lg mx-auto lg:max-w-none flex justify-center">
            <div class="relative group w-[380px] h-[390px] sm:w-[420px] sm:h-[430px]">
              
              <!-- Subtle Blur Blob background -->
              <div class="absolute -inset-4 rounded-[3rem] bg-gradient-to-tr from-primary/10 to-transparent blur-2xl opacity-75 transition duration-500 group-hover:scale-105"></div>
              
              <!-- Overlapping Small Icon Frame sticking out top-left -->
              <img 
                src="<?php echo alsalam_img('image-icon.png'); ?>" 
                alt="" 
                class="absolute top-[-45px] left-[-45px] w-[160px] h-[180px] z-20 pointer-events-none transform transition-transform duration-500 group-hover:scale-105"
              />
              
              <!-- Main Rounded Frame -->
              <div class="relative w-full h-full overflow-hidden rounded-[45px] shadow-2xl border border-slate-100 bg-slate-100 z-10">
                <!-- Overlay gradient -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary/40 via-primary/5 to-transparent pointer-events-none z-10 mix-blend-normal"></div>
                <img 
                  src="<?php echo alsalam_img('about-bg.jpg'); ?>" 
                  alt="AL-SALAM Corporate Building" 
                  loading="lazy" 
                  class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                />
              </div>

              <!-- Overlapping Pill Indicator -->
              <div class="absolute bottom-6 end-[-30px] bg-[#071D2C] text-white px-6 py-4 rounded-3xl shadow-2xl z-20 border border-white/10 flex items-center gap-3 transition-transform duration-300 group-hover:translate-x-1">
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-[11px] font-bold text-white/50 uppercase tracking-wider"><?php echo esc_html(__('Standards', 'alsalam')); ?></p>
                  <p class="text-sm font-bold font-heading text-primary-light"><?php echo esc_html(__('EU-GMP Certified', 'alsalam')); ?></p>
                </div>
              </div>

            </div>
          </div>

          <!-- Description Text -->
          <div class="lg:col-span-7 flex flex-col text-start">
            <div class="self-start mb-4">
              <span class="inline-block rounded-full bg-[#E5F0F6] px-4 py-1.5 text-sm font-semibold tracking-wide text-slate-800 font-sans">
                <?php echo wp_kses_post($meta('_alsalam_about_corp_profile_badge')); ?>
              </span>
            </div>
            
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#071D2C] tracking-tight mb-6 leading-tight font-heading">
              <?php echo wp_kses_post($meta('_alsalam_about_corp_profile_title')); ?>
            </h2>
            
            <p class="text-[#3A3A3A] text-[16px] sm:text-[17px] leading-relaxed mb-6 font-normal">
              <?php echo wp_kses_post($meta('_alsalam_about_corp_profile_desc1')); ?>
            </p>
            
            <p class="text-[#3A3A3A] text-[16px] sm:text-[17px] leading-relaxed mb-8 font-normal">
              <?php echo wp_kses_post($meta('_alsalam_about_corp_profile_desc2')); ?>
            </p>

            <!-- Grid Highlight Points -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 11.517 1.407l-.04.02-.041.02a.75.75 0 11-.517-1.407l.04-.02z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A11.952 11.952 0 0112 16.5c-2.998 0-5.74-1.1-7.843-2.918m-.284-1.582A8.959 8.959 0 013 12c0-.778.099-1.533.284-2.253m0 0l.003-.004" />
                  </svg>
                </div>
                <div>
                  <h4 class="font-bold font-heading text-[#071D2C] text-base mb-1"><?php echo wp_kses_post($meta('_alsalam_about_standards_title')); ?></h4>
                  <p class="text-xs text-text-secondary"><?php echo wp_kses_post($meta('_alsalam_about_standards_desc')); ?></p>
                </div>
              </div>
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.656 48.656 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l-3 3m3-3l3 3" />
                  </svg>
                </div>
                <div>
                  <h4 class="font-bold font-heading text-[#071D2C] text-base mb-1"><?php echo wp_kses_post($meta('_alsalam_about_aseptic_title')); ?></h4>
                  <p class="text-xs text-text-secondary"><?php echo wp_kses_post($meta('_alsalam_about_aseptic_desc')); ?></p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 2: VISION, MISSION, & VALUES -->
    <section class="py-20 lg:py-24 bg-[#EAF3F5] relative overflow-hidden">
      <!-- Background Decorative Blur -->
      <div class="absolute top-1/2 start-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <header class="flex flex-col items-center text-center mb-16">
          <h2 class="text-slate-900 text-3xl sm:text-4xl font-extrabold tracking-tight font-heading">
            <?php echo wp_kses_post($meta('_alsalam_about_purpose_title')); ?>
          </h2>
          <div class="w-16 h-1 bg-primary mt-4 rounded-full"></div>
        </header>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          
          <!-- Vision Card -->
          <div class="bg-white rounded-[30px] p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group border border-slate-100 flex flex-col justify-between">
            <div>
              <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-8 transition-transform duration-300 group-hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <h3 class="text-xl font-bold font-heading text-text-primary mb-4"><?php echo wp_kses_post($meta('_alsalam_about_vision_title')); ?></h3>
              <p class="text-text-secondary text-sm leading-relaxed mb-6">
                <?php echo wp_kses_post($meta('_alsalam_about_vision_desc')); ?>
              </p>
            </div>
            <div class="text-xs font-bold text-primary tracking-wider uppercase"><?php echo wp_kses_post($meta('_alsalam_about_vision_badge')); ?></div>
          </div>

          <!-- Mission Card (Featured Dark Styling for High Contrast) -->
          <div class="bg-[#041424] rounded-[30px] p-8 shadow-2xl hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-2 group border border-white/5 flex flex-col justify-between relative overflow-hidden">
            <div class="absolute top-0 end-0 w-32 h-32 bg-primary/20 blur-[50px] pointer-events-none rounded-full"></div>
            <div class="relative z-10">
              <div class="w-14 h-14 rounded-2xl bg-white/10 text-primary-light flex items-center justify-center mb-8 transition-transform duration-300 group-hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.64 8.38m6.16 3.49a14.98 14.98 0 01-6.16 12.12A14.98 14.98 0 013.48 8.38" />
                </svg>
              </div>
              <h3 class="text-xl font-bold font-heading text-white mb-4"><?php echo wp_kses_post($meta('_alsalam_about_mission_title')); ?></h3>
              <p class="text-white/80 text-sm leading-relaxed mb-6">
                <?php echo wp_kses_post($meta('_alsalam_about_mission_desc')); ?>
              </p>
            </div>
            <div class="text-xs font-bold text-primary-light tracking-wider uppercase relative z-10"><?php echo wp_kses_post($meta('_alsalam_about_mission_badge')); ?></div>
          </div>

          <!-- Values Card -->
          <div class="bg-white rounded-[30px] p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group border border-slate-100 flex flex-col justify-between">
            <div>
              <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-8 transition-transform duration-300 group-hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                </svg>
              </div>
              <h3 class="text-xl font-bold font-heading text-text-primary mb-4"><?php echo wp_kses_post($meta('_alsalam_about_values_title')); ?></h3>
              <ul class="text-text-secondary text-sm space-y-3">
                <li class="flex items-center gap-2">
                  <span class="w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                  <span><?php echo wp_kses_post($meta('_alsalam_about_values_val1')); ?></span>
                </li>
                <li class="flex items-center gap-2">
                  <span class="w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                  <span><?php echo wp_kses_post($meta('_alsalam_about_values_val2')); ?></span>
                </li>
                <li class="flex items-center gap-2">
                  <span class="w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                  <span><?php echo wp_kses_post($meta('_alsalam_about_values_val3')); ?></span>
                </li>
              </ul>
            </div>
            <div class="text-xs font-bold text-primary tracking-wider uppercase mt-6"><?php echo wp_kses_post($meta('_alsalam_about_values_badge')); ?></div>
          </div>

        </div>
      </div>
    </section>

    <!-- SECTION 3: KEY INFRASTRUCTURE METRICS -->
    <section class="py-20 lg:py-24 overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <header class="flex flex-col items-center text-center mb-16">
          <div class="self-center mb-3">
            <span class="inline-block rounded-full bg-primary/10 px-4 py-1 text-xs font-bold tracking-wider text-primary uppercase font-sans">
              <?php echo wp_kses_post($meta('_alsalam_about_cap_badge')); ?>
            </span>
          </div>
          <h2 class="text-slate-900 text-3xl sm:text-4xl font-extrabold tracking-tight font-heading">
            <?php echo wp_kses_post($meta('_alsalam_about_cap_title')); ?>
          </h2>
          <p class="text-text-secondary text-sm max-w-xl mt-4">
            <?php echo wp_kses_post($meta('_alsalam_about_cap_desc')); ?>
          </p>
        </header>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          
          <!-- Metric 1 -->
          <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 text-center group">
            <div class="text-4xl lg:text-5xl font-black text-primary font-heading mb-2 group-hover:scale-105 transition-transform duration-300"><?php echo wp_kses_post($meta('_alsalam_about_metric1_val')); ?></div>
            <h4 class="font-bold text-text-primary text-base mb-1"><?php echo wp_kses_post($meta('_alsalam_about_metric1_title')); ?></h4>
            <p class="text-xs text-text-secondary"><?php echo wp_kses_post($meta('_alsalam_about_metric1_desc')); ?></p>
          </div>

          <!-- Metric 2 -->
          <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 text-center group">
            <div class="text-4xl lg:text-5xl font-black text-[#014581] font-heading mb-2 group-hover:scale-105 transition-transform duration-300"><?php echo wp_kses_post($meta('_alsalam_about_metric2_val')); ?></div>
            <h4 class="font-bold text-text-primary text-base mb-1"><?php echo wp_kses_post($meta('_alsalam_about_metric2_title')); ?></h4>
            <p class="text-xs text-text-secondary"><?php echo wp_kses_post($meta('_alsalam_about_metric2_desc')); ?></p>
          </div>

          <!-- Metric 3 -->
          <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 text-center group">
            <div class="text-4xl lg:text-5xl font-black text-teal-600 font-heading mb-2 group-hover:scale-105 transition-transform duration-300"><?php echo wp_kses_post($meta('_alsalam_about_metric3_val')); ?></div>
            <h4 class="font-bold text-text-primary text-base mb-1"><?php echo wp_kses_post($meta('_alsalam_about_metric3_title')); ?></h4>
            <p class="text-xs text-text-secondary"><?php echo wp_kses_post($meta('_alsalam_about_metric3_desc')); ?></p>
          </div>

          <!-- Metric 4 -->
          <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 text-center group">
            <div class="text-4xl lg:text-5xl font-black text-[#007A3D] font-heading mb-2 group-hover:scale-105 transition-transform duration-300"><?php echo wp_kses_post($meta('_alsalam_about_metric4_val')); ?></div>
            <h4 class="font-bold text-text-primary text-base mb-1"><?php echo wp_kses_post($meta('_alsalam_about_metric4_title')); ?></h4>
            <p class="text-xs text-text-secondary"><?php echo wp_kses_post($meta('_alsalam_about_metric4_desc')); ?></p>
          </div>

        </div>

        <!-- Call to Action Banner inside page -->
        <div class="mt-20 bg-gradient-to-r from-[#014581] to-primary rounded-[30px] p-8 sm:p-12 text-white relative overflow-hidden shadow-xl flex flex-col md:flex-row justify-between items-center gap-8 group">
          <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(35,155,168,0.35),transparent_50%)] pointer-events-none"></div>
          <div class="relative z-10 max-w-xl text-center md:text-start">
            <h3 class="text-2xl sm:text-3xl font-bold font-heading mb-3 text-white"><?php echo wp_kses_post($meta('_alsalam_about_cta_title')); ?></h3>
            <p class="text-white/80 text-sm leading-relaxed">
              <?php echo wp_kses_post($meta('_alsalam_about_cta_desc')); ?>
            </p>
          </div>
          <a href="<?php echo home_url('/inquiry'); ?>" class="relative z-10 bg-white hover:bg-slate-100 text-[#071D2C] font-semibold text-sm px-8 py-4 rounded-full shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 shrink-0">
            <?php echo wp_kses_post($meta('_alsalam_submit_inquiry_btn')); ?>
          </a>
        </div>

      </div>
    </section>

  </main>

<?php get_footer(); ?>
