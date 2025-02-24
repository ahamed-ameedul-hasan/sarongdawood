<?php
/**
 * Woocommerce functions and definitions.
 *
 * @package Razzi
 */

namespace Razzi;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Woocommerce initial
 *
 */
class WooCommerce {
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
		add_action( 'after_setup_theme', array( $this, 'woocommerce_setup' ) );
		add_action( 'widgets_init', array( $this, 'woocommerce_widgets_register' ) );
		add_action('init', array( $this, 'init' ));
		add_action( 'wp', array( $this, 'add_actions' ), 10 );

		$this->get( 'customizer' );
	}

	/**
	 * WooCommerce setup function.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function woocommerce_setup() {
		add_theme_support( 'woocommerce', array(
			'product_grid' => array(
				'default_rows'    => 4,
				'min_rows'        => 2,
				'max_rows'        => 20,
				'default_columns' => 4,
				'min_columns'     => 2,
				'max_columns'     => 7,
			),
			'wishlist' => array(
				'single_button_position' => 'theme',
				'loop_button_position'   => 'theme',
				'button_type'   => 'theme',
			),
		) );

		if ( apply_filters('razzi_product_gallery_zoom', intval( Helper::get_option( 'product_image_zoom' ) ) ) ) {
			add_theme_support( 'wc-product-gallery-zoom' );
		}
		if ( intval( Helper::get_option( 'product_image_lightbox' ) ) ) {
			add_theme_support( 'wc-product-gallery-lightbox' );
		}

		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * Register widget areas.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function woocommerce_widgets_register() {
		$after_title = '</h4>';
		if ( intval( Helper::get_option( 'catalog_widget_collapse_content' ) ) ) {
			$after_title = \Razzi\Icon::get_svg( 'chevron-bottom' ) . '</h4>';
		}

		register_sidebar( array(
			'name'          => esc_html__( 'Catalog Sidebar', 'razzi' ),
			'id'            => 'catalog-sidebar',
			'description'   => esc_html__( 'Add sidebar for the catalog page', 'razzi' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => $after_title
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Catalog Filters Sidebar', 'razzi' ),
			'id'            => 'catalog-filters-sidebar',
			'description'   => esc_html__( 'Add sidebar for filters toolbar of the catalog page', 'razzi' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '<span class="razzi-svg-icon "><svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.95544 5.78413L0.225765 1.25827C-0.0752554 0.970375 -0.0752554 0.503596 0.225765 0.215837C0.526517 -0.0719456 1.01431 -0.0719456 1.31504 0.215837L5.50008 4.22052L9.68498 0.215953C9.98585 -0.0718292 10.4736 -0.0718292 10.7743 0.215953C11.0752 0.503736 11.0752 0.970491 10.7743 1.25839L6.04459 5.78424C5.89414 5.92814 5.69717 6 5.5001 6C5.30294 6 5.10582 5.928 4.95544 5.78413Z"/> </svg></span></h4>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Catalog Filters Mobile', 'razzi' ),
			'id'            => 'catalog-filters-mobile',
			'description'   => esc_html__( 'Add sidebar for catalog filters on the mobile version', 'razzi' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '<span class="razzi-svg-icon "><svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.95544 5.78413L0.225765 1.25827C-0.0752554 0.970375 -0.0752554 0.503596 0.225765 0.215837C0.526517 -0.0719456 1.01431 -0.0719456 1.31504 0.215837L5.50008 4.22052L9.68498 0.215953C9.98585 -0.0718292 10.4736 -0.0718292 10.7743 0.215953C11.0752 0.503736 11.0752 0.970491 10.7743 1.25839L6.04459 5.78424C5.89414 5.92814 5.69717 6 5.5001 6C5.30294 6 5.10582 5.928 4.95544 5.78413Z"/> </svg></span></h4>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Single Product Sidebar', 'razzi' ),
			'id'            => 'single-product-sidebar',
			'description'   => esc_html__( 'Add sidebar for the product page', 'razzi' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Single Product Extra Content', 'razzi' ),
			'id'            => 'single-product-extra-content',
			'description'   => esc_html__( 'Add sidebar for the product page', 'razzi' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );

	}

	/**
	 * WooCommerce Init
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		$this->get( 'setup' );
		$this->get( 'sidebars' );
		$this->get( 'cache' );
		$this->get( 'dynamic_css' );
		$this->get( 'cat_settings' );
		$this->get( 'product_settings' );

		$this->get_template( 'general' );
		$this->get_template( 'product_loop' );

		$this->get_element( 'deal' );
		$this->get_element( 'deal2' );
		$this->get_element( 'deal3' );
		$this->get_element( 'masonry' );
		$this->get_element( 'showcase' );
		$this->get_element( 'product_slider' );
		$this->get_element( 'listing' );
		$this->get_element( 'summary' );
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_actions() {
		$this->get_template( 'catalog' );
		$this->get_template( 'single_product' );
		$this->get_template( 'account' );
		$this->get_template( 'cart' );
		$this->get_template( 'checkout' );

		$this->get_module( 'badges' );
		$this->get_module( 'quick_view' );
		$this->get_module( 'notices' );
		$this->get_module( 'recently_viewed' );
		$this->get_module( 'sticky_atc' );
		$this->get_module( 'login_ajax' );
		$this->get_module( 'mini_cart' );
		$this->get_module( 'wishlist' );
		$this->get_module( 'compare' );
		$this->get_module( 'product_attribute' );

		if ( class_exists( 'WeDevs_Dokan' ) ) {
			\Razzi\Vendor\Dokan::instance();
		}
	}

	/**
	 * Get WooCommerce Class Init.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'setup':
				return \Razzi\WooCommerce\Setup::instance();
				break;
			case 'sidebars':
				return \Razzi\WooCommerce\Sidebars::instance();
				break;
			case 'customizer':
				return \Razzi\WooCommerce\Customizer::instance();
				break;
			case 'cache':
				return \Razzi\WooCommerce\Cache::instance();
				break;
			case 'dynamic_css':
				return \Razzi\WooCommerce\Dynamic_CSS::instance();
				break;
			case 'cat_settings':
				if ( is_admin() ) {
					return \Razzi\WooCommerce\Settings\Category::instance();
				}
				break;

			case 'product_settings':
				if ( is_admin() ) {
					return \Razzi\WooCommerce\Settings\Product::instance();
				}
				break;
		}
	}

	/**
	 * Get WooCommerce Template Class.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get_template( $class ) {
		switch ( $class ) {
			case 'general':
				return \Razzi\WooCommerce\Template\General::instance();
				break;
			case 'product_loop':
				return \Razzi\WooCommerce\Template\Product_Loop::instance();
				break;
			case 'catalog':
				if ( \Razzi\Helper::is_catalog() ) {
					return \Razzi\WooCommerce\Template\Catalog::instance();
				}
				break;
			case 'single_product':
				if ( is_singular( 'product' ) || is_page() ) {
					return \Razzi\WooCommerce\Template\Single_Product::instance();
				}
				break;
			case 'account':
				return \Razzi\WooCommerce\Template\Account::instance();
				break;
			case 'cart':
				if ( function_exists('is_cart') && is_cart() ) {
					return \Razzi\WooCommerce\Template\Cart::instance();
				}
				break;
			case 'checkout':
				if ( function_exists('is_checkout') && is_checkout() ) {
					return \Razzi\WooCommerce\Template\Checkout::instance();
				}
				break;
			default :
				break;
		}
	}

	/**
	 * Get WooCommerce Elements.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get_element( $class ) {
		switch ( $class ) {
			case 'deal':
				return \Razzi\WooCommerce\Elements\Product_Deal::instance();
				break;
			case 'deal2':
				return \Razzi\WooCommerce\Elements\Product_Deal_2::instance();
				break;
			case 'deal3':
				return \Razzi\WooCommerce\Elements\Product_Deal_3::instance();
				break;
			case 'masonry':
				return \Razzi\WooCommerce\Elements\Product_Masonry::instance();
				break;
			case 'showcase':
				return \Razzi\WooCommerce\Elements\Product_ShowCase::instance();
				break;
			case 'product_slider':
				return \Razzi\WooCommerce\Elements\Product_Slider::instance();
				break;
			case 'listing':
				return \Razzi\WooCommerce\Elements\Product_Listing::instance();
				break;
			case 'summary':
				return \Razzi\WooCommerce\Elements\Product_Summary::instance();
				break;
		}
	}

	/**
	 * Get Module.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get_module( $class ) {
		switch ( $class ) {
			case 'badges':
				return \Razzi\WooCommerce\Modules\Badges::instance();
				break;
			case 'quick_view':
				return \Razzi\WooCommerce\Modules\Quick_View::instance();
				break;
			case 'notices':
				return \Razzi\WooCommerce\Modules\Notices::instance();
				break;
			case 'recently_viewed':
				return \Razzi\WooCommerce\Modules\Recently_Viewed::instance();
				break;
			case 'login_ajax':
				return \Razzi\WooCommerce\Modules\Login_AJAX::instance();
				break;
			case 'mini_cart':
				return \Razzi\WooCommerce\Modules\Mini_Cart::instance();
				break;
			case 'wishlist':
				return \Razzi\WooCommerce\Modules\Wishlist::instance();
			case 'compare':
				if( function_exists('wcboost_products_compare') ) {
					return \Razzi\WooCommerce\Modules\Compare::instance();
				}
				break;
			case 'product_attribute':
				if( ! in_array(Helper::get_option( 'product_loop_layout' ), array( '1', '2', '3', '4', '5', '6', '10', '12' ) ) ) {
					return;
				}
				if(  empty(Helper::get_option('product_loop_attribute') ) ) {
					return;
				}
				if( Helper::get_option('product_loop_attribute') == 'none' ) {
					return;
				}
				return \Razzi\WooCommerce\Modules\Product_Attribute::instance();
				break;
			case 'sticky_atc':
				if ( is_singular( 'product' ) && intval( apply_filters( 'razzi_product_add_to_cart_sticky', Helper::get_option( 'product_add_to_cart_sticky' ) ) ) ) {
					return \Razzi\WooCommerce\Modules\Sticky_ATC::instance();
				}
				break;
		}
	}

}
