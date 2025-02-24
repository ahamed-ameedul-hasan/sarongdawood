<?php
/**
 * Woocommerce Setup functions and definitions.
 *
 * @package Razzi
 */

namespace Razzi\WooCommerce;
use Razzi\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Woocommerce initial
 *
 */
class Setup {
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
		add_filter( 'woocommerce_get_image_size_gallery_thumbnail', array(
			$this,
			'get_gallery_thumbnail_size'
		) );
	}

	/**
	 * Set the gallery thumbnail size.
	 *
	 * @since 1.0.0
	 *
	 * @param array $size Image size.
	 *
	 * @return array
	 */
	public function get_gallery_thumbnail_size( $size ) {
		$size['width'] = 130;
		$size['height'] = 0;
		$size['crop']   = 1;

		return $size;
	}

}
