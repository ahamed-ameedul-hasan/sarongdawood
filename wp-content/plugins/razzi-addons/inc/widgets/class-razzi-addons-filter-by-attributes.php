<?php
/**
 * Social links widget
 *
 * @package Razzi
 */

namespace Razzi\Addons\Widgets;

use WeDevs\Dokan\Vendor;
/**
 * Class Razzi_Social_Links_Widget
 */
class Filter_By_Attributes extends \WP_Widget {
	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $default;

	/**
	 * List of supported socials
	 *
	 * @var array
	 */
	protected $socials;

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function __construct() {

		parent::__construct(
			'razzi-filter-product',
			esc_html__( 'Razzi - Filter Products by Attribute', 'razzi-addons' ),
			array(
				'classname'                   => 'razzi-widget__filter-products',
				'customize_selective_refresh' => true,
			),
			array( 'width' => 600 )
		);
	}

	  /**
     * Front-end display of widget.
     *
     * @since DOKAN_PRO_SINCE
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     *
     * @see WP_Widget::widget()
     */
    public function widget( $args, $instance ) {
        if ( ! dokan_is_store_listing() && ! dokan_is_store_page() ) {
            return;
        }

        // load frontend script
        wp_enqueue_script( 'dokan-frontend' );

        $taxonomy     = $this->get_instance_taxonomy( $instance );
        $seller_id = empty( $seller_id ) ? get_query_var( 'author' ) : $seller_id;
        $vendor    = dokan()->vendor->get( $seller_id );

        if ( ! $vendor instanceof  \WeDevs\Dokan\Vendor\Vendor ) {
            return;
        }

        $terms = $vendor->get_vendor_used_terms_list( $seller_id, $taxonomy );
        if ( empty( $terms ) ) {
            return;
        }

        $title        = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        $query_type   = isset( $instance['query_type'] ) ? apply_filters( 'widget_query_type', $instance['query_type'] ) : '';

        echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
        }

        $seller_id = empty( $seller_id ) ? get_query_var( 'author' ) : $seller_id;

        $this->store_term_menu_list( $seller_id, $terms, $taxonomy, $query_type );

        echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped

