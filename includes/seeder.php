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

    // Rebuild all Arabic content and fix Polylang links
    if (isset($_GET['run_alsalam_rebuild_ar']) && $_GET['run_alsalam_rebuild_ar'] == '1' && current_user_can('manage_options')) {
        alsalam_rebuild_arabic_data();
        wp_die('Arabic rebuild completed successfully. Check the log above.');
    }

    // Setup blog/news pages for both languages
    if (isset($_GET['run_alsalam_setup_blog']) && $_GET['run_alsalam_setup_blog'] == '1' && current_user_can('manage_options')) {
        alsalam_setup_blog_pages();
        wp_die('Blog pages setup completed. Check the log above.');
    }
}
add_action('init', 'alsalam_run_seeder_action');

/**
 * SETUP BLOG / NEWS PAGES ROUTINE
 *
 * 1. Creates "News & Events" (EN) and "أخبار وفعاليات" (AR) pages.
 * 2. Assigns both to Polylang as a linked translation pair.
 * 3. Sets the EN page as the WordPress "Posts Page" (Reading Settings).
 * 4. Polylang automatically uses the AR page as the posts page for Arabic context.
 * 5. Registers and creates main-nav and footer menus for both languages if missing.
 * 6. Adds the News page to the main menu and to the footer "Quick Access" menu.
 *
 * Run via: /?run_alsalam_setup_blog=1  (must be logged in as admin)
 */
function alsalam_setup_blog_pages() {
    if (!function_exists('pll_set_post_language')) {
        echo '<p style="color:red">❌ Polylang is not active.</p>';
        return;
    }

    echo '<h2>🗞️ AL-SALAM Blog Pages Setup Log</h2>';

    // ─── STEP 1: Create or retrieve EN News Page ───────────────────────
    echo '<h3>Step 1: News Pages</h3><ul>';

    global $wpdb;
    $find_page = function($title_en, $title_ar) use ($wpdb) {
        return $wpdb->get_var($wpdb->prepare(
            "SELECT ID FROM $wpdb->posts WHERE post_title IN (%s, %s) AND post_type = 'page' AND post_status != 'trash' LIMIT 1",
            $title_en, $title_ar
        ));
    };

    // EN News Page
    $en_news_id = $find_page('News & Events', 'أخبار وفعاليات');
    if (!$en_news_id) {
        $en_news_id = wp_insert_post([
            'post_title'  => 'News & Events',
            'post_type'   => 'page',
            'post_status' => 'publish',
            'post_name'   => 'news',
        ]);
        echo '<li>✅ Created EN page: News &amp; Events (ID: ' . $en_news_id . ')</li>';
    } else {
        echo '<li>ℹ️ EN news page already exists (ID: ' . $en_news_id . ')</li>';
    }
    if ($en_news_id && !is_wp_error($en_news_id)) {
        pll_set_post_language($en_news_id, 'en');
        update_post_meta($en_news_id, '_alsalam_hero_title', 'News &amp; <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">Events</span>');
        update_post_meta($en_news_id, '_alsalam_hero_subtitle', 'Discover the latest developments in parenteral sterile manufacturing, clinical facility upgrades, and medical news.');
        update_post_meta($en_news_id, '_alsalam_show_hero', '1');
    }

    // AR News Page
    $ar_news_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type = 'page' AND post_status != 'trash' LIMIT 1",
        'أخبار وفعاليات'
    ));
    if (!$ar_news_id) {
        $ar_news_id = wp_insert_post([
            'post_title'  => 'أخبار وفعاليات',
            'post_type'   => 'page',
            'post_status' => 'publish',
            'post_name'   => 'akhbar',
        ]);
        echo '<li>✅ Created AR page: أخبار وفعاليات (ID: ' . $ar_news_id . ')</li>';
    } else {
        echo '<li>ℹ️ AR news page already exists (ID: ' . $ar_news_id . ')</li>';
    }
    if ($ar_news_id && !is_wp_error($ar_news_id)) {
        pll_set_post_language($ar_news_id, 'ar');
        update_post_meta($ar_news_id, '_alsalam_hero_title', 'أخبار <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-light to-teal-300">وفعاليات</span>');
        update_post_meta($ar_news_id, '_alsalam_hero_subtitle', 'اكتشف آخر المستجدات في مجال التصنيع الدوائي المعقم وترقيات المرافق السريرية والأخبار الطبية.');
        update_post_meta($ar_news_id, '_alsalam_show_hero', '1');
    }

    // Link EN ↔ AR via Polylang
    if ($en_news_id && $ar_news_id && !is_wp_error($en_news_id) && !is_wp_error($ar_news_id)) {
        pll_save_post_translations(['en' => $en_news_id, 'ar' => $ar_news_id]);
        echo '<li>🔗 Linked EN/AR news pages in Polylang.</li>';
    }
    echo '</ul>';

    // ─── STEP 2: Set EN page as WordPress "Posts Page" ─────────────────
    echo '<h3>Step 2: WordPress Reading Settings</h3><ul>';
    if ($en_news_id && !is_wp_error($en_news_id)) {
        // Ensure "Your homepage displays" is set to "A static page"
        if (get_option('show_on_front') !== 'page') {
            update_option('show_on_front', 'page');
        }
        // Set page_for_posts (Posts Page) to EN news page
        update_option('page_for_posts', $en_news_id);
        echo '<li>✅ Set "News &amp; Events" as WordPress Posts Page (page_for_posts = ' . $en_news_id . ')</li>';
        // Polylang automatically maps the translated page for the AR context
        echo '<li>ℹ️ Polylang will auto-use the AR page for /ar/akhbar/ context.</li>';
    }
    echo '</ul>';

    // ─── STEP 3: Register & populate menus for both languages ──────────
    echo '<h3>Step 3: Menu Setup</h3><ul>';

    // Menu names we expect
    $menus_needed = [
        'Main Menu EN'        => 'main-menu-en',
        'Main Menu AR'        => 'main-menu-ar',
        'Footer Quick EN'     => 'footer-quick-en',
        'Footer Quick AR'     => 'footer-quick-ar',
        'Footer Services EN'  => 'footer-services-en',
        'Footer Services AR'  => 'footer-services-ar',
        'Footer Resources EN' => 'footer-resources-en',
        'Footer Resources AR' => 'footer-resources-ar',
    ];

    foreach ($menus_needed as $name => $slug) {
        if (!wp_get_nav_menu_object($slug)) {
            $menu_id = wp_create_nav_menu($name);
            echo '<li>✅ Created menu: ' . esc_html($name) . ' (ID: ' . $menu_id . ')</li>';
        } else {
            echo '<li>ℹ️ Menu already exists: ' . esc_html($name) . '</li>';
        }
    }

    // Helper: add page to menu if not already present
    $add_page_to_menu = function($menu_slug, $page_id, $label) use ($wpdb) {
        $menu_obj = wp_get_nav_menu_object($menu_slug);
        if (!$menu_obj) return;
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $wpdb->postmeta pm
             JOIN $wpdb->posts p ON p.ID = pm.post_id
             WHERE pm.meta_key = '_menu_item_object_id' AND pm.meta_value = %s
             AND p.post_type = 'nav_menu_item' AND p.post_status = 'publish'",
            $page_id
        ));
        if (!$exists) {
            wp_update_nav_menu_item($menu_obj->term_id, 0, [
                'menu-item-type'      => 'post_type',
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $page_id,
                'menu-item-title'     => $label,
                'menu-item-status'    => 'publish',
            ]);
            echo '<li>🔗 Added "' . esc_html($label) . '" to menu: ' . esc_html($menu_slug) . '</li>';
        } else {
            echo '<li>ℹ️ "' . esc_html($label) . '" already in menu: ' . esc_html($menu_slug) . '</li>';
        }
    };

    // Add news pages to main menus
    if ($en_news_id) $add_page_to_menu('main-menu-en', $en_news_id, 'News & Events');
    if ($ar_news_id) $add_page_to_menu('main-menu-ar', $ar_news_id, 'أخبار وفعاليات');

    // Add news pages to footer Quick Access menus
    if ($en_news_id) $add_page_to_menu('footer-quick-en', $en_news_id, 'News & Events');
    if ($ar_news_id) $add_page_to_menu('footer-quick-ar', $ar_news_id, 'أخبار وفعاليات');

    echo '</ul>';

    // ─── STEP 4: Assign menus to Customizer theme_mod slots ───────────
    echo '<h3>Step 4: Theme Customizer Menu Assignments</h3><ul>';

    $menu_assignments = [
        '_alsalam_header_menu'           => 'main-menu-en',
        '_alsalam_header_menu_ar'        => 'main-menu-ar',
        '_alsalam_footer_quick_menu'     => 'footer-quick-en',
        '_alsalam_footer_quick_menu_ar'  => 'footer-quick-ar',
        '_alsalam_footer_services_menu'  => 'footer-services-en',
        '_alsalam_footer_services_menu_ar'=> 'footer-services-ar',
        '_alsalam_footer_resources_menu' => 'footer-resources-en',
        '_alsalam_footer_resources_menu_ar'=> 'footer-resources-ar',
    ];
    foreach ($menu_assignments as $mod_key => $menu_slug) {
        $menu_obj = wp_get_nav_menu_object($menu_slug);
        if ($menu_obj) {
            set_theme_mod($mod_key, $menu_obj->term_id);
            echo '<li>✅ Assigned menu <strong>' . esc_html($menu_slug) . '</strong> to theme_mod: <code>' . esc_html($mod_key) . '</code></li>';
        }
    }
    echo '</ul>';

    echo '<h2>✅ Blog pages setup complete!</h2>';
    echo '<p>Visit <strong>/news/</strong> (EN) and <strong>/ar/akhbar/</strong> (AR) to verify the blog pages.</p>';
    echo '<p><strong>Important:</strong> Go to <a href="' . admin_url('nav-menus.php') . '" target="_blank">Appearance → Menus</a> to manually add other pages (Home, About, Products, Gallery, Contact) to the Main Menus if not already present.</p>';
}


