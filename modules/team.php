<?php
/**
 * Modul: Ansatte / Team – henter fra «Ansatte» CPT
 * Klikk på kortet åpner popup med detaljert info.
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$title    = get_sub_field('team_title');
$subtitle = get_sub_field('team_subtitle');
$columns  = get_sub_field('team_columns') ?: '3';
$limit    = (int)(get_sub_field('team_limit') ?: -1);

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

        <!-- Kort-grid -->
        <div class="team__grid team__grid--cols-<?php echo esc_attr($columns); ?>">
            <?php foreach ($ansatte as $ansatt) :
                $photo        = get_the_post_thumbnail_url($ansatt->ID, 'medium');
                $name         = get_the_title($ansatt->ID);
                $stilling     = get_field('stilling',     $ansatt->ID);
                $linkedin     = get_field('linkedin',     $ansatt->ID);
                $epost        = get_field('epost',        $ansatt->ID);
                $hvem_er_du   = get_field('hvem_er_du',   $ansatt->ID);
                $rolle        = get_field('rolle',        $ansatt->ID);
                $mitt_bidrag  = get_field('mitt_bidrag',  $ansatt->ID);
                $ansvar_for   = get_field('ansvar_for',   $ansatt->ID);
                $styrker      = get_field('styrker',      $ansatt->ID);
                $motto        = get_field('motto',        $ansatt->ID);
                $has_popup    = ($hvem_er_du || $rolle || $mitt_bidrag || $ansvar_for || $styrker || $motto);
                $card_id      = 'ansatt-' . $ansatt->ID;
            ?>
            <div class="person-card<?php echo $has_popup ? ' person-card--clickable' : ''; ?>"
                 <?php if ($has_popup) : ?>
                     data-popup="<?php echo esc_attr($card_id); ?>"
                     role="button" tabindex="0"
                     aria-haspopup="dialog"
                     aria-label="<?php echo esc_attr('Les mer om ' . $name); ?>"
                 <?php endif; ?>>

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

                    <?php if ($linkedin || $epost) : ?>
                    <div class="person-card__links">
                        <?php if ($linkedin) : ?>
                        <a href="<?php echo esc_url($linkedin); ?>"
                           target="_blank" rel="noopener noreferrer"
                           class="person-card__link"
                           onclick="event.stopPropagation()"
                           aria-label="<?php echo esc_attr($name); ?> på LinkedIn">
                            <?php echo eupnea_social_icon('linkedin'); ?>
                            <span>LinkedIn</span>
                        </a>
                        <?php endif; ?>
                        <?php if ($epost) : ?>
                        <a href="mailto:<?php echo esc_attr($epost); ?>"
                           class="person-card__link"
                           onclick="event.stopPropagation()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <span>E-post</span>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($has_popup) : ?>
                    <button class="person-card__more-btn" aria-label="Mer om <?php echo esc_attr($name); ?>">
                        <?php esc_html_e('Mer om', 'eupnea'); ?> →
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($has_popup) : ?>
            <!-- POPUP for <?php echo esc_html($name); ?> -->
            <div id="<?php echo esc_attr($card_id); ?>"
                 class="ansatt-popup"
                 role="dialog"
                 aria-modal="true"
                 aria-label="<?php echo esc_attr($name); ?>"
                 hidden>

                <div class="ansatt-popup__backdrop"></div>

                <div class="ansatt-popup__panel">
                    <button class="ansatt-popup__close" aria-label="Lukk">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>

                    <div class="ansatt-popup__content">

                        <!-- Header -->
                        <div class="ansatt-popup__header">
                            <h2 class="ansatt-popup__name"><?php echo esc_html($name); ?></h2>
                            <?php if ($stilling) : ?>
                                <p class="ansatt-popup__stilling"><?php echo esc_html($stilling); ?></p>
                            <?php endif; ?>

                            <?php if ($linkedin) : ?>
                            <a href="<?php echo esc_url($linkedin); ?>"
                               target="_blank" rel="noopener noreferrer"
                               class="ansatt-popup__linkedin">
                                <?php echo eupnea_social_icon('linkedin'); ?>
                                <span>LinkedIn</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ansatt-popup__ext-icon" aria-hidden="true">
                                    <line x1="7" y1="17" x2="17" y2="7"/>
                                    <polyline points="7 7 17 7 17 17"/>
                                </svg>
                            </a>
                            <?php endif; ?>

                            <hr class="ansatt-popup__divider">
                        </div>

                        <!-- Seksjoner -->
                        <div class="ansatt-popup__sections">
                            <?php
                            $sections = [
                                'Hvem er du?' => $hvem_er_du,
                                'Rolle'        => $rolle,
                                'Mitt bidrag'  => $mitt_bidrag,
                                'Ansvar for'   => $ansvar_for,
                                'Styrker'      => $styrker,
                            ];
                            foreach ($sections as $heading => $content) :
                                if (!$content) continue;
                            ?>
                            <div class="ansatt-popup__section">
                                <h3 class="ansatt-popup__section-title"><?php echo esc_html($heading); ?></h3>
                                <p class="ansatt-popup__section-text"><?php echo nl2br(esc_html($content)); ?></p>
                            </div>
                            <?php endforeach; ?>

                            <?php if ($motto) : ?>
                            <blockquote class="ansatt-popup__motto">
                                <span class="ansatt-popup__motto-mark">"</span><?php echo esc_html($motto); ?><span class="ansatt-popup__motto-mark">"</span>
                            </blockquote>
                            <?php endif; ?>
                        </div>

                    </div><!-- /.ansatt-popup__content -->
                </div><!-- /.ansatt-popup__panel -->
            </div><!-- /.ansatt-popup -->
            <?php endif; ?>

            <?php endforeach; ?>
        </div>

    </div>
</section>
