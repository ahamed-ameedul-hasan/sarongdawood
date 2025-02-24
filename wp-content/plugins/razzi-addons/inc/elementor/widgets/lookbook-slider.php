<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Stack;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Lookbook slider widget
 */
class Lookbook_slider extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-lookbook-slider';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Lookbook Slider', 'razzi-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-slider';
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
		$this->section_content_slides();
		$this->section_content_option();
	}

	protected function section_content_slides() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Slides', 'razzi-addons' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );

		$repeater->start_controls_tab( 'background', [ 'label' => esc_html__( 'Content', 'razzi-addons' ) ] );

		$repeater->add_responsive_control(
			'banner_background_img',
			[
				'label'     => __( 'Background Image', 'razzi-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => 'https://via.placeholder.com/1920X600/cccccc?text=Image',
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-block__img:not(.swiper-lazy)' => 'background-image: url("{{URL}}");',
				],
			]
		);

		$repeater->add_responsive_control(
			'background_size',
			[
				'label'     => esc_html__( 'Background Size', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					'cover'   => esc_html__( 'Cover', 'razzi-addons' ),
					'contain' => esc_html__( 'Contain', 'razzi-addons' ),
					'auto'    => esc_html__( 'Auto', 'razzi-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-block__img' => 'background-size: {{VALUE}}',
				],
				'condition' => [
					'banner_background_img[url]!' => '',
				],
			]
		);

		$repeater->add_responsive_control(
			'background_position',
			[
				'label'     => esc_html__( 'Background Position', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''              => esc_html__( 'Default', 'razzi-addons' ),
					'left top'      => esc_html__( 'Left Top', 'razzi-addons' ),
					'left center'   => esc_html__( 'Left Center', 'razzi-addons' ),
					'left bottom'   => esc_html__( 'Left Bottom', 'razzi-addons' ),
					'right top'     => esc_html__( 'Right Top', 'razzi-addons' ),
					'right center'  => esc_html__( 'Right Center', 'razzi-addons' ),
					'right bottom'  => esc_html__( 'Right Bottom', 'razzi-addons' ),
					'center top'    => esc_html__( 'Center Top', 'razzi-addons' ),
					'center center' => esc_html__( 'Center Center', 'razzi-addons' ),
					'center bottom' => esc_html__( 'Center Bottom', 'razzi-addons' ),
					'initial'       => esc_html__( 'Custom', 'razzi-addons' ),
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-block__img' => 'background-position: {{VALUE}};',
				],
				'condition' => [
					'banner_background_img[url]!' => '',
				],

			]
		);

		$repeater->add_responsive_control(
			'background_position_xy',
			[
				'label'              => esc_html__( 'Custom Background Position', 'razzi-addons' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'left' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [],
				'selectors'          => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-block__img' => 'background-position: {{LEFT}}{{UNIT}} {{TOP}}{{UNIT}};',
				],
				'condition'          => [
					'background_position'         => [ 'initial' ],
					'banner_background_img[url]!' => '',
				],
				'required'           => true,
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'razzi-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Slide Heading', 'razzi-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'show_default_icon',
			[
				'label'        => esc_html__( 'Show Default Icon', 'razzi-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'razzi-addons' ),
				'label_on'     => __( 'On', 'razzi-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'razzi-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Click Here', 'razzi-addons' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'razzi-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'razzi-addons' ),
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'product_lookbooks', [ 'label' => esc_html__( 'Lookbooks', 'razzi-addons' ) ] );

		$control = apply_filters( 'razzi_slider_section_product_number', 3 );
		for ( $i = 1; $i <= $control; $i ++ ) {

			$repeater->add_control(
				'product_lookbooks_heading_' . $i,
				[
					'type'  => Controls_Manager::HEADING,
					'label' => esc_html__( 'Lookbook', 'razzi-addons' ) . ' ' . $i,
				]
			);

			$repeater->add_control(
				'product_lookbooks_ids_' . $i,
				[
					'label'       => esc_html__( 'Product', 'razzi-addons' ),
					'placeholder' => esc_html__( 'Click here and start typing...', 'razzi-addons' ),
					'type'        => 'rzautocomplete',
					'default'     => '',
					'label_block' => true,
					'multiple'    => false,
					'source'      => 'product',
					'sortable'    => true,
				]
			);


			$repeater->add_responsive_control(
				'product_lookbooks_position_x_' . $i,
				[
					'label'      => esc_html__( 'Point Position X', 'razzi-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => 30 + $i * 10,
					],
					'size_units' => [ '%', 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .razzi-lookbook-item.item-' . $i . '' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$repeater->add_responsive_control(
				'product_lookbooks_position_y_' . $i,
				[
					'label'      => esc_html__( 'Point Position Y', 'razzi-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => 30 + $i * 10,
					],
					'size_units' => [ '%', 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .razzi-lookbook-item.item-' . $i . ' ' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);


			$repeater->add_responsive_control(
				'product_content_lookbooks_position_x_' . $i,
				[
					'label'      => esc_html__( 'Product Position X', 'razzi-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => - 1000,
							'max' => 1000,
						],
						'%'  => [
							'min' => - 100,
							'max' => 100,
						],
					],
					'default'    => [],
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .razzi-lookbook-item.item-' . $i . ' .product-item' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$repeater->add_responsive_control(
				'product_content_lookbooks_position_y_' . $i,
				[
					'label'      => esc_html__( 'Product Position Y', 'razzi-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => - 1000,
							'max' => 1000,
						],
						'%'  => [
							'min' => - 100,
							'max' => 100,
						],
					],
					'default'    => [],
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .razzi-lookbook-item.item-' . $i . ' .product-item' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$repeater->add_control(
				'product_lookbooks_hr_' . $i,
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);

		}

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'style', [ 'label' => esc_html__( 'Style', 'razzi-addons' ) ] );

		$repeater->add_control(
			'custom_style',
			[
				'label'       => esc_html__( 'Custom', 'razzi-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Set custom style that will only affect this specific slide.', 'razzi-addons' ),
			]
		);

		$repeater->add_responsive_control(
			'horizontal_position',
			[
				'label'                => esc_html__( 'Horizontal Position', 'razzi-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'razzi-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'razzi-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'razzi-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'              => '',
				'selectors'            => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-inner' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
				'conditions'           => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'vertical_position',
			[
				'label'                => esc_html__( 'Vertical Position', 'razzi-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => esc_html__( 'Top', 'razzi-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'razzi-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'razzi-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors'            => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-inner' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'conditions'           => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'text_align',
			[
				'label'       => esc_html__( 'Text Align', 'razzi-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'razzi-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'razzi-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'razzi-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-inner' => 'text-align: {{VALUE}}',
				],
				'conditions'  => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'blank_position',
			[
				'label'                => esc_html__( 'Blank Position', 'razzi-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'razzi-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'razzi-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'              => '',
				'selectors'            => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-block__blank' => 'order: {{VALUE}}',
					'{{WRAPPER}} .razzi-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-block__img' => 'order: 1',
				],
				'selectors_dictionary' => [
					'left'   => '1',
					'right'  => '2',
				],
				'conditions'           => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'separator'  => 'before',
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label'      => esc_html__( 'Slides Items', 'razzi-addons' ),
				'type'       => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields'     => $repeater->get_controls(),
				'default'    => [
					[
						'title'       => esc_html__( 'Slide 1 Heading', 'razzi-addons' ),
						'description' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'razzi-addons' ),
						'button_text' => esc_html__( 'Click Here', 'razzi-addons' ),
					],
					[
						'title'       => esc_html__( 'Slide 2 Heading', 'razzi-addons' ),
						'description' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'razzi-addons' ),
						'button_text' => esc_html__( 'Click Here', 'razzi-addons' ),
					],
					[
						'title'       => esc_html__( 'Slide 3 Heading', 'razzi-addons' ),
						'description' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'razzi-addons' ),
						'button_text' => esc_html__( 'Click Here', 'razzi-addons' ),
					],
				],
			]
		);

		$this->add_responsive_control(
			'slides_height',
			[
				'label'      => esc_html__( 'Height', 'razzi-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 580,
				],
				'size_units' => [ 'px', 'vh', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .item-slider' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'lazyload',
			[
				'label'              => esc_html__( 'Lazy load for images', 'razzi-addons' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_off'          => __( 'Off', 'razzi-addons' ),
				'label_on'           => __( 'On', 'razzi-addons' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => esc_html__( 'Link Type', 'razzi-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'only' => esc_html__( 'Only button text', 'razzi-addons' ),
					'all'  => esc_html__( 'All slider', 'razzi-addons' ),
				],
				'default' => 'only',
				'toggle'  => false,
			]
		);

		$this->end_controls_section();
	}

	protected function section_content_option() {
		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'razzi-addons' ),
				'type'  => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'effect',
			[
				'label'              => esc_html__( 'Effect', 'razzi-addons' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'fade'      => esc_html__( 'Fade', 'razzi-addons' ),
					'slide'     => esc_html__( 'Slide', 'razzi-addons' ),
					'cube'      => esc_html__( 'Cube', 'razzi-addons' ),
					'coverflow' => esc_html__( 'Coverflow', 'razzi-addons' ),
				],
				'default'            => 'fade',
				'toggle'             => false,
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'navigation',
			[
				'label'   => esc_html__( 'Navigation', 'razzi-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'   => esc_html__( 'None', 'razzi-addons' ),
					'arrows' => esc_html__( 'Arrows', 'razzi-addons' ),
					'dots'   => esc_html__( 'Dots', 'razzi-addons' ),
				],
				'default' => 'arrows',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'              => esc_html__( 'Autoplay', 'razzi-addons' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_off'          => __( 'Off', 'razzi-addons' ),
				'label_on'           => __( 'On', 'razzi-addons' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'delay',
			[
				'label'              => esc_html__( 'Delay', 'razzi-addons' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 3000,
				'description'        => esc_html__( 'Delay between transitions (in ms). If this parameter is not specified, auto play will be disabled', 'razzi-addons' ),
				'conditions'         => [
					'terms' => [
						[
							'name'  => 'autoplay',
							'value' => 'yes',
						]
					],
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'              => esc_html__( 'Autoplay Speed', 'razzi-addons' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 1000,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'              => esc_html__( 'Infinite Loop', 'razzi-addons' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_off'          => __( 'Off', 'razzi-addons' ),
				'label_on'           => __( 'On', 'razzi-addons' ),
				'return_value'       => 'yes',
				'default'            => '',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

	}

	// Tab Style
	protected function section_style() {
		// Tab
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'blank_max_width',
			[
				'label'      => esc_html__( 'Blank Width', 'razzi-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .slick-slide-block__blank' => 'flex:0 0 {{SIZE}}%;max-width: {{SIZE}}%',
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .slick-slide-block__img'   => 'flex:0 0 calc(100% - {{SIZE}}%);max-width: calc(100% - {{SIZE}}%)',
				],
			]
		);

		// Tab
		$this->add_control(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'razzi-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'title_display',
			[
				'label'     => esc_html__( 'Display', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					'block' => esc_html__( 'Show', 'razzi-addons' ),
					'none'  => esc_html__( 'Hidden', 'razzi-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .slick-slide-inner .razzi-slide-heading' => 'display: {{VALUE}}',
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
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .slick-slide-inner .razzi-slide-heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .razzi-slide-heading' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .razzi-lookbook-slider-elementor .razzi-slide-heading',
			]
		);

		$this->add_control(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'razzi-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'btn_display',
			[
				'label'     => esc_html__( 'Display', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					'block' => esc_html__( 'Show', 'razzi-addons' ),
					'none'  => esc_html__( 'Hidden', 'razzi-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .button-text' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .button-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .razzi-lookbook-slider-elementor .button-text',
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label'     => esc_html__( 'Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .button-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'btn_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .button-text' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
		// End tab

		$this->section_style_lookbook();

		$this->section_style_carousel();
	}

	protected function section_style_lookbook() {

		// Arrows
		$this->start_controls_section(
			'section_style_lookbook',
			[
				'label' => esc_html__( 'LookBook', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lookbook_bgcolor',
			[
				'label'     => esc_html__( 'Dot Background Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .razzi-lookbook-item' => ' --rz-lookbook-color-primary: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lookbook_title_heading',
			[
				'label'     => esc_html__( 'Title', 'razzi-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'lookbook_title_typography',
				'selector' => '{{WRAPPER}} .razzi-lookbook-slider-elementor .product-item .product-name',
			]
		);

		$this->add_control(
			'lookbook_title_color',
			[
				'label'     => esc_html__( 'Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .product-item .product-name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lookbook_price_heading',
			[
				'label'     => esc_html__( 'Price', 'razzi-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'lookbook_price_typography',
				'selector' => '{{WRAPPER}} .razzi-lookbook-slider-elementor .product-item .product-price',
			]
		);

		$this->add_control(
			'lookbook_price_color',
			[
				'label'     => esc_html__( 'Regular Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .product-item .product-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lookbook_price_color_1',
			[
				'label'     => esc_html__( 'Sale Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .product-item .product-price ins' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_carousel() {
		// Arrows
		$this->start_controls_section(
			'section_style_slider',
			[
				'label' => esc_html__( 'Slider Options', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Arrows
		$this->add_control(
			'arrow_style_heading',
			[
				'label' => esc_html__( 'Arrows', 'razzi-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'arrow_position',
			[
				'label'                => esc_html__( 'Arrow Position', 'razzi-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'bottom'    => [
						'title' => esc_html__( 'Top', 'razzi-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
					'both' => [
						'title' => esc_html__( 'Middle', 'razzi-addons' ),
						'icon'  => 'eicon-h-align-stretch',
					],
				],
				'prefix_class' => 'razzi-lookbook-slider-nav-position-',
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_size',
			[
				'label'     => __( 'Size', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .rz-swiper-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .rz-swiper-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Dots
		$this->add_control(
			'dots_style_heading',
			[
				'label'     => esc_html__( 'Dots', 'razzi-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dots_style',
			[
				'label'        => __( 'Options', 'razzi-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'razzi-addons' ),
				'label_on'     => __( 'Custom', 'razzi-addons' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'sliders_dots_gap',
			[
				'label'     => __( 'Gap', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_dots_size',
			[
				'label'     => __( 'Size', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_dots_offset_ver',
			[
				'label'     => esc_html__( 'Spacing Top', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => - 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'sliders_dots_normal_settings' );

		$this->start_controls_tab( 'sliders_dots_normal', [ 'label' => esc_html__( 'Normal', 'razzi-addons' ) ] );

		$this->add_control(
			'sliders_dots_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'sliders_dots_active', [ 'label' => esc_html__( 'Active', 'razzi-addons' ) ] );

		$this->add_control(
			'sliders_dots_ac_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-lookbook-slider-elementor .swiper-pagination-bullet-active:before, {{WRAPPER}} .razzi-lookbook-slider-elementor .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['slides'] ) ) {
			return;
		}

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$classes = [
			'razzi-lookbook-slider-elementor swiper-container',
			'razzi-swiper-carousel-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$slides      = [];
		$slide_count = 0;

		foreach ( $settings['slides'] as $slide ) {
			$slide_html       = '';
			$btn_attributes   = '';
			$slide_attributes = '';
			$slide_element    = 'div';
			$btn_element      = 'div';

			$slide_html .= '<div class="razzi-slide-content">';

			if ( $slide['title'] ) {
				$slide_html .= '<div class="razzi-slide-heading">' . $slide['title'] . '</div>';
			}

			// Button
			$link_icon = $slide['show_default_icon'] ? \Razzi\Addons\Helper::get_svg( 'arrow-right', 'razzi-icon' ) : '';

			$button_text = $slide['button_text'] ? sprintf( '<span class="button-text razzi-button">%s %s</span>', $slide['button_text'], $link_icon ) : '';

			$key_btn   = 'btn_' . $slide_count;
			$key_btn_2 = 'btn2_' . $slide_count;

			$btn_full = '';

			if ( $slide['link']['url'] ) :

				$btn_full = $settings['link_type'] == 'all' ? Helper::control_url( $key_btn_2, $slide['link'], '', [ 'class' => 'full-box-button' ] ) : '';

				$button_text = Helper::control_url( $key_btn, $slide['link'], $button_text, [ 'class' => 'button-link' ] );

			endif;

			$slide_html .= $button_text;

			$slide_html .= '</div>';

			$control = apply_filters( 'razzi_slider_section_product_number', 3 );

			for ( $i = 1; $i <= $control; $i ++ ) {

				$product = '';

				$products_html = [];
				$product_id    = $slide["product_lookbooks_ids_$i"];
				$product       = wc_get_product( $product_id );

				if ( empty( $product ) ) {
					continue;
				}

				if ( $product_id ) {
					$products_html[] = sprintf(
						'<div class="product-item">
							<div class="product-image">%s</div>
							<div class="product-summary">
								<h6 class="product-name">%s</h6>
								<div class="product-price">%s</div>
							</div>
							<a class="razzi-slide-button" href="%s"></a>
						</div>',
						$product->get_image( 'single_product_archive_thumbnail_size' ),
						$product->get_name(),
						$product->get_price_html(),
						get_permalink( $product_id )
					);
				}

				$slide_html .= $product_id ? sprintf(
					'<div class="razzi-lookbook-item item-%s">%s</div>',
					esc_attr( $i ),
					implode( '', $products_html )
				) : '';
			}

			$slide_html .= $btn_full;

			$slide_html = '<div class="slick-slide-inner container">' . $slide_html . '</div>';

			$data_lazy_url = $data_lazy_class = '';

			if ( $settings['lazyload'] ) {

				$data_lazy_url   = 'data-background="' . $slide['banner_background_img']['url'] . '"';
				$data_lazy_class = 'swiper-lazy';

			}


			$slide_other_html = '<div class="slick-slide-block row-flex">';
			$slide_other_html .= '<div class="slick-slide-block__blank col-flex col-flex-md-4"></div>';
			$slide_other_html .= '<div ' . $data_lazy_url . ' class="slick-slide-block__img col-flex col-flex-md-8 ' . $data_lazy_class . '"></div>';
			$slide_other_html .= $btn_full;
			$slide_other_html .= '</div>';

			$slides[] = '<div class="elementor-repeater-item-' . $slide['_id'] . ' item-slider swiper-slide">' . $slide_html . $slide_other_html . '</div>';

			$slide_count ++;
		}

		$output_arrow = \Razzi\Addons\Helper::get_svg( 'chevron-left', 'rz-swiper-button-prev rz-swiper-button' );
		$output_arrow .= \Razzi\Addons\Helper::get_svg( 'chevron-right', 'rz-swiper-button-next rz-swiper-button' );

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		echo sprintf(
			'<div %s>
				<div class="razzi-lookbook-slider-elementor__inner swiper-wrapper">%s</div>
				<div class="swiper-pagination"></div>
				%s
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $slides ),
			$output_arrow
		);
	}
}