/**
 * REBUILD ARABIC DATA ROUTINE
 *
 * This function safely:
 * 1. Creates/fixes Arabic categories and links them to English counterparts via Polylang.
 * 2. For each English post (post, product, gallery), finds or creates the Arabic counterpart.
 * 3. Correctly assigns the AR post to the AR category (not the EN one).
 * 4. Links the EN-AR post pair via pll_save_post_translations().
 *
 * Run via: /?run_alsalam_rebuild_ar=1 (must be logged in as admin)
 */
function alsalam_rebuild_arabic_data() {
    if (!function_exists('pll_set_post_language')) {
        wp_die('Polylang is not active.');
    }

    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    if (!function_exists('alsalam_post_exists')) {
        function alsalam_post_exists($title) {
            global $wpdb;
            return $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_status != 'trash' LIMIT 1", $title));
        }
    }

    echo '<h2>🔧 AL-SALAM Arabic Rebuild Log</h2>';

    // ──────────────────────────────────────────────────
    // STEP 1: Ensure categories exist and are properly linked
    // ──────────────────────────────────────────────────
    echo '<h3>Step 1: Categories</h3><ul>';

    // EN educational category
    $en_cat = get_term_by('slug', 'educational-en', 'category');
    if (!$en_cat) {
        $result = wp_insert_term('Educational', 'category', ['slug' => 'educational-en']);
        $en_cat_id = is_wp_error($result) ? ($result->error_data['term_exists'] ?? 0) : $result['term_id'];
        echo '<li>✅ Created EN category: Educational (educational-en)</li>';
    } else {
        $en_cat_id = $en_cat->term_id;
        echo '<li>ℹ️ EN category already exists: educational-en (ID: ' . $en_cat_id . ')</li>';
    }
    if ($en_cat_id) pll_set_term_language($en_cat_id, 'en');

    // AR educational category
    $ar_cat = get_term_by('slug', 'educational-ar', 'category');
    if (!$ar_cat) {
        $result = wp_insert_term('تعليمي', 'category', ['slug' => 'educational-ar']);
        $ar_cat_id = is_wp_error($result) ? ($result->error_data['term_exists'] ?? 0) : $result['term_id'];
        echo '<li>✅ Created AR category: تعليمي (educational-ar)</li>';
    } else {
        $ar_cat_id = $ar_cat->term_id;
        echo '<li>ℹ️ AR category already exists: educational-ar (ID: ' . $ar_cat_id . ')</li>';
    }
    if ($ar_cat_id) pll_set_term_language($ar_cat_id, 'ar');

    // Link EN-AR category pair in Polylang
    if ($en_cat_id && $ar_cat_id) {
        pll_save_term_translations(['en' => $en_cat_id, 'ar' => $ar_cat_id]);
        echo '<li>🔗 Linked EN/AR educational categories in Polylang.</li>';
    }
    echo '</ul>';

    // ──────────────────────────────────────────────────
    // STEP 2: Rebuild Arabic News Posts
    // ──────────────────────────────────────────────────
    echo '<h3>Step 2: News Posts (post)</h3><ul>';

    // Paired data: EN title => AR data
    $news_pairs = [
        'The Name Of Article 1'  => ['title' => 'اسم المقالة ١',            'desc' => 'نص لوريم إيبسوم عربي للتجربة. هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.', 'cat' => 'latest'],
        'The Name Of Article 2'  => ['title' => 'اسم المقالة ٢',            'desc' => 'نص لوريم إيبسوم عربي للتجربة. هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.', 'cat' => 'latest'],
        'The Name Of Article 3'  => ['title' => 'اسم المقالة ٣',            'desc' => 'نص لوريم إيبسوم عربي للتجربة. هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.', 'cat' => 'latest'],
        'The Name Of Article 4'  => ['title' => 'اسم المقالة التعليمية ٤', 'desc' => 'نص لوريم إيبسوم عربي للتجربة. هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.', 'cat' => 'educational'],
        'The Name Of Article 5'  => ['title' => 'اسم المقالة التعليمية ٥', 'desc' => 'نص لوريم إيبسوم عربي للتجربة. هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.', 'cat' => 'educational'],
        'The Name Of Article 6'  => ['title' => 'اسم المقالة التعليمية ٦', 'desc' => 'نص لوريم إيبسوم عربي للتجربة. هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة.', 'cat' => 'educational'],
    ];

    $img_base = ALSALAM_DIR . '/../alsalam_original_theme/assets/images/';
    $news_images = ['news1.jpg', 'news2.jpg', 'news3.jpg', 'news1.jpg', 'news2.jpg', 'news3.jpg'];
    $news_keys   = array_keys($news_pairs);

    foreach ($news_keys as $idx => $en_title) {
        $ar_data = $news_pairs[$en_title];

        // Find EN post
        $en_post_id = alsalam_post_exists($en_title);
        if (!$en_post_id) {
            // Create it too so we have a pair
            $en_post_id = wp_insert_post([
                'post_title'   => wp_strip_all_tags($en_title),
                'post_content' => '',
                'post_excerpt' => '',
                'post_status'  => 'publish',
                'post_type'    => 'post',
            ]);
            echo '<li>✅ Created missing EN post: ' . esc_html($en_title) . '</li>';
        }
        if (is_wp_error($en_post_id) || !$en_post_id) {
            echo '<li>❌ Could not find or create EN post: ' . esc_html($en_title) . '</li>';
            continue;
        }

        // Set EN post language and category
        pll_set_post_language($en_post_id, 'en');
        if ($ar_data['cat'] === 'educational' && $en_cat_id) {
            wp_set_post_categories($en_post_id, [$en_cat_id]);
        }

        // Find or create AR post
        $ar_title = $ar_data['title'];
        $ar_post_id = alsalam_post_exists($ar_title);
        if (!$ar_post_id) {
            $ar_post_id = wp_insert_post([
                'post_title'   => wp_strip_all_tags($ar_title),
                'post_content' => wp_kses_post($ar_data['desc']) . "\n\n<!-- محتوى كامل هنا -->",
                'post_excerpt' => wp_strip_all_tags($ar_data['desc']),
                'post_status'  => 'publish',
                'post_type'    => 'post',
            ]);
            echo '<li>✅ Created AR post: ' . esc_html($ar_title) . '</li>';
        } else {
            echo '<li>ℹ️ AR post already exists: ' . esc_html($ar_title) . ' (ID: ' . $ar_post_id . ')</li>';
        }

        if (is_wp_error($ar_post_id) || !$ar_post_id) {
            echo '<li>❌ Could not create AR post: ' . esc_html($ar_title) . '</li>';
            continue;
        }

        // Set AR post language
        pll_set_post_language($ar_post_id, 'ar');

        // Set AR post to AR category (NOT the EN category)
        if ($ar_data['cat'] === 'educational' && $ar_cat_id) {
            wp_set_post_categories($ar_post_id, [$ar_cat_id]);
            echo '<li>📂 Assigned AR category (تعليمي) to: ' . esc_html($ar_title) . '</li>';
        }

        // Attach featured image
        $img_file = $img_base . $news_images[$idx];
        alsalam_attach_image_to_post($img_file, $ar_post_id);

        // Link EN <=> AR in Polylang
        pll_save_post_translations(['en' => $en_post_id, 'ar' => $ar_post_id]);
        echo '<li>🔗 Linked: ' . esc_html($en_title) . ' &laquo;=&raquo; ' . esc_html($ar_title) . '</li>';
    }
    echo '</ul>';

    // ──────────────────────────────────────────────────
    // STEP 3: Rebuild Arabic Products
    // ──────────────────────────────────────────────────
    echo '<h3>Step 3: Products (alsalam_product)</h3><ul>';

    $product_pairs = [
        'Sodium Chloride 0.9%'            => ['title' => 'محلول صوديوم كلورايد 0.9%',      'desc' => 'محلول كهرلي معقم متساوي التوتر لإعادة التروية، الترطيب وتخفيف الأدوية الوريدية.', 'tag1' => 'عبوة BFS معقمة', 'tag2' => '٥٠٠ مل', 'tag3' => 'معتمد بموجب GMP'],
        'Glucose 5% Infusion'             => ['title' => 'محلول جلوكوز 5% للحقن الوريدي', 'desc' => 'محلول كربوهيدراتي معقم لتعويض السعرات الحرارية والحفاظ على السوائل.',            'tag1' => 'كيس BFS معقم',    'tag2' => '٥٠٠ مل', 'tag3' => 'معيار USP'],
        "Ringer's Lactate Solution"       => ['title' => 'محلول رينجر لاكتات',             'desc' => 'محلول كهرلي متوازن مصمم ليمتثل للبلازما الفسيولوجية في حالات الجراحة والصدمات.',     'tag1' => 'غرفة نظيفة فئة A','tag2' => '٥٠٠ مل', 'tag3' => 'GMP أوروبي'],
        "Darrow's Solution"               => ['title' => 'محلول داروو المعقم',             'desc' => 'حقن كلوريد البوتاسيوم والصوديوم المعقم لتصحيح خلل الكهارل الشديد.',                 'tag1' => 'محلول كهرلي',      'tag2' => '٥٠٠ مل', 'tag3' => 'معتمد بموجب GMP'],
        'Metronidazole 500mg Solution'    => ['title' => 'محلول مترونيدازول 500 مجم',      'desc' => 'محلول مضاد لميكروبات الحقن المعقم للرعاية المستشفى الحرجة.',                       'tag1' => 'عبوة BFS',          'tag2' => '١٠٠ مل', 'tag3' => 'مادة فعالة معقمة'],
        'Mannitol 20% Infusion'           => ['title' => 'محلول مانيتول 20%',              'desc' => 'محلول مدر للبول التناضحي المعقم لتقليل الضغط داخل الجمجمة.',                      'tag1' => 'مدر تناضحي',      'tag2' => '٥٠٠ مل', 'tag3' => 'معتمد بموجب GMP'],
        'Paracetamol IV Infusion'         => ['title' => 'محلول باراسيتامول وريدي',        'desc' => 'محلول مسكن ومخفض للحرارة معقم للعلاج قصير الأمد للألم المتوسط والحمى.',           'tag1' => 'محلول مسكن',       'tag2' => '١٠٠ مل', 'tag3' => 'معايير أوروبية'],
        'Sodium Bicarbonate 8.4% Infusion'=> ['title' => 'بيكربونات الصوديوم 8.4%',       'desc' => 'محلول معقم مرتفع التوتر لتصحيح الحماض الاستقلابي.',                               'tag1' => 'منظم قلوية',       'tag2' => '٢٥٠ مل', 'tag3' => 'معيار USP'],
        'Potassium Chloride 10% Injection'=> ['title' => 'كلوريد البوتاسيوم 10% للحقن',   'desc' => 'محلول بوتاسيوم مركز معقم لعلاج نقص بوتاسيوم الدم الحاد.',                        'tag1' => 'كهرلي مركز',       'tag2' => '١٠٠ مل', 'tag3' => 'معتمد بموجب GMP'],
        'Sterile Water for Injection'     => ['title' => 'ماء معقم للحقن',                 'desc' => 'ماء معقم فائق النقاء لإذابة وتخفيف الأدوية الوريدية داخل الغرف النظيفة.',          'tag1' => 'مذيب نقاء',        'tag2' => '٥٠٠ مل', 'tag3' => 'تعقيم فئة A'],
        'Ciprofloxacin IV Infusion 200mg' => ['title' => 'سيبروفلوكساسين وريدي 200 مجم',  'desc' => 'محلول مضاد حيوي معقم واسع المجال للحقن الوريدي.',                                 'tag1' => 'محلول مضاد بكتيري','tag2' => '١٠٠ مل', 'tag3' => 'معتمد بموجب GMP'],
        'Calcium Gluconate 10% Injection' => ['title' => 'جلوكونات الكالسيوم 10%',         'desc' => 'محلول معقم لحماية القلب وعلاج نقص كالسيوم الدم الحاد في وحدات العناية المركزة.',  'tag1' => 'سائل حماية القلب', 'tag2' => '١٠٠ مل', 'tag3' => 'معيار USP'],
    ];

    $prod_img = ALSALAM_DIR . '/../alsalam_original_theme/assets/images/product.png';

    foreach ($product_pairs as $en_title => $ar_data) {
        // Find EN product
        $en_id = alsalam_post_exists($en_title);
        if (!$en_id) {
            $en_id = wp_insert_post([
                'post_title'   => $en_title,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'alsalam_product',
            ]);
            echo '<li>✅ Created missing EN product: ' . esc_html($en_title) . '</li>';
        }
        if (is_wp_error($en_id) || !$en_id) {
            echo '<li>❌ Cannot find/create EN product: ' . esc_html($en_title) . '</li>';
            continue;
        }
        pll_set_post_language($en_id, 'en');

        // Find or create AR product
        $ar_title   = $ar_data['title'];
        $ar_prod_id = alsalam_post_exists($ar_title);
        if (!$ar_prod_id) {
            $ar_prod_id = wp_insert_post([
                'post_title'   => $ar_title,
                'post_content' => $ar_data['desc'],
                'post_excerpt' => $ar_data['desc'],
                'post_status'  => 'publish',
                'post_type'    => 'alsalam_product',
            ]);
            echo '<li>✅ Created AR product: ' . esc_html($ar_title) . '</li>';
        } else {
            echo '<li>ℹ️ AR product already exists: ' . esc_html($ar_title) . '</li>';
        }

        if (is_wp_error($ar_prod_id) || !$ar_prod_id) {
            echo '<li>❌ Could not create AR product: ' . esc_html($ar_title) . '</li>';
            continue;
        }

        pll_set_post_language($ar_prod_id, 'ar');
        update_post_meta($ar_prod_id, '_alsalam_product_tag1', $ar_data['tag1']);
        update_post_meta($ar_prod_id, '_alsalam_product_tag2', $ar_data['tag2']);
        update_post_meta($ar_prod_id, '_alsalam_product_tag3', $ar_data['tag3']);
        alsalam_attach_image_to_post($prod_img, $ar_prod_id);

        pll_save_post_translations(['en' => $en_id, 'ar' => $ar_prod_id]);
        echo '<li>🔗 Linked product: ' . esc_html($en_title) . ' &laquo;=&raquo; ' . esc_html($ar_title) . '</li>';
    }
    echo '</ul>';

    // ──────────────────────────────────────────────────
    // STEP 4: Rebuild Arabic Gallery Items
    // ──────────────────────────────────────────────────
    echo '<h3>Step 4: Gallery (alsalam_gallery)</h3><ul>';

    $gallery_pairs = [
        'Sterile R&D Clean Room'             => ['title' => 'غرفة الأبحاث والتطوير المعقمة',       'cat' => 'البحث والتطوير',     'loc' => 'منشأة بغداد',             'media' => 'video', 'image' => 'gallery/p1.webp'],
        'Microbiology Quality Lab'           => ['title' => 'مختبر ضبط الجودة الأحيائية',         'cat' => 'جودة التصنيع',       'loc' => 'جناح رقابة الجودة',       'media' => 'image', 'image' => 'gallery/p2.webp'],
        'Automated BFS Production Line'      => ['title' => 'خط إنتاج BFS المعقم الآلي',          'cat' => 'خطوط الإنتاج',       'loc' => 'الغرفة النظيفة الرئيسية A','media' => 'video', 'image' => 'gallery/p3.webp'],
        'Chemical Analysis Center'           => ['title' => 'مركز التحليل الكيميائي والدوائي',    'cat' => 'جودة التصنيع',       'loc' => 'المختبر التحليلي المركزي', 'media' => 'image', 'image' => 'gallery/p4.webp'],
        'Smart Automated Storage Facility'   => ['title' => 'مستودع التخزين الذكي المعقم',        'cat' => 'اللوجستيات',         'loc' => 'المخزن المركزي',           'media' => 'video', 'image' => 'gallery/p5.webp'],
    ];

    $gal_img_base = ALSALAM_DIR . '/../alsalam_original_theme/assets/images/';

    foreach ($gallery_pairs as $en_title => $ar_data) {
        $en_gal_id = alsalam_post_exists($en_title);
        if (!$en_gal_id) {
            $en_gal_id = wp_insert_post([
                'post_title'  => $en_title,
                'post_status' => 'publish',
                'post_type'   => 'alsalam_gallery',
            ]);
            echo '<li>✅ Created missing EN gallery: ' . esc_html($en_title) . '</li>';
        }
        if (is_wp_error($en_gal_id) || !$en_gal_id) {
            echo '<li>❌ Cannot find/create EN gallery: ' . esc_html($en_title) . '</li>';
            continue;
        }
        pll_set_post_language($en_gal_id, 'en');

        // AR gallery item
        $ar_title = $ar_data['title'];
        $ar_gal_id = alsalam_post_exists($ar_title);
        if (!$ar_gal_id) {
            $ar_gal_id = wp_insert_post([
                'post_title'   => $ar_title,
                'post_content' => 'عرض عالي الجودة لمنشأة ' . $ar_title . ' المصممة وفقاً لمعايير GMP الأوروبية.',
                'post_status'  => 'publish',
                'post_type'    => 'alsalam_gallery',
            ]);
            echo '<li>✅ Created AR gallery: ' . esc_html($ar_title) . '</li>';
        } else {
            echo '<li>ℹ️ AR gallery already exists: ' . esc_html($ar_title) . '</li>';
        }

        if (is_wp_error($ar_gal_id) || !$ar_gal_id) {
            echo '<li>❌ Could not create AR gallery: ' . esc_html($ar_title) . '</li>';
            continue;
        }

        pll_set_post_language($ar_gal_id, 'ar');

        // Set AR gallery taxonomy term (gallery_cat)
        $ar_term = wp_insert_term($ar_data['cat'], 'gallery_cat');
        $ar_term_id = is_wp_error($ar_term) ? ($ar_term->error_data['term_exists'] ?? 0) : $ar_term['term_id'];
        if ($ar_term_id) {
            wp_set_object_terms($ar_gal_id, $ar_term_id, 'gallery_cat');
        }

        update_post_meta($ar_gal_id, '_alsalam_gallery_media_type', $ar_data['media']);
        update_post_meta($ar_gal_id, '_alsalam_gallery_location', $ar_data['loc']);
        alsalam_attach_image_to_post($gal_img_base . $ar_data['image'], $ar_gal_id);

        pll_save_post_translations(['en' => $en_gal_id, 'ar' => $ar_gal_id]);
        echo '<li>🔗 Linked gallery: ' . esc_html($en_title) . ' &laquo;=&raquo; ' . esc_html($ar_title) . '</li>';
    }
    echo '</ul>';

    echo '<h2>✅ Arabic Data Rebuild Complete!</h2>';
    echo '<p>Now visit <strong>your-site.com/ar/</strong> and confirm posts appear in the News, Products, and Gallery sections.</p>';
}

