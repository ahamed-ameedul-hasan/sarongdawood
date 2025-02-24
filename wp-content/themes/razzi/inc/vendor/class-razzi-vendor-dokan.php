<?php

namespace Razzi\Vendor;

/**
 * Vendor Dokan functions and definitions.
 *
 * @package Razzi
 */

class Dokan {

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
     * The constructor
     */
    function __construct() {
		add_filter( 'body_class', array( $this, 'body_classes' ) );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		$this->product_loop_layout();
		add_action( 'woocommerce_single_product_summary', array( $this, 'vendor_name_single'), 7 );
		add_action( 'razzi_woocommerce_single_product_listing', array( $this, 'vendor_name_single'), 7 );


		if( \Razzi\Helper::get_option('product_tab_vendor_info') ) {
			add_filter( 'woocommerce_product_tabs', array( $this, 'unset_vendor_info_tab' ), 98 );
		}
		if( \Razzi\Helper::get_option('product_tab_more_products') ) {
			add_filter( 'woocommerce_product_tabs', array( $this, 'unset_more_products_tab' ), 98 );
		}

		add_filter( 'razzi_get_page_header_elements', array( $this, 'page_header_elements' ) );
    }

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	public function body_classes( $classes ) {
		// Add class is dokan pro actived
		if ( class_exists( 'Dokan_Pro' ) ) {
			$classes[] = 'razzi-dokan-pro';
		}

		if ( function_exists( 'dokan_is_store_listing' ) && dokan_is_store_listing() ) {
			$classes[] = 'razzi-dokan-store-list-page';
		}

		if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
			$classes[] = 'razzi-dokan-store-page';
		}

		return $classes;
	}

    /**
     * Enqueue registration scripts
     *
     * @return void
     */
    public function enqueue_scripts() {
		wp_enqueue_style( 'razzi-dokan', get_template_directory_uri() . '/assets/css/vendors/dokan.css', array(), '20230203' );
        if ( is_user_logged_in() ) {
            return;
        }

		if(function_exists('dokan') ) {
			dokan()->scripts->load_form_validate_script();
			wp_enqueue_script( 'dokan-vendor-registration' );
		}

    }

	/**
	 * Product Card layout
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_loop_layout() {
		$loop_layout    = apply_filters( 'razzi_product_loop_layout', \Razzi\Helper::get_option( 'product_loop_layout' ) );
		if( $loop_layout == '10' ) {
			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'vendor_name' ), 10 );
		} elseif( $loop_layout == '11' ) {
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'vendor_name' ), 45 );
		} else {
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'vendor_name' ), 15 );
		}
	}

	/**
	 * Vendor name loop.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function vendor_name_loop() {
		if( ! intval( \Razzi\Helper::get_option( 'product_card_vendor_name' ) ) ) {
			return;
		}

		$this->vendor_name();
	}

	/**
	 * Vendor name loop.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function vendor_name_single() {
		if( ! intval( \Razzi\Helper::get_option( 'single_product_vendor_name' ) ) ) {
			return;
		}

		$this->vendor_name();
	}


	/**
	 * Vendor name.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function vendor_name() {
		global $product;

		if ( ! function_exists( 'dokan_get_store_url' ) ) {
			return;
		}

		global $product;
		$author_id = get_post_field( 'post_author', $product->get_id() );
		$author    = get_user_by( 'id', $author_id );
		if ( empty( $author ) ) {
			return;
		}

		$shop_info = get_user_meta( $author_id, 'dokan_profile_settings', true );
		$shop_name = $author->display_name;
		if ( $shop_info && isset( $shop_info['store_name'] ) && $shop_info['store_name'] ) {
			$shop_name = $shop_info['store_name'];
		}

		?>
		<div class="sold-by-meta">
			<a href="<?php echo esc_url( dokan_get_store_url( $author_id ) ); ?>">
				<?php echo get_avatar( $author_id );?>
				<span class="vendor-name"><?php echo esc_html( $shop_name ); ?></span>
			</a>
		</div>

		<?php
	}

	/**
	 * Unset vendor_info tab
	 *
	 * @return array
	 */
	public function unset_vendor_info_tab( $tabs ) {
		if( isset( $tabs[ 'seller' ] ) ) {
			unset( $tabs[ 'seller' ] );
		}

		return $tabs;
	}

	/**
	 * Unset more_products tab
	 *
	 * @return array
	 */
	public function unset_more_products_tab( $tabs ) {
		if( isset( $tabs[ 'more_seller_product' ] ) ) {
			unset( $tabs[ 'more_seller_product' ] );
		}

		return $tabs;
	}


	/**
	 * Vendor header.
	 *
	 *  @return void
	 */
	public function page_header_elements( $items ) {
		if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
			$items = array('breadcrumb');
		}

		return $items;
	}

}
