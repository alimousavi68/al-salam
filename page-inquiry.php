<?php 
/**
 * Template Name: Inquiry Page
 * 
 * Dedicated Request Inquiry Page - AL-SALAM
 * Premium B2B/clinical inquiry intake form for distributors and health networks.
 */

defined('ABSPATH') || exit;

get_header(); 

// Helper function to safely fetch meta with default fallback
$meta = function($key, $default = '') {
    $val = get_post_meta(get_the_ID(), $key, true);
    return $val === '' ? $default : $val;
};

// Polylang Helper for form labels (if Polylang is not active, fallback to __)
function alsalam_label($key, $fallback) {
    if (function_exists('pll__')) {
        return pll__($fallback); // In a real setup, you'd register the string first. For now, fallback.
    }
    return esc_html__($fallback, 'alsalam'); // In WordPress we pass the english string as key
}

// Temporary static list for products. 
// Will be replaced by get_posts(['post_type' => 'product']) when CPT is registered (WP-13)
$productsList = [
    ['title' => 'Sodium Chloride 0.9%'],
    ['title' => 'Glucose 5%'],
    ['title' => 'Ringer\'s Lactate'],
    ['title' => 'Metronidazole 500mg'],
    ['title' => 'Ciprofloxacin 200mg']
];
$selectedProduct = isset($_GET['product']) ? sanitize_text_field($_GET['product']) : '';
?>

