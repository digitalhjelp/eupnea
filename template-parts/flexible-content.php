<?php
/**
 * Fleksibelt innhold – looper gjennom alle ACF-moduler
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

if (!function_exists('have_rows') || !have_rows('page_modules')) {
    return;
}

while (have_rows('page_modules')) :
    the_row();

    $layout = get_row_layout();

    // Koble layoutnavn til modul-fil
    $module_map = [
        'hero'          => 'hero',
        'services'      => 'services',
        'about'         => 'about',
        'team'          => 'team',
        'mentors'       => 'mentors',
        'partners'      => 'partners',
        'testimonials'  => 'testimonials',
        'why_how_where' => 'why-how-where',
        'contact'       => 'contact',
    ];

    if (isset($module_map[$layout])) {
        $module_file = EUPNEA_DIR . '/modules/' . $module_map[$layout] . '.php';
        if (file_exists($module_file)) {
            include $module_file;
        }
    }

endwhile;
