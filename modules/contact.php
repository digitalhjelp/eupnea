<?php
/**
 * Modul: Kontakt
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$title        = get_sub_field('contact_title');
$intro        = get_sub_field('contact_intro');
$show_info    = get_sub_field('contact_show_info');
$show_form    = get_sub_field('contact_show_form');
$shortcode    = get_sub_field('contact_form_shortcode');
$image        = get_sub_field('contact_image');
$show_map     = get_sub_field('contact_show_map');

// Hent kontaktinfo fra innstillinger
$address  = get_option('eupnea_address', '');
$phone    = get_option('eupnea_phone', '');
$email    = get_option('eupnea_email', '');
$map_url  = get_option('eupnea_map_url', '');

$has_left_col  = $show_info || $image;
$has_right_col = $show_form && $shortcode;
$layout_class  = ($has_left_col && $has_right_col) ? 'contact--two-col' : 'contact--one-col';
?>

<section class="module module--contact contact <?php echo esc_attr($layout_class); ?>" id="kontakt">
    <div class="container contact__inner">

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

        <div class="contact__body">

            <!-- Venstre: Kontaktinfo / Bilde -->
            <?php if ($has_left_col) : ?>
            <div class="contact__info">

                <?php if ($image) : ?>
                <div class="contact__image">
                    <?php echo eupnea_image($image, 'large', 'contact__img'); ?>
                </div>
                <?php endif; ?>

                <?php if ($show_info && ($address || $phone || $email)) : ?>
                <ul class="contact__details">
                    <?php if ($address) : ?>
                    <li class="contact__detail">
                        <div class="contact__detail-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <div class="contact__detail-text">
                            <strong><?php esc_html_e('Adresse', 'eupnea'); ?></strong>
                            <span><?php echo nl2br(esc_html($address)); ?></span>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if ($phone) : ?>
                    <li class="contact__detail">
                        <div class="contact__detail-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.65 3.38 2 2 0 0 1 3.64 1.2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.79a16 16 0 0 0 5.55 5.55l.95-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/>
                            </svg>
                        </div>
                        <div class="contact__detail-text">
                            <strong><?php esc_html_e('Telefon', 'eupnea'); ?></strong>
                            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if ($email) : ?>
                    <li class="contact__detail">
                        <div class="contact__detail-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <div class="contact__detail-text">
                            <strong><?php esc_html_e('E-post', 'eupnea'); ?></strong>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </div>
                    </li>
                    <?php endif; ?>
                </ul>
                <?php endif; ?>

                <!-- Google Maps iframe -->
                <?php if ($show_map && $map_url) : ?>
                <div class="contact__map">
                    <a href="<?php echo esc_url($map_url); ?>" target="_blank" rel="noopener noreferrer"
                       class="contact__map-link btn btn--outline">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <?php esc_html_e('Vis i Google Maps', 'eupnea'); ?>
                    </a>
                </div>
                <?php endif; ?>

            </div>
            <?php endif; ?>

            <!-- Høyre: Kontaktskjema -->
            <?php if ($has_right_col) : ?>
            <div class="contact__form">
                <div class="contact__form-inner">
                    <?php echo do_shortcode(wp_kses_post($shortcode)); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>
