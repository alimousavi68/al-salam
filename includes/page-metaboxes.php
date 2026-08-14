<?php
/**
 * Page Metaboxes
 * Advanced tabbed metaboxes with Repeater Fields and Auto-Seeding logic.
 */

defined('ABSPATH') || exit;

// 1. Add Metabox
add_action('add_meta_boxes', 'alsalam_add_page_metaboxes');
function alsalam_add_page_metaboxes() {
    add_meta_box(
        'alsalam_page_settings',
        __('Page Advanced Settings', 'alsalam'),
        'alsalam_page_settings_html',
        'page',
        'normal',
        'high'
    );
}

// Helper: Get Meta with Auto-Seeding (Fallback to default if empty)
function alsalam_get_meta_with_default($post_id, $key, $default = '') {
    $val = get_post_meta($post_id, $key, true);
    if ($val === '') {
        return $default;
    }
    return $val;
}

// 2. HTML for Metabox
function alsalam_page_settings_html($post) {
    wp_nonce_field('alsalam_save_page_meta', 'alsalam_page_meta_nonce');
    
    $template = get_post_meta($post->ID, '_wp_page_template', true);
    
    // Inline CSS for Premium UX
    echo '<style>
        .alsalam-tabs { display: flex; border-bottom: 2px solid #e2e8f0; margin-bottom: 20px; background: #f8fafc; padding: 10px 10px 0 10px; border-radius: 8px 8px 0 0; }
        .alsalam-tab { padding: 12px 24px; cursor: pointer; color: #64748b; font-weight: 600; border: 1px solid transparent; border-bottom: none; margin-right: 5px; border-radius: 6px 6px 0 0; transition: all 0.2s; }
        .alsalam-tab:hover { color: #0f172a; background: #f1f5f9; }
        .alsalam-tab.active { background: #fff; color: #0f172a; border-color: #e2e8f0; margin-bottom: -2px; border-bottom: 2px solid #fff; box-shadow: 0 -2px 5px rgba(0,0,0,0.02); }
        .alsalam-tab-content { display: none; padding: 10px; }
        .alsalam-tab-content.active { display: block; animation: alsalamFadeIn 0.3s; }
        @keyframes alsalamFadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        .alsalam-form-row { margin-bottom: 20px; }
        .alsalam-form-row label { display: block; font-weight: bold; margin-bottom: 8px; color: #1e293b; }
        .alsalam-form-row input[type="text"], .alsalam-form-row textarea { width: 100%; max-width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05); }
        .alsalam-form-row input[type="text"]:focus, .alsalam-form-row textarea:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; outline: none; }
        .alsalam-section-title { font-size: 16px; font-weight: 600; color: #0f172a; margin-top: 30px; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 8px; }
        
        /* Repeater Styles */
        .alsalam-repeater-field { background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px; }
        .alsalam-repeater-item { display: flex; gap: 10px; margin-bottom: 10px; align-items: center; background: #fff; padding: 10px; border: 1px dashed #cbd5e1; border-radius: 6px; }
        .alsalam-repeater-item input { flex: 1; margin: 0 !important; }
        .alsalam-remove-row { color: #ef4444 !important; border-color: transparent !important; background: transparent !important; cursor: pointer; padding: 5px 10px; font-size: 18px; font-weight: bold; line-height: 1; transition: transform 0.2s; }
        .alsalam-remove-row:hover { transform: scale(1.1); color: #dc2626 !important; }
        .alsalam-add-row { margin-top: 10px !important; }
    </style>';

    // JS for tabs and repeater
    echo '<script>
        jQuery(document).ready(function($){
            // Tabs
            $(".alsalam-tab").click(function(){
                var target = $(this).data("target");
                $(".alsalam-tab").removeClass("active");
                $(this).addClass("active");
                $(".alsalam-tab-content").removeClass("active");
                $("#" + target).addClass("active");
            });

            // Repeater Add
            $(document).on("click", ".alsalam-add-row", function(){
                var container = $(this).closest(".alsalam-repeater-field");
                var name = container.data("name");
                var placeholder = container.data("placeholder");
                var html = \'<div class="alsalam-repeater-item" style="display:none;">\';
                html += \'<span class="dashicons dashicons-menu" style="color:#94a3b8; cursor:grab;"></span>\';
                html += \'<input type="text" name="\' + name + \'[]" value="" placeholder="\' + placeholder + \'"/>\';
                html += \'<button type="button" class="button alsalam-remove-row" title="Remove">&times;</button>\';
                html += \'</div>\';
                var $html = $(html);
                container.find(".alsalam-repeater-items").append($html);
                $html.slideDown(200);
            });

            // Repeater Remove
            $(document).on("click", ".alsalam-remove-row", function(){
                $(this).closest(".alsalam-repeater-item").slideUp(200, function(){
                    $(this).remove();
                });
            });
            
            // Simple Sortable (Requires jQuery UI Sortable, which WP loads in admin)
            if($.fn.sortable) {
                $(".alsalam-repeater-items").sortable({
                    handle: ".dashicons-menu",
                    axis: "y",
                    opacity: 0.7
                });
            }
        });
    </script>';

    echo '<div class="alsalam-tabs">';
    echo '<div class="alsalam-tab active" data-target="tab-hero"><span class="dashicons dashicons-cover-image" style="margin-right:5px; margin-top:2px;"></span> Hero Section</div>';
    
    if ($template === 'page-about.php') {
        echo '<div class="alsalam-tab" data-target="tab-about-corp">Corporate Profile</div>';
        echo '<div class="alsalam-tab" data-target="tab-about-vision">Vision & Mission</div>';
        echo '<div class="alsalam-tab" data-target="tab-about-metrics">Metrics & CTA</div>';
    } elseif ($template === 'page-contact.php') {
        echo '<div class="alsalam-tab" data-target="tab-contact"><span class="dashicons dashicons-phone" style="margin-right:5px; margin-top:2px;"></span> Contact Details</div>';
    } elseif ($template === 'page-inquiry.php') {
        echo '<div class="alsalam-tab" data-target="tab-inquiry">Inquiry Form</div>';
    }
    echo '</div>'; // End tabs

    // Helper to get meta with default
    $meta = function($key, $default = '') use ($post) {
        return alsalam_get_meta_with_default($post->ID, $key, $default);
    };

    // --- TAB: HERO (Standardized for all templates) ---
    echo '<div id="tab-hero" class="alsalam-tab-content active">';
    $show_hero = get_post_meta($post->ID, '_alsalam_show_hero', true) !== '0' ? '1' : '0';
    echo '<div class="alsalam-form-row"><label><input type="checkbox" name="alsalam_show_hero" value="1" ' . checked($show_hero, '1', false) . ' /> Show Hero Section on this page</label></div>';
    echo '<p class="description mb-4">Note: If left empty, the page will use default values based on the template.</p>';
    alsalam_render_meta_textarea('Hero Title (HTML Supported)', '_alsalam_hero_title', $meta('_alsalam_hero_title', ''));
    alsalam_render_meta_textarea('Hero Subtitle', '_alsalam_hero_subtitle', $meta('_alsalam_hero_subtitle', ''));
    echo '</div>';

    // --- TAB: INQUIRY ---
    if ($template === 'page-inquiry.php') {
        echo '<div id="tab-inquiry" class="alsalam-tab-content">';
        
        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-forms"></span> Step 1: Business Profile</div>';
        echo '<div class="alsalam-form-row" style="background:#fff; border:1px solid #e2e8f0; padding:15px; border-radius:6px;">';
        alsalam_render_meta_input('Badge (Top small text)', '_alsalam_inquiry_step1_badge', $meta('_alsalam_inquiry_step1_badge', '1. Business Profile'));
        alsalam_render_meta_input('Title', '_alsalam_inquiry_step1_title', $meta('_alsalam_inquiry_step1_title', 'Commercial & Business Profile'));
        alsalam_render_meta_textarea('Description', '_alsalam_inquiry_step1_desc', $meta('_alsalam_inquiry_step1_desc', 'Please provide credential details for clinical vetting and registration.'));
        echo '</div>';

        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-clipboard"></span> Step 2: Clinical Inquiry Details</div>';
        echo '<div class="alsalam-form-row" style="background:#fff; border:1px solid #e2e8f0; padding:15px; border-radius:6px;">';
        alsalam_render_meta_input('Badge (Top small text)', '_alsalam_inquiry_step2_badge', $meta('_alsalam_inquiry_step2_badge', '2. Clinical Inquiry'));
        alsalam_render_meta_input('Title', '_alsalam_inquiry_step2_title', $meta('_alsalam_inquiry_step2_title', 'Clinical Inquiry Details'));
        alsalam_render_meta_textarea('Description', '_alsalam_inquiry_step2_desc', $meta('_alsalam_inquiry_step2_desc', 'Specify your clinical requests, products of interest, and volume demands.'));
        echo '</div>';
        
        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-thumbs-up"></span> Form Configuration</div>';
        echo '<div class="alsalam-form-row" style="background:#fff; border:1px solid #e2e8f0; padding:15px; border-radius:6px;">';
        alsalam_render_meta_textarea('Success Message Alert', '_alsalam_inquiry_success_alert', $meta('_alsalam_inquiry_success_alert', 'Thank you! Your commercial inquiry has been registered. Our procurement team will review your business credentials.'));
        echo '</div>';

        echo '</div>';
    }

    // --- TAB: ABOUT ---
    if ($template === 'page-about.php') {
        // Corporate Profile
        echo '<div id="tab-about-corp" class="alsalam-tab-content">';
        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-building"></span> Corporate Profile</div>';
        alsalam_render_meta_input('Badge', '_alsalam_about_corp_profile_badge', $meta('_alsalam_about_corp_profile_badge'));
        alsalam_render_meta_input('Title', '_alsalam_about_corp_profile_title', $meta('_alsalam_about_corp_profile_title'));
        alsalam_render_meta_textarea('Description 1', '_alsalam_about_corp_profile_desc1', $meta('_alsalam_about_corp_profile_desc1'));
        alsalam_render_meta_textarea('Description 2', '_alsalam_about_corp_profile_desc2', $meta('_alsalam_about_corp_profile_desc2'));
        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-yes-alt"></span> Standards</div>';
        alsalam_render_meta_input('Standards Title', '_alsalam_about_standards_title', $meta('_alsalam_about_standards_title'));
        alsalam_render_meta_textarea('Standards Desc', '_alsalam_about_standards_desc', $meta('_alsalam_about_standards_desc'));
        alsalam_render_meta_input('Aseptic Title', '_alsalam_about_aseptic_title', $meta('_alsalam_about_aseptic_title'));
        alsalam_render_meta_textarea('Aseptic Desc', '_alsalam_about_aseptic_desc', $meta('_alsalam_about_aseptic_desc'));
        echo '</div>';

        // Vision & Mission
        echo '<div id="tab-about-vision" class="alsalam-tab-content">';
        alsalam_render_meta_input('Main Section Title', '_alsalam_about_purpose_title', $meta('_alsalam_about_purpose_title'));
        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-visibility"></span> Vision</div>';
        alsalam_render_meta_input('Vision Title', '_alsalam_about_vision_title', $meta('_alsalam_about_vision_title'));
        alsalam_render_meta_textarea('Vision Desc', '_alsalam_about_vision_desc', $meta('_alsalam_about_vision_desc'));
        alsalam_render_meta_input('Vision Badge', '_alsalam_about_vision_badge', $meta('_alsalam_about_vision_badge'));
        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-flag"></span> Mission</div>';
        alsalam_render_meta_input('Mission Title', '_alsalam_about_mission_title', $meta('_alsalam_about_mission_title'));
        alsalam_render_meta_textarea('Mission Desc', '_alsalam_about_mission_desc', $meta('_alsalam_about_mission_desc'));
        alsalam_render_meta_input('Mission Badge', '_alsalam_about_mission_badge', $meta('_alsalam_about_mission_badge'));
        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-heart"></span> Values</div>';
        alsalam_render_meta_input('Values Title', '_alsalam_about_values_title', $meta('_alsalam_about_values_title'));
        alsalam_render_meta_input('Value 1', '_alsalam_about_values_val1', $meta('_alsalam_about_values_val1'));
        alsalam_render_meta_input('Value 2', '_alsalam_about_values_val2', $meta('_alsalam_about_values_val2'));
        alsalam_render_meta_input('Value 3', '_alsalam_about_values_val3', $meta('_alsalam_about_values_val3'));
        alsalam_render_meta_input('Values Badge', '_alsalam_about_values_badge', $meta('_alsalam_about_values_badge'));
        echo '</div>';

        // Metrics & CTA
        echo '<div id="tab-about-metrics" class="alsalam-tab-content">';
        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-chart-bar"></span> Capabilities Header</div>';
        alsalam_render_meta_input('Badge', '_alsalam_about_cap_badge', $meta('_alsalam_about_cap_badge'));
        alsalam_render_meta_input('Title', '_alsalam_about_cap_title', $meta('_alsalam_about_cap_title'));
        alsalam_render_meta_textarea('Description', '_alsalam_about_cap_desc', $meta('_alsalam_about_cap_desc'));
        
        for ($i=1; $i<=4; $i++) {
            echo '<div class="alsalam-section-title"><span class="dashicons dashicons-plus-alt2"></span> Metric ' . $i . '</div>';
            alsalam_render_meta_input("Value $i", "_alsalam_about_metric{$i}_val", $meta("_alsalam_about_metric{$i}_val"));
            alsalam_render_meta_input("Title $i", "_alsalam_about_metric{$i}_title", $meta("_alsalam_about_metric{$i}_title"));
            alsalam_render_meta_input("Desc $i", "_alsalam_about_metric{$i}_desc", $meta("_alsalam_about_metric{$i}_desc"));
        }

        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-megaphone"></span> Call to Action</div>';
        alsalam_render_meta_input('CTA Title', '_alsalam_about_cta_title', $meta('_alsalam_about_cta_title'));
        alsalam_render_meta_textarea('CTA Desc', '_alsalam_about_cta_desc', $meta('_alsalam_about_cta_desc'));
        alsalam_render_meta_input('Button Text', '_alsalam_submit_inquiry_btn', $meta('_alsalam_submit_inquiry_btn'));
        echo '</div>';
    }

    // --- TAB: CONTACT ---
    if ($template === 'page-contact.php') {
        echo '<div id="tab-contact" class="alsalam-tab-content">';
        
        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-location"></span> 1. Facility Location Card</div>';
        alsalam_render_meta_input('Facility Title', '_alsalam_contact_facility_title', $meta('_alsalam_contact_facility_title', 'Our Facility'));
        alsalam_render_meta_textarea('Facility Description', '_alsalam_contact_facility_desc', $meta('_alsalam_contact_facility_desc', 'AL-SALAM Pharmaceutical Plant, Industrial Zone, Baghdad, Iraq.'));
        
        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-phone"></span> 2. Phone Numbers Card</div>';
        alsalam_render_meta_input('Phone Title', '_alsalam_contact_phone_title', $meta('_alsalam_contact_phone_title', 'Call Us Direct'));
        alsalam_render_meta_textarea('Phone Description', '_alsalam_contact_phone_desc', $meta('_alsalam_contact_phone_desc', 'Our customer support and clinical representatives are available.'));
        
        // Repeater for Phones
        $phones = get_post_meta($post->ID, '_alsalam_contact_phones', true);
        if (empty($phones)) $phones = ['+964 770 000 0000', '+964 780 000 0000'];
        alsalam_render_meta_repeater('Phone Numbers', '_alsalam_contact_phones', $phones, '+964 XXXXXXXXX');

        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-email-alt"></span> 3. Email Channels Card</div>';
        alsalam_render_meta_input('Email Title', '_alsalam_contact_email_title', $meta('_alsalam_contact_email_title', 'Email Channels'));
        alsalam_render_meta_textarea('Email Description', '_alsalam_contact_email_desc', $meta('_alsalam_contact_email_desc', 'Drop us a message and our specialists will respond within 24 hours.'));
        
        // Repeater for Emails
        $emails = get_post_meta($post->ID, '_alsalam_contact_emails', true);
        if (empty($emails)) $emails = ['info@alsalam-pharma.com', 'sales@alsalam-pharma.com'];
        alsalam_render_meta_repeater('Email Addresses', '_alsalam_contact_emails', $emails, 'mail@company.com');

        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-clock"></span> 4. Working Hours Card</div>';
        alsalam_render_meta_input('Hours Title', '_alsalam_contact_hours_title', $meta('_alsalam_contact_hours_title', 'Shift Schedules'));
        alsalam_render_meta_textarea('Hours Description', '_alsalam_contact_hours_desc', $meta('_alsalam_contact_hours_desc', 'Our offices are active during corporate weekdays.'));
        alsalam_render_meta_input('Working Hours Value', '_alsalam_contact_hours_val', $meta('_alsalam_contact_hours_val', 'Sun - Thu: 8:00 AM - 4:00 PM'));
        alsalam_render_meta_input('Closed Days Text', '_alsalam_contact_hours_closed', $meta('_alsalam_contact_hours_closed', 'Closed on Friday & Saturday'));

        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-feedback"></span> 5. Contact Form Section</div>';
        alsalam_render_meta_input('Form Badge', '_alsalam_contact_form_badge', $meta('_alsalam_contact_form_badge', 'Message Us'));
        alsalam_render_meta_input('Form Title', '_alsalam_contact_form_title', $meta('_alsalam_contact_form_title', 'Send a Direct Message'));
        alsalam_render_meta_textarea('Form Description', '_alsalam_contact_form_desc', $meta('_alsalam_contact_form_desc', 'Please complete the form below. Our corporate relations team will route your inquiry to the appropriate medical or commercial specialist.'));

        echo '<div class="alsalam-section-title"><span class="dashicons dashicons-admin-site-alt3"></span> 6. Map Section</div>';
        alsalam_render_meta_input('Map Badge', '_alsalam_contact_map_badge', $meta('_alsalam_contact_map_badge', 'Interactive Center'));
        alsalam_render_meta_input('Map Title', '_alsalam_contact_map_title', $meta('_alsalam_contact_map_title', 'Clinical Logistics'));
        alsalam_render_meta_textarea('Map Description', '_alsalam_contact_map_desc', $meta('_alsalam_contact_map_desc', 'Direct shipping corridors connecting to critical hospital supply lines.'));
        alsalam_render_meta_input('Map Co-ordinates Title', '_alsalam_contact_map_coords', $meta('_alsalam_contact_map_coords', 'Co-ordinates'));
        alsalam_render_meta_input('Map GMP Title', '_alsalam_contact_map_gmp', $meta('_alsalam_contact_map_gmp', 'GMP Zone'));
        alsalam_render_meta_input('Map Class A Text', '_alsalam_contact_map_classa', $meta('_alsalam_contact_map_classa', 'Class A Certified'));

        echo '</div>';
    }
}

// Helpers for rendering fields
function alsalam_render_meta_input($label, $name, $value) {
    echo '<div class="alsalam-form-row"><label>' . esc_html($label) . '</label>';
    echo '<input type="text" name="' . esc_attr($name) . '" value="' . esc_attr($value) . '" /></div>';
}

function alsalam_render_meta_textarea($label, $name, $value) {
    echo '<div class="alsalam-form-row"><label>' . esc_html($label) . '</label>';
    echo '<textarea name="' . esc_attr($name) . '" rows="3">' . esc_textarea($value) . '</textarea></div>';
}

function alsalam_render_meta_repeater($label, $name, $values, $placeholder = '') {
    if (!is_array($values)) $values = (array)$values;
    if (empty($values)) $values = ['']; // Initial empty row if nothing
    
    echo '<div class="alsalam-form-row alsalam-repeater-field" data-name="' . esc_attr($name) . '" data-placeholder="' . esc_attr($placeholder) . '">';
    echo '<label>' . esc_html($label) . '</label>';
    echo '<div class="alsalam-repeater-items">';
    foreach ($values as $val) {
        echo '<div class="alsalam-repeater-item">';
        echo '<span class="dashicons dashicons-menu" style="color:#94a3b8; cursor:grab;"></span>';
        echo '<input type="text" name="' . esc_attr($name) . '[]" value="' . esc_attr($val) . '" placeholder="' . esc_attr($placeholder) . '"/>';
        echo '<button type="button" class="button alsalam-remove-row" title="Remove">&times;</button>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" class="button alsalam-add-row"><span class="dashicons dashicons-plus" style="margin-top:3px;"></span> Add Item</button>';
    echo '</div>';
}

// 3. Save Metabox
add_action('save_post', 'alsalam_save_page_meta');
function alsalam_save_page_meta($post_id) {
    if (!isset($_POST['alsalam_page_meta_nonce']) || !wp_verify_nonce($_POST['alsalam_page_meta_nonce'], 'alsalam_save_page_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_page', $post_id)) return;
    
    $show_hero = isset($_POST['alsalam_show_hero']) ? '1' : '0';
    update_post_meta($post_id, '_alsalam_show_hero', $show_hero);
    
    // List of all possible text fields
    $fields = [
        '_alsalam_hero_title',
        '_alsalam_hero_subtitle',
        
        // About Page
        '_alsalam_about_corp_profile_badge', '_alsalam_about_corp_profile_title', '_alsalam_about_corp_profile_desc1', '_alsalam_about_corp_profile_desc2',
        '_alsalam_about_standards_title', '_alsalam_about_standards_desc', '_alsalam_about_aseptic_title', '_alsalam_about_aseptic_desc',
        '_alsalam_about_purpose_title', '_alsalam_about_vision_title', '_alsalam_about_vision_desc', '_alsalam_about_vision_badge',
        '_alsalam_about_mission_title', '_alsalam_about_mission_desc', '_alsalam_about_mission_badge',
        '_alsalam_about_values_title', '_alsalam_about_values_val1', '_alsalam_about_values_val2', '_alsalam_about_values_val3', '_alsalam_about_values_badge',
        '_alsalam_about_cap_badge', '_alsalam_about_cap_title', '_alsalam_about_cap_desc',
        '_alsalam_about_cta_title', '_alsalam_about_cta_desc', '_alsalam_submit_inquiry_btn',
        '_alsalam_about_metric1_val', '_alsalam_about_metric1_title', '_alsalam_about_metric1_desc',
        '_alsalam_about_metric2_val', '_alsalam_about_metric2_title', '_alsalam_about_metric2_desc',
        '_alsalam_about_metric3_val', '_alsalam_about_metric3_title', '_alsalam_about_metric3_desc',
        '_alsalam_about_metric4_val', '_alsalam_about_metric4_title', '_alsalam_about_metric4_desc',
        
        // Contact Page Scalar Fields
        '_alsalam_contact_facility_title', '_alsalam_contact_facility_desc',
        '_alsalam_contact_phone_title', '_alsalam_contact_phone_desc',
        '_alsalam_contact_email_title', '_alsalam_contact_email_desc',
        '_alsalam_contact_hours_title', '_alsalam_contact_hours_desc', '_alsalam_contact_hours_val', '_alsalam_contact_hours_closed',
        '_alsalam_contact_form_badge', '_alsalam_contact_form_title', '_alsalam_contact_form_desc',
        '_alsalam_contact_map_badge', '_alsalam_contact_map_title', '_alsalam_contact_map_desc', '_alsalam_contact_map_coords', '_alsalam_contact_map_gmp', '_alsalam_contact_map_classa',
        
        // Inquiry Page Scalar Fields
        '_alsalam_inquiry_step1_badge', '_alsalam_inquiry_step1_title', '_alsalam_inquiry_step1_desc',
        '_alsalam_inquiry_step2_badge', '_alsalam_inquiry_step2_title', '_alsalam_inquiry_step2_desc',
        '_alsalam_inquiry_success_alert'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, wp_kses_post($_POST[$field])); // Using kses_post to allow basic HTML (strong, span)
        } else {
            // Delete meta if it's completely empty or missing from POST
            delete_post_meta($post_id, $field);
        }
    }

    // Save Repeater Fields
    $repeaters = ['_alsalam_contact_phones', '_alsalam_contact_emails'];
    foreach ($repeaters as $rep) {
        if (isset($_POST[$rep]) && is_array($_POST[$rep])) {
            // Sanitize each item and remove empty rows
            $clean_arr = array_filter(array_map('sanitize_text_field', $_POST[$rep]), function($v) {
                return trim($v) !== '';
            });
            update_post_meta($post_id, $rep, array_values($clean_arr));
        } else {
            delete_post_meta($post_id, $rep);
        }
    }
}