<!-- Main Content Layout -->
<main class="flex-grow">
  
  <!-- HERO SECTION -->
  <?php if (get_post_meta(get_the_ID(), '_alsalam_show_hero', true) !== '0'): ?>
    <section class="relative bg-[#041424] min-h-[400px] flex flex-col justify-end pb-16 overflow-hidden">
      <!-- Layer 1: Gradient -->
      <div class="absolute inset-0 z-[1] bg-gradient-to-tr from-[#041424]/95 via-[#05293b]/80 to-[#0a3d3f]/55 backdrop-blur-[2px]"></div>
      <div class="absolute inset-0 z-[2] bg-primary/10 backdrop-blur-sm"></div>

      <!-- Layer 2: Decoration Images -->
      <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/top-right-bg.png" alt="" class="absolute top-0 end-0 w-auto h-auto max-w-[65%] lg:max-w-[50%] object-contain pointer-events-none z-[3]" role="presentation">
      <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/bottom-left.png" alt="" class="absolute bottom-0 start-0 w-auto h-auto max-w-[65%] lg:max-w-[50%] object-contain pointer-events-none z-[3]" role="presentation">

      <!-- Hero Banner Content -->
      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center pt-36">
        <!-- Breadcrumbs -->
        <nav class="flex items-center justify-center gap-2 mb-4 text-xs font-semibold text-white/50 tracking-wider uppercase font-sans">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary-light transition-colors duration-200"><?php echo esc_html(__('Home', 'alsalam')); ?></a>
          <span class="text-white/30 font-light">/</span>
          <span class="text-white/85"><?php echo esc_html(get_the_title()); ?></span>
        </nav>
        
        <!-- Title -->
        <?php $hero_title = $meta('_alsalam_hero_title') ?: 'Request <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">Inquiry</span>'; ?>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight font-heading leading-tight mb-4">
          <?php echo wp_kses_post($hero_title); ?>
        </h1>
        
        <!-- Subtitle -->
        <?php $hero_subtitle = $meta('_alsalam_hero_subtitle', 'Submit formal product distribution requests, cleanroom API sourcing, or contract manufacturing proposals directly to our operations.'); ?>
        <?php if ($hero_subtitle): ?>
          <p class="max-w-2xl mx-auto text-base sm:text-lg text-white/70 font-normal leading-relaxed">
            <?php echo esc_html($hero_subtitle); ?>
          </p>
        <?php endif; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- SECTION: TWO-STEP PREPARATION & FORM -->
  <section class="py-20 lg:py-24 bg-[#F4F7FE] relative overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <!-- Stepper Indicator -->
      <div class="max-w-2xl mx-auto mb-12">
        <div class="flex items-center justify-between relative">
          <div class="absolute start-0 end-0 top-1/2 h-0.5 bg-slate-200 -translate-y-1/2 z-0"></div>
          <!-- Progress Line (Simulated active stage 1) -->
          <div id="stepper-progress" class="absolute start-0 top-1/2 h-0.5 bg-primary -translate-y-1/2 z-0 transition-all duration-300 w-[50%]"></div>
          
          <!-- Step 1 Indicator -->
          <button id="step-btn-1" type="button" class="relative z-10 w-10 h-10 rounded-full bg-primary text-white font-bold text-sm flex items-center justify-center border-4 border-white shadow-md focus:outline-none transition-all duration-200">
            1
          </button>
          <!-- Step 2 Indicator -->
          <button id="step-btn-2" type="button" class="relative z-10 w-10 h-10 rounded-full bg-white text-slate-400 font-bold text-sm flex items-center justify-center border-4 border-slate-100 shadow-sm focus:outline-none transition-all duration-200">
            2
          </button>
        </div>
        <div class="flex justify-between mt-3 text-xs font-bold text-[#071D2C] uppercase tracking-wider">
          <span class="text-primary-dark"><?php echo esc_html($meta('_alsalam_inquiry_step1_badge', '1. Business Profile')); ?></span>
          <span class="text-slate-400" id="step-label-2"><?php echo esc_html($meta('_alsalam_inquiry_step2_badge', '2. Clinical Inquiry')); ?></span>
        </div>
      </div>

      <!-- Form Wrapper -->
      <div class="bg-white rounded-[30px] shadow-xl border border-slate-100 p-8 sm:p-12">
        
        <form id="inquiry-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="space-y-8">
          <?php wp_nonce_field('alsalam_inquiry_submit', 'alsalam_inquiry_nonce'); ?>
          <input type="hidden" name="action" value="alsalam_submit_inquiry">
          
          <!-- STEP 1 CONTAINER -->
          <div id="step-container-1" class="transition-all duration-300 opacity-100 space-y-6">
            <div class="border-b border-slate-100 pb-4 mb-6">
              <h3 class="text-xl font-bold font-heading text-[#071D2C]"><?php echo esc_html($meta('_alsalam_inquiry_step1_title', 'Commercial & Business Profile')); ?></h3>
              <p class="text-text-secondary text-xs mt-1"><?php echo esc_html($meta('_alsalam_inquiry_step1_desc', 'Please provide credential details for clinical vetting and registration.')); ?></p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Company Name -->
              <div class="flex flex-col gap-2">
                <label for="company_name" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo alsalam_label('inquiry_company_name', 'Company Name *'); ?></label>
                <input type="text" id="company_name" name="company_name" required placeholder="<?php echo alsalam_label('inquiry_company_placeholder', 'Al-Rafidain Health Distributors'); ?>" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200">
              </div>
              <!-- Country -->
              <div class="flex flex-col gap-2">
                <label for="country" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo alsalam_label('inquiry_country', 'Operating Country *'); ?></label>
                <input type="text" id="country" name="country" required placeholder="<?php echo alsalam_label('inquiry_country_placeholder', 'Iraq'); ?>" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200">
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Contact Person -->
              <div class="flex flex-col gap-2">
                <label for="contact_name" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo alsalam_label('inquiry_rep_name', 'Representative Name *'); ?></label>
                <input type="text" id="contact_name" name="contact_name" required placeholder="<?php echo alsalam_label('inquiry_rep_placeholder', 'Dr. Ahmed Ali'); ?>" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200">
              </div>
              <!-- Job Title -->
              <div class="flex flex-col gap-2">
                <label for="job_title" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo alsalam_label('inquiry_job_title', 'Job Title / Role *'); ?></label>
                <input type="text" id="job_title" name="job_title" required placeholder="<?php echo alsalam_label('inquiry_job_placeholder', 'Procurement Director'); ?>" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200">
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Phone -->
              <div class="flex flex-col gap-2">
                <label for="phone" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo alsalam_label('inquiry_phone', 'Direct Phone *'); ?></label>
                <input type="tel" id="phone" name="phone" required placeholder="<?php echo alsalam_label('inquiry_phone_placeholder', '+964 770 123 4567'); ?>" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200">
              </div>
              <!-- Website -->
              <div class="flex flex-col gap-2">
                <label for="website" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo alsalam_label('inquiry_website', 'Website URL'); ?></label>
                <input type="url" id="website" name="website" placeholder="https://company.com" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200">
              </div>
            </div>

            <div class="flex justify-end pt-4">
              <button type="button" id="next-step-btn" class="bg-primary hover:bg-primary-dark active:bg-primary text-white text-sm font-semibold px-8 py-3.5 rounded-full shadow-lg shadow-primary/20 transition-all duration-200 transform hover:-translate-y-0.5 cursor-pointer flex items-center gap-2">
                <span><?php echo alsalam_label('inquiry_proceed_step2', 'Proceed to Step 2'); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 rtl:-scale-x-100">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
              </button>
            </div>
          </div>

          <!-- STEP 2 CONTAINER (Hidden initially) -->
          <div id="step-container-2" class="hidden transition-all duration-300 opacity-0 space-y-6">
            <div class="border-b border-slate-100 pb-4 mb-6">
              <h3 class="text-xl font-bold font-heading text-[#071D2C]"><?php echo esc_html($meta('_alsalam_inquiry_step2_title', 'Clinical Inquiry Details')); ?></h3>
              <p class="text-text-secondary text-xs mt-1"><?php echo esc_html($meta('_alsalam_inquiry_step2_desc', 'Specify your clinical requests, products of interest, and volume demands.')); ?></p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Inquiry Type Dropdown -->
              <div class="flex flex-col gap-2">
                <label for="inquiry_type" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo alsalam_label('inquiry_type', 'Inquiry Type *'); ?></label>
                <select id="inquiry_type" name="inquiry_type" required class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary focus:outline-none focus:border-primary focus:bg-white transition-all duration-200 appearance-none cursor-pointer">
                  <option value="" disabled selected><?php echo alsalam_label('inquiry_type_select', 'Select option...'); ?></option>
                  <option value="Distribution"><?php echo alsalam_label('inquiry_type_opt1', 'Hospital / Clinic Distribution'); ?></option>
                  <option value="Contract Manufacturing"><?php echo alsalam_label('inquiry_type_opt2', 'Contract Aseptic BFS Manufacturing'); ?></option>
                  <option value="API Sourcing"><?php echo alsalam_label('inquiry_type_opt3', 'Chemical / API Sterile Sourcing'); ?></option>
                  <option value="Regulatory"><?php echo alsalam_label('inquiry_type_opt4', 'Regulatory Compliance / Dossiers'); ?></option>
                  <option value="General Commercial"><?php echo alsalam_label('inquiry_type_opt5', 'General Commercial Partnerships'); ?></option>
                </select>
              </div>

              <!-- Products of Interest Dropdown (Loaded dynamically) -->
              <div class="flex flex-col gap-2">
                <label for="product_interest" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo alsalam_label('product_interest', 'Product of Interest *'); ?></label>
                <select id="product_interest" name="product_interest" required class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary focus:outline-none focus:border-primary focus:bg-white transition-all duration-200 appearance-none cursor-pointer">
                  <option value="" disabled <?php echo empty($selectedProduct) ? 'selected' : ''; ?>><?php echo alsalam_label('inquiry_select_product', 'Select product...'); ?></option>
                  <option value="all" <?php echo ($selectedProduct === 'all') ? 'selected' : ''; ?>><?php echo alsalam_label('inquiry_multiple_products', 'Multiple Products / General Order'); ?></option>
                  <?php foreach ($productsList as $p): ?>
                    <option value="<?php echo esc_attr($p['title']); ?>" <?php echo ($p['title'] === $selectedProduct) ? 'selected' : ''; ?>>
                      <?php echo esc_html($p['title']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <!-- Estimated Annual Volume -->
            <div class="flex flex-col gap-2">
              <label for="volume" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo alsalam_label('inquiry_volume', 'Estimated Annual Volume Needs (Units)'); ?></label>
              <input type="text" id="volume" name="volume" placeholder="<?php echo alsalam_label('inquiry_volume_placeholder', 'e.g. 500,000 infusion bottles'); ?>" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200">
            </div>

            <!-- Specifications Message -->
            <div class="flex flex-col gap-2">
              <label for="specifications" class="text-xs font-bold text-[#071D2C] uppercase tracking-wider"><?php echo alsalam_label('inquiry_specs', 'Clinical Specs / Message *'); ?></label>
              <textarea id="specifications" name="specifications" rows="5" required placeholder="<?php echo alsalam_label('inquiry_specs_placeholder', 'Outline formulation requirements, special packaging specs, or delivery terms...'); ?>" class="w-full bg-[#F4F7FE] border border-slate-200/80 rounded-2xl px-5 py-3.5 text-sm text-text-primary placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all duration-200 resize-none"></textarea>
            </div>

            <div class="flex justify-between items-center pt-4">
              <button type="button" id="back-step-btn" class="bg-slate-100 hover:bg-slate-200 active:bg-slate-100 text-slate-800 text-sm font-semibold px-8 py-3.5 rounded-full transition-all duration-200 cursor-pointer flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 rtl:rotate-180">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span><?php echo alsalam_label('inquiry_back_step1', 'Back to Step 1'); ?></span>
              </button>

              <button type="submit" class="bg-primary hover:bg-primary-dark active:bg-primary text-white text-sm font-semibold px-8 py-3.5 rounded-full shadow-lg shadow-primary/20 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 shrink-0">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?php echo alsalam_label('inquiry_submit_btn', 'Submit B2B Inquiry'); ?></span>
              </button>
            </div>
          </div>

        </form>

      </div>
    </div>
  </section>

</main>

<!-- We place page-specific JS here, before footer which usually closes body -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const step1 = document.getElementById('step-container-1');
    const step2 = document.getElementById('step-container-2');
    
    const nextBtn = document.getElementById('next-step-btn');
    const backBtn = document.getElementById('back-step-btn');
    
    const stepBtn1 = document.getElementById('step-btn-1');
    const stepBtn2 = document.getElementById('step-btn-2');
    const stepLabel2 = document.getElementById('step-label-2');
    const stepperProgress = document.getElementById('stepper-progress');
    
    const form = document.getElementById('inquiry-form');

    // Go to Step 2
    if(nextBtn) {
        nextBtn.addEventListener('click', () => {
        // Simple client-side validation for Step 1
        const companyName = document.getElementById('company_name').value;
        const country = document.getElementById('country').value;
        const contactName = document.getElementById('contact_name').value;
        const jobTitle = document.getElementById('job_title').value;
        const phone = document.getElementById('phone').value;
        
        if (!companyName || !country || !contactName || !jobTitle || !phone) {
            alert('<?php echo alsalam_label('inquiry_step1_validation', 'Please fill out all required fields marked with * on Step 1.'); ?>');
            return;
        }
        
        // Hide step 1, show step 2
        step1.classList.add('hidden');
        step1.classList.remove('opacity-100');
        step2.classList.remove('hidden');
        setTimeout(() => {
            step2.classList.add('opacity-100');
        }, 50);

        // Update stepper indicators
        stepBtn2.classList.add('bg-primary', 'text-white');
        stepBtn2.classList.remove('bg-white', 'text-slate-400', 'border-slate-100');
        stepLabel2.classList.add('text-primary-dark');
        stepLabel2.classList.remove('text-slate-400');
        stepperProgress.classList.add('w-full');
        stepperProgress.classList.remove('w-[50%]');
        });
    }

    // Back to Step 1
    if(backBtn) {
        backBtn.addEventListener('click', () => {
        step2.classList.add('hidden');
        step2.classList.remove('opacity-100');
        step1.classList.remove('hidden');
        setTimeout(() => {
            step1.classList.add('opacity-100');
        }, 50);

        // Update stepper indicators
        stepBtn2.classList.remove('bg-primary', 'text-white');
        stepBtn2.classList.add('bg-white', 'text-slate-400', 'border-slate-100');
        stepLabel2.classList.remove('text-primary-dark');
        stepLabel2.classList.add('text-slate-400');
        stepperProgress.classList.remove('w-full');
        stepperProgress.classList.add('w-[50%]');
        });
    }

    // Note: Form submission will be handled by WP AJAX if implemented, 
    // or you can add JS here for standard AJAX sumbit.
    if(form) {
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
                if(data.success) {
                    alert(data.data.message || '<?php echo esc_js($meta('_alsalam_inquiry_success_alert', 'Thank you! Your commercial inquiry has been registered. Our procurement team will review your business credentials.')); ?>');
                    form.reset();
                    if(backBtn) backBtn.click();
                } else {
                    alert(data.data.message || 'Error submitting form.');
                }
            })
            .catch(err => {
                alert('Connection error. Please try again.');
            })
            .finally(() => {
                if (submitBtn) submitBtn.disabled = false;
            });
        });
    }
  });
</script>

<?php get_footer(); ?>
