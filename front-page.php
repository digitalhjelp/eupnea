<?php
/**
 * Forside-mal
 * Bruker ACF Flexible Content for å bygge siden modulbasert.
 *
 * @package Eupnea
 */

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // Last inn fleksibelt innhold
        get_template_part('template-parts/flexible-content');

    endwhile;
endif;

get_footer();
