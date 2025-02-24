<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Products_Listing_2 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-products-listing-2';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Razzi - Products Listing 2', 'razzi-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-carousel';
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
		$scripts = [
			'flexslider',
			'wc-single-product',
			'swiper',
			'imagesLoaded',
			'tawcvs-frontend',
		];

		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$scripts[] = 'zoom';
			$scripts[] = 'coundown';
		}
		return $scripts;
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
			'heading',
			[
				'label'     => esc_html__( 'Title', 'razzi-addons' ),
				'type'      => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'products',
			[
				'label'     => esc_html__( 'Product', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'recent'       => esc_html__( 'Recent', 'razzi-addons' ),
					'featured'     => esc_html__( 'Featured', 'razzi-addons' ),
					'best_selling' => esc_html__( 'Best Selling', 'razzi-addons' ),
					'top_rated'    => esc_html__( 'Top Rated', 'razzi-addons' ),
					'sale'         => esc_html__( 'On Sale', 'razzi-addons' ),
					'custom'         => esc_html__( 'Custom', 'razzi-addons' ),
				],
				'default'   => 'recent',
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
				'sortable'    => true,
				'condition'   => [
					'products' => 'custom',
				],
			]
		);

		$this->add_control(
			'product_cats',
			[
				'label'       => esc_html__( 'Product Categories', 'razzi-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi-addons' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'separator' => 'before',
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
			'product_tags',
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
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'razzi-addons' ),
					'date'       => esc_html__( 'Date', 'razzi-addons' ),
					'title'      => esc_html__( 'Title', 'razzi-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'razzi-addons' ),
					'rand'       => esc_html__( 'Random', 'razzi-addons' ),
				],
				'default'   => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'products',
							'operator' => '!in',
							'value' => [ 'best_selling', 'custom' ],
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
							'operator' => '!in',
							'value' => [ 'best_selling', 'custom' ],
						],
					],
				],
			]
		);

		$this->add_control(
			'product_outofstock',
			[
				'label'        => esc_html__( 'Show Out Of Stock Products', 'razzi-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'razzi-addons' ),
				'label_off'    => esc_html__( 'Hide', 'razzi-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
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

		$this->end_controls_section();
	}

	protected function section_carousel_settings_controls() {
		$this->start_controls_section(
			'section_carousel_settings',
			[ 'label' => esc_html__( 'Carousel Settings', 'razzi-addons' ) ]
		);

		$this->add_responsive_control(
			'navigation',
			[
				'label'     => esc_html__( 'Navigation', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'     => esc_html__( 'None', 'razzi-addons' ),
					'arrows' => esc_html__( 'Arrows', 'razzi-addons' ),
					'dots' => esc_html__( 'Dots', 'razzi-addons' ),
				],
				'default'   => 'arrows',
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

		$this->add_control(
			'product_style_divider',
			[
				'label' => __( 'Product', 'razzi-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'product_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-listing__item-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_hide_box_shadow',
			[
				'label'        => esc_html__( 'Hide Box Shadow', 'razzi-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'razzi-addons' ),
				'label_on'     => __( 'On', 'razzi-addons' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'prefix_class' => 'razzi-products-listing-hide-box-shadow-'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_box_shadow',
				'label' => __( 'Box Shadow', 'razzi-addons' ),
				'selector' => '{{WRAPPER}} .razzi-products-listing__item-box',
			]
		);

		$this->add_control(
			'product_content_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing__item-box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_content_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-listing__item-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_style_divider',
			[
				'label' => __( 'Title', 'razzi-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .razzi-products-listing__heading',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing__heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'     => __( 'Spacing', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 350,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing__heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'navigation',
							'operator' => '!=',
							'value' => 'arrows',
						],
					],
				]

			]
		);

		$this->add_responsive_control(
			'heading_arrows_spacing',
			[
				'label'     => __( 'Spacing', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 350,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing__heading' => 'margin-bottom: 0;',
					'{{WRAPPER}} .razzi-products-listing__heading--arrows' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'navigation',
							'value' => 'arrows',
						],
					],
				],
			]
		);

		$this->add_control(
			'image_style_divider',
			[
				'label' => __( 'Image', 'razzi-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->end_controls_section();
	}

	protected function section_carousel_style_controls() {
		// Carousel Settings
		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => esc_html__( 'Carousel Settings', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'carousel_divider',
			[
				'label' => __( 'Arrows', 'razzi-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'arrows_font_size',
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
					'{{WRAPPER}} .razzi-products-listing-2 .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_width',
			[
				'label'     => __( 'Width', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing-2 .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_height',
			[
				'label'     => __( 'Height', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing-2 .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing_horizontal',
			[
				'label'      => __( 'Horizontal Position', 'razzi-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => - 200,
						'max' => 300,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-listing-2 .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-products-listing-2 .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-products-listing__heading--arrows .razzi-products-listing__arrows' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing_button',
			[
				'label'      => __( 'Spacing Button', 'razzi-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => -50,
						'max' => 300,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-listing__heading--arrows .razzi-products-listing__arrows .rz-swiper-button-prev' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'sliders_normal_settings' );

		$this->start_controls_tab( 'sliders_normal', [ 'label' => esc_html__( 'Normal', 'razzi-addons' ) ] );

		$this->add_control(
			'sliders_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing-2 .rz-swiper-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing-2 .rz-swiper-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'sliders_hover', [ 'label' => esc_html__( 'Hover', 'razzi-addons' ) ] );

		$this->add_control(
			'sliders_arrow_hover_color',
			[
				'label'     => esc_html__( 'Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing-2 .rz-swiper-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_hover_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-listing-2 .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'carousel_style_divider_2',
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
					'{{WRAPPER}} .razzi-products-listing-2 .swiper-pagination .swiper-pagination-bullet::before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-listing-2 .swiper-pagination .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-listing-2 .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active:before, {{WRAPPER}} .razzi-products-listing-2 .swiper-pagination .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-listing-2 .swiper-container-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-listing-2 .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
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
			'razzi-products-listing-2 razzi-swiper-carousel-elementor razzi-swiper-slider-elementor',
			'single-product woocommerce',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$title = $settings['heading'] ? sprintf('<div class="razzi-products-listing__heading">%s</div>', $settings['heading'] ) : '';

		$arrows = sprintf( '%s%s',
			\Razzi\Addons\Helper::get_svg('chevron-left', 'rz-swiper-button-prev rz-swiper-button'),
			\Razzi\Addons\Helper::get_svg('chevron-right','rz-swiper-button-next rz-swiper-button')
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php
				printf( '<div class="razzi-products-listing__heading--arrows">%s<div class="razzi-products-listing__arrows">%s</div></div>', $title, $arrows );
				echo '<div class="razzi-products-listing__items products">';
				$this->get_categories_content( $settings );
				echo '</div>';
			?>
		</div>
		<?php
	}

	/**
	 * Get Categories
	 */
	protected function get_categories_content( $settings ) {
		$output = [];

		$attr = [
			'products' 			=> $settings['products'],
			'orderby'  			=> $settings['orderby'],
			'order'    			=> $settings['order'],
			'category'    		=> $settings['product_cats'],
			'tag'    			=> $settings['product_tags'],
			'product_brands'    => $settings['product_brands'],
			'limit'    			=> $settings['per_page'],
			'product_ids'   	=> !empty($settings['ids']) ? explode(',', $settings['ids']) : 0,
			'paginate'			=> true,
		];

		if ( taxonomy_exists( 'product_author' ) ) {
			$attr['product_authors'] = $settings['product_authors'];
		}

		if ( isset( $settings['product_outofstock'] ) && empty( $settings['product_outofstock'] ) ) {
			$attr['product_outofstock'] = $settings['product_outofstock'];
		}

		$product_ids = Helper::products_shortcode( $attr );

		$product_ids = ! empty($product_ids) ? $product_ids['ids'] : 0;

		update_meta_cache( 'post', $product_ids );
		update_object_term_cache( $product_ids, 'product' );

		add_filter( 'woocommerce_single_product_flexslider_enabled', '__return_true' );

		$original_post = $GLOBALS['post'];

		foreach ( $product_ids as $product_id ) {
			$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $GLOBALS['post'] );
			wc_get_template_part( 'content', 'single-product-listing' );
		}

		$GLOBALS['post'] = $original_post; // WPCS: override ok.

		wp_reset_postdata();
	}


}