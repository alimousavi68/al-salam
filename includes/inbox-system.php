<?php
/**
 * AL-SALAM Form Inbox System
 * Registers a hidden Custom Post Type 'alsalam_message' to serve as a central Admin Inbox for form submissions.
 */

defined('ABSPATH') || exit;

// 1. Register Custom Post Type & Taxonomy for Messages
add_action('init', 'alsalam_register_inbox_cpt');
function alsalam_register_inbox_cpt() {
    $labels = [
        'name'               => __('Form Inbox', 'alsalam'),
        'singular_name'      => __('Message', 'alsalam'),
        'menu_name'          => __('Inbox', 'alsalam'),
        'all_items'          => __('All Messages', 'alsalam'),
        'view_item'          => __('View Message', 'alsalam'),
        'search_items'       => __('Search Messages', 'alsalam'),
        'not_found'          => __('No messages found.', 'alsalam'),
        'not_found_in_trash' => __('No messages found in Trash.', 'alsalam')
    ];

    $args = [
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-email-alt',
        'supports'           => ['title', 'editor', 'custom-fields']
    ];

    register_post_type('alsalam_message', $args);

    // Taxonomy for Form Type (Contact, Inquiry, Join Us)
    register_taxonomy('message_type', 'alsalam_message', [
        'labels' => [
            'name' => __('Form Type', 'alsalam'),
            'singular_name' => __('Form Type', 'alsalam'),
        ],
        'public' => false,
        'show_ui' => true,
        'hierarchical' => true,
    ]);
}

// 2. Custom Columns in Admin List Table
add_filter('manage_alsalam_message_posts_columns', 'alsalam_inbox_columns');
function alsalam_inbox_columns($columns) {
    $new_columns = [
        'cb'           => $columns['cb'],
        'title'        => __('Sender / Subject', 'alsalam'),
        'form_type'    => __('Form Type', 'alsalam'),
        'email_phone'  => __('Contact Info', 'alsalam'),
        'date'         => $columns['date']
    ];
    return $new_columns;
}

add_action('manage_alsalam_message_posts_custom_column', 'alsalam_inbox_column_content', 10, 2);
function alsalam_inbox_column_content($column, $post_id) {
    switch ($column) {
        case 'form_type':
            $terms = get_the_terms($post_id, 'message_type');
            if ($terms && !is_wp_error($terms)) {
                $types = array_map(function($t) { return $t->name; }, $terms);
                echo '<strong>' . esc_html(implode(', ', $types)) . '</strong>';
            } else {
                echo '—';
            }
            break;
        case 'email_phone':
            $email = get_post_meta($post_id, '_alsalam_sender_email', true);
            $phone = get_post_meta($post_id, '_alsalam_sender_phone', true);
            if ($email) echo '<div>📧 ' . esc_html($email) . '</div>';
            if ($phone) echo '<div>📞 ' . esc_html($phone) . '</div>';
            break;
    }
}

// 3. Custom Details Metabox for Single Message View
add_action('add_meta_boxes', 'alsalam_add_message_metabox');
function alsalam_add_message_metabox() {
    add_meta_box(
        'alsalam_message_details',
        __('Submission Metadata & Details', 'alsalam'),
        'alsalam_message_details_html',
        'alsalam_message',
        'normal',
        'high'
    );
}

