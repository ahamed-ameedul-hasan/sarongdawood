<?php
/**
 * Template part for displaying the search icon
 *
 * @package Razzi
 */

use Razzi\Helper;

if ( ! function_exists( 'WC' ) ) {
	return;
}

$link  = wc_get_page_permalink( 'compare' );
$count = \WCBoost\ProductsCompare\Plugin::instance()->list->count_items();

if ( Helper::get_option( 'header_compare_link' ) ) {
	$link = Helper::get_option( 'header_compare_link' );
}

?>

<a class="rz-navigation-bar_icon compare-icon" href="<?php echo esc_url( $link ); ?>">
	<span>
		<?php echo \Razzi\Icon::get_svg('compare', '', 'shop'); ?>
		<?php if( intval( Helper::get_option( 'mobile_navigation_bar_compare_counter' ) ) ) : ?>
			<span class="counter compare-counter <?php echo $count == 0 ? 'hidden' : ''; ?>"><?php echo $count; ?></span>
		<?php endif; ?>
	</span>
	<?php echo \Razzi\Helper::get_option( 'mobile_navigation_bar_item_label' ) ? '<label>' .  esc_html__( 'Compare', 'razzi' ) . '</label>': ''; ?>
</a>
