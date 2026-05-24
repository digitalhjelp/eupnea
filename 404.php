<?php
/**
 * 404-side
 *
 * @package Eupnea
 */

get_header();
?>

<section class="error-404 not-found">
    <div class="container" style="text-align:center; padding: 6rem 1.5rem;">
        <p style="font-size: 6rem; margin-bottom: 0;">🌬️</p>
        <h1 style="font-size: 8rem; color: var(--color-secondary); margin: 0; line-height:1;">404</h1>
        <h2><?php esc_html_e('Siden ble ikke funnet', 'eupnea'); ?></h2>
        <p style="color: var(--color-text-muted); margin: 1rem 0 2rem;">
            <?php esc_html_e('Det ser ut som denne siden har tatt et dypt pust og forsvunnet.', 'eupnea'); ?>
        </p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
            <?php esc_html_e('← Tilbake til forsiden', 'eupnea'); ?>
        </a>
    </div>
</section>

<?php get_footer(); ?>
