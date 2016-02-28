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
	ul.jp-amp-list {
		list-style: none;
		display: inline;
	}

	ul.jp-amp-list li {
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

			$menu_list = sprintf( '<br /><ul id="%s" class="jp-amp-list">Menu: ', esc_attr( 'amp-jp-menu-' . $menu_name ) );

			foreach ( $menu_items as $key => $menu_item ) {
				$menu_list .= sprintf( '<li><a href="%s">%s</a></li>', amp_get_permalink( $menu_item->object_id ), esc_html( $menu_item->title ) );
			}

			$menu_list .= '</ul>';

			$content .= $menu_list;
		}

		return $content;
	}, 1000 );

	/**
	 * Add social sharing
	 */
	add_filter( 'the_content', function( $content ){
		$post = get_post();
		if( is_object( $post ) ){
			$twitter = add_query_arg( array(
				'url' => urlencode( get_permalink( $post->ID ) ),
				'status' => urlencode( $post->post_title )
			),'https://twitter.com/share' );

			$facebook = add_query_arg( array(
					'u' => urlencode( get_permalink( $post->ID ) )
				), 'https://www.facebook.com/sharer/sharer.php'
			);
		}

		$share = sprintf( '<hr /><ul id="amp-jp-share" class="jp-amp-list">Share: <li id="twitter-share"><a href="%s" title="Share on Twitter">Twitter</a></li><li id="facebook-share"><a href="%s" title="Share on Facebook">Facebook</a></ul>', esc_url_raw( $twitter ), esc_url_raw( $facebook ) );
		$content  .= $share;

		return $content;
	}, 1000 );
});
