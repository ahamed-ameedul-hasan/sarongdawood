<?php
/**
 * Razzi init
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
 * Razzi theme init
 */
final class Theme {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance = null;

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
		require_once get_template_directory() . '/inc/class-razzi-autoload.php';
		require_once get_template_directory() . '/inc/libs/class-mobile_detect.php';
		if ( is_admin() ) {
			require_once get_template_directory() . '/inc/libs/class-tgm-plugin-activation.php';
		}

		add_action( 'after_setup_theme', array( $this, 'setup_theme' ), 2 );
		add_action( 'after_setup_theme', array( $this, 'setup_content_width' ) );
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		add_action('init', array( $this, 'init' ));

		$this->get( 'woocommerce' );
		// Admin
		$this->get( 'admin' );
	}

	/**
	 * Hooks to init
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		// Before init action.
		do_action( 'before_razzi_init' );

		// Setup
		$this->get( 'mobile' );
		$this->get( 'maintenance' );

		// Header
		$this->get( 'preloader' );
		$this->get( 'topbar' );
		$this->get( 'header' );
		$this->get( 'campaigns' );

		// Page Header
		$this->get( 'page_header' );
		$this->get( 'breadcrumbs' );

		// Layout & Style
		$this->get( 'layout' );
		$this->get( 'dynamic_css' );

		// Comments
		$this->get( 'comments' );

		//Footer
		$this->get( 'footer' );

		// Modules
		$this->get( 'search_ajax' );
		$this->get( 'newsletter' );

		// Templates
		$this->get( 'page' );

		$this->get( 'blog' );

		// wpml
		$this->get( 'wpml' );

		// Init action.
		do_action( 'after_razzi_init' );

	}

	/**
	 * Get Razzi Class.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'woocommerce':
				if ( class_exists( 'WooCommerce' ) ) {
					return WooCommerce::instance();
				}
				break;

			case 'options':
				return Options::instance();
				break;

			case 'search_ajax':
				return \Razzi\Modules\Search_Ajax::instance();
				break;

			case 'newsletter':
				return \Razzi\Modules\Newsletter_Popup::instance();
				break;

			case 'mobile':
				if ( Helper::is_mobile() ) {
					return \Razzi\Mobile::instance();
				}
				break;

			case 'wpml':
				if ( ( defined( 'ICL_SITEPRESS_VERSION' ) && ! ICL_PLUGIN_INACTIVE ) || defined( 'POLYLANG_BASENAME' ) ) {
					return \Razzi\WPML::instance();
				}
				break;

			default :
				$class = ucwords( $class );
				$class = "\Razzi\\" . $class;
				if ( class_exists( $class ) ) {
					return $class::instance();
				}
				break;
		}

	}

	/**
	 * Setup theme
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setup_theme() {

		// Theme supports
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_editor_style( 'assets/css/editor-style.css' );

		// Load regular editor styles into the new block-based editor.
		add_theme_support( 'editor-styles' );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'align-wide' );

		add_theme_support( 'align-full' );

		add_image_size( 'razzi-blog-grid', 600, 398, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary'    => esc_html__( 'Primary Menu', 'razzi' ),
			'secondary'  => esc_html__( 'Secondary Menu', 'razzi' ),
			'hamburger'  => esc_html__( 'Hamburger Menu', 'razzi' ),
			'socials'    => esc_html__( 'Social Menu', 'razzi' ),
			'department' => esc_html__( 'Department Menu', 'razzi' ),
			'mobile'     => esc_html__( 'Mobile Menu', 'razzi' ),
			'user_logged'     => esc_html__( 'User Logged Menu', 'razzi' ),
		) );

	}

	/**
	 * Set the $content_width global variable used by WordPress to set image dimennsions.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setup_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'razzi_content_width', 640 );
	}

	/**
	 * Register widget area.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function widgets_init() {
		$sidebars = array(
			'blog-sidebar'           => esc_html__( 'Blog Sidebar', 'razzi' ),
			'footer-links'           => esc_html__( 'Footer Links', 'razzi' )
		);

		// Register footer sidebars
		for ( $i = 1; $i <= 5; $i ++ ) {
			$sidebars["footer-$i"] = esc_html__( 'Footer', 'razzi' ) . " $i";
		}

		// Register sidebars
		foreach ( $sidebars as $id => $name ) {
			register_sidebar(
				array(
					'name'          => $name,
					'id'            => $id,
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				)
			);
		}

	}

	/**
	 * Setup the theme global variable.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setup_prop( $args = array() ) {
		$default = array(
			'modals' => array(),
		);

		if ( isset( $GLOBALS['razzi'] ) ) {
			$default = array_merge( $default, $GLOBALS['razzi'] );
		}

		$GLOBALS['razzi'] = wp_parse_args( $args, $default );
	}

	/**
	 * Get a propery from the global variable.
	 *
	 * @param string $prop Prop to get.
	 * @param string $default Default if the prop does not exist.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_prop( $prop, $default = '' ) {
		self::setup_prop(); // Ensure the global variable is setup.

		return isset( $GLOBALS['razzi'], $GLOBALS['razzi'][ $prop ] ) ? $GLOBALS['razzi'][ $prop ] : $default;
	}

	/**
	 * Sets a property in the global variable.
	 *
	 * @param string $prop Prop to set.
	 * @param string $value Value to set.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function set_prop( $prop, $value = '' ) {
		if ( ! isset( $GLOBALS['razzi'] ) ) {
			self::setup_prop();
		}

		if ( ! isset( $GLOBALS['razzi'][ $prop ] ) ) {
			$GLOBALS['razzi'][ $prop ] = $value;

			return;
		}

		if ( is_array( $GLOBALS['razzi'][ $prop ] ) ) {
			if ( is_array( $value ) ) {
				$GLOBALS['razzi'][ $prop ] = array_merge( $GLOBALS['razzi'][ $prop ], $value );
			} else {
				$GLOBALS['razzi'][ $prop ][] = $value;
				array_unique( $GLOBALS['razzi'][ $prop ] );
			}
		} else {
			$GLOBALS['razzi'][ $prop ] = $value;
		}
	}
}
