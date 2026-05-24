<?php
/**
 * Modul: Mentorer
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$title    = get_sub_field('mentors_title');
$subtitle = get_sub_field('mentors_subtitle');
$items    = get_sub_field('mentors_items');

if (empty($items)) return;
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
            <?php foreach ($items as $mentor) :
                $photo     = $mentor['photo']     ?? null;
                $name      = $mentor['name']      ?? '';
                $expertise = $mentor['expertise'] ?? '';
                $bio       = $mentor['bio']        ?? '';
                $linkedin  = $mentor['linkedin']   ?? '';
                $tags_raw  = $mentor['tags']       ?? '';
                $tags      = array_map('trim', explode(',', $tags_raw));
            ?>
            <article class="mentor-card">

                <div class="mentor-card__visual">
                    <?php if ($photo) : ?>
                    <div class="mentor-card__photo">
                        <?php echo eupnea_image($photo, 'medium', 'mentor-card__img'); ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($linkedin) : ?>
                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer"
                       class="mentor-card__linkedin"
                       aria-label="<?php printf(esc_attr__('%s på LinkedIn', 'eupnea'), esc_attr($name)); ?>">
                        <?php echo eupnea_social_icon('linkedin'); ?>
                    </a>
                    <?php endif; ?>
                </div>

                <div class="mentor-card__info">
                    <?php if ($name) : ?>
                        <h3 class="mentor-card__name"><?php echo esc_html($name); ?></h3>
                    <?php endif; ?>

                    <?php if ($expertise) : ?>
                        <p class="mentor-card__expertise"><?php echo esc_html($expertise); ?></p>
                    <?php endif; ?>

                    <?php if ($bio) : ?>
                        <p class="mentor-card__bio"><?php echo esc_html($bio); ?></p>
                    <?php endif; ?>

                    <?php if ($tags_raw && $tags[0] !== '') : ?>
                    <ul class="mentor-card__tags" aria-label="<?php esc_attr_e('Kompetanseområder', 'eupnea'); ?>">
                        <?php foreach ($tags as $tag) :
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
