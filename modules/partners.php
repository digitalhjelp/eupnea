<?php
/**
 * Modul: Partnere – henter fra «Partnere» CPT
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$title = get_sub_field('partners_title');
$style = get_sub_field('partners_style') ?: 'grid';

$partnere = get_posts([
    'post_type'      => 'partner',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);

if (empty($partnere)) return;
?>

<section class="module module--partners partners partners--<?php echo esc_attr($style); ?>">
    <div class="container">

        <?php if ($title) : ?>
        <header class="section-header section-header--small">
            <h2 class="section-header__title"><?php echo esc_html($title); ?></h2>
        </header>
        <?php endif; ?>

        <?php if ($style === 'marquee') : ?>
        <div class="partners__marquee">
            <div class="partners__marquee-track">
                <?php
                // Dupliser for sømløs loop
                $alle = array_merge($partnere, $partnere);
                foreach ($alle as $partner) :
                    $logo = get_field('logo', $partner->ID);
                    $url  = get_field('partner_url', $partner->ID);
                    $name = get_the_title($partner->ID);
                ?>
                <div class="partner-logo">
                    <?php if ($url) : ?><a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr($name); ?>"><?php endif; ?>
                        <?php if ($logo) : ?>
                            <img src="<?php echo esc_url($logo['sizes']['medium'] ?? $logo['url']); ?>"
                                 alt="<?php echo esc_attr($name); ?>"
                                 class="partner-logo__img" loading="lazy">
                        <?php else : ?>
                            <span class="partner-logo__text"><?php echo esc_html($name); ?></span>
                        <?php endif; ?>
                    <?php if ($url) : ?></a><?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php else : ?>
        <div class="partners__grid">
            <?php foreach ($partnere as $partner) :
                $logo = get_field('logo', $partner->ID);
                $url  = get_field('partner_url', $partner->ID);
                $name = get_the_title($partner->ID);
            ?>
            <div class="partner-logo">
                <?php if ($url) : ?><a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr($name); ?>"><?php endif; ?>
                    <?php if ($logo) : ?>
                        <img src="<?php echo esc_url($logo['sizes']['medium'] ?? $logo['url']); ?>"
                             alt="<?php echo esc_attr($name); ?>"
                             class="partner-logo__img" loading="lazy">
                    <?php else : ?>
                        <span class="partner-logo__text"><?php echo esc_html($name); ?></span>
                    <?php endif; ?>
                <?php if ($url) : ?></a><?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>
