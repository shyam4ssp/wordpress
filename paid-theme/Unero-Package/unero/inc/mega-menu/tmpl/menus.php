<% if ( depth == 0 ) { %>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Mega Menu Content', 'unero' ) ?>" data-panel="mega"><?php esc_html_e( 'Mega Menu', 'unero' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Background', 'unero' ) ?>" data-panel="background"><?php esc_html_e( 'Background', 'unero' ) ?></a>
<div class="separator"></div>
<% } else if ( depth == 1 ) { %>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'unero' ) ?>" data-panel="content"><?php esc_html_e( 'Menu Content', 'unero' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu General', 'unero' ) ?>" data-panel="general"><?php esc_html_e( 'General', 'unero' ) ?></a>
<% } else { %>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu General', 'unero' ) ?>" data-panel="general"><?php esc_html_e( 'General', 'unero' ) ?></a>
<% } %>
