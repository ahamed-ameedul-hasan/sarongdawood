<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WeDesignTech_Widget_Base_Text_With_Image {

    private static $_instance = null;

	private $cc_style;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	function __construct() {
			
	}

    public function name() {
		return 'wdt-text-image';
	}

    public function title() {
		return esc_html__( 'Text with Image', 'wdt-elementor-addon' );
	}

    public function icon() {
		return 'eicon-apps';
	}

    public function init_styles() {
		return array (
			$this->name() =>  WEDESIGNTECH_ELEMENTOR_ADDON_DIR_URL.'inc/widgets/text-image/assets/css/style.css'
		);
	}

	public function init_inline_styles() {
		return array ();
	}

	public function init_scripts() {
		return array ();
	}

    public function create_elementor_controls($elementor_object) {

        $elementor_object->start_controls_section( 'wdt_section_features', array(
            'label' => esc_html__( 'Content', 'wdt-elementor-addon'),
            ) );
                $repeater = new \Elementor\Repeater();
                $repeater->add_control( 
                    'content_type', 
                    array(
                    'type'    => \Elementor\Controls_Manager::SELECT2,
                    'label'   => esc_html__( 'Content Type', 'wdt-elementor-addon' ),
                    'default' => 'default',
                    'options' => array(
                        'default'  => esc_html__( 'Text', 'wdt-elementor-addon' ),
                        'image' => esc_html__( 'Image', 'wdt-elementor-addon' ),
						'icon' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
                    )
                ));
                $repeater->add_control(
                    'content_template', 
                    array(
                    'label'     => esc_html__( 'Image ', 'wdt-elementor-addon' ),
                    'type'      => \Elementor\Controls_Manager::MEDIA,
                    'condition' => array (
                        'content_type' => 'image'
                    ),
                    'default' => array(
                                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                                ),
                ));
                $repeater->add_responsive_control(
                    'image_width',
                    array(
                        'label' => esc_html__( 'Width', 'wdt-elementor-addon' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => array('px', '%', 'em', 'rem', 'custom'),
                        'range' => array(
                            'px' => array(
                                'min' => 0,
                                'max' => 1000,
                                'step' => 5,
                            ),
                            '%' => array(
                                'min' => 0,
                                'max' => 100,
                            ),
                        ),
                        'default' => array(
                            'unit' => 'px',
                            'size' => 50,
                        ),
                        'selectors' => array(
                                '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{SIZE}}{{UNIT}};',
						),
                        'condition' => array (
                            'content_type' => 'image'
                        ),
				)
                );
				$repeater->add_responsive_control(
                    'image_height',
                    array(
                        'label' => esc_html__( 'Height', 'wdt-elementor-addon' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => array('px', '%', 'em', 'rem', 'custom'),
                        'range' => array(
                            'px' => array(
                                'min' => 0,
                                'max' => 1000,
                                'step' => 5,
                            ),
                            '%' => array(
                                'min' => 0,
                                'max' => 100,
                            ),
                        ),
                        'default' => array(
                            'unit' => 'px',
                            'size' => 50,
                        ),
                        'selectors' => array(
                                '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'height: {{SIZE}}{{UNIT}};',
						),
                        'condition' => array (
                            'content_type' => 'image'
                        ),
				)
                );
                $repeater->add_control(
                    'list_title',
                    array(
                        'type'    => \Elementor\Controls_Manager::TEXT,
                        'label' => esc_html__( 'Title', 'wdt-elementor-addon' ),
                        'default' => 'Sample Title',
                        'condition' => array (
                            'content_type' => 'default'
                        ),
                    )
                );
				$repeater->add_control(
					'list_color',
					array(
						'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'condition' => array (
                            'content_type' => 'default'
                        ),
						'selectors' => array(
							'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
						),
					)
				);
				$repeater->add_control(
				 'text_format',
				  array(
					'type'           => \Elementor\Controls_Manager::SELECT,
					'label'          => esc_html__( 'Style', 'wdt-elementor-addon' ),
					'default'        => 'underline',
					'options'        => array(
						'default' => esc_html__( 'Default', 'wdt-elementor-addon' ),
						'underline' => esc_html__( 'Underline', 'wdt-elementor-addon' ),
						'line-through' => esc_html__( 'Line Through', 'wdt-elementor-addon' ),
						'overline' => esc_html__( 'Overline', 'wdt-elementor-addon' )
					),
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}' => 'text-decoration: {{VALUE}};',
					),
					'condition' => array (
						'content_type' => 'default'
					),
				) 
				);
				$repeater->add_control(
                    'icon',
                    array(
                        'type'    => \Elementor\Controls_Manager::ICONS,
                        'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
						'default' => array(
							'value' => 'far fa-paper-plane',
							'library' => 'fa-solid',
						),
                        'condition' => array (
                            'content_type' => 'icon'
                        ),
                    )
                );
				$repeater->add_responsive_control(
                    'icon_size',
                    array(
                        'label' => esc_html__( 'Size', 'wdt-elementor-addon' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => array('px', '%', 'em', 'rem', 'custom'),
                        'range' => array(
                            'px' => array(
                                'min' => 0,
                                'max' => 1000,
                                'step' => 5,
                            ),
                            '%' => array(
                                'min' => 0,
                                'max' => 100,
                            ),
                        ),
                        'default' => array(
                            'unit' => 'px',
                            'size' => 25,
                        ),
                        'selectors' => array(
                                '{{WRAPPER}} {{CURRENT_ITEM}} i' => 'font-size: {{SIZE}}{{UNIT}};',
						),
                        'condition' => array (
                            'content_type' => 'icon'
                        ),
				)
                );
				$repeater->add_control(
					'icon_color',
					array(
						'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'condition' => array (
                            'content_type' => 'icon'
                        ),
						'selectors' => array(
							'{{WRAPPER}} {{CURRENT_ITEM}} i' => 'color: {{VALUE}}'
						),
					)
				);
				$elementor_object->add_control( 'title_tag', array(
					'label'   => esc_html__( 'Title Tag', 'wdt-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'h2',
					'options' => array(
						'div'  => esc_html__( 'Div', 'wdt-elementor-addon' ),
						'h1'   => esc_html__( 'H1', 'wdt-elementor-addon' ),
						'h2'   => esc_html__( 'H2', 'wdt-elementor-addon' ),
						'h3'   => esc_html__( 'H3', 'wdt-elementor-addon' ),
						'h4'   => esc_html__( 'H4', 'wdt-elementor-addon' ),
						'h5'   => esc_html__( 'H5', 'wdt-elementor-addon' ),
						'h6'   => esc_html__( 'H6', 'wdt-elementor-addon' ),
						'span' => esc_html__( 'Span', 'wdt-elementor-addon' ),
						'p'    => esc_html__( 'P', 'wdt-elementor-addon' )
					)
				));
                $elementor_object->add_control( 'features_content', array(
                    'type'        => \Elementor\Controls_Manager::REPEATER,
                    'label'       => esc_html__('Content Items', 'wdt-elementor-addon'),
                    'description' => esc_html__('Content Items', 'wdt-elementor-addon' ),
                    'fields'      => $repeater->get_controls(),
                    'default' => array (
                        array (
                            'list_title'     => esc_html__('Sed ut perspiciatis', 'wdt-elementor-addon' ),
                        ),
                        array (
                            'list_title'     => esc_html__('Lorem ipsum dolor', 'wdt-elementor-addon' ),
                        ),
                    ),
                    'title_field' => '{{{list_title}}}'
                ) );
            $elementor_object->end_controls_section();
			$elementor_object->start_controls_section(
				'wdt_item_style_section',
				array (
					'label' => esc_html__( 'Item', 'wdt-elementor-addon' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);
	
			$elementor_object->add_control(
				'text_align',
				array(
					'label' => esc_html__( 'Alignment', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => array(
						'left' => array(
							'title' => esc_html__( 'Left', 'wdt-elementor-addon' ),
							'icon' => 'eicon-text-align-left',
						),
		
						'center' => array(
							'title' => esc_html__( 'Center', 'wdt-elementor-addon' ),
							'icon' => 'eicon-text-align-center',
						),
												
						'right' => array(
							'title' => esc_html__( 'Right', 'wdt-elementor-addon' ),
							'icon' => 'eicon-text-align-right',
						),
							
					),
					'default' => 'center',
					'toggle' => true,
					'selectors' => array(
						'{{WRAPPER}} .wdt-elementor-repeater-container-wrapper' => 'text-align: {{VALUE}};',
					),
				)
					
			);
	
				$elementor_object->add_responsive_control(
				'item_margin',
				array (
					'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array ( 'px', 'em', '%' ),
					'selectors' => array (
						'{{WRAPPER}} .wdt-elementor-repeater-container-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
	
			$elementor_object->add_responsive_control(
				'item_padding',
				array (
					'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array ( 'px', 'em', '%' ),
					'selectors' => array (
						'{{WRAPPER}} .wdt-elementor-repeater-container-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);	
	
			$elementor_object->start_controls_tabs(
				'style_tabs'
			);
	
			$elementor_object->start_controls_tab(
				'style_normal_tab',
				array(
					'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
				)	
			);
	
			$elementor_object->add_control(
				'text_color',
				array(
					'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .wdt-elementor-repeater-container-wrapper' => 'color: {{VALUE}}',
					),
				)
			);
	
			$elementor_object->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				array(
					'name' => 'background',
					'types' =>  array('classic', 'gradient', 'video' ),
					'selector' => '{{WRAPPER}} .wdt-elementor-repeater-container-wrapper',
				)
			);
	
			$elementor_object->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				array(
					'name' => 'border',
					'selector' => '{{WRAPPER}} .wdt-elementor-repeater-container-wrapper',
				)
					
			);
	
			$elementor_object->add_responsive_control(
				'item-border-radius',
				array (
					'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array ( 'px', 'em', '%' ),
					'selectors' => array (
						'{{WRAPPER}} .wdt-elementor-repeater-container-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
	
			$elementor_object->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				array(
					'name' => 'item-box_shadow',
					'selector' => '{{WRAPPER}} .wdt-elementor-repeater-container-wrapper',
				)
					
			);
	
			$elementor_object->end_controls_tab();
	
			$elementor_object->start_controls_tab(
				'style_hover_tab',
				array(
					'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
				)	
			);
	
			$elementor_object->add_control(
				'text_color_hover',
				array(
					'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .wdt-elementor-repeater-container-wrapper:hover'=> 'color: {{VALUE}}',
					),
				)
			);
	
			$elementor_object->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				array(
					'name' => 'background_hover',
					'types' =>  array('classic', 'gradient', 'video' ),
					'selector' => '{{WRAPPER}} .wdt-elementor-repeater-container-wrapper:hover',
				)
			);
	
			$elementor_object->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				array(
					'name' => 'border_hover',
					'selector' => '{{WRAPPER}} .wdt-elementor-repeater-container-wrapperr:hover',
				)
					
			);
	
			$elementor_object->add_responsive_control(
				'item-border-radius_hover',
				array (
					'label' => esc_html__( 'Border Radius', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array ( 'px', 'em', '%' ),
					'selectors' => array (
						'{{WRAPPER}} .wdt-elementor-repeater-container-wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
	
			$elementor_object->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				array(
					'name' => 'item-box_shadow_hover',
					'selector' => '{{WRAPPER}} .wdt-elementor-repeater-container-wrapper:hover',
				)	
			);
	
			$elementor_object->end_controls_tab();
	
			$elementor_object->end_controls_tabs();
	
			$elementor_object->end_controls_section();

			//Title
			$elementor_object->start_controls_section(
				'wdt_title_style_section',
				array (
					'label' => esc_html__( 'Title', 'wdt-elementor-addon' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);
	
			$elementor_object->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array(
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .wdt-text-tile',
				)
			);
	
			$elementor_object->add_responsive_control(
				'item_title_margin',
				array (
					'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array ( 'px', 'em', '%' ),
					'selectors' => array (
						'{{WRAPPER}} .wdt-text-tile' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
	
			
			$elementor_object->start_controls_tabs(
				'title_style_tabs'
			);
	
			$elementor_object->start_controls_tab(
				'title_normal_tab',
				array(
					'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
				)	
			);
	
			$elementor_object->add_control(
				'title_color',
				array(
					'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .wdt-text-tile' => 'color: {{VALUE}}',
					),
				)
			);
	
			$elementor_object->end_controls_tab();
	
			$elementor_object->start_controls_tab(
				'title_hover_tab',
				array(
					'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
				)	
			);
	
			$elementor_object->add_control(
				'title_hover_color',
				array(
					'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .wdt-text-tile:hover' => 'color: {{VALUE}}',
					),
				)
			);
	
			$elementor_object->end_controls_tab();
			$elementor_object->end_controls_tabs();
			$elementor_object->end_controls_section();

			//Icon
			$elementor_object->start_controls_section(
				'wdt_icons_style_section',
				array (
					'label' => esc_html__( 'Icon', 'wdt-elementor-addon' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);
			$elementor_object->add_control(
				'item_icon_color',
				array(
					'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .wdt-opt-icon i' => 'color: {{VALUE}}',
					),
				)
			);
			
			$elementor_object->add_control(
				'item_icon_width',
				array(
						'label' => esc_html__( 'Width', 'wdt-elementor-addon' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => array('px', '%', 'em', 'rem', 'custom'),
                        'range' => array(
                            'px' => array(
                                'min' => 0,
                                'max' => 1000,
                                'step' => 5,
                            ),
                            '%' => array(
                                'min' => 0,
                                'max' => 100,
                            ),
                        ),
                        'default' => array(
                            'unit' => 'px',
                            'size' => 50,
                        ),
                        'selectors' => array(
                                '{{WRAPPER}} .wdt-opt-icon i' => 'width: {{SIZE}}{{UNIT}};',
						)
				)
			);
			$elementor_object->add_control(
				'item_icon_height',
				array(
					'label' => esc_html__( 'Height', 'wdt-elementor-addon' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => array('px', '%', 'em', 'rem', 'custom'),
                        'range' => array(
                            'px' => array(
                                'min' => 0,
                                'max' => 1000,
                                'step' => 5,
                            ),
                            '%' => array(
                                'min' => 0,
                                'max' => 100,
                            ),
                        ),
                        'default' => array(
                            'unit' => 'px',
                            'size' => 50,
                        ),
                        'selectors' => array(
                                '{{WRAPPER}} .wdt-opt-icon i' => 'height: {{SIZE}}{{UNIT}};',
						),
				)
			);
			$elementor_object->add_control(
				'item_icon_margin',
				array (
					'label' => esc_html__( 'Margin', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => array ( 'px', 'em', '%' ),
					'selectors' => array (
						'{{WRAPPER}} .wdt-opt-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
			$elementor_object->add_control(
				'item_icon_padding',
				array (
					'label' => esc_html__( 'Padding', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'selector' => array (
						'{{WRAPPER}} .wdt-opt-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
			$elementor_object->start_controls_tabs(
				'icon_style_tabs'
			);
			$elementor_object->start_controls_tab(
				'icon_normal_tab',
				array(
					'label' => esc_html__( 'Normal', 'wdt-elementor-addon' ),
				)	
			);
	
			$elementor_object->add_control(
				'icon_tab_color',
				array(
					'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .wdt-opt-icon i' => 'color: {{VALUE}}',
					),
				)
			);
	
			$elementor_object->end_controls_tab();
	
			$elementor_object->start_controls_tab(
				'icon_hover_tab',
				array(
					'label' => esc_html__( 'Hover', 'wdt-elementor-addon' ),
				)	
			);
	
			$elementor_object->add_control(
				'icon_hover_color',
				array(
					'label' => esc_html__( 'Color', 'wdt-elementor-addon' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .wdt-opt-icon i:hover' => 'color: {{VALUE}}',
					),
				)
			);
	
			$elementor_object->end_controls_tab();
			$elementor_object->end_controls_tab();
			$elementor_object->end_controls_section();

		}

    public function render_html($widget_object, $settings){

        if($widget_object->widget_type != 'elementor') {
			return;
		}
		$output  = '';
		if ( $settings['features_content'] ) 
		{
			$output.= '<div class="wdt-elementor-repeater-container">';
			$output.= '<'.esc_attr($settings['title_tag']).' class="wdt-elementor-repeater-container-wrapper">';
			foreach (  $settings['features_content'] as $item )
			 {
				if($item['content_type']=="image")
					$output.= '<span class="elementor-repeater-item-'.esc_attr( $item['_id'] ).'"><img src='.esc_url( $item['content_template']['url'] ) . '></span>';
				else if($item['content_type']=="default")
					$output.= '<span class="wdt-text-tile elementor-repeater-item-'.esc_attr( $item['_id'] ).'">' . $item['list_title'] . '</span>';
				else
				{
					$output.='<span class="wdt-opt-icon  elementor-repeater-item-'.esc_attr( $item['_id'] ).'">';
					$output .= ($item['icon']['library'] == 'svg') ? '<i>' : '';
						ob_start();
						\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
						$output .= ob_get_clean();
					$output .= ($item['icon']['library'] == 'svg') ? '</i>' : '';
					$output.='</span>';
				}
			}
			$output .= '</'.esc_attr($settings['title_tag']).'>';
			$output.= '</div>';
			return $output;
		}
    }

}

if( !function_exists( 'wedesigntech_widget_base_text_with_image' ) ) {
    function wedesigntech_widget_base_text_with_image() {
        return WeDesignTech_Widget_Base_Text_With_Image::instance();
    }
}
