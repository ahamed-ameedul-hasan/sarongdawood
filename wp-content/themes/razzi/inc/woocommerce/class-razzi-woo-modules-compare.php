<?php
/**
 * Compare template hooks.
 *
 * @package Razzi
 */

namespace Razzi\WooCommerce\Modules;

use Razzi\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Compare template.
 */
class Compare {
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
		add_filter( 'wcboost_products_compare_button_icon', array( $this, 'products_compare_button_icon' ), 10, 2 );

		add_filter( 'wcboost_products_compare_button_template_args', array( $this, 'products_compare_button_template_args' ), 10, 2 );

		add_filter( 'wcboost_products_compare_add_to_compare_fragments', array( $this, 'products_compare_add_to_compare_fragments' ), 10, 1 );

		// Compare button.
		$compare = \WCBoost\ProductsCompare\Frontend::instance();
		remove_action( 'woocommerce_after_add_to_cart_form', [ $compare, 'single_add_to_compare_button' ] );
		remove_action( 'woocommerce_after_shop_loop_item', [ $compare, 'loop_add_to_compare_button' ], 15 );

	}

	/**
	 * Update a single cart item.
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function products_compare_button_icon( $svg, $icon ) {
		if( $icon == 'arrows' ) {
			$svg = '<svg viewBox="0 0 30 32"><path d="M10.347 15.253l-4.565-4.587h17.685v-2.133h-17.685l4.565-4.587-1.493-1.493-7.168 7.147 7.168 7.147z"></path><path d="M21.013 15.253l-1.493 1.493 4.565 4.587h-17.621v2.133h17.621l-4.565 4.587 1.493 1.493 7.168-7.147z"></path></svg>';
		}

		return $svg;
	}

	/**
	 * Show button compare.
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function products_compare_button_template_args( $args, $product ) {
		$args['class'][] = 'rz-loop_button';
		$args['product_title'] = $product->get_title();

		return $args;
	}

	/**
	 * Ajaxify update count compare
	 *
	 * @since 1.0
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	public static function products_compare_add_to_compare_fragments( $data ) {
		$data['.compare-counter'] = '<span class="counter compare-counter">'. \WCBoost\ProductsCompare\Plugin::instance()->list->count_items() . '</span>';

		return $data;
	}
}
