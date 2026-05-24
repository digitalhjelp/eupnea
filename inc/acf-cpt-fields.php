<?php
/**
 * ACF-felt for Custom Post Types
 * Ansatte, Mentorer, Partnere, Tilbakemeldinger
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

if (!function_exists('acf_add_local_field_group')) return;

add_action('acf/init', 'eupnea_register_cpt_acf_fields');

function eupnea_register_cpt_acf_fields(): void {

    // ──────────────────────────────────────────
    // ANSATT-FELT
    // ──────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_ansatt',
        'title'  => '👤 Ansatt-informasjon',
        'fields' => [
            [
                'key'          => 'field_ansatt_stilling',
                'label'        => 'Stilling / Tittel',
                'name'         => 'stilling',
                'type'         => 'text',
                'required'     => 1,
                'placeholder'  => 'f.eks. Daglig leder',
                'instructions' => 'Vises under navn på nettsiden',
            ],
            [
                'key'          => 'field_ansatt_bio',
                'label'        => 'Kort biografi',
                'name'         => 'bio',
                'type'         => 'textarea',
                'rows'         => 4,
                'placeholder'  => 'Kort presentasjon av personen...',
            ],
            [
                'key'           => 'field_ansatt_epost',
                'label'         => 'E-post',
                'name'          => 'epost',
                'type'          => 'email',
                'placeholder'   => 'navn@eupnea.no',
            ],
            [
                'key'         => 'field_ansatt_linkedin',
                'label'       => 'LinkedIn-profil (URL)',
                'name'        => 'linkedin',
                'type'        => 'url',
                'placeholder' => 'https://linkedin.com/in/...',
            ],
            [
                'key'          => 'field_ansatt_fremhev',
                'label'        => 'Fremhev på forsiden',
                'name'         => 'fremhev',
                'type'         => 'true_false',
                'ui'           => 1,
                'default_value'=> 1,
                'instructions' => 'Slå av for å skjule fra teammodulen',
            ],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'ansatt']],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
    ]);

    // ──────────────────────────────────────────
    // MENTOR-FELT
    // ──────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_mentor',
        'title'  => '🎓 Mentor-informasjon',
        'fields' => [
            [
                'key'         => 'field_mentor_kompetanse',
                'label'       => 'Kompetanseområde',
                'name'        => 'kompetanse',
                'type'        => 'text',
                'required'    => 1,
                'placeholder' => 'f.eks. Ledelse & coaching',
                'instructions'=> 'Vises som undertittel under navn',
            ],
            [
                'key'         => 'field_mentor_bio',
                'label'       => 'Biografi',
                'name'        => 'bio',
                'type'        => 'textarea',
                'rows'        => 4,
                'placeholder' => 'Kort presentasjon av mentoren...',
            ],
            [
                'key'         => 'field_mentor_linkedin',
                'label'       => 'LinkedIn-profil (URL)',
                'name'        => 'linkedin',
                'type'        => 'url',
                'placeholder' => 'https://linkedin.com/in/...',
            ],
            [
                'key'          => 'field_mentor_tagger',
                'label'        => 'Tagger / Spesialområder',
                'name'         => 'tagger',
                'type'         => 'text',
                'placeholder'  => 'Coaching, HR, Strategi',
                'instructions' => 'Kommaseparert liste. Vises som chips under biografi.',
            ],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'mentor']],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
    ]);

    // ──────────────────────────────────────────
    // PARTNER-FELT
    // ──────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_partner',
        'title'  => '🤝 Partner-informasjon',
        'fields' => [
            [
                'key'           => 'field_partner_logo',
                'label'         => 'Logo',
                'name'          => 'logo',
                'type'          => 'image',
                'required'      => 1,
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'instructions'  => 'PNG eller SVG med transparent bakgrunn. Maks høyde 100 px.',
            ],
            [
                'key'         => 'field_partner_url',
                'label'       => 'Nettside (URL)',
                'name'        => 'partner_url',
                'type'        => 'url',
                'placeholder' => 'https://partnernavn.no',
            ],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'partner']],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
    ]);

    // ──────────────────────────────────────────
    // TILBAKEMELDING-FELT
    // ──────────────────────────────────────────
    acf_add_local_field_group([
        'key'    => 'group_tilbakemelding',
        'title'  => '💬 Tilbakemelding',
        'fields' => [
            [
                'key'          => 'field_tback_sitat',
                'label'        => 'Sitat',
                'name'         => 'sitat',
                'type'         => 'textarea',
                'required'     => 1,
                'rows'         => 4,
                'placeholder'  => 'Skriv inn sitatet her – uten anførselstegn...',
                'instructions' => 'Anførselstegn legges til automatisk på nettsiden.',
            ],
            [
                'key'         => 'field_tback_tittel',
                'label'       => 'Tittel / Firma',
                'name'        => 'forfatter_tittel',
                'type'        => 'text',
                'placeholder' => 'CEO, Firma AS',
                'instructions'=> 'Vises under forfatterens navn (som er sidetittelen)',
            ],
            [
                'key'           => 'field_tback_bilde',
                'label'         => 'Profilbilde (valgfritt)',
                'name'          => 'bilde',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'thumbnail',
                'library'       => 'all',
            ],
            [
                'key'           => 'field_tback_stjerner',
                'label'         => 'Antall stjerner',
                'name'          => 'stjerner',
                'type'          => 'range',
                'min'           => 1,
                'max'           => 5,
                'step'          => 1,
                'default_value' => 5,
                'prepend'       => '⭐',
                'append'        => 'av 5',
            ],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'tilbakemelding']],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
    ]);
}
