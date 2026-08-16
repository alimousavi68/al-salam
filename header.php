<?php
/**
 * The header for our theme
 *
 * @package alsalam
 */
defined('ABSPATH') || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
        :root {
            --color-primary: <?php echo esc_attr(get_theme_mod('_alsalam_color_primary', '#239BA8')); ?>;
            --color-primary-dark: <?php echo esc_attr(get_theme_mod('_alsalam_color_primary_dark', '#12A19A')); ?>;
            --color-bg-dark: <?php echo esc_attr(get_theme_mod('_alsalam_color_bg_dark', '#041424')); ?>;
            --color-bg-light: <?php echo esc_attr(get_theme_mod('_alsalam_color_bg_light', '#F4F7FE')); ?>;
            --font-heading-en: '<?php echo esc_attr(get_theme_mod('_alsalam_font_heading_en', 'Outfit')); ?>', sans-serif;
            --font-heading-ar: '<?php echo esc_attr(get_theme_mod('_alsalam_font_heading_ar', 'Cairo')); ?>', sans-serif;
            --font-body-en: '<?php echo esc_attr(get_theme_mod('_alsalam_font_body_en', 'Inter')); ?>', sans-serif;
            --font-body-ar: '<?php echo esc_attr(get_theme_mod('_alsalam_font_body_ar', 'Tajawal')); ?>', sans-serif;
            <?php $is_ar = (function_exists('pll_current_language') && pll_current_language() === 'ar') || is_rtl(); ?>
            --font-sans: <?php echo $is_ar ? 'var(--font-body-ar)' : 'var(--font-body-en)'; ?>;
            --font-heading: <?php echo $is_ar ? 'var(--font-heading-ar)' : 'var(--font-heading-en)'; ?>;
        }
    </style>
</head>
<body <?php body_class('bg-background-page text-text-primary min-h-screen flex flex-col font-sans selection:bg-primary selection:text-white'); ?>>
<?php wp_body_open(); ?>