function alsalam_run_seeder() {
    $is_polylang_active = function_exists('pll_set_post_language');

    if (!$is_polylang_active) {
        wp_die('Polylang is not active. Please install and activate Polylang, and configure EN and AR languages before running the seeder.');
    }

    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    
    if (!function_exists('alsalam_post_exists')) {
        function alsalam_post_exists($title) {
            global $wpdb;
            return $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_status != 'trash' LIMIT 1", $title));
        }
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
        $en_post_id = alsalam_post_exists($en_item['title']);
        if (!$en_post_id) {
            $en_post_data = array(
                'post_title'   => wp_strip_all_tags($en_item['title']),
                'post_content' => wp_kses_post($en_item['desc']) . "\n\n<!-- Insert full content here -->",
                'post_excerpt' => wp_strip_all_tags($en_item['desc']),
                'post_status'  => 'publish',
                'post_type'    => 'post',
                'post_date'    => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $en_item['date'])))
            );
            $en_post_id = wp_insert_post($en_post_data);
        }

        if (is_wp_error($en_post_id) || !$en_post_id) {
            echo '<li>Error creating/retrieving EN post: ' . esc_html($en_item['title']) . '</li>';
            continue;
        }

        if (function_exists('pll_set_post_language')) {
            pll_set_post_language($en_post_id, 'en');
        }

        if ($en_item['category'] === 'educational' && $en_cat_term_id) {
            wp_set_post_categories($en_post_id, array($en_cat_term_id));
        }

        $img_path = ALSALAM_DIR . '/../alsalam_original_theme/' . $en_item['image'];
        alsalam_attach_image_to_post($img_path, $en_post_id);

        // --- Create AR Post ---
        $ar_post_id = alsalam_post_exists($ar_item['title']);
        if (!$ar_post_id) {
            $ar_post_data = array(
                'post_title'   => wp_strip_all_tags($ar_item['title']),
                'post_content' => wp_kses_post($ar_item['desc']) . "\n\n<!-- Insert full content here -->",
                'post_excerpt' => wp_strip_all_tags($ar_item['desc']),
                'post_status'  => 'publish',
                'post_type'    => 'post',
                'post_date'    => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $ar_item['date'])))
            );
            $ar_post_id = wp_insert_post($ar_post_data);
        }

        if (!is_wp_error($ar_post_id) && $ar_post_id) {
            if (function_exists('pll_set_post_language')) {
                pll_set_post_language($ar_post_id, 'ar');
            }
            if ($ar_item['category'] === 'educational' && $ar_cat_term_id) {
                wp_set_post_categories($ar_post_id, array($ar_cat_term_id));
            }
            alsalam_attach_image_to_post($img_path, $ar_post_id);

            // Link translations
            if (function_exists('pll_save_post_translations')) {
                pll_save_post_translations(array(
                    'en' => $en_post_id,
                    'ar' => $ar_post_id
                ));
            }
            
            echo '<li>Successfully created & linked EN and AR posts for: ' . esc_html($en_item['title']) . '</li>';
        }
    }

    // --- 3. Seed About Pages ---
    echo '</ul><h3>Seeding Pages</h3><ul>';
    $translations_path = ALSALAM_DIR . '/includes/translations-data.php';
    if (file_exists($translations_path)) {
        $translations = require $translations_path;
        
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

    // --- 4. Seed Products (Bilingual EN & AR) ---
    echo '</ul><h3>Seeding Products (Bilingual EN & AR)</h3><ul>';
    $products = array(
        array(
            'en' => array(
                'title' => 'Sodium Chloride 0.9%',
                'desc'  => 'Isotonic parenteral electrolyte solution for fluid resuscitation, hydration, and drug dilution.',
                'tag1'  => 'BFS Sterile Bottle', 'tag2' => '500ml', 'tag3' => 'GMP Certified'
            ),
            'ar' => array(
                'title' => 'محلول صوديوم كلورايد 0.9%',
                'desc'  => 'محلول كهرلي معقم متساوي التوتر لإعادة التروية، الترطيب وتخفيف الأدوية الوريدية.',
                'tag1'  => 'عبوة BFS معقمة', 'tag2' => '٥٠٠ مل', 'tag3' => 'معتمد بموجب GMP'
            ),
            'image' => 'assets/images/product.png'
        ),
        array(
            'en' => array(
                'title' => 'Glucose 5% Infusion',
                'desc'  => 'Sterile parenteral carbohydrate solution for caloric replenishment and fluid maintenance.',
                'tag1'  => 'Aseptic BFS Pack', 'tag2' => '500ml', 'tag3' => 'USP Standard'
            ),
            'ar' => array(
                'title' => 'محلول جلوكوز 5% للحقن الوريدي',
                'desc'  => 'محلول كربوهيدراتي معقم لتعويض السعرات الحرارية والحفاظ على السوائل.',
                'tag1'  => 'كيس BFS معقم', 'tag2' => '٥٠٠ مل', 'tag3' => 'معيار USP'
            ),
            'image' => 'assets/images/product.png'
        ),
        array(
            'en' => array(
                'title' => "Ringer's Lactate Solution",
                'desc'  => 'Balanced electrolyte replacement infusion designed to match physiological blood plasma in surgery and trauma.',
                'tag1'  => 'Class A Cleanroom', 'tag2' => '500ml', 'tag3' => 'European GMP'
            ),
            'ar' => array(
                'title' => 'محلول رينجر لاكتات',
                'desc'  => 'محلول كهرلي متوازن مصمم ليمتثل للبلازما الفسيولوجية في حالات الجراحة والصدمات.',
                'tag1'  => 'غرفة نظيفة فئة A', 'tag2' => '٥٠٠ مل', 'tag3' => 'GMP أوروبي'
            ),
            'image' => 'assets/images/product.png'
        ),
        array(
            'en' => array(
                'title' => "Darrow's Solution",
                'desc'  => 'Sterile potassium and sodium chloride injection for correcting severe electrolyte imbalance and pediatric dehydration.',
                'tag1'  => 'Electrolyte Solution', 'tag2' => '500ml', 'tag3' => 'GMP Certified'
            ),
            'ar' => array(
                'title' => 'محلول داروو المعقم',
                'desc'  => 'حقن كلوريد البوتاسيوم والصوديوم المعقم لتصحيح خلل الكهارل الشديد والجفاف عند الأطفال.',
                'tag1'  => 'محلول كهرلي', 'tag2' => '٥٠٠ مل', 'tag3' => 'معتمد بموجب GMP'
            ),
            'image' => 'assets/images/product.png'
        ),
        array(
            'en' => array(
                'title' => 'Metronidazole 500mg Solution',
                'desc'  => 'Sterile antimicrobial infusion for critical hospital care and anaerobic bacterial infections.',
                'tag1'  => 'BFS Container', 'tag2' => '100ml', 'tag3' => 'Sterile API'
            ),
            'ar' => array(
                'title' => 'محلول مترونيدازول 500 مجم',
                'desc'  => 'محلول مضاد لميكروبات الحقن المعقم للرعاية المستشفى الحرجة والعدوى البكتيرية اللاهوائية.',
                'tag1'  => 'عبوة BFS', 'tag2' => '١٠٠ مل', 'tag3' => 'مادة فعالة معقمة'
            ),
            'image' => 'assets/images/product.png'
        ),
        array(
            'en' => array(
                'title' => 'Mannitol 20% Infusion',
                'desc'  => 'Sterile hypertonic osmotic diuretic solution for reduction of intracranial pressure and cerebral edema.',
                'tag1'  => 'Osmotic Diuretic', 'tag2' => '500ml', 'tag3' => 'GMP Certified'
            ),
            'ar' => array(
                'title' => 'محلول مانيتول 20%',
                'desc'  => 'محلول مدر للبول التناضحي المعقم لتقليل الضغط داخل الجمجمة والوذمة الدماغية.',
                'tag1'  => 'مدر تناضحي', 'tag2' => '٥٠٠ مل', 'tag3' => 'معتمد بموجب GMP'
            ),
            'image' => 'assets/images/product.png'
        ),
        array(
            'en' => array(
                'title' => 'Paracetamol IV Infusion',
                'desc'  => 'Sterile analgesic and antipyretic solution for short-term treatment of moderate pain and fever.',
                'tag1'  => 'Analgesic Solution', 'tag2' => '100ml', 'tag3' => 'EU Standards'
            ),
            'ar' => array(
                'title' => 'محلول باراسيتامول وريدي',
                'desc'  => 'محلول مسكن ومخفض للحرارة معقم للعلاج قصير الأمد للألم المتوسط والحمى.',
                'tag1'  => 'محلول مسكن', 'tag2' => '١٠٠ مل', 'tag3' => 'معايير أوروبية'
            ),
            'image' => 'assets/images/product.png'
        ),
        array(
            'en' => array(
                'title' => 'Sodium Bicarbonate 8.4% Infusion',
                'desc'  => 'Sterile hypertonic solution for correction of metabolic acidosis and systemic alkalization in emergency care.',
                'tag1'  => 'Systemic Alkalizer', 'tag2' => '250ml', 'tag3' => 'USP Standard'
            ),
            'ar' => array(
                'title' => 'بيكربونات الصوديوم 8.4%',
                'desc'  => 'محلول معقم مرتفع التوتر لتصحيح الحماض الاستقلابي وزيادة قلوية الجسم في الحالات الطارئة.',
                'tag1'  => 'منظم قلوية', 'tag2' => '٢٥٠ مل', 'tag3' => 'معيار USP'
            ),
            'image' => 'assets/images/product.png'
        ),
        array(
            'en' => array(
                'title' => 'Potassium Chloride 10% Injection',
                'desc'  => 'Sterile concentrated potassium infusion for treatment of severe hypokalemia.',
                'tag1'  => 'Concentrated Electrolyte', 'tag2' => '100ml', 'tag3' => 'GMP Certified'
            ),
            'ar' => array(
                'title' => 'كلوريد البوتاسيوم 10% للحقن',
                'desc'  => 'محلول بوتاسيوم مركز معقم لعلاج نقص بوتاسيوم الدم الحاد.',
                'tag1'  => 'كهرلي مركز', 'tag2' => '١٠٠ مل', 'tag3' => 'معتمد بموجب GMP'
            ),
            'image' => 'assets/images/product.png'
        ),
        array(
            'en' => array(
                'title' => 'Sterile Water for Injection',
                'desc'  => 'Ultra-pure sterile water for dissolving and diluting parenteral drugs in cleanroom processing.',
                'tag1'  => 'Purified Solvent', 'tag2' => '500ml', 'tag3' => 'Class A Sterility'
            ),
            'ar' => array(
                'title' => 'ماء معقم للحقن',
                'desc'  => 'ماء معقم فائقة النقاء لإذابة وتخفيف الأدوية الوريدية داخل الغرف النظيفة.',
                'tag1'  => 'مذيب نقاء', 'tag2' => '٥٠٠ مل', 'tag3' => 'تعقيم فئة A'
            ),
            'image' => 'assets/images/product.png'
        ),
        array(
            'en' => array(
                'title' => 'Ciprofloxacin IV Infusion 200mg',
                'desc'  => 'Sterile broad-spectrum fluoroquinolone antibacterial solution for intravenous administration.',
                'tag1'  => 'Antibacterial Infusion', 'tag2' => '100ml', 'tag3' => 'GMP Certified'
            ),
            'ar' => array(
                'title' => 'سيبروفلوكساسين وريدي 200 مجم',
                'desc'  => 'محلول مضاد حيوي معقم واسع المجال من الفلوروكينولون للحقن الوريدي.',
                'tag1'  => 'محلول مضاد بكتيري', 'tag2' => '١٠٠ مل', 'tag3' => 'معتمد بموجب GMP'
            ),
            'image' => 'assets/images/product.png'
        ),
        array(
            'en' => array(
                'title' => 'Calcium Gluconate 10% Injection',
                'desc'  => 'Sterile solution for cardioprotection and therapy of acute hypocalcemia in clinical ICUs.',
                'tag1'  => 'Cardioprotective Fluid', 'tag2' => '100ml', 'tag3' => 'USP Standard'
            ),
            'ar' => array(
                'title' => 'جلوكونات الكالسيوم 10%',
                'desc'  => 'محلول معقم لحماية القلب وعلاج نقص كالسيوم الدم الحاد في وحدات العناية المركزة.',
                'tag1'  => 'سائل حماية القلب', 'tag2' => '١٠٠ مل', 'tag3' => 'معيار USP'
            ),
            'image' => 'assets/images/product.png'
        ),
    );

    foreach ($products as $p) {
        // Create EN Product
        $en_id = alsalam_post_exists($p['en']['title']);
        if (!$en_id) {
            $en_id = wp_insert_post([
                'post_title'   => $p['en']['title'],
                'post_content' => $p['en']['desc'],
                'post_excerpt' => $p['en']['desc'],
                'post_status'  => 'publish',
                'post_type'    => 'alsalam_product'
            ]);
            if (!is_wp_error($en_id)) {
                update_post_meta($en_id, '_alsalam_product_tag1', $p['en']['tag1']);
                update_post_meta($en_id, '_alsalam_product_tag2', $p['en']['tag2']);
                update_post_meta($en_id, '_alsalam_product_tag3', $p['en']['tag3']);
                if (function_exists('pll_set_post_language')) pll_set_post_language($en_id, 'en');
                $img_path = ALSALAM_DIR . '/../alsalam_original_theme/' . $p['image'];
                alsalam_attach_image_to_post($img_path, $en_id);
            }
        }

        // Create AR Product
        $ar_id = alsalam_post_exists($p['ar']['title']);
        if (!$ar_id) {
            $ar_id = wp_insert_post([
                'post_title'   => $p['ar']['title'],
                'post_content' => $p['ar']['desc'],
                'post_excerpt' => $p['ar']['desc'],
                'post_status'  => 'publish',
                'post_type'    => 'alsalam_product'
            ]);
            if (!is_wp_error($ar_id)) {
                update_post_meta($ar_id, '_alsalam_product_tag1', $p['ar']['tag1']);
                update_post_meta($ar_id, '_alsalam_product_tag2', $p['ar']['tag2']);
                update_post_meta($ar_id, '_alsalam_product_tag3', $p['ar']['tag3']);
                if (function_exists('pll_set_post_language')) pll_set_post_language($ar_id, 'ar');
                $img_path = ALSALAM_DIR . '/../alsalam_original_theme/' . $p['image'];
                alsalam_attach_image_to_post($img_path, $ar_id);
            }
        }

        // Link Translations via Polylang
        if (!is_wp_error($en_id) && !is_wp_error($ar_id) && function_exists('pll_save_post_translations')) {
            pll_save_post_translations(['en' => $en_id, 'ar' => $ar_id]);
            echo '<li>Linked Product Pair: ' . esc_html($p['en']['title']) . ' <=> ' . esc_html($p['ar']['title']) . '</li>';
        }
    }

    // --- 5. Seed Gallery (Bilingual EN & AR) ---
    echo '</ul><h3>Seeding Gallery (Bilingual EN & AR)</h3><ul>';
    $galleryItems = array(
        array(
            'en' => array('title' => 'Sterile R&D Clean Room', 'cat' => 'Research & Development', 'loc' => 'Baghdad Facility', 'photo' => 'AL-SALAM Media'),
            'ar' => array('title' => 'غرفة الأبحاث والتطوير المعقمة', 'cat' => 'البحث والتطوير', 'loc' => 'منشأة بغداد', 'photo' => 'إعلام السلام'),
            'media' => 'video', 'image' => 'assets/images/gallery/p1.webp'
        ),
        array(
            'en' => array('title' => 'Microbiology Quality Lab', 'cat' => 'Quality Assurance', 'loc' => 'QC Control Wing', 'photo' => 'QA Team'),
            'ar' => array('title' => 'مختبر ضبط الجودة الأحيائية', 'cat' => 'جودة التصنيع', 'loc' => 'جناح رقابة الجودة', 'photo' => 'فريق الجودة'),
            'media' => 'image', 'image' => 'assets/images/gallery/p2.webp'
        ),
        array(
            'en' => array('title' => 'Automated BFS Production Line', 'cat' => 'Manufacturing', 'loc' => 'Main Cleanroom A', 'photo' => 'Operations Tech'),
            'ar' => array('title' => 'خط إنتاج BFS المعقم الآلي', 'cat' => 'خطوط الإنتاج', 'loc' => 'الغرفة النظيفة الرئيسية A', 'photo' => 'تقنيي العمليات'),
            'media' => 'video', 'image' => 'assets/images/gallery/p3.webp'
        ),
        array(
            'en' => array('title' => 'Chemical Analysis Center', 'cat' => 'Quality Assurance', 'loc' => 'Central Analytical Lab', 'photo' => 'QC Chemist'),
            'ar' => array('title' => 'مركز التحليل الكيميائي والدوائي', 'cat' => 'جودة التصنيع', 'loc' => 'المختبر التحليلي المركزي', 'photo' => 'كيميائي ضبط الجودة'),
            'media' => 'image', 'image' => 'assets/images/gallery/p4.webp'
        ),
        array(
            'en' => array('title' => 'Smart Automated Storage Facility', 'cat' => 'Logistics', 'loc' => 'Central Warehouse', 'photo' => 'Supply Chain Team'),
            'ar' => array('title' => 'مستودع التخزين الذكي المعقم', 'cat' => 'اللوجستيات', 'loc' => 'المخزن المركزي', 'photo' => 'فريق سلاسل الإمداد'),
            'media' => 'video', 'image' => 'assets/images/gallery/p5.webp'
        )
    );

    foreach ($galleryItems as $g) {
        // EN Gallery Item
        $en_id = alsalam_post_exists($g['en']['title']);
        if (!$en_id) {
            $en_id = wp_insert_post([
                'post_title'   => $g['en']['title'],
                'post_content' => 'High quality view of ' . $g['en']['title'] . ' showing our modern European GMP facilities.',
                'post_status'  => 'publish',
                'post_type'    => 'alsalam_gallery'
            ]);
            if (!is_wp_error($en_id)) {
                $term = wp_insert_term($g['en']['cat'], 'gallery_cat');
                $term_id = is_wp_error($term) ? $term->error_data['term_exists'] : $term['term_id'];
                if ($term_id) wp_set_object_terms($en_id, $term_id, 'gallery_cat');
                update_post_meta($en_id, '_alsalam_gallery_media_type', $g['media']);
                update_post_meta($en_id, '_alsalam_gallery_location', $g['en']['loc']);
                update_post_meta($en_id, '_alsalam_gallery_photographer', $g['en']['photo']);
                if (function_exists('pll_set_post_language')) pll_set_post_language($en_id, 'en');
                $img_path = ALSALAM_DIR . '/../alsalam_original_theme/' . $g['image'];
                alsalam_attach_image_to_post($img_path, $en_id);
            }
        }

        // AR Gallery Item
        $ar_id = alsalam_post_exists($g['ar']['title']);
        if (!$ar_id) {
            $ar_id = wp_insert_post([
                'post_title'   => $g['ar']['title'],
                'post_content' => 'عرض عالي الجودة لمنشأة ' . $g['ar']['title'] . ' المصممة وفقاً لمعايير التصنيع الجيد GMP الأوروبية.',
                'post_status'  => 'publish',
                'post_type'    => 'alsalam_gallery'
            ]);
            if (!is_wp_error($ar_id)) {
                $term = wp_insert_term($g['ar']['cat'], 'gallery_cat');
                $term_id = is_wp_error($term) ? $term->error_data['term_exists'] : $term['term_id'];
                if ($term_id) wp_set_object_terms($ar_id, $term_id, 'gallery_cat');
                update_post_meta($ar_id, '_alsalam_gallery_media_type', $g['media']);
                update_post_meta($ar_id, '_alsalam_gallery_location', $g['ar']['loc']);
                update_post_meta($ar_id, '_alsalam_gallery_photographer', $g['ar']['photo']);
                if (function_exists('pll_set_post_language')) pll_set_post_language($ar_id, 'ar');
                $img_path = ALSALAM_DIR . '/../alsalam_original_theme/' . $g['image'];
                alsalam_attach_image_to_post($img_path, $ar_id);
            }
        }

        if (!is_wp_error($en_id) && !is_wp_error($ar_id) && function_exists('pll_save_post_translations')) {
            pll_save_post_translations(['en' => $en_id, 'ar' => $ar_id]);
            echo '<li>Linked Gallery Pair: ' . esc_html($g['en']['title']) . ' <=> ' . esc_html($g['ar']['title']) . '</li>';
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
            }
        }
    }

    echo '</ul>';
    echo '<h3>Seeding Complete!</h3>';
}

