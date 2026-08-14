<?php
/**
 * Security, rate limiting, and sanitization functions
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

/**
 * Verify nonce and referer
 */
function alsalam_verify_nonce($action, $nonce_name) {
    if (!isset($_REQUEST[$nonce_name]) || !wp_verify_nonce($_REQUEST[$nonce_name], $action)) {
        wp_send_json_error(array('message' => esc_html__('Security check failed.', 'alsalam')));
    }
}
