<?php
/**
 * Products Section Template Part
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

$products = array(
    array(
        'title' => esc_html__('IV Infusion Solution - NaCl 0.9%', 'alsalam'),
        'desc'  => esc_html__('Sterile sodium chloride infusion solution manufactured under GMP standards for clinical hydration and dilution.', 'alsalam'),
        'tag1'  => esc_html__('Electrolyte Solution', 'alsalam'),
        'tag2'  => esc_html__('Sterile', 'alsalam'),
        'tag3'  => esc_html__('GMP', 'alsalam'),
        'image' => alsalam_img('product.png')
    ),
    array(
        'title' => esc_html__('Dextrose 5% Water Infusion', 'alsalam'),
        'desc'  => esc_html__('Sterile carbohydrate parenteral solution for carbohydrate replenishment and hydration.', 'alsalam'),
        'tag1'  => esc_html__('Sterile Fluids', 'alsalam'),
        'tag2'  => esc_html__('Sterile', 'alsalam'),
        'tag3'  => esc_html__('GMP', 'alsalam'),
        'image' => alsalam_img('product.png')
    ),
    array(
        'title' => esc_html__('Ringer Lactate Infusion', 'alsalam'),
        'desc'  => esc_html__('Isotonic electrolyte replenishment infusion designed to match physiological blood plasma.', 'alsalam'),
        'tag1'  => esc_html__('Electrolyte Solution', 'alsalam'),
        'tag2'  => esc_html__('Sterile', 'alsalam'),
        'tag3'  => esc_html__('GMP', 'alsalam'),
        'image' => alsalam_img('product.png')
    )
);
?>

<section class="products-section relative w-full py-24 overflow-hidden z-0">
  <div class="absolute top-1/2 -translate-y-1/2 start-0 w-full h-[293px] bg-[#E5EEF4] -z-10 flex items-center justify-between overflow-hidden">
    <img src="<?php echo esc_url(alsalam_img('bg-pattern-left.svg')); ?>" class="h-[150%] max-w-none object-contain opacity-90 ltr:block rtl:hidden" alt="" loading="lazy" />
    <img src="<?php echo esc_url(alsalam_img('bg-pattern-right.svg')); ?>" class="h-[150%] max-w-none object-contain opacity-90 rtl:block ltr:hidden" alt="" loading="lazy" />
    <img src="<?php echo esc_url(alsalam_img('bg-pattern-right.svg')); ?>" class="h-[150%] max-w-none object-contain opacity-90 ltr:block rtl:hidden" alt="" loading="lazy" />
    <img src="<?php echo esc_url(alsalam_img('bg-pattern-left.svg')); ?>" class="h-[150%] max-w-none object-contain opacity-90 rtl:block ltr:hidden" alt="" loading="lazy" />
  </div>

  <div class="max-w-7xl mx-auto px-4 flex flex-col lg:flex-row items-center gap-12 lg:h-[540px]">
    <div class="w-full lg:w-1/3 lg:max-w-[300px] text-start flex flex-col justify-center">
      <h2 class="pt-[25px] text-[40px] font-extrabold tracking-tight leading-tight font-heading gsap-fade-up">
        <?php esc_html_e('Reliable Sterile Solutions', 'alsalam'); ?>
      </h2>
      <p class="text-slate-600 text-[20px] leading-relaxed font-sans gsap-fade-up">
        <?php esc_html_e('European Standards, Iraqi Excellence', 'alsalam'); ?>
      </p>
      
      <div class="flex flex-col items-start gap-6 gsap-fade-up">
        <a href="#contact" class="bg-teal-600 text-white px-6 py-3 rounded-full hover:bg-teal-700 font-semibold transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
          <span><?php esc_html_e('All Products', 'alsalam'); ?></span>
          <img src="<?php echo esc_url(alsalam_img('arrow-right.svg')); ?>" class="w-4 h-4 filter invert brightness-0 rtl:rotate-180" alt="Arrow Right" loading="lazy" />
        </a>
        
        <div class="flex items-center gap-3">
          <button class="custom-prev w-12 h-12 rounded-full bg-white border-2 border-teal-600 hover:border-teal-700 text-teal-600 hover:bg-teal-50 flex items-center justify-center transition-all duration-300 focus:outline-none" aria-label="<?php esc_attr_e('Previous slide', 'alsalam'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button class="custom-next w-12 h-12 rounded-full bg-white border-2 border-teal-600 hover:border-teal-700 text-teal-600 hover:bg-teal-50 flex items-center justify-center transition-all duration-300 focus:outline-none" aria-label="<?php esc_attr_e('Next slide', 'alsalam'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div class="w-full lg:flex-1 overflow-hidden h-full gsap-fade-up">
      <div class="swiper swiper-container-products relative h-full">
        <div class="swiper-wrapper flex items-stretch h-full">
          
          <?php foreach ($products as $index => $product): ?>
          <div class="swiper-slide swiper-slide-product lg:!h-[465px] p-6 border border-slate-100 rounded-[2rem] flex flex-col justify-between items-center text-center">
            <div class="w-full flex flex-col items-center">
              <div class="w-40 h-[137px] rounded-t-[100px] rounded-b-[20px] bg-slate-100/50 flex items-center justify-center mb-6 overflow-hidden relative">
                <img src="<?php echo esc_url($product['image']); ?>" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition-transform duration-500 rounded-none" alt="<?php echo esc_attr($product['title']); ?>" loading="lazy" />
              </div>
              
              <h3 class="text-xl font-bold text-slate-850 mb-2 font-heading tracking-tight leading-tight"><?php echo esc_html($product['title']); ?></h3>
              <p class="text-slate-500 text-xs px-2 leading-relaxed mb-6">
                <?php echo esc_html($product['desc']); ?>
              </p>
              
              <div class="w-full flex flex-col gap-2.5 mb-6">
                <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-full border border-slate-100/80 shadow-sm justify-center">
                  <img src="<?php echo esc_url(alsalam_img('papers-text (1).svg')); ?>" class="w-4 h-4 opacity-80" alt="Electrolyte" loading="lazy" />
                  <span class="text-xs font-semibold text-slate-600"><?php echo esc_html($product['tag1']); ?></span>
                </div>
                
                <div class="grid grid-cols-2 gap-2.5">
                  <div class="flex items-center gap-2 px-2.5 py-2 bg-white rounded-full border border-slate-100/80 shadow-sm justify-center">
                    <img src="<?php echo esc_url(alsalam_img('test-tube-alt (1).svg')); ?>" class="w-4 h-4 opacity-80" alt="Sterile" loading="lazy" />
                    <span class="text-xs font-semibold text-slate-600"><?php echo esc_html($product['tag2']); ?></span>
                  </div>
                  <div class="flex items-center gap-2 px-2.5 py-2 bg-white rounded-full border border-slate-100/80 shadow-sm justify-center">
                    <img src="<?php echo esc_url(alsalam_img('award-star.png')); ?>" class="w-4 h-4 object-contain" alt="GMP" loading="lazy" />
                    <span class="text-xs font-semibold text-slate-600"><?php echo esc_html($product['tag3']); ?></span>
                  </div>
                </div>
              </div>
            </div>
            
            <a href="#" class="w-full h-[34px] bg-[#31858A] hover:bg-[#286f73] text-white ps-5 pe-0 rounded-full flex items-center justify-between transition-all duration-300 font-semibold group shadow-md shadow-teal-700/10">
              <span class="text-sm"><?php esc_html_e('View Details', 'alsalam'); ?></span>
              <div class="w-[34px] h-[34px] rounded-full bg-transparent flex items-center justify-center ltr:group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-300">
                <img src="<?php echo esc_url(alsalam_img('arrow-right.svg')); ?>" class="w-[17px] h-[17px] filter invert brightness-0 rtl:rotate-180" alt="Arrow" loading="lazy" />
              </div>
            </a>
          </div>
          <?php endforeach; ?>

        </div>

        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
</section>
