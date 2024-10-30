<?php
/**
 * Plugin that adds custom modules to Divi.
 *
 * @package     MarketingWithDivi
 * @author      Philipp Stracker
 * @license     GPL2+
 *
 * Plugin Name: Marketing With Divi
 * Plugin URI:  http://philippstracker.com/
 * Description: A collection of marketing related Divi modules.
 * Version:     1.0.0
 * Author:      Philipp Stracker
 * Author URI:  https://philippstracker.com/
 * License:     GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: marketing-with-divi
 * Domain Path: /lang
 *
 * Marketing With Divi is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Marketing With Divi is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Marketing With Divi. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function evrdm_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/MarketingWithDivi.php';
}
add_action( 'divi_extensions_init', 'evrdm_initialize_extension' );

/**
 * Load translations for Marketing with Divi.
 *
 * @since 1.0.0
 */
function myplugin_load_textdomain() {
	load_plugin_textdomain(
		'marketing-with-divi',
		false,
		basename( dirname( __FILE__ ) ) . '/lang'
	);
}

add_action( 'plugins_loaded', 'myplugin_load_textdomain' );
