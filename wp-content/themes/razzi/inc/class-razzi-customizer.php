<?php
/**
 * Theme customizer
 *
 * @package Razzi
 */

namespace Razzi;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customize
 *
 * @var array
 */

class Customizer {
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
	 * Customize settings
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * The class constructor
	 *
	 * @since 1.0.0
	 *
	 * @param array $config
	 *
	 * @return void
	 */
	public function __construct( $config = array()) {
		$this->config = apply_filters( 'razzi_customize_config', $config );

		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		$this->register();

		add_action( 'customize_preview_init', array( $this, 'enqueue_preview_scripts' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'customize_register', array( $this, 'customize_modify' ) );

		if ( defined( 'KIRKI_VERSION' ) && version_compare( KIRKI_VERSION, '5.0.0', '<=' ) ) {
			add_filter( 'http_request_args', array($this, 'razzi_fix_kirki_fonts_request_headers'), 10, 2);
			add_action( 'after_switch_theme', array( $this,'razzi_fix_kirki_fonts')  );
			add_action( 'wp_ajax_kirki_clear_font_cache',array( $this, 'razzi_fix_kirki_fonts') );
		}
	}

	/**
	 * Enqueues style and scripts for customizer controls
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_add_inline_style( 'customize-controls', '.customize-pane-parent > .control-section-kirki-default{min-height: auto}' );
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_preview_scripts() {
		wp_add_inline_style( 'wp-admin', '.customize-pane-parent > .control-section-kirki-default{min-height: auto}' );
	}

	/**
	 * Register settings
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register() {
		/**
		 * Add the theme configuration
		 */
		if ( ! empty( $this->config['theme'] ) ) {
			\Kirki::add_config(
				$this->config['theme'], array(
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				)
			);
		}

		/**
		 * Add panels
		 */
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				\Kirki::add_panel( $panel, $settings );
			}
		}

		/**
		 * Add sections
		 */
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				\Kirki::add_section( $section, $settings );
			}
		}

		/**
		 * Add fields
		 */
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}

				\Kirki::add_field( $this->config['theme'], $settings );
			}
		}
	}

	/**
	 * Get config ID
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_theme() {
		return $this->config['theme'];
	}

	/**
	 * Get customize setting value
	 *
	 * @since 1.0.0
	 *
	 * @param string $name
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {
		$default = $this->get_option_default( $name );

		return get_theme_mod( $name, $default );
	}

	/**
	 * Get default option values
	 *
	 * @since 1.0.0
	 *
	 * @param $name
	 *
	 * @return mixed
	 */
	public function get_option_default( $name ) {
		if ( ! isset( $this->config['fields'][ $name ] ) ) {
			return false;
		}

		return isset( $this->config['fields'][ $name ]['default'] ) ? $this->config['fields'][ $name ]['default'] : false;
	}

	/**
	 * Move some default sections to `general` panel that registered by theme
	 *
	 * @since 1.0.0
	 *
	 * @param object $wp_customize
	 *
	 * @return void
	 */
	public function customize_modify( $wp_customize ) {
		$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
		$wp_customize->get_section( 'static_front_page' )->panel = 'general';
	}

	/**
	 * Fix incorrect fonts files downloaded from Google.
	 * Delete the Kirki's transients to force downloading font files again.
	 *
	 * @return void
	 */
	public function razzi_fix_kirki_fonts() {
		delete_transient( 'kirki_remote_url_contents' );
	}

	/**
	 * Change the http request headers of 'user-agent' to download .woff2 fonts frm Google.
	 *
	 * @param  array $args
	 * @param  string $url
	 *
	 * @return array
	 */
	public function razzi_fix_kirki_fonts_request_headers( $args, $url ) {
		if ( false === strpos( $url, 'https://fonts.googleapis.com/css' ) ) {
			return $args;
		}

		if ( isset( $args['user-agent'] ) && $args['user-agent'] == 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/603.3.8 (KHTML, like Gecko) Version/10.1.2 Safari/603.3.8' ) {
			$args['user-agent'] = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0';
		}

		return $args;
	}
}