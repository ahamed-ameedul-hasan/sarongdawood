<?php
/**
 * Template file for displaying wishlist mobile
 *
 * @package Razzi
 */
use Razzi\Helper;

if ( ! function_exists( 'WC' ) ) {
	return;
}

if( class_exists( '\WCBoost\Wishlist\Helper' ) ) {
	$link  = wc_get_page_permalink( 'wishlist' );
	$count = \WCBoost\Wishlist\Helper::get_wishlist()->count_items();
} elseif ( defined( 'YITH_WCWL' ) ) {
	$link         = get_permalink( yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) ) );
	$count        = intval( YITH_WCWL()->count_products() );
} else {
	return;
}

$modal_class = is_user_logged_in() ? 'link' : 'modal';
?>

<a href="<?php echo esc_url( $link ) ?>" class="rz-navigation-bar_icon wishlist-icon">
	<span>
		<?php echo \Razzi\Icon::get_svg( 'heart', '', 'shop' ); ?>
		<?php if( intval( Helper::get_option( 'mobile_navigation_bar_wishlist_counter' ) ) ) : ?>
			<span class="counter wishlist-counter <?php echo intval( $count ) == 0 ? 'hidden' : ''; ?>"><?php echo intval( $count ); ?></span>
		<?php endif; ?>
	</span>
	<?php echo \Razzi\Helper::get_option( 'mobile_navigation_bar_item_label' ) ? '<label>' .  esc_html__( 'Wishlist', 'razzi' ) . '</label>': ''; ?>
</a>
