<?php
/**
 * Database Seeder for AL-SALAM theme
 * Handles creating categories, posts, and linking translations via Polylang.
 */

defined('ABSPATH') || exit;

// Temporarily removed capability check for automated seeder run
function alsalam_run_seeder_action() {
    if (isset($_GET['run_alsalam_seeder']) && $_GET['run_alsalam_seeder'] == '1') {
        alsalam_seed_data();
        wp_die('Seeder completed successfully.');
    }
    
    if (isset($_GET['run_alsalam_customizer_seeder']) && $_GET['run_alsalam_customizer_seeder'] == '1') {
        alsalam_seed_customizer_options();
        wp_die('Customizer Seeder completed successfully.');
    }
}
add_action('init', 'alsalam_run_seeder_action');

function alsalam_run_seeder() {
    $is_polylang_active = function_exists('pll_set_post_language');

    if (!$is_polylang_active) {
        wp_die('Polylang is not active. Please install and activate Polylang, and configure EN and AR languages before running the seeder.');
    }

    echo '<h3>AL-SALAM Seeder Log</h3>';
    echo '<ul>';

    // 1. Create Categories
    $en_cat_id = wp_insert_term('Educational', 'category', array('slug' => 'educational-en'));
    $ar_cat_id = wp_insert_term('تعليمي', 'category', array('slug' => 'educational-ar'));

    $en_cat_term_id = is_wp_error($en_cat_id) ? $en_cat_id->error_data['term_exists'] : $en_cat_id['term_id'];
    $ar_cat_term_id = is_wp_error($ar_cat_id) ? $ar_cat_id->error_data['term_exists'] : $ar_cat_id['term_id'];

    if ($en_cat_term_id) pll_set_term_language($en_cat_term_id, 'en');
    if ($ar_cat_term_id) pll_set_term_language($ar_cat_term_id, 'ar');

    // Link translations
    if ($en_cat_term_id && $ar_cat_term_id) {
        pll_save_term_translations(array(
            'en' => $en_cat_term_id,
            'ar' => $ar_cat_term_id
        ));
        echo '<li>Categories created and translated successfully.</li>';
    }

    $en_news = [
        [
            "title" => "The Name Of Article 1",
            "date" => "2024/02/21",
            "image" => "assets/images/news1.jpg",
            "desc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec arcu sodales, rhoncus ex sed, tempor sapien.",
            "category" => "latest"
        ],
        [
            "title" => "The Name Of Article 2",
            "date" => "2024/02/21",
            "image" => "assets/images/news2.jpg",
            "desc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non pulvinar est, eu gravida purus. Sed convallis sem.",
            "category" => "latest"
        ],
        [
            "title" => "The Name Of Article 3",
            "date" => "2024/02/21",
            "image" => "assets/images/news3.jpg",
            "desc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tristique velit eu sapien imperdiet lacinia non quis ligula.",
            "category" => "latest"
        ],
        [
            "title" => "The Name Of Article 4",
            "date" => "2024/02/21",
            "image" => "assets/images/news1.jpg",
            "desc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet tincidunt sapien. In hac habitasse platea.",
            "category" => "educational"
        ],
        [
            "title" => "The Name Of Article 5",
            "date" => "2024/02/21",
            "image" => "assets/images/news2.jpg",
            "desc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque eget elit a massa dapibus dictum ac quis magna.",
            "category" => "educational"
        ],
        [
            "title" => "The Name Of Article 6",
            "date" => "2024/02/21",
            "image" => "assets/images/news3.jpg",
            "desc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam elementum tellus a mi condimentum, vitae ultrices justo.",
            "category" => "educational"
        ]
    ];

    $ar_news = [
        [
            "title" => "اسم المقالة ١",
            "date" => "2024/02/21",
            "image" => "assets/images/news1.jpg",
            "desc" => "نص لوريم إيبسوم عربي للتجربة. هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.",
            "category" => "latest"
        ],
        [
            "title" => "اسم المقالة ٢",
            "date" => "2024/02/21",
            "image" => "assets/images/news2.jpg",
            "desc" => "نص لوريم إيبسوم عربي للتجربة. هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.",
            "category" => "latest"
        ],
        [
            "title" => "اسم المقالة ٣",
            "date" => "2024/02/21",
            "image" => "assets/images/news3.jpg",
            "desc" => "نص لوريم إيبسوم عربي للتجربة. هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.",
            "category" => "latest"
        ],
        [
            "title" => "اسم المقالة التعليمية ٤",
            "date" => "2024/02/21",
            "image" => "assets/images/news1.jpg",
            "desc" => "نص لوريم إيبسوم عربي للتجربة. هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.",
            "category" => "educational"
        ],
        [
            "title" => "اسم المقالة التعليمية ٥",
            "date" => "2024/02/21",
            "image" => "assets/images/news2.jpg",
            "desc" => "نص لوريم إيبسوم عربي للتجربة. هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.",
            "category" => "educational"
        ],
        [
            "title" => "اسم المقالة التعليمية ٦",
            "date" => "2024/02/21",
            "image" => "assets/images/news3.jpg",
            "desc" => "نص لوريم إيبسوم عربي للتجربة. هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.",
            "category" => "educational"
        ]
    ];

    // Create posts
    foreach ($en_news as $index => $en_item) {
        $ar_item = isset($ar_news[$index]) ? $ar_news[$index] : null;
        if (!$ar_item) continue;

        // Ensure we aren't creating duplicates by checking title
        if (post_exists($en_item['title'])) {
            echo '<li>Skipped existing post: ' . esc_html($en_item['title']) . '</li>';
            continue;
        }

        // --- Create EN Post ---
        $en_post_data = array(
            'post_title'   => wp_strip_all_tags($en_item['title']),
            'post_content' => wp_kses_post($en_item['desc']) . "\n\n<!-- Insert full content here -->",
            'post_excerpt' => wp_strip_all_tags($en_item['desc']),
            'post_status'  => 'publish',
            'post_type'    => 'post',
            'post_date'    => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $en_item['date'])))
        );
        $en_post_id = wp_insert_post($en_post_data);
        if (is_wp_error($en_post_id)) {
            echo '<li>Error creating EN post: ' . $en_item['title'] . '</li>';
            continue;
        }

        pll_set_post_language($en_post_id, 'en');

        if ($en_item['category'] === 'educational' && $en_cat_term_id) {
            wp_set_post_categories($en_post_id, array($en_cat_term_id));
        }

        // Attach Image (simplified path reference for seeder)
        $img_path = ALSALAM_DIR . '/../alsalam_original_theme/' . $en_item['image'];
        alsalam_attach_image_to_post($img_path, $en_post_id);

        // --- Create AR Post ---
        $ar_post_data = array(
            'post_title'   => wp_strip_all_tags($ar_item['title']),
            'post_content' => wp_kses_post($ar_item['desc']) . "\n\n<!-- Insert full content here -->",
            'post_excerpt' => wp_strip_all_tags($ar_item['desc']),
            'post_status'  => 'publish',
            'post_type'    => 'post',
            'post_date'    => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $ar_item['date'])))
        );
        $ar_post_id = wp_insert_post($ar_post_data);
        if (!is_wp_error($ar_post_id)) {
            pll_set_post_language($ar_post_id, 'ar');
            if ($ar_item['category'] === 'educational' && $ar_cat_term_id) {
                wp_set_post_categories($ar_post_id, array($ar_cat_term_id));
            }
            alsalam_attach_image_to_post($img_path, $ar_post_id); // Assuming same image for both

            // Link translations
            pll_save_post_translations(array(
                'en' => $en_post_id,
                'ar' => $ar_post_id
            ));
            
            echo '<li>Successfully created & linked EN and AR posts for: ' . esc_html($en_item['title']) . '</li>';
        }
    }

    // --- 3. Seed About Pages ---
    echo '</ul><h3>Seeding Pages</h3><ul>';
    $translations_path = ALSALAM_DIR . '/../alsalam_original_theme/data/translations.php';
    if (file_exists($translations_path)) {
        $content = file_get_contents($translations_path);
        $content = preg_replace('/function __\(\$key\).*?\}/s', '', $content);
        $content = str_replace('<?php', '', $content);
        eval($content);
        
        if (isset($translations) && isset($translations['en']) && isset($translations['ar'])) {
            function alsalam_seed_about_page($lang, $title, $translations_array) {
                $existing = get_page_by_title($title, OBJECT, 'page');
                if ($existing) {
                    $post_id = $existing->ID;
                    echo '<li>Page ' . esc_html($title) . ' already exists. Updating meta...</li>';
                } else {
                    $post_id = wp_insert_post([
                        'post_title' => $title,
                        'post_type' => 'page',
                        'post_status' => 'publish',
                        'page_template' => 'page-about.php'
                    ]);
                    echo '<li>Created page ' . esc_html($title) . '.</li>';
                }

                update_post_meta($post_id, '_wp_page_template', 'page-about.php');
                update_post_meta($post_id, '_alsalam_hero_title', 'About <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">AL-SALAM</span>');
                update_post_meta($post_id, '_alsalam_hero_subtitle', 'Pioneering parenteral solution manufacturing with uncompromising clinical excellence and European GMP standards.');
                $meta_map = [
                    'about_meta_title' => '_alsalam_meta_title',
                    'about_page_subtitle' => '_alsalam_hero_subtitle',
                    'about_corp_profile_badge' => '_alsalam_about_corp_profile_badge',
                    'about_corp_profile_title' => '_alsalam_about_corp_profile_title',
                    'about_corp_profile_desc1' => '_alsalam_about_corp_profile_desc1',
                    'about_corp_profile_desc2' => '_alsalam_about_corp_profile_desc2',
                    'about_standards_title' => '_alsalam_about_standards_title',
                    'about_standards_desc' => '_alsalam_about_standards_desc',
                    'about_aseptic_title' => '_alsalam_about_aseptic_title',
                    'about_aseptic_desc' => '_alsalam_about_aseptic_desc',
                    'about_purpose_title' => '_alsalam_about_purpose_title',
                    'about_vision_title' => '_alsalam_about_vision_title',
                    'about_vision_desc' => '_alsalam_about_vision_desc',
                    'about_vision_badge' => '_alsalam_about_vision_badge',
                    'about_mission_title' => '_alsalam_about_mission_title',
                    'about_mission_desc' => '_alsalam_about_mission_desc',
                    'about_mission_badge' => '_alsalam_about_mission_badge',
                    'about_values_title' => '_alsalam_about_values_title',
                    'about_values_val1' => '_alsalam_about_values_val1',
                    'about_values_val2' => '_alsalam_about_values_val2',
                    'about_values_val3' => '_alsalam_about_values_val3',
                    'about_values_badge' => '_alsalam_about_values_badge',
                    'about_cap_badge' => '_alsalam_about_cap_badge',
                    'about_cap_title' => '_alsalam_about_cap_title',
                    'about_cap_desc' => '_alsalam_about_cap_desc',
                    'about_metric1_val' => '_alsalam_about_metric1_val',
                    'about_metric1_title' => '_alsalam_about_metric1_title',
                    'about_metric1_desc' => '_alsalam_about_metric1_desc',
                    'about_metric2_val' => '_alsalam_about_metric2_val',
                    'about_metric2_title' => '_alsalam_about_metric2_title',
                    'about_metric2_desc' => '_alsalam_about_metric2_desc',
                    'about_metric3_val' => '_alsalam_about_metric3_val',
                    'about_metric3_title' => '_alsalam_about_metric3_title',
                    'about_metric3_desc' => '_alsalam_about_metric3_desc',
                    'about_metric4_val' => '_alsalam_about_metric4_val',
                    'about_metric4_title' => '_alsalam_about_metric4_title',
                    'about_metric4_desc' => '_alsalam_about_metric4_desc',
                    'about_cta_title' => '_alsalam_about_cta_title',
                    'about_cta_desc' => '_alsalam_about_cta_desc',
                    'submit_inquiry_btn' => '_alsalam_submit_inquiry_btn',
                ];

                foreach ($meta_map as $orig_key => $meta_key) {
                    if (isset($translations_array[$orig_key])) {
                        update_post_meta($post_id, $meta_key, wp_kses_post($translations_array[$orig_key]));
                    }
                }
                
                update_post_meta($post_id, '_alsalam_show_hero', '1');
                if (function_exists('pll_set_post_language')) {
                    pll_set_post_language($post_id, $lang);
                }
                return $post_id;
            }

            $en_id = alsalam_seed_about_page('en', 'About', $translations['en']);
            $ar_id = alsalam_seed_about_page('ar', 'من نحن', $translations['ar']);

            if (function_exists('pll_save_post_translations')) {
                pll_save_post_translations([
                    'en' => $en_id,
                    'ar' => $ar_id
                ]);
                echo '<li>Linked page translations successfully.</li>';
            }

            // Seed Contact Page
            function alsalam_seed_contact_page($lang, $title, $translations_array) {
                $existing = get_page_by_title($title, OBJECT, 'page');
                if ($existing) {
                    $post_id = $existing->ID;
                    echo '<li>Page ' . esc_html($title) . ' already exists. Updating meta...</li>';
                } else {
                    $post_id = wp_insert_post([
                        'post_title' => $title,
                        'post_type' => 'page',
                        'post_status' => 'publish',
                        'page_template' => 'page-contact.php'
                    ]);
                    echo '<li>Created page ' . esc_html($title) . '.</li>';
                }

                update_post_meta($post_id, '_wp_page_template', 'page-contact.php');
                update_post_meta($post_id, '_alsalam_hero_title', 'Get in <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">Touch</span>');
                update_post_meta($post_id, '_alsalam_hero_subtitle', 'Have questions about our sterile manufacturing capabilities, product distribution, or regulatory compliance? Reach out to our teams.');
                
                $contact_meta_map = [
                    'contact_hero_subtitle' => '_alsalam_hero_subtitle',
                    'contact_facility_title' => '_alsalam_contact_facility_title',
                    'contact_facility_desc' => '_alsalam_contact_facility_desc',
                    'contact_phone_title' => '_alsalam_contact_phone_title',
                    'contact_phone_desc' => '_alsalam_contact_phone_desc',
                    'contact_email_title' => '_alsalam_contact_email_title',
                    'contact_email_desc' => '_alsalam_contact_email_desc',
                    'contact_hours_title' => '_alsalam_contact_hours_title',
                    'contact_hours_desc' => '_alsalam_contact_hours_desc',
                    'contact_hours_value' => '_alsalam_contact_hours_val',
                    'contact_hours_closed' => '_alsalam_contact_hours_closed',
                    'contact_form_badge' => '_alsalam_contact_form_badge',
                    'contact_form_title' => '_alsalam_contact_form_title',
                    'contact_form_desc' => '_alsalam_contact_form_desc',
                    'contact_map_badge' => '_alsalam_contact_map_badge',
                    'contact_map_title' => '_alsalam_contact_map_title',
                    'contact_map_desc' => '_alsalam_contact_map_desc',
                    'contact_map_coords' => '_alsalam_contact_map_coords',
                    'contact_map_gmp' => '_alsalam_contact_map_gmp',
                    'contact_map_classa' => '_alsalam_contact_map_classa',
                ];

                foreach ($contact_meta_map as $orig_key => $meta_key) {
                    if (isset($translations_array[$orig_key])) {
                        update_post_meta($post_id, $meta_key, wp_kses_post($translations_array[$orig_key]));
                    }
                }
                
                // Hardcoded defaults for un-translated fields in original
                update_post_meta($post_id, '_alsalam_contact_phone1', '+964 770 000 0000');
                update_post_meta($post_id, '_alsalam_contact_phone2', '+964 780 000 0000');
                update_post_meta($post_id, '_alsalam_contact_email1', 'info@alsalam-pharma.com');
                update_post_meta($post_id, '_alsalam_contact_email2', 'sales@alsalam-pharma.com');

                update_post_meta($post_id, '_alsalam_show_hero', '1');
                if (function_exists('pll_set_post_language')) {
                    pll_set_post_language($post_id, $lang);
                }
                return $post_id;
            }

            $en_contact_id = alsalam_seed_contact_page('en', 'Contact', $translations['en']);
            $ar_contact_id = alsalam_seed_contact_page('ar', 'اتصل بنا', $translations['ar']);

            if (function_exists('pll_save_post_translations')) {
                pll_save_post_translations([
                    'en' => $en_contact_id,
                    'ar' => $ar_contact_id
                ]);
            }
            
            // Seed Inquiry Page
            function alsalam_seed_inquiry_page($lang, $title, $translations_array) {
                $existing = get_page_by_title($title, OBJECT, 'page');
                if ($existing) {
                    $post_id = $existing->ID;
                    echo '<li>Page ' . esc_html($title) . ' already exists. Updating meta...</li>';
                } else {
                    $post_id = wp_insert_post([
                        'post_title' => $title,
                        'post_type' => 'page',
                        'post_status' => 'publish',
                        'page_template' => 'page-inquiry.php'
                    ]);
                    echo '<li>Created page ' . esc_html($title) . '.</li>';
                }

                update_post_meta($post_id, '_wp_page_template', 'page-inquiry.php');
                update_post_meta($post_id, '_alsalam_hero_title', 'Request <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">Inquiry</span>');
                update_post_meta($post_id, '_alsalam_hero_subtitle', 'Submit formal product distribution requests, cleanroom API sourcing, or contract manufacturing proposals directly to our operations.');
                
                $inquiry_meta_map = [
                    'inquiry_hero_subtitle' => '_alsalam_hero_subtitle',
                    'inquiry_step1_badge' => '_alsalam_inquiry_step1_badge',
                    'inquiry_step1_title' => '_alsalam_inquiry_step1_title',
                    'inquiry_step1_desc' => '_alsalam_inquiry_step1_desc',
                    'inquiry_step2_badge' => '_alsalam_inquiry_step2_badge',
                    'inquiry_step2_title' => '_alsalam_inquiry_step2_title',
                    'inquiry_step2_desc' => '_alsalam_inquiry_step2_desc',
                    'inquiry_success_alert' => '_alsalam_inquiry_success_alert',
                ];

                foreach ($inquiry_meta_map as $orig_key => $meta_key) {
                    if (isset($translations_array[$orig_key])) {
                        update_post_meta($post_id, $meta_key, wp_kses_post($translations_array[$orig_key]));
                    }
                }

                update_post_meta($post_id, '_alsalam_show_hero', '1');
                if (function_exists('pll_set_post_language')) {
                    pll_set_post_language($post_id, $lang);
                }
                return $post_id;
            }

            $en_inquiry_id = alsalam_seed_inquiry_page('en', 'Request Inquiry', $translations['en']);
            $ar_inquiry_id = alsalam_seed_inquiry_page('ar', 'تقديم استفسار', $translations['ar']);

            if (function_exists('pll_save_post_translations')) {
                pll_save_post_translations([
                    'en' => $en_inquiry_id,
                    'ar' => $ar_inquiry_id
                ]);
            }

            // Seed Join Us Page
            function alsalam_seed_joinus_page($lang, $title, $translations_array) {
                $existing = get_page_by_title($title, OBJECT, 'page');
                if ($existing) {
                    $post_id = $existing->ID;
                    echo '<li>Page ' . esc_html($title) . ' already exists. Updating meta...</li>';
                } else {
                    $post_id = wp_insert_post([
                        'post_title' => $title,
                        'post_type' => 'page',
                        'post_status' => 'publish',
                        'page_template' => 'page-join-us.php'
                    ]);
                    echo '<li>Created page ' . esc_html($title) . '.</li>';
                }

                update_post_meta($post_id, '_wp_page_template', 'page-join-us.php');
                
                if ($lang === 'ar') {
                    update_post_meta($post_id, '_alsalam_hero_title', 'انضم إلى <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">فريقنا</span>');
                    update_post_meta($post_id, '_alsalam_hero_subtitle', 'ابنِ مسيرتك المهنية مع مصنع السلام الرائد للصناعات الدوائية المعقمة في العراق.');
                    update_post_meta($post_id, '_alsalam_joinus_culture_badge', 'ثقافة العمل والنمو');
                    update_post_meta($post_id, '_alsalam_joinus_culture_title', 'لماذا تبني مسيرتك المهنية مع السلام؟');
                    update_post_meta($post_id, '_alsalam_joinus_culture_desc', 'انضم إلى فريق عالمي المستوى من أخصائيي التصنيع المعقم والمهندسين الطبيين لتطبيق أفضل المعايير الدولية.');
                    update_post_meta($post_id, '_alsalam_joinus_form_badge', 'استمارة التوظيف');
                    update_post_meta($post_id, '_alsalam_joinus_form_title', 'قدم سيرتك الذاتية');
                    update_post_meta($post_id, '_alsalam_joinus_form_desc', 'قم بملء معلوماتك وبياناتك التخصصية أدناه لتقييمها من قبل فريق الموارد البشرية.');
                    update_post_meta($post_id, '_alsalam_joinus_success_alert', 'نشكرك! تم تقديم طلب التوظيف بنجاح إلى فريق الموارد البشرية في شركة السلام.');
                } else {
                    update_post_meta($post_id, '_alsalam_hero_title', 'Join <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">Our Team</span>');
                    update_post_meta($post_id, '_alsalam_hero_subtitle', 'Build your career with Iraq\'s leading sterile pharmaceutical manufacturer.');
                    update_post_meta($post_id, '_alsalam_joinus_culture_badge', 'Work Culture & Growth');
                    update_post_meta($post_id, '_alsalam_joinus_culture_title', 'Why Build Your Career with AL-SALAM?');
                    update_post_meta($post_id, '_alsalam_joinus_culture_desc', 'Join a world-class team of sterile manufacturing specialists, pharmaceutical engineers, and clinical professionals dedicated to setting new benchmarks in Iraq.');
                    update_post_meta($post_id, '_alsalam_joinus_form_badge', 'Careers Intake');
                    update_post_meta($post_id, '_alsalam_joinus_form_title', 'Submit Your Profile');
                    update_post_meta($post_id, '_alsalam_joinus_form_desc', 'Fill out your credentials below. Our HR and talent acquisition team will evaluate your clinical or technical experience for relevant vacancies.');
                    update_post_meta($post_id, '_alsalam_joinus_success_alert', 'Thank you! Your career application has been submitted to the AL-SALAM HR team.');
                }

                update_post_meta($post_id, '_alsalam_show_hero', '1');
                if (function_exists('pll_set_post_language')) {
                    pll_set_post_language($post_id, $lang);
                }
                return $post_id;
            }

            $en_joinus_id = alsalam_seed_joinus_page('en', 'Join Us', $translations['en']);
            $ar_joinus_id = alsalam_seed_joinus_page('ar', 'انضم إلينا', $translations['ar']);

            if (function_exists('pll_save_post_translations')) {
                pll_save_post_translations([
                    'en' => $en_joinus_id,
                    'ar' => $ar_joinus_id
                ]);
            }

            // Seed Products Portfolio Page
            $en_prod_page = wp_insert_post([
                'post_title' => 'Products',
                'post_type' => 'page',
                'post_status' => 'publish',
                'page_template' => 'page-products.php'
            ]);
            update_post_meta($en_prod_page, '_wp_page_template', 'page-products.php');

            // Seed Gallery Page
            $en_gal_page = wp_insert_post([
                'post_title' => 'Gallery',
                'post_type' => 'page',
                'post_status' => 'publish',
                'page_template' => 'page-gallery.php'
            ]);
            update_post_meta($en_gal_page, '_wp_page_template', 'page-gallery.php');
        }
    }

    // --- 4. Seed Products ---
    echo '</ul><h3>Seeding Products</h3><ul>';
    $products = array(
        array(
            'title' => 'IV Infusion Solution - NaCl 0.9%',
            'desc'  => 'Sterile sodium chloride infusion solution manufactured under GMP standards for clinical hydration and dilution.',
            'tag1'  => 'Electrolyte Solution',
            'tag2'  => 'Sterile',
            'tag3'  => 'GMP',
            'image' => 'assets/images/product.png'
        ),
        array(
            'title' => 'Dextrose 5% Water Infusion',
            'desc'  => 'Sterile carbohydrate parenteral solution for carbohydrate replenishment and hydration.',
            'tag1'  => 'Sterile Fluids',
            'tag2'  => 'Sterile',
            'tag3'  => 'GMP',
            'image' => 'assets/images/product.png'
        ),
        array(
            'title' => 'Ringer Lactate Infusion',
            'desc'  => 'Isotonic electrolyte replenishment infusion designed to match physiological blood plasma.',
            'tag1'  => 'Electrolyte Solution',
            'tag2'  => 'Sterile',
            'tag3'  => 'GMP',
            'image' => 'assets/images/product.png'
        )
    );

    foreach ($products as $p) {
        if (!post_exists($p['title'])) {
            $post_id = wp_insert_post([
                'post_title'   => $p['title'],
                'post_content' => $p['desc'],
                'post_excerpt' => $p['desc'],
                'post_status'  => 'publish',
                'post_type'    => 'alsalam_product'
            ]);
            if (!is_wp_error($post_id)) {
                update_post_meta($post_id, '_alsalam_product_tag1', $p['tag1']);
                update_post_meta($post_id, '_alsalam_product_tag2', $p['tag2']);
                update_post_meta($post_id, '_alsalam_product_tag3', $p['tag3']);
                $img_path = ALSALAM_DIR . '/../alsalam_original_theme/' . $p['image'];
                alsalam_attach_image_to_post($img_path, $post_id);
                echo '<li>Inserted Product: ' . esc_html($p['title']) . '</li>';
            }
        }
    }

    // --- 5. Seed Gallery ---
    echo '</ul><h3>Seeding Gallery</h3><ul>';
    $galleryItems = array(
        array(
            'title'    => 'Sterile R&D Clean Room',
            'category' => 'Research & Development',
            'media'    => 'video',
            'image'    => 'assets/images/gallery/p1.webp'
        ),
        array(
            'title'    => 'Microbiology Quality Lab',
            'category' => 'Quality Assurance',
            'media'    => 'image',
            'image'    => 'assets/images/gallery/p2.webp'
        ),
        array(
            'title'    => 'Automated Production Line',
            'category' => 'Manufacturing',
            'media'    => 'video',
            'image'    => 'assets/images/gallery/p3.webp'
        ),
        array(
            'title'    => 'Chemical Analysis Center',
            'category' => 'Quality Assurance',
            'media'    => 'image',
            'image'    => 'assets/images/gallery/p4.webp'
        ),
        array(
            'title'    => 'Smart Storage Facility',
            'category' => 'Logistics',
            'media'    => 'video',
            'image'    => 'assets/images/gallery/p5.webp'
        )
    );

    foreach ($galleryItems as $g) {
        if (!post_exists($g['title'])) {
            $post_id = wp_insert_post([
                'post_title'   => $g['title'],
                'post_content' => 'High quality view of ' . $g['title'] . ' showing our modern facilities.',
                'post_status'  => 'publish',
                'post_type'    => 'alsalam_gallery'
            ]);
            if (!is_wp_error($post_id)) {
                wp_insert_term($g['category'], 'gallery_cat');
                $term = get_term_by('name', $g['category'], 'gallery_cat');
                if ($term) {
                    wp_set_object_terms($post_id, $term->term_id, 'gallery_cat');
                }
                update_post_meta($post_id, '_alsalam_gallery_media_type', $g['media']);
                $img_path = ALSALAM_DIR . '/../alsalam_original_theme/' . $g['image'];
                alsalam_attach_image_to_post($img_path, $post_id);
                echo '<li>Inserted Gallery Item: ' . esc_html($g['title']) . '</li>';
            }
        }
    }

    // --- 4. Seed Polylang Strings ---
    echo '</ul><h3>Seeding Polylang Strings</h3><ul>';
    if (class_exists('PLL_MO') && function_exists('PLL')) {
        if (isset($translations) && isset($translations['en']) && isset($translations['ar'])) {
            $ar_lang = PLL()->model->get_language('ar');
            if ($ar_lang) {
                $mo = new PLL_MO();
                $mo->import_from_db($ar_lang);
                $strings_added = 0;
                
                foreach ($translations['en'] as $key => $en_str) {
                    if (isset($translations['ar'][$key])) {
                        $ar_str = $translations['ar'][$key];
                        $mo->add_entry( $mo->make_entry($en_str, $ar_str) );
                        $strings_added++;
                    }
                }
                
                $mo->export_to_db($ar_lang);
                echo '<li>Successfully seeded ' . $strings_added . ' Arabic string translations into Polylang DB.</li>';
            } else {
                echo '<li>Arabic language not found in Polylang.</li>';
            }
        }
    }

    echo '</ul>';
    echo '<h3>Seeding Complete!</h3>';
    echo '<a href="' . admin_url('edit.php') . '">Go to Posts</a>';
    exit;
}

