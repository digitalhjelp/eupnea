    </main>
    <!-- ─── FOOTER ─────────────────────────────────────────── -->
    <footer id="colophon" class="site-footer" role="contentinfo">

        <div class="footer-main">
            <div class="container footer-main__inner">

                <!-- Brand-kolonne -->
                <div class="footer-col footer-col--brand">
                    <?php if (has_custom_logo()) : ?>
                        <div class="footer-logo"><?php the_custom_logo(); ?></div>
                    <?php else : ?>
                        <span class="footer-site-name"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>

                    <?php $tagline = get_option('eupnea_tagline', get_bloginfo('description')); ?>
                    <?php if ($tagline) : ?>
                        <p class="footer-tagline"><?php echo esc_html($tagline); ?></p>
                    <?php endif; ?>

                    <!-- Sosiale medier -->
                    <?php $social = eupnea_social_links(); ?>
                    <?php if ($social) : ?>
                    <div class="footer-social">
                        <?php foreach ($social as $network => $url) : ?>
                        <a href="<?php echo esc_url($url); ?>"
                           class="footer-social__link footer-social__link--<?php echo esc_attr($network); ?>"
                           target="_blank" rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                            <?php echo eupnea_social_icon($network); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Navigasjonskolonne -->
                <?php if (has_nav_menu('footer')) : ?>
                <div class="footer-col footer-col--nav">
                    <h4 class="footer-col__title"><?php esc_html_e('Navigasjon', 'eupnea'); ?></h4>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-nav-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ]);
                    ?>
                </div>
                <?php endif; ?>

                <!-- Kontaktkolonne -->
                <?php
                $address  = get_option('eupnea_address', '');
                $phone    = get_option('eupnea_phone', '');
                $email    = get_option('eupnea_email', '');
                if ($address || $phone || $email) :
                ?>
                <div class="footer-col footer-col--contact">
                    <h4 class="footer-col__title"><?php esc_html_e('Kontakt', 'eupnea'); ?></h4>
                    <ul class="footer-contact-list">
                        <?php if ($address) : ?>
                        <li class="footer-contact-list__item footer-contact-list__item--address">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span><?php echo nl2br(esc_html($address)); ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if ($phone) : ?>
                        <li class="footer-contact-list__item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.65 3.38 2 2 0 0 1 3.64 1.2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.79a16 16 0 0 0 5.55 5.55l.95-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/>
                            </svg>
                            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if ($email) : ?>
                        <li class="footer-contact-list__item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- Footer bunn-bar -->
        <div class="footer-bottom">
            <div class="container footer-bottom__inner">
                <p class="footer-bottom__copy">
                    <?php
                    $footer_text = get_option('eupnea_footer_text', '');
                    if ($footer_text) {
                        echo wp_kses_post($footer_text);
                    } else {
                        printf(
                            '&copy; %s %s. %s',
                            esc_html(date('Y')),
                            esc_html(get_bloginfo('name')),
                            esc_html__('Alle rettigheter forbeholdt.', 'eupnea')
                        );
                    }
                    ?>
                </p>
                <p class="footer-bottom__credits">
                    <?php esc_html_e('Bygget med', 'eupnea'); ?>
                    <a href="https://wordpress.org" target="_blank" rel="noopener">WordPress</a>
                </p>
            </div>
        </div>

    </footer>
    <!-- ─── / FOOTER ───────────────────────────────────────── -->

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
