<?php
/**
 * Template Name: Join Us
 * Dedicated Careers & Join Us Page - AL-SALAM
 * Premium modern aesthetics, interactive career intake form, and culture cards.
 * Fully supports RTL/LTR using Tailwind CSS logical properties.
 */

defined('ABSPATH') || exit;

get_header();

$meta = function($key, $default = '') {
    $val = get_post_meta(get_the_ID(), $key, true);
    return $val === '' ? $default : $val;
};

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
        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-light transition-colors duration-200"><?php esc_html_e('Home', 'alsalam'); ?></a>
        <span class="text-white/30 font-light">/</span>
        <span class="text-white/85"><?php the_title(); ?></span>
      </nav>
      
      <!-- Title -->
      <?php $hero_title = $meta('_alsalam_hero_title') ?: 'Join <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">Our Team</span>'; ?>
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight font-heading leading-tight mb-4">
        <?php echo wp_kses_post($hero_title); ?>
      </h1>
      
      <!-- Subtitle -->
      <p class="max-w-2xl mx-auto text-base sm:text-lg text-white/70 font-normal leading-relaxed">
        <?php echo wp_kses_post($meta('_alsalam_hero_subtitle', 'Build your career with Iraq\'s leading sterile pharmaceutical manufacturer. We offer opportunities across R&D, clinical QA, engineering, and commercial operations.')); ?>
      </p>
    </div>
  </section>
  <?php endif; ?>

  <!-- SECTION 1: WORK CULTURE & BENEFITS CARDS -->
  <section class="py-16 lg:py-20 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="inline-block rounded-full bg-[#E5F0F6] px-4 py-1.5 text-xs font-bold tracking-wider text-primary-dark uppercase font-sans mb-3">
          <?php echo esc_html($meta('_alsalam_joinus_culture_badge', 'Work Culture & Growth')); ?>
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-[#071D2C] tracking-tight font-heading leading-tight mb-4">
          <?php echo wp_kses_post($meta('_alsalam_joinus_culture_title', 'Why Build Your Career with AL-SALAM?')); ?>
        </h2>
        <p class="text-text-secondary text-sm leading-relaxed">
          <?php echo wp_kses_post($meta('_alsalam_joinus_culture_desc', 'Join a world-class team of sterile manufacturing specialists, pharmaceutical engineers, and clinical professionals dedicated to setting new benchmarks in Iraq.')); ?>
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        
        <!-- Card 1: European GMP Environment -->
        <div class="bg-[#F4F7FE] rounded-[30px] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group flex flex-col justify-between">
          <div>
            <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3" />
              </svg>
            </div>
            <h3 class="text-lg font-bold font-heading text-[#071D2C] mb-2">
              <?php esc_html_e('European GMP Standards', 'alsalam'); ?>
            </h3>
            <p class="text-text-secondary text-sm leading-relaxed">
              <?php esc_html_e('Work alongside international pharmaceutical standards in state-of-the-art Class A/B cleanroom facilities.', 'alsalam'); ?>
            </p>
          </div>
        </div>

        <!-- Card 2: Continuous Training -->
        <div class="bg-[#F4F7FE] rounded-[30px] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group flex flex-col justify-between">
          <div>
            <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
              </svg>
            </div>
            <h3 class="text-lg font-bold font-heading text-[#071D2C] mb-2">
              <?php esc_html_e('Clinical Development', 'alsalam'); ?>
            </h3>
            <p class="text-text-secondary text-sm leading-relaxed">
              <?php esc_html_e('Structured career progression tracks, continuous aseptic technology workshops, and leadership mentorship.', 'alsalam'); ?>
            </p>
          </div>
        </div>

        <!-- Card 3: Advanced BFS Automation -->
        <div class="bg-[#F4F7FE] rounded-[30px] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group flex flex-col justify-between">
          <div>
            <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19 14.5M14.25 3.104c.251.023.501.05.75.082M19 14.5a3.75 3.75 0 01-3.75 3.75H8.75A3.75 3.75 0 015 14.5m14 0V9a3.75 3.75 0 00-3.75-3.75h-6.5A3.75 3.75 0 005 9v5.5" />
              </svg>
            </div>
            <h3 class="text-lg font-bold font-heading text-[#071D2C] mb-2">
              <?php esc_html_e('Cutting-Edge Tech', 'alsalam'); ?>
            </h3>
            <p class="text-text-secondary text-sm leading-relaxed">
              <?php esc_html_e('Operate fully automated Blow-Fill-Seal (BFS) lines and computerized parametric quality assurance systems.', 'alsalam'); ?>
            </p>
          </div>
        </div>

        <!-- Card 4: Impact & Purpose -->
        <div class="bg-[#F4F7FE] rounded-[30px] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group flex flex-col justify-between">
          <div>
            <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
              </svg>
            </div>
            <h3 class="text-lg font-bold font-heading text-[#071D2C] mb-2">
              <?php esc_html_e('Life-Saving Purpose', 'alsalam'); ?>
            </h3>
            <p class="text-text-secondary text-sm leading-relaxed">
              <?php esc_html_e('Be part of a mission supplying essential Parenteral therapies to critical hospital networks across the nation.', 'alsalam'); ?>
            </p>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- SECTION 2: CAREER APPLICATION FORM -->
  <section class="py-20 lg:py-24 bg-[#F4F7FE] relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <div class="bg-white rounded-[30px] shadow-xl border border-slate-100 p-8 sm:p-12">
        <div class="border-b border-slate-100 pb-6 mb-8 text-center sm:text-start">
          <span class="inline-block rounded-full bg-[#E5F0F6] px-4 py-1.5 text-xs font-bold tracking-wider text-primary-dark uppercase font-sans mb-3">
            <?php echo esc_html($meta('_alsalam_joinus_form_badge', 'Careers Intake')); ?>
          </span>
          <h3 class="text-2xl font-extrabold font-heading text-[#071D2C]"><?php echo esc_html($meta('_alsalam_joinus_form_title', 'Submit Your Profile')); ?></h3>
          <p class="text-text-secondary text-sm mt-1"><?php echo esc_html($meta('_alsalam_joinus_form_desc', 'Fill out your credentials below. Our HR and talent acquisition team will evaluate your clinical or technical experience for relevant vacancies.')); ?></p>
        </div>

        <form id="joinus-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="space-y-6">
          <?php wp_nonce_field('alsalam_joinus_submit', 'nonce'); ?>
          <input type="hidden" name="action" value="alsalam_submit_joinus">

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Full Name -->
            <div class="flex flex-col gap-2">
              <label for="name" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php esc_html_e('Full Name *', 'alsalam'); ?></label>
              <input type="text" id="name" name="name" required placeholder="<?php esc_attr_e('e.g. Dr. Sarah Hassan', 'alsalam'); ?>" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200">
            </div>

            <!-- Email Address -->
            <div class="flex flex-col gap-2">
              <label for="email" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php esc_html_e('Email Address *', 'alsalam'); ?></label>
              <input type="email" id="email" name="email" required placeholder="sarah@example.com" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200">
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Phone Number -->
            <div class="flex flex-col gap-2">
              <label for="phone" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php esc_html_e('Phone Number *', 'alsalam'); ?></label>
              <input type="tel" id="phone" name="phone" required placeholder="+964 770 000 0000" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200">
            </div>

            <!-- Target Department -->
            <div class="flex flex-col gap-2">
              <label for="department" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php esc_html_e('Specialized Field / Role *', 'alsalam'); ?></label>
              <select id="department" name="department" required class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary focus:outline-none focus:border-primary focus:bg-white transition-all duration-200 appearance-none cursor-pointer">
                <option value="" disabled selected><?php esc_html_e('Select your specialization...', 'alsalam'); ?></option>
                <option value="Sterile Production / BFS"><?php esc_html_e('Sterile Production & BFS Operations', 'alsalam'); ?></option>
                <option value="Quality Assurance & QC"><?php esc_html_e('Quality Assurance & Microbiological QC', 'alsalam'); ?></option>
                <option value="HVAC & Cleanroom Engineering"><?php esc_html_e('HVAC & Utility Engineering', 'alsalam'); ?></option>
                <option value="Regulatory & Pharmacovigilance"><?php esc_html_e('Regulatory Affairs & Dossiers', 'alsalam'); ?></option>
                <option value="Supply Chain & Logistics"><?php esc_html_e('Pharmaceutical Supply Chain & Logistics', 'alsalam'); ?></option>
                <option value="Commercial & Medical Rep"><?php esc_html_e('Commercial Sales & Medical Representative', 'alsalam'); ?></option>
              </select>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Experience Level -->
            <div class="flex flex-col gap-2">
              <label for="experience" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php esc_html_e('Years of Experience', 'alsalam'); ?></label>
              <input type="text" id="experience" name="experience" placeholder="<?php esc_attr_e('e.g. 5 Years in Cleanroom Operations', 'alsalam'); ?>" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200">
            </div>

            <!-- CV / LinkedIn URL -->
            <div class="flex flex-col gap-2">
              <label for="cv_url" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php esc_html_e('CV / LinkedIn Profile URL', 'alsalam'); ?></label>
              <input type="url" id="cv_url" name="cv_url" placeholder="https://linkedin.com/in/yourprofile" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200">
            </div>
          </div>

          <!-- Cover Note / Credentials Summary -->
          <div class="flex flex-col gap-2">
            <label for="notes" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php esc_html_e('Qualifications & Cover Note', 'alsalam'); ?></label>
            <textarea id="notes" name="notes" rows="4" placeholder="<?php esc_attr_e('Summarize your medical/technical background, key qualifications, or link to your online portfolio/CV...', 'alsalam'); ?>" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200 resize-none"></textarea>
          </div>

          <!-- Submit Button -->
          <div class="pt-4 flex justify-end">
            <button type="submit" class="bg-primary hover:bg-primary-dark active:bg-primary text-white text-sm font-semibold px-8 py-3.5 rounded-full shadow-lg shadow-primary/20 transition-all duration-200 transform hover:-translate-y-0.5 cursor-pointer flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
              </svg>
              <span><?php esc_html_e('Submit Application', 'alsalam'); ?></span>
            </button>
          </div>

        </form>
      </div>

    </div>
  </section>

</main>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('joinus-form');
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
            alert(data.data.message || '<?php echo esc_js($meta('_alsalam_joinus_success_alert', 'Thank you! Your career application has been submitted to the AL-SALAM HR team.')); ?>');
            form.reset();
          } else {
            alert(data.data.message || 'Error submitting application.');
          }
        })
        .catch(() => alert('Connection error. Please try again.'))
        .finally(() => {
          if (submitBtn) submitBtn.disabled = false;
        });
      });
    }
  });
</script>

<?php get_footer(); ?>
