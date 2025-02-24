<?php
/**
 * Woocommerce Widgets functions and definitions.
 *
 * @package Razzi
 */

namespace Razzi\WooCommerce;
use Razzi\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Woocommerce Widgets initial
 *
 */
class Sidebars {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'dynamic_sidebar_params', array( $this, 'woocommerce_dynamic_sidebar_params' ) );
	}

	/**
	 * Dynamic Sidebar Params.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function woocommerce_dynamic_sidebar_params( $params ) {
		global $wp_registered_widgets;

		$settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];

		if ( ! is_object( $settings_getter ) ) {
			return $params;
		}

		$settings        = $settings_getter->get_settings();
		$settings        = $settings[ $params[1]['number'] ];

		if ( $params[0]['after_widget'] == '</div></div>' && isset( $settings['title'] ) && empty( $settings['title'] ) ) {
			$params[0]['before_widget'] .= '<div class="content">';
		}

		return $params;
	}

}
