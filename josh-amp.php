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
	<?php
});

/**
 * Show featured image
 */
add_action( 'pre_amp_render_post', function () {
	add_filter( 'the_content', function( $content ){
		if ( has_post_thumbnail() ) {
			$image = sprintf( '<p class="jp-amp-featured-image">%s</p>', get_the_post_thumbnail() );
			$content = $image . $content;
		}
		return $content;
	});
});


