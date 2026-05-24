<?php
/**
 * Modul: Ansatte / Team – henter fra «Ansatte» CPT
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$title    = get_sub_field('team_title');
$subtitle = get_sub_field('team_subtitle');
$columns  = get_sub_field('team_columns') ?: '3';
$limit    = (int)(get_sub_field('team_limit') ?: -1);

// Hent ansatte fra CPT
$ansatte = get_posts([
    'post_type'      => 'ansatt',
    'posts_per_page' => $limit,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
    'meta_query'     => [[
        'key'     => 'fremhev',
        'value'   => '1',
        'compare' => '=',
    ]],
]);

// Fallback: vis alle hvis ingen er fremhevet
if (empty($ansatte)) {
    $ansatte = get_posts([
        'post_type'      => 'ansatt',
        'posts_per_page' => $limit,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ]);
}

if (empty($ansatte)) return;
?>

<section class="module module--team team">
    <div class="container">

        <?php if ($title || $subtitle) : ?>
        <header class="section-header">
            <?php if ($title) : ?>
                <h2 class="section-header__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <?php if ($subtitle) : ?>
                <p class="section-header__subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </header>
        <?php endif; ?>

        <div class="team__grid team__grid--cols-<?php echo esc_attr($columns); ?>">
            <?php foreach ($ansatte as $ansatt) :
                $photo    = get_the_post_thumbnail_url($ansatt->ID, 'medium');
                $name     = get_the_title($ansatt->ID);
                $stilling = get_field('stilling',  $ansatt->ID);
                $bio      = get_field('bio',       $ansatt->ID);
                $linkedin = get_field('linkedin',  $ansatt->ID);
                $epost    = get_field('epost',     $ansatt->ID);
            ?>
            <div class="person-card">
                <div class="person-card__photo">
                    <?php if ($photo) : ?>
                        <img src="<?php echo esc_url($photo); ?>"
                             alt="<?php echo esc_attr($name); ?>"
                             class="person-card__img" loading="lazy">
                    <?php else : ?>
                        <div class="person-card__placeholder" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="person-card__info">
                    <?php if ($name) : ?>
                        <h3 class="person-card__name"><?php echo esc_html($name); ?></h3>
                    <?php endif; ?>
                    <?php if ($stilling) : ?>
                        <p class="person-card__position"><?php echo esc_html($stilling); ?></p>
                    <?php endif; ?>
                    <?php if ($bio) : ?>
                        <p class="person-card__bio"><?php echo esc_html($bio); ?></p>
                    <?php endif; ?>

                    <?php if ($linkedin || $epost) : ?>
                    <div class="person-card__links">
                        <?php if ($linkedin) : ?>
                        <a href="<?php echo esc_url($linkedin); ?>"
                           target="_blank" rel="noopener noreferrer"
                           class="person-card__link person-card__link--linkedin"
                           aria-label="<?php echo esc_attr($name); ?> på LinkedIn">
                            <?php echo eupnea_social_icon('linkedin'); ?>
                            <span>LinkedIn</span>
                        </a>
                        <?php endif; ?>
                        <?php if ($epost) : ?>
                        <a href="mailto:<?php echo esc_attr($epost); ?>"
                           class="person-card__link person-card__link--email">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <span>E-post</span>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
