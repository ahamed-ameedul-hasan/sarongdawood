<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Products_Tab_Carousel extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-product-tab';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Razzi - Product Tabs Carousel', 'razzi-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-tabs';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'razzi' ];
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
		$this->section_tab_header_style_controls();
		$this->section_carousel_style_controls();
		$this->section_heading_style_controls();
		$this->section_button_style_controls();
		$this->section_products_style_controls();
	}

	protected function section_products_settings_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'razzi-addons' ) ]
		);

		$this->add_control(
			'heading', [
				'label'       => esc_html__( 'Heading', 'razzi-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'per_page',
			[
				'label'   => esc_html__( 'Total Products', 'razzi-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_tabs_source',
			[
				'label'   => esc_html__( 'Source', 'razzi-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'special_products' => esc_html__( 'Special Products', 'razzi-addons' ),
					'product_cats'     => esc_html__( 'Product Categories', 'razzi-addons' ),
				],
				'default' => 'special_products',
				'toggle'  => false,
				'separator' => 'before',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label'       => esc_html__( 'Title', 'razzi-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is heading', 'razzi-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_products',
			[
				'label'   => esc_html__( 'Products', 'razzi-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'recent'       => esc_html__( 'Recent', 'razzi-addons' ),
					'featured'     => esc_html__( 'Featured', 'razzi-addons' ),
					'best_selling' => esc_html__( 'Best Selling', 'razzi-addons' ),
					'top_rated'    => esc_html__( 'Top Rated', 'razzi-addons' ),
					'sale'         => esc_html__( 'On Sale', 'razzi-addons' ),
				],
				'default' => 'recent',
				'toggle'  => false,
			]
		);

		$repeater->add_control(
			'tab_orderby',
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
				'toggle'    => false,
				'condition' => [
					'tab_products' => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
			]
		);

		$repeater->add_control(
			'tab_order',
			[
				'label'     => esc_html__( 'Order', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'razzi-addons' ),
					'asc'  => esc_html__( 'Ascending', 'razzi-addons' ),
					'desc' => esc_html__( 'Descending', 'razzi-addons' ),
				],
				'default'   => '',
				'toggle'    => false,
				'condition' => [
					'tab_products' => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
			]
		);

		$repeater->add_control(
			'product_outofstock',
			[
				'label'        => esc_html__( 'Show Out Of Stock Products', 'razzi-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'razzi-addons' ),
				'label_off'    => esc_html__( 'Hide', 'razzi-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'tab_button_text',
			[
				'label'       => esc_html__( 'Button Text', 'razzi-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$repeater->add_control(
			'tab_button_link', [
				'label'         => esc_html__( 'Button Link', 'razzi-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'razzi-addons' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'special_products_tabs',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'title'        => esc_html__( 'New Arrivals', 'razzi-addons' ),
						'tab_products' => 'recent',
						'tab_button_text' => ''
					],
					[
						'title'        => esc_html__( 'Features', 'razzi-addons' ),
						'tab_products' => 'featured',
						'tab_button_text' => ''
					],
					[
						'title'        => esc_html__( 'Top Rated', 'razzi-addons' ),
						'tab_products' => 'top_rated',
						'tab_button_text' => ''
					]
				],
				'title_field'   => '{{{ title }}}',
				'prevent_empty' => false,
				'condition'     => [
					'product_tabs_source' => 'special_products',
				],
			]
		);

		$this->add_control(
			'view_all_cats',
			[
				'label'        => esc_html__( 'View All Categories', 'razzi-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'razzi-addons' ),
				'label_off'    => esc_html__( 'Hide', 'razzi-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition' => [
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->add_control(
			'view_all_cats_text',
			[
				'label'       => esc_html__( 'View All Text', 'razzi-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'All', 'razzi-addons' ),
				'condition' => [
					'product_tabs_source' => 'product_cats',
					'view_all_cats' => 'yes',
				],
			]
		);

		$product_cats = Helper::taxonomy_list();
		$repeater     = new \Elementor\Repeater();

		$repeater->add_control(
			'product_cat', [
				'label'       => esc_html__( 'Category Tab', 'razzi-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $product_cats,
				'multiple' => true,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'product_cat_title',
			[
				'label'       => esc_html__( 'Title', 'razzi-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$repeater->add_control(
			'product_cat_btn_text',
			[
				'label'       => esc_html__( 'Button Text', 'razzi-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$repeater->add_control(
			'product_cat_btn_link',
			[
				'label' => __( 'Link', 'razzi-addons' ),
				'type' => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$repeater->add_responsive_control(
			'product_cat_image',
			[
				'label'    => __( 'Image', 'razzi-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'product_cats_tabs',
			[
				'label'         => esc_html__( 'Category Tabs', 'razzi-addons' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [ ],
				'prevent_empty' => false,
				'condition'     => [
					'product_tabs_source' => 'product_cats',
				],
				'title_field'   => '{{{ product_cat }}}',
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => esc_html__( 'Products Category', 'razzi-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi-addons' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'condition'   => [
					'product_tabs_source' => 'special_products',
				],
				'separator' => 'before',
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
				'condition'   => [
					'product_tabs_source' => 'special_products',
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
				'condition'   => [
					'product_tabs_source' => 'special_products',
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
					'condition'   => [
						'product_tabs_source' => 'special_products',
					],
				]
			);
		}

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
				],
				'default'   => 'recent',
				'toggle'    => false,
				'condition' => [
					'product_tabs_source' => 'product_cats',
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
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
					'product_tabs_source' => 'product_cats',
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
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
					'product_tabs_source' => 'product_cats',
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
				'condition' => [
					'product_tabs_source' => 'product_cats',
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

		$this->add_control(
			'slidesPerViewAuto',
			[
				'label'     => __( 'Slides per view auto', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi-addons' ),
				'label_on'  => __( 'On', 'razzi-addons' ),
				'default'   => '',
				'frontend_available' => true,
				'prefix_class' => 'razzi-products-tabs__slidesperviewauto-'
			]
		);

		$this->add_responsive_control(
			'slide_spacing_right',
			[
				'label'     => __( 'Spacing', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 1500,
						'min' => 0,
					],
				],
				'desktop_default' => [
					'size' => 366,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 0,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}}.razzi-products-tabs__slidesperviewauto-yes .razzi-products-tabs__wrapper' => 'margin-right: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.razzi-products-tabs__slidesperviewauto-yes ul.products li.swiper-item-empty' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slidesPerViewAuto',
							'value' => 'yes',
						],
					],
				],
			]
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
				'max'             => 7,
				'default' 		  => 4,
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'slidesToScroll',
			[
				'label'           => esc_html__( 'Slides to scroll', 'razzi-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 7,
				'default' 		  => 4,
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
					'scrollbar'  => esc_html__( 'Scrollbar', 'razzi-addons' ),
					'dots' => esc_html__( 'Dots', 'razzi-addons' ),
					'arrows' => esc_html__( 'Arrows', 'razzi-addons' ),
				],
				'default'   => 'scrollbar',
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

	protected function section_tab_header_style_controls() {
		$this->start_controls_section(
			'section_tab_header_style',
			[
				'label' => esc_html__( 'Tab Header', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'product_tabs_position',
			[
				'label' => esc_html__( 'Position', 'razzi-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'razzi-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'razzi-addons' ),
						'icon' => 'eicon-v-align-top',
					],
				],

			]
		);

		$this->add_responsive_control(
			'tab_header_space',
			[
				'label'     => __( 'Space', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-tabs.tabs-position-top .tabs-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-products-tabs.tabs-position-left .tabs-header' => '--rz-product-tabs-header-space: {{SIZE}}{{UNIT}}',
				],
			]
		);


		$this->add_responsive_control(
			'tab_header_item_space',
			[
				'label'     => __( 'Item Space', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-tabs.tabs-position-top ul.tabs li:not(:first-child)' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-products-tabs.tabs-position-top ul.tabs li:not(:last-child)' => 'padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .razzi-products-tabs.tabs-position-left ul.tabs' => '--rz-product-tabs-header-items-space: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'tab_header_align',
			[
				'label'       => esc_html__( 'Align', 'razzi-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'flex-start'   => [
						'title' => esc_html__( 'Flex Start', 'razzi-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'razzi-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'  => [
						'title' => esc_html__( 'Flex End', 'razzi-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .razzi-products-tabs ul.tabs' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tab_header_divider',
			[
				'label' => '',
				'type'  => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tab_header_title',
				'selector' => '{{WRAPPER}} .razzi-products-tabs ul.tabs li a',
			]
		);
		$this->add_control(
			'tab_header_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-tabs ul.tabs li a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'tab_header_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-tabs ul.tabs li a.active' => 'color: {{VALUE}};',
					'{{WRAPPER}} .razzi-products-tabs ul.tabs li a:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_image_header_divider',
			[
				'label'     => esc_html__( 'Image', 'razzi-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'     => [
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->add_responsive_control(
			'tab_header_image_width',
			[
				'label'     => __( 'Max Width', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-tabs ul.tabs li img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition'     => [
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->add_responsive_control(
			'tab_header_image_width_border_radius',
			[
				'label'      => __( 'Border Radius', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-tabs ul.tabs li img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'     => [
					'product_tabs_source' => 'product_cats',
				],
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
			'carousel_style_divider',
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
					'{{WRAPPER}} .razzi-products-tabs .swiper-scrollbar' => 'margin-top: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-tabs .swiper-scrollbar' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-tabs .swiper-scrollbar-drag' => 'background-color: {{VALUE}};',
				],
			]
		);

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
					'{{WRAPPER}} .razzi-products-tabs .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-tabs .swiper-pagination .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-tabs .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active:before, {{WRAPPER}} .razzi-products-tabs .swiper-pagination .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-products-tabs .swiper-container-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-products-tabs .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_heading_style_controls() {
		// Heading Tab Style
		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => esc_html__( 'Heading', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'heading_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-tabs__heading-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-products-tabs__heading-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'      => esc_html__( 'Text Color', 'razzi-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .razzi-products-tabs__heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .razzi-products-tabs__heading',
			]
		);

		$this->end_controls_section();
	}

	protected function section_button_style_controls() {
		// Button Tab Style
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_spacing',
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
					'{{WRAPPER}} .razzi-products-tabs .tabs-panel .razzi-tabs-button' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_divider',
			[
				'label' => '',
				'type'  => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_text',
				'selector' => '{{WRAPPER}} .razzi-products-tabs .tabs-panel .razzi-tabs-button a',
			]
		);
		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__( 'Text Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-products-tabs .tabs-panel .razzi-tabs-button a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_products_style_controls() {
		// Button Tab Style
		$this->start_controls_section(
			'section_products_style',
			[
				'label' => esc_html__( 'Products', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'product_boxshadow',
				'label' => __( 'Product Box Shadow', 'razzi-addons' ),
				'selector' => '{{WRAPPER}} ul.products li.product .product-inner',
			]
		);

		$this->add_responsive_control(
			'product_border_radius',
			[
				'label'      => __( 'Product Border Radius', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ul.products li.product .product-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ul.products li.product .product-inner .product-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
					'{{WRAPPER}} ul.products li.product .product-inner .rz-atc-button-bg' => 'border-radius: 0 0 {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_spacing_bottom',
			[
				'label'     => __( 'Product Spacing Bottom', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} ul.products li.product .product-inner' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_content_padding',
			[
				'label'     => __( 'Product Content Padding', 'razzi-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} ul.products li.product .product-summary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ul.products.product-loop-layout-8 li.product .product-loop__buttons' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ul.products.product-loop-layout-10 li.product .product-summary' => 'padding-bottom: 0',
					'{{WRAPPER}} ul.products.product-loop-layout-10 li.product .rz-loop_atc_button' => 'margin-left: {{LEFT}}{{UNIT}};margin-right: {{RIGHT}}{{UNIT}};margin-bottom: {{BOTTOM}}{{UNIT}}',
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
			'razzi-products-tabs razzi-tabs razzi-elementor-product-carousel razzi-swiper-carousel-elementor woocommerce',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
			'tabs-position-' . $settings['product_tabs_position']
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php
				if ( $settings['heading'] || $settings['navigation'] == 'arrows' ) {
					echo sprintf(
						'<div class="razzi-products-tabs__heading-wrapper">
							<div class="razzi-products-tabs__heading">%s</div>
							<div class="razzi-products-tabs__navigation">%s%s</div>
						</div>',
						$settings['heading'],
						\Razzi\Addons\Helper::get_svg('chevron-left', 'rz-swiper-button-prev rz-swiper-button'),
						\Razzi\Addons\Helper::get_svg('chevron-right', 'rz-swiper-button-next rz-swiper-button')
					);
				};

				echo $settings['product_tabs_position'] == 'left' ? '<div class="razzi-products-tabs__wrapper columns-'. $settings['slidesToShow'] .'">' : '';
				self::get_products_tab( $settings );
				echo $settings['product_tabs_position'] == 'left' ? '</div>' : '';
			?>
		</div>
		<?php
	}

	public static function get_products_tab( $settings ) {

		$output      = [ ];
		$header_tabs = [ ];
		$tab_content = [ ];

		$header_tabs[] = '<ul class="tabs-header tabs-nav tabs">';
		$i             = 0;
		if ( $settings['product_tabs_source'] == 'special_products' ) {
			$tabs = $settings['special_products_tabs'];

			if ( $tabs ) {
				foreach ( $tabs as $index => $item ) {
					$button_view = $class_active = '';

					if ( $i == 0 ) {
						$class_active = 'active';
					}

					if ( isset( $item['title'] ) ) {
						$header_tabs[] = sprintf( '<li><a href="#" data-href="%s" class="%s">%s</a></li>', esc_attr( $item['tab_products'] ), $class_active, esc_html( $item['title'] ) );
					}

					if ( $item['tab_button_text'] ) {
						$button_view = sprintf( '<div class="razzi-tabs-button">%s</div>', Helper::control_url( $index, $item['tab_button_link'], $item['tab_button_text'], [ 'class' => 'razzi-button--underlined' ] ) );
					}

					$tab_atts = [
						'products'     		=> $item['tab_products'],
						'orderby'      		=> ! empty( $item['tab_orderby'] ) ? $item['tab_orderby'] : '',
						'order'        		=> ! empty( $item['tab_order'] ) ? $item['tab_order'] : '',
						'category'    		=> $settings['category'],
						'tag'    			=> $settings['product_tags'],
						'product_brands'    => $settings['product_brands'],
						'per_page'    		=> $settings['per_page'],
						'paginate'			=> true,
					];

					if ( taxonomy_exists( 'product_author' ) ) {
						$tab_atts['product_authors'] = $settings['product_authors'];
					}

					if ( isset( $item['product_outofstock'] ) && empty( $item['product_outofstock'] ) ) {
						$tab_atts['product_outofstock'] = $item['product_outofstock'];
					}

					$results = Helper::products_shortcode( $tab_atts );
					if ( ! $results ) {
						return;
					}

					$product_ids = $results['ids'];

					if ( $i == 0 ) {
						$tab_content[] = sprintf(
										'<div class="tabs-panel tabs-%s tab-loaded active" data-settings="%s">',
										esc_attr( $item['tab_products'] ),
										esc_attr( wp_json_encode( $tab_atts ) )
									);

						ob_start();
						Helper::get_template_loop( $product_ids );
						$tab_content[] = ob_get_clean();

						$tab_content[] = wp_kses_post( $button_view );

						$tab_content[] = '</div>';
					} else {
						$tab_content[] = sprintf(
							'<div class="tabs-panel tabs-%s" data-settings="%s">%s</div>',
							esc_attr( $item['tab_products'] ),
							esc_attr( wp_json_encode( $tab_atts ) ),
							wp_kses_post( $button_view )
						);
					}

					$i ++;
				}
			}
		} else {
			if ( $settings['view_all_cats'] ) {
				$header_tabs[] = sprintf( '<li><a href="#" data-href="all" class="active">%s</a></li>', $settings['view_all_cats_text'] );

				$tab_atts = [
					'products'     		=> $settings['products'],
					'orderby'      		=> $settings['orderby'],
					'order'        		=> $settings['order'],
					'category'    		=> '',
					'tag'    			=> $settings['product_tags'],
					'product_brands'    => $settings['product_brands'],
					'per_page'    		=> $settings['per_page'],
					'paginate'			=> true,
				];

				if ( taxonomy_exists( 'product_author' ) ) {
					$tab_atts['product_authors'] = $settings['product_authors'];
				}

				if ( isset( $settings['product_outofstock'] ) && empty( $settings['product_outofstock'] ) ) {
					$tab_atts['product_outofstock'] = $settings['product_outofstock'];
				}

				$results = Helper::products_shortcode( $tab_atts );
				if ( ! $results ) {
					return;
				}

				$product_ids = $results['ids'];

				$tab_content[] = sprintf(
					'<div class="tabs-panel tabs-all tab-loaded active" data-settings="%s">',
					esc_attr( wp_json_encode( $tab_atts ) )
				);

				ob_start();

				Helper::get_template_loop( $product_ids );

				$tab_content[] = ob_get_clean();

				$tab_content[] = '</div>';
			}

			$cats = $settings['product_cats_tabs'];
			if ( $cats ) {
				foreach ( $cats as $tab ) {
					$class_active = '';
					if ( $i == 0 && $settings['view_all_cats'] == '' ) {
						$class_active = 'active';
					}

					if( empty($tab['product_cat']) ) {
						continue;
					}

					$settings['image'] = $tab['product_cat_image'];
					$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
					$image = $image ? '<div class="razzi-products-tabs__image_category">'. $image .'</div>' : '';

					$tab_slug = 'product_cat_' . $i;
					$tab_title = ! empty( $tab['product_cat_title'] ) ? $tab['product_cat_title'] : '';
					$tab_btn_link = ! empty( $tab['product_cat_btn_link'] ) ? $tab['product_cat_btn_link'] : '';

					if( empty( $tab_title ) || empty( $tab_btn_link ) ) {
						$product_cat = is_array( $tab['product_cat'] ) ? $tab['product_cat'][0] : $tab['product_cat'];
						$term = get_term_by( 'slug', $product_cat, 'product_cat' );
						if ( ! is_wp_error( $term ) && $term ) {
							$tab_title = empty( $tab_title ) ? $term->name : $tab_title;
							$tab_btn_link = empty( $tab_btn_link ) ? get_category_link( $term->term_id ) : $tab_btn_link;
						}
					}


					if( ! empty( $tab_title ) ) {
						$header_tabs[] = sprintf( '<li><a href="#" data-href="%s" class="%s">%s%s</a></li>', esc_attr( $tab_slug ), esc_attr($class_active), $image, $tab_title );
					}

					$tab_atts = array(
						'products'     => $settings['products'],
						'order'        => $settings['order'],
						'orderby'      => $settings['orderby'],
						'per_page'     => intval( $settings['per_page'] ),
						'category'    	=> is_array( $tab['product_cat'] ) ? implode(',', $tab['product_cat']) : $tab['product_cat'],
						'paginate'		=> true,
					);

					if ( isset( $settings['product_outofstock'] ) && empty( $settings['product_outofstock'] ) ) {
						$tab_atts['product_outofstock'] = $settings['product_outofstock'];
					}

					$results = Helper::products_shortcode( $tab_atts );
					if ( ! $results ) {
						continue;
					}

					$product_ids = $results['ids'];

					$button_view = '';

					if ( $tab['product_cat_btn_text'] ) {
						$button_view = sprintf( '<div class="razzi-tabs-button"><a class="razzi-button--underlined" href="%s">%s</a></div>', esc_url($tab_btn_link), esc_html( $tab['product_cat_btn_text'] ) );
					}

					if ( $i == 0 && $settings['view_all_cats'] == '' ) {
						$tab_content[] = sprintf(
							'<div class="tabs-panel tabs-%s tab-loaded active" data-settings="%s">',
							esc_attr( $tab_slug ),
							esc_attr( wp_json_encode( $tab_atts ) )
						);

						ob_start();

						if(isset($settings['columns'])) {
							wc_setup_loop(
								array(
									'columns'      => $settings['columns']
								)
							);
                        }

						Helper::get_template_loop( $product_ids );
						$tab_content[] = ob_get_clean();

						$tab_content[] = wp_kses_post( $button_view );

						$tab_content[] = '</div>';
					} else {
						$tab_content[] = sprintf(
							'<div class="tabs-panel tabs-%s" data-settings="%s">%s</div>',
							esc_attr( $tab_slug ),
							esc_attr( wp_json_encode( $tab_atts ) ),
							wp_kses_post( $button_view )
						);
					}

					$i ++;

				}
			}
		}

		$header_tabs[] = '</ul>';

		$output[] = sprintf( '%s<div class="tabs-content">%s</div>', implode( ' ', $header_tabs ), implode( ' ', $tab_content ) );

		echo implode( '', $output );
	}
}