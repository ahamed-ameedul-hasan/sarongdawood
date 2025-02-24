<?php
/**
 * Hooks of single product.
 *
 * @package Razzi
 */

namespace Razzi\WooCommerce\Elements;
use Razzi\WooCommerce\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of single product template.
 */
class Product_Listing {
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
		// Adds a class of product layout to product page.
		add_action( 'razzi_woocommerce_before_single_product_listing', 'woocommerce_show_product_images', 20 );
		add_action( 'razzi_woocommerce_single_product_listing', 'woocommerce_template_single_title', 5 );

		// Re-order the stars rating.
		add_action( 'razzi_woocommerce_single_product_listing', 'woocommerce_template_single_rating', 8 );

		if ( apply_filters( 'razzi_product_show_price', true ) ) {
			add_action( 'razzi_woocommerce_single_product_listing', 'woocommerce_template_single_price', 10 );
		}

		add_action( 'razzi_woocommerce_single_product_listing', array( $this, 'in_stock' ), 11 );

		add_action( 'razzi_woocommerce_single_product_listing', array( $this, 'button' ), 12 );
	}

	/**
	 * WooCommerce in stock
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function in_stock() {
		global $product;
		$in_stock = '';

		if( class_exists( '\Razzi\Addons\Helper' ) && \Razzi\Addons\Helper::is_product_deal( $product ) ) {
			$limit = intval( get_post_meta( $product->get_id(), '_deal_quantity', true ) );
			$sold = intval( get_post_meta( $product->get_id(), '_deal_sales_counts', true ) );
			if( $limit > $sold ) {
				$in_stock = $limit - $sold . esc_html__( ' in stock', 'razzi' );
			}
		} else {
			$availability = $product->get_availability();
			$in_stock = $availability['availability'];
		}

		if ( ! empty ( $in_stock ) ) {
			echo '<div class="rz-stock">' . esc_html__( 'Availability: ', 'razzi' ) . '<span>' . $in_stock . '</span></div>';
		}
	}

	/**
	 * Add button link to product details page
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function button() {
		echo '<a class="razzi-button" href="'. get_permalink() .'">'. esc_html__( 'Shop Now', 'razzi' ) . \Razzi\Icon::get_svg( 'arrow-right' ) . '</a>';
	}
}
