<?php
/**
 * Database Seeder for AL-SALAM theme
 * Handles creating categories, posts, and linking translations via Polylang.
 */

defined('ABSPATH') || exit;

function alsalam_run_seeder() {
    if (!isset($_GET['run_alsalam_seeder']) || !current_user_can('manage_options')) {
        return;
    }

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
    echo '<a href="' . admin_url() . '">Return to Dashboard</a>';
    exit;
}
add_action('admin_init', 'alsalam_run_seeder');

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
