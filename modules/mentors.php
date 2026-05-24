<?php
/**
 * Modul: Mentorer – henter fra «Mentorer» CPT
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$title    = get_sub_field('mentors_title');
$subtitle = get_sub_field('mentors_subtitle');
$limit    = (int)(get_sub_field('mentors_limit') ?: -1);

$mentorer = get_posts([
    'post_type'      => 'mentor',
    'posts_per_page' => $limit,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);

if (empty($mentorer)) return;
?>

<section class="module module--mentors mentors">
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

        <div class="mentors__grid">
            <?php foreach ($mentorer as $mentor) :
                $photo      = get_the_post_thumbnail_url($mentor->ID, 'medium');
                $name       = get_the_title($mentor->ID);
                $kompetanse = get_field('kompetanse', $mentor->ID);
                $bio        = get_field('bio',        $mentor->ID);
                $linkedin   = get_field('linkedin',   $mentor->ID);
                $tagger_raw = get_field('tagger',     $mentor->ID);
                $tagger     = $tagger_raw ? array_map('trim', explode(',', $tagger_raw)) : [];
            ?>
            <article class="mentor-card">
                <div class="mentor-card__visual">
                    <?php if ($photo) : ?>
                    <div class="mentor-card__photo">
                        <img src="<?php echo esc_url($photo); ?>"
                             alt="<?php echo esc_attr($name); ?>"
                             class="mentor-card__img" loading="lazy">
                    </div>
                    <?php else : ?>
                    <div class="mentor-card__photo mentor-card__photo--placeholder" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <?php endif; ?>

                    <?php if ($linkedin) : ?>
                    <a href="<?php echo esc_url($linkedin); ?>"
                       target="_blank" rel="noopener noreferrer"
                       class="mentor-card__linkedin"
                       aria-label="<?php echo esc_attr($name); ?> på LinkedIn">
                        <?php echo eupnea_social_icon('linkedin'); ?>
                    </a>
                    <?php endif; ?>
                </div>

                <div class="mentor-card__info">
                    <?php if ($name) : ?>
                        <h3 class="mentor-card__name"><?php echo esc_html($name); ?></h3>
                    <?php endif; ?>
                    <?php if ($kompetanse) : ?>
                        <p class="mentor-card__expertise"><?php echo esc_html($kompetanse); ?></p>
                    <?php endif; ?>
                    <?php if ($bio) : ?>
                        <p class="mentor-card__bio"><?php echo esc_html($bio); ?></p>
                    <?php endif; ?>
                    <?php if ($tagger) : ?>
                    <ul class="mentor-card__tags">
                        <?php foreach ($tagger as $tag) :
                            if (!trim($tag)) continue;
                        ?>
                        <li class="mentor-card__tag"><?php echo esc_html(trim($tag)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
