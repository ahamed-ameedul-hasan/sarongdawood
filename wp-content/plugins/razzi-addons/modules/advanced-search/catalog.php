<?php
/**
 * Single Product hooks.
 *
 * @package Razzi
 */

namespace Razzi\Addons\Modules\Advanced_Search;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Single Product
 */
class Catalog {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * posts
	 *
	 * @var $instance
	 */
	protected static $posts = null;

	/**
	 * taxonomies
	 *
	 * @var $instance
	 */
	protected static $taxonomies = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'pre_get_posts', array($this, 'product_search_by_sku_hook' ) );
	}

	/**
	 * Add filter to posts clauses to support searching products by sku.
	 *
	 * @param object $query
	 */
	function product_search_by_sku_hook( $query ) {
		if ( ( is_admin() && ! defined( 'DOING_AJAX' ) ) || ! $query->is_search() || ! $query->is_main_query() || ! in_array( 'product', (array) $query->get( 'post_type' ) ) ) {
			return;
		}

		add_filter( 'posts_clauses', array($this,'product_search_by_sku_query_clauses') );
	}


	/**
	 * Modify the product search query clauses to support searching by sku.
	 *
	 * @todo Support searching in product_variation
	 * @param array $clauses
	 * @return array
	 */
	function product_search_by_sku_query_clauses( $clauses ) {
		global $wpdb;

		// Double check because we can't remove filter.
		if (
			! get_query_var( 's' )
			|| ! in_array( 'product', (array) get_query_var( 'post_type' ) )
		) {
			return $clauses;
		}

		$join    = $clauses['join'];
		$where   = $clauses['where'];
		$groupby = $clauses['groupby'];

		// Use the wc_product_meta_lookup, for a better performance.
		if ( $wpdb->wc_product_meta_lookup ) {
			if( ! str_contains( $join, "LEFT JOIN {$wpdb->wc_product_meta_lookup} wc_product_meta_lookup" ) ) {
				$join .= " LEFT JOIN {$wpdb->wc_product_meta_lookup} wc_product_meta_lookup ON $wpdb->posts.ID = wc_product_meta_lookup.product_id ";
			}

			$where = preg_replace(
				"/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
				"({$wpdb->posts}.post_title LIKE $1) OR (wc_product_meta_lookup.sku LIKE $1)", $where );
		} else { // Old WC. Use postmeta table.
			$join .= " LEFT JOIN {$wpdb->postmeta} ON (" . $wpdb->posts . ".ID = {$wpdb->postmeta}.post_id AND {$wpdb->postmeta}.meta_key='_sku')";

			$where = preg_replace(
				"/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
				"({$wpdb->posts}.post_title LIKE $1) OR ({$wpdb->postmeta}.meta_value LIKE $1)", $where );
		}

		// GROUP BY: product id; to avoid duplication.
		$id_group = "{$wpdb->posts}.ID";

		if ( ! strlen( trim( $groupby ) ) ) {
			$groupby = $id_group;
		} elseif ( ! preg_match( "/$id_group/", $groupby ) ) {
			$groupby = $groupby . ', ' . $id_group;
		}



		$clauses['join']    = $join;
		$clauses['where']   = $where;
		$clauses['groupby'] = $groupby;

		return $clauses;
	}
}