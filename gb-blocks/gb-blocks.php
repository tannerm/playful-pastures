<?php
/**
 * Plugin Name: Gutenberg Blocks
 * Plugin URI:  https://www.multidots.com/
 * Description: Implements Hero, Current series and Message Gutenberg blocks.
 * Author:      Multidots
 * Author URI:  https://www.multidots.com/
 * Version:     1.0
 * License:     GPLv3
 * Text Domain: gbblock
 * Domain Path: languages
 *
 * Copyright (c) 2020 Multidots (email : info@multidots.com)
 *
 * @package gbblock
 * @author Multidots <info@multidots.com>
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || die;

/** Paths. */
define( 'GBBLOCK_FILE', __FILE__ );
define( 'GBBLOCK_PATH', plugin_dir_path( GBBLOCK_FILE ) );
define( 'GBBLOCK_URL', plugin_dir_url( GBBLOCK_FILE ) );
define( 'GBBLOCK_BASENAME', plugin_basename( __FILE__ ) );

/**
 * For Post Type.
 */
global $current_blog;

define( 'GBBLOCK_CONTENT_TYPE', 'post' );
define( 'GBBLOCK_CONTENT_TAXONOMY', 'category' );

/** Versions. */
define( 'GBBLOCK_VERSION', '1.0.0' );

/**
 * Function runs on plugin installation.
 *
 * @since: 1.0.0
 */
function gbblock_install() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gbblock-activator.php';

	GbBlock_Activator::activate();
}

register_activation_hook( __FILE__, 'gbblock_install' );

/**
 * Functions runs when uninstall the plugin.
 *
 * @since: 1.0.0
 */
function gbblock_uninstall() {
	// Not Required.
}

register_deactivation_hook( __FILE__, 'gbblock_uninstall' );

require_once GBBLOCK_PATH . 'includes/class-base.php';

$base = new Base();
$base->gbblock_init();