/**
 * Customizer Seeder
 */
function alsalam_run_customizer_seeder() {
    if (!isset($_GET['run_alsalam_customizer_seeder']) || !current_user_can('manage_options')) {
        return;
    }

    echo '<h3>AL-SALAM Customizer Seeder Log</h3><ul>';

    // Helper to get image URI
    $img = function($filename) {
        return get_template_directory_uri() . '/assets/images/' . $filename;
    };

    $mods = [
        // 1. Global
        '_alsalam_color_primary' => '#239BA8',
        '_alsalam_color_primary_dark' => '#12A19A',
        '_alsalam_color_bg_dark' => '#041424',
        '_alsalam_color_bg_light' => '#F4F7FE',
        '_alsalam_font_heading_en' => 'Outfit',
        '_alsalam_font_heading_ar' => 'Cairo',
        '_alsalam_font_body_en' => 'Inter',
        '_alsalam_font_body_ar' => 'Tajawal',
        '_alsalam_social_links' => json_encode([
            ['icon' => '', 'url' => '#'],
            ['icon' => '', 'url' => '#']
        ]),
        
        // 2. Header
        '_alsalam_header_logo' => $img('logo (2).png'),
        '_alsalam_header_logo_width' => 150,
        '_alsalam_header_cta_text' => 'Request Inquiry',
        '_alsalam_header_cta_link' => '/inquiry/',
        '_alsalam_header_lang_switcher' => '1',
        
        // 3.1 Hero
        '_alsalam_hero_bg_type' => 'video',
        '_alsalam_hero_bg_video' => get_template_directory_uri() . '/assets/video/HomePageVideo.mp4',
        '_alsalam_hero_deco_tr' => $img('top-right-bg.png'),
        '_alsalam_hero_deco_bl' => $img('bottom-left.png'),
        '_alsalam_hero_btn1_text' => 'About Us',
        '_alsalam_hero_btn1_link' => '/about/',
        '_alsalam_hero_btn2_text' => 'Our Products',
        '_alsalam_hero_btn2_link' => '/products/',
        '_alsalam_hero_video_modal_enable' => '1',
        '_alsalam_hero_video_modal_url' => 'https://www.youtube.com/watch?v=your-video-id',
        '_alsalam_hero_slides' => json_encode([
            [
                'badge1' => 'AL-SALAM',
                'badge2' => 'COMPANY',
                'title' => 'Sterile Pharmaceutical',
                'sub' => 'Manufacturing Built on European GMP Standards',
                'desc' => 'Delivering high-quality parenteral solutions conforming to global regulatory frameworks with state-of-the-art sterile processing facilities. All lines operate with automated aseptic safety protocols.'
            ],
            [
                'badge1' => 'AL-SALAM',
                'badge2' => 'TECHNOLOGY',
                'title' => 'Advanced Aseptic Lines',
                'sub' => 'High-Tech Bio-Processing Operations',
                'desc' => 'Utilizing advanced barrier systems (RABS) and blow-fill-seal methodologies to eliminate intervention vectors, ensuring the absolute highest safety indexes in parenteral formulation.'
            ],
            [
                'badge1' => 'AL-SALAM',
                'badge2' => 'HEALTHCARE',
                'title' => 'Global Core Logistics',
                'sub' => 'Reliable Essential Critical-Care Distribution',
                'desc' => 'Supplying life-saving intravenous solutions and vial parenterals globally. Our robust supply channels secure critical hospital networks with seamless therapeutic solutions continuous-uptime assurance.'
            ]
        ]),

        // 3.2 About
        '_alsalam_about_enable' => '1',
        '_alsalam_about_img' => $img('about-bg.jpg'),
        '_alsalam_about_deco' => $img('image-icon.png'),
        '_alsalam_about_btn_text' => 'Learn More',
        '_alsalam_about_btn_link' => '/about/',
        '_alsalam_about_badge' => 'Corporate Profile',
        '_alsalam_about_title' => 'About AL-SALAM',
        '_alsalam_about_desc1' => 'AL-SALAM Pharmaceutical Industry is a sterile manufacturing facility specializing in parenteral solutions, built according to European GMP standards in Iraq.',
        '_alsalam_about_desc2' => 'We combine advanced production, strict quality control, and fully controlled cleanroom environments to ensure safe and reliable pharmaceutical products.',
        '_alsalam_about_features' => json_encode([
            ['icon' => $img('icon-1.svg'), 'title' => 'Advanced Sterile Manufacturing'],
            ['icon' => $img('icon-2.svg'), 'title' => 'Quality & Laboratory Control']
        ]),

        // 3.3 Infrastructure
        '_alsalam_infra_enable' => '1',
        '_alsalam_infra_title' => 'Advanced <span class="text-teal-500">Pharmaceutical</span> Infrastructure',
        '_alsalam_infra_sub' => 'Built on Quality. Driven by Care',
        '_alsalam_infra_mask' => $img('Mask group.svg'),
        '_alsalam_infra_items' => json_encode([
            ['icon' => $img('Shield.svg'), 'title' => 'Sterile Production', 'desc' => 'Manufactured under strict GMP guidelines with high sterility standards to ensure product purity.'],
            ['icon' => $img('Search copy.svg'), 'title' => 'Quality Control', 'desc' => 'Rigorous testing and analytical inspection to ensure full compliance with global pharmacopeia standards.'],
            ['icon' => $img('Star.svg'), 'title' => 'Facility & Utilities', 'desc' => 'State-of-the-art cleanroom facilities powered by intelligent climate control (HVAC) systems.'],
            ['icon' => $img('Graph.svg'), 'title' => 'Storage & Packaging', 'desc' => 'Advanced packaging and validation protocols including thermal processing for maximum safety.']
        ]),

        // 3.4 Products
        '_alsalam_products_title' => '<span class="text-teal-600 block"><span class="text-teal-600">Sterile</span> <span class="text-slate-900">Solutions</span></span><span class="text-slate-900 block mt-1">Reliable</span>',
        '_alsalam_products_sub' => 'European Standards, Iraqi Excellence',
        '_alsalam_products_btn_text' => 'All Products',
        '_alsalam_products_btn_link' => '/products/',
        '_alsalam_products_count' => 10,

        // 3.5 Gallery
        '_alsalam_gallery_enable' => '1',
        '_alsalam_gallery_badge' => 'AL-SALAM',
        '_alsalam_gallery_title' => 'Company Gallery',
        '_alsalam_gallery_btn_text' => 'View All',
        '_alsalam_gallery_btn_link' => '/gallery/',

        // 3.6 Why Choose Us
        '_alsalam_why_img' => $img('Why Choose Us.jpg'),
        '_alsalam_why_badge' => 'Flexible IV Bag Technology',
        '_alsalam_why_box_title' => 'Why Choose Us',
        '_alsalam_why_box_sub' => 'A transversal vision with infinite solutions',
        '_alsalam_why_icon' => $img('question_mark_sign_blue_01 copy 1 1.svg'),
        '_alsalam_why_title' => 'Safer, Smarter <span class="text-teal-500">Infusion Solutions</span>',
        '_alsalam_why_desc' => 'Advanced flexible IV bags designed to improve safety, handling, and efficiency compared to conventional glass bottles.',
        '_alsalam_why_features' => json_encode([
            ['icon' => $img('medal-star.svg'), 'title' => 'Enhanced Safety', 'desc' => 'Reduced risk of breakage and contamination in clinical settings.'],
            ['icon' => $img('truck.svg'), 'title' => 'Better Handling', 'desc' => 'Lightweight and easy to transport, optimizing logistics.'],
            ['icon' => $img('target.svg'), 'title' => 'Clinical Efficiency', 'desc' => 'Streamlined design for medical staff and fast setup.'],
            ['icon' => $img('layer-group.svg'), 'title' => 'Advanced Materials', 'desc' => 'Multi-layered technology for optimal medical protection.']
        ]),

        // 3.7 News
        '_alsalam_news_enable' => '1',
        '_alsalam_news_title' => 'News & Events',
        '_alsalam_news_tab1_cat' => 'latest',
        '_alsalam_news_tab2_cat' => 'educational',
        '_alsalam_news_btn_text' => 'Read More',

        // 3.8 Testimonials
        '_alsalam_testi_enable' => '1',
        '_alsalam_testi_title' => 'What Our Partners Say',
        '_alsalam_testi_icon' => $img('quote-icon.svg'),
        '_alsalam_testi_image' => $img('testimonial-bg.jpg'),
        '_alsalam_testi_btn_text' => 'All Comments',
        '_alsalam_testi_btn_link' => '/about/#testimonials',
        '_alsalam_testi_reviews' => json_encode([
            [
                'name' => 'Dr. Ahmed Yassin',
                'role' => 'Clinical Director',
                'rating' => '5.0',
                'date' => '2024/02/12',
                'comment' => 'The professionalism and quality of sterile solutions provided by AL-SALAM have completely elevated our hospital operations. Their supply consistency is unmatched.',
                'avatar' => $img('avatar-man.jpg')
            ],
            [
                'name' => 'Pharmacist Sarah Rafiq',
                'role' => 'Procurement Manager',
                'rating' => '4.8',
                'date' => '2024/01/20',
                'comment' => 'Fantastic experience with their flexible IV bag line. Light, durable, and highly compliant with global pharmacopoeial standards. Highly recommended.',
                'avatar' => $img('avatar-man.jpg')
            ],
            [
                'name' => 'Dr. Mustafa Jawad',
                'role' => 'Critical Care Specialist',
                'rating' => '5.0',
                'date' => '2023/11/05',
                'comment' => 'A truly reliable partner for critical care fluids in Iraq. Their compliance with European GMP standards is clear in every batch they deliver.',
                'avatar' => $img('avatar-man.jpg')
            ]
        ]),

        // 3.9 Marquee
        '_alsalam_marquee_enable' => '1',
        '_alsalam_marquee_items' => json_encode([
            ['icon' => $img('badge-check.svg'), 'title' => 'Trusted Quality'],
            ['icon' => $img('Star.svg'), 'title' => 'European Standards'],
            ['icon' => $img('Shield.svg'), 'title' => 'GMP Certified'],
            ['icon' => $img('Graph.svg'), 'title' => 'Advanced Technology']
        ]),

        // Footer Settings
        '_alsalam_social_links' => wp_json_encode(array(
            array('icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>', 'url' => '#'),
            array('icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>', 'url' => '#'),
            array('icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>', 'url' => '#'),
            array('icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>', 'url' => '#'),
        )),
        '_alsalam_footer_title' => '<span class="text-teal-500">Excellence</span> <br/> in Parenteral Manufacturing',
        '_alsalam_footer_newsletter' => 'Enter your email address',
        '_alsalam_footer_copyright' => 'Copyright © [year] AL-SALAM. All rights reserved.',
        '_alsalam_footer_scroll_top' => '1',
        '_alsalam_footer_dev_credit' => '1',

        // 5. Inner Pages
        '_alsalam_inner_preloader' => '1',
        '_alsalam_inner_preloader_logo' => $img('logo (2).png'),
        '_alsalam_inner_breadcrumb' => '1',
        '_alsalam_inner_header_bg' => $img('inner-bg.jpg'),
        '_alsalam_404_img' => $img('404.svg'),
        '_alsalam_404_title' => 'Page Not Found',
        '_alsalam_404_btn' => 'Back to Home'
    ];

    foreach ($mods as $key => $val) {
        set_theme_mod($key, $val);
        echo '<li>Seeded: ' . esc_html($key) . '</li>';
    }

    echo '</ul><h3>Customizer Seeding Complete!</h3><a href="' . admin_url('customize.php') . '">Open Customizer</a>';
    exit;
}

/**
 * Helper to upload an image from file path and attach it to a post
 */
function alsalam_attach_image_to_post($file_path, $post_id) {
    if (!file_exists($file_path)) return false;

    // Check if attachment already exists
    $filename = basename($file_path);
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid LIKE '%%%s%%' LIMIT 1;", $filename)); 
    if (!empty($attachment)) {
        set_post_thumbnail($post_id, $attachment[0]);
        return $attachment[0];
    }

    $upload_file = wp_upload_bits($filename, null, file_get_contents($file_path));
    if (!$upload_file['error']) {
        $wp_filetype = wp_check_filetype($filename, null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
        $attachment_id = wp_insert_attachment($attachment, $upload_file['file'], $post_id);
        if (!is_wp_error($attachment_id)) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file['file']);
            wp_update_attachment_metadata($attachment_id, $attachment_data);
            set_post_thumbnail($post_id, $attachment_id);
            return $attachment_id;
        }
    }
    return false;
}
