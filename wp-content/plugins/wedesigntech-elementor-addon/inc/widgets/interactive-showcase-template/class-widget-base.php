<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Interactive_Showcase_Template {

	private static $_instance = null;

	private $cc_repeater_contents;
	private $cc_content_position;
	private $cc_layout;
	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {

		// Options
			$options_group = array( 'default' );
			$options['default'] = array(
				'icon'           => esc_html__( 'Icon', 'wdt-elementor-addon'),
				'title'          => esc_html__( 'Title', 'wdt-elementor-addon'),
				'description'    => esc_html__( 'Description', 'wdt-elementor-addon'),
				'image'          => esc_html__( 'Image', 'wdt-elementor-addon'),
				'link'           => esc_html__( 'Link', 'wdt-elementor-addon'),
				'button'         => esc_html__( 'Button', 'wdt-elementor-addon')
			);

		// Group 1 content positions
			$group1_content_position_elements = array(
				'image'           => esc_html__( 'Image', 'wdt-elementor-addon'),
				'icon'            => esc_html__( 'Icon', 'wdt-elementor-addon'),
				'elements_group'  => esc_html__( 'Elements Group', 'wdt-elementor-addon')
			);
			$group1_content_positions = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);

		// Group 1 - Element Group content positions
			$group1_element_group_content_position_elements = array(
				'title'           => esc_html__( 'Title', 'wdt-elementor-addon'),
				'description'     => esc_html__( 'Description', 'wdt-elementor-addon'),
				'button'          => esc_html__( 'Button', 'wdt-elementor-addon')
			);
			$group1_element_group_content_positions = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);

		// Group 2 content positions
			$group2_content_position_elements = array();
			$group2_content_positions = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);

		// Group 2 - Element Group content positions
			$group2_element_group_content_position_elements = array();
			$group2_element_group_content_positions = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

		// Content position elements
			$content_position_elements = array_merge($group1_content_position_elements, $group1_element_group_content_position_elements, $group2_content_position_elements, $group2_element_group_content_position_elements);

		// Module defaults
			$option_defaults = array(
				array(
					'item_type' => 'default',
					'media_image' => array (
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'media_image_size' => 'full',
					'media_icon' => array (
						'value' => 'fas fa-star',
						'library' => 'fa-solid'
					),
					'media_icon_style' => 'default',
					'media_icon_shape' => 'circle',
					'item_title' => esc_html__( 'Ut accumsan mass', 'wdt-elementor-addon' ),
					'item_description' => esc_html__( 'Donec sed lectus mi. Vestibulum et augue ultricies, tempus augue non, consectetur est. In arcu justo, pulvinar sit amet turpis id, tincidunt fermentum eros.', 'wdt-elementor-addon' ),
					'item_link'    => array (
						'url' => '#',
						'is_external' => true,
						'nofollow' => true,
						'custom_attributes' => ''
					),
					'item_button_text' => esc_html__( 'Click Here', 'wdt-elementor-addon' )
				),
				array(
					'item_type' => 'default',
					'media_image' => array (
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'media_image_size' => 'full',
					'media_icon' => array (
						'value' => 'fas fa-star',
						'library' => 'fa-solid'
					),
					'media_icon_style' => 'default',
					'media_icon_shape' => 'circle',
					'item_title' => esc_html__( 'Pellentesque ornare', 'wdt-elementor-addon' ),
					'item_sub_title' => esc_html__( 'Tesque ornare', 'wdt-elementor-addon' ),
					'item_description' => esc_html__( 'Vestibulum et augue ultricies, tempus augue non, consectetur est. In arcu justo, pulvinar sit amet turpis id, tincidunt fermentum eros.', 'wdt-elementor-addon' ),
					'item_link'    => array (
						'url' => '#',
						'is_external' => true,
						'nofollow' => true,
						'custom_attributes' => ''
					),
					'item_button_text' => esc_html__( 'Click Here', 'wdt-elementor-addon' )
				)
			);

		// Module Details
			$module_details = array (
				'content_positions' => array ( 'group1', 'group1_element_group', 'group2', 'group2_element_group'),
				'group1_title'    => esc_html__( 'Image Group', 'wdt-elementor-addon'),
				'group2_title'    => esc_html__( 'Content Group', 'wdt-elementor-addon'),
				'group_cp_label'    => esc_html__( 'Content Positions', 'wdt-elementor-addon'),
				'group_eg_cp_label' => esc_html__( 'Element Group - Content Positions', 'wdt-elementor-addon'),
				'jsSlug'          => 'wdtRepeaterInteractiveShowcaseContent',
				'title'           => esc_html__( 'Items', 'wdt-elementor-addon' ),
				'description'     => ''
			);

		// Initialize depandant class
			$this->cc_repeater_contents = new WeDesignTech_Common_Controls_Repeater_Contents($options_group, $options, $option_defaults, $module_details);
			$this->cc_content_position = new WeDesignTech_Common_Controls_Content_Position($content_position_elements, $group1_content_positions, $group1_element_group_content_positions, $group2_content_positions, $group2_element_group_content_positions, $module_details);
			$this->cc_layout = new WeDesignTech_Common_Controls_Layout('both');
			$this->cc_style = new WeDesignTech_Common_Controls_Style();

	}

	public function name() {
		return 'wdt-interactive-showcase-template';
	}

	public function title() {
		return esc_html__( 'Interactive Showcase Template', 'wdt-elementor-addon' );
	}

	public function icon() {
		return 'eicon-inner-section';
	}

	public function init_styles() {
		return array_merge(
			$this->cc_repeater_contents->init_styles(),
			array (
				$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/interactive-showcase-template/assets/css/style.css'
			)
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/interactive-showcase-template/assets/js/script.js'
		);
	}

	public function create_elementor_controls($elementor_object) {

		$this->cc_repeater_contents->get_controls($elementor_object);

		$elementor_object->start_controls_section( 'wdt_section_settings', array(
			'label' => esc_html__( 'Settings', 'wdt-elementor-addon'),
		) );

			/* $elementor_object->add_control(
				'icon_show',
				array(
					'label'              => esc_html__( 'Show Icon', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => 'true',
					'return_value'       => 'true',
					'condition' => array ()
				)
			);

			$elementor_object->add_control(
				'image_show',
				array(
					'label'              => esc_html__( 'Show Image', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => 'true',
					'return_value'       => 'true',
					'condition' => array ()
				)
			); */

			$elementor_object->add_control(
				'hover_and_click',
				array(
					'label'              => esc_html__( 'Show Content on Click', 'wdt-elementor-addon' ),
					'type'               => \Elementor\Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'default'            => 'false',
					'return_value'       => 'true',
					'condition' => array ()
				)
			);

			/* $elementor_object->add_control(
				'title_prefix',
				array (
					'label' 			 => esc_html__( 'Title Prefix', 'wdt-elementor-addon' ),
					'type' 				 => \Elementor\Controls_Manager::SELECT,
					'options' 			 => array (
						''  			 => esc_html__( 'None', 'wdt-elementor-addon' ),
						'number'   		 => esc_html__( 'Number', 'wdt-elementor-addon' ),
						'alphabet' 		 => esc_html__( 'Alphabet', 'wdt-elementor-addon' ),
					),
					'default' 			 => ''
				)
			); */

			$elementor_object->add_control( 'template', array(
				'label'   => esc_html__( 'Template', 'wdt-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'default' => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'wdt-elementor-addon' ),
					'standard' => esc_html__( 'Standard', 'wdt-elementor-addon' ),
					'custom-template' => esc_html__( 'Custom Template', 'wdt-elementor-addon' )
				)
			) );

		$elementor_object->end_controls_section();

		$this->cc_content_position->get_controls($elementor_object, array ( 'template' => 'custom-template' ));


	// Item Content
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'tab_item_content',
			'title' => esc_html__( 'Item Content', 'wdt-elementor-addon' ),
			'styles' => array (
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper',
									'color_selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper:before' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper:before',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper:before',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover / Active', 'wdt-elementor-addon' ),
							'styles' => array (
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper:hover',
									'color_selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper:before, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper:hover' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper:hover, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));

	// Title
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'tab_title',
			'title' => esc_html__( 'Title', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title',
					'condition' => array ()
				),
				'tabs' => array (
					'field_type' => 'tabs',
					'tab_items' => array (
						'normal' => array (
							'title' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-title h5, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-title h5 a' => 'color: {{VALUE}};',
										'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-title h5:before' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-title h5 a',
									'color_selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-title h5 a' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title:before',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title:before',
									'condition' => array ()
								)
							)
						),
						'hover' => array (
							'title' => esc_html__( 'Hover / Active', 'wdt-elementor-addon' ),
							'styles' => array (
								'color' => array (
									'field_type' => 'color',
									'selector' => array (
										'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-title h5:hover, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-title h5 a:hover' => 'color: {{VALUE}};',
										'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title:before, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title:after, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title:before' => 'color: {{VALUE}};',
										'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title h5 a:after, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-list a.wdt-interactive-showcase-element::after' => 'background: transparent;'
									),
									'condition' => array ()
								),
								'background' => array (
									'field_type' => 'background',
									'selector' => '{{WRAPPER}} {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title h5 a, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title h5 a:hover',
									'color_selector' => array (
										'{{WRAPPER}} {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title h5 a, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-list:before, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title h5 a:hover' => 'background-color: {{VALUE}};'
									),
									'condition' => array ()
								),
								'border' => array (
									'field_type' => 'border',
									'selector' => '{{WRAPPER}} {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title h5 a, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title h5 a:hover, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title h5 a:hover',
									'condition' => array ()
								),
								'border_radius' => array (
									'field_type' => 'border_radius',
									'selector' => array (
										'{{WRAPPER}} {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title h5 a, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title h5 a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
									),
									'condition' => array ()
								),
								'box_shadow' => array (
									'field_type' => 'box_shadow',
									'selector' => '{{WRAPPER}} {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title h5 a, {{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group .wdt-content-title h5 a:hover',
									'condition' => array ()
								)
							)
						)
					)
				)
			)
		));


	// Tab Content
		$this->cc_style->get_style_controls($elementor_object, array (
			'slug' => 'tab_content',
			'title' => esc_html__( 'Tab Content', 'wdt-elementor-addon' ),
			'styles' => array (
				'alignment' => array (
					'field_type' => 'alignment',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}; justify-items: {{VALUE}};'
					),
					'condition' => array ()
				),
				'vertical_align' => array (
					'field_type' => 'vertical_align',
					'label' => esc_html__( 'Vertical Position', 'wdt-elementor-addon' ),
					'options' => array (
						'start' => array (
							'title' => esc_html__( 'Start', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-top',
						),
						'center' => array (
							'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-middle',
						),
						'end' => array (
							'title' => esc_html__( 'End', 'wdt-elementor-addon' ),
							'icon' => 'eicon-v-align-bottom',
						)
					),
					'default' => 'center',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group' => 'align-content: {{VALUE}};'
					),
					'condition' => array (
						'template' => 'default'
					)
				),
				'margin' => array (
					'field_type' => 'margin',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'padding' => array (
					'field_type' => 'padding',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'typography' => array (
					'field_type' => 'typography',
					'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group',
					'condition' => array ()
				),
				'color' => array (
					'field_type' => 'color',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group' => 'color: {{VALUE}};'
					),
					'condition' => array ()
				),
				'background' => array (
					'field_type' => 'background',
					'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group',
					'condition' => array ()
				),
				'border' => array (
					'field_type' => 'border',
					'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group',
					'condition' => array ()
				),
				'border_radius' => array (
					'field_type' => 'border_radius',
					'selector' => array (
						'{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition' => array ()
				),
				'box_shadow' => array (
					'field_type' => 'box_shadow',
					'selector' => '{{WRAPPER}} .wdt-interactive-showcase-template-container .wdt-interactive-showcase-template-list-wrapper .wdt-content-item .wdt-content-detail-group',
					'condition' => array ()
				)
			)
		));

	}

	public function render_html($widget_object, $settings) {

		if($widget_object->widget_type != 'elementor') {
			return;
		}

		$output = '';

		if( count( $settings['item_contents'] ) > 0 ):

			$classes = array ();
			array_push($classes, 'wdt-rc-template-'.$settings['template']);

			$settings['module_id'] = $widget_object->get_id();
			$settings['module_class'] = 'interactive-showcase-template';

			$settings['classes'] = $classes;
			$this->cc_layout->set_settings($settings);
			$settings['module_layout_class'] = $this->cc_layout->get_item_class();

			$output .= '<div class="wdt-interactive-showcase-template-container" data-click="'. esc_js($settings['hover_and_click']) .'">';
				$output .= '<div class="wdt-interactive-showcase-template-list-wrapper wdt-rc-template-'.$settings['template'].'">';

			if($settings['template'] == 'custom-template') {

				$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

			} else if($settings['template'] == 'default') {

				$group1_content_position_elements = array(
					'image' => esc_html__( 'Image', 'wdt-elementor-addon')
				);
				$group1_element_group_content_position_elements = array();
				$group2_content_position_elements = array(
					'title' => esc_html__( 'Title', 'wdt-elementor-addon'),
					'description' => esc_html__( 'Description', 'wdt-elementor-addon'),
					'button' => esc_html__( 'Button', 'wdt-elementor-addon')
				);
				$group2_element_group_content_position_elements = array();

				$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
				$settings['group1_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);
				$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);
				$settings['group2_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

				$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

			} else if($settings['template'] == 'standard') {

				$group1_content_position_elements = array(
					'image' => esc_html__( 'Image', 'wdt-elementor-addon')
				);
				$group1_element_group_content_position_elements = array();
				$group2_content_position_elements = array(
					'title' => esc_html__( 'Title', 'wdt-elementor-addon')
				);
				$group2_element_group_content_position_elements = array();

				$settings['group1_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_content_position_elements);
				$settings['group1_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group1_element_group_content_position_elements);
				$settings['group2_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_content_position_elements);
				$settings['group2_element_group_content_positions'] = wedesigntech_elementor_format_repeater_values($group2_element_group_content_position_elements);

				$output .= $this->cc_repeater_contents->render_html($widget_object, $settings);

			}

				$output .= $this->cc_layout->get_column_edit_mode_css();

				$output .= '</div>';
			$output .= '</div>';
			
		else:
			$output .= '<div class="wdt-interactive-showcase-template-container no-records">';
				$output .= esc_html__('No records found!', 'wdt-elementor-addon');
			$output .= '</div>';
		endif;

		return $output;

	}

	public function render_icon($icon) {
		$output = '';
		if(!empty($icon['value'])):

			$output .= ($icon['library'] === 'svg') ? '<i>' : '';
				ob_start();
				\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
				$output .= ob_get_clean();
			$output .= ($icon['library'] === 'svg') ? '</i>' : '';

		endif;
		return $output;
	}

	public function render_image($item, $link_start, $link_end) {
		$output = '';
		if ( ! empty( $item['media_image_template']['url'] ) ) :
			$class = '';
			$output .= '<div class="wdt-content-image-wrapper '.esc_attr($class).'">';
				$output .= '<div class="wdt-content-image">';

					$media_image_setting = array ();
					$media_image_setting['image'] = $item['media_image_template'];
					$media_image_setting['image_size'] = 'full';
					$media_image_setting['image_custom_dimension'] = isset($item['media_image_template_custom_dimension']) ? $item['media_image_custom_dimension'] : array ();

					$output .=  ($link_start != '') ? $link_start : '<span>';
						$output .= \Elementor\Group_Control_Image_Size::get_attachment_image_html( $media_image_setting );
					$output .=  ($link_end != '') ? $link_end : '</span>';

				$output .= '</div>';
			$output .= '</div>';

		endif;
		return $output;
	}

}

if( !function_exists( 'wedesigntech_widget_base_interactive_showcase_template' ) ) {
    function wedesigntech_widget_base_interactive_showcase_template() {
        return WeDesignTech_Widget_Base_Interactive_Showcase_Template::instance();
    }
}