<?php
/**
 * Mobile functions and definitions.
 *
 * @package Razzi
 */

namespace Razzi\Mobile;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Mobile initial
 *
 */
class Single_Product {
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
		add_filter( 'razzi_product_gallery_zoom', '__return_false' );
		add_action( 'wp', array( $this, 'hooks' ), 0 );
	}

	/**
	 * Hooks
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function hooks() {
		if ( ! is_singular( 'product' ) ) {
			return;
		}

		add_filter( 'body_class', array( $this, 'body_class' ) );

		add_filter( 'post_class', array( $this, 'product_class' ), 10, 3 );

		add_filter( 'razzi_single_get_product_layout', array( $this, 'get_mobile_product_layout' ) );
		add_filter( 'razzi_get_product_tabs_status', array( $this, 'product_tabs_status' ) );
		add_filter( 'razzi_product_add_to_cart_sticky', '__return_false' );

		add_filter('razzi_get_product_tabs_position', array( $this, 'product_tabs_position' ) );

		//remove_action( 'woocommerce_single_product_summary', array( \Razzi\Theme::instance()->get( 'woocommerce' )->get_template( 'single_product' ), 'open_summary_top_wrapper' ), 2 );

		//remove_action( 'woocommerce_single_product_summary', array( \Razzi\Theme::instance()->get( 'woocommerce' )->get_template( 'single_product' ), 'close_summary_top_wrapper' ), 4 );

		remove_action( 'woocommerce_single_product_summary', array( \Razzi\Theme::instance()->get( 'woocommerce' )->get_template( 'single_product' ), 'product_data_tabs' ), 100 );
		add_action( 'woocommerce_after_single_product_summary', array( \Razzi\Theme::instance()->get( 'woocommerce' )->get_template( 'single_product' ), 'product_data_tabs' ), 10 );

	}

	/**
	 * Adds classes to body
     *
	 * @since 1.0.0
	 *
	 * @param string $class Post class.
	 *
	 * @return array
	 */
	public function body_class( $classes ) {
		if( \Razzi\Helper::get_option('product_auto_background') ) {
			$classes[] = 'product-has-background';
		}

		return $classes;
	}

	/**
	 * Adds classes to products
     *
	 * @since 1.0.0
	 *
	 * @param string $class Post class.
	 *
	 * @return array
	 */
	public function product_class( $classes ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return $classes;
		}

		$classes[] = 'product-tabs-under-summary';

		return $classes;
	}

	/**
	 * Get product layout
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_mobile_product_layout() {
		return 'v1';
	}

		/**
	 * Get product layout
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function product_tabs_position() {
		return 'under_summary';
	}

	/**
	 * Get product tabs status
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function product_tabs_status() {
		return \Razzi\Helper::get_option('mobile_product_tabs_status');
	}
}
