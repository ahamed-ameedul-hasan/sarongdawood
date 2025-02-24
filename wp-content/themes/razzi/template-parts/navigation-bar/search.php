<?php
/**
 * Template file for displaying search
 *
 * @package Razzi
 */
?>

<a href="#" class="rz-navigation-bar_icon search-icon" data-toggle="modal" data-target="search-modal">
	<?php echo \Razzi\Icon::get_svg( 'search', '', 'shop' ); ?>
	<?php echo \Razzi\Helper::get_option( 'mobile_navigation_bar_item_label' ) ? '<label>' .   esc_html__( 'Search', 'razzi' ) . '</label>': ''; ?>
</a>
