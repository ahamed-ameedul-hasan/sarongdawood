<?php
/**
 * Template file for displaying cart mobile
 *
 * @package Razzi
 */
?>

<a href="#" class="rz-navigation-bar_icon cart-icon" data-toggle="modal" data-target="cart-modal">
	<span>
		<?php echo \Razzi\WooCommerce\Helper::get_cart_icon();?>
		<span class="counter cart-counter"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
	</span>
	<?php echo \Razzi\Helper::get_option( 'mobile_navigation_bar_item_label' ) ? '<label>' .  esc_html__( 'Cart', 'razzi' ) . '</label>' : ''; ?>
</a>
