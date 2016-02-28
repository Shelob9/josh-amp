<?php
/**
 Plugin Name: Josh AMP
 Plugin Description: Extra code for customizing Automattic's AMP plugin on JoshPress.net
 */

/**
 Copyright 2016 Josh Pollock. Licensed under the terms of the GNU GPL v2 or later. See license.txt and please share with your neighbor
 */

/**
 * Custom CSS
 */
add_action( 'amp_post_template_css', function( $amp_template ) {
	?>
	nav.amp-wp-title-bar {background: #000;}
	ul#amp-menu-primary {
		list-style: none;
		display: inline;
	}

	ul#amp-menu-primary li {
		display: inline;
		margin: 0 8px;
	}
	<?php
});

/**
 * Template Modifications
 */
add_action( 'pre_amp_render_post', function () {
	/**
	 * Show featured image
	 */
	add_filter( 'the_content', function( $content ){
		if ( has_post_thumbnail() ) {
			$image = sprintf( '<p class="jp-amp-featured-image">%s</p>', get_the_post_thumbnail() );
			$content = $image . $content;
		}
		return $content;
	}, 3 );

	/**
	 * Add menu
	 */
	add_filter( 'the_content', function( $content ){
		$menu_name = 'primary';
		$menu = wp_get_nav_menu_object( $menu_name );

		if ( ! empty( $menu ) ) {
			$menu_items = wp_get_nav_menu_items( $menu->term_id );

			$menu_list = '<ul id="amp-menu-' . $menu_name . '">Menu: ';

			foreach ( $menu_items as $key => $menu_item ) {
				$menu_list .= sprintf( '<li><a href="%s">%s</a></li>', amp_get_permalink( $menu_item->ID ), esc_html( $menu_item->title ) );
			}

			$menu_list .= '</ul>';

			$content .= $menu_list;
		}

		return $content;
	}, 1000 );
});


//jetpack_the_site_logo()


