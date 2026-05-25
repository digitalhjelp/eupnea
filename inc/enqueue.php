<?php
/**
 * Skript og stilark
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

function eupnea_enqueue_assets(): void {
    // Google Fonts
    wp_enqueue_style(
        'eupnea-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap',
        [],
        null
    );

    // Hoved-CSS
    wp_enqueue_style(
        'eupnea-main',
        EUPNEA_URI . '/assets/css/main.css',
        ['eupnea-fonts'],
        EUPNEA_VERSION
    );

    // Forside v2 – last kun på sider med malen "Forside v2"
    if (is_page_template('template-forside-v2.php')) {
        wp_enqueue_style(
            'eupnea-forside-v2',
            EUPNEA_URI . '/assets/css/forside-v2.css',
            ['eupnea-main'],
            EUPNEA_VERSION
        );
    }

    // Hoved-JS
    wp_enqueue_script(
        'eupnea-main',
        EUPNEA_URI . '/assets/js/main.js',
        [],
        EUPNEA_VERSION,
        true
    );

    // Gjør tema-data tilgjengelig for JS
    wp_localize_script('eupnea-main', 'eupneaData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('eupnea_nonce'),
        'siteUrl' => get_site_url(),
    ]);

    // Comment reply (bare på enkeltinnlegg)
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'eupnea_enqueue_assets');

// Admin-stilark
function eupnea_admin_styles(): void {
    wp_enqueue_style(
        'eupnea-admin',
        EUPNEA_URI . '/assets/css/admin.css',
        [],
        EUPNEA_VERSION
    );
}
add_action('admin_enqueue_scripts', 'eupnea_admin_styles');
