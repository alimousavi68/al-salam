<?php
/**
 * Helper functions
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

/**
 * Global translations dictionary loader
 */
if (!function_exists('alsalam_get_dictionary')) {
    function alsalam_get_dictionary() {
        static $dict = null;
        if ($dict === null) {
            $dict = array();
            $dict_file = ALSALAM_DIR . '/includes/translations-data.php';
            if (file_exists($dict_file)) {
                $translations = require $dict_file;
                if (isset($translations) && is_array($translations)) {
                    $dict = $translations;
                }
            }
        }
        return $dict;
    }
}

/**
 * Get translation safely
 */
if (!function_exists('alsalam_str')) {
    function alsalam_str($key, $default_value = '') {
        $current_lang = '';
        if (function_exists('pll_current_language')) {
            $current_lang = pll_current_language();
        }
        if (!$current_lang && function_exists('determine_locale')) {
            $locale = determine_locale();
            if (strpos($locale, 'ar') === 0) {
                $current_lang = 'ar';
            }
        }
        if (!$current_lang && is_rtl()) {
            $current_lang = 'ar';
        }

        if ($current_lang === 'ar') {
            $all_dict = alsalam_get_dictionary();
            $ar_dict  = isset($all_dict['ar']) ? $all_dict['ar'] : array();
            $en_dict  = isset($all_dict['en']) ? $all_dict['en'] : array();

            // 1. Direct key match in Arabic dictionary
            if ($key && isset($ar_dict[$key])) {
                return $ar_dict[$key];
            }

            // 2. Default value match in Arabic dictionary
            if ($default_value) {
                if (isset($ar_dict[$default_value])) {
                    return $ar_dict[$default_value];
                }
                
                // Reverse lookup default_value in English dict
                $found_key = array_search($default_value, $en_dict, true);
                if ($found_key !== false && isset($ar_dict[$found_key])) {
                    return $ar_dict[$found_key];
                }

                // Clean string matching
                $clean_default = strtolower(trim(strip_tags($default_value)));
                foreach ($en_dict as $k => $v) {
                    if (strtolower(trim(strip_tags($v))) === $clean_default && isset($ar_dict[$k])) {
                        return $ar_dict[$k];
                    }
                }
            }

            // 3. Polylang pll__ lookup if active
            if ($default_value && function_exists('pll__')) {
                $translated = pll__($default_value);
                if ($translated && $translated !== $default_value) {
                    return $translated;
                }
            }

            // 4. Custom fallbacks for common unmapped UI elements
            if ($default_value) {
                $custom_map = array(
                    // Badges & Labels
                    'COMPANY' => 'الشركة',
                    'TECHNOLOGY' => 'التكنولوجيا',
                    'HEALTHCARE' => 'الرعاية الصحية',
                    'AL-SALAM' => 'السلام',
                    
                    // Hero Slides
                    'Sterile Pharmaceutical' => 'صناعة دوائية معقمة',
                    'Manufacturing Built on European GMP Standards' => 'تصنيع وفق معايير التصنيع الجيد GMP الأوروبية',
                    'Delivering high-quality parenteral solutions conforming to global regulatory frameworks with state-of-the-art sterile processing facilities. All lines operate with automated aseptic safety protocols.' => 'تقديم محاليل وريدية علاجية عالية النقاء تتوافق مع الأطر التنظيمية العالمية داخل منشآت تصنيع معقمة فائقة التطور.',
                    'Advanced Aseptic Lines' => 'خطوط BFS المعقمة المتقدمة',
                    'High-Tech Bio-Processing Operations' => 'عمليات مؤتمتة عالية التقنية',
                    'Utilizing advanced barrier systems (RABS) and blow-fill-seal methodologies to eliminate intervention vectors, ensuring the absolute highest safety indexes in parenteral formulation.' => 'نعتمد تكنولوجيا النفخ والتعبئة والختم الذاتية لاستبعاد عوامل التلوث البشري وضمان أعلى مؤشرات الأمان الدوائي.',
                    'Global Core Logistics' => 'الأمن الدوائي الوطني',
                    'National Health Supply Security' => 'الأمن الدوائي الوطني',
                    'Reliable Essential Critical-Care Distribution' => 'تأمين المحاليل الوريدية الحيوية',
                    'Essential Critical-Care Distribution' => 'تأمين المحاليل الوريدية الحيوية',
                    'Supplying life-saving intravenous solutions and vial parenterals globally. Our robust supply channels secure critical hospital networks with seamless therapeutic solutions continuous-uptime assurance.' => 'تزويد شبكات المستشفيات والمراكز الطبية بالمحاليل الوريدية المنقذة للحياة باستمرارية توريد موثوقة.',

                    // Infrastructure Items
                    'Sterile Production' => 'الإنتاج المعقم',
                    'Manufactured under strict GMP guidelines with high sterility standards to ensure product purity.' => 'مُصنّع تحت إرشادات ممارسات التصنيع الجيد GMP الصارمة مع معايير تعقيم عالية لضمان نقاء المنتج.',
                    'Quality Control' => 'مراقبة الجودة',
                    'Rigorous testing and analytical inspection to ensure full compliance with global pharmacopeia standards.' => 'اختبارات صارمة وفحص تحليلي لضمان الامتثال الكامل لمعايير الدستور الدوائي العالمي.',
                    'Facility & Utilities' => 'المرفق والمرافق العامة',
                    'State-of-the-art cleanroom facilities powered by intelligent climate control (HVAC) systems.' => 'مرافق غرف نظيفة متطورة تعتمد على أنظمة تحكم ذكية بالمناخ <strong>(HVAC)</strong>.',
                    'Storage & Packaging' => 'التخزين والتعبئة والتغليف',
                    'Advanced packaging and validation protocols including thermal processing for maximum safety.' => 'بروتوكولات تعبئة وتحقق متقدمة تشمل المعالجة الحرارية لأقصى درجات الأمان.',

                    // Product Titles & Descriptions (Fallback Safety Layer)
                    'Sodium Chloride 0.9%' => 'محلول صوديوم كلورايد 0.9%',
                    'IV Infusion Solution - NaCl 0.9%' => 'محلول صوديوم كلورايد 0.9%',
                    'Isotonic parenteral electrolyte solution for fluid resuscitation, hydration, and drug dilution.' => 'محلول كهرلي معقم متساوي التوتر لإعادة التروية، الترطيب وتخفيف الأدوية الوريدية.',
                    'Sterile sodium chloride infusion solution manufactured under GMP standards for clinical hydration and dilution.' => 'محلول صوديوم كلورايد معقم مُصنّع وفق معايير GMP لإعادة التروية والترطيب.',

                    'Glucose 5% Infusion' => 'محلول جلوكوز 5% للحقن الوريدي',
                    'Dextrose 5% Water Infusion' => 'محلول جلوكوز 5% للحقن الوريدي',
                    'Sterile parenteral carbohydrate solution for caloric replenishment and fluid maintenance.' => 'محلول كربوهيدراتي معقم لتعويض السعرات الحرارية والحفاظ على السوائل.',

                    "Ringer's Lactate Solution" => 'محلول رينجر لاكتات',
                    'Ringer Lactate Infusion' => 'محلول رينجر لاكتات',
                    'Balanced electrolyte replacement infusion designed to match physiological blood plasma in surgery and trauma.' => 'محلول كهرلي متوازن مصمم ليمتثل للبلازما الفسيولوجية في حالات الجراحة والصدمات.',
                    'Isotonic electrolyte replenishment infusion designed to match physiological blood plasma.' => 'محلول كهرلي متوازن مصمم ليمتثل للبلازما الفسيولوجية.',

                    "Darrow's Solution" => 'محلول داروو المعقم',
                    'Sterile potassium and sodium chloride injection for correcting severe electrolyte imbalance and pediatric dehydration.' => 'حقن كلوريد البوتاسيوم والصوديوم المعقم لتصحيح خلل الكهارل الشديد والجفاف عند الأطفال.',
                    'Sterile potassium and sodium chloride injection for correcting severe electrolyte imbalance.' => 'حقن كلوريد البوتاسيوم والصوديوم المعقم لتصحيح خلل الكهارل الشديد.',

                    'Metronidazole 500mg Solution' => 'محلول مترونيدازول 500 مجم',
                    'Metronidazole Injection' => 'محلول مترونيدازول 500 مجم',
                    'Sterile antimicrobial infusion for critical hospital care and anaerobic bacterial infections.' => 'محلول مضاد لميكروبات الحقن المعقم للرعاية المستشفى الحرجة والعدوى البكتيرية اللاهوائية.',
                    'Sterile antibacterial and antiprotozoal infusion solution for clinical systemic administration.' => 'محلول مضاد بكتيري وريدي معقم للرعاية المستشفى الحرجة.',

                    'Mannitol 20% Infusion' => 'محلول مانيتول 20%',
                    'Sterile hypertonic osmotic diuretic solution for reduction of intracranial pressure and cerebral edema.' => 'محلول مدر للبول التناضحي المعقم لتقليل الضغط داخل الجمجمة والوذمة الدماغية.',
                    'Sterile hypertonic osmotic diuretic solution for reduction of intracranial pressure.' => 'محلول مدر للبول التناضحي المعقم لتقليل الضغط داخل الجمجمة.',

                    'Paracetamol IV Infusion' => 'محلول باراسيتامول وريدي',
                    'Sterile analgesic and antipyretic solution for short-term treatment of moderate pain and fever.' => 'محلول مسكن ومخفض للحرارة معقم للعلاج قصير الأمد للألم المتوسط والحمى.',

                    'Sodium Bicarbonate 8.4% Infusion' => 'بيكربونات الصوديوم 8.4%',
                    'Sterile hypertonic solution for correction of metabolic acidosis and systemic alkalization in emergency care.' => 'محلول معقم مرتفع التوتر لتصحيح الحماض الاستقلابي وزيادة قلوية الجسم في الحالات الطارئة.',
                    'Sterile hypertonic solution for correction of metabolic acidosis and systemic alkalization.' => 'محلول معقم مرتفع التوتر لتصحيح الحماض الاستقلابي وزيادة قلوية الجسم.',

                    'Potassium Chloride 10% Injection' => 'كلوريد البوتاسيوم 10% للحقن',
                    'Sterile concentrated potassium infusion for treatment of severe hypokalemia.' => 'محلول بوتاسيوم مركز معقم لعلاج نقص بوتاسيوم الدم الحاد.',

                    'Sterile Water for Injection' => 'ماء معقم للحقن',
                    'Ultra-pure sterile water for dissolving and diluting parenteral drugs in cleanroom processing.' => 'ماء معقم فائقة النقاء لإذابة وتخفيف الأدوية الوريدية داخل الغرف النظيفة.',
                    'Ultra-pure sterile water for dissolving and diluting parenteral drugs.' => 'ماء معقم فائقة النقاء لإذابة وتخفيف الأدوية الوريدية.',

                    'Ciprofloxacin IV Infusion 200mg' => 'سيبروفلوكساسين وريدي 200 مجم',
                    'Ciprofloxacin IV Infusion' => 'سيبروفلوكساسين وريدي 200 مجم',
                    'Sterile broad-spectrum fluoroquinolone antibacterial solution for intravenous administration.' => 'محلول مضاد حيوي معقم واسع المجال من الفلوروكينولون للحقن الوريدي.',

                    'Calcium Gluconate 10% Injection' => 'جلوكونات الكالسيوم 10%',
                    'Sterile solution for cardioprotection and therapy of acute hypocalcemia in clinical ICUs.' => 'محلول معقم لحماية القلب وعلاج نقص كالسيوم الدم الحاد في وحدات العناية المركزة.',
                    'Sterile solution for cardioprotection and therapy of acute hypocalcemia.' => 'محلول معقم لحماية القلب وعلاج نقص كالسيوم الدم الحاد.',

                    // Products Tags & Common Labels
                    'Electrolyte Solution' => 'محلول كهرلي',
                    'Sterile' => 'معقم',
                    'GMP' => 'معتمد GMP',
                    'BFS Sterile Bottle' => 'عبوة BFS معقمة',
                    '500ml' => '٥٠٠ مل',
                    '100ml' => '١٠٠ مل',
                    '250ml' => '٢٥٠ مل',
                    'GMP Certified' => 'معتمد بموجب GMP',
                    'Sterile Fluids' => 'سوائل معقمة',
                    'USP Standard' => 'معيار USP',
                    'Class A Cleanroom' => 'غرفة نظيفة فئة A',
                    'European GMP' => 'GMP أوروبي',
                    'Aseptic BFS Pack' => 'كيس BFS معقم',
                    'BFS Container' => 'عبوة BFS',
                    'Sterile API' => 'مادة فعالة معقمة',
                    'Osmotic Diuretic' => 'مدر تناضحي',
                    'Analgesic Solution' => 'محلول مسكن',
                    'EU Standards' => 'معايير أوروبية',
                    'Systemic Alkalizer' => 'منظم قلوية',
                    'Concentrated Electrolyte' => 'كهرلي مركز',
                    'Purified Solvent' => 'مذيب نقاء',
                    'Class A Sterility' => 'تعقيم فئة A',
                    'Antibacterial Infusion' => 'محلول مضاد بكتيري',
                    'Cardioprotective Fluid' => 'سائل حماية القلب',

                    // General Buttons & Titles
                    'Sterile Solutions' => 'حلول معقمة',
                    'Reliable' => 'موثوقة',
                    'European Certified' => 'معتمد أوروبياً',
                    'Advanced BFS Technology' => 'تقنية BFS المتقدمة',
                    'Cleanroom Qualification' => 'تأهيل الغرف النظيفة',
                    'ISO 9001 Certified' => 'شهادة ISO 9001',
                    'Trusted Quality' => 'جودة موثوقة',
                    'Precision in Sterile Care' => 'دقة في الرعاية المعقمة',
                    'Iraqi Excellence' => 'تميز عراقي',
                    'European Standards' => 'معايير أوروبية',
                    'About Us' => 'نبذة عنا',
                    'Our Products' => 'منتجاتنا',
                    'Learn More' => 'اعرف المزيد',
                    'All Products' => 'جميع المنتجات',
                    'View Details' => 'عرض التفاصيل',
                    'Company Gallery' => 'معرض صور الشركة',
                    'All Photos' => 'كل الصور',
                    'What Our Partners Say' => 'ماذا يقول شركاؤنا',
                    'All Comments' => 'جميع الآراء',
                    'Copyright © [year] AL-SALAM. All rights reserved.' => 'جميع حقوق الملكية الفكرية محفوظة. © [year] السلام'
                );

                if (isset($custom_map[$default_value])) {
                    return $custom_map[$default_value];
                }
            }
        }

        return $default_value !== '' ? $default_value : $key;
    }
}

