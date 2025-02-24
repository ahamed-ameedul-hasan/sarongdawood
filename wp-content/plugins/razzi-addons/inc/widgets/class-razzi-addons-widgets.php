<?php
/**
 * Load and register widgets
 *
 * @package Razzi
 */

namespace Razzi\Addons;
/**
 * Razzi theme init
 */
class Widgets {

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
		$this->includes();
		$this->add_actions();
	}

	/**
	 * Include Files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function includes() {
		\Razzi\Addons\Auto_Loader::register( [
			'Razzi\Addons\Widgets\Social_Links'    => RAZZI_ADDONS_DIR . 'inc/widgets/class-razzi-addons-socials.php',
			'Razzi\Addons\Widgets\Filter_By_Attributes'    => RAZZI_ADDONS_DIR . 'inc/widgets/class-razzi-addons-filter-by-attributes.php',
		] );
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_actions() {
		register_widget( new \Razzi\Addons\Widgets\Social_Links() );
		if ( class_exists( 'WeDevs_Dokan' ) ) {
			register_widget( new \Razzi\Addons\Widgets\Filter_By_Attributes() );
		}
	}
}