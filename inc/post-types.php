<?php
/**
 * Custom Post Types – Ansatte, Mentorer, Partnere, Tilbakemeldinger
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

// ══════════════════════════════════════════════
// ANSATTE
// ══════════════════════════════════════════════
function eupnea_register_cpt_ansatte(): void {
    register_post_type('ansatt', [
        'labels' => [
            'name'               => 'Ansatte',
            'singular_name'      => 'Ansatt',
            'add_new'            => 'Legg til ansatt',
            'add_new_item'       => 'Legg til ny ansatt',
            'edit_item'          => 'Rediger ansatt',
            'new_item'           => 'Ny ansatt',
            'view_item'          => 'Vis ansatt',
            'search_items'       => 'Søk ansatte',
            'not_found'          => 'Ingen ansatte funnet',
            'not_found_in_trash' => 'Ingen ansatte i papirkurv',
            'menu_name'          => 'Ansatte',
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => ['title', 'thumbnail', 'page-attributes'],
        'has_archive'        => false,
        'rewrite'            => false,
        'show_in_rest'       => false,
    ]);
}
add_action('init', 'eupnea_register_cpt_ansatte');

// ══════════════════════════════════════════════
// MENTORER
// ══════════════════════════════════════════════
function eupnea_register_cpt_mentorer(): void {
    register_post_type('mentor', [
        'labels' => [
            'name'               => 'Mentorer',
            'singular_name'      => 'Mentor',
            'add_new'            => 'Legg til mentor',
            'add_new_item'       => 'Legg til ny mentor',
            'edit_item'          => 'Rediger mentor',
            'new_item'           => 'Ny mentor',
            'view_item'          => 'Vis mentor',
            'search_items'       => 'Søk mentorer',
            'not_found'          => 'Ingen mentorer funnet',
            'not_found_in_trash' => 'Ingen mentorer i papirkurv',
            'menu_name'          => 'Mentorer',
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => ['title', 'thumbnail', 'page-attributes'],
        'has_archive'        => false,
        'rewrite'            => false,
        'show_in_rest'       => false,
    ]);
}
add_action('init', 'eupnea_register_cpt_mentorer');

// ══════════════════════════════════════════════
// PARTNERE
// ══════════════════════════════════════════════
function eupnea_register_cpt_partnere(): void {
    register_post_type('partner', [
        'labels' => [
            'name'               => 'Partnere',
            'singular_name'      => 'Partner',
            'add_new'            => 'Legg til partner',
            'add_new_item'       => 'Legg til ny partner',
            'edit_item'          => 'Rediger partner',
            'new_item'           => 'Ny partner',
            'search_items'       => 'Søk partnere',
            'not_found'          => 'Ingen partnere funnet',
            'not_found_in_trash' => 'Ingen partnere i papirkurv',
            'menu_name'          => 'Partnere',
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 22,
        'menu_icon'          => 'dashicons-building',
        'supports'           => ['title', 'page-attributes'],
        'has_archive'        => false,
        'rewrite'            => false,
        'show_in_rest'       => false,
    ]);
}
add_action('init', 'eupnea_register_cpt_partnere');

// ══════════════════════════════════════════════
// TILBAKEMELDINGER
// ══════════════════════════════════════════════
function eupnea_register_cpt_tilbakemeldinger(): void {
    register_post_type('tilbakemelding', [
        'labels' => [
            'name'               => 'Tilbakemeldinger',
            'singular_name'      => 'Tilbakemelding',
            'add_new'            => 'Legg til tilbakemelding',
            'add_new_item'       => 'Legg til ny tilbakemelding',
            'edit_item'          => 'Rediger tilbakemelding',
            'new_item'           => 'Ny tilbakemelding',
            'search_items'       => 'Søk tilbakemeldinger',
            'not_found'          => 'Ingen tilbakemeldinger funnet',
            'not_found_in_trash' => 'Ingen tilbakemeldinger i papirkurv',
            'menu_name'          => 'Tilbakemeldinger',
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 23,
        'menu_icon'          => 'dashicons-format-quote',
        'supports'           => ['title', 'page-attributes'],
        'has_archive'        => false,
        'rewrite'            => false,
        'show_in_rest'       => false,
    ]);
}
add_action('init', 'eupnea_register_cpt_tilbakemeldinger');

// ══════════════════════════════════════════════
// Admin-kolonner: Ansatte
// ══════════════════════════════════════════════
add_filter('manage_ansatt_posts_columns', function($cols) {
    return [
        'cb'       => $cols['cb'],
        'thumb'    => 'Bilde',
        'title'    => 'Navn',
        'stilling' => 'Stilling',
        'order'    => 'Rekkefølge',
    ];
});
add_action('manage_ansatt_posts_custom_column', function($col, $post_id) {
    if ($col === 'thumb') {
        $img = get_the_post_thumbnail($post_id, [48, 48]);
        echo $img ? '<div style="width:48px;height:48px;overflow:hidden;border-radius:50%">' . $img . '</div>' : '—';
    }
    if ($col === 'stilling') echo esc_html(get_field('stilling', $post_id) ?: '—');
    if ($col === 'order')    echo esc_html(get_post_field('menu_order', $post_id));
}, 10, 2);

// Admin-kolonner: Mentorer
add_filter('manage_mentor_posts_columns', function($cols) {
    return [
        'cb'          => $cols['cb'],
        'thumb'       => 'Bilde',
        'title'       => 'Navn',
        'kompetanse'  => 'Kompetanseområde',
    ];
});
add_action('manage_mentor_posts_custom_column', function($col, $post_id) {
    if ($col === 'thumb') {
        $img = get_the_post_thumbnail($post_id, [48, 48]);
        echo $img ? '<div style="width:48px;height:48px;overflow:hidden;border-radius:50%">' . $img . '</div>' : '—';
    }
    if ($col === 'kompetanse') echo esc_html(get_field('kompetanse', $post_id) ?: '—');
}, 10, 2);

// Admin-kolonner: Partnere
add_filter('manage_partner_posts_columns', function($cols) {
    return [
        'cb'    => $cols['cb'],
        'logo'  => 'Logo',
        'title' => 'Navn',
        'url'   => 'Nettside',
    ];
});
add_action('manage_partner_posts_custom_column', function($col, $post_id) {
    if ($col === 'logo') {
        $logo = get_field('logo', $post_id);
        if ($logo) {
            $src = $logo['sizes']['thumbnail'] ?? $logo['url'] ?? '';
            echo '<img src="' . esc_url($src) . '" style="height:36px;width:auto;object-fit:contain">';
        } else {
            echo '—';
        }
    }
    if ($col === 'url') {
        $url = get_field('partner_url', $post_id);
        echo $url ? '<a href="' . esc_url($url) . '" target="_blank">' . esc_html(parse_url($url, PHP_URL_HOST)) . '</a>' : '—';
    }
}, 10, 2);

// Admin-kolonner: Tilbakemeldinger
add_filter('manage_tilbakemelding_posts_columns', function($cols) {
    return [
        'cb'       => $cols['cb'],
        'title'    => 'Navn',
        'sitat'    => 'Sitat (utdrag)',
        'stjerner' => 'Stjerner',
    ];
});
add_action('manage_tilbakemelding_posts_custom_column', function($col, $post_id) {
    if ($col === 'sitat') {
        $q = get_field('sitat', $post_id);
        echo esc_html($q ? mb_substr($q, 0, 80) . '…' : '—');
    }
    if ($col === 'stjerner') {
        $r = (int) get_field('stjerner', $post_id);
        echo str_repeat('★', $r) . str_repeat('☆', 5 - $r);
    }
}, 10, 2);

// Sorter etter menu_order som standard
add_filter('pre_get_posts', function($query) {
    if (!is_admin() || !$query->is_main_query()) return;
    $types = ['ansatt', 'mentor', 'partner', 'tilbakemelding'];
    if (in_array($query->get('post_type'), $types)) {
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
    }
});

// ══════════════════════════════════════════════
// Tips om rekkefølge i CPT-editoren
// ══════════════════════════════════════════════
function eupnea_cpt_order_tip(): void {
    global $post;
    if (!$post) return;
    $types = ['ansatt', 'mentor', 'partner', 'tilbakemelding'];
    if (!in_array($post->post_type, $types, true)) return;
    ?>
    <div class="eupnea-order-tip">
        💡 <strong>Rekkefølge:</strong>
        Endre «Sidens rekkefølge»-feltet (under Publiser-boksen, «Attributter»)
        for å styre visningsrekkefølgen på nettsiden. Lavest tall vises først.
    </div>
    <?php
}
add_action('edit_form_after_title', 'eupnea_cpt_order_tip');