/**
 * Get image URI from assets
 */
function alsalam_img($filename) {
    return ALSALAM_URI . '/assets/images/' . $filename;
}

/**
 * Convert Western Arabic numerals (0-9) to Eastern Arabic-Indic numerals (٠-٩)
 * when the current language is Arabic. Otherwise return the value unchanged.
 *
 * Usage: echo alsalam_number(42);      // outputs ٤٢ in Arabic context
 *        echo alsalam_number('500ml'); // outputs ٥٠٠ml in Arabic context
 *
 * @param  string|int $value The number or string containing numbers.
 * @return string
 */
if (!function_exists('alsalam_number')) {
    function alsalam_number($value) {
        $is_ar = false;
        if (function_exists('pll_current_language')) {
            $is_ar = (pll_current_language() === 'ar');
        } elseif (is_rtl()) {
            $is_ar = true;
        }

        if (!$is_ar) {
            return (string) $value;
        }

        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $arabic  = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        return str_replace($western, $arabic, (string) $value);
    }
}

/**
 * Format and localize a date string — uses Arabic numerals in AR context.
 *
 * @param  string $format  PHP date format string (default 'Y/m/d').
 * @param  int    $post_id Optional post ID; defaults to current post in loop.
 * @return string
 */
if (!function_exists('alsalam_date')) {
    function alsalam_date($format = 'Y/m/d', $post_id = null) {
        if ($post_id) {
            $date = get_the_date($format, $post_id);
        } else {
            $date = get_the_date($format);
        }
        return alsalam_number($date);
    }
}

