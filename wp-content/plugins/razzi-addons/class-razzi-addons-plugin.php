<?php
/**
 * Razzi Addons init
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Razzi
 */

namespace Razzi;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Razzi Addons init
 *
 * @since 1.0.0
 */
class Addons {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
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
		add_action( 'plugins_loaded', array( $this, 'load_templates' ) );
	}

	/**
	 * Load Templates
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_templates() {
		$this->includes();
		spl_autoload_register( '\Razzi\Addons\Auto_Loader::load' );

		add_action('init', array( $this, 'init' ));

		add_action( 'widgets_init', array( $this, 'register_widgets' ) );

		$this->get( 'importer' );

		// Modules
		$this->get( 'modules' );
	}

	/**
	 * Includes files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		// Auto Loader
		require_once RAZZI_ADDONS_DIR . 'class-razzi-addons-autoloader.php';
		\Razzi\Addons\Auto_Loader::register( [
			'Razzi\Addons\Helper'         => RAZZI_ADDONS_DIR . 'class-razzi-addons-helper.php',
			'Razzi\Addons\Widgets'        => RAZZI_ADDONS_DIR . 'inc/widgets/class-razzi-addons-widgets.php',
			'Razzi\Addons\Modules'        => RAZZI_ADDONS_DIR . 'modules/modules.php',
			'Razzi\Addons\Elementor'      => RAZZI_ADDONS_DIR . 'inc/elementor/class-razzi-elementor.php',
			'Razzi\Addons\Product_Brands' => RAZZI_ADDONS_DIR . 'inc/backend/class-razzi-addons-product-brand.php',
			'Razzi\Addons\Product_Authors'=> RAZZI_ADDONS_DIR . 'inc/backend/class-razzi-addons-product-author.php',
			'Razzi\Addons\Importer'       => RAZZI_ADDONS_DIR . 'inc/backend/class-razzi-addons-importer.php',
		] );
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		// Before init action.
		do_action( 'before_razzi_init' );

		$this->get( 'product_brand' );
		$this->get( 'product_author' );

		// Elmentor
		$this->get( 'elementor' );

		// Init action.
		do_action( 'after_razzi_init' );
	}

	public function register_widgets() {
		// Widgets
		$this->get( 'widgets' );
	}

	/**
	 * Get Razzi Addons Class instance
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'product_brand':
				if ( class_exists( 'WooCommerce' ) ) {
					return \Razzi\Addons\Product_Brands::instance();
				}
				break;
			case 'product_author':
				if ( class_exists( 'WooCommerce' ) ) {
					return \Razzi\Addons\Product_Authors::instance();
				}
				break;
			case 'importer':
				if ( is_admin() ) {
					return \Razzi\Addons\Importer::instance();
				}
				break;
			case 'elementor':
				if ( did_action( 'elementor/loaded' ) ) {
					return \Razzi\Addons\Elementor::instance();
				}
				break;

			case 'modules':
				return \Razzi\Addons\Modules::instance();
				break;

			case 'widgets':
				return \Razzi\Addons\Widgets::instance();
				break;
		}
	}

}
