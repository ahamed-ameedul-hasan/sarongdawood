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

$wislist_icon = '';

if( class_exists( '\WCBoost\Wishlist\Helper' ) ) {
	$link  = wc_get_page_permalink( 'wishlist' );
	$count = \WCBoost\Wishlist\Helper::get_wishlist()->count_items();
} elseif ( defined( 'YITH_WCWL' ) ) {
	$link         = get_permalink( yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) ) );
	$count        = intval( YITH_WCWL()->count_products() );

	$wislist_icon = get_option( 'yith_wcwl_add_to_wishlist_icon' );
	$wislist_icon = $wislist_icon == 'fa-heart-o' ? '' : $wislist_icon;
} else {
	return;
}

if ( Helper::get_option( 'header_wishlist_link' ) ) {
	$link = Helper::get_option( 'header_wishlist_link' );
}

?>

<div class="header-wishlist">
	<a class="wishlist-icon" href="<?php echo esc_url( $link ); ?>">
		<?php echo ! empty( $wislist_icon ) ? '<i class="fa ' . esc_attr( $wislist_icon ) . '"></i>' : \Razzi\Icon::get_svg('heart', '', 'shop'); ?>
		<?php if( intval( Helper::get_option( 'header_wishlist_counter' ) ) ) : ?>
			<span class="counter wishlist-counter <?php echo $count == 0 ? 'hidden' : ''; ?>"><?php echo $count; ?></span>
		<?php endif; ?>
	</a>
</div>
