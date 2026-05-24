<?php
/**
 * Eupnea Theme – Hovedfunksjoner
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

define('EUPNEA_VERSION', '1.4.3');
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
// Deaktiver Gutenberg fullstendig for sider og CPT-er
// Bruker ALLE kjente filtre for maksimal kompatibilitet
// ──────────────────────────────────────────────
$eupnea_classic_types = ['page', 'ansatt', 'mentor', 'partner', 'tilbakemelding'];

// Filter 1: WordPress core (post-objekt)
add_filter('use_block_editor_for_post', function ($use, $post) use ($eupnea_classic_types) {
    return in_array($post->post_type, $eupnea_classic_types, true) ? false : $use;
}, 999, 2);

// Filter 2: WordPress core (post-type streng) – mest pålitelig
add_filter('use_block_editor_for_post_type', function ($use, $post_type) use ($eupnea_classic_types) {
    return in_array($post_type, $eupnea_classic_types, true) ? false : $use;
}, 999, 2);

// Filter 3: Gutenberg-pluginet (hvis installert)
add_filter('gutenberg_can_edit_post_type', function ($use, $post_type) use ($eupnea_classic_types) {
    return in_array($post_type, $eupnea_classic_types, true) ? false : $use;
}, 999, 2);

add_filter('gutenberg_can_edit_post', function ($use, $post) use ($eupnea_classic_types) {
    return in_array($post->post_type, $eupnea_classic_types, true) ? false : $use;
}, 999, 2);

// ──────────────────────────────────────────────
// Admin-varsel + redirect hvis Gutenberg likevel lastes
// ──────────────────────────────────────────────
add_action('admin_init', function () use ($eupnea_classic_types) {
    // Redirect til klassisk editor hvis vi er i Gutenberg for en klassisk side
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen) return;

    global $pagenow;
    if (!in_array($pagenow, ['post.php', 'post-new.php'], true)) return;

    $post_id   = absint($_GET['post'] ?? 0);
    $post_type = $_GET['post_type'] ?? ($post_id ? get_post_type($post_id) : '');

    if (!in_array($post_type, $eupnea_classic_types, true)) return;

    // Hvis Gutenberg er aktivt for dette innlegget, redirect til klassisk URL
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && $post_id) {
        if (function_exists('use_block_editor_for_post') && use_block_editor_for_post($post_id)) {
            wp_redirect(admin_url("post.php?post={$post_id}&action=edit&classic-editor"));
            exit;
        }
    }
});

// Admin-varsel øverst på sider/CPT-editoren
add_action('admin_notices', function () use ($eupnea_classic_types) {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen || !in_array($screen->post_type, $eupnea_classic_types, true)) return;
    if (!in_array($screen->base, ['post'], true)) return;

    global $post;
    $classic_url = $post ? admin_url("post.php?post={$post->ID}&action=edit&classic-editor") : '';
    ?>
    <div class="notice notice-info eupnea-editor-notice" style="display:flex;align-items:center;gap:1rem;padding:0.75rem 1rem;">
        <span>🧩 <strong>Eupnea-moduler:</strong>
        Scroll ned til <strong>«Sidebygger – Moduler»</strong> under tekstfeltet og klikk <strong>«➕ Legg til modul»</strong>.</span>
        <?php if ($classic_url) : ?>
        <a href="<?php echo esc_url($classic_url); ?>" class="button button-small">
            Bytt til klassisk editor
        </a>
        <?php endif; ?>
    </div>
    <?php
});

