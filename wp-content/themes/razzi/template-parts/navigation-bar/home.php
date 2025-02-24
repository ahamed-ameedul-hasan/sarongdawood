<?php
/**
 * Template file for displaying Home mobile
 *
 * @package Razzi
 */
?>

<a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="rz-navigation-bar_icon home-icon">
	<?php echo \Razzi\Icon::get_svg( 'home', '', 'mobile' ); ?>
	<?php echo \Razzi\Helper::get_option( 'mobile_navigation_bar_item_label' ) ? '<label>' .  esc_html__( 'Home', 'razzi' ) . '</label>': ''; ?>
</a>
