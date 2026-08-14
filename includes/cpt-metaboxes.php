<?php
/**
 * Custom Post Type Metaboxes (Products & Gallery)
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

/**
 * Register Metaboxes for CPTs
 */
function alsalam_add_cpt_metaboxes() {
    // Products Metabox
    add_meta_box(
        'alsalam_product_specs',
        __('Product Specifications & Tags', 'alsalam'),
        'alsalam_render_product_metabox',
        'alsalam_product',
        'normal',
        'high'
    );

    // Gallery Metabox
    add_meta_box(
        'alsalam_gallery_details',
        __('Gallery Item Details', 'alsalam'),
        'alsalam_render_gallery_metabox',
        'alsalam_gallery',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'alsalam_add_cpt_metaboxes');

/**
 * Render Product Metabox
 */
function alsalam_render_product_metabox($post) {
    wp_nonce_field('alsalam_save_product_meta', 'alsalam_product_meta_nonce');

    $tag1 = get_post_meta($post->ID, '_alsalam_product_tag1', true);
    $tag2 = get_post_meta($post->ID, '_alsalam_product_tag2', true);
    $tag3 = get_post_meta($post->ID, '_alsalam_product_tag3', true);

    // Default fallbacks
    if (empty($tag1)) $tag1 = 'BFS Sterile Bottle';
    if (empty($tag2)) $tag2 = '500ml';
    if (empty($tag3)) $tag3 = 'GMP Certified';

    ?>
    <div class="alsalam-metabox-wrapper" style="padding: 10px 0;">
        <style>
            .alsalam-row { margin-bottom: 15px; }
            .alsalam-row label { display: block; font-weight: 600; margin-bottom: 5px; color: #1e1e1e; }
            .alsalam-row input[type="text"] { width: 100%; padding: 6px 10px; border-radius: 4px; border: 1px solid #8c8f94; }
            .alsalam-help { font-size: 12px; color: #646970; margin-top: 4px; display: block; }
            .alsalam-box { background: #f0f0f1; border: 1px solid #c3c4c7; padding: 15px; border-radius: 6px; }
        </style>

        <div class="alsalam-box">
            <div class="alsalam-row">
                <label for="alsalam_product_tag1"><?php esc_html_e('Packaging Presentation (Tag 1)', 'alsalam'); ?></label>
                <input type="text" id="alsalam_product_tag1" name="alsalam_product_tag1" value="<?php echo esc_attr($tag1); ?>">
                <span class="alsalam-help"><?php esc_html_e('e.g., BFS Sterile Bottle, Aseptic BFS Pack', 'alsalam'); ?></span>
            </div>

            <div class="alsalam-row">
                <label for="alsalam_product_tag2"><?php esc_html_e('Volume Availability (Tag 2)', 'alsalam'); ?></label>
                <input type="text" id="alsalam_product_tag2" name="alsalam_product_tag2" value="<?php echo esc_attr($tag2); ?>">
                <span class="alsalam-help"><?php esc_html_e('e.g., 500ml, 100ml', 'alsalam'); ?></span>
            </div>

            <div class="alsalam-row">
                <label for="alsalam_product_tag3"><?php esc_html_e('Quality Grade (Tag 3)', 'alsalam'); ?></label>
                <input type="text" id="alsalam_product_tag3" name="alsalam_product_tag3" value="<?php echo esc_attr($tag3); ?>">
                <span class="alsalam-help"><?php esc_html_e('e.g., GMP Certified, USP Standard, European GMP', 'alsalam'); ?></span>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Render Gallery Metabox
 */
function alsalam_render_gallery_metabox($post) {
    wp_nonce_field('alsalam_save_gallery_meta', 'alsalam_gallery_meta_nonce');

    $location = get_post_meta($post->ID, '_alsalam_gallery_location', true);
    $photographer = get_post_meta($post->ID, '_alsalam_gallery_photographer', true);
    $media_type = get_post_meta($post->ID, '_alsalam_gallery_media_type', true) ?: 'image';

    ?>
    <div class="alsalam-metabox-wrapper">
        <style>
            .alsalam-side-row { margin-bottom: 15px; }
            .alsalam-side-row label { display: block; font-weight: 600; margin-bottom: 5px; color: #1e1e1e; }
            .alsalam-side-row input[type="text"], .alsalam-side-row select { width: 100%; padding: 5px; border-radius: 4px; border: 1px solid #8c8f94; }
        </style>

        <p style="font-size:13px; color:#646970; margin-top:0;">
            <?php esc_html_e('Optional details to display alongside the gallery item.', 'alsalam'); ?>
        </p>

        <div class="alsalam-side-row">
            <label for="alsalam_gallery_media_type"><?php esc_html_e('Media Type', 'alsalam'); ?></label>
            <select id="alsalam_gallery_media_type" name="alsalam_gallery_media_type">
                <option value="image" <?php selected($media_type, 'image'); ?>><?php esc_html_e('Image', 'alsalam'); ?></option>
                <option value="video" <?php selected($media_type, 'video'); ?>><?php esc_html_e('Video (Plays Icon)', 'alsalam'); ?></option>
            </select>
        </div>

        <div class="alsalam-side-row">
            <label for="alsalam_gallery_location"><?php esc_html_e('Location / Facility', 'alsalam'); ?></label>
            <input type="text" id="alsalam_gallery_location" name="alsalam_gallery_location" value="<?php echo esc_attr($location); ?>" placeholder="e.g., Cleanroom A">
        </div>

        <div class="alsalam-side-row">
            <label for="alsalam_gallery_photographer"><?php esc_html_e('Photographer / Source', 'alsalam'); ?></label>
            <input type="text" id="alsalam_gallery_photographer" name="alsalam_gallery_photographer" value="<?php echo esc_attr($photographer); ?>" placeholder="e.g., AL-SALAM Media">
        </div>
    </div>
    <?php
}

/**
 * Save Metabox Data
 */
function alsalam_save_cpt_meta($post_id) {
    // Check if our nonce is set and verify it.
    if (isset($_POST['alsalam_product_meta_nonce']) && wp_verify_nonce($_POST['alsalam_product_meta_nonce'], 'alsalam_save_product_meta')) {
        // Stop WP from clearing custom fields on autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        if (isset($_POST['alsalam_product_tag1'])) {
            update_post_meta($post_id, '_alsalam_product_tag1', sanitize_text_field($_POST['alsalam_product_tag1']));
        }
        if (isset($_POST['alsalam_product_tag2'])) {
            update_post_meta($post_id, '_alsalam_product_tag2', sanitize_text_field($_POST['alsalam_product_tag2']));
        }
        if (isset($_POST['alsalam_product_tag3'])) {
            update_post_meta($post_id, '_alsalam_product_tag3', sanitize_text_field($_POST['alsalam_product_tag3']));
        }
    }

    if (isset($_POST['alsalam_gallery_meta_nonce']) && wp_verify_nonce($_POST['alsalam_gallery_meta_nonce'], 'alsalam_save_gallery_meta')) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        if (isset($_POST['alsalam_gallery_location'])) {
            update_post_meta($post_id, '_alsalam_gallery_location', sanitize_text_field($_POST['alsalam_gallery_location']));
        }
        if (isset($_POST['alsalam_gallery_photographer'])) {
            update_post_meta($post_id, '_alsalam_gallery_photographer', sanitize_text_field($_POST['alsalam_gallery_photographer']));
        }
        if (isset($_POST['alsalam_gallery_media_type'])) {
            update_post_meta($post_id, '_alsalam_gallery_media_type', sanitize_text_field($_POST['alsalam_gallery_media_type']));
        }
    }
}
add_action('save_post', 'alsalam_save_cpt_meta');