function alsalam_message_details_html($post) {
    $all_meta = get_post_meta($post->ID);
    echo '<style>
        .alsalam-inbox-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .alsalam-inbox-table th, .alsalam-inbox-table td { padding: 12px 15px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        .alsalam-inbox-table th { background: #f8fafc; width: 220px; color: #475569; }
    </style>';

    echo '<table class="alsalam-inbox-table">';
    foreach ($all_meta as $key => $values) {
        if (strpos($key, '_alsalam_msg_') === 0 || strpos($key, '_alsalam_sender_') === 0) {
            $label = ucwords(str_replace(['_alsalam_msg_', '_alsalam_sender_', '_'], [' ', ' ', ' '], $key));
            $val = esc_html($values[0]);
            echo '<tr><th>' . esc_html($label) . '</th><td>' . nl2br($val) . '</td></tr>';
        }
    }
    echo '</table>';
}

// 4. AJAX Handlers for Front-end Submissions
// --- Contact Form AJAX ---
add_action('wp_ajax_alsalam_submit_contact', 'alsalam_handle_contact_submission');
add_action('wp_ajax_nopriv_alsalam_submit_contact', 'alsalam_handle_contact_submission');

function alsalam_handle_contact_submission() {
    check_ajax_referer('alsalam_contact_submit', 'nonce');

    $name    = sanitize_text_field($_POST['name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $phone   = sanitize_text_field($_POST['phone'] ?? '');
    $subject = sanitize_text_field($_POST['subject'] ?? 'Direct Contact Message');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(['message' => __('Please fill out all required fields.', 'alsalam')]);
    }

    $post_id = wp_insert_post([
        'post_title'   => "Contact: {$name} - {$subject}",
        'post_content' => $message,
        'post_status'  => 'publish',
        'post_type'    => 'alsalam_message'
    ]);

    if (!is_wp_error($post_id)) {
        wp_set_object_terms($post_id, 'Contact Form', 'message_type');
        update_post_meta($post_id, '_alsalam_sender_name', $name);
        update_post_meta($post_id, '_alsalam_sender_email', $email);
        update_post_meta($post_id, '_alsalam_sender_phone', $phone);
        update_post_meta($post_id, '_alsalam_msg_subject', $subject);

        wp_send_json_success(['message' => __('Thank you! Your message has been sent successfully.', 'alsalam')]);
    } else {
        wp_send_json_error(['message' => __('Could not save submission.', 'alsalam')]);
    }
}

// --- Inquiry Form AJAX ---
add_action('wp_ajax_alsalam_submit_inquiry', 'alsalam_handle_inquiry_submission');
add_action('wp_ajax_nopriv_alsalam_submit_inquiry', 'alsalam_handle_inquiry_submission');

function alsalam_handle_inquiry_submission() {
    check_ajax_referer('alsalam_inquiry_submit', 'alsalam_inquiry_nonce');

    $company_name     = sanitize_text_field($_POST['company_name'] ?? '');
    $country          = sanitize_text_field($_POST['country'] ?? '');
    $contact_name     = sanitize_text_field($_POST['contact_name'] ?? '');
    $job_title        = sanitize_text_field($_POST['job_title'] ?? '');
    $phone            = sanitize_text_field($_POST['phone'] ?? '');
    $website          = sanitize_url($_POST['website'] ?? '');
    $inquiry_type     = sanitize_text_field($_POST['inquiry_type'] ?? '');
    $product_interest = sanitize_text_field($_POST['product_interest'] ?? '');
    $volume           = sanitize_text_field($_POST['volume'] ?? '');
    $specifications   = sanitize_textarea_field($_POST['specifications'] ?? '');

    if (empty($company_name) || empty($contact_name) || empty($phone) || empty($specifications)) {
        wp_send_json_error(['message' => __('Please fill out all required fields.', 'alsalam')]);
    }

    $post_id = wp_insert_post([
        'post_title'   => "Inquiry: {$company_name} ({$contact_name})",
        'post_content' => $specifications,
        'post_status'  => 'publish',
        'post_type'    => 'alsalam_message'
    ]);

    if (!is_wp_error($post_id)) {
        wp_set_object_terms($post_id, 'Request Inquiry', 'message_type');
        update_post_meta($post_id, '_alsalam_msg_company_name', $company_name);
        update_post_meta($post_id, '_alsalam_msg_country', $country);
        update_post_meta($post_id, '_alsalam_sender_name', $contact_name);
        update_post_meta($post_id, '_alsalam_msg_job_title', $job_title);
        update_post_meta($post_id, '_alsalam_sender_phone', $phone);
        update_post_meta($post_id, '_alsalam_msg_website', $website);
        update_post_meta($post_id, '_alsalam_msg_inquiry_type', $inquiry_type);
        update_post_meta($post_id, '_alsalam_msg_product_interest', $product_interest);
        update_post_meta($post_id, '_alsalam_msg_estimated_volume', $volume);

        wp_send_json_success(['message' => __('Thank you! Your commercial inquiry has been registered.', 'alsalam')]);
    } else {
        wp_send_json_error(['message' => __('Could not save submission.', 'alsalam')]);
    }
}
