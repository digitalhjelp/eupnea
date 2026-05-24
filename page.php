<?php
/**
 * Sidemal
 *
 * @package Eupnea
 */

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // Sjekk om siden bruker flexible content-moduler
        if (function_exists('have_rows') && have_rows('page_modules')) {
            get_template_part('template-parts/flexible-content');
        } else {
            // Vanlig side-innhold
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
                <div class="container page-content__inner">
                    <?php if (get_the_title()) : ?>
                    <header class="page-content__header">
                        <h1 class="page-content__title"><?php the_title(); ?></h1>
                    </header>
                    <?php endif; ?>

                    <div class="page-content__body">
                        <?php the_content(); ?>
                    </div>
                </div>
            </article>
            <?php
        }

    endwhile;
endif;

get_footer();
