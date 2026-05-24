<?php
/**
 * ACF Feltgrupper – registrert i PHP
 * Alle moduler for Flexible Content på forsiden og sider.
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

if (!function_exists('acf_add_local_field_group')) {
    return;
}

add_action('acf/init', 'eupnea_register_acf_fields');

function eupnea_register_acf_fields(): void {

    // ══════════════════════════════════════════
    // FLEXIBLE CONTENT – SIDEBYGGER
    // ══════════════════════════════════════════
    acf_add_local_field_group([
        'key'      => 'group_eupnea_flexible',
        'title'    => '🧩 Sidebygger – Moduler',
        'fields'   => [
            [
                'key'            => 'field_eupnea_flexible_content',
                'label'          => 'Moduler',
                'name'           => 'page_modules',
                'type'           => 'flexible_content',
                'instructions'   => 'Legg til, flytt og konfigurer seksjoner på siden.',
                'button_label'   => '➕ Legg til modul',
                'min'            => 0,
                'max'            => 0,
                'layouts'        => eupnea_get_all_layouts(),
            ],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'page']],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'seamless',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ]);
}

// ──────────────────────────────────────────────
// Hent alle layouts
// ──────────────────────────────────────────────
function eupnea_get_all_layouts(): array {
    return array_merge(
        eupnea_layout_hero(),
        eupnea_layout_services(),
        eupnea_layout_about(),
        eupnea_layout_team(),
        eupnea_layout_mentors(),
        eupnea_layout_partners(),
        eupnea_layout_testimonials(),
        eupnea_layout_why_how_where(),
        eupnea_layout_contact()
    );
}

// ══════════════════════════════════════════════
// LAYOUT: HERO
// ══════════════════════════════════════════════
function eupnea_layout_hero(): array {
    return [[
        'key'        => 'layout_hero',
        'name'       => 'hero',
        'label'      => '🖼️ Hero – Velkomstseksjon',
        'display'    => 'block',
        'min'        => '',
        'max'        => '',
        'sub_fields' => [
            // Bakgrunn
            eupnea_field_tab('Bakgrunn'),
            eupnea_field_image('field_hero_bg_image', 'hero_bg_image', 'Bakgrunnsbilde', 'Anbefalt: 1920×1080 px eller større'),
            [
                'key'          => 'field_hero_bg_video_url',
                'label'        => 'Bakgrunnsvideo (URL)',
                'name'         => 'hero_bg_video_url',
                'type'         => 'url',
                'instructions' => 'Valgfritt – overstyrer bakgrunnsbildet. Bruk .mp4-fil.',
                'placeholder'  => 'https://...',
            ],
            eupnea_field_color('field_hero_overlay_color', 'hero_overlay_color', 'Overlay-farge', '#0D3349'),
            [
                'key'           => 'field_hero_overlay_opacity',
                'label'         => 'Overlay-gjennomsiktighet',
                'name'          => 'hero_overlay_opacity',
                'type'          => 'range',
                'min'           => 0,
                'max'           => 100,
                'step'          => 5,
                'default_value' => 60,
                'append'        => '%',
            ],

            // Innhold
            eupnea_field_tab('Innhold'),
            [
                'key'          => 'field_hero_pre_heading',
                'label'        => 'Pre-overskrift (liten)',
                'name'         => 'hero_pre_heading',
                'type'         => 'text',
                'instructions' => 'Vises over hovedoverskriften. F.eks. «Velkommen til»',
                'placeholder'  => 'Eupnea',
            ],
            [
                'key'         => 'field_hero_heading',
                'label'       => 'Hovedoverskrift',
                'name'        => 'hero_heading',
                'type'        => 'text',
                'required'    => 1,
                'placeholder' => 'Frihet til å puste',
            ],
            [
                'key'         => 'field_hero_subheading',
                'label'       => 'Underoverskrift',
                'name'        => 'hero_subheading',
                'type'        => 'textarea',
                'rows'        => 3,
                'placeholder' => 'Kort beskrivelse av hva dere tilbyr...',
            ],

            // CTA-knapper
            eupnea_field_tab('Knapper'),
            [
                'key'          => 'field_hero_cta_buttons',
                'label'        => 'CTA-knapper',
                'name'         => 'hero_cta_buttons',
                'type'         => 'repeater',
                'instructions' => 'Legg til opptil 2 knapper',
                'min'          => 0,
                'max'          => 2,
                'layout'       => 'table',
                'button_label' => 'Legg til knapp',
                'sub_fields'   => [
                    eupnea_field_text('field_hero_btn_label', 'label', 'Knappetekst', true, 'Kom i gang'),
                    eupnea_field_url('field_hero_btn_url', 'url', 'URL'),
                    [
                        'key'           => 'field_hero_btn_style',
                        'label'         => 'Stil',
                        'name'          => 'style',
                        'type'          => 'select',
                        'choices'       => [
                            'primary'   => 'Primær (filled)',
                            'outline'   => 'Outline (ramme)',
                            'secondary' => 'Sekundær',
                        ],
                        'default_value' => 'primary',
                    ],
                    [
                        'key'   => 'field_hero_btn_new_tab',
                        'label' => 'Ny fane',
                        'name'  => 'new_tab',
                        'type'  => 'true_false',
                        'ui'    => 1,
                    ],
                ],
            ],

            // Layout
            eupnea_field_tab('Layout'),
            [
                'key'           => 'field_hero_height',
                'label'         => 'Seksjonshøyde',
                'name'          => 'hero_height',
                'type'          => 'select',
                'choices'       => [
                    'fullscreen' => 'Fullskjerm (100vh)',
                    'large'      => 'Stor (80vh)',
                    'medium'     => 'Medium (60vh)',
                    'small'      => 'Liten (40vh)',
                ],
                'default_value' => 'large',
            ],
            [
                'key'           => 'field_hero_align',
                'label'         => 'Innhold-justering',
                'name'          => 'hero_content_align',
                'type'          => 'button_group',
                'choices'       => ['left' => 'Venstre', 'center' => 'Midtstilt', 'right' => 'Høyre'],
                'default_value' => 'left',
            ],
        ],
    ]];
}

// ══════════════════════════════════════════════
// LAYOUT: TJENESTER (SERVICES)
// ══════════════════════════════════════════════
function eupnea_layout_services(): array {
    return [[
        'key'        => 'layout_services',
        'name'       => 'services',
        'label'      => '⚡ Tjenester',
        'display'    => 'block',
        'sub_fields' => [
            eupnea_field_tab('Seksjon'),
            eupnea_field_text('field_services_title', 'services_title', 'Seksjonstittel', false, 'Våre tjenester'),
            eupnea_field_textarea('field_services_subtitle', 'services_subtitle', 'Ingress', 'Kort beskrivelse under tittelen'),
            [
                'key'           => 'field_services_columns',
                'label'         => 'Antall kolonner',
                'name'          => 'services_columns',
                'type'          => 'button_group',
                'choices'       => ['2' => '2 kolonner', '3' => '3 kolonner', '4' => '4 kolonner'],
                'default_value' => '3',
            ],
            eupnea_field_tab('Tjenester'),
            [
                'key'          => 'field_services_items',
                'label'        => 'Tjenester',
                'name'         => 'services_items',
                'type'         => 'repeater',
                'instructions' => 'Legg til tjenester – drag for å endre rekkefølge',
                'min'          => 1,
                'layout'       => 'row',
                'button_label' => '➕ Legg til tjeneste',
                'sub_fields'   => [
                    eupnea_field_image('field_svc_icon', 'icon', 'Ikon/Bilde', 'SVG eller PNG, 64×64 px'),
                    [
                        'key'      => 'field_svc_emoji',
                        'label'    => 'Emoji-ikon (alternativ)',
                        'name'     => 'emoji',
                        'type'     => 'text',
                        'instructions' => 'Skriv inn et emoji-tegn hvis du ikke bruker bilde. F.eks: 🎯',
                    ],
                    eupnea_field_text('field_svc_title', 'title', 'Tittel', true, 'Tjenestenavn'),
                    eupnea_field_wysiwyg('field_svc_description', 'description', 'Beskrivelse'),
                    eupnea_field_url('field_svc_url', 'url', 'Lenke (valgfritt)'),
                    eupnea_field_text('field_svc_link_label', 'link_label', 'Lenketekst', false, 'Les mer'),
                    [
                        'key'           => 'field_svc_highlight',
                        'label'         => 'Fremhev dette kortet',
                        'name'          => 'highlight',
                        'type'          => 'true_false',
                        'ui'            => 1,
                        'default_value' => 0,
                    ],
                ],
            ],
            eupnea_field_tab('CTA'),
            eupnea_field_text('field_services_cta_label', 'services_cta_label', 'CTA-knapp tekst', false, 'Se alle tjenester'),
            eupnea_field_url('field_services_cta_url', 'services_cta_url', 'CTA-knapp URL'),
        ],
    ]];
}

// ══════════════════════════════════════════════
// LAYOUT: OM OSS (ABOUT)
// ══════════════════════════════════════════════
function eupnea_layout_about(): array {
    return [[
        'key'        => 'layout_about',
        'name'       => 'about',
        'label'      => '🏢 Om oss',
        'display'    => 'block',
        'sub_fields' => [
            eupnea_field_tab('Innhold'),
            eupnea_field_text('field_about_label', 'about_label', 'Lite merkelapp', false, 'Om oss'),
            eupnea_field_text('field_about_title', 'about_title', 'Overskrift', true, 'Vi hjelper deg å finne balansen'),
            eupnea_field_wysiwyg('field_about_content', 'about_content', 'Brødtekst'),
            eupnea_field_text('field_about_cta_label', 'about_cta_label', 'Knappetekst', false, 'Lær mer om oss'),
            eupnea_field_url('field_about_cta_url', 'about_cta_url', 'Knapp-URL'),

            eupnea_field_tab('Bilde'),
            eupnea_field_image('field_about_image', 'about_image', 'Bilde', 'Anbefalt: 800×600 px'),
            [
                'key'           => 'field_about_image_position',
                'label'         => 'Bildeposisjon',
                'name'          => 'about_image_position',
                'type'          => 'button_group',
                'choices'       => ['left' => '← Venstre', 'right' => 'Høyre →'],
                'default_value' => 'right',
            ],

            eupnea_field_tab('Statistikk'),
            [
                'key'          => 'field_about_stats',
                'label'        => 'Statistikk / tall',
                'name'         => 'about_stats',
                'type'         => 'repeater',
                'max'          => 4,
                'layout'       => 'table',
                'button_label' => '➕ Legg til statistikk',
                'sub_fields'   => [
                    eupnea_field_text('field_stat_number', 'number', 'Tall/Verdi', false, '100+'),
                    eupnea_field_text('field_stat_label',  'label',  'Betegnelse',  false, 'Fornøyde kunder'),
                ],
            ],
        ],
    ]];
}

// ══════════════════════════════════════════════
// LAYOUT: ANSATTE / TEAM
// ══════════════════════════════════════════════
function eupnea_layout_team(): array {
    return [[
        'key'        => 'layout_team',
        'name'       => 'team',
        'label'      => '👥 Ansatte / Team',
        'display'    => 'block',
        'sub_fields' => [
            eupnea_field_tab('Seksjon'),
            eupnea_field_text('field_team_title', 'team_title', 'Overskrift', false, 'Møt teamet'),
            eupnea_field_textarea('field_team_subtitle', 'team_subtitle', 'Ingress', ''),
            [
                'key'           => 'field_team_columns',
                'label'         => 'Kolonner',
                'name'          => 'team_columns',
                'type'          => 'button_group',
                'choices'       => ['2' => '2', '3' => '3', '4' => '4'],
                'default_value' => '3',
            ],
            eupnea_field_tab('Teammedlemmer'),
            [
                'key'          => 'field_team_members',
                'label'        => 'Teammedlemmer',
                'name'         => 'team_members',
                'type'         => 'repeater',
                'layout'       => 'row',
                'button_label' => '➕ Legg til teammedlem',
                'sub_fields'   => [
                    eupnea_field_image('field_tm_photo',    'photo',    'Profilbilde', 'Anbefalt: kvadratisk, 400×400 px'),
                    eupnea_field_text('field_tm_name',     'name',     'Fullt navn',  true, 'Ola Nordmann'),
                    eupnea_field_text('field_tm_position', 'position', 'Stilling',    false, 'Daglig leder'),
                    eupnea_field_textarea('field_tm_bio',  'bio',      'Kort bio',    ''),
                    eupnea_field_url('field_tm_linkedin',  'linkedin', 'LinkedIn-URL'),
                    eupnea_field_url('field_tm_email',     'email',    'E-post (mailto:)'),
                ],
            ],
        ],
    ]];
}

// ══════════════════════════════════════════════
// LAYOUT: MENTORER
// ══════════════════════════════════════════════
function eupnea_layout_mentors(): array {
    return [[
        'key'        => 'layout_mentors',
        'name'       => 'mentors',
        'label'      => '🎓 Mentorer',
        'display'    => 'block',
        'sub_fields' => [
            eupnea_field_tab('Seksjon'),
            eupnea_field_text('field_mentors_title', 'mentors_title', 'Overskrift', false, 'Våre mentorer'),
            eupnea_field_textarea('field_mentors_subtitle', 'mentors_subtitle', 'Ingress', ''),
            eupnea_field_tab('Mentorer'),
            [
                'key'          => 'field_mentors_items',
                'label'        => 'Mentorer',
                'name'         => 'mentors_items',
                'type'         => 'repeater',
                'layout'       => 'row',
                'button_label' => '➕ Legg til mentor',
                'sub_fields'   => [
                    eupnea_field_image('field_mentor_photo',     'photo',     'Profilbilde', 'Kvadratisk, 400×400 px'),
                    eupnea_field_text('field_mentor_name',      'name',      'Fullt navn',  true, 'Kari Nordmann'),
                    eupnea_field_text('field_mentor_expertise', 'expertise', 'Kompetanseområde', false, 'Ledelse & coaching'),
                    eupnea_field_textarea('field_mentor_bio',   'bio',       'Kort biografi', ''),
                    eupnea_field_url('field_mentor_linkedin',   'linkedin',  'LinkedIn'),
                    [
                        'key'     => 'field_mentor_tags',
                        'label'   => 'Tagger (kommaseparert)',
                        'name'    => 'tags',
                        'type'    => 'text',
                        'instructions' => 'F.eks: Coaching, Ledelse, HR',
                    ],
                ],
            ],
        ],
    ]];
}

// ══════════════════════════════════════════════
// LAYOUT: PARTNERE
// ══════════════════════════════════════════════
function eupnea_layout_partners(): array {
    return [[
        'key'        => 'layout_partners',
        'name'       => 'partners',
        'label'      => '🤝 Partnere',
        'display'    => 'block',
        'sub_fields' => [
            eupnea_field_tab('Seksjon'),
            eupnea_field_text('field_partners_title', 'partners_title', 'Overskrift (valgfritt)', false, 'Våre samarbeidspartnere'),
            [
                'key'           => 'field_partners_style',
                'label'         => 'Visningsstil',
                'name'          => 'partners_style',
                'type'          => 'select',
                'choices'       => [
                    'grid'     => 'Grid (statisk)',
                    'marquee'  => 'Scrollende rekke (marquee)',
                ],
                'default_value' => 'grid',
            ],
            eupnea_field_tab('Partnere'),
            [
                'key'          => 'field_partners_items',
                'label'        => 'Partnere',
                'name'         => 'partners_items',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => '➕ Legg til partner',
                'sub_fields'   => [
                    eupnea_field_image('field_partner_logo', 'logo', 'Logo', 'SVG eller PNG, hvit/transparent bakgrunn'),
                    eupnea_field_text('field_partner_name', 'name', 'Selskapsnavn', false, ''),
                    eupnea_field_url('field_partner_url',   'url',  'Nettside-URL'),
                ],
            ],
        ],
    ]];
}

// ══════════════════════════════════════════════
// LAYOUT: TILBAKEMELDINGER (TESTIMONIALS)
// ══════════════════════════════════════════════
function eupnea_layout_testimonials(): array {
    return [[
        'key'        => 'layout_testimonials',
        'name'       => 'testimonials',
        'label'      => '💬 Tilbakemeldinger',
        'display'    => 'block',
        'sub_fields' => [
            eupnea_field_tab('Seksjon'),
            eupnea_field_text('field_testi_title', 'testi_title', 'Overskrift', false, 'Hva sier kundene våre?'),
            [
                'key'           => 'field_testi_style',
                'label'         => 'Visningsstil',
                'name'          => 'testi_style',
                'type'          => 'select',
                'choices'       => [
                    'slider' => 'Slider / Karusell',
                    'grid'   => 'Grid (2–3 kolonner)',
                    'single' => 'Stor enkelt-sitat',
                ],
                'default_value' => 'grid',
            ],
            eupnea_field_tab('Sitater'),
            [
                'key'          => 'field_testi_items',
                'label'        => 'Tilbakemeldinger',
                'name'         => 'testi_items',
                'type'         => 'repeater',
                'layout'       => 'row',
                'button_label' => '➕ Legg til sitat',
                'sub_fields'   => [
                    eupnea_field_textarea('field_testi_quote', 'quote', 'Sitat', ''),
                    eupnea_field_text('field_testi_author',    'author_name',  'Navn',    false, 'Ola Nordmann'),
                    eupnea_field_text('field_testi_author_title', 'author_title', 'Tittel/rolle', false, 'CEO, Firma AS'),
                    eupnea_field_image('field_testi_photo',    'author_photo', 'Profilbilde (valgfritt)', ''),
                    [
                        'key'           => 'field_testi_rating',
                        'label'         => 'Stjerner',
                        'name'          => 'rating',
                        'type'          => 'range',
                        'min'           => 1,
                        'max'           => 5,
                        'step'          => 1,
                        'default_value' => 5,
                    ],
                ],
            ],
        ],
    ]];
}

// ══════════════════════════════════════════════
// LAYOUT: HVORFOR / HVORDAN / HVOR
// ══════════════════════════════════════════════
function eupnea_layout_why_how_where(): array {
    return [[
        'key'        => 'layout_why_how_where',
        'name'       => 'why_how_where',
        'label'      => '🧭 Hvorfor / Hvordan / Hvor',
        'display'    => 'block',
        'sub_fields' => [
            eupnea_field_tab('Seksjon'),
            eupnea_field_text('field_whw_title', 'whw_title', 'Seksjonstittel (valgfritt)', false, ''),
            eupnea_field_textarea('field_whw_intro', 'whw_intro', 'Ingress (valgfritt)', ''),
            [
                'key'           => 'field_whw_bg',
                'label'         => 'Bakgrunn',
                'name'          => 'whw_bg',
                'type'          => 'select',
                'choices'       => [
                    'white'   => 'Hvit',
                    'light'   => 'Lys grå',
                    'primary' => 'Primærfarge (mørk)',
                ],
                'default_value' => 'light',
            ],
            eupnea_field_tab('Elementer'),
            [
                'key'          => 'field_whw_items',
                'label'        => 'Elementer',
                'name'         => 'whw_items',
                'type'         => 'repeater',
                'instructions' => 'Typisk: Hvorfor, Hvordan, Hvor – men du kan bruke hva du vil',
                'min'          => 1,
                'max'          => 6,
                'layout'       => 'row',
                'button_label' => '➕ Legg til element',
                'sub_fields'   => [
                    eupnea_field_image('field_whw_icon',    'icon',    'Ikon/Bilde', ''),
                    [
                        'key'   => 'field_whw_emoji',
                        'label' => 'Emoji (alternativ til bilde)',
                        'name'  => 'emoji',
                        'type'  => 'text',
                    ],
                    eupnea_field_text('field_whw_label',   'label',   'Merkelapp (f.eks. «Hvorfor»)', false, 'Hvorfor'),
                    eupnea_field_text('field_whw_item_title', 'title', 'Tittel', true, ''),
                    eupnea_field_wysiwyg('field_whw_content', 'content', 'Innhold'),
                    eupnea_field_url('field_whw_url',        'url',    'Lenke (valgfritt)'),
                    eupnea_field_text('field_whw_link_label', 'link_label', 'Lenketekst', false, 'Les mer'),
                ],
            ],
        ],
    ]];
}

// ══════════════════════════════════════════════
// LAYOUT: KONTAKT
// ══════════════════════════════════════════════
function eupnea_layout_contact(): array {
    return [[
        'key'        => 'layout_contact',
        'name'       => 'contact',
        'label'      => '📞 Kontakt',
        'display'    => 'block',
        'sub_fields' => [
            eupnea_field_tab('Innhold'),
            eupnea_field_text('field_contact_title', 'contact_title', 'Overskrift', false, 'Ta kontakt'),
            eupnea_field_textarea('field_contact_intro', 'contact_intro', 'Ingress', ''),
            [
                'key'          => 'field_contact_show_info',
                'label'        => 'Vis kontaktinformasjon',
                'name'         => 'contact_show_info',
                'type'         => 'true_false',
                'ui'           => 1,
                'default_value'=> 1,
                'instructions' => 'Henter adresse/telefon/e-post fra Eupnea → Kontaktinfo',
            ],
            [
                'key'          => 'field_contact_show_form',
                'label'        => 'Vis kontaktskjema',
                'name'         => 'contact_show_form',
                'type'         => 'true_false',
                'ui'           => 1,
                'default_value'=> 1,
            ],
            [
                'key'          => 'field_contact_form_shortcode',
                'label'        => 'Skjema-shortcode',
                'name'         => 'contact_form_shortcode',
                'type'         => 'text',
                'instructions' => 'F.eks: [contact-form-7 id="123"] eller [gravityforms id="1"]',
                'placeholder'  => '[contact-form-7 id="123"]',
                'conditional_logic' => [
                    [['field' => 'field_contact_show_form', 'operator' => '==', 'value' => '1']],
                ],
            ],
            eupnea_field_tab('Kart & Media'),
            eupnea_field_image('field_contact_image', 'contact_image', 'Illustrasjonsbilde (valgfritt)', ''),
            [
                'key'          => 'field_contact_show_map',
                'label'        => 'Vis kart (Google Maps)',
                'name'         => 'contact_show_map',
                'type'         => 'true_false',
                'ui'           => 1,
                'default_value'=> 0,
                'instructions' => 'Henter Google Maps-URL fra Eupnea → Kontaktinfo',
            ],
        ],
    ]];
}

// ══════════════════════════════════════════════
// HJELPEFUNKSJONER FOR FELTDEFINISJONER
// ══════════════════════════════════════════════

function eupnea_field_tab(string $label): array {
    static $i = 0;
    return [
        'key'   => 'field_tab_' . sanitize_title($label) . '_' . (++$i),
        'label' => $label,
        'name'  => '',
        'type'  => 'tab',
    ];
}

function eupnea_field_text(string $key, string $name, string $label, bool $required = false, string $placeholder = ''): array {
    return [
        'key'         => $key,
        'label'       => $label,
        'name'        => $name,
        'type'        => 'text',
        'required'    => (int) $required,
        'placeholder' => $placeholder,
    ];
}

function eupnea_field_textarea(string $key, string $name, string $label, string $placeholder = ''): array {
    return [
        'key'         => $key,
        'label'       => $label,
        'name'        => $name,
        'type'        => 'textarea',
        'rows'        => 3,
        'placeholder' => $placeholder,
    ];
}

function eupnea_field_url(string $key, string $name, string $label): array {
    return [
        'key'   => $key,
        'label' => $label,
        'name'  => $name,
        'type'  => 'url',
    ];
}

function eupnea_field_image(string $key, string $name, string $label, string $instructions = ''): array {
    return [
        'key'           => $key,
        'label'         => $label,
        'name'          => $name,
        'type'          => 'image',
        'instructions'  => $instructions,
        'return_format' => 'array',
        'preview_size'  => 'medium',
        'library'       => 'all',
    ];
}

function eupnea_field_wysiwyg(string $key, string $name, string $label): array {
    return [
        'key'          => $key,
        'label'        => $label,
        'name'         => $name,
        'type'         => 'wysiwyg',
        'toolbar'      => 'basic',
        'media_upload' => 0,
        'tabs'         => 'visual',
    ];
}

function eupnea_field_color(string $key, string $name, string $label, string $default = '#000000'): array {
    return [
        'key'           => $key,
        'label'         => $label,
        'name'          => $name,
        'type'          => 'color_picker',
        'default_value' => $default,
        'enable_opacity'=> 1,
        'return_format' => 'string',
    ];
}
