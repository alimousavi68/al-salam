<?php
/**
 * Why Choose Us Section Template Part
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;
?>
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <div class="relative w-full h-full lg:pe-8 group">
                <div class="absolute top-1/2 start-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-gradient-to-tr from-teal-100/50 to-transparent rounded-full blur-3xl -z-10 pointer-events-none"></div>

                <div class="relative w-full h-[400px] sm:h-[480px] lg:h-full min-h-[350px] rounded-[2rem] overflow-hidden bg-background-page isolate">
                    <img src="<?php echo esc_url(alsalam_img('Why Choose Us.jpg')); ?>" 
                        alt="<?php esc_attr_e('Why Choose Us', 'alsalam'); ?>" 
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.05]" loading="lazy" />
                    
                    <div class="absolute -top-[2px] -start-[2px] w-[calc(50%+2px)] h-[calc(25%+2px)] rtl:w-[calc(40%+2px)] rtl:h-[28.5%] bg-background-page z-10 rounded-ee-[2.5rem]"></div>
                    
                    <svg class="absolute top-0 start-1/2 rtl:start-[40%] w-8 h-8 z-10 text-background-page -ms-[1px] rtl:-scale-x-100" fill="currentColor" viewBox="0 0 100 100">
                        <path d="M0 0 L100 0 A100 100 0 0 0 0 100 Z" />
                    </svg>
                    
                    <svg class="absolute top-1/4 rtl:top-[28%] start-0 w-8 h-8 z-10 text-background-page -mt-[1px] rtl:-scale-x-100" fill="currentColor" viewBox="0 0 100 100">
                        <path d="M0 0 L100 0 A100 100 0 0 0 0 100 Z" />
                    </svg>
                </div>

                <div class="absolute -top-[13%] -start-[12%] z-20 max-w-[85%] flex flex-col items-start gap-4 transition-transform duration-500 hover:-translate-y-1 gsap-fade-up">
                    <span class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-50 to-white border border-teal-100 text-teal-800 rounded-full px-4 py-1.5 text-sm font-bold shadow-md">
                        <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                        <?php esc_html_e('Flexible IV Bag Technology', 'alsalam'); ?>
                    </span>

                    <div class="p-4">
                        <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-2 tracking-tight font-heading">
                            <?php esc_html_e('Why Choose Us', 'alsalam'); ?>
                        </h2>
                        <p class="text-slate-500 text-base font-medium leading-relaxed font-sans">
                            <?php esc_html_e('A transversal vision with infinite solutions', 'alsalam'); ?>
                        </p>
                    </div>
                </div>

                <div class="absolute top-[-20px] end-[60px] rtl:end-[30px] translate-x-1/4 -translate-y-1/4 z-30 transition-transform duration-700 hover:rotate-12 hover:scale-110">
                    <img src="<?php echo esc_url(alsalam_img('question_mark_sign_blue_01 copy 1 1.svg')); ?>" 
                        alt="Question Mark" 
                        class="w-full h-full object-contain drop-shadow-[0_15px_25px_rgba(20,184,166,0.4)]" loading="lazy" />
                </div>
            </div>

            <div class="text-start">
                <header class="mb-4 gsap-fade-up">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 leading-tight font-heading">
                        <?php esc_html_e('Safer, Smarter Infusion Solutions', 'alsalam'); ?>
                    </h2>
                    <p class="text-lg text-slate-500 font-sans">
                        <?php esc_html_e('Advanced flexible IV bags designed to improve safety, handling, and efficiency compared to conventional glass bottles.', 'alsalam'); ?>
                    </p>
                </header>

                <ul class="flex flex-col gap-4">
                    <li class="why-stagger-item flex items-center gap-4 bg-white rounded-full py-1.5 ps-3 pe-6 shadow-md shadow-slate-200/50 transition-transform duration-300 hover:-translate-y-1 cursor-default border border-slate-100">
                        <img src="<?php echo esc_url(alsalam_img('medal-star.svg')); ?>" alt="" class="w-8 h-8 shrink-0" loading="lazy">
                        <article class="flex flex-col">
                            <h3 class="text-slate-800 font-bold text-base font-heading"><?php esc_html_e('Enhanced Safety', 'alsalam'); ?></h3>
                            <p class="text-slate-500 text-sm line-clamp-1 font-sans"><?php esc_html_e('Reduced risk of breakage and contamination in clinical settings.', 'alsalam'); ?></p>
                        </article>
                    </li>

                    <li class="why-stagger-item flex items-center gap-4 bg-white rounded-full py-1.5 ps-3 pe-6 shadow-md shadow-slate-200/50 transition-transform duration-300 hover:-translate-y-1 cursor-default border border-slate-100">
                        <img src="<?php echo esc_url(alsalam_img('truck.svg')); ?>" alt="" class="w-8 h-8 shrink-0" loading="lazy">
                        <article class="flex flex-col">
                            <h3 class="text-slate-800 font-bold text-base font-heading"><?php esc_html_e('Better Handling', 'alsalam'); ?></h3>
                            <p class="text-slate-500 text-sm line-clamp-1 font-sans"><?php esc_html_e('Lightweight and easy to transport, optimizing logistics.', 'alsalam'); ?></p>
                        </article>
                    </li>

                    <li class="why-stagger-item flex items-center gap-4 bg-white rounded-full py-1.5 ps-3 pe-6 shadow-md shadow-slate-200/50 transition-transform duration-300 hover:-translate-y-1 cursor-default border border-slate-100">
                        <img src="<?php echo esc_url(alsalam_img('target.svg')); ?>" alt="" class="w-8 h-8 shrink-0" loading="lazy">
                        <article class="flex flex-col">
                            <h3 class="text-slate-800 font-bold text-base font-heading"><?php esc_html_e('Clinical Efficiency', 'alsalam'); ?></h3>
                            <p class="text-slate-500 text-sm line-clamp-1 font-sans"><?php esc_html_e('Streamlined design for medical staff and fast setup.', 'alsalam'); ?></p>
                        </article>
                    </li>

                    <li class="why-stagger-item flex items-center gap-4 bg-white rounded-full py-1.5 ps-3 pe-6 shadow-md shadow-slate-200/50 transition-transform duration-300 hover:-translate-y-1 cursor-default border border-slate-100">
                        <img src="<?php echo esc_url(alsalam_img('layer-group.svg')); ?>" alt="" class="w-8 h-8 shrink-0" loading="lazy">
                        <article class="flex flex-col">
                            <h3 class="text-slate-800 font-bold text-base font-heading"><?php esc_html_e('Advanced Materials', 'alsalam'); ?></h3>
                            <p class="text-slate-500 text-sm line-clamp-1 font-sans"><?php esc_html_e('Multi-layered technology for optimal medical protection.', 'alsalam'); ?></p>
                        </article>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
