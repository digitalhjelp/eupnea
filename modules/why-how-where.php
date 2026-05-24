<?php
/**
 * Modul: Hvorfor / Hvordan / Hvor
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$title  = get_sub_field('whw_title');
$intro  = get_sub_field('whw_intro');
$bg     = get_sub_field('whw_bg') ?: 'light';
$items  = get_sub_field('whw_items');

if (empty($items)) return;

$col_class = 'whw__grid--cols-' . min(count($items), 3);
?>

<section class="module module--whw whw whw--bg-<?php echo esc_attr($bg); ?>">
    <div class="container">

        <?php if ($title || $intro) : ?>
        <header class="section-header">
            <?php if ($title) : ?>
                <h2 class="section-header__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <?php if ($intro) : ?>
                <p class="section-header__subtitle"><?php echo esc_html($intro); ?></p>
            <?php endif; ?>
        </header>
        <?php endif; ?>

        <div class="whw__grid <?php echo esc_attr($col_class); ?>">
            <?php foreach ($items as $item) :
                $icon       = $item['icon']       ?? null;
                $emoji      = $item['emoji']      ?? '';
                $label      = $item['label']      ?? '';
                $item_title = $item['title']      ?? '';
                $content    = $item['content']    ?? '';
                $url        = $item['url']         ?? '';
                $link_label = $item['link_label']  ?? __('Les mer', 'eupnea');
            ?>
            <div class="whw-card">

                <?php if ($icon || $emoji) : ?>
                <div class="whw-card__icon" aria-hidden="true">
                    <?php if ($icon) : ?>
                        <?php echo eupnea_image($icon, 'thumbnail', 'whw-card__icon-img'); ?>
                    <?php elseif ($emoji) : ?>
                        <span class="whw-card__emoji"><?php echo esc_html($emoji); ?></span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if ($label) : ?>
                    <span class="whw-card__label section-label"><?php echo esc_html($label); ?></span>
                <?php endif; ?>

                <?php if ($item_title) : ?>
                    <h3 class="whw-card__title"><?php echo esc_html($item_title); ?></h3>
                <?php endif; ?>

                <?php if ($content) : ?>
                    <div class="whw-card__content"><?php echo wp_kses_post($content); ?></div>
                <?php endif; ?>

                <?php if ($url) : ?>
                <a href="<?php echo esc_url($url); ?>" class="whw-card__link">
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

    </div>
</section>
