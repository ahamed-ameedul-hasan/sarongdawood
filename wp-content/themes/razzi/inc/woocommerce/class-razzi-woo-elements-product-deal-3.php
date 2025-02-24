<?php
/**
 * Product Deal 2 template hooks.
 *
 * @package Razzi
 */

namespace Razzi\WooCommerce\Elements;
use Razzi\WooCommerce\Helper;
use Razzi\WooCommerce\Template\Product_Loop;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Product Deal 3
 */
class Product_Deal_3 {
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
		// Template product deal
		add_action( 'razzi_deal3_woocommerce_before_shop_loop_item', array( $this, 'product_wrapper_open' ), 10 );
		add_action( 'razzi_deal3_woocommerce_after_shop_loop_item', array( $this, 'product_wrapper_close' ), 1000 );

		add_action( 'razzi_deal3_woocommerce_before_shop_loop_item_title', array(
			$this,
			'product_loop_thumbnail'
		), 1 );

		// Group elements bellow product thumbnail.
		add_action( 'razzi_deal3_woocommerce_shop_loop_item_title', array( $this, 'summary_wrapper_open' ), 1 );
		add_action( 'razzi_deal3_woocommerce_after_shop_loop_item', array( $this, 'summary_wrapper_close' ), 1000 );

		// Change the product title.
		add_action( 'razzi_deal3_woocommerce_shop_loop_item_title', array( Helper::instance(), 'product_loop_title' ) );

		// Add rating
		add_action( 'razzi_deal3_woocommerce_after_shop_loop_item_title', array( Product_Loop::instance(), 'rating_counts' ), 20 );

		// Add Price
		if ( apply_filters( 'razzi_product_loop_show_price', true ) ) {
			add_action( 'razzi_deal3_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 20 );
		}

		// Add product deal
		add_action( 'razzi_deal3_woocommerce_after_shop_loop_item_title', array( $this, 'product_deal_outside' ), 20 );

		// Add in stock
		add_action( 'razzi_deal3_woocommerce_after_shop_loop_item_title', array( $this, 'in_stock' ), 20 );

		add_action( 'razzi_deal3_woocommerce_shop_loop_item_title', array( Helper::instance(), 'product_taxonomy' ), 5 );

		if ( apply_filters( 'razzi_product_loop_show_atc', true ) ) {
			add_action( 'razzi_deal3_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 50 );
		}
	}

	/**
	 * Open product wrapper.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_wrapper_open() {
		echo '<div class="product-inner">';
	}

	/**
	 * Close product wrapper.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_wrapper_close() {
		echo '</div>';
	}

	/**
	 * Open product summary wrapper.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function summary_wrapper_open() {
		echo '<div class="product-summary">';
	}

	/**
	 * Close product summary wrapper.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function summary_wrapper_close() {
		echo '</div>';
	}

	/**
	 * Open product Loop buttons.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_loop_buttons_open() {
		echo '<div class="product-loop__buttons">';
	}

	/**
	 * Close product Loop buttons.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_loop_buttons_close() {
		echo '</div>';
	}

	/**
	 * WooCommerce template deal thumbnail
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function product_loop_thumbnail() {
		echo '<div class="product-thumbnail">';

		woocommerce_template_loop_product_link_open();
		woocommerce_template_loop_product_thumbnail();
		woocommerce_template_loop_product_link_close();

		$this->product_loop_buttons_open();

		if ( apply_filters( 'razzi_product_loop_show_atc', true ) ) {
			woocommerce_template_loop_add_to_cart();
		}

		Helper::quick_view_button();

		Helper::wishlist_button();

		$this->product_loop_buttons_close();

		echo '</div>';
	}

	/**
	 * WooCommerce get deal outside the image.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_deal_outside() {
		if ( ! class_exists( '\Razzi\Addons\Modules\Product_Deals\Frontend' ) ) {
			return;
		}

		$atts = \Razzi\Addons\Modules\Product_Deals\Frontend::get_product_deal_attrs();
		if( ! $atts ) {
			return;
		}
		$expire = $atts['expire'];
		$texts = class_exists('\Razzi\Addons\Helper') ? \Razzi\Addons\Helper::get_countdown_texts() : array();
		echo sprintf('<div class="product-deal-3-countdown" data-expire="%s" data-text=%s></div>', esc_attr( $expire ), wp_json_encode($texts));

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
		if ( ! class_exists( '\Razzi\Addons\Modules\Product_Deals\Frontend' ) ) {
			return;
		}
		$in_stock = '';
		$sold = $limit = 0;
		$atts = \Razzi\Addons\Modules\Product_Deals\Frontend::get_product_deal_attrs();
		if( ! $atts ) {
			$availability = $product->get_availability();
			$in_stock = $availability['availability'];
		} else {
			$limit = $atts['limit'];
			$sold = $atts['sold'];
			if( $limit > $sold ) {
				$in_stock = $limit - $sold . esc_html__( ' in stock', 'razzi' );
			}
		}

		$width = ( $sold == 0 && $limit == 0 ) ? 0 : $sold / $limit * 100;
		if( $width ) {
			echo '<div class="deal-progress"><div class="progress-bar"><div class="progress-value" style="width: ' . $width . '%"></div></div></div>';
		}

		if ( ! empty ( $in_stock ) ) {
			echo '<div class="rz-stock">' . esc_html__( 'Availability: ', 'razzi' ) . '<span>' . $in_stock . '</span></div>';
		}
	}
}
