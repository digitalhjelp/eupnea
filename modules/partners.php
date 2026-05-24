<?php
/**
 * Modul: Partnere
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$title  = get_sub_field('partners_title');
$style  = get_sub_field('partners_style') ?: 'grid';
$items  = get_sub_field('partners_items');

if (empty($items)) return;
?>

<section class="module module--partners partners partners--<?php echo esc_attr($style); ?>">
    <div class="container">

        <?php if ($title) : ?>
        <header class="section-header section-header--small">
            <h2 class="section-header__title"><?php echo esc_html($title); ?></h2>
        </header>
        <?php endif; ?>

        <?php if ($style === 'marquee') : ?>
        <!-- Scrollende logo-rekke -->
        <div class="partners__marquee" aria-label="<?php esc_attr_e('Samarbeidspartnere', 'eupnea'); ?>">
            <div class="partners__marquee-track">
                <?php
                // Dupliser for sømløs loop
                $all_items = array_merge($items, $items);
                foreach ($all_items as $partner) :
                    $logo = $partner['logo'] ?? null;
                    $name = $partner['name'] ?? '';
                    $url  = $partner['url']  ?? '';
                ?>
                <div class="partner-logo">
                    <?php if ($url) : ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer"
                           title="<?php echo esc_attr($name); ?>">
                    <?php endif; ?>
                        <?php if ($logo) : ?>
                            <?php echo eupnea_image($logo, 'medium', 'partner-logo__img', $name); ?>
                        <?php elseif ($name) : ?>
                            <span class="partner-logo__text"><?php echo esc_html($name); ?></span>
                        <?php endif; ?>
                    <?php if ($url) : ?>
                        </a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php else : ?>
        <!-- Grid -->
        <div class="partners__grid" aria-label="<?php esc_attr_e('Samarbeidspartnere', 'eupnea'); ?>">
            <?php foreach ($items as $partner) :
                $logo = $partner['logo'] ?? null;
                $name = $partner['name'] ?? '';
                $url  = $partner['url']  ?? '';
            ?>
            <div class="partner-logo">
                <?php if ($url) : ?>
                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer"
                       title="<?php echo esc_attr($name); ?>">
                <?php endif; ?>
                    <?php if ($logo) : ?>
                        <?php echo eupnea_image($logo, 'medium', 'partner-logo__img', $name); ?>
                    <?php elseif ($name) : ?>
                        <span class="partner-logo__text"><?php echo esc_html($name); ?></span>
                    <?php endif; ?>
                <?php if ($url) : ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>
