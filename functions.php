<?php
/**
 * Eupnea Theme – Hovedfunksjoner
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

define('EUPNEA_VERSION', '1.3.1');
define('EUPNEA_DIR', get_template_directory());
define('EUPNEA_URI', get_template_directory_uri());

// ──────────────────────────────────────────────
// Last inn del-filer
// ──────────────────────────────────────────────
require_once EUPNEA_DIR . '/inc/enqueue.php';
require_once EUPNEA_DIR . '/inc/helpers.php';
require_once EUPNEA_DIR . '/inc/admin-menu.php';
require_once EUPNEA_DIR . '/inc/acf-fields.php';
require_once EUPNEA_DIR . '/inc/acf-options.php';
require_once EUPNEA_DIR . '/inc/post-types.php';
require_once EUPNEA_DIR . '/inc/acf-cpt-fields.php';

// ──────────────────────────────────────────────
// Tema-støtte
// ──────────────────────────────────────────────
function eupnea_setup(): void {
    load_theme_textdomain('eupnea', EUPNEA_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ]);
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');

    // Navigasjonsmenyer
    register_nav_menus([
        'primary'  => __('Primærnavigasjon', 'eupnea'),
        'footer'   => __('Bunntekst-navigasjon', 'eupnea'),
        'topbar'   => __('Toppfelt', 'eupnea'),
    ]);
}
add_action('after_setup_theme', 'eupnea_setup');

// ──────────────────────────────────────────────
// Widget-områder
// ──────────────────────────────────────────────
function eupnea_widgets_init(): void {
    register_sidebar([
        'name'          => __('Sidefelt', 'eupnea'),
        'id'            => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => __('Bunntekst – Kolonne 1', 'eupnea'),
        'id'            => 'footer-1',
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget__title">',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'eupnea_widgets_init');

// ──────────────────────────────────────────────
// Fjern WordPress-versjon fra <head>
// ──────────────────────────────────────────────
remove_action('wp_head', 'wp_generator');

// ──────────────────────────────────────────────
// Deaktiver Gutenberg for sider og CPT-er
// → ACF metabokser og Flexible Content fungerer da korrekt
// ──────────────────────────────────────────────
function eupnea_disable_gutenberg(bool $use_block_editor, WP_Post $post): bool {
    $classic_types = ['page', 'ansatt', 'mentor', 'partner', 'tilbakemelding'];
    if (in_array($post->post_type, $classic_types, true)) {
        return false;
    }
    return $use_block_editor;
}
add_filter('use_block_editor_for_post', 'eupnea_disable_gutenberg', 10, 2);
