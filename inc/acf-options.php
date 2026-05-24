<?php
/**
 * ACF Options Pages
 * Registrerer globale opsjonssider via ACF (krever ACF 5.x+)
 *
 * @package Eupnea
 */

defined('ABSPATH') || exit;

if (!function_exists('acf_add_options_page')) {
    return; // ACF ikke aktivert
}

// Hoved-opsjonsside (under Eupnea-menyen)
acf_add_options_page([
    'page_title'  => __('Eupnea Nettsted-innstillinger', 'eupnea'),
    'menu_title'  => __('ACF Innstillinger', 'eupnea'),
    'menu_slug'   => 'eupnea-acf-settings',
    'parent_slug' => 'eupnea-settings',
    'capability'  => 'manage_options',
    'redirect'    => false,
    'icon_url'    => '',
    'position'    => false,
]);

// Underside: Header
acf_add_options_sub_page([
    'page_title'  => __('Header-innstillinger', 'eupnea'),
    'menu_title'  => __('Header', 'eupnea'),
    'parent_slug' => 'eupnea-acf-settings',
]);

// Underside: Footer
acf_add_options_sub_page([
    'page_title'  => __('Footer-innstillinger', 'eupnea'),
    'menu_title'  => __('Footer', 'eupnea'),
    'parent_slug' => 'eupnea-acf-settings',
]);
