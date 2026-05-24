<?php
/**
 * Tilpasset admin-meny for Eupnea-temaet
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

// ──────────────────────────────────────────────
// Registrer admin-menyer
// ──────────────────────────────────────────────
function eupnea_admin_menu(): void {
    // Hoved-meny (topp-nivå)
    add_menu_page(
        __('Eupnea Innstillinger', 'eupnea'),
        __('Eupnea', 'eupnea'),
        'manage_options',
        'eupnea-settings',
        'eupnea_render_settings_page',
        eupnea_get_menu_icon(),
        3
    );

    // Undermenyer
    add_submenu_page(
        'eupnea-settings',
        __('Generelle innstillinger', 'eupnea'),
        __('Generelt', 'eupnea'),
        'manage_options',
        'eupnea-settings',
        'eupnea_render_settings_page'
    );

    add_submenu_page(
        'eupnea-settings',
        __('Kontaktinformasjon', 'eupnea'),
        __('Kontakt', 'eupnea'),
        'manage_options',
        'eupnea-contact-settings',
        'eupnea_render_contact_page'
    );

    add_submenu_page(
        'eupnea-settings',
        __('Sosiale medier', 'eupnea'),
        __('Sosiale medier', 'eupnea'),
        'manage_options',
        'eupnea-social-settings',
        'eupnea_render_social_page'
    );

    add_submenu_page(
        'eupnea-settings',
        __('Hurtigredigering av moduler', 'eupnea'),
        __('Moduler & hjelp', 'eupnea'),
        'manage_options',
        'eupnea-modules-help',
        'eupnea_render_modules_help_page'
    );
}
add_action('admin_menu', 'eupnea_admin_menu');

// ──────────────────────────────────────────────
// SVG-ikon for menyen
// ──────────────────────────────────────────────
function eupnea_get_menu_icon(): string {
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/><path d="M8 12c0-2.21 1.79-4 4-4s4 1.79 4 4-1.79 4-4 4-4-1.79-4-4z"/><path d="M12 8v-2M12 18v-2M8 12H6M18 12h-2"/></svg>';
    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}

// ──────────────────────────────────────────────
// Registrer WordPress-innstillinger
// ──────────────────────────────────────────────
function eupnea_register_settings(): void {
    // Generelle innstillinger
    register_setting('eupnea_general', 'eupnea_tagline',   ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('eupnea_general', 'eupnea_footer_text', ['sanitize_callback' => 'wp_kses_post']);
    register_setting('eupnea_general', 'eupnea_primary_color', ['sanitize_callback' => 'sanitize_hex_color', 'default' => '#0D3349']);
    register_setting('eupnea_general', 'eupnea_secondary_color', ['sanitize_callback' => 'sanitize_hex_color', 'default' => '#14B8A6']);
    register_setting('eupnea_general', 'eupnea_accent_color', ['sanitize_callback' => 'sanitize_hex_color', 'default' => '#F59E0B']);

    // Kontaktinnstillinger
    register_setting('eupnea_contact', 'eupnea_address',  ['sanitize_callback' => 'sanitize_textarea_field']);
    register_setting('eupnea_contact', 'eupnea_phone',    ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('eupnea_contact', 'eupnea_email',    ['sanitize_callback' => 'sanitize_email']);
    register_setting('eupnea_contact', 'eupnea_map_url',  ['sanitize_callback' => 'esc_url_raw']);

    // Sosiale medier
    foreach (['facebook', 'instagram', 'linkedin', 'twitter', 'youtube'] as $net) {
        register_setting('eupnea_social', "eupnea_social_{$net}", ['sanitize_callback' => 'esc_url_raw']);
    }
}
add_action('admin_init', 'eupnea_register_settings');

// ──────────────────────────────────────────────
// Dynamiske CSS-variabler basert på fargevalg
// ──────────────────────────────────────────────
function eupnea_dynamic_colors(): void {
    $primary   = get_option('eupnea_primary_color',   '#0D3349');
    $secondary = get_option('eupnea_secondary_color', '#14B8A6');
    $accent    = get_option('eupnea_accent_color',    '#F59E0B');

    // Konverter til RGB for alpha-støtte
    $primary_rgb   = eupnea_hex_to_rgb($primary);
    $secondary_rgb = eupnea_hex_to_rgb($secondary);
    $accent_rgb    = eupnea_hex_to_rgb($accent);

    echo "<style id=\"eupnea-dynamic-colors\">
    :root {
        --color-primary:       {$primary};
        --color-primary-rgb:   {$primary_rgb};
        --color-secondary:     {$secondary};
        --color-secondary-rgb: {$secondary_rgb};
        --color-accent:        {$accent};
        --color-accent-rgb:    {$accent_rgb};
    }
    </style>\n";
}
add_action('wp_head', 'eupnea_dynamic_colors', 5);

function eupnea_hex_to_rgb(string $hex): string {
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = str_repeat($hex[0], 2) . str_repeat($hex[1], 2) . str_repeat($hex[2], 2);
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return "{$r}, {$g}, {$b}";
}

// ──────────────────────────────────────────────
// Render: Generelle innstillinger
// ──────────────────────────────────────────────
function eupnea_render_settings_page(): void {
    if (!current_user_can('manage_options')) return;
    ?>
    <div class="wrap eupnea-admin-wrap">
        <div class="eupnea-admin-header">
            <h1>⚙️ <?php esc_html_e('Eupnea – Generelle innstillinger', 'eupnea'); ?></h1>
            <p><?php esc_html_e('Her tilpasser du farger, sitefot og generell info for nettstedet.', 'eupnea'); ?></p>
        </div>

        <form method="post" action="options.php">
            <?php settings_fields('eupnea_general'); ?>

            <div class="eupnea-settings-grid">
                <!-- Farger -->
                <div class="eupnea-settings-card">
                    <h2>🎨 <?php esc_html_e('Farger', 'eupnea'); ?></h2>
                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e('Primærfarge', 'eupnea'); ?></th>
                            <td>
                                <input type="color" name="eupnea_primary_color"
                                       value="<?php echo esc_attr(get_option('eupnea_primary_color', '#0D3349')); ?>">
                                <p class="description"><?php esc_html_e('Brukes til overskrifter, knapper og bakgrunner.', 'eupnea'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Sekundærfarge', 'eupnea'); ?></th>
                            <td>
                                <input type="color" name="eupnea_secondary_color"
                                       value="<?php echo esc_attr(get_option('eupnea_secondary_color', '#14B8A6')); ?>">
                                <p class="description"><?php esc_html_e('Teal/turkis – aksentfarger og highlights.', 'eupnea'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Accentfarge', 'eupnea'); ?></th>
                            <td>
                                <input type="color" name="eupnea_accent_color"
                                       value="<?php echo esc_attr(get_option('eupnea_accent_color', '#F59E0B')); ?>">
                                <p class="description"><?php esc_html_e('Brukes til CTA-knapper og uthevede elementer.', 'eupnea'); ?></p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Generelt -->
                <div class="eupnea-settings-card">
                    <h2>📝 <?php esc_html_e('Innhold', 'eupnea'); ?></h2>
                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e('Slagord (tagline)', 'eupnea'); ?></th>
                            <td>
                                <input type="text" class="regular-text" name="eupnea_tagline"
                                       value="<?php echo esc_attr(get_option('eupnea_tagline', '')); ?>"
                                       placeholder="<?php esc_attr_e('f.eks. «Frihet til å puste»', 'eupnea'); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e('Bunntekst-tekst', 'eupnea'); ?></th>
                            <td>
                                <textarea name="eupnea_footer_text" rows="3" class="large-text"><?php
                                    echo esc_textarea(get_option('eupnea_footer_text', ''));
                                ?></textarea>
                                <p class="description"><?php esc_html_e('Vises i bunnteksten. HTML er tillatt.', 'eupnea'); ?></p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <?php submit_button(__('Lagre innstillinger', 'eupnea')); ?>
        </form>
    </div>
    <?php
}

// ──────────────────────────────────────────────
// Render: Kontaktinnstillinger
// ──────────────────────────────────────────────
function eupnea_render_contact_page(): void {
    if (!current_user_can('manage_options')) return;
    ?>
    <div class="wrap eupnea-admin-wrap">
        <div class="eupnea-admin-header">
            <h1>📍 <?php esc_html_e('Eupnea – Kontaktinformasjon', 'eupnea'); ?></h1>
            <p><?php esc_html_e('Adresse, telefon og e-post som vises i bunnteksten og kontaktseksjonen.', 'eupnea'); ?></p>
        </div>

        <form method="post" action="options.php">
            <?php settings_fields('eupnea_contact'); ?>

            <div class="eupnea-settings-card">
                <table class="form-table">
                    <tr>
                        <th><?php esc_html_e('Adresse', 'eupnea'); ?></th>
                        <td>
                            <textarea name="eupnea_address" rows="3" class="large-text"><?php
                                echo esc_textarea(get_option('eupnea_address', ''));
                            ?></textarea>
                            <p class="description"><?php esc_html_e('Gateadresse, postnummer og by.', 'eupnea'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th><?php esc_html_e('Telefon', 'eupnea'); ?></th>
                        <td>
                            <input type="tel" class="regular-text" name="eupnea_phone"
                                   value="<?php echo esc_attr(get_option('eupnea_phone', '')); ?>"
                                   placeholder="+47 000 00 000">
                        </td>
                    </tr>
                    <tr>
                        <th><?php esc_html_e('E-post', 'eupnea'); ?></th>
                        <td>
                            <input type="email" class="regular-text" name="eupnea_email"
                                   value="<?php echo esc_attr(get_option('eupnea_email', '')); ?>"
                                   placeholder="kontakt@eupnea.no">
                        </td>
                    </tr>
                    <tr>
                        <th><?php esc_html_e('Google Maps-lenke', 'eupnea'); ?></th>
                        <td>
                            <input type="url" class="large-text" name="eupnea_map_url"
                                   value="<?php echo esc_attr(get_option('eupnea_map_url', '')); ?>"
                                   placeholder="https://maps.google.com/...">
                            <p class="description"><?php esc_html_e('Lim inn lenke til Google Maps-stedet ditt.', 'eupnea'); ?></p>
                        </td>
                    </tr>
                </table>
            </div>

            <?php submit_button(__('Lagre kontaktinfo', 'eupnea')); ?>
        </form>
    </div>
    <?php
}

// ──────────────────────────────────────────────
// Render: Sosiale medier
// ──────────────────────────────────────────────
function eupnea_render_social_page(): void {
    if (!current_user_can('manage_options')) return;

    $networks = [
        'facebook'  => ['label' => 'Facebook',   'placeholder' => 'https://facebook.com/eupnea'],
        'instagram' => ['label' => 'Instagram',  'placeholder' => 'https://instagram.com/eupnea'],
        'linkedin'  => ['label' => 'LinkedIn',   'placeholder' => 'https://linkedin.com/company/eupnea'],
        'twitter'   => ['label' => 'X / Twitter', 'placeholder' => 'https://twitter.com/eupnea'],
        'youtube'   => ['label' => 'YouTube',    'placeholder' => 'https://youtube.com/@eupnea'],
    ];
    ?>
    <div class="wrap eupnea-admin-wrap">
        <div class="eupnea-admin-header">
            <h1>📱 <?php esc_html_e('Eupnea – Sosiale medier', 'eupnea'); ?></h1>
            <p><?php esc_html_e('Lenker som vises i bunntekst og header.', 'eupnea'); ?></p>
        </div>

        <form method="post" action="options.php">
            <?php settings_fields('eupnea_social'); ?>

            <div class="eupnea-settings-card">
                <table class="form-table">
                    <?php foreach ($networks as $key => $info) : ?>
                    <tr>
                        <th><?php echo esc_html($info['label']); ?></th>
                        <td>
                            <input type="url" class="large-text" name="eupnea_social_<?php echo esc_attr($key); ?>"
                                   value="<?php echo esc_attr(get_option("eupnea_social_{$key}", '')); ?>"
                                   placeholder="<?php echo esc_attr($info['placeholder']); ?>">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <?php submit_button(__('Lagre sosiale medier', 'eupnea')); ?>
        </form>
    </div>
    <?php
}

// ──────────────────────────────────────────────
// Render: Moduler & Hjelp
// ──────────────────────────────────────────────
function eupnea_render_modules_help_page(): void {
    if (!current_user_can('manage_options')) return;

    $modules = [
        ['name' => 'Hero',                'slug' => 'hero',           'icon' => '🖼️',  'desc' => 'Stor velkomst-seksjon med bilde, overskrift og CTA-knapper'],
        ['name' => 'Tjenester',           'slug' => 'services',       'icon' => '⚡',  'desc' => 'Kort-grid som presenterer tjenester med ikon og beskrivelse'],
        ['name' => 'Om oss',              'slug' => 'about',          'icon' => '🏢',  'desc' => 'Fortell historien med bilde, tekst og statistikk'],
        ['name' => 'Ansatte / Team',      'slug' => 'team',           'icon' => '👥',  'desc' => 'Profilkort med bilde, navn, tittel og LinkedIn'],
        ['name' => 'Mentorer',            'slug' => 'mentors',        'icon' => '🎓',  'desc' => 'Fremhev mentorer med kompetanseområder'],
        ['name' => 'Partnere',            'slug' => 'partners',       'icon' => '🤝',  'desc' => 'Logo-grid for samarbeidspartnere med lenker'],
        ['name' => 'Tilbakemeldinger',    'slug' => 'testimonials',   'icon' => '💬',  'desc' => 'Sitater fra fornøyde kunder/brukere'],
        ['name' => 'Hvorfor/Hvordan/Hvor','slug' => 'why_how_where',  'icon' => '🧭',  'desc' => 'Tre-kolonne seksjon for konseptuell presentasjon'],
        ['name' => 'Kontakt',             'slug' => 'contact',        'icon' => '📞',  'desc' => 'Kontaktinfo, kart og kontaktskjema'],
    ];

    $frontpage_id  = get_option('page_on_front');
    $frontpage_url = $frontpage_id
        ? get_edit_post_link($frontpage_id)
        : admin_url('edit.php?post_type=page');
    ?>
    <div class="wrap eupnea-admin-wrap">
        <div class="eupnea-admin-header">
            <h1>🧩 <?php esc_html_e('Moduler & Hjelp', 'eupnea'); ?></h1>
            <p><?php esc_html_e('Oversikt over alle tilgjengelige ACF-moduler i dette temaet.', 'eupnea'); ?></p>
        </div>

        <?php if ($frontpage_id) : ?>
        <div class="eupnea-notice eupnea-notice--info">
            <strong><?php esc_html_e('Snarlenke:', 'eupnea'); ?></strong>
            <a href="<?php echo esc_url($frontpage_url); ?>" class="button button-primary">
                ✏️ <?php esc_html_e('Rediger Forside-moduler', 'eupnea'); ?>
            </a>
        </div>
        <?php endif; ?>

        <div class="eupnea-modules-grid">
            <?php foreach ($modules as $module) : ?>
            <div class="eupnea-module-card">
                <div class="eupnea-module-card__icon"><?php echo $module['icon']; ?></div>
                <h3><?php echo esc_html($module['name']); ?></h3>
                <p><?php echo esc_html($module['desc']); ?></p>
                <code>layout: <?php echo esc_html($module['slug']); ?></code>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="eupnea-settings-card" style="margin-top:2rem;">
            <h2>📖 <?php esc_html_e('Slik bruker du modulene', 'eupnea'); ?></h2>
            <ol style="line-height:2">
                <li><?php esc_html_e('Gå til Sider → rediger forsiden', 'eupnea'); ?></li>
                <li><?php esc_html_e('Finn seksjonen «Fleksibelt innhold» i editoren', 'eupnea'); ?></li>
                <li><?php esc_html_e('Klikk «Legg til modul» og velg ønsket modul', 'eupnea'); ?></li>
                <li><?php esc_html_e('Fyll inn innholdet og publiser', 'eupnea'); ?></li>
                <li><?php esc_html_e('Dra og slipp for å endre rekkefølgen på modulene', 'eupnea'); ?></li>
            </ol>
        </div>
    </div>
    <?php
}

// ──────────────────────────────────────────────
// Tilpass admin-bar
// ──────────────────────────────────────────────
function eupnea_admin_bar_links(WP_Admin_Bar $wp_admin_bar): void {
    if (!current_user_can('manage_options')) return;

    $wp_admin_bar->add_node([
        'id'    => 'eupnea-quick',
        'title' => '⚙️ Eupnea',
        'href'  => admin_url('admin.php?page=eupnea-settings'),
    ]);

    $wp_admin_bar->add_node([
        'parent' => 'eupnea-quick',
        'id'     => 'eupnea-quick-general',
        'title'  => __('Generelle innstillinger', 'eupnea'),
        'href'   => admin_url('admin.php?page=eupnea-settings'),
    ]);

    $wp_admin_bar->add_node([
        'parent' => 'eupnea-quick',
        'id'     => 'eupnea-quick-contact',
        'title'  => __('Kontaktinfo', 'eupnea'),
        'href'   => admin_url('admin.php?page=eupnea-contact-settings'),
    ]);

    $wp_admin_bar->add_node([
        'parent' => 'eupnea-quick',
        'id'     => 'eupnea-quick-social',
        'title'  => __('Sosiale medier', 'eupnea'),
        'href'   => admin_url('admin.php?page=eupnea-social-settings'),
    ]);

    // Hurtiglenke til forsiden
    $frontpage_id = get_option('page_on_front');
    if ($frontpage_id) {
        $wp_admin_bar->add_node([
            'parent' => 'eupnea-quick',
            'id'     => 'eupnea-quick-frontpage',
            'title'  => '✏️ ' . __('Rediger forside', 'eupnea'),
            'href'   => get_edit_post_link($frontpage_id),
        ]);
    }
}
add_action('admin_bar_menu', 'eupnea_admin_bar_links', 100);
