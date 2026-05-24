<?php
/**
 * Modul: Hero – Velkomstseksjon
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

$bg_image        = get_sub_field('hero_bg_image');
$bg_video_url    = get_sub_field('hero_bg_video_url');
$overlay_color   = get_sub_field('hero_overlay_color') ?: '#0D3349';
$overlay_opacity = get_sub_field('hero_overlay_opacity') ?? 60;
$pre_heading     = get_sub_field('hero_pre_heading');
$heading         = get_sub_field('hero_heading');
$subheading      = get_sub_field('hero_subheading');
$cta_buttons     = get_sub_field('hero_cta_buttons');
$height          = get_sub_field('hero_height') ?: 'large';
$align           = get_sub_field('hero_content_align') ?: 'left';

// Bakgrunnsstil
$bg_style = '';
if ($bg_image && !$bg_video_url) {
    $img_url  = $bg_image['sizes']['1536x1536'] ?? $bg_image['url'] ?? '';
    $bg_style = $img_url ? "background-image: url('" . esc_url($img_url) . "');" : '';
}

$overlay_alpha = round($overlay_opacity / 100, 2);
$overlay_rgb   = eupnea_hex_to_rgb($overlay_color);
?>

<section class="module module--hero hero hero--<?php echo esc_attr($height); ?> hero--align-<?php echo esc_attr($align); ?>"
         style="<?php echo esc_attr($bg_style); ?>"
         aria-label="<?php esc_attr_e('Hero-seksjon', 'eupnea'); ?>">

    <!-- Video-bakgrunn -->
    <?php if ($bg_video_url) : ?>
    <video class="hero__video" autoplay muted loop playsinline>
        <source src="<?php echo esc_url($bg_video_url); ?>" type="video/mp4">
    </video>
    <?php endif; ?>

    <!-- Overlay -->
    <div class="hero__overlay"
         style="background-color: rgba(<?php echo esc_attr($overlay_rgb); ?>, <?php echo esc_attr($overlay_alpha); ?>);">
    </div>

    <!-- Innhold -->
    <div class="container hero__content">
        <?php if ($pre_heading) : ?>
            <p class="hero__pre-heading"><?php echo esc_html($pre_heading); ?></p>
        <?php endif; ?>

        <?php if ($heading) : ?>
            <h1 class="hero__heading"><?php echo esc_html($heading); ?></h1>
        <?php endif; ?>

        <?php if ($subheading) : ?>
            <p class="hero__subheading"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>

        <?php if ($cta_buttons) : ?>
        <div class="hero__buttons">
            <?php foreach ($cta_buttons as $btn) :
                $label   = $btn['label']   ?? '';
                $url     = $btn['url']     ?? '';
                $style   = $btn['style']   ?? 'primary';
                $new_tab = !empty($btn['new_tab']);
                echo eupnea_button($label, $url, $style, '', $new_tab);
            endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Scroll-indikator -->
    <div class="hero__scroll-indicator" aria-hidden="true">
        <span class="hero__scroll-arrow"></span>
    </div>

</section>
