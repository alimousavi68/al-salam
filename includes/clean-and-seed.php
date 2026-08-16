<?php
/**
 * One-time clean and seed.
 * CRITICAL: Flag is set FIRST (before any work) to prevent double-execution on any failure.
 */
defined('ABSPATH') || exit;

add_action('init', 'alsalam_clean_and_seed_once', 1);

function alsalam_clean_and_seed_once() {
    // ─── LOCK: flag set FIRST, before any DB work ───────────────
    if (get_option('alsalam_seed_lock_v12')) return;
    update_option('alsalam_seed_lock_v12', true);

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    // ─── STEP 1: Wipe all pages, posts, and media ───────────────
    foreach (['page', 'post', 'attachment', 'alsalam_product', 'alsalam_gallery'] as $type) {
        $items = get_posts(['post_type' => $type, 'numberposts' => -1, 'post_status' => 'any']);
        foreach ($items as $item) {
            if ($type === 'attachment') {
                $file = get_attached_file($item->ID);
                if ($file && file_exists($file)) @unlink($file);
            }
            wp_delete_post($item->ID, true);
        }
    }

    // ─── STEP 2: Wipe all nav menus ─────────────────────────────
    foreach (wp_get_nav_menus() as $menu) {
        wp_delete_nav_menu($menu->term_id);
    }

    // ─── STEP 3: Run the main seeder (suppressed output) ────────
    if (function_exists('alsalam_run_seeder')) {
        ob_start();
        try {
            alsalam_run_seeder();
            if (function_exists('alsalam_run_customizer_seeder')) {
                alsalam_run_customizer_seeder();
            }
        } catch (Throwable $e) {
            error_log('AL-SALAM Seeder error: ' . $e->getMessage());
        }
        ob_end_clean();
    }

    // ─── STEP 4: Create 3 core pages missing from seeder ────────
    $core_pages = [
        ['en' => 'Home',     'ar' => 'الرئيسية',   'tpl' => 'front-page.php'],
        ['en' => 'Products', 'ar' => 'المنتجات',    'tpl' => 'page-products.php'],
        ['en' => 'Gallery',  'ar' => 'معرض الصور',  'tpl' => 'page-gallery.php'],
    ];

    foreach ($core_pages as $pg) {
        $existing_en = get_page_by_title($pg['en'], OBJECT, 'page');
        $en_id = $existing_en ? $existing_en->ID : wp_insert_post([
            'post_title' => $pg['en'], 'post_type' => 'page', 'post_status' => 'publish'
        ]);
        if (!is_wp_error($en_id)) {
            update_post_meta($en_id, '_wp_page_template', $pg['tpl']);
            if (function_exists('pll_set_post_language')) pll_set_post_language($en_id, 'en');
        }

        $existing_ar = get_page_by_title($pg['ar'], OBJECT, 'page');
        $ar_id = $existing_ar ? $existing_ar->ID : wp_insert_post([
            'post_title' => $pg['ar'], 'post_type' => 'page', 'post_status' => 'publish'
        ]);
        if (!is_wp_error($ar_id)) {
            update_post_meta($ar_id, '_wp_page_template', $pg['tpl']);
            if (function_exists('pll_set_post_language')) pll_set_post_language($ar_id, 'ar');
        }

        if (!is_wp_error($en_id) && !is_wp_error($ar_id) && function_exists('pll_save_post_translations')) {
            pll_save_post_translations(['en' => $en_id, 'ar' => $ar_id]);
        }
    }

    // ─── STEP 5: Set Home as the static front page ──────────────
    $home = get_page_by_title('Home', OBJECT, 'page');
    if ($home) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home->ID);
    }

    // Helper: get page URL by title (uses actual WP permalink)
    $page_url = function($title, $fallback = '/') {
        $page = get_page_by_title($title, OBJECT, 'page');
        return $page ? get_permalink($page->ID) : home_url($fallback);
    };

    // ─── STEP 6: Build primary menus via page lookups ────────────
    // Using title-based lookup so slugs are always correct
    $primary_menus = [
        'primary___en' => [
            'name' => 'Primary Menu EN', 'lang' => 'en',
            'pages' => ['Home', 'About', 'Products', 'Gallery', 'Contact', 'Request Inquiry', 'Join Us']
        ],
        'primary___ar' => [
            'name' => 'Primary Menu AR', 'lang' => 'ar',
            'pages' => ['الرئيسية', 'من نحن', 'المنتجات', 'معرض الصور', 'اتصل بنا', 'طلب استفسار', 'انضم إلينا']
        ],
    ];

    $locations = get_theme_mod('nav_menu_locations', []);
    foreach ($primary_menus as $loc => $cfg) {
        $menu_id = wp_create_nav_menu($cfg['name']);
        foreach ($cfg['pages'] as $title) {
            $page = get_page_by_title($title, OBJECT, 'page');
            if ($page) {
                wp_update_nav_menu_item($menu_id, 0, [
                    'menu-item-title'     => $title,
                    'menu-item-object-id' => $page->ID,
                    'menu-item-object'    => 'page',
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                ]);
            }
        }
        if (function_exists('pll_set_term_language')) pll_set_term_language($menu_id, $cfg['lang']);
        $locations[$loc] = $menu_id;
    }
    set_theme_mod('nav_menu_locations', $locations);

    // ─── STEP 6b: Footer menus — EN (exactly matching original) ──
    $footer_en = [
        '_alsalam_footer_quick_menu' => [
            'name'  => 'Footer Quick Access EN',
            'items' => [
                ['title' => 'Home',             'url' => $page_url('Home')],
                ['title' => 'About',            'url' => $page_url('About')],
                ['title' => 'Our Infrastructure','url' => home_url('/#infrastructure')],
                ['title' => 'Contact',          'url' => $page_url('Contact')],
            ]
        ],
        '_alsalam_footer_services_menu' => [
            'name'  => 'Footer Services EN',
            'items' => [
                ['title' => 'Parenteral Mfg',  'url' => $page_url('Products')],
                ['title' => 'Quality Control', 'url' => $page_url('Products')],
                ['title' => 'R&D',             'url' => $page_url('Products')],
            ]
        ],
        '_alsalam_footer_resources_menu' => [
            'name'  => 'Footer Resources EN',
            'items' => [
                ['title' => 'News & Events', 'url' => home_url('/news/')],
                ['title' => 'Gallery',       'url' => $page_url('Gallery')],
                ['title' => 'Careers',       'url' => $page_url('Join Us')],
            ]
        ],
    ];

    // ─── STEP 6c: Footer menus — AR (Arabic items + correct links) ─
    $footer_ar = [
        '_alsalam_footer_quick_menu_ar' => [
            'name'  => 'Footer Quick Access AR',
            'items' => [
                ['title' => 'الرئيسية',       'url' => $page_url('الرئيسية')],
                ['title' => 'من نحن',         'url' => $page_url('من نحن')],
                ['title' => 'البنية التحتية', 'url' => home_url('/ar/#infrastructure')],
                ['title' => 'اتصل بنا',       'url' => $page_url('اتصل بنا')],
            ]
        ],
        '_alsalam_footer_services_menu_ar' => [
            'name'  => 'Footer Services AR',
            'items' => [
                ['title' => 'تصنيع المحاليل', 'url' => $page_url('المنتجات')],
                ['title' => 'مراقبة الجودة',  'url' => $page_url('المنتجات')],
                ['title' => 'البحث والتطوير', 'url' => $page_url('المنتجات')],
            ]
        ],
        '_alsalam_footer_resources_menu_ar' => [
            'name'  => 'Footer Resources AR',
            'items' => [
                ['title' => 'الأخبار والأحداث', 'url' => home_url('/ar/news/')],
                ['title' => 'معرض الصور',        'url' => $page_url('معرض الصور')],
                ['title' => 'الوظائف',           'url' => $page_url('انضم إلينا')],
            ]
        ],
    ];

    foreach (array_merge($footer_en, $footer_ar) as $mod_key => $cfg) {
        $existing = wp_get_nav_menu_object($cfg['name']);
        if ($existing) wp_delete_nav_menu($existing->term_id);
        $menu_id = wp_create_nav_menu($cfg['name']);
        foreach ($cfg['items'] as $item) {
            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title'  => $item['title'],
                'menu-item-url'    => $item['url'],
                'menu-item-type'   => 'custom',
                'menu-item-status' => 'publish',
            ]);
        }
        set_theme_mod($mod_key, $menu_id);
    }

    // ─── STEP 7: Seed CTA Link (Request Inquiry page) ────────────
    $inquiry_page = get_page_by_title('Request Inquiry', OBJECT, 'page');
    if ($inquiry_page) {
        set_theme_mod('_alsalam_header_cta_link', get_permalink($inquiry_page->ID));
        set_theme_mod('_alsalam_header_cta_label', 'Request Inquiry');
    }

    // ─── STEP 8: Set Blog Name and Tagline ───────────────────────
    update_option('blogname', 'AL-SALAM');
    update_option('blogdescription', 'Leading Pharmaceutical Manufacturing Company');

    // ─── STEP 9: Fix Customizer images ───────────────────────────
    $img = get_template_directory_uri() . '/assets/images/';
    set_theme_mod('_alsalam_testi_image', $img . 'testominals.webp');
    set_theme_mod('_alsalam_testi_icon',  $img . 'quote-icon.svg');
}
