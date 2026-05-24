<?php
/**
 * Modul: Ansatte / Team
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$title    = get_sub_field('team_title');
$subtitle = get_sub_field('team_subtitle');
$columns  = get_sub_field('team_columns') ?: '3';
$members  = get_sub_field('team_members');

if (empty($members)) return;
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
            <?php foreach ($members as $member) :
                $photo    = $member['photo']    ?? null;
                $name     = $member['name']     ?? '';
                $position = $member['position'] ?? '';
                $bio      = $member['bio']       ?? '';
                $linkedin = $member['linkedin']  ?? '';
                $email    = $member['email']     ?? '';
            ?>
            <div class="person-card">
                <?php if ($photo) : ?>
                <div class="person-card__photo">
                    <?php echo eupnea_image($photo, 'medium', 'person-card__img'); ?>
                </div>
                <?php endif; ?>

                <div class="person-card__info">
                    <?php if ($name) : ?>
                        <h3 class="person-card__name"><?php echo esc_html($name); ?></h3>
                    <?php endif; ?>
                    <?php if ($position) : ?>
                        <p class="person-card__position"><?php echo esc_html($position); ?></p>
                    <?php endif; ?>
                    <?php if ($bio) : ?>
                        <p class="person-card__bio"><?php echo esc_html($bio); ?></p>
                    <?php endif; ?>

                    <?php if ($linkedin || $email) : ?>
                    <div class="person-card__links">
                        <?php if ($linkedin) : ?>
                        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer"
                           class="person-card__link person-card__link--linkedin"
                           aria-label="<?php printf(esc_attr__('%s på LinkedIn', 'eupnea'), esc_attr($name)); ?>">
                            <?php echo eupnea_social_icon('linkedin'); ?>
                            <span>LinkedIn</span>
                        </a>
                        <?php endif; ?>
                        <?php if ($email) : ?>
                        <a href="<?php echo esc_url($email); ?>"
                           class="person-card__link person-card__link--email"
                           aria-label="<?php printf(esc_attr__('Send e-post til %s', 'eupnea'), esc_attr($name)); ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <span><?php esc_html_e('E-post', 'eupnea'); ?></span>
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