<header id="main-header" class="w-full max-w-[1440px] mx-auto px-8 sm:px-12 lg:px-16 absolute top-8 lg:top-[64px] start-0 end-0 z-20 h-20 flex items-center">
  <div class="flex items-center justify-between w-full h-full rounded-[30px] bg-white/10 backdrop-blur-lg border border-white/20 px-6 py-2 transition-all duration-200 hover:bg-white/15">
    
    <!-- Left/Start Side: Logo & Navigation Group -->
    <div class="flex items-center gap-[26px]">
      <!-- Logo -->
      <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2 group focus:outline-none" aria-label="<?php bloginfo('name'); ?>">
         <img src="<?php echo esc_url(get_theme_mod('_alsalam_header_logo', alsalam_img('logo (2).png'))); ?>" 
              alt="<?php bloginfo('name'); ?>" 
              style="width: <?php echo esc_attr(get_theme_mod('_alsalam_header_logo_width', 150)); ?>px;"
              class="h-auto object-contain transition-all duration-200 group-hover:scale-105">
      </a>
      
      <!-- Vertical Separator Line (Hidden on Mobile) -->
      <div class="hidden md:block w-px h-6 bg-white/20"></div>

      <!-- Navigation Links -->
      <nav class="hidden md:flex items-center gap-x-[26px]" aria-label="Main Navigation">
        <?php
        // Polylang registers menus as 'primary___en' / 'primary___ar'
        // but also works with 'primary' as fallback through pll_translate_url
        // Use the language-specific location when Polylang is active
        $menu_location = 'primary';
        if (function_exists('pll_current_language')) {
            $lang = pll_current_language();
            $lang_location = 'primary___' . $lang;
            $locations = get_nav_menu_locations();
            if (!empty($locations[$lang_location])) {
                $menu_location = $lang_location;
            }
        }
        wp_nav_menu(array(
            'theme_location' => $menu_location,
            'container'      => false,
            'menu_class'     => 'flex items-center gap-x-[26px]',
            'fallback_cb'    => false,
            'walker'         => new Alsalam_Nav_Walker(),
        ));
        ?>
      </nav>
    </div>

    <!-- Right/End Side: Language Switcher, CTA and Responsive Burger -->
    <div class="flex items-center gap-4">
      
      <!-- Language Switcher (Premium Globe Dropdown) -->
      <?php if (get_theme_mod('_alsalam_header_lang_switcher', '1') === '1' && function_exists('pll_the_languages')) : 
          $languages = pll_the_languages(array('raw' => 1));
          $current_lang = 'EN';
          foreach ($languages as $lang) {
              if ($lang['current_lang']) {
                  $current_lang = strtoupper($lang['slug']);
                  break;
              }
          }
      ?>
      <div class="relative inline-block text-left group" id="language-switcher-container">
        <button id="lang-switcher-btn" type="button" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-full border border-white/20 hover:border-white/40 hover:bg-white/10 text-sm font-semibold text-white/95 hover:text-white transition-all duration-200 focus:outline-none" aria-haspopup="true" aria-expanded="false">
          <!-- Premium Globe Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 shrink-0 opacity-80" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-.778.099-1.533.284-2.253" />
          </svg>
          <span id="current-lang-label"><?php echo esc_html($current_lang); ?></span>
          <!-- Chevron Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3 shrink-0 opacity-60 transition-transform duration-200" id="lang-chevron">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
        </button>

        <!-- Dropdown Menu (Luxurious Glassmorphism) -->
        <div id="lang-dropdown-menu" class="lang-dropdown-menu absolute right-0 ltr:right-0 rtl:left-0 mt-2 w-32 rounded-2xl bg-[#041424]/90 backdrop-blur-xl border border-white/10 shadow-2xl py-1.5 z-30 origin-top-right hidden group-hover:block">
          <?php foreach ($languages as $lang) : 
            $is_current = $lang['current_lang'];
            $btn_classes = $is_current 
              ? 'w-full flex items-center justify-between px-4 py-2 text-sm font-medium text-white hover:bg-white/10 transition-colors duration-150' 
              : 'w-full flex items-center justify-between px-4 py-2 text-sm font-medium text-white/75 hover:text-white hover:bg-white/10 transition-colors duration-150';
          ?>
          <a href="<?php echo esc_url($lang['url']); ?>" class="<?php echo esc_attr($btn_classes); ?>" data-lang-btn="<?php echo esc_attr($lang['slug']); ?>">
            <span><?php echo esc_html(strtoupper($lang['slug'])); ?></span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-primary-light shrink-0 <?php echo $is_current ? '' : 'hidden'; ?>" id="check-<?php echo esc_attr($lang['slug']); ?>">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <a href="<?php echo esc_url(get_theme_mod('_alsalam_header_cta_link', '#')); ?>" 
          class="hidden md:inline-flex items-center gap-2 bg-primary hover:bg-primary-dark active:bg-primary text-white text-sm font-semibold px-6 py-2.5 rounded-full shadow-lg shadow-primary/20 focus:outline-none focus:ring-2 focus:ring-primary-light focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?php echo esc_html(pll__(get_theme_mod('_alsalam_header_cta_text', 'Request Inquiry'))); ?></span>
      </a>

      <!-- Responsive Mobile Toggle -->
      <button id="mobile-menu-toggle" type="button" class="md:hidden text-white hover:text-primary-light focus:outline-none transition-colors duration-200" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
        </svg>
      </button>
    </div>

  </div>

  <!-- Fullscreen Mobile Navigation Menu -->
  <div id="mobile-menu" class="hidden fixed inset-0 bg-[#041424]/98 backdrop-blur-3xl z-[100] flex-col justify-between p-8 transition-all duration-300 opacity-0 scale-95 pointer-events-none">
    
    <div class="flex items-center justify-between w-full">
      <img src="<?php echo esc_url(get_theme_mod('_alsalam_header_logo', alsalam_img('logo (2).png'))); ?>" 
           alt="<?php bloginfo('name'); ?>" 
           style="width: <?php echo esc_attr(get_theme_mod('_alsalam_header_logo_width', 150)); ?>px;"
           class="h-auto object-contain">
      <button id="mobile-menu-close" type="button" class="text-white hover:text-primary-light focus:outline-none transition-colors duration-200" aria-label="Close menu">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Center Menu Links (Luxury Typography) -->
    <nav class="flex flex-col gap-6 text-center my-auto">
       <?php
        wp_nav_menu(array(
            'theme_location' => $menu_location,
            'container'      => false,
            'menu_class'     => 'flex flex-col gap-6 text-center my-auto',
            'fallback_cb'    => false,
        ));
        ?>
    </nav>
    
    <!-- Bottom CTA -->
    <div class="flex flex-col gap-4 w-full">
      <a href="<?php echo esc_url(get_theme_mod('_alsalam_header_cta_link', '#')); ?>" class="flex w-full items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white text-base font-semibold px-6 py-3.5 rounded-full shadow-lg shadow-primary/20 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?php echo esc_html(pll__(get_theme_mod('_alsalam_header_cta_text', 'Request Inquiry'))); ?></span>
      </a>
    </div>

  </div>
</header>
