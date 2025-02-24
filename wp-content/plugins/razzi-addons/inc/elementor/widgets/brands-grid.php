<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Brands widget
 */
class Brands_Grid extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-brands-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Brands Grid', 'razzi-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
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

	/**
	 * Section Content
	 */
	protected function section_content() {

		// Brands Settings
		$this->start_controls_section(
			'section_blogs',
			[ 'label' => esc_html__( 'Content', 'razzi-addons' ) ]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'   => esc_html__( 'Columns', 'razzi-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 6,
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => 6,
				'tablet_default' => 4,
				'mobile_default' => 2,
				'separator' => 'before',
				'selectors'  => [
					'{{WRAPPER}} .razzi-brands-grid .brand-item' => '--rz-brands-grid-columns: {{SIZE}};',
				],
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

		$this->add_control(
			'limit',
			[
				'label'     => esc_html__( 'Total', 'razzi-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 8,
				'min'       => 2,
				'max'       => 1000,
				'step'      => 1,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'      => esc_html__( 'Order By', 'razzi-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'date'       => esc_html__( 'Date', 'razzi-addons' ),
					'count'      => esc_html__( 'Count', 'razzi-addons' ),
					'name'       => esc_html__( 'Name', 'razzi-addons' ),
					'id'         => esc_html__( 'Ids', 'razzi-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'razzi-addons' ),
				],
				'default'    => 'date',
			]
		);

		$this->add_control(
			'order',
			[
				'label'      => esc_html__( 'Order', 'razzi-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''     => esc_html__( 'Default', 'razzi-addons' ),
					'ASC'  => esc_html__( 'Ascending', 'razzi-addons' ),
					'DESC' => esc_html__( 'Descending', 'razzi-addons' ),
				],
				'default'    => '',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'orderby',
							'operator' => '!=',
							'value' => 'menu_order',
						],
					],
				],

			]
		);


		$this->end_controls_section();

		$this->section_pagination_settings_controls();
	}

	protected function section_pagination_settings_controls() {
		$this->start_controls_section(
			'section_pagination_settings',
			[ 'label' => esc_html__( 'Pagination', 'razzi-addons' ) ]
		);

		$this->add_control(
			'pagination',
			[
				'label'   => esc_html__( 'Pagination', 'razzi-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'     => esc_html__( 'None', 'razzi-addons' ),
					'numberic' => esc_html__( 'Numberic', 'razzi-addons' ),
				],
				'default'            => 'none',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {

		$this->start_controls_section(
			'section_content_styles',
			[
				'label' => __( 'Brands', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'items_spacing',
			[
				'label'      => __( 'Spacing', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-brands-grid .brand-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .razzi-brands-grid.razzi-brands-grid__border-none .list-brands' => 'margin-left: -{{LEFT}}{{UNIT}}; margin-right: -{{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_custom',
			[
				'label' => __( 'Brand Item', 'razzi-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'item_min_height',
			[
				'label'     => esc_html__( 'Min Height', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-brands-grid .brand-item a' => 'min-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'items_padding',
			[
				'label'      => __( 'Padding', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-brands-grid .brand-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'items_background',
			[
				'label'     => __( 'Background Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-brands-grid .brand-item a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_style',
			[
				'label'        => __( 'Border', 'razzi-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'razzi-addons' ),
				'label_on'     => __( 'Custom', 'razzi-addons' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'content_border_style',
			[
				'label'     => esc_html__( 'Border Style', 'razzi-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'razzi-addons' ),
					'dashed' => esc_html__( 'Dashed', 'razzi-addons' ),
					'solid'  => esc_html__( 'Solid', 'razzi-addons' ),
					'none'   => esc_html__( 'None', 'razzi-addons' ),
				],
				'default'   => 'solid',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .razzi-brands-grid .brand-item' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .razzi-brands-grid .list-brands' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_border_width',
			[
				'label'     => __( 'Border Width', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 7,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .razzi-brands-grid .brand-item' => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;',
					'{{WRAPPER}} .razzi-brands-grid .list-brands' => 'border-width: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_border_color',
			[
				'label'     => __( 'Border Color', 'razzi-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .razzi-brands-grid .brand-item' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .razzi-brands-grid .list-brands' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'show_box_shadow',
			[
				'label'        => esc_html__( 'Show Box Shadow', 'razzi-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'razzi-addons' ),
				'label_on'     => __( 'On', 'razzi-addons' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'brand_box_shadow',
				'label' => __( 'Box Shadow', 'razzi-addons' ),
				'selector' => '{{WRAPPER}} .razzi-brands-grid-box-shadow-yes .brand-item a',
				'conditions' => [
					'terms' => [
						[
							'name' => 'show_box_shadow',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'items_border_radius',
			[
				'label'      => __( 'Border Radius', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-brands-grid .brand-item a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->section_pagination_style();
	}

	protected function section_pagination_style() {
		$this->start_controls_section(
			'section_pagination_style',
			[
				'label' => __( 'Pagination', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'pagination_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-brands-grid .woocommerce-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
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

		$classes = [
			'razzi-brands-grid',
			! empty( $settings['content_border_style'] ) && $settings['content_border_style'] == 'none' ? 'razzi-brands-grid__border-none' : '',
			$settings['show_box_shadow'] == 'yes' ? 'razzi-brands-grid-box-shadow-yes': ''
		];
		$offset = '';
		// Paginated
		if( $settings['pagination'] !== 'none' ) {
			$page         = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$offset       = ( $page > 0 ) ?  $settings['limit'] * ( $page - 1 ) : 1;
			$totalterms   = wp_count_terms( 'product_brand', array( 'hide_empty' => TRUE ) );
			$max_num_pages   = ceil( $totalterms / $settings['limit'] );
		}

		$atts = [
			'taxonomy'   	=> 'product_brand',
			'hide_empty' 	=> 1,
			'number'     	=> $settings['limit'],
			'orderby'     	=> $settings['orderby'],
			'offset'        => $offset,
		];

		$atts['menu_order'] = false;

		if ( $settings['orderby'] == 'menu_order' ) {
			$atts['menu_order'] = 'asc';
		} elseif ($settings['order'] != ''){
			$atts['order'] = $settings['order'];
		}

		$columns = isset( $settings['columns'] ) && ! empty( $settings['columns'] ) ? $settings['columns'] : '6';
		$columns_tablet = isset( $settings['columns_tablet'] ) && ! empty( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : $columns;
		$columns_mobile = isset( $settings['columns_mobile'] ) && ! empty( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : $columns;

		$add_col_class = $columns == '5' ? ' col-flex-md-1-5' : '';
		$add_col_class .= $columns_tablet == '5' ? ' col-flex-sm-1-5' : '';
		$add_col_class .= $columns_mobile == '5' ? ' col-flex-xs-1-5' : '';

		$terms   = get_terms( $atts );

		$output  = array();

		if ( is_wp_error( $terms ) ) {
			return;
		}

		if ( empty( $terms ) || ! is_array( $terms ) ) {
			return;
		}

		foreach ( $terms as $term ) {

			$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
			if( empty($thumbnail_id) ) {
				$thumbnail_id = absint( get_term_meta( $term->term_id, 'brand_thumbnail_id', true ) );
			}

			if ( $thumbnail_id ) {

				$image_url = wp_get_attachment_image_src( $thumbnail_id ) ? wp_get_attachment_image_src( $thumbnail_id )[0] : '';

				$settings['image'] = array(
					'url' => $image_url,
					'id'  => $thumbnail_id
				);

				$html = Group_Control_Image_Size::get_attachment_image_html( $settings );

			} else {
				$html = $term->name;
			}

			$output[] = sprintf(
				'<div class="brand-item%s">' .
				'<a href="%s">%s</a>' .
				'</div>',
				esc_attr($add_col_class),
				esc_url(get_term_link( $term->term_id, 'product_brand' )),
			 	$html
			);
		}


		$this->add_render_attribute('wrapper', 'class', $classes );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="list-brands" >
				<?php echo implode('', $output ) ?>
			</div>
			<?php
				if( $settings['pagination'] !== 'none' ) {
					echo $this->pagination_numeric( $max_num_pages );
				}
			?>
		</div>
		<?php

	}

	/**
	 * Get pagination numeric
	 *
	 * @return string.
	 */
	protected function pagination_numeric( $max_num_pages ) {
		?>
        <nav class="woocommerce-pagination">
			<?php
			$big  = 999999999;
			$args = array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'total'     => $max_num_pages,
				'end_size'  => 3,
				'mid_size'  => 3,
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'prev_text' => \Razzi\Icon::get_svg( 'caret-right' ),
				'next_text' => \Razzi\Icon::get_svg( 'caret-right' ),
				'type'      => 'list',
			);

			$links = paginate_links( $args );

			if ( $links ) {
				echo paginate_links( $args );
			}

			?>
        </nav>
		<?php
	}
}
