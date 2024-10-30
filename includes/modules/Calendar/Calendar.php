<?php
/**
 * Custom Divi Module.
 *
 * @package MarketingWithDivi
 */

/**
 * The "Calendar" module.
 */
class EVRDM_Calender extends ET_Builder_Module {

	/**
	 * The module slug (i.e. shortcode-name)
	 *
	 * @var string
	 */
	public $slug = 'evrdm_calendar';

	/**
	 * Whether this module is available in Visual Builder.
	 *
	 * @var string [on|off]
	 */
	public $vb_support = 'on';

	/**
	 * Module metadata.
	 *
	 * @var array
	 */
	protected $module_credits = array(
		'module_uri' => 'http://philippstracker.com/',
		'author'     => 'Philipp Stracker',
		'author_uri' => 'https://philippstracker.com/',
	);

	/**
	 * Register the module with Divi.
	 */
	public function init() {
		$this->name      = esc_html__( 'Calendar', 'marketing-with-divi' );
		$this->icon_path = trailingslashit( __DIR__ ) . 'icon.svg';

		add_action( 'et_fb_enqueue_assets', [ $this, 'admin_scripts' ] );
	}

	/**
	 * Add JS data to the admin editor.
	 *
	 * @return void
	 */
	public function admin_scripts() {
		if ( ! is_user_logged_in() ) {
			return;
		}
		if ( ! et_core_is_fb_enabled() ) {
			return;
		}

		// Pass configuration details from WordPress admin to the JS framework.
		wp_localize_script( 'et-frontend-builder', 'evrdm', [
			'locale' => str_replace( '_', '-', get_locale() ),
		]);
	}

	/**
	 * Return list of our custom settings.
	 *
	 * @return array
	 */
	public function get_fields() {
		$fields = [];

		$fields['content'] = [
			'label'           => esc_html__( 'Content', 'marketing-with-divi' ),
			'type'            => 'tiny_mce',
			'option_category' => 'basic_option',
			'description'     => esc_html__( 'Content entered here will appear inside the module.', 'marketing-with-divi' ),
			'toggle_slug'     => 'main_content',
		];

		$fields['the_date'] = [
			'label'           => esc_html__( 'The Date', 'marketing-with-divi' ),
			'type'            => 'date_picker',
			'option_category' => 'basic_option',
			'default'         => date( 'Y-m-d H:i' ),
		];

		$fields['is_small'] = [
			'label'           => esc_html__( 'Small Calendar', 'marketing-with-divi' ),
			'type'            => 'yes_no_button',
			'options'         => [
				'on'  => 'Yes',
				'off' => 'No',
			],
			'default'         => 'off',
			'option_category' => 'basic_option',
		];

		$fields['show_time'] = [
			'label'           => esc_html__( 'Display Time', 'marketing-with-divi' ),
			'type'            => 'yes_no_button',
			'options'         => [
				'on'  => 'Yes',
				'off' => 'No',
			],
			'default'         => 'off',
			'option_category' => 'basic_option',
		];

		$fields['position'] = [
			'label'           => esc_html__( 'Calendar Position', 'marketing-with-divi' ),
			'type'            => 'select',
			'options'         => [
				'left'  => 'Left',
				'right' => 'Right',
			],
			'default'         => 'left',
			'option_category' => 'basic_option',
		];

		$fields['date_format'] = [
			'label'           => esc_html__( 'Date format', 'marketing-with-divi' ),
			'type'            => 'text',
			'default'         => 'j F',
			'option_category' => 'basic_option',
		];

		$fields['time_format'] = [
			'label'           => esc_html__( 'Time format', 'marketing-with-divi' ),
			'type'            => 'text',
			'default'         => 'G:i',
			'option_category' => 'basic_option',
			'show_if'         => [
				'show_time' => 'on',
			],
		];

		$fields['icon_top_bg_color'] = [
			'label'        => esc_html__( 'Top color', 'et_core' ),
			'type'         => 'color-alpha',
			'custom_color' => true,
			'default'      => et_builder_accent_color(),
			'toggle_slug'  => 'icon',
			'tab_slug'     => 'advanced',
		];

		$fields['icon_bottom_bg_color'] = [
			'label'        => esc_html__( 'Bottom color', 'et_core' ),
			'type'         => 'color-alpha',
			'custom_color' => true,
			'default'      => '#ffffff',
			'toggle_slug'  => 'icon',
			'tab_slug'     => 'advanced',
		];

		return $fields;
	}

	/**
	 * Render the HTML output for the front-end.
	 *
	 * This is not the editor preview!
	 *
	 * @param array  $attrs       The shortcode attributes (i.e. settings).
	 * @param string $content     Eventual shortcode-content.
	 * @param string $render_slug The shortcode slug.
	 * @return string The shortcodes HTML output.
	 */
	public function render( $attrs, $content = null, $render_slug ) {
		$the_date      = strtotime( $this->props['the_date'] );
		$content       = $this->props['content'];
		$item_classes  = array( 'evrdm_calendar_item' );
		$date_format   = $this->props['date_format'];
		$time_format   = $this->props['time_format'];
		$top_bg_col    = $this->props['icon_top_bg_color'];
		$bottom_bg_col = $this->props['icon_bottom_bg_color'];

		$date = [
			'date'      => date_i18n( 'j', $the_date ),
			'dayname'   => date_i18n( 'l', $the_date ),
			'month'     => date_i18n( 'M', $the_date ),
			'day_month' => date_i18n( $date_format, $the_date ),
			'time'      => date_i18n( $time_format, $the_date ),
		];

		if ( 'on' === $this->props['is_small'] ) {
			$item_classes[] = 'size-small';
		} else {
			$item_classes[] = 'size-big';
		}
		if ( 'on' === $this->props['show_time'] ) {
			$item_classes[] = 'date-time';
		} else {
			$item_classes[] = 'date-only';
			$date['time']   = '';
		}
		$item_classes[] = 'pos-' . $this->props['position'];

		// Calendar icon top color.
		if ( '' !== $top_bg_col ) {
			self::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .evrdm_calendar_item .icon .month',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $top_bg_col )
				),
			) );
		}

		// Calendar icon bottom color.
		if ( '' !== $bottom_bg_col ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .evrdm_calendar_item .icon',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $bottom_bg_col )
				),
			) );
		}

		return sprintf(
			'<div class="%6$s">
			<div class="icon"><span class="month">%1$s</span><span class="day">%2$s</span></div>
			<div class="dayname">%3$s</div>
			<div class="date">%4$s</div>
			<div class="time">%7$s</div>
			<div class="content">%5$s</div>
			</div>',
			$date['month'],     // 1
			$date['date'],      // 2
			$date['dayname'],   // 3
			$date['day_month'], // 4
			$content,           // 5
			implode( ' ', $item_classes ), // 6
			$date['time']       // 7
		);
	}
}

// Create a new instance of our module.
new EVRDM_Calender();
