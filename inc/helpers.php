<?php
/**
 * Hjelpefunksjoner
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

/**
 * Henter ACF-opsjon med fallback.
 */
function eupnea_option(string $key, mixed $fallback = ''): mixed {
    if (function_exists('get_field')) {
        $value = get_field($key, 'option');
        return ($value !== '' && $value !== null && $value !== false) ? $value : $fallback;
    }
    return $fallback;
}

/**
 * Rendrer en ACF-bildearray som <img>-tag.
 */
function eupnea_image(array|int|null $image, string $size = 'large', string $class = '', string $alt = ''): string {
    if (empty($image)) {
        return '';
    }

    if (is_numeric($image)) {
        $image = wp_get_attachment_image_src($image, $size);
        if (!$image) return '';
        $src = $image[0];
        $width  = $image[1];
        $height = $image[2];
        $alt_text = $alt ?: '';
    } else {
        $src    = $image['sizes'][$size] ?? $image['url'] ?? '';
        $width  = $image['sizes']["{$size}-width"]  ?? $image['width']  ?? '';
        $height = $image['sizes']["{$size}-height"] ?? $image['height'] ?? '';
        $alt_text = $alt ?: ($image['alt'] ?? '');
    }

    $class_attr = $class ? ' class="' . esc_attr($class) . '"' : '';

    return sprintf(
        '<img src="%s" alt="%s" width="%s" height="%s"%s loading="lazy">',
        esc_url($src),
        esc_attr($alt_text),
        esc_attr((string) $width),
        esc_attr((string) $height),
        $class_attr
    );
}

/**
 * Rendrer en CTA-knapp.
 */
function eupnea_button(string $label, string $url, string $style = 'primary', string $extra_class = '', bool $new_tab = false): string {
    if (empty($label) || empty($url)) return '';

    $target = $new_tab ? ' target="_blank" rel="noopener noreferrer"' : '';
    $classes = implode(' ', array_filter([
        'btn',
        "btn--{$style}",
        $extra_class,
    ]));

    return sprintf(
        '<a href="%s" class="%s"%s>%s</a>',
        esc_url($url),
        esc_attr($classes),
        $target,
        esc_html($label)
    );
}

/**
 * Wrapper for get_the_content med spesifisert post.
 */
function eupnea_content(int $post_id = 0): string {
    $post = $post_id ? get_post($post_id) : get_post();
    if (!$post) return '';
    setup_postdata($post);
    ob_start();
    the_content();
    return ob_get_clean();
}

/**
 * Renser streng for bruk som CSS-klasse.
 */
function eupnea_slug(string $str): string {
    return sanitize_title($str);
}

/**
 * Henter sosiale medier-lenker fra ACF-opsjoner.
 */
function eupnea_social_links(): array {
    $networks = ['facebook', 'instagram', 'linkedin', 'twitter', 'youtube'];
    $links    = [];

    foreach ($networks as $network) {
        $url = eupnea_option("social_{$network}");
        if ($url) {
            $links[$network] = $url;
        }
    }

    return $links;
}

/**
 * Ikoner for sosiale nettverk (inline SVG).
 */
function eupnea_social_icon(string $network): string {
    $icons = [
        'facebook'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
        'instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
        'linkedin'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>',
        'twitter'   => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>',
        'youtube'   => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon fill="white" points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>',
    ];

    return $icons[$network] ?? '';
}
