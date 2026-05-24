<?php
/**
 * Modul: Tjenester (Services)
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$title     = get_sub_field('services_title');
$subtitle  = get_sub_field('services_subtitle');
$columns   = get_sub_field('services_columns') ?: '3';
$items     = get_sub_field('services_items');
$cta_label = get_sub_field('services_cta_label');
$cta_url   = get_sub_field('services_cta_url');

if (empty($items)) return;
?>

<section class="module module--services services">
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

        <div class="services__grid services__grid--cols-<?php echo esc_attr($columns); ?>">
            <?php foreach ($items as $item) :
                $icon       = $item['icon']       ?? null;
                $emoji      = $item['emoji']      ?? '';
                $svc_title  = $item['title']       ?? '';
                $desc       = $item['description'] ?? '';
                $link       = $item['url']         ?? '';
                $link_label = $item['link_label']  ?? __('Les mer', 'eupnea');
                $highlight  = !empty($item['highlight']);
            ?>
            <div class="service-card<?php echo $highlight ? ' service-card--highlight' : ''; ?>">

                <?php if ($icon || $emoji) : ?>
                <div class="service-card__icon" aria-hidden="true">
                    <?php if ($icon) : ?>
                        <?php echo eupnea_image($icon, 'thumbnail', 'service-card__icon-img'); ?>
                    <?php elseif ($emoji) : ?>
                        <span class="service-card__emoji"><?php echo esc_html($emoji); ?></span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if ($svc_title) : ?>
                    <h3 class="service-card__title"><?php echo esc_html($svc_title); ?></h3>
                <?php endif; ?>

                <?php if ($desc) : ?>
                    <div class="service-card__desc"><?php echo wp_kses_post($desc); ?></div>
                <?php endif; ?>

                <?php if ($link) : ?>
                    <a href="<?php echo esc_url($link); ?>" class="service-card__link">
                        <?php echo esc_html($link_label); ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                <?php endif; ?>

            </div>
            <?php endforeach; ?>
        </div>

        <?php if ($cta_label && $cta_url) : ?>
        <div class="services__cta">
            <?php echo eupnea_button($cta_label, $cta_url, 'primary'); ?>
        </div>
        <?php endif; ?>

    </div>
</section>
