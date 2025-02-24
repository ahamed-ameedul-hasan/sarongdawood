<?php
/**
 * Mini Cart template hooks.
 *
 * @package Razzi
 */

namespace Razzi\WooCommerce\Modules;

use Razzi\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Mini Cart template.
 */
class Wishlist {
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
		// Ajax update mini cart.
		add_action( 'wc_ajax_update_wishlist_item', array( $this, 'update_wishlist_item' ) );

		if( function_exists('wcboost_wishlist') ) {
			add_filter( 'wcboost_wishlist_add_to_wishlist_fragments', array( $this, 'update_wishlist_count' ), 10, 1 );
			add_filter( 'wcboost_wishlist_button_template_args', array( $this, 'wishlist_args' ), 20, 3 );
			add_filter( 'wcboost_wishlist_svg_icon', array( $this, 'wishlist_svg_icon' ), 20, 3 );
			add_action( 'wcboost_wishlist_after_item_name', array( $this, 'wishlist_table' ), 10, 3 );
		}
	}

	/**
	 * Update a single cart item.
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function update_wishlist_item() {
		if( function_exists('wcboost_wishlist') && class_exists( '\WCBoost\Wishlist\Helper' ) ) {
			wp_send_json( \WCBoost\Wishlist\Helper::get_wishlist()->count_items() );
		} elseif ( function_exists( 'YITH_WCWL' ) ) {
			wp_send_json( YITH_WCWL()->count_products() );
		} else {
			return;
		}
	}

	/**
	 * Ajaxify update count wishlist
	 *
	 * @since 1.0
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	public function update_wishlist_count($data) {
		$data['.header-wishlist .wishlist-counter'] = '<span class="counter wishlist-counter">'.\WCBoost\Wishlist\Helper::get_wishlist()->count_items() . '</span>';

		return $data;
	}

	/**
	 * Wishlist array
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function wishlist_args($args, $wishlist, $product) {
		$args['class'][] = esc_attr( 'rz-loop_button' );
		$args['product_title'] = $product->get_title();
		return $args;
	}

	/**
	 * Wishlist icon
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function wishlist_svg_icon($svg, $icon) {
		if( $icon == 'heart' ) {
			$svg = \Razzi\Icon::get_svg( 'heart', '', 'shop' );
		} elseif( $icon == 'heart-filled' ) {
			$svg = \Razzi\Icon::get_svg( 'heart', '', 'shop' );
		}

		return $svg;
	}

	/**
	 * Wishlist table
	 *
	 * @return void
	 */
	public function wishlist_table( $item, $item_key, $wishlist ) {
		$_product = $item->get_product();
		$columns = (array) get_option( 'wcboost_wishlist_table_columns' );
		?>
			<?php if( isset( $columns['price'] ) && $columns['price'] == 'yes' ) : ?>
				<div class="product-price hidden-lg hidden-md">
					<span class="label"><?php esc_html_e( 'Price', 'razzi' ); ?></span>
					<span class="price"><?php echo wp_kses_post( $_product->get_price_html() ); ?></span>
				</div>
			<?php endif; ?>

			<?php if( isset( $columns['stock'] ) && $columns['stock'] == 'yes' ) : ?>
				<div class="product-stock-status hidden-lg hidden-md">
					<span class="label"><?php esc_html_e( 'Stock', 'razzi' ); ?></span>
					<?php
					$availability = $_product->get_availability();
					printf( '<span class="%s">%s</span>', esc_attr( $availability['class'] ), $availability['availability'] ? esc_html( $availability['availability'] ) : esc_html__( 'In Stock', 'razzi' ) );
					?>
				</div>
			<?php endif; ?>

			<?php if ( isset( $columns['date'] ) && $columns['date'] == 'yes' ) : ?>
				<div class="product-date hidden-lg hidden-md">
					<?php echo esc_html( $item->get_date_added()->format( get_option( 'date_format' ) ) ); ?>
				</div>
			<?php endif; ?>
		<?php
	}

}