        wp_reset_postdata();
    }

    /**
     * Back-end widget form.
     *
     * @since DOKAN_PRO_SINCE
     *
     * @param array $instance Previously saved values from database.
     *
     * @see WP_Widget::form()
     */
    public function form( $instance ) {
        if ( isset( $instance['title'] ) ) {
            $title = esc_attr( $instance['title'] );
        } else {
            $title = __( 'Filter by', 'razzi-addons' );
        }

        $attribute_array      = [];
        $std_attribute        = '';
        $attribute_taxonomies = wc_get_attribute_taxonomies();

        if ( ! empty( $attribute_taxonomies ) ) {
            foreach ( $attribute_taxonomies as $tax ) {
                if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
                    $attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
                }
            }
            $std_attribute = current( $attribute_array );
        }

        $attribute_value = isset( $instance['attribute'] ) ? $instance['attribute'] : $std_attribute;
        $query_type  = [
            'and' => __( 'AND', 'razzi-addons' ),
            'or'  => __( 'OR', 'razzi-addons' ),
        ];
        $query_value = isset( $instance['query_type'] ) ? $instance['query_type'] : '';

        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'razzi-addons' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'attribute' ) ); ?>"><?php echo __( 'Attribute', 'razzi-addons' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'attribute' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'attribute' ) ); ?>">
                <?php foreach ( $attribute_array as $option_key => $option_value ) : ?>
                    <option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $attribute_value ); ?>><?php echo esc_html( $option_value ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'query_type' ) ); ?>"><?php echo __( 'Query Type', 'razzi-addons' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'query_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'query_type' ) ); ?>">
                <?php foreach ( $query_type as $option_key => $option_value ) : ?>
                    <option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $query_value ); ?>><?php echo esc_html( $option_value ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @since DOKAN_PRO_SINCE
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @see WP_Widget::update()
     *
     * @see WP_Widget::update()
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance               = [];
        $instance['title']      = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
        $instance['attribute']  = ( ! empty( $new_instance['attribute'] ) ) ? wp_strip_all_tags( $new_instance['attribute'] ) : '';
        $instance['query_type'] = ( ! empty( $new_instance['query_type'] ) ) ? wp_strip_all_tags( $new_instance['query_type'] ) : '';

        return $instance;
    }

    /**
     * Get this widget taxonomy.
     *
     * @since DOKAN_PRO_SINCE
     *
     * @param array $instance Array of instance options.
     *
     * @return string
     */
    protected function get_instance_taxonomy( $instance ) {
        if ( isset( $instance['attribute'] ) ) {
            return wc_attribute_taxonomy_name( $instance['attribute'] );
        }

        $attribute_taxonomies = wc_get_attribute_taxonomies();

        if ( ! empty( $attribute_taxonomies ) ) {
            foreach ( $attribute_taxonomies as $tax ) {
                if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
                    return wc_attribute_taxonomy_name( $tax->attribute_name );
                }
            }
        }

        return '';
    }

	function store_term_menu_list( $seller_id, $terms, $taxonomy, $query_type ) {
    ?>
    <div class="store-cat-stack-dokan cat-drop-stack">
        <?php
        $seller_id = empty( $seller_id ) ? get_query_var( 'author' ) : $seller_id;
        $vendor    = dokan()->vendor->get( $seller_id );
        $store_url = dokan_get_store_url( $seller_id );


		echo '<ul class="products-filter--swatches">';
		$_chosen_attributes = dokan_get_chosen_taxonomy_attributes();
		foreach ( $terms as $term ) {
			$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : [];
			$option_is_set  = in_array( $term->slug, $current_values, true );
			$filter_name    = 'filter_' . wc_attribute_taxonomy_slug( $taxonomy );
			// phpcs:ignore
			$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array();

			if ( ! in_array( $term->slug, $current_filter, true ) ) {
				$current_filter[] = $term->slug;
			}

			$link = remove_query_arg( $filter_name, $store_url );
			// Add current filters to URL.
			foreach ( $current_filter as $key => $value ) {
				// Exclude query arg for current term archive term.
				if ( $value === dokan_get_current_term_slug() ) {
					unset( $current_filter[ $key ] );
				}

				// Exclude self so filter can be unset on click.
				if ( $option_is_set && $value === $term->slug ) {
					unset( $current_filter[ $key ] );
				}
			}

			if ( ! empty( $current_filter ) ) {
				asort( $current_filter );
				$link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

				// Add Query type Arg to URL.
				if ( 'or' === $query_type && ! ( 1 === count( $current_filter ) && $option_is_set ) ) {
					$link = add_query_arg( 'query_type_' . wc_attribute_taxonomy_slug( $taxonomy ), 'or', $link );
				}
				$link = str_replace( '%2C', ',', $link );
			}

			$selected = '';
			if ( $option_is_set ) {
				$selected = 'selected';
			}
			$attribute = $this->get_tax_attribute($taxonomy);
			$value = $this->display_auto($term, $attribute->attribute_type, $option_is_set);

			echo '
			<li class="parent-cat-wrap swatch-' . esc_attr($attribute->attribute_type) . ' ' . $selected . '">
				<a href=' . esc_url( $link ) . '>' . $value . '</a>
			</li>';
		}
		echo '</ul>';
        ?>
    </div>
        <?php
    }

	/**
	 * Get atribute swatches data
	 *
	 * @param int $term_id
	 * @param string $type
	 * @return mixed
	 */
	public function get_attribute_swatches( $term_id, $type = 'color' ) {
		if ( class_exists( '\WCBoost\VariationSwatches\Admin\Term_Meta' ) ) {
			$data = \WCBoost\VariationSwatches\Admin\Term_Meta::instance()->get_meta( $term_id, $type );
		} else {
			$data = get_term_meta( $term_id, $type, true );
		}

		return $data;
	}

		/**
	 * Get attribute's properties
	 *
	 * @since 1.0.0
	 *
	 * @param string $attribute
	 *
	 * @return object
	 */
	protected function get_tax_attribute( $attribute_name ) {
		$attribute_slug     = wc_attribute_taxonomy_slug( $attribute_name );
		$taxonomies         = wc_get_attribute_taxonomies();
		$attribute_taxonomy = wp_list_filter( $taxonomies, [ 'attribute_name' => $attribute_slug ] );
		$attribute_taxonomy = ! empty( $attribute_taxonomy ) ? array_shift( $attribute_taxonomy ) : null;

		return $attribute_taxonomy;
	}

		/**
	 * Display attribute filter automatically
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 */
	protected function display_auto( $term, $type, $option_is_set ) {
		if ( ! class_exists( 'WCBoost\VariationSwatches\Swatches' ) ) {
			$type = 'select';
		}

		switch ( $type ) {
			case 'color':
				$color = $this->get_attribute_swatches( $term->term_id, 'color' );

				return sprintf(
					'<span class="products-filter__option swatch-color swatch-%s %s" data-value="%s"  title="%s"><span class="bg-color" style="background-color:%s;"></span>%s%s</span>',
					esc_attr( $term->slug ),
					$option_is_set ? 'selected' : '',
					esc_attr( $term->slug ),
					esc_attr( $term->name ),
					esc_attr( $color ),
					'<span class="name">' . esc_html( $term->name ) . '</span>',
					'<span class="products-filter__count count">' . $term->count . '</span>'
				);

				break;

			case 'image':
				$image = $this->get_attribute_swatches( $term->term_id, 'image' );
				$image = $image ? wp_get_attachment_image_src( $image ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';

				return sprintf(
					'<span class="products-filter__option swatch swatch-%s %s" data-value="%s" title="%s"><img src="%s" alt="%s">%s%s</span>',
					esc_attr( $term->slug ),
					$option_is_set ? 'selected' : '',
					esc_attr( $term->slug ),
					esc_attr( $term->name ),
					esc_url( $image ),
					esc_attr( $term->name ),
					'<span class="name hidden">' . 	esc_html( $term->name ) . '</span>',
					'<span class="products-filter__count count">' . $term->count . '</span>'
				);

				break;

			case 'label':
				$label = $this->get_attribute_swatches( $term->term_id, 'label' );
				$label = $label ? $label : $term->name;

				return sprintf(
					'<span class="products-filter__option swatch swatch-%s %s" data-value="%s" title="%s">%s%s</span>',
					esc_attr( $term->slug ),
					$option_is_set ? 'selected' : '',
					esc_attr( $term->slug ),
					esc_attr( $term->name ),
					'<span class="name">' . 	esc_html( $label ) . '</span>',
					'<span class="products-filter__count count">' . $term->count . '</span>'
				);

				break;

			case 'button':
				$label = $term->name;

				return sprintf(
					'<span class="products-filter__option swatch swatch-%s %s" data-value="%s" title="%s">%s%s</span>',
					esc_attr( $term->slug ),
					$option_is_set ? 'selected' : '',
					esc_attr( $term->slug ),
					esc_attr( $term->name ),
					'<span class="name">' . 	esc_html( $label ) . '</span>',
					'<span class="products-filter__count count">' . $term->count . '</span>'
				);

				break;

			default:
				return sprintf(
					'<span class="products-filter__option swatch swatch-%s %s" data-value="%s" title="%s">%s%s</span>',
					esc_attr( $term->slug ),
					$option_is_set ? 'selected' : '',
					esc_attr( $term->slug ),
					esc_attr( $term->name ),
					'<span class="products-filter__option-name name">' . 	esc_html( $term->name ) . '</span>',
					'<span class="products-filter__count count">' . $term->count . '</span>'
				);

				break;
		}
	}
}
