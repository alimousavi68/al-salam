<?php 
/**
 * Template Name: Contact Us
 * Dedicated Contact Us Page - AL-SALAM
 * Premium modern aesthetics, interactive styled form, and info cards.
 * Fully supports RTL/LTR using Tailwind CSS logical properties.
 */

defined('ABSPATH') || exit;

get_header(); 

$meta = function($key) {
    return get_post_meta(get_the_ID(), $key, true);
};

// Check if Hero should be shown
$show_hero = $meta('_alsalam_show_hero') !== '0';
?>

  <!-- Main Content Layout -->
  <main class="flex-grow">
    
    <?php if ($show_hero): ?>
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
      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center pt-36">
        <!-- Breadcrumbs -->
        <nav class="flex items-center justify-center gap-2 mb-4 text-xs font-semibold text-white/50 tracking-wider uppercase font-sans">
          <a href="<?php echo home_url('/'); ?>" class="hover:text-primary-light transition-colors duration-200"><?php echo esc_html__('Home', 'alsalam'); ?></a>
          <span class="text-white/30 font-light">/</span>
          <span class="text-white/85"><?php the_title(); ?></span>
        </nav>
        
        <!-- Title -->
        <?php $hero_title = $meta('_alsalam_hero_title') ?: 'Get in <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">Touch</span>'; ?>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight font-heading leading-tight mb-4">
          <?php echo wp_kses_post($hero_title); ?>
        </h1>
        
        <!-- Subtitle -->
        <p class="max-w-2xl mx-auto text-base sm:text-lg text-white/70 font-normal leading-relaxed">
          <?php 
          $subtitle = $meta('_alsalam_hero_subtitle');
          echo wp_kses_post($subtitle ?: __('Have questions about our sterile manufacturing capabilities, product distribution, or regulatory compliance? Reach out to our teams.', 'alsalam')); 
          ?>
        </p>
      </div>
    </section>
    <?php endif; ?>

    <!-- SECTION 1: CONTACT INFORMATION CARDS -->
    <section class="py-16 lg:py-20 bg-white relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          
          <!-- Card 1: Facility Location -->
          <div class="bg-[#F4F7FE] rounded-[30px] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group flex flex-col justify-between">
            <div>
              <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
              </div>
              <h3 class="text-lg font-bold font-heading text-[#071D2C] mb-2">
                <?php echo wp_kses_post($meta('_alsalam_contact_facility_title') ?: __('Our Facility', 'alsalam')); ?>
              </h3>
              <p class="text-text-secondary text-sm leading-relaxed mb-4">
                <?php echo wp_kses_post($meta('_alsalam_contact_facility_desc') ?: __('AL-SALAM Pharmaceutical Plant, Industrial Zone, Baghdad, Iraq.', 'alsalam')); ?>
              </p>
            </div>
            <a href="https://maps.google.com" target="_blank" class="text-xs font-bold text-primary hover:text-primary-dark tracking-wider uppercase inline-flex items-center gap-1.5 transition-colors duration-200">
              <span><?php echo esc_html__('Open in Maps', 'alsalam'); ?></span>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5 rtl:-scale-x-100">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
              </svg>
            </a>
          </div>

          <!-- Card 2: Phone Numbers -->
          <div class="bg-[#F4F7FE] rounded-[30px] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group flex flex-col justify-between">
            <div>
              <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.122-4.1-6.92-6.92l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
              </div>
              <h3 class="text-lg font-bold font-heading text-[#071D2C] mb-2">
                <?php echo wp_kses_post($meta('_alsalam_contact_phone_title') ?: __('Call Us Direct', 'alsalam')); ?>
              </h3>
              <p class="text-text-secondary text-sm leading-relaxed mb-4">
                <?php echo wp_kses_post($meta('_alsalam_contact_phone_desc') ?: __('Our customer support and clinical representatives are available.', 'alsalam')); ?>
              </p>
            </div>
            <div class="flex flex-col gap-1">
              <?php 
              $phones = get_post_meta(get_the_ID(), '_alsalam_contact_phones', true);
              if (empty($phones)) $phones = ['+964 770 000 0000', '+964 780 000 0000'];
              foreach ((array)$phones as $phone): 
              ?>
              <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>" class="text-sm font-bold text-[#071D2C] hover:text-primary transition-colors"><?php echo esc_html($phone); ?></a>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Card 3: Email Channels -->
          <div class="bg-[#F4F7FE] rounded-[30px] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group flex flex-col justify-between">
            <div>
              <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
              </div>
              <h3 class="text-lg font-bold font-heading text-[#071D2C] mb-2">
                <?php echo wp_kses_post($meta('_alsalam_contact_email_title') ?: __('Email Channels', 'alsalam')); ?>
              </h3>
              <p class="text-text-secondary text-sm leading-relaxed mb-4">
                <?php echo wp_kses_post($meta('_alsalam_contact_email_desc') ?: __('Drop us a message and our specialists will respond within 24 hours.', 'alsalam')); ?>
              </p>
            </div>
            <div class="flex flex-col gap-1">
              <?php 
              $emails = get_post_meta(get_the_ID(), '_alsalam_contact_emails', true);
              if (empty($emails)) $emails = ['info@alsalam-pharma.com', 'sales@alsalam-pharma.com'];
              foreach ((array)$emails as $email): 
              ?>
              <a href="mailto:<?php echo esc_attr($email); ?>" class="text-sm font-bold text-[#071D2C] hover:text-primary transition-colors break-words"><?php echo esc_html($email); ?></a>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Card 4: Hours of Operation -->
          <div class="bg-[#F4F7FE] rounded-[30px] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group flex flex-col justify-between">
            <div>
              <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <h3 class="text-lg font-bold font-heading text-[#071D2C] mb-2">
                <?php echo wp_kses_post($meta('_alsalam_contact_hours_title') ?: __('Shift Schedules', 'alsalam')); ?>
              </h3>
              <p class="text-text-secondary text-sm leading-relaxed mb-4">
                <?php echo wp_kses_post($meta('_alsalam_contact_hours_desc') ?: __('Our offices are active during corporate weekdays.', 'alsalam')); ?>
              </p>
            </div>
            <div>
              <p class="text-sm font-bold text-[#071D2C]"><?php echo wp_kses_post($meta('_alsalam_contact_hours_val') ?: __('Sun - Thu: 8:00 AM - 4:00 PM', 'alsalam')); ?></p>
              <p class="text-xs text-text-secondary"><?php echo wp_kses_post($meta('_alsalam_contact_hours_closed') ?: __('Closed on Friday & Saturday', 'alsalam')); ?></p>
            </div>
          </div>

        </div>

      </div>
    </section>

    <!-- SECTION 2: CONTACT FORM & INTERACTIVE MAP -->
    <section class="py-20 lg:py-24 bg-[#EAF3F5] relative overflow-hidden">
      <!-- Background Decorative Blur Blob -->
      <div class="absolute top-1/2 start-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[130px] pointer-events-none z-0"></div>

      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-stretch">
          
          <!-- Column 1: Interactive Contact Form (7 cols on desktop) -->
          <div class="lg:col-span-7 bg-white rounded-[30px] p-8 sm:p-10 shadow-xl border border-slate-100 flex flex-col justify-between">
            <div>
              <span class="inline-block rounded-full bg-[#E5F0F6] px-4 py-1.5 text-sm font-semibold tracking-wide text-slate-800 font-sans mb-4">
                <?php echo wp_kses_post($meta('_alsalam_contact_form_badge') ?: __('Message Us', 'alsalam')); ?>
              </span>
              <h2 class="text-2xl sm:text-3xl font-extrabold text-[#071D2C] tracking-tight mb-2 font-heading leading-tight">
                <?php echo wp_kses_post($meta('_alsalam_contact_form_title') ?: __('Send a Direct Message', 'alsalam')); ?>
              </h2>
              <p class="text-[#3A3A3A] text-sm leading-relaxed mb-8">
                <?php echo wp_kses_post($meta('_alsalam_contact_form_desc') ?: __('Please complete the form below. Our corporate relations team will route your inquiry to the appropriate medical or commercial specialist.', 'alsalam')); ?>
              </p>
              
              <!-- Contact Form -->
              <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="space-y-6" id="contact-form">
                <?php wp_nonce_field('alsalam_contact_submit', 'nonce'); ?>
                <input type="hidden" name="action" value="alsalam_submit_contact">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                  <!-- Name Input -->
                  <div class="flex flex-col gap-2">
                    <label for="name" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo esc_html__('Full Name', 'alsalam'); ?></label>
                    <input 
                      type="text" 
                      id="name" 
                      name="name" 
                      required 
                      placeholder="<?php echo esc_attr(is_rtl() ? 'أدخل اسمك الكامل' : 'John Doe'); ?>" 
                      class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200"
                    >
                  </div>
                  <!-- Email Input -->
                  <div class="flex flex-col gap-2">
                    <label for="email" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo esc_html__('Email Address', 'alsalam'); ?></label>
                    <input 
                      type="email" 
                      id="email" 
                      name="email" 
                      required 
                      placeholder="<?php echo esc_attr(is_rtl() ? 'mail@company.com' : 'john@company.com'); ?>" 
                      class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200"
                    >
                  </div>
                </div>

                <!-- Subject Input -->
                <div class="flex flex-col gap-2">
                  <label for="subject" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo esc_html__('Subject', 'alsalam'); ?></label>
                  <input 
                    type="text" 
                    id="subject" 
                    name="subject" 
                    required 
                    placeholder="<?php echo esc_attr(is_rtl() ? 'موضوع الاستفسار' : 'Clinical Distribution Partnership'); ?>" 
                    class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200"
                  >
                </div>

                <!-- Message Input -->
                <div class="flex flex-col gap-2">
                  <label for="message" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo esc_html__('Message', 'alsalam'); ?></label>
                  <textarea 
                    id="message" 
                    name="message" 
                    rows="5" 
                    required 
                    placeholder="<?php echo esc_attr(is_rtl() ? 'اكتب تفاصيل استفسارك هنا...' : 'Provide detailed description of your request...'); ?>" 
                    class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200 resize-none"
                  ></textarea>
                </div>

                <!-- Submit Button -->
                <button 
                  type="submit" 
                  class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark active:bg-primary text-white text-sm font-semibold px-8 py-4 rounded-full shadow-lg shadow-primary/20 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                  </svg>
                  <span><?php echo esc_html__('Send Message', 'alsalam'); ?></span>
                </button>
              </form>
            </div>
          </div>

          <!-- Column 2: Styled Map / Graphic (5 cols on desktop) -->
          <div class="lg:col-span-5 relative w-full rounded-[30px] overflow-hidden shadow-xl min-h-[350px] lg:min-h-full group">
            <!-- Simulated Premium Dark Interactive Map background -->
            <div class="absolute inset-0 bg-[#041424] flex flex-col justify-between p-8 z-10">
              <!-- Grid background effect -->
              <div class="absolute inset-0 bg-[linear-gradient(to_right,#082032_1px,transparent_1px),linear-gradient(to_bottom,#082032_1px,transparent_1px)] bg-[size:3rem_3rem] opacity-30 pointer-events-none"></div>
              
              <!-- Floating Map Marker overlay with glowing pulses -->
              <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center z-20">
                <div class="relative flex items-center justify-center w-12 h-12">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-8 w-8 bg-primary-light flex items-center justify-center text-white font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                  </span>
                </div>
                <div class="mt-2 bg-[#071D2C]/90 backdrop-blur-md border border-white/10 rounded-xl p-3 shadow-2xl text-center">
                  <p class="text-xs font-bold text-white font-heading">AL-SALAM Plant</p>
                  <p class="text-[10px] text-primary-light font-medium mt-0.5">Baghdad, Iraq</p>
                </div>
              </div>

              <!-- Top Content: Badge & Title -->
              <div class="relative z-20">
                <span class="inline-block rounded-full bg-white/10 border border-white/10 px-3.5 py-1 text-[11px] font-bold tracking-wider text-primary-light uppercase font-sans mb-3">
                  <?php echo wp_kses_post($meta('_alsalam_contact_map_badge') ?: __('Interactive Center', 'alsalam')); ?>
                </span>
                <h3 class="text-xl font-bold font-heading text-white">
                  <?php echo wp_kses_post($meta('_alsalam_contact_map_title') ?: __('Clinical Logistics', 'alsalam')); ?>
                </h3>
                <p class="text-white/60 text-xs mt-1">
                  <?php echo wp_kses_post($meta('_alsalam_contact_map_desc') ?: __('Direct shipping corridors connecting to critical hospital supply lines.', 'alsalam')); ?>
                </p>
              </div>

              <!-- Bottom Content: Coordinates & details -->
              <div class="relative z-20 flex justify-between items-end border-t border-white/10 pt-6">
                <div>
                  <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest">
                    <?php echo wp_kses_post($meta('_alsalam_contact_map_coords') ?: __('Co-ordinates', 'alsalam')); ?>
                  </p>
                  <p class="text-xs font-semibold text-white/90 font-sans mt-0.5">33.3152° N, 44.3661° E</p>
                </div>
                <div class="text-end">
                  <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest font-sans">
                    <?php echo wp_kses_post($meta('_alsalam_contact_map_gmp') ?: __('GMP Zone', 'alsalam')); ?>
                  </p>
                  <p class="text-xs font-semibold text-primary-light font-sans mt-0.5">
                    <?php echo wp_kses_post($meta('_alsalam_contact_map_classa') ?: __('Class A Certified', 'alsalam')); ?>
                  </p>
                </div>
              </div>
            </div>

            <!-- Real Google Maps iFrame overlay with low opacity hover to let the user see map -->
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d106675.05929845001!2d44.35246736460627!3d33.312959828859944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15578028a15f0553%3A0xf581628d022b7a8d!2sBaghdad%2C%20Iraq!5e0!3m2!1sen!2sus!4v1718471289123!5m2!1sen!2sus" 
              class="absolute inset-0 w-full h-full border-0 opacity-0 hover:opacity-100 focus:opacity-100 transition-opacity duration-500 z-30 filter grayscale invert contrast-125" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade"
              title="AL-SALAM Plant Map"
            ></iframe>
          </div>

        </div>
      </div>
    </section>

  </main>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('contact-form');
      if (form) {
        form.addEventListener('submit', (e) => {
          e.preventDefault();
          const submitBtn = form.querySelector('button[type="submit"]');
          if (submitBtn) submitBtn.disabled = true;

          const formData = new FormData(form);
          fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
            method: 'POST',
            body: formData
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              alert(data.data.message || '<?php echo esc_js(__('Thank you! Your message has been sent successfully to the AL-SALAM relations team.', 'alsalam')); ?>');
              form.reset();
            } else {
              alert(data.data.message || 'Error sending message.');
            }
          })
          .catch(() => alert('Connection error.'))
          .finally(() => { if (submitBtn) submitBtn.disabled = false; });
        });
      }
    });
  </script>

<?php get_footer(); ?>
