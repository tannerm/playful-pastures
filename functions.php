<?php
/**
 * Church Plugins - Default Theme Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Church Plugins - Default Theme
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_CHURCH_PLUGINS_DEFAULT_THEME_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'church-plugins-default-theme-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_CHURCH_PLUGINS_DEFAULT_THEME_VERSION, 'all' );
    wp_enqueue_style( 'leafletcss', 'http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css', array(), CHILD_THEME_CHURCH_PLUGINS_DEFAULT_THEME_VERSION, 'all' );
    wp_enqueue_script( 'leafletjs', 'http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js', array(), CHILD_THEME_CHURCH_PLUGINS_DEFAULT_THEME_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );