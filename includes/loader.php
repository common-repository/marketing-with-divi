<?php
/**
 * Registers all modules from the "modules" folder with Divi.
 *
 * @package MarketingWithDivi
 *
 * Note: The "modules/index.js" file must include all modules as well, though there
 *       we list each module explicitely!
 */

if ( ! class_exists( 'ET_Builder_Element' ) ) {
	return;
}

$module_files = glob( __DIR__ . '/modules/*/*.php' );

// Load custom Divi Builder modules.
foreach ( (array) $module_files as $module_file ) {
	if ( $module_file && preg_match( "/\/modules\/\b([^\/]+)\/\\1\.php$/", $module_file ) ) {
		require_once $module_file;
	}
}
