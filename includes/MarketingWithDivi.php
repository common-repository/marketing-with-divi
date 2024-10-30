<?php
/**
 * The place, where we register our Divi Extension.
 *
 * @package MarketingWithDivi
 */

/**
 * Initialize our custom Divi module.
 *
 * This class simply tells Divi that we have an extension and where to find the
 * module files.
 */
class EVRDM_MarketingWithDivi extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'marketing-with-divi';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'marketing-with-divi';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * EVRDM_MarketingWithDivi constructor.
	 *
	 * @param string $name The module name.
	 * @param array  $args Eventual arguments.
	 */
	public function __construct( $name = 'marketing-with-divi', $args = [] ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}
}

new EVRDM_MarketingWithDivi();
