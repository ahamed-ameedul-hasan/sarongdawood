<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use razziAddons\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product Brands
 */
class Product_Brands extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'razzi-product-brands';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Product Brands', 'razzi-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
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
		$this->content_settings_controls();
	}

	protected function content_settings_controls() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'razzi-addons' ) ]
		);

		$this->add_control(
			'brands_source',
			[
				'label'       => esc_html__( 'Source', 'razzi-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'default' => esc_html__( 'Default', 'razzi-addons' ),
					'custom'  => esc_html__( 'Custom', 'razzi-addons' ),
				],
				'default'     => 'default',
				'label_block' => false,
			]
		);
		$this->add_control(
			'brands_display',
			[
				'label'       => esc_html__( 'Brands Display', 'razzi-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'all'    => esc_html__( 'All', 'razzi-addons' ),
					'parent' => esc_html__( 'Parent Brands Only', 'razzi-addons' ),
				],
				'default'     => 'parent',
				'label_block' => true,
				'condition'   => [
					'brands_source' => 'default',
				],
			]
		);
		$this->add_control(
			'brands_number',
			[
				'label'       => esc_html__( 'Brands to show', 'razzi-addons' ),
				'description' => esc_html__( 'Set 0 to show all brands', 'razzi-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 6,
				'condition'   => [
					'brands_source' => 'default',
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'        => esc_html__( 'Columns', 'razzi-addons' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'1' => esc_html__( '1 Column', 'razzi-addons' ),
					'2' => esc_html__( '2 Columns', 'razzi-addons' ),
					'3' => esc_html__( '3 Columns', 'razzi-addons' ),
					'4' => esc_html__( '4 Columns', 'razzi-addons' ),
					'5' => esc_html__( '5 Columns', 'razzi-addons' ),
				],
				'default'      => '3',
				'toggle'       => false,
				'prefix_class' => 'columns-%s',
			]
		);

		$this->add_control(
			'brands_orderby',
			[
				'label'       => esc_html__( 'Order by', 'razzi-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'name'  => esc_html__( 'Name', 'razzi-addons' ),
					'id'    => esc_html__( 'ID', 'razzi-addons' ),
					'count' => esc_html__( 'Count', 'razzi-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'razzi-addons' ),
				],
				'default'     => 'count',
				'label_block' => false,
				'condition'   => [
					'brands_source' => 'default',
				],
			]
		);

		$this->add_control(
			'brands_order',
			[
				'label'       => esc_html__( 'Order', 'razzi-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'ASC'  => esc_html__( 'ASC', 'razzi-addons' ),
					'DESC' => esc_html__( 'DESC', 'razzi-addons' ),
				],
				'default'     => 'DESC',
				'label_block' => false,
				'condition'   => [
					'brands_source' => 'default',
				],
			]
		);

		$this->add_control(
			'brands_selected',
			[
				'label'       => esc_html__( 'Brands', 'razzi-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'razzi-addons' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_brand',
				'sortable'    => true,
				'condition'   => [
					'brands_source' => 'custom',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'full',
				'separator' => 'before'
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_content_style();
	}

	protected function section_content_style() {
		// Heading Style
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'razzi-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'products_brands_padding',
			[
				'label'      => esc_html__( 'Padding', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-product-brands__item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'products_brands_box_shadow',
				'label' => __( 'Box Shadow', 'razzi-addons' ),
				'selector' => 	'{{WRAPPER}} .razzi-product-brands__item-inner',
			]
		);


		$this->add_responsive_control(
			'products_brands_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'razzi-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .razzi-product-brands__item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'brand_name_spacing',
			[
				'label'     => __( 'Brand Name Spacing', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 350,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-product-brands__name' => 'margin-top: {{SIZE}}{{UNIT}};',
				],

			]
		);


		$this->add_responsive_control(
			'product_list_spacing',
			[
				'label'     => __( 'Products List Spacing', 'razzi-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 350,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .razzi-product-brands__product-list' => 'margin-top: {{SIZE}}{{UNIT}};',
				],

			]
		);


		$this -> end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute(
			'wrapper', 'class', [
				'razzi-product-brands',
				'razzi-swiper-carousel-elementor',
			]
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="razzi-product-brands__box row-flex">
				<?php $this->get_brands_content( $settings ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Get Brands
	 */
	protected function get_brands_content( $settings ) {
		$source = $settings['brands_source'];

		$term_args = [
			'taxonomy' => 'product_brand',
		];

		if ( $source == 'default' ) {
			$display = $settings['brands_display'];
			$parent  = '';
			if ( $display == 'parent' ) {
				$parent = 0;
			}

			$term_args['orderby'] = $settings['brands_orderby'];
			$term_args['order']   = $settings['brands_order'];
			$term_args['number']  = $settings['brands_number'];
			$term_args['parent']  = $parent;

		} else {
			$brands                 = explode( ',', $settings['brands_selected'] );
			$term_args['slug']    = $brands;
			$term_args['orderby'] = 'slug__in';
		}

		$terms = get_terms( $term_args );

		$output  = [];
		$i      = 0;

		if ( ! is_wp_error( $terms ) && $terms ) {

			foreach ( $terms as $term ) {

				$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
				if( empty($thumbnail_id) ) {
					$thumbnail_id = absint( get_term_meta( $term->term_id, 'brand_thumbnail_id', true ) );
				}

				$settings['image']['url'] = wp_get_attachment_image_src( $thumbnail_id );
				$settings['image']['id']  = $thumbnail_id;

				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

				$thumbnail_html = $thumbnail_id ? '<div class="brand-header--image">' . $image . '</div>' : '';

				$count = '<div class="brand-header--count">';
				$count .= sprintf( _n( '%s product', '%s products', $term->count, 'razzi-addons' ), number_format_i18n( $term->count ) );
				$count .= '</div>';

				$args = array(
					'post_type'             => 'product',
					'post_status'           => 'publish',
					'posts_per_page'        => '4',
					'tax_query'             => array(
						array(
							'taxonomy'      => 'product_brand',
							'field' 		=> 'term_id',
							'terms'         => $term->term_id,
							'operator'      => 'IN'
						)
					)
				);

				$products = get_posts($args);

				$product_html = '';

				if ( $products ) {
					$product_item = [];

					foreach ( $products as $product ) {
						$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'thumbnail' );
						$_product = wc_get_product( $product->ID );

						$product_item[] = sprintf(
							'<li class="product-item swiper-slide">
								<div class="product-inner">
									<div class="product-item__image"><a href="%s"><img src="%s" alt="%s"/></a></div>
									<div class="product-item__price">%s</div>
								</div>
							</li>',
							esc_url( get_permalink( $product->ID ) ),
							! empty($image_url) ? esc_url( $image_url['0'] ) : '',
							esc_html( $product->post_title ),
							$_product->get_price_html()
						);
					}

					$product_html = '<div class="razzi-product-brands__product-list">';
					$product_html .= '<div class="razzi-product-brands__product-container swiper-container">';
					$product_html .= '<ul class="razzi-product-brands__product-wrapper swiper-wrapper">' . implode( '', $product_item ) . '</ul>';
					$product_html .= '</div>';
					$product_html .= \Razzi\Addons\Helper::get_svg('chevron-left', 'rz-swiper-button-prev rz-swiper-button');
					$product_html .= \Razzi\Addons\Helper::get_svg('chevron-right','rz-swiper-button-next rz-swiper-button');
					$product_html .= '</div>';
				}

				$output[] = sprintf(
					'<div class="razzi-product-brands__item">
						<div class="razzi-product-brands__item-inner">
							<div class="razzi-product-brands__header">%s%s</div>
							<div class="razzi-product-brands__name"><a href="%s">%s%s</a></div>
							%s
						</div>
					</div>',
					$thumbnail_html,
					$count,
					esc_url( get_category_link( $term->term_id ) ),
					esc_html( $term->name ),
					\Razzi\Addons\Helper::get_svg( 'arrow-right' ),
					$product_html
				);

			}

		}

		echo implode( '', $output );
	}

	/**
	 * Render link control output
	 *
	 * @param       $link_key
	 * @param       $url
	 * @param       $content
	 * @param array $attr
	 *
	 * @return string
	 */
	protected function get_link_control( $link_key, $url, $content, $attr = [] ) {
		$attr_default = [
			'href' => $url['url'] ? $url['url'] : '#',
		];

		if ( $url['is_external'] ) {
			$attr_default['target'] = '_blank';
		}

		if ( $url['nofollow'] ) {
			$attr_default['rel'] = 'nofollow';
		}

		$attr = wp_parse_args( $attr, $attr_default );

		$this->add_render_attribute( $link_key, $attr );

		return sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( $link_key ), $content );
	}
}