<# if ( data.depth == 0 ) { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Mega Menu Content', 'razzi-addons' ) ?>"
   data-panel="mega"><?php esc_html_e( 'Mega Menu', 'razzi-addons' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Background', 'razzi-addons' ) ?>"
   data-panel="background"><?php esc_html_e( 'Background', 'razzi-addons' ) ?></a>
<div class="separator"></div>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Badges', 'razzi-addons' ) ?>"
   data-panel="badges"><?php esc_html_e( 'Badges', 'razzi-addons' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'razzi-addons' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'razzi-addons' ) ?></a>
<# } else if ( data.depth == 1 ) { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'razzi-addons' ) ?>"
   data-panel="content"><?php esc_html_e( 'Menu Content', 'razzi-addons' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu General', 'razzi-addons' ) ?>"
   data-panel="general"><?php esc_html_e( 'General', 'razzi-addons' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Badges', 'razzi-addons' ) ?>"
   data-panel="badges"><?php esc_html_e( 'Badges', 'razzi-addons' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'razzi-addons' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'razzi-addons' ) ?></a>
<# } else { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu General', 'razzi-addons' ) ?>"
   data-panel="general_2"><?php esc_html_e( 'General', 'razzi-addons' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Badges', 'razzi-addons' ) ?>"
   data-panel="badges"><?php esc_html_e( 'Badges', 'razzi-addons' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'razzi-addons' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'razzi-addons' ) ?></a>
<# } #>
