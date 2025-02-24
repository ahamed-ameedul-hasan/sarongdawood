<?php
/**
 * Template file for displaying menu mobile
 *
 * @package Razzi
 */
?>

<a href="#" class="rz-navigation-bar_icon menu-icon" data-toggle="modal" data-target="mobile-category-menu-modal">
	<?php echo \Razzi\Icon::get_svg( 'hamburger' ); ?>
	<?php echo \Razzi\Helper::get_option( 'mobile_navigation_bar_item_label' ) ? '<label>' .  esc_html__( 'Menu', 'razzi' ). '</label>': ''; ?>
</a>
