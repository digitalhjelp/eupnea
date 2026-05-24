<?php
/**
 * Modul: Om oss (About)
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$label          = get_sub_field('about_label');
$title          = get_sub_field('about_title');
$content        = get_sub_field('about_content');
$cta_label      = get_sub_field('about_cta_label');
$cta_url        = get_sub_field('about_cta_url');
$image          = get_sub_field('about_image');
$image_position = get_sub_field('about_image_position') ?: 'right';
$stats          = get_sub_field('about_stats');
?>

<section class="module module--about about about--image-<?php echo esc_attr($image_position); ?>">
    <div class="container about__inner">

        <!-- Tekstkolonne -->
        <div class="about__text">
            <?php if ($label) : ?>
                <span class="section-label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>

            <?php if ($title) : ?>
                <h2 class="about__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($content) : ?>
                <div class="about__content"><?php echo wp_kses_post($content); ?></div>
            <?php endif; ?>

            <?php if ($stats) : ?>
            <div class="about__stats">
                <?php foreach ($stats as $stat) :
                    $number = $stat['number'] ?? '';
                    $s_label = $stat['label']  ?? '';
                    if (!$number) continue;
                ?>
                <div class="about__stat">
                    <span class="about__stat-number"><?php echo esc_html($number); ?></span>
                    <?php if ($s_label) : ?>
                        <span class="about__stat-label"><?php echo esc_html($s_label); ?></span>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($cta_label && $cta_url) : ?>
                <div class="about__cta">
                    <?php echo eupnea_button($cta_label, $cta_url, 'primary'); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Bildekolonne -->
        <?php if ($image) : ?>
        <div class="about__image-wrap">
            <?php echo eupnea_image($image, 'large', 'about__image'); ?>
        </div>
        <?php endif; ?>

    </div>
</section>
