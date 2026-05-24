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
            // ── Grunninfo ──
            [
                'key'   => 'field_ansatt_tab_basis',
                'label' => 'Grunninfo',
                'name'  => '',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_ansatt_stilling',
                'label'        => 'Stilling / Tittel',
                'name'         => 'stilling',
                'type'         => 'text',
                'required'     => 1,
                'placeholder'  => 'f.eks. Chief Executive Officer',
                'instructions' => 'Vises under navn på kortet og i popup',
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

            // ── Popup-innhold ──
            [
                'key'   => 'field_ansatt_tab_popup',
                'label' => 'Popup-innhold',
                'name'  => '',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_ansatt_hvem_er_du',
                'label'        => 'Hvem er du?',
                'name'         => 'hvem_er_du',
                'type'         => 'textarea',
                'rows'         => 4,
                'placeholder'  => 'Beskriv deg selv – bakgrunn, utdanning, erfaring...',
                'instructions' => 'Vises som første seksjon i popup',
            ],
            [
                'key'         => 'field_ansatt_rolle',
                'label'       => 'Rolle',
                'name'        => 'rolle',
                'type'        => 'textarea',
                'rows'        => 3,
                'placeholder' => 'Hva er din rolle i Eupnea?',
            ],
            [
                'key'         => 'field_ansatt_mitt_bidrag',
                'label'       => 'Mitt bidrag',
                'name'        => 'mitt_bidrag',
                'type'        => 'textarea',
                'rows'        => 4,
                'placeholder' => 'Hva bidrar du med i teamet og prosjektet?',
            ],
            [
                'key'         => 'field_ansatt_ansvar_for',
                'label'       => 'Ansvar for',
                'name'        => 'ansvar_for',
                'type'        => 'textarea',
                'rows'        => 3,
                'placeholder' => 'Hva er du ansvarlig for?',
            ],
            [
                'key'         => 'field_ansatt_styrker',
                'label'       => 'Styrker',
                'name'        => 'styrker',
                'type'        => 'textarea',
                'rows'        => 3,
                'placeholder' => 'Hva er dine fremste styrker?',
            ],
            [
                'key'          => 'field_ansatt_motto',
                'label'        => 'Motto',
                'name'         => 'motto',
                'type'         => 'text',
                'placeholder'  => 'f.eks. «Aldri gi opp»',
                'instructions' => 'Vises som avsluttende sitat nederst i popup',
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
