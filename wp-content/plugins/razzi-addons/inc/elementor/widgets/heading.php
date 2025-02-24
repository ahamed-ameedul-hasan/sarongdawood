<?php

namespace Razzi\Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Widget_Base;

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Heading extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-heading';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Razzi - Heading', 'razzi-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-t-letter';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'razzi' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'heading', 'title', 'text' ];
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Heading', 'razzi-addons' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'   => __( 'SubTitle', 'razzi-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'razzi-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your title', 'razzi-addons' ),
				'default'     => __( 'Add Your Heading Text Here', 'razzi-addons' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'     => __( 'Link', 'razzi-addons' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [
					'active' => true,
				],
				'default'   => [
					'url' => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'header_size',
			[
				'label'   => __( 'HTML Tag', 'razzi-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h2',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'     => __( 'Alignment', 'razzi-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'razzi-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'razzi-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'razzi-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'razzi-addons' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shape',
			[
				'label'     => __( 'Shape', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'razzi-addons' ),
				'label_on'  => __( 'On', 'razzi-addons' ),
				'default'   => '',
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'shape_position',
			[
				'label'           => esc_html__( 'Position', 'razzi-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 0,
				'max'             => 50,
				'default' 		=> '',
				'frontend_available' => true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'shape',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'shape_background',
				'label' => esc_html__( 'Background', 'razzi-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .razzi-heading-title .razzi-shape-background',
				'conditions' => [
					'terms' => [
						[
							'name' => 'shape',
							'value' => 'yes',
						],
					],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Heading', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'auto_scrolling',
			[
				'label'     => esc_html__( 'Auto Scrolling', 'razzi-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'razzi-addons' ),
				'label_off' => esc_html__( 'No', 'razzi-addons' ),
				'default'   => 'no',
				'return_value' => 'yes',
			]
		);

		$this->add_responsive_control(
			'spacing_text',
			[
				'label'     => esc_html__( 'Spacing Text', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-heading-title' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'auto_scrolling',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'scroll_animation_duration',
			[
				'label'     => esc_html__( 'Scroll Animation Duration (second)', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 's',
				],
				'range'     => [
					's' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-heading-title' => '--rz-animation-duration: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'auto_scrolling',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'title_heading',
			[
				'label'     => __( 'Title', 'razzi-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_gradient_color',
			[
				'label'     => __( 'Gradient Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-heading-title' => 'background: linear-gradient(92.37deg, {{title_color.VALUE}} 0%, {{VALUE}} 100%);
					-webkit-background-clip: text;
					-webkit-text-fill-color: transparent;
					background-clip: text;
					text-fill-color: transparent;
					display: inline-block;',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Text Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .razzi-heading-title',
			]
		);

		$this->add_control(
			'stroke_width',
			[
				'label'     => esc_html__( 'Stroke Width', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-heading-title' => '--rz-stroke-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'stroke_color',
			[
				'label'     => __( 'Stroke Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-heading-title' => '--rz-stroke-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'subtitle_heading',
			[
				'label'     => __( 'SubTitle', 'razzi-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => __( 'Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-heading-title small' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .razzi-heading-title small',
			]
		);

		$this->add_responsive_control(
			'subtitle_spacing',
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
					'{{WRAPPER}} .razzi-heading-title small' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'shape_heading',
			[
				'label'     => __( 'Shape', 'razzi-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name' => 'shape',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'shape_typography',
				'selector' => '{{WRAPPER}} .razzi-heading-title .razzi-shape-background',
				'conditions' => [
					'terms' => [
						[
							'name' => 'shape',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'shape_color',
			[
				'label'     => __( 'Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .razzi-heading-title .razzi-shape-background' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'shape',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'shape_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-heading-title .razzi-shape-background' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'shape',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'shape_margin',
			[
				'label'      => esc_html__( 'Margin', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-heading-title .razzi-shape-background' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'shape',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'title', 'class', 'razzi-heading-title' );
		$this->add_render_attribute( 'wrapper', 'class', 'razzi-heading-wrapper' );

		if( $settings['auto_scrolling'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper', 'class', 'razzi-heading-auto-scrolling' );
		}

		$title = $settings['title'];

		if( $settings['shape'] == 'yes' ) {
			if( $settings['shape_position'] ) {
				$shape_position = $settings['shape_position']-1;
				$title = preg_split("/\s+(?=[^>]*(<|$))/", $title);
				$title[$shape_position] = '<span class="razzi-shape-background">' . $title[$shape_position] . '</span>';
				$title = join(" ", $title);
			}
		}

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'url', $settings['link'] );

			$title = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $title );
		}

		$subtitle = '';
		if ( ! empty( $settings['subtitle'] ) ) {
			$subtitle = sprintf( '<small>%s</small>', $settings['subtitle'] );
		}

		$title_html = sprintf( '<div %1$s><%2$s %3$s>%4$s %5$s</%2$s></div>', $this->get_render_attribute_string( 'wrapper' ), Utils::validate_html_tag( $settings['header_size'] ), $this->get_render_attribute_string( 'title' ), $subtitle, $title );

		echo $title_html;
	}

	/**
	 * Render heading widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {

	}
}