/**
 * Customizer Seeder
 */
function alsalam_run_customizer_seeder() {
    if (!isset($_GET['run_alsalam_customizer_seeder']) || !current_user_can('manage_options')) {
        return;
    }

    echo '<h3>AL-SALAM Customizer Seeder Log</h3><ul>';

    $img = function($filename) {
        return get_template_directory_uri() . '/assets/images/' . $filename;
    };

    $mods = [
        // Global
        '_alsalam_color_primary' => '#239BA8',
        '_alsalam_color_primary_dark' => '#12A19A',
        '_alsalam_color_bg_dark' => '#041424',
        '_alsalam_color_bg_light' => '#F4F7FE',
        
        // Header
        '_alsalam_header_logo' => $img('logo (2).png'),
        '_alsalam_header_logo_width' => 150,
        '_alsalam_header_cta_text' => 'Request Inquiry',
        '_alsalam_header_cta_link' => '/inquiry/',
        
        // Hero EN
        '_alsalam_hero_bg_type' => 'video',
        '_alsalam_hero_bg_video' => get_template_directory_uri() . '/assets/video/HomePageVideo.mp4',
        '_alsalam_hero_deco_tr' => $img('top-right-bg.png'),
        '_alsalam_hero_deco_bl' => $img('bottom-left.png'),
        '_alsalam_hero_btn1_text' => 'About Us',
        '_alsalam_hero_btn1_link' => '/about/',
        '_alsalam_hero_btn2_text' => 'Our Products',
        '_alsalam_hero_btn2_link' => '/products/',
        '_alsalam_hero_video_modal_enable' => '1',
        '_alsalam_hero_slides' => json_encode([
            [
                'badge1' => 'AL-SALAM', 'badge2' => 'COMPANY',
                'title' => 'Sterile Pharmaceutical',
                'sub' => 'Manufacturing Built on European GMP Standards',
                'desc' => 'Delivering high-quality parenteral solutions conforming to global regulatory frameworks with state-of-the-art sterile processing facilities.'
            ],
            [
                'badge1' => 'AL-SALAM', 'badge2' => 'TECHNOLOGY',
                'title' => 'Advanced Aseptic BFS Lines',
                'sub' => 'High-Tech Automated Operations',
                'desc' => 'Utilizing advanced blow-fill-seal methodologies to eliminate intervention vectors, ensuring highest safety indexes in parenteral formulation.'
            ],
            [
                'badge1' => 'AL-SALAM', 'badge2' => 'HEALTHCARE',
                'title' => 'National Health Supply Security',
                'sub' => 'Essential Critical-Care Distribution',
                'desc' => 'Supplying life-saving intravenous solutions globally. Securing hospital networks with seamless therapeutic supply.'
            ]
        ]),

        // Hero AR
        '_alsalam_hero_slides_ar' => json_encode([
            [
                'badge1' => 'السلام', 'badge2' => 'الشركة',
                'title' => 'صناعة دوائية معقمة',
                'sub' => 'تصنيع وفق معايير التصنيع الجيد GMP الأوروبية',
                'desc' => 'تقديم محاليل وريدية علاجية عالية النقاء تتوافق مع الأطر التنظيمية العالمية داخل منشآت تصنيع معقمة فائقة التطور.'
            ],
            [
                'badge1' => 'السلام', 'badge2' => 'التكنولوجيا',
                'title' => 'خطوط BFS المعقمة المتقدمة',
                'sub' => 'عمليات مؤتمتة عالية التقنية',
                'desc' => 'نعتمد تكنولوجيا النفخ والتعبئة والختم الذاتية لاستبعاد عوامل التلوث البشري وضمان أعلى مؤشرات الأمان الدوائي.'
            ],
            [
                'badge1' => 'السلام', 'badge2' => 'الرعاية الصحية',
                'title' => 'الأمن الدوائي الوطني',
                'sub' => 'تأمين المحاليل الوريدية الحيوية',
                'desc' => 'تزويد شبكات المستشفيات والمراكز الطبية بالمحاليل الوريدية المنقذة للحياة باستمرارية توريد موثوقة.'
            ]
        ]),

        // About
        '_alsalam_about_enable' => '1',
        '_alsalam_about_img' => $img('about-bg.jpg'),
        '_alsalam_about_deco' => $img('image-icon.png'),
        '_alsalam_about_btn_text' => 'Learn More',
        '_alsalam_about_btn_link' => '/about/',
        '_alsalam_about_badge' => 'Corporate Profile',
        '_alsalam_about_title' => 'About AL-SALAM',
        '_alsalam_about_desc1' => 'AL-SALAM Pharmaceutical Industry is a sterile manufacturing facility specializing in parenteral solutions, built according to European GMP standards in Iraq.',
        '_alsalam_about_desc2' => 'We combine advanced production, strict quality control, and fully controlled cleanroom environments to ensure safe and reliable pharmaceutical products.',

        // Infrastructure EN & AR
        '_alsalam_infra_enable' => '1',
        '_alsalam_infra_title' => 'Advanced <span class="text-teal-500">Pharmaceutical</span> Infrastructure',
        '_alsalam_infra_sub' => 'Built on Quality. Driven by Care',
        '_alsalam_infra_items' => json_encode([
            ['icon' => $img('Shield.svg'), 'title' => 'Sterile Production', 'desc' => 'Manufactured under strict GMP guidelines with high sterility standards to ensure product purity.'],
            ['icon' => $img('Search copy.svg'), 'title' => 'Quality Control', 'desc' => 'Rigorous testing and analytical inspection to ensure full compliance with global pharmacopeia standards.'],
            ['icon' => $img('Star.svg'), 'title' => 'Facility & Utilities', 'desc' => 'State-of-the-art cleanroom facilities powered by intelligent climate control (HVAC) systems.'],
            ['icon' => $img('Graph.svg'), 'title' => 'Storage & Packaging', 'desc' => 'Advanced packaging and validation protocols including thermal processing for maximum safety.']
        ]),
        '_alsalam_infra_items_ar' => json_encode([
            ['icon' => $img('Shield.svg'), 'title' => 'الإنتاج المعقم', 'desc' => 'مُصنّع تحت إرشادات ممارسات التصنيع الجيد GMP الصارمة مع معايير تعقيم عالية لضمان نقاء المنتج.'],
            ['icon' => $img('Search copy.svg'), 'title' => 'مراقبة الجودة', 'desc' => 'اختبارات صارمة وفحص تحليلي لضمان الامتثال الكامل لمعايير الدستور الدوائي العالمي.'],
            ['icon' => $img('Star.svg'), 'title' => 'المرفق والمرافق العامة', 'desc' => 'مرافق غرف نظيفة متطورة تعتمد على أنظمة تحكم ذكية بالمناخ (HVAC).'],
            ['icon' => $img('Graph.svg'), 'title' => 'التخزين والتعبئة والتغليف', 'desc' => 'بروتوكولات تعبئة وتحقق متقدمة تشمل المعالجة الحرارية لأقصى درجات الأمان.']
        ]),

        // Products
        '_alsalam_products_title' => '<span class="text-teal-600 block"><span class="text-teal-600">Sterile</span> <span class="text-slate-900">Solutions</span></span><span class="text-slate-900 block mt-1">Reliable</span>',
        '_alsalam_products_sub' => 'European Standards, Iraqi Excellence',
        '_alsalam_products_btn_text' => 'All Products',
        '_alsalam_products_btn_link' => '/products/',

        // Why Choose Us EN & AR
        '_alsalam_why_features' => json_encode([
            ['icon' => $img('medal-star.svg'), 'title' => 'Enhanced Safety', 'desc' => 'Reduced risk of breakage and contamination in clinical settings.'],
            ['icon' => $img('truck.svg'), 'title' => 'Better Handling', 'desc' => 'Lightweight and easy to transport, optimizing logistics.'],
            ['icon' => $img('target.svg'), 'title' => 'Clinical Efficiency', 'desc' => 'Streamlined design for medical staff and fast setup.'],
            ['icon' => $img('layer-group.svg'), 'title' => 'Advanced Materials', 'desc' => 'Multi-layered technology for optimal medical protection.']
        ]),
        '_alsalam_why_features_ar' => json_encode([
            ['icon' => $img('medal-star.svg'), 'title' => 'سلامة معززة', 'desc' => 'تقليل مخاطر الكسر والتلوث في البيئات السريرية.'],
            ['icon' => $img('truck.svg'), 'title' => 'تعامل أفضل', 'desc' => 'خفيفة الوزن وسهلة النقل، مما يحسن العمليات اللوجستية.'],
            ['icon' => $img('target.svg'), 'title' => 'كفاءة سريرية', 'desc' => 'تصميم مبسط للطاقم الطبي وسرعة التحضير.'],
            ['icon' => $img('layer-group.svg'), 'title' => 'مواد متطورة', 'desc' => 'تكنولوجيا متعددة الطبقات لتوفير حماية طبية مثالية.']
        ]),

        // Testimonials EN & AR
        '_alsalam_testi_enable' => '1',
        '_alsalam_testi_title' => 'What Our Partners Say',
        '_alsalam_testi_reviews' => json_encode([
            [
                'name' => 'Dr. Ahmed Yassin', 'role' => 'Clinical Director', 'rating' => '5.0', 'date' => '2024/02/12',
                'comment' => 'The professionalism and quality of sterile solutions provided by AL-SALAM have completely elevated our hospital operations. Their supply consistency is unmatched.',
                'avatar' => $img('avatar-man.jpg')
            ],
            [
                'name' => 'Pharmacist Sarah Rafiq', 'role' => 'Procurement Manager', 'rating' => '4.8', 'date' => '2024/01/20',
                'comment' => 'Fantastic experience with their flexible IV bag line. Light, durable, and highly compliant with global pharmacopoeial standards.',
                'avatar' => $img('avatar-man.jpg')
            ],
            [
                'name' => 'Dr. Mustafa Jawad', 'role' => 'Critical Care Specialist', 'rating' => '5.0', 'date' => '2023/11/05',
                'comment' => 'A truly reliable partner for critical care fluids in Iraq. Their compliance with European GMP standards is clear in every batch.',
                'avatar' => $img('avatar-man.jpg')
            ]
        ]),
        '_alsalam_testi_reviews_ar' => json_encode([
            [
                'name' => 'د. أحمد ياسين', 'role' => 'المدير السريري للمستشفى', 'rating' => '5.0', 'date' => '١٤٤٥/٠٨/٠٢',
                'comment' => 'إن الاحترافية والجودة الفائقة للمحاليل الوريدية المعقمة المقدمة من شركة السلام ارتقتا بعمليات مستشفانا بشكل كامل. استقرار التوريد لديهم لا يضاهى.',
                'avatar' => $img('avatar-man.jpg')
            ],
            [
                'name' => 'الصيدلانية سارة رفيق', 'role' => 'مديرة المشتريات الطبية', 'rating' => '4.8', 'date' => '١٤٤٥/٠٧/١٠',
                'comment' => 'تجربة ممتازة مع خط الأكياس الوريدية المرنة. خفيفة الوزن ومتينة ومتوافقة تماماً مع المعايير القياسية للدستور الدوائي العالمي.',
                'avatar' => $img('avatar-man.jpg')
            ],
            [
                'name' => 'د. مصطفى جواد', 'role' => 'أخصائي العناية المركزة', 'rating' => '5.0', 'date' => '١٤٤٥/٠٥/٢٢',
                'comment' => 'شريك موثوق بحق للمحاليل العلاجية الحساسة في العراق. التزامهم بمعايير GMP الأوروبية واضح وجلي في كل وجبة دوائية تصلنا.',
                'avatar' => $img('avatar-man.jpg')
            ]
        ]),

        // Marquee EN & AR
        '_alsalam_marquee_enable' => '1',
        '_alsalam_marquee_items' => json_encode([
            ['icon' => $img('badge-check.svg'), 'title' => 'Trusted Quality'],
            ['icon' => $img('Star.svg'), 'title' => 'European Standards'],
            ['icon' => $img('Shield.svg'), 'title' => 'GMP Certified'],
            ['icon' => $img('Graph.svg'), 'title' => 'Advanced Technology'],
            ['icon' => $img('Search copy.svg'), 'title' => 'Precision Care']
        ]),
        '_alsalam_marquee_items_ar' => json_encode([
            ['icon' => $img('badge-check.svg'), 'title' => 'جودة موثوقة'],
            ['icon' => $img('Star.svg'), 'title' => 'معايير أوروبية'],
            ['icon' => $img('Shield.svg'), 'title' => 'شهادة GMP'],
            ['icon' => $img('Graph.svg'), 'title' => 'تكنولوجيا متطورة'],
            ['icon' => $img('Search copy.svg'), 'title' => 'رعاية دقيقة']
        ])
    ];

    foreach ($mods as $key => $val) {
        set_theme_mod($key, $val);
    }

    echo '</ul><h3>Customizer Seeding Complete!</h3>';
}

/**
 * Helper to upload an image from file path and attach it to a post
 */
function alsalam_attach_image_to_post($file_path, $post_id) {
    if (!file_exists($file_path)) return false;

    // Check if THIS post already has a thumbnail — skip if so
    if (has_post_thumbnail($post_id)) return get_post_thumbnail_id($post_id);

    // Always upload fresh — append unique suffix if filename already exists in uploads
    $filename  = basename($file_path);
    $file_data = file_get_contents($file_path);
    $upload    = wp_upload_bits($filename, null, $file_data);

    if ($upload['error']) return false;

    $wp_filetype = wp_check_filetype($upload['file'], null);
    $attachment  = [
        'post_mime_type' => $wp_filetype['type'],
        'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    $attachment_id = wp_insert_attachment($attachment, $upload['file'], $post_id);
    if (is_wp_error($attachment_id)) return false;

    if (!function_exists('wp_generate_attachment_metadata')) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
    }

    $meta = wp_generate_attachment_metadata($attachment_id, $upload['file']);
    wp_update_attachment_metadata($attachment_id, $meta);
    set_post_thumbnail($post_id, $attachment_id);

    return $attachment_id;
}
