<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <!-- ─── HEADER ─────────────────────────────────────────── -->
    <header id="masthead" class="site-header" role="banner">
        <div class="container site-header__inner">

            <!-- Logo -->
            <div class="site-header__brand">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-header__name" rel="home">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Primær navigasjon -->
            <nav id="site-navigation" class="site-header__nav" aria-label="<?php esc_attr_e('Primærnavigasjon', 'eupnea'); ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ]);
                ?>
            </nav>

            <!-- CTA-knapp i header -->
            <?php
            $header_cta_label = eupnea_option('header_cta_label', '');
            $header_cta_url   = eupnea_option('header_cta_url', '');
            if ($header_cta_label && $header_cta_url) :
            ?>
            <div class="site-header__cta">
                <a href="<?php echo esc_url($header_cta_url); ?>" class="btn btn--primary btn--small">
                    <?php echo esc_html($header_cta_label); ?>
                </a>
            </div>
            <?php endif; ?>

            <!-- Hamburger-meny (mobil) -->
            <button class="hamburger" aria-label="<?php esc_attr_e('Åpne meny', 'eupnea'); ?>" aria-expanded="false" aria-controls="site-navigation">
                <span class="hamburger__line"></span>
                <span class="hamburger__line"></span>
                <span class="hamburger__line"></span>
            </button>

        </div>
    </header>
    <!-- ─── / HEADER ───────────────────────────────────────── -->

    <main id="primary" class="site-main">
