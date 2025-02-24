<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Products_Deal_3 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-products-deal-3';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Razzi - Product Super Deals', 'razzi-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-countdown';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'razzi' ];
	}

	public function get_script_depends() {
		return [
			'swiper',
			'imagesLoaded',
			'razzi-coundown',
		];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->section_content();
		$this->section_style();
	}

	// Tab Content
	protected function section_content() {
		$this->section_products_settings_controls();
		$this->section_carousel_settings_controls();
	}

	// Tab Style
	protected function section_style() {
		$this->section_content_style_controls();
		$this->section_carousel_style_controls();
	}

	protected function section_products_settings_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'razzi-addons' ) ]
		);

		$this->add_control(
			'products_divider',
			[
				'label' => esc_html__( 'Products', 'razzi-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'per_page',
			[
				'label'   => esc_html__( 'Total Products', 'razzi-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
				'conditions' => [
					'terms' => [
						[
							'name' => 'products',
							'operator' => '!=',
							'value' => 'custom',
						],
					],
				],
			]
		);

		$this->add_control(
			'products',
			[
				'label'     => esc_html__( 'Products', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'day'   => esc_html__( 'Deals of the day', 'razzi-addons' ),
					'week'  => esc_html__( 'Deals of the week', 'razzi-addons' ),
					'month' => esc_html__( 'Deals of the month', 'razzi-addons' ),
					'sale'  => esc_html__( 'On Sale', 'razzi-addons' ),
					'deals' => esc_html__( 'Product Deals', 'razzi-addons' ),
					'custom' => esc_html__( 'Product Custom', 'razzi-addons' ),
					'recent' => esc_html__( 'Recent Products', 'razzi-addons' ),
				],
				'default'   => 'deals',
				'toggle'    => false,
			]
		);

		$this->add_control(
			'ids',
			[
				'label'       => esc_html__( 'Products', 'razzi-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi-addons' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product',
				'sortable'    => false,
				'condition'   => [
					'products' => 'custom',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'razzi-addons' ),
					'date'       => esc_html__( 'Date', 'razzi-addons' ),
					'title'      => esc_html__( 'Title', 'razzi-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'razzi-addons' ),
				],
				'default'   => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'products',
							'operator' => '!=',
							'value' => 'custom',
						],
					],
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'     => esc_html__( 'Order', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'razzi-addons' ),
					'asc'  => esc_html__( 'Ascending', 'razzi-addons' ),
					'desc' => esc_html__( 'Descending', 'razzi-addons' ),
				],
				'default'   => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'products',
							'operator' => '!=',
							'value' => 'custom',
						],
					],
				],
			]
		);

		$this->add_control(
			'product_category',
			[
				'label'       => esc_html__( 'Product Categories', 'razzi-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi-addons' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'products',
							'operator' => '!=',
							'value' => 'custom',
						],
					],
				],
			]
		);

		$this->add_control(
			'product_tag',
			[
				'label'       => esc_html__( 'Products Tags', 'razzi-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi-addons' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_tag',
				'sortable'    => true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'products',
							'operator' => '!=',
							'value' => 'custom',
						],
					],
				],
			]
		);

		$this->add_control(
			'product_brands',
			[
				'label'       => esc_html__( 'Products Brands', 'razzi-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi-addons' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_brand',
				'sortable'    => true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'products',
							'operator' => '!=',
							'value' => 'custom',
						],
					],
				],
			]
		);

		if ( taxonomy_exists( 'product_author' ) ) {
			$this->add_control(
				'product_authors',
				[
					'label'       => esc_html__( 'Products Authors', 'razzi-addons' ),
					'placeholder' => esc_html__( 'Click here and start typing...', 'razzi-addons' ),
					'type'        => 'rzautocomplete',
					'default'     => '',
					'label_block' => true,
					'multiple'    => true,
					'source'      => 'product_author',
					'sortable'    => true,
					'conditions' => [
						'terms' => [
							[
								'name' => 'products',
								'operator' => '!=',
								'value' => 'custom',
							],
						],
					],
				]
			);
		}

		$this->add_control(
			'attributes_divider',
			[
				'label' => esc_html__( 'Attributes', 'razzi-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'     => esc_html__( 'Category', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'razzi-addons' ),
				'label_on'  => __( 'Show', 'razzi-addons' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'     => esc_html__( 'Rating', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'razzi-addons' ),
				'label_on'  => __( 'Show', 'razzi-addons' ),
				'return_value' => 'show',
				'default'   => 'show',
			]
		);

		$this->add_control(
			'show_quickview',
			[
				'label'     => esc_html__( 'Quick View', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'razzi-addons' ),
				'label_on'  => __( 'Show', 'razzi-addons' ),
				'return_value' => 'show',
				'default'   => 'show',
			]
		);

		$this->add_control(
			'show_addtocart',
			[
				'label'     => esc_html__( 'Add To Cart', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'razzi-addons' ),
				'label_on'  => __( 'Show', 'razzi-addons' ),
				'return_value' => 'show',
				'default'   => 'show',
			]
		);

		$this->add_control(
			'show_wishlist',
			[
				'label'     => esc_html__( 'Wishlist', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'razzi-addons' ),
				'label_on'  => __( 'Show', 'razzi-addons' ),
				'return_value' => 'show',
				'default'   => 'show',
			]
		);

		$this->add_control(
			'show_stock',
			[
				'label'     => esc_html__( 'Stock', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'razzi-addons' ),
				'label_on'  => __( 'Show', 'razzi-addons' ),
				'return_value' => 'show',
				'default'   => 'show',
			]
		);

		$this->add_control(
			'show_atc_mobile',
			[
				'label'     => esc_html__( 'Show Add to Cart Button on Mobile', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'razzi-addons' ),
				'label_on'  => __( 'Show', 'razzi-addons' ),
				'return_value' => 'show',
				'default'   => 'show',
			]
		);

		$this->add_control(
			'show_featured_icons_mobile',
			[
				'label'     => esc_html__( 'Show Featured Icons Mobile', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'razzi-addons' ),
				'label_on'  => __( 'Show', 'razzi-addons' ),
				'return_value' => 'show',
				'default'   => 'show',
			]
		);


		$this->end_controls_section();
	}

	protected function section_carousel_settings_controls() {
		$this->start_controls_section(
			'section_carousel_settings',
			[ 'label' => esc_html__( 'Carousel Settings', 'razzi-addons' ) ]
		);

		$this->add_control(
			'centeredSlides',
			[
				'label'     => __( 'Centered auto', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi-addons' ),
				'label_on'  => __( 'On', 'razzi-addons' ),
				'default'   => '',
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'slidesToShow',
			[
				'label'           => esc_html__( 'Slides to show', 'razzi-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 50,
				'default' 			=> 1,
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'slidesToScroll',
			[
				'label'           => esc_html__( 'Slides to scroll', 'razzi-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 50,
				'default' 		=> 1,
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'navigation',
			[
				'label'     => esc_html__( 'Navigation', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'     => esc_html__( 'None', 'razzi-addons' ),
					'scrollbar' => esc_html__( 'Scrollbar', 'razzi-addons' ),
					'dots' => esc_html__( 'Dots', 'razzi-addons' ),
				],
				'default'   => 'dots',
				'frontend_available' => true,
			]
		);
		$this->add_control(
			'infinite',
			[
				'label'     => __( 'Infinite Loop', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi-addons' ),
				'label_on'  => __( 'On', 'razzi-addons' ),
				'default'   => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'     => __( 'Autoplay', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi-addons' ),
				'label_on'  => __( 'On', 'razzi-addons' ),
				'default'   => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'speed',
			[
				'label'       => __( 'Speed', 'razzi-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 800,
				'min'         => 100,
				'step'        => 50,
				'description' => esc_html__( 'Slide animation speed (in ms)', 'razzi-addons' ),
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();
	}

	protected function section_content_style_controls() {
		// Content Style
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_padding_inner',
			[
				'label'      => esc_html__( 'Padding Content', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-deal-3 .product-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding Content Summary', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-deal-3 ul.products li.product .product-summary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label'     => __( 'Background Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-deal-3 .product-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'img_box_border',
				'label' => __( 'Border', 'razzi-addons' ),
				'selector' => '{{WRAPPER}} .razzi-products-deal-3 .product-inner',
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-deal-3 .product-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_heading',
			[
				'label' => __( 'Image', 'razzi-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'      => __( 'Max Width', 'razzi-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'max' => 1500,
						'min' => 0,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-deal-3 ul.products li.product .product-thumbnail .woocommerce-loop-product__link img' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-products-deal-3 ul.products li.product .product-summary' => 'calc( 100% - {{SIZE}}{{UNIT}} );',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_carousel_style_controls() {
		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => __( 'Carousel Setting', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Arrows
		$this->add_control(
			'carousel_divider',
			[
				'label' => __( 'Scrollbar', 'razzi-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'scrollbar_spacing',
			[
				'label'     => __( 'Spacing', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-deal-3 .swiper-scrollbar' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'scrollbar_color',
			[
				'label'     => esc_html__( 'Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-deal-3 .swiper-scrollbar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scrollbar_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-deal-3 .swiper-scrollbar-drag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dots_divider',
			[
				'label' => __( 'Dots', 'razzi-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'dots_font_size',
			[
				'label'     => __( 'Size', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-deal-3 .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => esc_html__( 'Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-deal-3 .swiper-pagination .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dots_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-deal-3 .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active:before, {{WRAPPER}} .razzi-products-deal-3 .swiper-pagination .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'dots_spacing_item',
			[
				'label'      => __( 'Item Space', 'razzi-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-deal-3 .swiper-container-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'dots_spacing',
			[
				'label'      => __( 'Space', 'razzi-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-deal-3 .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$classes = [
			'razzi-products-deal-3 razzi-swiper-carousel-elementor',
			$settings['show_category'] != '' ? 'show-category' : '',
			$settings['show_rating'] != '' ? 'show-rating' : '',
			$settings['show_quickview'] != '' ? 'show-quickview' : '',
			$settings['show_addtocart'] != '' ? 'show-addtocart' : '',
			$settings['show_wishlist'] != '' ? 'show-wishlist' : '',
			$settings['show_stock'] != '' ? 'show-stock' : '',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) .'>';

		if( $settings['products'] == 'custom' ) {
			$attr = [
				'products' 			=> $settings['products'],
				'product_ids'   	=> explode( ',', $settings['ids'] ),
			];
		} else {
			$attr = [
				'products' 			=> $settings['products'],
				'orderby'  			=> $settings['orderby'],
				'order'    			=> $settings['order'],
				'category'    		=> $settings['product_category'],
				'tag'    			=> $settings['product_tag'],
				'product_brands'    => $settings['product_brands'],
				'limit'    			=> $settings['per_page'],
			];

			if ( taxonomy_exists( 'product_author' ) ) {
				$attr['product_authors'] = $settings['product_authors'];
			}
		}

		$product_ids = Helper::products_shortcode( $attr );

		$product_ids = ! empty($product_ids) ? $product_ids['ids'] : 0;

		if( ! $product_ids ) {
			return;
		}

		echo '<div class="product-content swiper-container linked-products-deal-carousel">';

		update_meta_cache( 'post', $product_ids );
		update_object_term_cache( $product_ids, 'product' );
		$original_post = $GLOBALS['post'];

		$classes = '';
		if ( $settings['show_atc_mobile'] == 'show' ) {
			$classes = 'mobile-show-atc';
		}

		if ( $settings['show_featured_icons_mobile'] == 'show' ) {
			$classes .= ' mobile-show-featured-icons';
		}


		if ( $settings['centeredSlides'] ) {
			$classes .= ' columns-' . $settings['slidesToShow'];
		}

		echo '<ul class="products shortcode-element product-loop-layout-deal-3 swiper-wrapper '. esc_attr( $classes ) .'">';

		foreach ( $product_ids as $product_id ) {
			$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $GLOBALS['post'] );
			wc_get_template(
				'content-product-deal-3.php',
			);
		}


		$GLOBALS['post'] = $original_post; // WPCS: override ok.

		echo '</ul>';

		wp_reset_postdata();

		echo '</div>';

		echo '</div>';
	}
}